const app = new Vue({
	el: '#root',
	props: [],
	data: {
		totals: [],
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
			});
		},
		updateShipping(shipping) {
			// get the price subtotal with all options selected
			axios.post('/update-shipping-finish',{
				'shipping':shipping
			}).then(response => {

				this.totals = response.data.totals;
				

			});
		},
		sameAsShipping($event) {

			street = $("input[name='street']").val();
			suite = $("input[name='suite']").val();
			city = $("input[name='city']").val();
			state = $("select[name='state']").find('option:selected').val();
			country = $("select[name='country']").find('option:selected').val();
			zipcode = $("input[name='zipcode']").val();

			$("input[name='billing_street']").val(($($event.target).is(':checked')) ? street : '');
			$("input[name='billing_suite']").val(($($event.target).is(':checked')) ? suite : '');
			$("input[name='billing_city']").val(($($event.target).is(':checked')) ? city : '');
			$("select[name='billing_state']").val(($($event.target).is(':checked')) ? state : '');
			$("select[name='billing_country']").val(($($event.target).is(':checked')) ? country : '');
			$("input[name='billing_zipcode']").val(($($event.target).is(':checked')) ? zipcode : '');
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
	checkout.pageLoad();
	checkout.events();
});
checkout = {
	pageLoad(){

	},
	events: function(){
		$('img.lazy').lazyload();
		$(".slip").sliphover();

	},

};