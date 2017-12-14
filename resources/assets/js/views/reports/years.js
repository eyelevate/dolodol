const app = new Vue({
	el: '#root',

	data() {
		return {
			dataset: [],
			years: [],
			thisYear: '',
			invoices:[],
			totals:[]
		}
		
	},
	methods: {
		make() {
			var ctx = document.getElementById("main-chart");
			console.log('running');

			return new Chart(ctx, {
				type: this.dataset.type,
				data: {
					labels: this.dataset.labels,
					datasets: this.dataset.datasets
				},
				options: this.dataset.options
			});
		},
		setYear(){
			// get weeks from years
			axios.post('/reports/get-years',{
				'year': this.thisYear
			}).then(response => {
				if (response.data.status) {
					this.dataset = response.data.dataset;
					this.invoices = response.data.invoices;
					this.totals = response.data.totals;
					this.make();
				}
			});
		}
	},
	computed: {

	},
	created() {

	},
	mount() {
		
	
	}
});

var vars = new Vue({
	el: '#variable-root',
	mounted: function mounted() {
		app.dataset = JSON.parse(this.$el.attributes.dataset.value);
		app.years = JSON.parse(this.$el.attributes.years.value);
		app.thisYear = this.$el.attributes.thisYear.value;
		app.invoices = JSON.parse(this.$el.attributes.invoices.value);
		app.totals = JSON.parse(this.$el.attributes.totals.value);

	}
});

$(document).ready(function(){
	console.log('page loaded');
	app.make();
});
