const app = new Vue({
	el: '#root',
	data: {
		invoices: []
	},
	methods: {
		updateShipping(row, $event){
			id = this.invoices[row].id;
			total = $($event.target).parents('div:first').find('input').val();

			axios.post('/invoices/'+id+'/update-shipping',{
				'total':total
			}).then(response => {
				if (response.data.status) {
					$("#subtotal-"+row).html(response.data.subtotal);
					$($event.target).parents('div:first').find('input').val(response.data.shipping);
					$("#tax-"+row).html(response.data.tax);
					$("#total-"+row).html(response.data.total);
					$("#shippingError-"+row).html('');
				} else {
					$("#shippingError-"+row).html(response.data.message);
				}
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

var vars = new Vue({
	el: '#variable-root',
	mounted: function mounted() {
		app.invoices = JSON.parse(this.$el.attributes.invoices.value);
		
	}
});