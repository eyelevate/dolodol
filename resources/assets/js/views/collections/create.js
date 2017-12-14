const app = new Vue({
	el: '#root',
	data() {
		return {

		}
		
	},
	methods: {

	},
	computed: {

	},
	created() {

	},
	mounted() {

	}
});

$(document).ready(function() {
	collections.events();
});
collections = {
	events: function() {
		var upload = require('simple-upload-preview');
		 
		const file = document.querySelector('input[type="file"]'); // <input type="file" /> 
		var image = document.querySelector('#preview'); // <img src="#" id="blah" /> 
		 
		file.addEventListener('change', upload.preview({
		    element: image
		    }, function(err, image) {
		    // image variable is the image element with the file from input sorced. 
		}));
	}
}