const app = new Vue({
	el: '#root',
	data() {
		return {
			inventoryId: '',
			collectionId: '',
			inventories: []
		}
		
	},
	methods: {
		setInventory($event){
    		var option_selected = $($event.target).find('option:selected').val();
    		this.inventoryId = option_selected;
    		
		},
		add(inventoryItemId,collectionId,$event ){
			// get fee info from server and post it to form
			axios.post('/collections/'+collectionId+'/add',{inventory_item_id:inventoryItemId}).then(response => {
				let status = response.data.status;

				if (status == 'fail') {
					alert('Could not set the inventory to the collection. Please try again');
				} else {
					this.inventories = response.data.inventories;
					// set the buttons
					$($event.target).addClass('hide').parents('div:first').find('.remove-set').removeClass('hide');

					// Set the appropraite reactive variables
				}
			});
		},
		remove(inventoryItemId,collectionId,$event) {
			// get fee info from server and post it to form
			axios.post('/collections/'+collectionId+'/remove',{
				inventory_item_id:inventoryItemId
			}).then(response => {
				let status = response.data.status;
				if (status == 'fail') {
					alert('Could not remove the inventory to the collection. Please try again');
				} else {
					this.inventories = response.data.inventories;
					// set the buttons
					$($event.target).addClass('hide').parents('div:first').find('.add-set').removeClass('hide');
					
					// Set the appropraite reactive variables
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

$(document).ready(function() {
	collections.pageLoad();
	collections.events();
});
collections = {
	pageLoad() {
		app.inventories = JSON.parse($("#inventories").val());
		app.collectionId = $("#collection-id").val();
	},
	events: function() {
	}
}