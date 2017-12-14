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
/******/ 	return __webpack_require__(__webpack_require__.s = 555);
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

/***/ 555:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(556);


/***/ }),

/***/ 556:
/***/ (function(module, exports, __webpack_require__) {

var app = new Vue({
	el: '#root',
	data: function data() {
		return {
			sizes: false,
			sizeList: [{
				'name': 'extra-small',
				'x_cm': 0,
				'y_cm': 0,
				'z_cm': 0,
				'subtotal': 0 .toFixed(2),
				'status': true
			}, {
				'name': 'small',
				'x_cm': 0,
				'y_cm': 0,
				'z_cm': 0,
				'subtotal': 0 .toFixed(2),
				'status': true
			}, {
				'name': 'medium',
				'x_cm': 0,
				'y_cm': 0,
				'z_cm': 0,
				'subtotal': 0 .toFixed(2),
				'status': true
			}, {
				'name': 'large',
				'x_cm': 0,
				'y_cm': 0,
				'z_cm': 0,
				'subtotal': 0 .toFixed(2),
				'status': true
			}, {
				'name': 'extra-large',
				'x_cm': 0,
				'y_cm': 0,
				'z_cm': 0,
				'subtotal': 0 .toFixed(2),
				'status': true
			}],
			images: [],
			videos: [],
			video: []
		};
	},

	methods: {
		updateSizes: function updateSizes() {
			if (this.sizes) {
				this.sizes = false;
			} else {
				this.sizes = true;
			}
		},
		updateSizeRow: function updateSizeRow(row) {
			if (this.sizeList[row]['status']) {
				this.sizeList[row]['status'] = false;
			} else {
				this.sizeList[row]['status'] = true;
			}
		},
		primaryImage: function primaryImage(key, $event) {
			images = this.images;
			$.each(images, function (index, val) {
				if (key == index) {

					$(".image-divs").removeClass('bg-success').removeClass('card-inverse').find('.make-primary').removeClass('hide');
					$($event.target).addClass('hide');
					$($event.target).parents('.card:first').addClass('card-inverse').addClass('bg-success');
					images[index]['primary'] = true;
				} else {
					images[index]['primary'] = false;
				}
			});

			// set data
			this.images = images;
		},
		removeImage: function removeImage(key) {
			images = this.images;
			imgs = [];
			$.each(images, function (index, val) {
				if (key !== index) {
					imgs.push(val);
				}
			});

			if (imgs.length == 0) {
				$("#video-uploader").val('');
			}

			// set data
			this.images = imgs;
		},
		setVideos: function setVideos($event) {
			this.video = $($event.target).val();
		},
		removeVideo: function removeVideo(key) {
			videos = this.videos;
			vids = [];
			$.each(videos, function (index, val) {
				if (key !== index) {
					vids.push(val);
				}
			});

			// set data
			this.videos = vids;
		},
		activateRow: function activateRow($event) {
			console.log($($event.target).is(':checked'));
			tr = $($event.target).parents('tr:first');
			if ($($event.target).is(':checked')) {
				tr.removeClass('table-active');
				tr.find('.active-input').removeClass('hide');
				tr.find('.active-button').removeClass('hide');
			} else {
				tr.addClass('table-active');
				tr.find('.active-input').addClass('hide');
				tr.find('.active-button').addClass('hide');
			}
		},
		imageEvents: function imageEvents() {
			// set variables and file input
			var upload = __webpack_require__(34);
			var file = $('input[name="imgs[]"]'); // <input type="file" /> 

			// watch for change in 
			$("#image-parent").on('change', file, function (event) {
				// remove previous variables
				app.images = [];

				// iterate through files and update
				file.each(function () {
					var $input = $(this);
					var inputFiles = this.files;
					if (inputFiles == undefined || inputFiles.length == 0) return;
					$.each(inputFiles, function (index, el) {
						var reader = new FileReader();
						reader.onload = function (event) {

							app.images.push({
								"name": el.name.length > 15 ? el.name.substring(0, 15) + '...' : el.name,
								"primary": false,
								"primary_name": 'primary_image[' + index + ']',
								"src": event.target.result
							});
							$input.next().attr("src", event.target.result);
						};
						reader.onerror = function (event) {
							alert("ERROR: " + event.target.error.code);
						};
						reader.readAsDataURL(el);
					});
				});
			});
		},
		videoEvents: function videoEvents() {
			// set variables and file input
			var upload = __webpack_require__(34);
			var file = $('input[name="videos[]"]'); // <input type="file" /> 

			// watch for change in 
			$("#video-parent").on('change', file, function (event) {
				// remove previous variables
				app.videos = [];

				// iterate through files and update
				file.each(function () {
					var $input = $(this);
					var inputFiles = this.files;
					if (inputFiles == undefined || inputFiles.length == 0) return;
					$.each(inputFiles, function (index, el) {
						console.log(el);
						var reader = new FileReader();
						reader.onload = function (event) {
							app.videos.push({
								"name": el.name.length > 15 ? el.name.substring(0, 15) + '...' : el.name,
								"primary": false,
								"type": el.type,
								"primary_name": 'primary_video[' + index + ']',
								"src": event.target.result
							});
							$input.next().attr("src", event.target.result);
						};
						reader.onerror = function (event) {
							alert("ERROR: " + event.target.error.code);
						};
						reader.readAsDataURL(el);
					});
				});
			});
		},
		submitForm: function submitForm() {
			console.log('here');
			$('#send-form-modal').modal('show');
			$("#item-form").submit();
		}
	},
	computed: {},
	created: function created() {},
	mounted: function mounted() {
		this.imageEvents();
		this.videoEvents();
	}
});

var vars = new Vue({
	el: '#variable-root',
	mounted: function mounted() {}
});

$(document).ready(function () {});

inventory_items = {};

/***/ })

/******/ });