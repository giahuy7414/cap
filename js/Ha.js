$(document).ready(function(){
	$('a[rel=popover]').popover({
		content: function() {
			return $(this).siblings(".po-doc-popover-content").html();
		},
		placement: 'bottom',
		html: true,
		// trigger: 'focus'
	});

	$('body').on('click', function (e) {
		$('.po-doc-popover').each(function () {
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	        	$(this).popover('hide');
	        }
	    });
	});

    // $(document).click(function(e) {  
    //     $('.popover').click(function(){  
    //         return false;  
    //     });  
    //  $('.popover').popover('hide');  
    // });  
});