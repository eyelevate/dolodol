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
	}
});

$(document).ready(function(){
	home.pageLoad();
	home.events();
});
home = {
	pageLoad(){
		// google map
		$('#map').on('shown.bs.modal', function () {
		    var map = maps[0].map;
		    var currentCenter = map.getCenter();
		    google.maps.event.trigger(map, "resize");
		    map.setCenter(currentCenter);
		});
	},
	events: function(){
		$('img.lazy').lazyload();
		$(".slip").sliphover();

	},

};