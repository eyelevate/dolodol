@component('mail::layout')
@slot('header')
@component('mail::header',['url' => config('app.url')])
{{ $company->name }} - Invoice Receipt #{{ str_pad($invoice->id,6,0,STR_PAD_LEFT) }}
@endcomponent
@endslot


@component('mail::message')
Hello {{ ($invoice->user_id) ? ucFirst($invoice->users->first_name) : ucFirst($invoice->first_name) }} {{ ($invoice->user_id) ? ucFirst($invoice->users->last_name) : ucFirst($customer['last_name']) }},
@endcomponent

@component('mail::message')
This is a response to your order at {{ $company->name }}. We appreciate your business and thank you for your order. Below are the details of your order. We will get started on your order right away to ensure the best quality and service we can provide. At {{ $company->name }} we strive for perfection so we will make sure that your item will be done with the highest priority and completed with the upmost care. Please take the time to review your data below and call us if you have any questions.
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