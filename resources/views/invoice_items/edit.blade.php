@extends('layouts.themes.backend.layout')
@section('styles')
@endsection
@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/invoice_items/edit.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb --> 
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Edit Invoice</li>
</ol>
{!! Form::open(['method'=>'patch','route'=>['invoice_item.update',$invoiceItem->id]]) !!}
<div class="container">
    <bootstrap-card use-header = "true" use-body="true" use-footer = "true">
        <template slot = "header"> Update Invoice Item </template>
        <template slot = "body">

            <div class="row-fluid">
                <div class="form-group {{ $errors->has('quantity') ? ' has-danger' : '' }}">
                    <label>Quantity</label>
                    {{ Form::select('quantity',[1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10], (old('quantity')) ? old('quantity') : $invoiceItem->quantity,['class'=>"form-control {($errors->has('quantity') ? 'form-control-danger' : ''}",'v-on:change'=>'setQuantity($event)']) }}
                    <div class="{{ ($errors->has('quantity')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('quantity') }}</small>
                    </div>
                </div>

            </div>
            @if(isset($invoiceItem->finger_id))
            <div class="row-fluid">
                
                <div class="form-group {{ $errors->has('finger_id') ? ' has-danger' : '' }}">
                    <label>Select Finger Size</label>
                    {{ Form::select('finger_id',$fingers,old('finger_id') ? old('finger_id') : $invoiceItem->finger_id,['class'=>"form-control {($errors->has('finger_id')) ? 'form-control-danger' : ''}",'v-on:change'=>'setFinger($event)']) }}
                    <div class="{{ ($errors->has('finger_id')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('finger_id') }}</small>
                    </div>
                </div>
            </div>
            @endif
            @if(isset($invoiceItem->item_metal_id))
            <div class="row-fluid">
                
                <div class="form-group {{ $errors->has('item_metal_id') ? ' has-danger' : '' }}">
                    <label>Select Metal Type</label>
                    {{ Form::select('item_metal_id',$metals,old('item_metal_id') ?  old('item_metal_id') : $invoiceItem->item_metal_id,['class'=>"form-control {($errors->has('item_metal_id')) ? 'form-control-danger' : ''}",'v-on:change'=>'setMetal($event)']) }}
                    <div class="{{ ($errors->has('item_metal_id')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('item_metal_id') }}</small>
                    </div>
                </div>
            </div>
            @endif

            @if(isset($invoiceItem->item_stone_id))
            <div class="row-fluid">
                
                <div class="form-group {{ $errors->has('item_stone_id') ? ' has-danger' : '' }}">
                    <label>Select Stone Type</label>
                    {{ Form::select('item_stone_id',$stone_select,old('item_stone_id') ? old('item_stone_id') : $invoiceItem->item_stone_id,['class'=>"form-control {($errors->has('stone_id')) ? 'form-control-danger' : ''}",'v-on:change'=>'setStone($event)']) }}
                    <div class="{{ ($errors->has('item_stone_id')) ? '' : 'hide' }}">
                        <small class="form-control-feedback">{{ $errors->first('item_stone_id') }}</small>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                @if (count($invoiceItem->inventoryItem->itemStone) > 0)
                    @foreach($invoiceItem->inventoryItem->itemStone as $stone)
                    <div v-if="stoneId == {{ $stone->id }}">

                        <div class="form-group {{ $errors->has("item_size_id.{$stone->id}") ? ' has-danger' : '' }}">
                            
                            @if ($invoiceItem->itemStone->stones->email)
                            <bootstrap-input class="form-group-no-border {{ $errors->has('serial') ? ' has-danger' : '' }}" 
                                use-label = "true"
                                label = "Custom Stone Serial # (optional)"
                                b-placeholder="Serial #"
                                b-name="serial"
                                b-type="text"
                                b-value="{{ old('serial') ? old('serial') : $invoiceItem->serial }}"
                                b-err="{{ $errors->has('serial') }}"
                                b-error="{{ $errors->first('serial') }}"
                                >
                            </bootstrap-input>

                            <bootstrap-control class="form-group-no-border {{ $errors->has('custom_stone_price') ? ' has-danger' : '' }}" 
                                use-label = "true"
                                label = "Custom Stone Price"
                                b-placeholder="0.00"
                                b-name="custom_stone_price"
                                b-type="text"
                                b-value="{{ old('custom_stone_price') ? old('custom_stone_price') : $invoiceItem->custom_stone_price }}"
                                b-err="{{ $errors->has('custom_stone_price') }}"
                                b-error="{{ $errors->first('custom_stone_price') }}"
                                >
                                <template slot="control">
                                    {{ Form::text('custom_stone_price',old('custom_stone_price') ? old('custom_stone_price') : $invoiceItem->custom_stone_price,['class'=>'form-control','v-on:blur'=>'setCustomPrice($event)']) }}
                                </template>
                            </bootstrap-control>

                            @else
                                @if(count($stone_sizes) > 0)
                                    @foreach($stone_sizes as $key => $ss)
                                    <div v-if="stoneId == {{ $key }}">
                                        <label>Select Stone Size</label>  
                                        {{ Form::select('item_size_id['.$key.']',$ss,(old('item_size_id['.$key.']')) ? (old('item_size_id['.$key.']')) : $invoiceItem->item_size_id ,['class'=>"form-control {($errors->has('item_size_id.'.$stone->id)) ? 'form-control-danger' : ''}",'v-on:change'=>'setSize($event)']) }}
                                        <div class="{{ ($errors->has("item_size_id.{$key}")) ? '' : 'hide' }}">
                                            <small class="form-control-feedback">{{ $errors->first("item_size_id.{$stone->id}") }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            
                            @endif
                            
                        </div>                      
                    </div>
                    @endforeach
                @endif
            </div>
            @endif
            <div class="row-fluid">

                <label>Subtotal</label>
                <input name="subtotal" id="subtotal" class="form-control" v-model="subtotal"/>
                <div class="{{ ($errors->has('subtotal')) ? '' : 'hide' }}">
                    <small class="form-control-feedback">{{ $errors->first('subtotal') }}</small>
                </div>
            </div>

        </template>
        <template slot="footer">
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class = "btn btn-primary">Update Invoice</button>
        </template>
    </bootstrap-card>
</div>

{!! Form::close() !!}
@endsection

@section('modals')

@endsection

@section('scripts')
@endsection

@section('variables')
<div id="variable-root" 
    metalId="{{ (old('item_metal_id')) ? old('item_metal_id') : $invoiceItem->item_metal_id }}"
    itemId="{{ $invoiceItem->inventory_item_id }}" 
    fingerId = "{{ old('finger_id') ? old('finger_id') :  $invoiceItem->finger_id }}"
    subtotal="{{ old('subtotal') ? old('subtotal') : $invoiceItem->subtotal }}"
    stoneId="{{ old('item_stone_id') ? old('item_stone_id') : $invoiceItem->item_stone_id }}"
    sizeId="{{ old('item_size_id') ? old('item_size_id') : $invoiceItem->item_size_id }}">
        
</div>
@endsection