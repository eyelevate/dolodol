const app = new Vue({
	el: '#root',
	props: [],
	data: {
	},
	methods: {
	},
	computed: {

	},
	created() {
		


	},
	mounted() {
		// init Masonry
		$('img.lazy').lazyload({
        	effect: 'fadeIn',
	        load: function() {
	            // Disable trigger on this image
	            $(this).removeClass("not-loaded");
	            $grid.masonry('layout');
	        }
    	});

	}
});
