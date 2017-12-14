const app = new Vue({
	el: '#root',
	data() {
		return {
			measurement: 1, // 1 = inches, 2 = centimeters
			quantity:1,
			inventoryItemId:'',
			sizeId:'',
			subtotal:'',
			subtotalFormatted:''
		}
		
	},
	methods: {
		setMeasurement(type) {
			this.measurement = type;
			this.setSubtotal();
		},

		setQuantity($event) {
			this.quantity = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setSize($event) {
			this.sizeId = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setSubtotal() {
			// get the price subtotal with all options selected
			axios.post('/inventory-items/'+this.inventoryItemId+'/get-subtotal',{
				size_id:this.sizeId,
				quantity:this.quantity,
				item_id: this.inventoryItemId,
			}).then(response => {
				this.subtotal = response.data.subtotal;
				this.subtotalFormatted = response.data.subtotal_formatted;
				
				console.log(response.data);
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
		app.inventoryItemId = this.$el.attributes.itemId.value;
		app.subtotal = this.$el.attributes.subtotal.value;
		app.subtotalFormatted = this.$el.attributes.subtotal.value;
		
    }
});
