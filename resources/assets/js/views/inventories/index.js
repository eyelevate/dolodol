// import dependency
import * as Sortable from "sortablejs";

// create instance
const app = new Vue({
	el: '#root',
	props: [],
	data: {
		inventories:[],
		newOrder:[]
	},
	methods: {
		setTab(id,key,$event) {
			// Stop default event
			$event.preventDefault();

			// create a variable that we will edit and save again
			var inventories = this.inventories;

			// loop through and set the order
			$.each(inventories, function(index, val) {
				inventories[index].active_state = (index == key) ? true : false; 
			});

			// reestablish variable in data
			this.inventories = inventories;

			// update active class
			$(".tab-pane").removeClass('active');
			$("#item-"+id).addClass('active');
		},
		makeOrderedRows() {
			// set maniuplated variable
			var rows = [];

			// loop through to get current reordered ids
			$(".parsing").each(function(e) {
				var id = $(this).attr('id');
				rows[e] = $(this).attr('id').replace('nav-link-','');
			});

			// set the ids in the global variable
			this.newOrder = rows;
			// send the order
			axios.post('/inventories/reorder',{
				'newOrder':this.newOrder,
			});
		}
	},
	computed: {
	},
	created() {
		
	},
	mounted() {

		if ($("#inventory-list").length > 0) {
			var el =document.getElementById('inventory-list');
			var sortable = new Sortable(el, {

			    onUpdate: function (/**Event*/evt) {
	
	        		// reorder the rows
	 
	        		app.makeOrderedRows()
	        		

	        		
	    		},
			});
		}
		
	}
});

const vars = new Vue({
	el: '#variable-root',
	mounted() {
		app.inventories = JSON.parse(this.$el.attributes.inventories.value);
		app.newOrder = JSON.parse(this.$el.attributes.newOrder.value);
    }
});

