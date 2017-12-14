const base = new Vue({
	el: '#aside-root',
	data: {
		count:0,
		archivedCount:0,
		firstMessages:[],
		secondMessages:[]
	},
	methods: {
		prepareData(data) {
			var countFirst = 0;
			var countSecond = 0;
			var firstMessages = {};
			var secondMessages = {};
			$.each(data['first'], function(index, val) {
				$.each(val, function(k, v) {
					countFirst++;
				});
				
				key = (index > 0) ? index+' day(s) ago' : 'Today'; 

				firstMessages[key] = val;
				
			});
			$.each(data['second'], function(index, val) {
				$.each(val, function(k, v) {
					countSecond++;
				});
				key = (index > 0) ? index+' day(s) ago' : 'Today'; 	
				secondMessages[key] = val;
			});

			this.firstMessages = firstMessages;
			this.secondMessages = secondMessages;
			this.count = countFirst;
			this.archivedCount = countSecond;
		},
		markAsRead(id) {
			// mark the message as read
			axios.post('/contact/'+id+'/mark-as-read').then(response => {
				if (response.data.status) {
					this.prepareData(response.data.set);
					this.setNavCount();
				}
			});
		},
		setAsArchive(id) {
			// set message as Archive
			axios.post('/contact/'+id+'/set-as-archive').then(response => {
				if (response.data.status) {
					this.prepareData(response.data.set);
					this.setNavCount();
				}
			});
		},
		setAsDeleted(id) {
			// set message as Archive
			axios.post('/contact/'+id+'/set-as-deleted').then(response => {
				if (response.data.status) {
					this.prepareData(response.data.set);
					this.setNavCount();
				}
			});
		},
		setNavCount() {
			// set nav count
			$("#navCount").html(this.count);
		},
	},
	computed: {

	},
	created() {

	},
	mounted() {
		// modal
		// set variables for saving
		var set = JSON.parse($("#aside-root").attr('data'));
		this.prepareData(set);
	}
});


$(document).ready(function(){
	bootstrap.events();
});

bootstrap = {
	events: function() {
		$('div.alert').not('.alert-important').delay(3000).fadeOut(350);

		$('.table-responsive').on('show.bs.dropdown', function () {
		     $('.table-responsive').css( "overflow", "inherit" );
		});

		$('.table-responsive').on('hide.bs.dropdown', function () {
		     $('.table-responsive').css( "overflow", "auto" );
		});
	}
};