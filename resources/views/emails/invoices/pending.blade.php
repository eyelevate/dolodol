@component('mail::layout')
@slot('header')
@component('mail::header',['url' => config('app.url')])
{{ $company->name }} - Invoice Receipt #{{ str_pad($invoice->id,6,0,STR_PAD_LEFT) }}
@endcomponent
@endslot


@component('mail::message')
Hello {{ ucFirst($invoice->first_name) }} {{ ucFirst($invoice->last_name) }},
@endcomponent

@component('mail::message')
Thank you for your patience with us and allowing us to find the best price possible for your purchase. We have reviewed your order and have successfully found the best price available for your stone. Listed below is our new invoice for your item(s) you selected with us.
@endcomponent

@component('mail::message')
# Invoice #{{ str_pad($invoice->id,6,0,STR_PAD_LEFT) }}
@endcomponent

@component('mail::table')
|Quantity  |Description        |Price      |
|:--------:|:--------------------- |-------:|
@if(count($invoice->invoiceItems) > 0)
	@foreach($invoice->invoiceItems as $item)
|{{ $item->quantity }}|{{ $item->inventoryItem->name }} - {{ $item->inventoryItem->desc }}|${{ number_format($item->subtotal,2,'.',',') }}      |
	@endforeach
@endif
@endcomponent


@component('mail::table')

|                     |          |          |
| ------------------- |---------:| --------:|
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;          |Quantity:&nbsp;|<strong> {{ $invoice->quantity }} </strong>|
|           |Subtotal:&nbsp;|<strong> ${{ number_format($invoice->subtotal,2,'.',',') }} </strong>|
|           |Sales Tax:&nbsp;| <strong>${{ number_format($invoice->tax,2,'.',',') }}</strong>|
|           |Shipping:&nbsp;|<strong>${{ number_format($invoice->shipping_total,2,'.',',') }}</strong>| 
|           |Total:&nbsp;|<strong>${{ number_format($invoice->total,2,'.',',') }}</strong>|
@endcomponent
@component('mail::message')
In order for us to complete this invoice we will need you to review the invoice and click on "Finish Payment" to finish out the invoice. Once we receive your payment we will get to work on your order right away to ensure the best quality and service we can provide. At {{ $company->name }} we strive for perfection so we will make sure that your item will be done with the highest priority and completed with the upmost care. Please take the time to review your data below and call us if you have any questions.
@endcomponent
@component('mail::button',['url' => route('invoice.finish',$invoice->email_token),'color'=>'green'])
Accept & Pay Invoice
@endcomponent
@component('mail::message')
Best,<br>
{{ $company->name }} Team


@endcomponent


@slot('footer')
@component('mail::footer')
<strong>{{ $company->name }}</strong><br>
{{ $company->street }} Ste. {{ $company->suite }}<br>
{{ $company->city }}, {{ $company->state }} {{ $company->zipcode }}<br>
{{ $company->phone }}<br>
{{ $company->email }}

@endcomponent
@endslot
@endcomponent