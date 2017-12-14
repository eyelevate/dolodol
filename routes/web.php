<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page
Route::get('/', 'HomeController@index')->name('home');
Route::get('/cart', 'HomeController@cart')->name('home.cart');
Route::get('/frequently-asked-questions', 'HomeController@faq')->name('home.faq');
Route::get('/logout', 'HomeController@logout')->name('home.logout');
Route::get('/privacy-policy', 'HomeController@privacy')->name('home.privacy');
Route::get('/shipping', 'HomeController@shipping')->name('home.shipping');
Route::get('/shop', 'HomeController@shop')->name('home.shop');
Route::post('/address-validate', 'HomeController@addressValidate')->name('home.address_validate');
Route::post('/update-shipping', 'HomeController@updateShipping')->name('home.update_shipping');
Route::post('/update-shipping-finish', 'HomeController@updateShippingFinish')->name('home.update_shipping_finish');
Route::get('/terms-of-service', 'HomeController@tos')->name('home.tos');
Route::get('/checkout', 'HomeController@checkout')->name('home.checkout');
Route::post('/finish', 'HomeController@finish')->name('home.finish');
Route::post('/attempt-login', 'HomeController@attemptLogin')->name('home.attempt_login');
Route::get('/thank-you', 'HomeController@thankYou')->name('home.thank_you');
Route::get('/custom', 'HomeController@custom')->name('home.custom');



// Contactus
//Route::get('/contact', 'HomeController@contact')->name('home.contact');
Route::get('/contact', 'ContactusController@index')->name('home.index');
Route::get('/contact/create', 'ContactusController@create')->name('contact.create');
Route::post('/contact/store', 'ContactusController@store')->name('contact.store');



// collections
Route::get('/collections/{collection}/show', 'CollectionController@show')->name('collection.show');

// Invoice
Route::patch('/done/{invoice}', 'InvoiceController@done')->name('invoice.done');
Route::get('/invoices/{token}/finish', 'InvoiceController@finish')->name('invoice.finish');

// inventory items
Route::post('/inventory-items/{inventoryItem}/add-to-cart', 'InventoryItemController@addToCart')->name('inventory_item.add_to_cart');
Route::get('/item/{inventory_item}/shop', 'InventoryItemController@shop')->name('inventory_item.shop');
Route::post('/inventory-items/{inventory_item}/get-subtotal', 'InventoryItemController@subtotal')->name('inventory_item.subtotal');
Route::post('/inventory-items/delete-cart-item', 'InventoryItemController@deleteCartItem')->name('inventory_item.delete_cart_item');

Auth::routes();

// Admin Access
Route::get('/admins/login', 'AdminController@login')->name('admin.login');
Route::post('/admins/authenticate', 'AdminController@authenticate')->name('admin.auth');

/** Customer Pages **/
Route::group(['middleware' => ['frontend']], function () {
    // dashboard
    Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard');
});

// Redirects if role_id > 3 (employee) or guests, check middleware/Authentice class if need to change
Route::group(['middleware' => ['check:1']], function () {
});
Route::group(['middleware' => ['check:2']], function () {
    // Employees
    Route::get('/employees', 'EmployeeController@index')->name('employee.index');
    Route::get('/employees/create', 'EmployeeController@create')->name('employee.create');
    Route::delete('/employees/{employee}', 'EmployeeController@destroy')->name('employee.destroy');
    Route::post('/employees/store', 'EmployeeController@store')->name('employee.store');
    Route::get('/employees/{employee}/show', 'EmployeeController@show')->name('employee.show');
    Route::get('/employees/{vendor}/edit', 'EmployeeController@edit')->name('employee.edit');
    Route::patch('/employees/{vendor}', 'EmployeeController@update')->name('employee.update');
});
Route::group(['middleware' => ['check:3']], function () {
    // Admins
    Route::get('/admins', 'AdminController@index')->name('admin.index');
    Route::get('/admins/logout', 'AdminController@logout')->name('admin.logout');

    // Customers
    Route::get('/customers', 'CustomerController@index')->name('customer.index');
    Route::get('/customers/create', 'CustomerController@create')->name('customer.create');
    Route::delete('/customers/{customer}', 'CustomerController@destroy')->name('customer.destroy');
    Route::post('/customers/store', 'CustomerController@store')->name('customer.store');
    Route::get('/customers/{customer}/show', 'CustomerController@show')->name('customer.show');
    Route::get('/customers/{customer}/edit', 'CustomerController@edit')->name('customer.edit');
    Route::patch('/customers/{customer}', 'CustomerController@update')->name('customer.update');

    // Companies
    Route::get('/companies', 'CompanyController@index')->name('company.index');
    Route::get('/companies/create', 'CompanyController@create')->name('company.create');
    Route::delete('/companies/{company}', 'CompanyController@destroy')->name('company.destroy');
    Route::post('/companies/store', 'CompanyController@store')->name('company.store');
    Route::get('/companies/{company}/show', 'CompanyController@show')->name('company.show');
    Route::get('/companies/{company}/edit', 'CompanyController@edit')->name('company.edit');
    Route::patch('/companies/{company}', 'CompanyController@update')->name('company.update');

    // Collections
    Route::get('/collections', 'CollectionController@index')->name('collection.index');
    Route::get('/collections/create', 'CollectionController@create')->name('collection.create');
    Route::delete('/collections/{collection}', 'CollectionController@destroy')->name('collection.destroy');
    Route::post('/collections/store', 'CollectionController@store')->name('collection.store');
    Route::get('/collections/{collection}/edit', 'CollectionController@edit')->name('collection.edit');
    Route::patch('/collections/{collection}', 'CollectionController@update')->name('collection.update');
    Route::get('/collections/{collection}/set', 'CollectionController@set')->name('collection.set');
    Route::post('/collections/{collection}/add', 'CollectionController@add')->name('collection.add');
    Route::post('/collections/{collection}/remove', 'CollectionController@remove')->name('collection.remove');

    // Contact Us
    Route::delete('/contact/{contactus}', 'ContactusController@destroy')->name('contact.destroy');
    Route::get('/contact/{contactus}/show', 'ContactusController@show')->name('contact.show');
    Route::get('/contact/{contactus}/edit', 'ContactusController@edit')->name('contact.edit');
    Route::patch('/contact/{contactus}', 'ContactusController@update')->name('contact.update');
    Route::post('/contact/{contactus}/mark-as-read', 'ContactusController@markAsRead')->name('contact.mark_as_read');
    Route::post('/contact/{contactus}/set-as-archive', 'ContactusController@setAsArchive')->name('contact.set_as_archive');
    Route::post('/contact/{contactus}/set-as-deleted', 'ContactusController@setAsDeleted')->name('contact.set_as_deleted');


    // Employees
    Route::get('/employees', 'EmployeeController@index')->name('employee.index');
    Route::get('/employees/create', 'EmployeeController@create')->name('employee.create');
    Route::delete('/employees/{employee}', 'EmployeeController@destroy')->name('employee.destroy');
    Route::post('/employees/store', 'EmployeeController@store')->name('employee.store');
    Route::get('/employees/{employee}/show', 'EmployeeController@show')->name('employee.show');
    Route::get('/employees/{employee}/edit', 'EmployeeController@edit')->name('employee.edit');
    Route::patch('/employees/{employee}', 'EmployeeController@update')->name('employee.update');



    // Inventory
    Route::get('/inventories', 'InventoryController@index')->name('inventory.index');
    Route::get('/inventories/create', 'InventoryController@create')->name('inventory.create');
    Route::delete('/inventories/{inventory}', 'InventoryController@destroy')->name('inventory.destroy');
    Route::post('/inventories/store', 'InventoryController@store')->name('inventory.store');
    Route::get('/inventories/{inventory}/show', 'InventoryController@show')->name('inventory.show');
    Route::get('/inventories/{inventory}/edit', 'InventoryController@edit')->name('inventory.edit');
    Route::patch('/inventories/{inventory}', 'InventoryController@update')->name('inventory.update');
    Route::post('/inventories/reorder', 'InventoryController@reorder')->name('inventory.reorder');

    
    // Inventory Item
    Route::get('/inventory-items', 'InventoryItemController@index')->name('inventory_item.index');
    Route::get('/inventory-items/{inventory}/create', 'InventoryItemController@create')->name('inventory_item.create');
    Route::delete('/inventory-items/{inventory_item}', 'InventoryItemController@destroy')->name('inventory_item.destroy');
    Route::post('/inventory-items/{inventory}/store', 'InventoryItemController@store')->name('inventory_item.store');
    Route::post('/inventory-items/find-items', 'InventoryItemController@findItems')->name('inventory_item.find_items');
    
    Route::get('/inventory-items/{inventory_item}/edit', 'InventoryItemController@edit')->name('inventory_item.edit');
    Route::patch('/inventory-items/{inventory_item}', 'InventoryItemController@update')->name('inventory_item.update');
    Route::post('/inventory-items/{inventory_item}/get-subtotal-admins', 'InventoryItemController@subtotalAdmin')->name('inventory_item.subtotal_admin');
    Route::post('/inventory-items/get-options', 'InventoryItemController@getOptions')->name('inventory_item.get_options');
    Route::post('/inventory-items/get-totals', 'InventoryItemController@getTotals')->name('inventory_item.get_totals');
    Route::post('/inventory-items/get-totals-edit', 'InventoryItemController@getTotalsEdit')->name('inventory_item.get_totals_edit');

    // Invoices
    Route::get('/invoices', 'InvoiceController@index')->name('invoice.index');
    Route::get('/invoices/create', 'InvoiceController@create')->name('invoice.create');
    Route::delete('/invoices/{invoice}', 'InvoiceController@destroy')->name('invoice.destroy');
    Route::post('/invoices/store', 'InvoiceController@store')->name('invoice.store');
    Route::get('/invoices/{invoice}/show', 'InvoiceController@show')->name('invoice.show');
    Route::get('/invoices/{invoice}/edit', 'InvoiceController@edit')->name('invoice.edit');
    Route::post('/invoices/{invoice}/update', 'InvoiceController@update')->name('invoice.update');
    Route::patch('/invoices/{invoice}/complete', 'InvoiceController@complete')->name('invoice.complete');
    Route::post('/invoices/{invoice}/refund', 'InvoiceController@refund')->name('invoice.refund');
    Route::post('/invoices/{invoice}/refund-payment', 'InvoiceController@refundPayment')->name('invoice.refund_payment');
    Route::post('/invoices/{invoice}/send-email', 'InvoiceController@sendEmail')->name('invoice.email');
    Route::post('/invoices/reset', 'InvoiceController@reset')->name('invoice.reset');
    Route::patch('/invoices/{invoice}/revert', 'InvoiceController@revert')->name('invoice.revert');
    Route::post('/invoices/make-session', 'InvoiceController@makeSession')->name('invoice.make_session');
    Route::post('/invoices/forget-session', 'InvoiceController@forgetSession')->name('invoice.forget_session');
    Route::post('/invoices/authorize-payment', 'InvoiceController@authorizePayment')->name('invoice.authorize_payment');
    Route::post('/invoices/{invoice}/update-shipping', 'InvoiceController@updateShipping')->name('invoice.update_shipping');
    Route::post('/invoices/{invoice}/push-email-form', 'InvoiceController@pushEmailForm')->name('invoice.push_email_form');
    Route::get('/invoices/{invoice}/show-invoice-pdf', 'InvoiceController@showInvoicePdf')->name('invoice.show_invoice_pdf');


    Route::post('/invoices/push-email', 'InvoiceController@pushEmail')->name('invoice.push_email');
    // Invoice Item
    Route::get('/invoice-items', 'InvoiceItemController@index')->name('invoice_item.index');
    Route::get('/invoice-items/create', 'InvoiceItemController@create')->name('invoice_item.create');
    Route::delete('/invoice-items/{invoiceItem}', 'InvoiceItemController@destroy')->name('invoice_item.destroy');
    Route::post('/invoice-items/store', 'InvoiceItemController@store')->name('invoice_item.store');
    Route::get('/invoice-items/{invoiceItem}/show', 'InvoiceItemController@show')->name('invoice_item.show');
    Route::get('/invoice-items/{invoiceItem}/edit', 'InvoiceItemController@edit')->name('invoice_item.edit');
    Route::patch('/invoice-items/{invoiceItem}', 'InvoiceItemController@update')->name('invoice_item.update');
    Route::post('/invoice-items/{invoiceItem}/update-price', 'InvoiceItemController@updatePrice')->name('invoice_item.update_price');


    // Reports
    Route::get('/reports', 'ReportController@index')->name('report.index');
    Route::get('/reports/create', 'ReportController@create')->name('report.create');
    Route::delete('/reports/{report}', 'ReportController@destroy')->name('report.destroy');
    Route::post('/reports/store', 'ReportController@store')->name('report.store');
    Route::get('/reports/{report}/show', 'ReportController@show')->name('report.show');
    Route::get('/reports/{report}/edit', 'ReportController@edit')->name('report.edit');
    Route::patch('/reports/{report}', 'ReportController@update')->name('report.update');
    Route::get('/reports/weeks', 'ReportController@weeks')->name('report.weeks');
    Route::get('/reports/months', 'ReportController@months')->name('report.months');
    Route::get('/reports/years', 'ReportController@years')->name('report.years');
    Route::post('/reports/get-weeks-from-year', 'ReportController@getWeeksFromYear')->name('report.get_weeks_from_year');
    Route::post('/reports/update-table-weeks', 'ReportController@updateTableWeeks')->name('report.update_table_weeks');
    Route::post('/reports/get-months-from-year', 'ReportController@getMonthsFromYear')->name('report.get_months_from_year');
    Route::post('/reports/update-table-months', 'ReportController@updateTableMonths')->name('report.update_table_months');
    Route::post('/reports/get-years', 'ReportController@getYears')->name('report.get_years');
    // Size
    Route::get('/sizes', 'SizeController@index')->name('size.index');
    Route::get('/sizes/create', 'SizeController@create')->name('size.create');
    Route::delete('/sizes/{size}', 'SizeController@destroy')->name('size.destroy');
    Route::post('/sizes/store', 'SizeController@store')->name('size.store');
    Route::get('/sizes/{size}/show', 'SizeController@show')->name('size.show');
    Route::get('/sizes/{size}/edit', 'SizeController@edit')->name('size.edit');
    Route::patch('/sizes/{size}', 'SizeController@update')->name('size.update');


    // Taxes
    Route::get('/taxes', 'TaxController@index')->name('tax.index');
    Route::get('/taxes/create', 'TaxController@create')->name('tax.create');
    Route::post('/taxes/store', 'TaxController@store')->name('tax.store');


});
