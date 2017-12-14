const app = new Vue({
	el: '#root',

	data() {
		return {
			dataset: [],
			weeks: [],
			years: [],
			thisYear: '',
			thisWeek: '',
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
			axios.post('/reports/get-weeks-from-year',{
				'year': this.thisYear
			}).then(response => {
				if (response.data.status) {
					this.weeks = response.data.weeks;
					this.thisWeek = 1;
					this.dataset = response.data.dataset;
					this.invoices = response.data.invoices;
					this.totals = response.data.totals;
					this.make();
				}
			});
		},
		setWeek(){
			// update table from weeks
			axios.post('/reports/update-table-weeks',{
				'year': this.thisYear,
				'week': this.thisWeek
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
		app.weeks = JSON.parse(this.$el.attributes.weeks.value);
		app.years = JSON.parse(this.$el.attributes.years.value);
		app.thisYear = this.$el.attributes.thisYear.value;
		app.thisWeek = this.$el.attributes.thisWeek.value;
		app.invoices = JSON.parse(this.$el.attributes.invoices.value);
		app.totals = JSON.parse(this.$el.attributes.totals.value);

	}
});

$(document).ready(function(){
	console.log('page loaded');
	app.make();
});
