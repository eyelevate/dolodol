const app = new Vue({
	el: '#root',
	props: [],
	data: {
		totals: []
	},
	methods: {
		removeRow($event, $row) {
			var remove = $($event.target);
			

			// get the price subtotal with all options selected
			axios.post('/inventory-items/delete-cart-item',{
				'row':$row,
			}).then(response => {

				remove.parents('.item').remove();
				this.totals = response.data.totals;
				$(".cart-number").html(response.data.remaining);
			});
		}
	},
	computed: {
	},
	created() {
	},
	mounted() {
	}
});


const vars = new Vue({
	el: '#variable-root',
	mounted() {
		app.totals = JSON.parse(this.$el.attributes.totals.value);
    }
});

$(document).ready(function(){
	cart.pageLoad();
	cart.events();
});
cart = {
	pageLoad(){

	},
	events: function(){
		$('img.lazy').lazyload();
		$(".slip").sliphover();

	},

};