const app = new Vue({
	el: '#root',
	data() {
		return {
			sizes:false,
			sizeList:[
				{
					'name':'extra-small',
					'x_cm':0,
					'y_cm':0,
					'z_cm':0,
					'subtotal':(0).toFixed(2),
					'status':true
				}, {
					'name':'small',
					'x_cm':0,
					'y_cm':0,
					'z_cm':0,
					'subtotal':(0).toFixed(2),
					'status':true
				}, {
					'name':'medium',
					'x_cm':0,
					'y_cm':0,
					'z_cm':0,
					'subtotal':(0).toFixed(2),
					'status':true
				}, {
					'name':'large',
					'x_cm':0,
					'y_cm':0,
					'z_cm':0,
					'subtotal':(0).toFixed(2),
					'status':true
				}, {
					'name':'extra-large',
					'x_cm':0,
					'y_cm':0,
					'z_cm':0,
					'subtotal':(0).toFixed(2),
					'status':true
				}
			],
			images:[],
			videos:[],
			video:[]
		}
		
	},
	methods: {
		updateSizes() {
			if(this.sizes) {
				this.sizes = false;
			} else {
				this.sizes = true;
			}
		},
		updateSizeRow(row) {
			if(this.sizeList[row]['status']) {
				this.sizeList[row]['status'] = false;
			} else {
				this.sizeList[row]['status'] = true;
			}
		},
		primaryImage(key, $event){
			images = this.images;
			$.each(images, function(index, val) {
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
		removeImage(key){
			images = this.images;
			imgs = [];
			$.each(images, function(index, val) {
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
		setVideos($event) {
			this.video = $($event.target).val();

		},
		removeVideo(key){
			videos = this.videos;
			vids = [];
			$.each(videos, function(index, val) {
				if (key !== index) {
					vids.push(val);
				}
			});

			// set data
			this.videos = vids;
		},
		activateRow($event) {
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
		imageEvents(){
			// set variables and file input
			var upload = require('simple-upload-preview');
			var file = $('input[name="imgs[]"]'); // <input type="file" /> 

			// watch for change in 
			$("#image-parent").on('change', file, function(event) {
				// remove previous variables
				app.images = [];

				// iterate through files and update
				file.each(function() {
			        var $input = $(this);
			        var inputFiles = this.files;
			        if(inputFiles == undefined || inputFiles.length == 0) return;
			        $.each(inputFiles,function(index, el) {
			        	var reader = new FileReader();
				        reader.onload = function(event) {

				        	app.images.push({
				        		"name": (el.name.length > 15) ? el.name.substring(0,15) + '...' :  el.name,
				        		"primary":false,
				        		"primary_name":'primary_image['+index+']',
				        		"src":event.target.result
				        	});
				            $input.next().attr("src", event.target.result);
				        };
				        reader.onerror = function(event) {
				            alert("ERROR: " + event.target.error.code);
				        };
				        reader.readAsDataURL(el);
			        });
			    });

			});
		},
		videoEvents() {
			// set variables and file input
			var upload = require('simple-upload-preview');
			var file = $('input[name="videos[]"]'); // <input type="file" /> 

			// watch for change in 
			$("#video-parent").on('change', file, function(event) {
				// remove previous variables
				app.videos = [];

				// iterate through files and update
				file.each(function() {
			        var $input = $(this);
			        var inputFiles = this.files;
			        if(inputFiles == undefined || inputFiles.length == 0) return;
			        $.each(inputFiles,function(index, el) {
			        	console.log(el);
			        	var reader = new FileReader();
				        reader.onload = function(event) {
				        	app.videos.push({
				        		"name": (el.name.length > 15) ? el.name.substring(0,15) + '...' :  el.name,
				        		"primary":false,
				        		"type":el.type,
				        		"primary_name":'primary_video['+index+']',
				        		"src":event.target.result
				        	});
				            $input.next().attr("src", event.target.result);
				        };
				        reader.onerror = function(event) {
				            alert("ERROR: " + event.target.error.code);
				        };
				        reader.readAsDataURL(el);
			        });
			    });

			});
		},

		submitForm(){
			console.log('here');
			$('#send-form-modal').modal('show');
			$( "#item-form" ).submit();
		}
	},
	computed: {

	},
	created() {

	},
	mounted() {
		this.imageEvents();
		this.videoEvents();
	}
});

const vars = new Vue({
	el: '#variable-root',
	mounted() {

    }
});


$(document).ready(function() {

});



inventory_items = {
	
}