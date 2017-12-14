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
	shop.pageLoad();
	shop.events();
});
shop = {
	pageLoad(){

	},
	events: function(){
		$('img.lazy').lazyload();
		$(".slip").sliphover();

	},

};