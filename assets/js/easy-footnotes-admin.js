jQuery(function() {
    
    jQuery("input[name=hide_easy_footnote_after_posts]").click(function() {
        // only show the "Show on Front page" option when the user has decided NOT to hide the footnotes from the bottom of the posts.
        // jQuery("#easy_footnote_on_front").toggle(!this.checked); 

        // Disable the "Show on Front page" option when the user has decided NOT to hide the footnotes from the bottom of the posts.
        jQuery("input[name=show_easy_footnote_on_front]").attr('disabled',this.checked)
    });
       
});

