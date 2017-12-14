<?php

namespace App\Http\Controllers;

use App\Authorize;
use App\Company;
use App\Job;
use App\InventoryItem;
use App\ItemStone;
use App\Invoice;
use App\InvoiceItem;
use App\User;
use Illuminate\Http\Request;
use Mail;
use App\Mail\InvoicePending;
use App\Mail\InvoiceUserOrder;
use App\Mail\InvoiceBackendOrder;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Invoice $invoice)
    {
        $columns = $invoice->prepareTableColumns();
        $rows = $invoice->prepareTableRows();
        $invoiceDetails = $invoice->details(true);
        return view('invoices.index', compact(['columns','rows','invoiceDetails']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InventoryItem $ii, Job $job)
    {
        $states = $job->prepareStates();
        $countries = $job->prepareCountries();
        $inventoryItems = $ii->prepareForShowInventory($ii->orderBy('name','asc')->get());
        return view('invoices.create',compact(['inventoryItems','states','countries']));
    }
    /**
    * creates backend shopping cart session used in create and edit invoice
    **/
    public function makeSession(Request $request)
    {
        session()->put('cartBackend',[
            'selectedOptions'=> $request->selected_options,
            'firstName'=>$request->first_name,
            'lastName'=>$request->last_name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'street'=>$request->street,
            'suite'=>$request->suite,
            'city'=>$request->city,
            'state'=>$request->state,
            'country'=>$request->country,
            'zipcode'=>$request->zipcode,
            'billingStreet'=>$request->billing_street,
            'billingSuite'=>$request->billing_suite,
            'billingCity'=>$request->billing_city,
            'billingState'=>$request->billing_state,
            'billingZipcode'=>$request->billing_zipcode,
            'cardNumber'=>$request->card_number,
            'expMonth'=>$request->exp_month,
            'expYear'=>$request->exp_year,
            'cvv'=>$request->cvv,
            'itemName'=>$request->item_name,
            'searchInventoryCount'=>$request->search_inventory_count,
            'selectedItems'=>$request->selected_items,
            'items'=>$request->items,
            'current'=>$request->current,
            'sas'=>$request->sas,
            'totals'=>$request->totals,
            'shipping'=>$request->shipping,
            'shippingTotal'=>$request->shipping_total

        ]);
        return response()->json([
            'status' => true
        ]);
    }

    /**
    * Authorize a payment to authorize.net new payment 
    **/
    public function authorizePayment(Request $request, Authorize $authorize, Job $job)
    {
        // Prepare all the variables required for saving
        $cart = session()->get('cartBackend');
        $totals = $cart['totals'];
        $due = $totals['_total'];
        $shipping = $cart['shipping'];
        $customer = [
            'id'=> NULL,
            'first_name'=>trim($cart['firstName']),
            'last_name'=>trim($cart['lastName']),
            'email'=>trim($cart['email']),
            'phone'=>trim($cart['phone']),
            'street'=>trim($cart['street']),
            'suite'=>trim($cart['suite']),
            'city'=>trim($cart['city']),
            'state'=>trim($cart['state']),
            'zipcode'=>trim($cart['zipcode']),
            'country'=>trim($cart['country']),
            'billing_street'=>trim($cart['billingStreet']),
            'billing_suite'=>trim($cart['billingSuite']),
            'billing_city'=>trim($cart['billingCity']),
            'billing_state'=>trim($cart['billingState']),
            'billing_zipcode'=>trim($cart['billingZipcode']),
            'comment'=>NULL,
            'shipping'=>$shipping
        ]; 
        // Run this if we are running payments, basically if the email variable is false

        $card = [
            'card_number'=>$job->stripAllButNumbers($cart['cardNumber']),
            'exp_month'=>$job->stripAllButNumbers($cart['expMonth']),
            'exp_year'=>$job->stripAllButNumbers($cart['expYear']),
            'cvv'=>$job->stripAllButNumbers($cart['cvv'])
        ];

        // Attempt to make the payment for the item
        $result = $authorize->chargeCreditCard($due, $card, $customer);
        
        if  ($result['status']) { // Payment has been processed, proceed to save invoice
            return response()->json([
                'status' => true,
                'result'=>$result
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message'=>$result['error_message']
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, InvoiceItem $invoiceItem, InventoryItem $inventoryItem, ItemStone $itemStone, Job $job, Invoice $invoice)
    {
        $result = $request->result;
        $cart = session()->get('cartBackend');
        $email = $itemStone->checkEmailAll($cart['selectedOptions']);
        $customer = [
            'id'=> NULL,
            'first_name'=>trim($cart['firstName']),
            'last_name'=>trim($cart['lastName']),
            'email'=>trim($cart['email']),
            'phone'=>$job->stripAllButNumbers($cart['phone']),
            'street'=>trim($cart['street']),
            'suite'=>trim($cart['suite']),
            'city'=>trim($cart['city']),
            'state'=>trim($cart['state']),
            'zipcode'=>trim($cart['zipcode']),
            'country'=>trim($cart['country']),
            'billing_street'=>trim($cart['billingStreet']),
            'billing_suite'=>trim($cart['billingSuite']),
            'billing_city'=>trim($cart['billingCity']),
            'billing_state'=>trim($cart['billingState']),
            'billing_zipcode'=>trim($cart['billingZipcode']),
            'comment'=>NULL,
            'shipping'=>$cart['shipping'],
            'shipping_total'=>$cart['shippingTotal']
        ]; 
        $totals = $cart['totals'];
        $card = [
            'card_number'=>$job->stripAllButNumbers($cart['cardNumber']),
            'exp_month'=>$job->stripAllButNumbers($cart['expMonth']),
            'exp_year'=>$job->stripAllButNumbers($cart['expYear']),
            'cvv'=>$job->stripAllButNumbers($cart['cvv'])
        ];
        $new_invoice = $invoice->newInvoice($totals, $customer, $result, $card);
        if($new_invoice) {
            $inventoryItem = new InventoryItem();
            $count_cart = count($cart['selectedOptions']);
            if (count($cart['selectedOptions']) > 0) {
                foreach ($cart['selectedOptions'] as $item) {
                    $ii = $item['inventoryItem'];
                    $invItemObject = $inventoryItem->find($ii['id']);
                    $quantity = $item['quantity'];
                    $item_size_id = (!$email) ? ($ii['sizes']) ? $item['stone_size_id'] : NULL : NULL;
                    $item_metal_id = ($ii['metals']) ? $item['metal_id'] : NULL;
                    $item_stone_id = ($ii['stones']) ? $item['stone_id'] : NULL;
                    $item_finger_id = ($ii['fingers']) ? $item['finger_id'] : NULL;
                    $subtotal = $item['subtotal'];

                    $invoice_item = new InvoiceItem();
                    $invoice_item->invoice_id = $new_invoice->id;
                    $invoice_item->inventory_item_id = $invItemObject->id;
                    $invoice_item->quantity = $quantity;
                    $invoice_item->subtotal = ($subtotal) ? $subtotal : 0;
                    $invoice_item->item_metal_id = $item_metal_id;
                    $invoice_item->item_stone_id = $item_stone_id;
                    $invoice_item->finger_id = $item_finger_id;
                    $invoice_item->item_size_id = $item_size_id;
                    if($invoice_item->save()) {
                        $count_cart--;
                    }

                    
                }
            }

            if ($count_cart == 0) {
                return response()->json([
                    'status' => true,
                    'new_invoice'=>$new_invoice
                ]);
            }
        }

        return response()->json([
            'status' => false
        ]);
        
    }
    /**
    * Resend email after editing invoice , invoice item
    **/
    public function pushEmail(Request $request, Company $company, ItemStone $itemStone, Invoice $invoice)
    {
        $cart = session()->get('cartBackend');
        $email_address = $request->email_address;
        $email = $itemStone->checkEmailAll($cart['selectedOptions']);
        $inv = $request->new_invoice;
        $new_invoice = $invoice->find($inv['id']);
        $company_info = $company->find(1);
        // Send Email
        try {
            // check if this is a lab certified diamond or a lab created diamond
            if ($email) {
                Mail::to($email_address)->send(new InvoiceBackendOrder($new_invoice, $company_info, $email));
            } else {
                Mail::to($email_address)->send(new InvoiceUserOrder($new_invoice, $company_info, $email));
            }
            
            // All Done
            $status = true;
            $message = 'Thank you for your business! We have sent an email of your invoice to you. Please check your email for further instructions!';
        } catch (\Exception $e) {
            $status = false;
            $message = "The invoice has been paid and properly saved. However, there was an error saving items from your cart. try sending the email again.";
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        
    }
    /**
    * another forget session script
    **/
    public function forgetSession(Request $request)
    {
        session()->forget('cart');
        session()->forget('cartBackend');
        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice, InventoryItem $ii, Job $job)
    {

        $invoices = $invoice->makeSessionRow($invoice);

        $states = $job->prepareStates();
        $countries = $job->prepareCountries();
        $inventoryItems = $ii->prepareForShowInventory($ii->orderBy('name','asc')->get());
        return view('invoices.edit',compact(['invoice','invoices','inventoryItems','states','countries']));
    }

    /**
    * Backend function which allows us to refund if the user has a previous transaction id 
    **/
    public function refund(Request $request, Invoice $invoice, Authorize $authorize)
    {
        $transaction_id = $invoice->transaction_id;
        if (isset($transaction_id)) {
            $get_transaction_details = $authorize->getTransactionDetails($transaction_id);
            if (($get_transaction_details != null) && ($get_transaction_details->getMessages()->getResultCode() == "Ok")) {
                // start the void process
                switch ($get_transaction_details->getTransaction()->getTransactionStatus()) {
                    case 'settledSuccessfully': // Must refund
                        $refund = $authorize->refundTranscaction($invoice->total,$invoice->last_four,$invoice->exp_month,$invoice->exp_year);

                        if ($refund['status']) {
                            // change status to 2 pending
                            $invoice->status = 2;
                            $invoice->transaction_id = NULL;
                            $invoice->save();
                            flash('Successfully refunded transaction.')->success();
                            
                        } else {
                            flash($refund['reason'])->error();

                        }
                        
                        break;
                    
                    default: // Must void
                        $void = $authorize->voidTransaction($transaction_id);
                        if ($void['status']) {
                            $invoice->status = 2;
                            $invoice->transaction_id = NULL;
                            $invoice->save();
                            flash('Successfully voided transaction.')->success();
                        } else {
                            flash($void['reason'])->error();

                        }
                        # code...
                        break;
                }
            } else {
                flash('There was an error get details of the transaction. Please speak to your administrator.')->error();
                // dd('error');
                
            }
            
        }
        return redirect()->back();
    }

    /**
    * Refund payment script 
    **/
    public function refundPayment(Request $request, Invoice $invoice, Authorize $authorize)
    {
        $transaction_id = $invoice->transaction_id;
        $result = [
            'status'=> false,
            'message'=>'No refund to make. There was no previous transaction.'
        ];
        if (isset($transaction_id)) {
            $get_transaction_details = $authorize->getTransactionDetails($transaction_id);
            if (($get_transaction_details != null) && ($get_transaction_details->getMessages()->getResultCode() == "Ok")) {
                // start the void process
                switch ($get_transaction_details->getTransaction()->getTransactionStatus()) {
                    case 'settledSuccessfully': // Must refund
                        $refund = $authorize->refundTranscaction($invoice->total,$invoice->last_four,$invoice->exp_month,$invoice->exp_year);

                        if ($refund['status']) {
                            // change status to 2 pending
                            $invoice->status = 2;
                            $invoice->transaction_id = NULL;
                            $invoice->save();
                            $result['status'] = true;
                            
                        } else {
                            $result=[
                                'status'=>false,
                                'message'=>$refund['reason']
                            ];
                        }
                        break;
                    
                    default: // Must void
                        $void = $authorize->voidTransaction($transaction_id);
                        if ($void['status']) {
                            $invoice->status = 2;
                            $invoice->transaction_id = NULL;
                            $invoice->save();
                            $result['status'] = true;
                        } else {
                            $result=[
                                'status'=>false,
                                'message'=>$void['reason']
                            ];
                        }
                        break;
                }
            } else {
                $result=[
                    'status'=>false,
                    'message'=>'here was an error get details of the transaction. Please speak to your administrator.'
                ];
            }
            
        }
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceItem $invoiceItem, InventoryItem $inventoryItem, ItemStone $itemStone, Job $job, Invoice $invoice)
    {
        $result = $request->result;
        $cart = session()->get('cartBackend');
        $email = $itemStone->checkEmailAll($cart['selectedOptions']);
        $customer = [
            'id'=> NULL,
            'first_name'=>trim($cart['firstName']),
            'last_name'=>trim($cart['lastName']),
            'email'=>trim($cart['email']),
            'phone'=>$job->stripAllButNumbers($cart['phone']),
            'street'=>trim($cart['street']),
            'suite'=>trim($cart['suite']),
            'city'=>trim($cart['city']),
            'state'=>trim($cart['state']),
            'zipcode'=>trim($cart['zipcode']),
            'country'=>trim($cart['country']),
            'billing_street'=>trim($cart['billingStreet']),
            'billing_suite'=>trim($cart['billingSuite']),
            'billing_city'=>trim($cart['billingCity']),
            'billing_state'=>trim($cart['billingState']),
            'billing_zipcode'=>trim($cart['billingZipcode']),
            'comment'=>NULL,
            'shipping'=>$cart['shipping']
        ]; 
        $totals = $cart['totals'];
        $card = [
            'card_number'=>$job->stripAllButNumbers($cart['cardNumber']),
            'exp_month'=>$job->stripAllButNumbers($cart['expMonth']),
            'exp_year'=>$job->stripAllButNumbers($cart['expYear']),
            'cvv'=>$job->stripAllButNumbers($cart['cvv'])
        ];

        $update_invoice = $invoice->updateInvoice($invoice->id,$totals, $customer, $result, $card);
        // $new_invoice = $invoice->newInvoice($totals, $customer, $result, $card);
        if($update_invoice) {
            $update_invoice_items = $invoiceItem->updateInvoiceItems($cart);
            if ($update_invoice_items) {
                return response()->json([
                    'status' => true,
                    'invoice'=>$update_invoice
                ]);
            }
            
        
        }

        return response()->json([
            'status' => false
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice, Authorize $authorize,InvoiceItem $invoiceItem)
    {
        
        $transaction_id = $invoice->transaction_id;
        flash('successfully cancelled invoice')->success();
        if (isset($transaction_id)) {
            $get_transaction_details = $authorize->getTransactionDetails($transaction_id);
            if (($get_transaction_details != null) && ($get_transaction_details->getMessages()->getResultCode() == "Ok")) {
                // start the void process
                switch ($get_transaction_details->getTransaction()->getTransactionStatus()) {
                    case 'settledSuccessfully': // Must refund
                        $refund = $authorize->refundTranscaction($invoice->total,$invoice->last_four,$invoice->exp_month,$invoice->exp_year);

                        if ($refund['status']) {
                            flash('Successfully refunded transaction.')->success();
                        } else {
                            flash($refund['reason'])->error();
                            return redirect()->back();
                        }
                        
                        break;
                    
                    default: // Must void
                        $void = $authorize->voidTransaction($transaction_id);
                        if ($void['status']) {
                            flash('Successfully voided transaction.')->success();
                        } else {
                            flash($void['reason'])->error();
                            return redirect()->back();
                        }
                        # code...
                        break;
                }
            } else {
                flash('There was an error get details of the transaction. Please speak to your administrator.')->error();
                // dd('error');
                return redirect()->back();
            }
            
        }

        // remove all invoice items associated with
        $del_items = $invoice->invoiceItems()->delete();
        if ($del_items) {
            if ($invoice->delete()) {
                return redirect()->back();
            }
        }
        
    }

    

    /**
    * Backend function which makes the invoice complete
    **/
    public function complete(Request $request, Invoice $invoice)
    {
        $update = $invoice->update(['status'=>5]);

        if ($update) {
            flash('Successfully completed invoice!')->success();
            return redirect()->back();
        }
    }

    /**
    * Sends email from backend, showing updated totals
    **/
    public function sendEmail(Request $request, Invoice $invoice, Company $company)
    {
        // generate the email

        $company_info = $company->find(1);
        // generate the token page
        $token = bin2hex(random_bytes(20));
        $invoice->email_token = $token;

        if ($invoice->save()) {
            $invoice_single = $invoice->singleDetail($invoice);
            // dd('here');
            try{
                Mail::to($invoice_single->email)->send(new InvoicePending($invoice_single, $company_info));
                // All Done
                flash('Successfully send invoice email to customer!')->success();   
            } catch(\Exception $e) {
                flash($e->getMessage())->warning();
            }
        }
        return redirect()->back();
    }

    /**
    * Sends email from backend, showing updated totals
    **/
    public function pushEmailForm(Request $request, Invoice $invoice, Company $company)
    {
        // generate the email
        $result = [
            'status' => false
        ];
        $company_info = $company->find(1);
        // generate the token page
        $token = bin2hex(random_bytes(20));
        $invoice->email_token = $token;

        if ($invoice->save()) {
            $invoice_single = $invoice->singleDetail($invoice);
            try{
                Mail::to($invoice_single->email)->send(new InvoicePending($invoice_single, $company_info));
                // All Done
                $result = [
                    'status' => true
                ];
                
            } catch(\Exception $e) {
                $result = [
                    'status' => false,
                    'message'=>$e->getMessage()
                ];
                
            }
        }

        return response()->json($result);

    }

    /**
    * displays pending form with updated totals from lab created diamons / certified diamonds. Customer fills
    * out and authorizes payment. Returns status 3 which is paid back to admins page
    **/
    public function finish(Request $request, $token = null,Invoice $invoice, Job $job, InventoryItem $inventoryItem, ItemStone $itemStone)
    {
        $invs = $invoice->where('email_token',$token)->first();
        if (isset($invs) && isset($invs['email_token'])) {

            $invoice = $invoice->singleDetail($invs);
            $states = $job->prepareStates();
            $countries = $job->prepareCountries();
            $cart = $inventoryItem->prepareCartAdmin($invs);

            $totals = $inventoryItem->prepareTotalsAdmin($invs);
            $email = $itemStone->checkEmailAll($cart);
            session()->put('cartFinish',$cart);
            return view('invoices.finish', compact(['totals','states','countries','cart','email','invoice']));
        } else {
            flash('This token has expired or does not belong to you. Please contact administrator to send a new email. Thank you.')->error();
            return redirect()->route('home');
        }
        
    }

    /**
    * finalize checkout, authorize payment, save invoice, save invoice items, email customer
    **/
    public function done(Request $request,Invoice $invoice, Authorize $authorize, Job $job, InventoryItem $inventoryItem, User $user, Company $company, InvoiceItem $invoiceItem, ItemStone $itemStone)
    {
        // Prepare all the variables required for saving
        $cart = session()->get('cartFinish');

        $email = false;
        $this->validate(request(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            "street"=>'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required',
            'zipcode' => 'required|string|max:10',
            'billing_street' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_zipcode' => 'required|string|max:255',
            'card_number' => 'required|numeric',
            'exp_month' => 'required|numeric|max:12',
            'exp_year' => 'required|numeric|max:9999',
            'cvv' => 'required|numeric|max:9999'
        ]);

        $company_info = $company->find(1);
        $totals = $inventoryItem->prepareTotalsAdmin($invoice);
        $due = $totals['_total'];
        $shipping = $request->shipping;
        $customer = [
            'id'=>(auth()->check()) ? auth()->user()->id : NULL,
            'first_name'=>trim($request->first_name),
            'last_name'=>trim($request->last_name),
            'email'=>trim($request->email),
            'phone'=>trim($request->phone),
            'street'=>trim($request->street),
            'suite'=>trim($request->suite),
            'city'=>trim($request->city),
            'state'=>trim($request->state),
            'zipcode'=>trim($request->zipcode),
            'country'=>trim($request->country),
            'billing_street'=>$request->billing_street,
            'billing_suite'=>$request->billing_suite,
            'billing_city'=>$request->billing_city,
            'billing_state'=>$request->billing_state,
            'billing_zipcode'=>$request->billing_zipcode,
            'comment'=>NULL,
            'shipping'=>$invoice->shipping
        ]; 

        // Run this if we are running payments, basically if the email variable is false

        $card = [
            'card_number'=>$job->stripAllButNumbers($request->card_number),
            'exp_month'=>$job->stripAllButNumbers($request->exp_month),
            'exp_year'=>$job->stripAllButNumbers($request->exp_year),
            'cvv'=>$job->stripAllButNumbers($request->cvv)
        ];


        // Attempt to make the payment for the item
        $result = $authorize->chargeCreditCard($due, $card, $customer);
        
        if  ($result['status']) { // Payment has been processed, proceed to save invoice

            // save the invoice
            $update_invoice = $invoice->updateInvoice($invoice->id,$totals, $customer, $result, $card);
            
            if ($update_invoice) {
   
                try{
                    Mail::to($customer['email'])->send(new InvoiceUserOrder($update_invoice, $company_info, $email));
                    // All Done
                    flash('Thank you for your business! We have sent an email of your invoice to you. Please check your email for further instructions!')->success();   
                } catch(\Exception $e) {
                    flash("The invoice has been paid and properly saved. However, there was an error saving items from your cart. Please call us at {$job->formatPhone($company_info->phone)} to remedy this error. We are sorry for the inconvenience.")->warning();
                }
                    
                // last but not least send user to thank you page
                return redirect()->route('home.thank_you');
            }
        } else { // Payment was not processed due to error
            flash($result['error_message'])->error()->important();
            return redirect()->back();
        }
    
    }
    /**
    * Resets shopping cart session
    **/
    public function reset(Request $request) {
        session()->forget('cart');
        session()->forget('cartBackend');
        return response()->json([
            'status' => true
        ]);
    }

    /**
    * Reverts invoice statuses 
    **/
    public function revert(Request $request, Invoice $invoice) {
        $status = 3;
        $invoice->update(['status'=>$status]);
        flash('successfully reverted invoice to paid')->success();
        return redirect()->back();
    }

    /**
    * Updates shipping costs 
    **/
    public function updateShipping(Request $request, Invoice $invoice)
    {
        $subtotal = $invoice->subtotal;
        $tax = $invoice->tax;
        $shipping_total = $request->total;
        
        if (is_numeric($request->total)) {
            $total = $subtotal + $tax + $request->total;
            $invoice->update(['shipping_total'=>$request->total,'total'=>$total,'status'=>2]);
            return response()->json([
                'status' => true,
                'subtotal'=> '$'.number_format($subtotal,2,'.',','),
                'shipping'=> number_format($shipping_total,2,'.',','),
                'tax'=> '$'.number_format($tax,2,'.',','),
                'total'=> '$'.number_format($total,2,'.',',')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Shipping total must be a number. It cannot be left empty or have any non numeric characters. Try again'
            ]);
        }
        

        
    }

    public function showInvoicePdf(Invoice $invoice, Company $company) {
        $inv = $invoice->singleDetail($invoice);
        $company = $company->prepareCompany($company->find(1));
        $pdf = \PDF::loadView('pdfs.invoice',compact(['inv','company']));
        return $pdf->stream();
    }


}
