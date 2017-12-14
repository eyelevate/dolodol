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
/******/ 	return __webpack_require__(__webpack_require__.s = 536);
/******/ })
/************************************************************************/
/******/ ({

/***/ 34:
/***/ (function(module, exports) {

exports.preview = (props, callback) => {
	return function() {
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = (event) => {
				props.element.src = event.target.result;
			}
			reader.readAsDataURL(this.files[0]);
			callback(null, props.element);
		}
	}
}

/***/ }),

/***/ 536:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(537);


/***/ }),

/***/ 537:
/***/ (function(module, exports, __webpack_require__) {

var app = new Vue({
	el: '#root',
	data: function data() {
		return {};
	},

	methods: {},
	computed: {},
	created: function created() {},
	mounted: function mounted() {}
});

$(document).ready(function () {
	collections.events();
});
collections = {
	events: function events() {
		var upload = __webpack_require__(34);

		var file = document.querySelector('input[type="file"]'); // <input type="file" /> 
		var image = document.querySelector('#preview'); // <img src="#" id="blah" /> 

		file.addEventListener('change', upload.preview({
			element: image
		}, function (err, image) {
			// image variable is the image element with the file from input sorced. 
		}));
	}
};

/***/ })

/******/ });