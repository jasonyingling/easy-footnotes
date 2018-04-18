<?php
	$footnoteOptions = get_option('easy_footnotes_options');

    if ( isset($_POST['easy_footnote_hidden']) && $_POST['easy_footnote_hidden'] == 'Y' ) {
        //Form data sent
        $easyFootnoteLabel = $_POST['easy_footnotes_label'];
        if ($_POST['easy_footnote_check']) {
	        $easyFootnoteCheck = true;
        } else {
	        $easyFootnoteCheck = false;
        }

        if (isset( $_POST['hide_easy_footnote_after_posts'] ) && $_POST['hide_easy_footnote_after_posts'] ) {
	        $hide_easy_footnote_after_posts = true;
        } else {
	        $hide_easy_footnote_after_posts = false;
        }

        $updateOptions = array(
        	'footnoteLabel' => $easyFootnoteLabel,
            'useLabel' => $easyFootnoteCheck,
            'hide_easy_footnote_after_posts' => $hide_easy_footnote_after_posts,
        );

        update_option('easy_footnotes_options', $updateOptions);

        ?>
        <div class="updated"><p><strong><?php esc_html_e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        //Normal page display
        $easyFootnoteLabel = $footnoteOptions['footnoteLabel'];
        $easyFootnoteCheck = $footnoteOptions['useLabel'];
        $hide_easy_footnote_after_posts = $footnoteOptions['hide_easy_footnote_after_posts'];
    }
?>

<div class="wrap">
    <?php echo "<h2>" . esc_html__( 'Easy Footnotes Settings', 'easy_footnotes_trdom' ) . "</h2>"; ?>

    <form name="easy_footnotes_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    	<input type="hidden" name="easy_footnote_hidden" value="Y">
        <?php echo "<h4>" . esc_html__( 'Easy Footnotes Settings', 'easy_footnotes_trdom' ) . "</h4>"; ?>
		<p><?php esc_html_e("Want to add a label to your footnotes section at the bottom of your post? Just enter some text here and check the box and you're good to go."); ?></p>
        <p><?php esc_html_e("Easy Footnotes Label: "); ?><input type="text" name="easy_footnotes_label" value="<?php echo esc_attr($easyFootnoteLabel); ?>" size="20"></p>

		<p><?php esc_html_e("Insert Easy Footnotes Label: "); ?><input type="checkbox" name="easy_footnote_check" <?php checked($easyFootnoteCheck); ?> size="20"><?php esc_html_e(""); ?></p>

        <p><?php esc_html_e("Hide Footnotes after post content: "); ?><input type="checkbox" name="hide_easy_footnote_after_posts" <?php checked($hide_easy_footnote_after_posts); ?> size="20"><?php esc_html_e(""); ?></p>

        <p class="submit">
        <input type="submit" name="Submit" value="<?php esc_attr_e('Update Options', 'easy_footnotes_trdom' ) ?>" />
        </p>
    </form>

    <div class="easy-footnotes-shortcode-hint">
	    <p><?php echo __('Shortcode: [note]Insert your note here.[/note]', 'easy-footnotes'); ?></p>
    </div>

	<div class="efn-preview">
		<a class="efn-theme-link" href="<?php echo esc_url( 'https://www.themes.pizza/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' ); ?>" target="_blank"><img src="<?php echo plugins_url( '/assets/zuul-wordpress-theme.jpg' , __FILE__ ); ?>" alt="Zuul WordPress Theme homepage in various color options" /></a>
		<div class="efn-preview-copy">
			<h2><?php echo __( 'Tasty WordPress Themes', 'easy-footnotes' ); ?></h2>
			<p><?php printf( __( 'Love easy footnotes? Check out my premium themes now available on Themes.Pizza. Each theme is hand crafted from the finest ingredients with a specific purpose in mind. Need to start a side project / membership site? Try out <a href="%1s" target="_blank">Zuul</a>. Looking to establish yourself as an authoirty on a subject? Try out <a href="%2s" target="_blank">The Authority Pro</a>.', 'easy-footnotes' ), esc_url( 'https://www.themes.pizza/downloads/zuul-pro/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' ), esc_url( 'https://www.themes.pizza/downloads/the-authority-pro/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' ) ); ?></p>
			<p><?php echo __( 'All themes are 100% GPL. Use them on as many sites as you want and make something awesome! And for being a faithful Easy Footnotes user get 20% off with the code <strong>TASTYZA</strong>.', 'easy-footnotes' ); ?></p>
			<a class="efn-theme-button" href="<?php echo esc_url( 'https://www.themes.pizza/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' ); ?>" target="_blank"><?php echo __( 'Shop Now', 'easy-footnotes' ); ?></a>
		</div>
	</div>
</div>
