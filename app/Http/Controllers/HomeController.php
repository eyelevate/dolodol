<?php

namespace App\Http\Controllers;

use App\Authorize;
use App\Company;
use App\Collection;
use App\Instagram;
use App\InventoryItem;
use App\Invoice;
use App\InvoiceItem;

use App\Job;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Mail Test
use Mail;
use App\Mail\InvoiceUserOrder;

class HomeController extends Controller
{
    private $layout;
    private $view;
    // private $instagram;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        $theme = 2;
        $this->layout = $job->switchLayout($theme);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Instagram $instagram, Collection $collection, InventoryItem $inventoryItem)
    {
        $layout = $this->layout;

        // featured collection (Randomly Selected)
        $featured_collection = $collection->where('featured', true)->where('active', true)->inRandomOrder()->first();
        // featured items (All for now until we start collections)
        $items = $inventoryItem->where('featured', true)->where('active', true)->orderBy('id','desc')->get();

        $featured_items = $inventoryItem->prepareForFrontend($items);

        return view('home.index', compact(['layout','featured_collection','featured_items']));
    }

    public function cart(InventoryItem $inventoryItem)
    {
        // session()->forget('cart');

        $cart = $inventoryItem->prepareCart(session()->get('cart'));
        $totals = $inventoryItem->prepareTotals(session()->get('cart'));


        $layout = $this->layout;
        return view('home.cart', compact(['layout','cart','totals']));
    }

    public function faq()
    {
        $layout = $this->layout;
        return view('home.faq', compact(['layout']));
    }


    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
            flash()->message('Successfully logged out!')->success();
        } else {
            flash()->message('Warning: no instances of a logged in session remaining. Please try logging in again.')->warning();
        }

        return redirect()->route('home');
    }

    public function privacy()
    {
        $layout = $this->layout;
        return view('home.privacy', compact(['layout']));
    }

    public function shipping()
    {
        $layout = $this->layout;
        return view('home.shipping', compact(['layout']));
    }

    public function shop(Collection $collection)
    {
        $nonfeatured = $collection->where('active', true)->where('featured', false)->orderBy('id', 'desc');
        $collections = $collection->where('featured', true)->where('active', true)->union($nonfeatured)->get();
        $layout = $this->layout;
        return view('home.shop', compact(['layout','collections']));
    }

    public function tos()
    {
        $layout = $this->layout;
        return view('home.tos', compact(['layout']));
    }

    public function custom()
    {
        $layout = $this->layout;
        return view('home.custom', compact(['layout']));
    }


    public function checkout(InventoryItem $inventoryItem, Job $job)
    {
        $states = $job->prepareStates();
        $countries = $job->prepareCountries();
        $cart = $inventoryItem->prepareCart(session()->get('cart'));
        $totals = $inventoryItem->prepareTotals(session()->get('cart'));
        $layout = $this->layout;

        return view('home.checkout', compact(['layout','totals','states','countries','cart']));
    }

    // Mail Test
    public function email()
    {
        Mail::to(Auth::user()->email)->send(new InvoiceUserOrder());
        $layout = $this->layout;
        return view('home.checkout', compact(['layout']));
    }

    // Update Shipping Rates
    public function updateShipping(Request $request, InventoryItem $inventoryItem)
    {
        $cart = session()->get('cart');
        if (count($cart) > 0) {
            foreach ($cart as $key => $value) {
                $cart[$key]['shipping'] = $request->shipping;
            }
        }

        $totals = $inventoryItem->prepareTotals($cart);

        session()->put('cart', $cart);


        return response()->json([
            'status'=>true,
            'totals'=>$totals
        ]);
    }
    // Update Shipping Rates on Finish Page
    public function updateShippingFinish(Request $request, InventoryItem $inventoryItem)
    {
        $cart = session()->get('cart');
        if (count($cart) > 0) {
            foreach ($cart as $key => $value) {
                $cart[$key]['shipping'] = $request->shipping;
            }
        }
        
        session()->put('cart', $cart);

        $totals = $inventoryItem->prepareTotalsFinish($cart);

        return response()->json([
            'status'=>true,
            'totals'=>$totals
        ]);
    }

    // Address Validator
    public function addressValidate(Request $request)
    {
        $street = $request->street;
        $suite = $request->suite;
        $city = $request->city;
        $state = $request->state;
        $zipcode = $request->zipcode;
        $country = $request->country;

        $rate = new \Ups\Rate(
            env('UPS_ACCESS_KEY'),
            env('UPS_USER_ID'),
            env('UPS_PASSWORD')
        );
        $status = true;
        try {
            $shipment = new \Ups\Entity\Shipment();

            $shipperAddress = $shipment->getShipper()->getAddress();
            $shipperAddress->setPostalCode('75240'); // where are we shipping from?

            $address = new \Ups\Entity\Address();
            $address->setPostalCode('75240');
            $shipFrom = new \Ups\Entity\ShipFrom();
            $shipFrom->setAddress($address);

            $shipment->setShipFrom($shipFrom);

            $shipTo = $shipment->getShipTo();
            $shipTo->setCompanyName('Test Ship To');
            $shipToAddress = $shipTo->getAddress();
            $shipToAddress->setPostalCode($zipcode);

            $package = new \Ups\Entity\Package();
            $package->getPackagingType()->setCode(\Ups\Entity\PackagingType::PT_PACKAGE);
            $package->getPackageWeight()->setWeight(1);
            
            // if you need this (depends of the shipper country)
            $weightUnit = new \Ups\Entity\UnitOfMeasurement;
            $weightUnit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_LBS);
            $package->getPackageWeight()->setUnitOfMeasurement($weightUnit);

            $dimensions = new \Ups\Entity\Dimensions();
            $dimensions->setHeight(5);
            $dimensions->setWidth(5);
            $dimensions->setLength(5);

            $unit = new \Ups\Entity\UnitOfMeasurement;
            $unit->setCode(\Ups\Entity\UnitOfMeasurement::UOM_IN);

            $dimensions->setUnitOfMeasurement($unit);
            $package->setDimensions($dimensions);

            $shipment->addPackage($package);
            $rates = $rate->getRate($shipment);
            $total_rate = ['rate'=>0,'rate_formatted'=>'$0.00'];
            if (count($rates) > 0) {
                foreach ($rates as $key => $value) {
                    $ratedShipment = $value;
                    if (count($ratedShipment) > 0) {
                        foreach ($ratedShipment as $rs) {
                            $totalCharges = $rs->TotalCharges->MonetaryValue;
                            $total_rate['rate'] = $totalCharges;
                            $total_rate['rate_formatted'] = '$'.number_format($totalCharges, 2, '.', ',');
                        }
                    }
                }
            }
            return response()->json([
                'status'=>true,
                'rate'=>$total_rate
            ]);
        } catch (Exception $e) {
            return response()->json(['status'=>false,'reason'=>$e]);
        }
    }

    public function finish(Request $request, Authorize $authorize, Job $job, InventoryItem $inventoryItem, User $user, Invoice $invoice, Company $company, InvoiceItem $invoiceItem, ItemStone $itemStone)
    {
        // Prepare all the variables required for saving
        $cart = session()->get('cart');
        $email = ($request->shipping== 1) ? $itemStone->checkEmailAll($cart) : true;
        if (!$email) {
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
        } else {
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
            ]);
        }

        
        $company_info = $company->find(1);
        $totals = $inventoryItem->prepareTotals($cart);
        $due = $totals['_total'];
        $shipping = $request->shipping;
        $customer = [
            'id'=>(auth()->check()) ? auth()->user()->id : null,
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
            'comment'=>null,
            'shipping'=>$shipping
        ];



        // Run this if we are running payments, basically if the email variable is false
        if (!$email) {
            $card = [
                'card_number'=>$job->stripAllButNumbers($request->card_number),
                'exp_month'=>$job->stripAllButNumbers($request->exp_month),
                'exp_year'=>$job->stripAllButNumbers($request->exp_year),
                'cvv'=>$job->stripAllButNumbers($request->cvv)
            ];

            // $sent = Mail::to($customer['email'])->send(new InvoiceUserOrder($customer,$totals,$cart));

            // Attempt to make the payment for the item
            $result = $authorize->chargeCreditCard($due, $card, $customer);
            
            if ($result['status']) { // Payment has been processed, proceed to save invoice


                // save the invoice
                $new_invoice = $invoice->newInvoice($totals, $customer, $result, $card);
                
                if ($new_invoice) {
                    // successfully saved invoice now saving invoice items
                    $new_items = $invoiceItem->newInvoiceItems($new_invoice, $cart);
                    if ($new_items) {
                        // Send Email
                        try {
                            Mail::to($customer['email'])->send(new InvoiceUserOrder($new_invoice, $company_info, $email));
                            // All Done
                            flash('Thank you for your business! We have sent an email of your invoice to you. Please check your email for further instructions!')->success();
                        } catch (\Exception $e) {
                            flash("The invoice has been paid and properly saved. However, there was an error saving items from your cart. Please call us at {$job->formatPhone($company_info->phone)} to remedy this error. We are sorry for the inconvenience.")->warning();
                        }
                    } else { // error saving invoice items
                    }

                    // last but not least send user to thank you page
                    return redirect()->route('home.thank_you');
                }
            } else { // Payment was not processed due to error
                flash($result['error_message'])->error()->important();
                return redirect()->back();
            }
        } else { // Run this if email is set to true

            // save the invoice
            $new_invoice = $invoice->newInvoiceEmail($totals, $customer);

            if ($new_invoice) {
                // successfully saved invoice now saving invoice items
                $new_items = $invoiceItem->newInvoiceItems($new_invoice, $cart);
                if ($new_items) {
                    // Send Email
                    try {
                        Mail::to($customer['email'])->send(new InvoiceUserOrder($new_invoice, $company_info, $email));
                        // All Done
                        flash('Thank you for your business! We have sent an email of your invoice to you. Please check your email for further instructions!')->success()->important();
                    } catch (\Exception $e) {
                        flash("The invoice has been paid and properly saved. However, there was an error saving items from your cart. Please call us at {$job->formatPhone($company_info->phone)} to remedy this error. We are sorry for the inconvenience.")->warning()->important();
                    }
                } else { // error saving invoice items
                    flash("The invoice has been paid and properly saved. However, there was an error saving items from your cart. Please call us at {$job->formatPhone($company_info->phone)} to remedy this error. We are sorry for the inconvenience.")->warning()->important();
                }
                

                // last but not least send user to thank you page
                return redirect()->route('home.thank_you');
            }
        }
    }

    

    public function thankYou()
    {
        // remove the session data
        $cart = session()->pull('cart');
        $layout = $this->layout;
        return view('home.thank_you', compact(['layout','cart']));
    }

    public function attemptLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $rememberToken = $request->remember;

        // Attempt login if successful then return true status and refresh the page so auth data can autofill form
        if (Auth::attempt(['email'=>$email,'password'=>$password], $rememberToken)) {
            return response()->json([
                'status'=>true
            ]);
        } else { // send back false message with false status and have user authenticate again
            return response()->json([
                'status'=>false,
                'message'=>'Your credentials did not authenticate. Please try again.'
            ]);
        }
    }
}
