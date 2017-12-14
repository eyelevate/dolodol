
@extends('layouts.themes.backend.layout')

@section('styles')
@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('js/views/invoices/create.js') }}"></script>
@endsection

@section('content')
<!-- Breadcrumb -->	
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('invoice.index') }}">Invoices</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>

<div class="container-fluid">
	<bootstrap-card use-header = "true" use-body="true" use-footer = "true" v-if="current == 1">
		<template slot = "header"> Step 1 - Select Inventory Item </template>
		<template slot = "body">
            <div class="content">
            	<div class="row-fluid">
            		<label>Filter By Keywords</label>
            		<input type="text" v-model="itemName" class="form-control" @keydown.enter.prevent="searchInventoryItem"/>
            	</div>
            	<div id="itemRow" class="row-fluid clearfix">
            		<label><span>@{{ searchInventoryCount }}</span> Results Found</label>
            		<div class="hidden-md-down" v-for="item in items">

						<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 pull-left">
							<div class="card">
							    <div class="card-header">
							    	@{{ item.name_short }}
							    </div>
						        <img class="card-img-top" :src="item.primary_src" >    
						        
							    <div class="card-block">
							    	<p class="text-center">$@{{ item.subtotal }}</p>
							    </div>
							    <div class="card-footer">
							    	<div class="form-button-group">
										<button class="remove-set btn btn-sm btn-block btn-success" type="button" @click="selectItem(item.id)">Select</button>
									</div>
							    </div>
							</div>
						</div>
					</div>
					<div class="hidden-lg-up" v-for="item in items">
						<div class="media">
							<img class="d-flex mr-3" :src="item.primary_src" style="height:50px;width:50px;" alt="Generic placeholder image">
							<div class="media-body">
								<h5 class="mt-0">@{{ item.name_short }}</h5>
								<p >$@{{ item.subtotal }}</p>
								<button class="remove-set btn btn-sm btn-block btn-success" type="button" @click="selectItem(item.id)">Select</button>
							</div>
						</div>
						<hr/>
					</div>
            	</div>

	        </div>
		</template>

		<template slot = "footer">

			<a href="{{ route('invoice.index') }}" class="btn btn-secondary">Cancel</a>
			<button type="button" class="btn btn-danger" @click="reset">Reset</button>
			<button type="button" class = "btn btn-primary pull-right" @click="next" v-if="stepOne">Next</button>

			<button type="button" class = "btn btn-default pull-right disabled" v-else @mouseover="validation">Next</button>	

			
		</template>
	</bootstrap-card>
	<bootstrap-card use-header = "true" use-body="true" use-footer = "true" v-if="current == 2">
		<template slot = "header"> Step 2 - Selected Item Options </template>
		<template slot = "body">
            <div class="content">
            	<div v-for="option, okey in selectedOptions">
            		<div class="media" >
						<img class="d-flex mr-3" :src="option.inventoryItem.primary_src" alt="Generic placeholder image" style="height:75px;">
						<div class="media-body">
							<h5 class="mt-0">@{{ option.inventoryItem.name }}</h5>
							<div class="row-fluid">
								<div>
									<bootstrap-control
										use-label="true"
										label="Quantity"
									>
										<template slot="control">
											<select class="form-control" v-on:change="quantitySelected(okey,$event)" v-model="option.quantity">
												<option v-for="opt, key in option.quantity_select" :value="key" v-if="key == ''" checked>@{{ opt }}</option>
												<option v-for="opt, key in option.quantity_select" :value="key" >@{{ opt }}</option>
											</select>
										</template>
									</bootstrap-control>
								</div>
								<div v-if="option.inventoryItem.fingers">
									<div class="form-group" :class="{'has-danger': option.errors.finger_id }">
										<label class="form-control-label">Ring Size</label>
										<select class="form-control" :class="{'form-control-danger': option.errors.finger_id}"  v-on:change="fingerSelected(okey,$event)" v-model="option.finger_id">
											<option v-for="opt, key in option.fingers" :value="key" v-if="key == ''" checked>@{{ opt }}</option>
											<option v-for="opt, key in option.fingers" :value="key" >@{{ opt }}</option>
										</select>
										<div class="form-control-feedback" v-if="option.errors.finger_id">This is a required field. Please select a proper ring size.</div>
									</div>
								</div>
								<div v-if="option.inventoryItem.stones">
									<div class="form-group" :class="{'has-danger': option.errors.stone_id }">
										<label class="form-control-label">Stone Type</label>
										<select class="form-control" :class="{'form-control-danger': option.errors.stone_id}" :name="'item['+option.inventoryItem.id+'][stone_id]'" v-on:change="stoneSelected(okey, $event)" v-model="option.stone_id">
												<option v-for="opt, key in option.stone_select" :value="key" v-if="key == ''" checked>@{{ opt }}</option>
												<option v-for="opt, key in option.stone_select" :value="key" else>@{{ opt }}</option>
											</select>
										<div class="form-control-feedback" v-if="option.errors.stone_id">This is a required field. Please select a proper stone type.</div>
									</div>
	

									<div v-if="option.inventoryItem.sizes">

										<div v-for="size, stone_id in option.stone_sizes" v-if="option.stones_compare[option.stone_id] == stone_id">
											<div class="form-group" :class="{'has-danger': option.errors.stone_size_id }">
												<label class="form-control-label">Stone Size</label>
												<select class="form-control" :class="{'form-control-danger': option.errors.stone_size_id}" v-on:change="sizeSelected(okey, $event)" v-model="option.stone_size_id">
													<option v-for="svalue, skey in size" :value="skey" v-if="skey == ''" checked>@{{ svalue }}</option>
													<option v-for="svalue, skey in size" :value="skey" else>@{{ svalue }}</option>
												</select>
												<div class="form-control-feedback" v-if="option.errors.stone_size_id">This is a required field. Please select a proper stone size.</div>
											</div>
	
										</div>
										
									</div>
								</div>
								
								<div v-if="option.inventoryItem.metals">
									<div class="form-group" :class="{'has-danger': option.errors.metal_id }">
										<label class="form-control-label">Metal Type</label>
										<select class="form-control" :class="{'form-control-danger': option.errors.metal_id}" :name="'item['+option.inventoryItem.id+'][metal_id]'" v-on:change="metalSelected(okey, $event)" v-model="option.metal_id">
											<option v-for="opt, key in option.metals" :value="key" v-if="key == ''" checked>@{{ opt }}</option>
											<option v-for="opt, key in option.metals" :value="key" else>@{{ opt }}</option>
										</select>
										<div class="form-control-feedback" v-if="option.errors.metal_id">This is a required field. Please select a proper metal type.</div>
									</div>	
								</div>

								<div class="row-fluid">
									<div class="form-group" :class="{'has-danger': option.errors.subtotal }">
										<label class="form-control-label">Subtotal</label>
										<input :name="'item['+option.inventoryItem.id+'][subtotal]'" :class="{'form-control-danger': option.errors.subtotal}" v-model="option.subtotal" class="form-control" @blur="subtotalUpdate(okey,$event)"/>
										<div class="form-control-feedback" v-if="option.errors.subtotal">This is a required field. Subtotal cannot be a zero value.</div>
									</div>
								</div>
								<button type="button" class="btn btn-danger btn-block" @click="removeItem(okey,$event)">Remove</button>
							</div>

						</div>
					</div>	


					<hr/>
            	</div>
				
	        </div>
	        <div class="table-responsive">
	        	<h3 class="text-center">Totals</h3>
	        	<table class="table table-condensed table-outline">
	        		<tfoot>
	        			<tr>
	        				<td class="text-right">Quantity:&nbsp;</td>
	        				<th>@{{ totals.quantity }}</th>
	        			</tr>
	        			<tr>
	        				<td class="text-right">Subtotal:&nbsp;</td>
	        				<th>@{{ totals.subtotal }}</th>
	        			</tr>
	        			<tr>
	        				<td class="text-right">Tax:&nbsp;</td>
	        				<th>@{{ totals.tax }}</th>
	        			</tr>
	        			<tr>
	        				<td class="text-right">Total:&nbsp;</td>
	        				<th>@{{ totals.total }}</th>
	        			</tr>
	        		</tfoot>
	        	</table>
	        </div>
		</template>

		<template slot = "footer">
			<button type="button" class="btn btn-secondary" @click="back">Back</button>
			<button type="button" class="btn btn-danger" @click="reset">Reset</button>
			<button type="button" class = "btn btn-primary pull-right" @click="next" v-if="stepTwo">Next</button>

			<button type="button" class = "btn btn-default pull-right disabled" v-else @mouseover="validationTwo">Next</button>	
		</template>
	</bootstrap-card>

	<bootstrap-card use-header = "true" use-body="true" use-footer = "true" v-if="current == 3">
		<template slot = "header"> Step 3 - Shipping Information </template>
		<template slot = "body">
            <div class="content">
            	<!-- First Name -->
            	<div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.firstName }">
						<label class="form-control-label">First Name</label>
						<input type="text" required v-model="firstName" name="first_name" class="form-control" :class="{'form-control-danger': errors.firstName}"/>
						<div class="form-control-feedback" v-if="errors.firstName">This is a required field</div>
					</div>
				</div>

                <!-- Last Name -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.lastName }">
						<label class="form-control-label">Last Name</label>
						<input type="text" required v-model="lastName" name="last_name" class="form-control" :class="{'form-control-danger': errors.lastName}"/>
						<div class="form-control-feedback" v-if="errors.lastName">This is a required field</div>
					</div>
				</div>


                <!-- Phone -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.phone }">
						<label class="form-control-label">Phone</label>
						<input type="text" required v-model="phone" name="phone" class="form-control" :class="{'form-control-danger': errors.phone}"/>
						<div class="form-control-feedback" v-if="errors.phone">This is a required field</div>
					</div>
				</div>

                <!-- Email -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.email }">
						<label class="form-control-label">Email</label>
						<input type="email" required v-model="email" name="email" class="form-control" :class="{'form-control-danger': errors.email}"/>
						<div class="form-control-feedback" v-if="errors.email">This is a required field</div>
					</div>
				</div>

                <!-- Street -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.street }">
						<label class="form-control-label">Street</label>
						<input type="text" required v-model="street" name="street" class="form-control" :class="{'form-control-danger': errors.street}"/>
						<div class="form-control-feedback" v-if="errors.street">This is a required field</div>
					</div>
				</div>

                <!-- Suite -->
                <bootstrap-control class="form-group-no-border" 
                    use-label = "true"
 					label = "Suite (optional)">
                    <template slot="control">
                    	<input type="text" v-model="suite" name="suite" class="form-control" />
                    </template>
                </bootstrap-control>

                <!-- City -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.city }">
						<label class="form-control-label">City</label>
						<input type="text" required v-model="city" name="city" class="form-control" :class="{'form-control-danger': errors.city}"/>
						<div class="form-control-feedback" v-if="errors.city">This is a required field</div>
					</div>
				</div>

                <!-- state -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.state }">
						<label class="form-control-label">State</label>
						
						{{ Form::select('state',$states,'',['class'=>'form-control','v-model'=>'state','v-bind:class'=>"{'form-control-danger':errors.state}"]) }}
						<div class="form-control-feedback" v-if="errors.state">This is a required field</div>
					</div>
				</div>

                <!-- country -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.country }">
						<label class="form-control-label">Country</label>
						{{ Form::select('country',$countries,'US',['class'=>'form-control','v-model'=>'country','v-bind:class'=>"{'form-control-danger':errors.country}"]) }}
						<div class="form-control-feedback" v-if="errors.country">This is a required field</div>
					</div>
				</div>


                <!-- Zipcode -->
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.zipcode }">
						<label class="form-control-label">Zipcode</label>
						<input type="text" required v-model="zipcode" name="zipcode" class="form-control" :class="{'form-control-danger': errors.zipcode}"/>
						<div class="form-control-feedback" v-if="errors.zipcode">This is a required field</div>
					</div>
				</div>


	        </div>
		</template>

		<template slot = "footer">
			<button type="button" class="btn btn-secondary" @click="back">Back</button>
			<button type="button" class="btn btn-danger" @click="reset">Reset</button>
			<button type="button" class = "btn btn-primary pull-right" @click="next" v-if="stepThree">Next</button>

			<button type="button" class = "btn btn-default pull-right disabled" v-else @mouseover="validationThree">Next</button>	
		</template>
	</bootstrap-card>

	<bootstrap-card use-header = "true" use-body="true" use-footer = "true" v-if="current == 4">
		<template slot = "header"> Step 4 - Billing & Payment Information </template>
		<template slot = "body">
            <div class="content">
            	<!-- Send Payment Form -->
                <bootstrap-control class="form-group-no-border" >
                    <template slot="control">
                    	<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" checked v-model="sendPaymentForm" @click="validationFour">
							
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description" >I have the customers credit card information.</span>
						</label>
                    </template>
                </bootstrap-control>
                <div v-if="sendPaymentForm">
	            	<!-- Same As Shipping -->
	                <bootstrap-control class="form-group-no-border" >
	                    <template slot="control">
	                    	<label class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" @click="sameAsShipping">
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Same As Shipping?</span>
							</label>
	                    </template>
	                </bootstrap-control>
	            	<!-- Street -->
	            	<div class="row-fluid">
						<div class="form-group" :class="{'has-danger': errors.billingStreet }">
							<label class="form-control-label">Billing Street</label>
							<input type="text" required v-model="billingStreet" name="billing_street" class="form-control" :class="{'form-control-danger': errors.billingStreet}"/>
							<div class="form-control-feedback" v-if="errors.billingStreet">This is a required field</div>
						</div>
					</div>
	                <!-- Suite -->
	                <bootstrap-control class="form-group-no-border" 
	                    use-label = "true"
	 					label = "Suite (optional)">
	                    <template slot="control">
	                    	<input name="billing_suite" type="text" v-model="billingSuite" class="form-control" />
	                    </template>
	                </bootstrap-control>

	                <!-- City -->
	                <div class="row-fluid">
						<div class="form-group" :class="{'has-danger': errors.billingCity }">
							<label class="form-control-label">Billing City</label>
							<input type="text" required v-model="billingCity" name="billing_city" class="form-control" :class="{'form-control-danger': errors.billingCity}"/>
							<div class="form-control-feedback" v-if="errors.billingCity">This is a required field</div>
						</div>
					</div>

	                <!-- state -->
	                <div class="row-fluid">
						<div class="form-group" :class="{'has-danger': errors.billingState }">
							<label class="form-control-label">Billing State</label>
							
							{{ Form::select('billing_state',$states,'',['class'=>'form-control','v-model'=>'billingState','v-bind:class'=>"{'form-control-danger':errors.billingState}"]) }}
							<div class="form-control-feedback" v-if="errors.billingState">This is a required field</div>
						</div>
					</div>

	                <!-- country -->
	                <div class="row-fluid">
						<div class="form-group" :class="{'has-danger': errors.billingCountry }">
							<label class="form-control-label">Billing Country</label>
							{{ Form::select('billing_country',$countries,'US',['class'=>'form-control','v-model'=>'billingCountry','v-bind:class'=>"{'form-control-danger':errors.billingCountry}"]) }}
							<div class="form-control-feedback" v-if="errors.billingCountry">This is a required field</div>
						</div>
					</div>

	                <!-- Zipcode -->
	                <div class="row-fluid">
						<div class="form-group" :class="{'has-danger': errors.billingZipcode }">
							<label class="form-control-label">Billing Zipcode</label>
							<input type="text" required v-model="billingZipcode" name="billingZipcode" class="form-control" :class="{'form-control-danger': errors.billingZipcode}"/>
							<div class="form-control-feedback" v-if="errors.billingZipcode">This is a required field</div>
						</div>
					</div>
				</div>
                <hr/>
				<div class="row-fluid">
				<label>Shipping Type</label>
                    <div class="col-12">
                        
                        <label class="form-control-label">
                            <input type="radio" name="shipping" value="1" checked @click="updateShipping(1)">
                            &nbsp;2 Day
                        </label>
                    </div>

                    <div class="col-12">
                        
                        <label class="form-control-label">
                            <input type="radio" name="shipping" value="2" @click="updateShipping(2)">
                            &nbsp;Next Day
                        </label>
                    </div>

                </div>
                <div class="row-fluid">
					<div class="form-group" :class="{'has-danger': errors.shippingTotal }">
						<label class="form-control-label">Shipping Total</label>
						<div class="input-group">
	                		<input type="text" required v-model="shippingTotal" name="shipping_total" class="form-control" :class="{'form-control-danger': errors.shippingTotal}" @blur="getTotals"/>
	                		<div class="input-group-addon" @click="getTotals">Set</div>
	                	</div>
						<div class="form-control-feedback" v-if="errors.shippingTotal">This is a required field</div>
					</div>
				</div>
                <hr/>
                <div v-if="sendPaymentForm">
	                <!-- card number -->
	                <div class="row-fluid">
						<div class="form-group" :class="{'has-danger': errors.cardNumber }">
							<label class="form-control-label">Card Number</label>
							<input type="text" required v-model="cardNumber" name="card_number" class="form-control" :class="{'form-control-danger': errors.cardNumber}"/>
							<div class="form-control-feedback" v-if="errors.cardNumber">This is a required field</div>
						</div>
					</div>

	                <div class="row">
	                	<!-- expiration month -->
						<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-4" :class="{'has-danger': errors.expMonth }">
							<label class="form-control-label">Expiration Month</label>
							<input type="text" required v-model="expMonth" name="exp_month" class="form-control" :class="{'form-control-danger': errors.expMonth}" maxlength="2"/>
							<div class="form-control-feedback" v-if="errors.expMonth">This is a required field</div>
						</div>
		                <!-- expiration year -->
		                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-4" :class="{'has-danger': errors.expYear }">
							<label class="form-control-label">Expiration Year</label>
							<input type="text" required v-model="expYear" name="exp_year" class="form-control" :class="{'form-control-danger': errors.expYear}" maxlength="4"/>
							<div class="form-control-feedback" v-if="errors.expYear">This is a required field</div>
						</div>
		                <!-- CVV -->
		                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-4" :class="{'has-danger': errors.cvv }">
							<label class="form-control-label">CVV</label>
							<input type="text" required v-model="cvv" name="cvv" class="form-control" :class="{'form-control-danger': errors.cvv}" maxlength="4"/>
							<div class="form-control-feedback" v-if="errors.cvv">This is a required field</div>
						</div>
	                </div>
            	</div>
	        </div>
	        <hr/>
	        <h3 class="text-center">Totals</h3>
	        <div class="table-responsive">
	        	<table class="table table-condensed table-outline">
	        		<tfoot>
	        			<tr>
	        				<td class="text-right">Quantity:&nbsp;</td>
	        				<th>@{{ totals.quantity }}</th>
	        			</tr>
	        			<tr>
	        				<td class="text-right">Subtotal:&nbsp;</td>
	        				<th>@{{ totals.subtotal }}</th>
	        			</tr>
	        			<tr>
	        				<td class="text-right">Tax:&nbsp;</td>
	        				<th>@{{ totals.tax }}</th>
	        			</tr>
	        			<tr>
	        				<td class="text-right">Shipping:&nbsp;</td>
	        				<th>@{{ totals.shipping }}</th>
	        			</tr>
	        			<tr>
	        				<td class="text-right">Total:&nbsp;</td>
	        				<th>@{{ totals.total }}</th>
	        			</tr>
	        		</tfoot>
	        	</table>
	        </div>
		</template>
		<template slot = "footer">
			<button type="button" class="btn btn-secondary" @click="back">Back</button>
			<button type="button" class="btn btn-danger" @click="reset">Reset</button>
			<button type="button" class = "btn btn-success pull-right" v-if="stepFour" data-toggle="modal" data-target="#sendModal">Create</button>
				
			<button type="button" class = "btn btn-success pull-right" v-if="stepFive" data-toggle="modal" data-target="#sendModal">Save & Send Customer Payment Form</button>
			<button type="button" class = "btn btn-default pull-right disabled" v-if="!stepFive && !stepFour" @mouseover="validationFour">Validate</button>
		</template>
	</bootstrap-card>

</div>
@endsection
@section('modals')
<bootstrap-modal id="sendModal" b-size="modal-lg">
	<template slot="header">Creating Invoice</template>
	<template slot="body">
		<label>Progress</label>
		<div class="progress" v-if="!done">
			<div class="progress-bar progress-bar-striped bg-info" role="progressbar" :style="'width:'+progress+'%'" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		<div class="progress" v-if="done">
			<div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
		</div>	
		<label>@{{ progress }}% Complete</label>
		<div v-if="stepFour">
			<!-- Send Email -->
	        <bootstrap-control class="form-group-no-border" >
	            <template slot="control">
	            	<label class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" v-model="setSendEmail" checked>
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">Send Email To Customer?</span>
					</label>
	            </template>
	        </bootstrap-control>
		</div>
		<ul>
			<li class="text-muted" v-if="formStatusOne">Preparing form to create session...</li>
			<li class="text-success" v-if="formStatusOne">Successfully created session!</li>
			<li class="text-muted" v-if="formStatusThree">Authorizing Payment...</li>
			<li class="text-success" v-if="formStatusFour">Successfully made payment transaction!</li>
			<li class="text-muted" v-if="formStatusFive">Saving Invoice Information...</li>
			<li class="text-success" v-if="formStatusSix">Successfully saved invoice information!</li>
			<li class="text-muted" v-if="formStatusSeven">Emailing Customer...</li>
			<li class="text-success" v-if="formStatusEight">Successfully emailed Customer!</li>
			<li class="text-muted" v-if="formStatusNine">Forgetting session and cleaning up form data...</li>
			<li class="text-success" v-if="formStatusTen">Successfully completed all tasks!</li>
		</ul>

		<ul class="text-danger">
			<li v-if="formErrorOne">Could not save session data. Please check your internet connection and try again.</li>
			<li v-if="formErrorTwo">@{{ authorizationErrorMessage }}</li>
			<li v-if="formErrorThree">Error saving invoice</li>
			<li v-if="formErrorFour">Error Sending Email</li>
			<li v-if="formErrorFour">Error removing session. Please manually press reset form to clear.</li>

		</ul>
		
	</template>
	<template slot="footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" @click="makeSession" v-if="formErrors">Try Again</button>
		<button type="button" class="btn btn-primary" @click="makeSession" v-else>Create Invoice</button>
	</template>
</bootstrap-modal>
@endsection
@section('variables')
<div id="variable-root"
	items="{{ (count($inventoryItems) > 0) ? json_encode($inventoryItems) : json_encode([]) }}"
>
	
</div>
@endsection

