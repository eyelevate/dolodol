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
/******/ 	return __webpack_require__(__webpack_require__.s = 528);
/******/ })
/************************************************************************/
/******/ ({

/***/ 528:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(529);


/***/ }),

/***/ 529:
/***/ (function(module, exports) {

var app = new Vue({
	el: '#root',
	data: {
		invoices: []
	},
	methods: {
		updateShipping: function updateShipping(row, $event) {
			id = this.invoices[row].id;
			total = $($event.target).parents('div:first').find('input').val();

			axios.post('/invoices/' + id + '/update-shipping', {
				'total': total
			}).then(function (response) {
				if (response.data.status) {
					$("#subtotal-" + row).html(response.data.subtotal);
					$($event.target).parents('div:first').find('input').val(response.data.shipping);
					$("#tax-" + row).html(response.data.tax);
					$("#total-" + row).html(response.data.total);
					$("#shippingError-" + row).html('');
				} else {
					$("#shippingError-" + row).html(response.data.message);
				}
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
		app.invoices = JSON.parse(this.$el.attributes.invoices.value);
	}
});

/***/ })

/******/ });