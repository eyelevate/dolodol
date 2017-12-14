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
/******/ 	return __webpack_require__(__webpack_require__.s = 538);
/******/ })
/************************************************************************/
/******/ ({

/***/ 538:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(539);


/***/ }),

/***/ 539:
/***/ (function(module, exports) {

var app = new Vue({
	el: '#root',
	data: function data() {
		return {
			inventoryId: '',
			collectionId: '',
			inventories: []
		};
	},

	methods: {
		setInventory: function setInventory($event) {
			var option_selected = $($event.target).find('option:selected').val();
			this.inventoryId = option_selected;
		},
		add: function add(inventoryItemId, collectionId, $event) {
			var _this = this;

			// get fee info from server and post it to form
			axios.post('/collections/' + collectionId + '/add', { inventory_item_id: inventoryItemId }).then(function (response) {
				var status = response.data.status;

				if (status == 'fail') {
					alert('Could not set the inventory to the collection. Please try again');
				} else {
					_this.inventories = response.data.inventories;
					// set the buttons
					$($event.target).addClass('hide').parents('div:first').find('.remove-set').removeClass('hide');

					// Set the appropraite reactive variables
				}
			});
		},
		remove: function remove(inventoryItemId, collectionId, $event) {
			var _this2 = this;

			// get fee info from server and post it to form
			axios.post('/collections/' + collectionId + '/remove', {
				inventory_item_id: inventoryItemId
			}).then(function (response) {
				var status = response.data.status;
				if (status == 'fail') {
					alert('Could not remove the inventory to the collection. Please try again');
				} else {
					_this2.inventories = response.data.inventories;
					// set the buttons
					$($event.target).addClass('hide').parents('div:first').find('.add-set').removeClass('hide');

					// Set the appropraite reactive variables
				}
			});
		}
	},
	computed: {},
	created: function created() {},
	mounted: function mounted() {}
});

$(document).ready(function () {
	collections.pageLoad();
	collections.events();
});
collections = {
	pageLoad: function pageLoad() {
		app.inventories = JSON.parse($("#inventories").val());
		app.collectionId = $("#collection-id").val();
	},

	events: function events() {}
};

/***/ })

/******/ });