$(document).ready(function(){
	general.pageLoad();
});
general = {
	pageLoad: function() {
		$(window).on('scroll', general.checkScroll)

	},
	checkScroll: function() {
		scroll_distance = $('.navbar[on-scroll]').attr('on-scroll') || 500;
		if($(document).scrollTop() > scroll_distance ) {
			$('.navbar-top').hide();
	        $('.navbar[on-scroll]').fadeIn();
	    } else {
	    	$('.navbar-top').fadeIn();
	       	$('.navbar[on-scroll]').hide();
	    }
	}

}
