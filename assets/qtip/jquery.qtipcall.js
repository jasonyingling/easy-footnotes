jQuery(document).ready(function($){
	$('.easy-footnote a').qtip({
		position: {
	        my: 'top center',  // Position my top left...
	        at: 'bottom center', // at the bottom right of...
	        //target: $('.container-post') // my target
	        //viewport: $('.post_copy')
	    },
	    style: {
		    classes: 'qtip-bootstrap'
	    },
	    hide: {
            fixed: true,
            delay: 400,
            event: 'unfocus mouseleave'
        }
	});
});