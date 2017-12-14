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
/******/ 	return __webpack_require__(__webpack_require__.s = 569);
/******/ })
/************************************************************************/
/******/ ({

/***/ 569:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(570);


/***/ }),

/***/ 570:
/***/ (function(module, exports) {

var app = new Vue({
	el: '#root',

	data: function data() {
		return {
			dataset: [],
			weeks: [],
			years: [],
			thisYear: '',
			thisWeek: '',
			invoices: [],
			totals: []
		};
	},

	methods: {
		make: function make() {
			var ctx = document.getElementById("main-chart");
			console.log('running');

			return new Chart(ctx, {
				type: this.dataset.type,
				data: {
					labels: this.dataset.labels,
					datasets: this.dataset.datasets
				},
				options: this.dataset.options
			});
		},
		setYear: function setYear() {
			var _this = this;

			// get weeks from years
			axios.post('/reports/get-weeks-from-year', {
				'year': this.thisYear
			}).then(function (response) {
				if (response.data.status) {
					_this.weeks = response.data.weeks;
					_this.thisWeek = 1;
					_this.dataset = response.data.dataset;
					_this.invoices = response.data.invoices;
					_this.totals = response.data.totals;
					_this.make();
				}
			});
		},
		setWeek: function setWeek() {
			var _this2 = this;

			// update table from weeks
			axios.post('/reports/update-table-weeks', {
				'year': this.thisYear,
				'week': this.thisWeek
			}).then(function (response) {
				if (response.data.status) {
					_this2.invoices = response.data.invoices;
					_this2.totals = response.data.totals;
				}
			});
		}
	},
	computed: {},
	created: function created() {},
	mount: function mount() {}
});

var vars = new Vue({
	el: '#variable-root',
	mounted: function mounted() {
		app.dataset = JSON.parse(this.$el.attributes.dataset.value);
		app.weeks = JSON.parse(this.$el.attributes.weeks.value);
		app.years = JSON.parse(this.$el.attributes.years.value);
		app.thisYear = this.$el.attributes.thisYear.value;
		app.thisWeek = this.$el.attributes.thisWeek.value;
		app.invoices = JSON.parse(this.$el.attributes.invoices.value);
		app.totals = JSON.parse(this.$el.attributes.totals.value);
	}
});

$(document).ready(function () {
	console.log('page loaded');
	app.make();
});

/***/ })

/******/ });