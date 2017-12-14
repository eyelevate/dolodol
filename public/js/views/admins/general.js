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
/******/ 	return __webpack_require__(__webpack_require__.s = 524);
/******/ })
/************************************************************************/
/******/ ({

/***/ 524:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(525);


/***/ }),

/***/ 525:
/***/ (function(module, exports) {

var base = new Vue({
	el: '#aside-root',
	data: {
		count: 0,
		archivedCount: 0,
		firstMessages: [],
		secondMessages: []
	},
	methods: {
		prepareData: function prepareData(data) {
			var countFirst = 0;
			var countSecond = 0;
			var firstMessages = {};
			var secondMessages = {};
			$.each(data['first'], function (index, val) {
				$.each(val, function (k, v) {
					countFirst++;
				});

				key = index > 0 ? index + ' day(s) ago' : 'Today';

				firstMessages[key] = val;
			});
			$.each(data['second'], function (index, val) {
				$.each(val, function (k, v) {
					countSecond++;
				});
				key = index > 0 ? index + ' day(s) ago' : 'Today';
				secondMessages[key] = val;
			});

			this.firstMessages = firstMessages;
			this.secondMessages = secondMessages;
			this.count = countFirst;
			this.archivedCount = countSecond;
		},
		markAsRead: function markAsRead(id) {
			var _this = this;

			// mark the message as read
			axios.post('/contact/' + id + '/mark-as-read').then(function (response) {
				if (response.data.status) {
					_this.prepareData(response.data.set);
					_this.setNavCount();
				}
			});
		},
		setAsArchive: function setAsArchive(id) {
			var _this2 = this;

			// set message as Archive
			axios.post('/contact/' + id + '/set-as-archive').then(function (response) {
				if (response.data.status) {
					_this2.prepareData(response.data.set);
					_this2.setNavCount();
				}
			});
		},
		setAsDeleted: function setAsDeleted(id) {
			var _this3 = this;

			// set message as Archive
			axios.post('/contact/' + id + '/set-as-deleted').then(function (response) {
				if (response.data.status) {
					_this3.prepareData(response.data.set);
					_this3.setNavCount();
				}
			});
		},
		setNavCount: function setNavCount() {
			// set nav count
			$("#navCount").html(this.count);
		}
	},
	computed: {},
	created: function created() {},
	mounted: function mounted() {
		// modal
		// set variables for saving
		var set = JSON.parse($("#aside-root").attr('data'));
		this.prepareData(set);
	}
});

$(document).ready(function () {
	bootstrap.events();
});

bootstrap = {
	events: function events() {
		$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

		$('.table-responsive').on('show.bs.dropdown', function () {
			$('.table-responsive').css("overflow", "inherit");
		});

		$('.table-responsive').on('hide.bs.dropdown', function () {
			$('.table-responsive').css("overflow", "auto");
		});
	}
};

/***/ })

/******/ });