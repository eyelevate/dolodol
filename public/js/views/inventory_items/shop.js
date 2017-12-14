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
/******/ 	return __webpack_require__(__webpack_require__.s = 559);
/******/ })
/************************************************************************/
/******/ ({

/***/ 559:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(560);


/***/ }),

/***/ 560:
/***/ (function(module, exports) {

var app = new Vue({
	el: '#root',
	data: function data() {
		return {
			measurement: 1, // 1 = inches, 2 = centimeters
			quantity: 1,
			inventoryItemId: '',
			sizeId: '',
			subtotal: '',
			subtotalFormatted: ''
		};
	},

	methods: {
		setMeasurement: function setMeasurement(type) {
			this.measurement = type;
			this.setSubtotal();
		},
		setQuantity: function setQuantity($event) {
			this.quantity = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setSize: function setSize($event) {
			this.sizeId = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setSubtotal: function setSubtotal() {
			var _this = this;

			// get the price subtotal with all options selected
			axios.post('/inventory-items/' + this.inventoryItemId + '/get-subtotal', {
				size_id: this.sizeId,
				quantity: this.quantity,
				item_id: this.inventoryItemId
			}).then(function (response) {
				_this.subtotal = response.data.subtotal;
				_this.subtotalFormatted = response.data.subtotal_formatted;

				console.log(response.data);
			});
		}
	},
	computed: {},
	created: function created() {},
	mounted: function mounted() {}
});
var vars = new Vue({
	el: '#variable-root',
	mounted: function mounted() {
		app.inventoryItemId = this.$el.attributes.itemId.value;
		app.subtotal = this.$el.attributes.subtotal.value;
		app.subtotalFormatted = this.$el.attributes.subtotal.value;
	}
});

/***/ })

/******/ });