/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 565);
/******/ })
/************************************************************************/
/******/ ({

/***/ 565:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(566);


/***/ }),

/***/ 566:
/***/ (function(module, exports) {

var app = new Vue({
	el: '#root',
	props: [],
	data: {
		invoiceId: '',
		itemName: '',
		searchInventoryCount: 0,
		selectedItems: [],
		selectedOptions: [],
		items: [],
		current: 2,
		firstName: '',
		lastName: '',
		phone: '',
		email: '',
		street: '',
		suite: '',
		city: '',
		state: 'TX',
		country: 'US',
		zipcode: '',
		billingStreet: '',
		billingSuite: '',
		billingCity: '',
		billingState: 'TX',
		billingCountry: 'US',
		billingZipcode: '',
		cardNumber: '',
		expMonth: '',
		expYear: '',
		cvv: '',
		sas: false,
		originalTotals: [],
		totals: [],
		stepOne: true,
		stepTwo: true,
		stepThree: true,
		stepFour: false,
		stepFive: false,
		stepSix: false,
		shipping: 1,
		shippingTotal: 0,
		progress: 0,
		formStatusOne: false,
		formStatusTwo: false,
		formStatusThree: false,
		formStatusFour: false,
		formStatusFive: false,
		formStatusSix: false,
		formStatusSeven: false,
		formStatusEight: false,
		formStatusNine: false,
		formStatusTen: false,
		formStatusEleven: false,
		formStatusTwelve: false,
		formErrorOne: false,
		formErrorTwo: false,
		formErrorThree: false,
		formErrorFour: false,
		formErrorFive: false,
		formWarningRefund: false,
		done: false,
		formErrors: false,
		authorizationErrorMessage: '',
		refundErrorMessage: '',
		paymentResult: null,
		newInvoice: null,
		setSendEmail: true,
		errors: {
			firstName: false,
			lastName: false,
			phone: false,
			email: false,
			street: false,
			city: false,
			state: false,
			country: false,
			zipcode: false,
			billingStreet: false,
			billingCity: false,
			billingState: false,
			billingCountry: false,
			billingZipcode: false,
			cardNumber: false,
			expMonth: false,
			expYear: false,
			cvv: false

		},
		transaction: false,
		transactionId: '',
		sendPaymentForm: true
	},
	methods: {
		searchInventoryItem: function searchInventoryItem() {
			var _this = this;

			// get the price subtotal with all options selected
			axios.post('/inventory-items/find-items', {
				'name': this.itemName,
				'selected': this.selectedItems
			}).then(function (response) {
				if (response.data.status) {
					_this.items = response.data.items;
					_this.searchInventoryCount = response.data.items.length;
				}
			});
		},
		selectedItemOptions: function selectedItemOptions() {
			var _this2 = this;

			// get the price subtotal with all options selected
			axios.post('/inventory-items/get-options', {
				'selected': this.selectedItems
			}).then(function (response) {
				if (response.data.status) {
					_this2.selectedOptions = response.data.selected;
				}
			});
		},
		setSendPaymentForm: function setSendPaymentForm() {
			if (this.sendPaymentForm) {
				this.sendPaymentForm = false;
			} else {
				this.sendPaymentForm = true;
			}
			this.validationFour();
		},
		reset: function reset() {
			var _this3 = this;

			// Completely resets the form
			this.itemName = '';
			this.searchInventoryCount = 0;
			this.selectedItems = [];
			this.selectedOptions = [];
			this.items = [];
			this.current = 2;
			this.firstName = '';
			this.lastName = '';
			this.phone = '';
			this.email = '';
			this.street = '';
			this.suite = '';
			this.city = '';
			this.state = 'TX';
			this.country = 'US';
			this.zipcode = '';
			this.billingStreet = '';
			this.billingSuite = '';
			this.billingCity = '';
			this.billingState = 'TX';
			this.billingCountry = 'US';
			this.billingZipcode = '';
			this.cardNumber = '';
			this.expMonth = '';
			this.expYear = '';
			this.cvv = '';
			this.sas = false;
			this.totals = [];
			this.stepOne = false;
			this.stepTwo = false;
			this.stepThree = false;
			this.stepFour = false;
			this.stepFive = false;
			this.stepSix = false;
			this.shipping = 1;
			this.shippingTotal = 0;
			this.progress = 0;
			this.formStatusOne = false;
			this.formStatusTwo = false;
			this.formStatusThree = false;
			this.formStatusFour = false;
			this.formStatusFive = false;
			this.formStatusSix = false;
			this.formStatusSeven = false;
			this.formStatusEight = false;
			this.formStatusNine = false;
			this.formStatusTen = false;
			this.formStatusEleven = false;
			this.formStatusTwelve = false;
			this.formErrorOne = false;
			this.formErrorTwo = false;
			this.formErrorThree = false;
			this.formErrorFour = false;
			this.formErrorFive = false;
			this.formWarningRefund = false;
			this.done = false;
			this.formErrors = false;
			this.authorizationErrorMessage = '';
			this.refundErrorMessage = '';
			this.paymentResult = null;
			this.newInvoice = null;
			this.setSendEmail = true;
			this.errors = {
				firstName: false,
				lastName: false,
				phone: false,
				email: false,
				street: false,
				city: false,
				state: false,
				country: false,
				zipcode: false,
				billingStreet: false,
				billingCity: false,
				billingState: false,
				billingCountry: false,
				billingZipcode: false,
				cardNumber: false,
				expMonth: false,
				expYear: false,
				cvv: false
			};
			this.transaction = false;
			this.transactionId = '';

			axios.post('/invoices/forget-session').then(function (response) {
				if (response.data.status) {
					_this3.searchInventoryItem();
				}
			});
		},
		back: function back() {
			// Goes back one step on the steppy
			this.current -= 1;
		},
		next: function next() {
			// Goes forward one step on the steppy
			check = true;
			switch (this.current) {
				case 1:
					check = this.validation();
					break;
				case 2:
					check = this.validationTwo();
					break;
				case 3:
					check = this.validationThree();
					break;
				default:
					check = this.validationFour();
					break;
			}
			if (check) {
				this.current += 1;
			}
		},
		selectItem: function selectItem(item_id, $event) {
			// Selects item in step 1

			this.selectedItems.push(item_id);
			this.searchInventoryItem();
			this.selectedItemOptions();
		},
		removeItem: function removeItem(row, $event) {
			// removes item in step 2

			//remove the rows
			rows = [];
			ids = [];
			$.each(this.selectedOptions, function (index, val) {
				if (index != row) {
					rows.push(val);
					ids.push(val.inventoryItem.id);
				}
			});
			this.selectedOptions = rows;
			this.selectedItems = ids;
			this.searchInventoryItem();
			this.getTotals();
		},
		fingerSelected: function fingerSelected(row, $event) {
			// option in step 2
			this.selectedOptions[row]['finger_id'] = $($event.target).find('option:selected').val();
		},
		quantitySelected: function quantitySelected(row, $event) {
			this.selectedOptions[row]['quantity'] = $($event.target).find('option:selected').val();
			this.subtotal(row);
		},
		stoneSelected: function stoneSelected(row, $event) {

			this.selectedOptions[row]['stone_id'] = $($event.target).find('option:selected').val();
			this.selectedOptions[row]['stone_size_id'] = '';
			this.subtotal(row);
		},
		sizeSelected: function sizeSelected(row, $event) {

			this.selectedOptions[row]['stone_size_id'] = $($event.target).find('option:selected').val();
			this.subtotal(row);
		},
		metalSelected: function metalSelected(row, $event) {

			this.selectedOptions[row]['metal_id'] = $($event.target).find('option:selected').val();
			this.subtotal(row);
		},
		subtotalUpdate: function subtotalUpdate(row, $event) {
			this.selectedOptions[row]['subtotal'] = $($event.target).val();
			this.getTotals();
		},
		subtotal: function subtotal(row) {
			var _this4 = this;

			// get the price subtotal with all options selected
			axios.post('/inventory-items/' + this.selectedOptions[row].inventoryItem.id + '/get-subtotal', {
				'quantity': this.selectedOptions[row]['quantity'],
				'metal_id': this.selectedOptions[row]['metal_id'],
				'stone_id': this.selectedOptions[row]['stone_id'],
				'size_id': this.selectedOptions[row]['stone_size_id']

			}).then(function (response) {
				_this4.selectedOptions[row]['subtotal'] = response.data.subtotal;
				_this4.getTotals();
			});
		},
		getTotals: function getTotals() {
			var _this5 = this;

			// get the price subtotal with all options selected
			axios.post('/inventory-items/get-totals-edit', {
				'items': this.selectedOptions,
				'shippingTotal': this.shippingTotal
			}).then(function (response) {
				_this5.totals = response.data.totals;
			});
		},
		sameAsShipping: function sameAsShipping() {
			if (this.sas) {
				this.sas = false;
				this.billingStreet = '';
				this.billingSuite = '';
				this.billingCity = '';
				this.billingState = '';
				this.billingCountry = '';
				this.billingZipcode = '';
			} else {
				this.sas = true;
				this.billingStreet = this.street;
				this.billingSuite = this.suite;
				this.billingCity = this.city;
				this.billingState = this.state;
				this.billingCountry = this.country;
				this.billingZipcode = this.zipcode;
			}
		},
		validationTwo: function validationTwo() {
			var validate = this.selectedOptions;
			this.stepTwo = false;
			checkTwo = true;
			$.each(this.selectedOptions, function (index, val) {
				validate[index].errors.finger_id = false;
				validate[index].errors.metal_id = false;
				validate[index].errors.stone_id = false;
				validate[index].errors.stone_size_id = false;
				validate[index].errors.subtotal = false;
				/* iterate through array or object */
				// determine the rules
				var fingers = val.inventoryItem.fingers;
				var metals = val.inventoryItem.metals;
				var stones = val.inventoryItem.stones;
				var sizes = val.inventoryItem.sizes;
				var email = false;
				if (fingers) {
					if (val.finger_id == null || val.finger_id == '') {
						checkTwo = false;
						validate[index].errors.finger_id = true;
					}
				}

				if (metals) {
					if (val.metal_id == null || val.metal_id == '') {
						checkTwo = false;
						validate[index].errors.metal_id = true;
					}
				}

				if (stones) {

					$.each(val.inventoryItem.item_stone, function (k, v) {
						if (v.id == val.stone_id) {
							email = v.stones.email;
						}
					});
					if (val.stone_id == null || val.stone_id == '') {

						checkTwo = false;
						validate[index].errors.stone_id = true;
					}
					if (!email) {
						if (sizes) {
							if (val.stone_size_id == null || val.stone_size_id == '') {
								checkTwo = false;
								validate[index].errors.stone_size_id = true;
							}
						}
					}
				}

				if (!$.isNumeric(val.subtotal) || $.isNumeric(val.subtotal) && val.subtotal == 0 || val.subtotal == null || val.subtotal == '') {
					checkTwo = false;
					validate[index].errors.subtotal = true;
				}
			});
			if (checkTwo) {
				this.stepTwo = true;
				return true;
			} else {
				return false;
			}
		},
		validationThree: function validationThree() {
			// Step 3
			this.stepThree = true;
			this.errors.firstName = false;
			this.errors.lastName = false;
			this.errors.phone = false;
			this.errors.email = false;
			this.errors.street = false;
			this.errors.city = false;
			this.errors.state = false;
			this.errors.country = false;
			this.errors.zipcode = false;

			if (this.firstName == '') {
				this.errors.firstName = true;
				this.stepThree = false;
			}
			if (this.lastName == '') {
				this.errors.lastName = true;
				this.stepThree = false;
			}
			if (this.phone == '') {
				this.errors.phone = true;
				this.stepThree = false;
			}
			if (this.email == '') {
				this.errors.email = true;
				this.stepThree = false;
			}
			if (this.street == '') {
				this.errors.street = true;
				this.stepThree = false;
			}
			if (this.city == '') {
				this.errors.city = true;
				this.stepThree = false;
			}
			if (this.state == '') {
				this.errors.state = true;
				this.stepThree = false;
			}
			if (this.country == '') {
				this.errors.country = true;
				this.stepThree = false;
			}
			if (this.zipcode == '') {
				this.errors.zipcode = true;
				this.stepThree = false;
			}

			if (this.stepThree) {
				return true;
			}

			return false;
		},
		validationFour: function validationFour() {
			this.getTotals();
			// Step 4
			this.stepFour = false;
			this.stepFive = false;
			this.stepSix = false;
			this.errors.billingStreet = false;
			this.errors.billingCity = false;
			this.errors.billingState = false;
			this.errors.billingCountry = false;
			this.errors.billingZipcode = false;
			this.errors.cardNumber = false;
			this.errors.expMonth = false;
			this.errors.expYear = false;
			this.errors.cvv = false;

			if (!this.sendPaymentForm) {
				// first check to see if the new totals = the original totals
				if (parseFloat(this.totals._total).toFixed(2) - parseFloat(this.originalTotals._total).toFixed(2) == 0) {
					// update the form only

					this.stepFour = true;

					return true;
				} else {
					this.stepSix = true;
					return true;
				}
			} else {
				if (this.billingStreet == '') {
					this.errors.billingStreet = true;
					this.stepFour = false;
				}
				if (this.billingCity == '') {
					this.errors.billingCity = true;
					this.stepFour = false;
				}
				if (this.billingState == '') {
					this.errors.billingState = true;
					this.stepFour = false;
				}
				if (this.billingCountry == '') {
					this.errors.billingCountry = true;
					this.stepFour = false;
				}
				if (this.billingZipcode == '') {
					this.errors.billingZipcode = true;
					this.stepFour = false;
				}

				// first check to see if the new totals = the original totals
				if (this.transaction == "") {
					this.stepFive = true;
					return true;
				} else if (parseFloat(this.totals._total).toFixed(2) - parseFloat(this.originalTotals._total).toFixed(2) == 0) {
					// update the form only

					this.stepFour = true;

					return true;
				} else {
					if (!$.isNumeric(this.shippingTotal) || this.shippingTotal == null || this.shippingTotal == '') {
						this.shippingTotal = 0;
					}

					var cardReady = true;
					if (this.cardNumber == '') {
						cardReady = false;
						this.errors.cardNumber = true;
					}
					if (this.expMonth == '') {
						cardReady = false;
						this.errors.expMonth = true;
					}
					if (this.expYear == '') {
						cardReady = false;
						this.errors.expYear = true;
					}

					if (this.cvv == '') {
						cardReady = false;
						this.errors.cvv = true;
					}

					this.stepFive = true;
					return true;
				}
			}

			return false;
		},
		validation: function validation() {
			// Step 1
			this.stepOne = false;
			if (this.selectedItems.length > 0) {
				this.stepOne = true;
			}
		},
		updateShipping: function updateShipping(shipping) {
			if (shipping == 1) {
				this.shippingTotal = 0;
			}

			this.shipping = shipping;

			options = this.selectedOptions;
			$.each(options, function (index, val) {
				options[index]['shipping'] = shipping;
			});

			this.selectedOptions = options;

			this.getTotals();
		},
		makeSession: function makeSession() {
			var _this6 = this;

			this.progress = 0;
			this.formStatusOne = true;
			this.resetSendingForm();
			try {
				axios.post('/invoices/make-session', {
					'selected_options': this.selectedOptions,
					'first_name': this.firstName,
					'last_name': this.lastName,
					'phone': this.phone,
					'email': this.email,
					'street': this.street,
					'suite': this.suite,
					'city': this.city,
					'state': this.state,
					'country': this.country,
					'zipcode': this.zipcode,
					'billing_street': this.billingStreet,
					'billing_suite': this.billingSuite,
					'billing_city': this.billingCity,
					'billing_state': this.billingState,
					'billing_zipcode': this.billingZipcode,
					'card_number': this.cardNumber,
					'exp_month': this.expMonth,
					'exp_year': this.expYear,
					'cvv': this.cvv,
					'item_name': this.itemName,
					'search_inventory_count': this.searchInventoryCount,
					'selected_items': this.selectedItems,
					'items': this.items,
					'current': this.current,
					'sas': this.sas,
					'totals': this.totals,
					'shipping': this.shipping
				}).then(function (response) {
					if (response.data.status) {
						// update the progress
						_this6.progress = 10;
						_this6.formStatusTwo = true;

						// check which form to run next
						if (_this6.stepFour) {
							//update only so skip to step 5
							_this6.update();
						} else {
							_this6.refundPayment();
						}
					} else {
						_this6.formErrors = true;
						_this6.formErrorOne = true;
					}
				});
			} catch (e) {
				this.formErrors = true;
				this.formErrorOne = true;
			}
		},
		refundPayment: function refundPayment() {
			var _this7 = this;

			this.progress = 20;
			this.formStatusThree = true;
			try {
				axios.post('/invoices/' + this.invoiceId + '/refund-payment').then(function (response) {
					if (response.data.status) {
						_this7.formStatusFour = true;
						_this7.progress = 30;
					} else {
						_this7.formErrors = true;
						_this7.formWarningRefund = true;
						_this7.refundErrorMessage = response.data.message;
						_this7.paymentResult = null;
					}
					if (_this7.stepFour) {
						_this7.update();
						return true;
					} else {
						if (_this7.sendPaymentForm) {

							_this7.authorizePayment();
							return true;
						} else {
							_this7.update();
							return true;
						}
					}
				});
			} catch (e) {
				this.formErrors = true;
				this.formWarningRefund = true;
			}
		},
		authorizePayment: function authorizePayment() {
			var _this8 = this;

			this.progress = 50;
			this.formStatusSeven = true;
			try {
				axios.post('/invoices/authorize-payment').then(function (response) {
					if (response.data.status) {
						_this8.formStatusEight = true;
						_this8.progress = 60;
						_this8.paymentResult = response.data.result;
						_this8.update();
					} else {
						_this8.formErrors = true;
						_this8.formErrorTwo = true;
						_this8.authorizationErrorMessage = response.data.message;
						_this8.paymentResult = null;
					}
				});
			} catch (e) {
				this.formErrors = true;
				this.formErrorTwo = true;
				this.paymentResult = null;
			}
		},
		update: function update() {
			var _this9 = this;

			// TODO
			this.progress = 35;
			this.formStatusFive = true;
			try {
				axios.post('/invoices/' + this.invoiceId + '/update', {
					'result': this.paymentResult
				}).then(function (response) {
					if (response.data.status) {
						_this9.formStatusSix = true;
						_this9.progress = 45;
						_this9.newInvoice = response.data.invoice;
						if (_this9.stepFour) {
							if (_this9.setSendEmail) {
								_this9.sendEmail();
							} else {
								_this9.forgetSession();
							}
						} else {
							if (_this9.paymentResult != null) {
								_this9.sendEmail();
							} else if (_this9.setSendPaymentForm) {
								_this9.pushPaymentFormEmail();
							} else {
								_this9.forgetSession();
							}
						}
					} else {
						_this9.formErrors = true;
						_this9.formErrorThree = true;
						_this9.newInvoice = null;
					}
				});
			} catch (e) {
				this.formErrors = true;
				this.formErrorThree = true;
				this.newInvoice = null;
			}
		},
		pushPaymentFormEmail: function pushPaymentFormEmail() {
			var _this10 = this;

			this.progress = 70;
			this.formStatusNine = true;
			invoice_id = this.invoiceId;
			var send = '/invoices/' + invoice_id + '/push-email-form';
			try {
				axios.post(send, {
					'new_invoice': this.newInvoice,
					'email_address': this.email
				}).then(function (response) {
					if (response.data.status) {
						_this10.formStatusTen = true;
						_this10.progress = 80;
						_this10.forgetSession();
					} else {
						_this10.formErrors = true;
						_this10.formErrorFour = true;
					}
				});
			} catch (e) {
				// statements
				this.formErrors = true;
				this.formErrorFour = true;
			}
		},
		sendEmail: function sendEmail() {
			var _this11 = this;

			this.progress = 70;
			this.formStatusNine = true;
			try {
				axios.post('/invoices/push-email', {
					'new_invoice': this.newInvoice,
					'email_address': this.email
				}).then(function (response) {
					if (response.data.status) {
						_this11.formStatusTen = true;
						_this11.progress = 80;
						_this11.forgetSession();
					} else {
						_this11.formErrors = true;
						_this11.formErrorFour = true;
					}
				});
			} catch (e) {
				// statements
				this.formErrors = true;
				this.formErrorFour = true;
			}
		},
		forgetSession: function forgetSession() {
			var _this12 = this;

			this.progress = 90;
			this.formStatusNine = true;
			try {
				axios.post('/invoices/forget-session').then(function (response) {
					if (response.data.status) {
						_this12.formStatusTen = true;
						_this12.progress = 100;
						_this12.done = true;
						_this12.formErrors = false;
						// send user back to page
						// window.location.replace('/invoices');
					} else {
						_this12.formErrors = true;
						_this12.formErrorFive = true;
					}
				});
			} catch (e) {
				this.formErrors = true;
				this.formErrorFive = true;
			}
		},
		resetSendingForm: function resetSendingForm() {
			this.progress = 0;
			this.formStatusOne = false;
			this.formStatusTwo = false;
			this.formStatusThree = false;
			this.formStatusFour = false;
			this.formStatusFive = false;
			this.formStatusSix = false;
			this.formStatusSeven = false;
			this.formStatusEight = false;
			this.formStatusNine = false;
			this.formStatusTen = false;
			this.formErrorOne = false;
			this.formErrorTwo = false;
			this.formErrorThree = false;
			this.formErrorFour = false;
			this.formErrorFive = false;
			this.done = false;
		}
	},
	computed: {},
	created: function created() {},
	mounted: function mounted() {}
});
var vars = new Vue({
	el: '#variable-root',
	mounted: function mounted() {
		app.invoiceId = this.$el.attributes.invoiceId.value;
		app.items = JSON.parse(this.$el.attributes.items.value);
		app.searchInventoryCount = app.items.length;
		app.firstName = this.$el.attributes.firstName.value;
		app.lastName = this.$el.attributes.lastName.value;
		app.phone = this.$el.attributes.phone.value;
		app.email = this.$el.attributes.email.value;
		app.street = this.$el.attributes.street.value;
		app.suite = this.$el.attributes.suite.value;
		app.city = this.$el.attributes.city.value;
		app.state = this.$el.attributes.state.value;
		app.country = this.$el.attributes.country.value;
		app.zipcode = this.$el.attributes.zipcode.value;
		app.billingStreet = this.$el.attributes.billingStreet.value;
		app.billingSuite = this.$el.attributes.billingSuite.value;
		app.billingCity = this.$el.attributes.billingCity.value;
		app.billingState = this.$el.attributes.billingState.value;
		app.billingCountry = this.$el.attributes.billingCountry.value;
		app.billingZipcode = this.$el.attributes.billingZipcode.value;
		app.expMonth = this.$el.attributes.expMonth.value;
		app.expYear = this.$el.attributes.expYear.value;
		app.selectedOptions = JSON.parse(this.$el.attributes.selectedOptions.value);
		app.selectedItems = JSON.parse(this.$el.attributes.selectedItems.value);
		app.shipping = this.$el.attributes.shipping.value;
		app.shippingTotal = this.$el.attributes.shippingTotal.value;
		app.totals = JSON.parse(this.$el.attributes.totals.value);
		app.originalTotals = JSON.parse(this.$el.attributes.originalTotals.value);
		app.transaction = this.$el.attributes.transaction.value ? true : false;
		app.sendPaymentForm = app.transaction ? true : false;
		app.transactionId = this.$el.attributes.transactionId.value;
		app.searchInventoryItem();
		app.validation();
	}
});

$(document).ready(function () {
	invoices.pageLoad();
	invoices.events();
});

invoices = {
	pageLoad: function pageLoad() {},

	events: function events() {}

};

/***/ })

/******/ });