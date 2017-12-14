const app = new Vue({
	el: '#root',

	data() {
		return {
			dataset: [],
			months: [],
			years: [],
			thisYear: '',
			thisMonth: '',
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
			axios.post('/reports/get-months-from-year',{
				'year': this.thisYear
			}).then(response => {
				if (response.data.status) {
					this.months = response.data.months;
					this.thisMonth = 1;
					this.dataset = response.data.dataset;
					this.invoices = response.data.invoices;
					this.totals = response.data.totals;
					this.make();
				}
			});
		},
		setMonth(){
			// update table from weeks
			axios.post('/reports/update-table-months',{
				'year': this.thisYear,
				'month': this.thisMonth
			}).then(response => {
				if (response.data.status) {
					this.invoices = response.data.invoices;
					this.totals = response.data.totals;
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
		app.months = JSON.parse(this.$el.attributes.months.value);
		app.years = JSON.parse(this.$el.attributes.years.value);
		app.thisYear = this.$el.attributes.thisYear.value;
		app.thisMonth = this.$el.attributes.thisMonth.value;
		app.invoices = JSON.parse(this.$el.attributes.invoices.value);
		app.totals = JSON.parse(this.$el.attributes.totals.value);

	}
});

$(document).ready(function(){
	console.log('page loaded');
	app.make();
});
