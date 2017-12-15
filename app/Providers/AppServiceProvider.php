<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // Layouts
        view()->composer([
            'layouts.themes.backend.login',
            'layouts.themes.backend.layout',
            'layouts.themes.backend.partials.nav',
            'layouts.themes.theme2.layout',
            'layouts.themes.theme2.partials.nav',
            'home.thank_you',
            'layouts.themes.pdfs.layout'
            ], function ($view) {
                $company = \App\Company::prepareCompany(\App\Company::find(1));
                $view->with('company', $company);
            });
        view()->composer([
            'layouts.themes.backend.layout'
            ], function ($view) {
                $contact_get = \App\Contactus::prepareContactus();
                $view->with('contact_get', $contact_get);
            });

        // Parts
        view()->composer([
            'layouts.themes.theme2.partials.footer',
            'emails.user.invoiceuserorder'
            ], function ($view) {
                $company = \App\Company::prepareCompany(\App\Company::find(1));
                $view->with('company', $company);
            });

        // backend nav and aside
        view()->composer([
            'layouts.themes.backend.partials.nav',
             'layouts.themes.backend.partials.aside',
            ], function ($view) {
                $count_contactus = \App\Contactus::countContactus();
                $active_invoices = \App\Invoice::where('status', '<', 5)->whereBetween('created_at', [date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])->count();
                $view->with('active_invoices', $active_invoices)
                ->with('count_contactus', $count_contactus);
            });

        // Send asset issues data globally to sidebar
        view()->composer('layouts.themes.backend.partials.sidebar', function ($view) {
            $collections_count = \App\Collection::countCollections();
            $customer_count = \App\User::countCustomers();
            $employee_count = \App\User::countEmployees();
            $companies_count = \App\Company::countCompanies();
            $inventory_count = \App\Inventory::countInventories();
            $inventory_item_count = \App\InventoryItem::countInventoryItems();
            $invoice_count = \App\Invoice::countInvoices();
            $view->with('companies_count', $companies_count)
            ->with('collections_count', $collections_count)
            ->with('customer_count', $customer_count)
            ->with('employee_count', $employee_count)
            ->with('inventory_count', $inventory_count)
            ->with('inventory_item_count', $inventory_item_count)
            ->with('invoice_count', $invoice_count);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
