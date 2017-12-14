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
/******/ 	return __webpack_require__(__webpack_require__.s = 567);
/******/ })
/************************************************************************/
/******/ ({

/***/ 567:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(568);


/***/ }),

/***/ 568:
/***/ (function(module, exports) {

var app = new Vue({
	el: '#root',
	data: function data() {
		return {
			quantity: 1,
			inventoryItemId: '',
			metalId: '',
			fingerId: '',
			sizeId: '',
			stoneId: '',
			subtotal: '',
			subtotalFormatted: '',
			customPrice: 0
		};
	},

	methods: {
		setFinger: function setFinger($event) {
			this.fingerId = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setMetal: function setMetal($event) {
			this.metalId = $($event.target).find('option:selected').val();
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
		setStone: function setStone($event) {
			this.stoneId = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setCustomPrice: function setCustomPrice($event) {
			this.customPrice = $($event.target).val();
			this.setSubtotal();
		},
		setSubtotal: function setSubtotal() {
			var _this = this;

			// get the price subtotal with all options selected
			axios.post('/inventory-items/' + this.inventoryItemId + '/get-subtotal-admins', {
				metal_id: this.metalId,
				stone_id: this.stoneId,
				size_id: this.sizeId,
				quantity: this.quantity,
				item_id: this.inventoryItemId,
				custom_price: this.customPrice
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
		app.subtotalFormatted = this.$el.attributes.subtotal.value;
		app.stoneId = this.$el.attributes.stoneId.value;
		app.metalId = this.$el.attributes.metalId.value;
		app.sizeId = this.$el.attributes.sizeId.value;
		app.fingerId = this.$el.attributes.fingerId.value;
		app.subtotal = this.$el.attributes.subtotal.value;
		console.log(this.$el.attributes.stoneId.value);
	}
});

$(document).ready(function () {
	checkout.pageLoad();
	checkout.events();
});
checkout = {
	pageLoad: function pageLoad() {},

	events: function events() {}

};

/***/ })

/******/ });