const app = new Vue({
	el: '#root',
	data() {
		return {
			quantity:1,
			inventoryItemId:'',
			metalId:'',
			fingerId:'',
			sizeId:'',
			stoneId:'',
			subtotal:'',
			subtotalFormatted:'',
			customPrice: 0
		}
		
	},
	methods: {
		setFinger($event) {
			this.fingerId = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setMetal($event) {
			this.metalId = $($event.target).find('option:selected').val();
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
		setStone($event) {
			this.stoneId = $($event.target).find('option:selected').val();
			this.setSubtotal();
		},
		setCustomPrice($event) {
			this.customPrice = $($event.target).val();
			this.setSubtotal();
		},
		setSubtotal() {
			// get the price subtotal with all options selected
			axios.post('/inventory-items/'+this.inventoryItemId+'/get-subtotal-admins',{
				metal_id:this.metalId,
				stone_id:this.stoneId,
				size_id:this.sizeId,
				quantity:this.quantity,
				item_id: this.inventoryItemId,
				custom_price: this.customPrice
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
		app.subtotalFormatted = this.$el.attributes.subtotal.value;
		app.stoneId = this.$el.attributes.stoneId.value;
		app.metalId = this.$el.attributes.metalId.value;
		app.sizeId = this.$el.attributes.sizeId.value;
		app.fingerId = this.$el.attributes.fingerId.value;
		app.subtotal = this.$el.attributes.subtotal.value;
		console.log(this.$el.attributes.stoneId.value);
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
	},

};