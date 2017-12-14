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
/******/ 	return __webpack_require__(__webpack_require__.s = 548);
/******/ })
/************************************************************************/
/******/ ({

/***/ 548:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(549);


/***/ }),

/***/ 549:
/***/ (function(module, exports) {

var app = new Vue({
	el: '#root',
	props: [],
	data: {
		totals: [],
		email: '',
		pw: '',
		remember: false,
		checkShipping: true,
		shipping: 1
	},
	methods: {
		removeRow: function removeRow($event, $row) {
			var _this = this;

			var remove = $($event.target);

			// get the price subtotal with all options selected
			axios.post('/inventory-items/delete-cart-item', {
				'row': $row
			}).then(function (response) {

				remove.parents('.item').remove();
				_this.totals = response.data.totals;
				$(".cart-number").html(response.data.remaining);
			});
		},
		validateAddress: function validateAddress() {
			// get the price subtotal with all options selected
			axios.post('/address-validate', {
				'street': this.street,
				'suite': this.suite,
				'city': this.city,
				'state': this.state,
				'zipcode': this.zipcode
			}).then(function (response) {

				var rate = response.data.rate.rate;
				var rate_formatted = response.data.rate.rate_formatted;
			});
		},
		updateShipping: function updateShipping(shipping) {
			var _this2 = this;

			// get the price subtotal with all options selected
			axios.post('/update-shipping', {
				'shipping': shipping
			}).then(function (response) {

				_this2.totals = response.data.totals;
				_this2.checkShipping = _this2.shipping == "1" ? true : false;
			});
		},
		sameAsShipping: function sameAsShipping($event) {

			street = $("input[name='street']").val();
			suite = $("input[name='suite']").val();
			city = $("input[name='city']").val();
			state = $("select[name='state']").find('option:selected').val();
			country = $("select[name='country']").find('option:selected').val();
			zipcode = $("input[name='zipcode']").val();

			$("input[name='billing_street']").val($($event.target).is(':checked') ? street : '');
			$("input[name='billing_suite']").val($($event.target).is(':checked') ? suite : '');
			$("input[name='billing_city']").val($($event.target).is(':checked') ? city : '');
			$("select[name='billing_state']").val($($event.target).is(':checked') ? state : '');
			$("select[name='billing_country']").val($($event.target).is(':checked') ? country : '');
			$("input[name='billing_zipcode']").val($($event.target).is(':checked') ? zipcode : '');
		},
		attemptLogin: function attemptLogin() {
			// get the price subtotal with all options selected
			axios.post('/attempt-login', {
				'email': this.email,
				'password': this.pw,
				'remember': this.remember
			}).then(function (response) {

				if (response.data.status) {
					// Refresh Page
					location.reload();
				} else {
					// show errors
					alert(response.data.message);
				}
			});
		}
	},
	computed: {},
	created: function created() {},
	mounted: function mounted() {
		this.updateShipping();
	}
});

var vars = new Vue({
	el: '#variable-root',
	mounted: function mounted() {
		app.totals = JSON.parse(this.$el.attributes.totals.value);
	}
});

$(document).ready(function () {
	checkout.pageLoad();
	checkout.events();
});
checkout = {
	pageLoad: function pageLoad() {},

	events: function events() {
		$('img.lazy').lazyload();
		$(".slip").sliphover();
	}

};

/***/ })

/******/ });