<?php
/**
 * Admin screen functionality for Easy Footnotes.
 *
 * @package easy-footnotes
 */

$footnoteOptions = get_option( 'easy_footnotes_options' );

if ( isset( $_POST['easy_footnote_hidden'] ) ) {
	// Check the nonce for the Reading Time.
	check_admin_referer( 'easy_footnotes_settings_nonce' );

	if ( 'Y' === $_POST['easy_footnote_hidden'] ) :
		// Form data sent.
		$easyFootnoteLabel = ( isset( $_POST['easy_footnotes_label'] ) ) ? sanitize_text_field( wp_unslash( $_POST['easy_footnotes_label'] ) ) : '';

		if ( isset( $_POST['easy_footnote_check'] ) ) {
			$easyFootnoteCheck = true;
		} else {
			$easyFootnoteCheck = false;
		}

		if ( isset( $_POST['hide_easy_footnote_after_posts'] ) ) {
			$hide_easy_footnote_after_posts = true;
		} else {
			$hide_easy_footnote_after_posts = false;
		}

		if ( isset( $_POST['show_easy_footnote_on_front'] ) ) {
			$show_easy_footnote_on_front = true;
		} else {
			$show_easy_footnote_on_front = false;
		}

		$updateOptions = array(
			'footnoteLabel'                  => $easyFootnoteLabel,
			'useLabel'                       => $easyFootnoteCheck,
			'hide_easy_footnote_after_posts' => $hide_easy_footnote_after_posts,
			'show_easy_footnote_on_front'    => $show_easy_footnote_on_front,
		);

		update_option( 'easy_footnotes_options', $updateOptions );
		?>
		<div class="updated">
			<p><strong><?php esc_html_e( 'Options saved.', 'easy-footnotes' ); ?></strong></p>
		</div>
		<?php
	endif;
} else {
	// Normal page display.
	$easyFootnoteLabel              = isset( $footnoteOptions['footnoteLabel'] ) ? $footnoteOptions['footnoteLabel'] : __( 'Footnotes', 'easy-footnotes' );
	$easyFootnoteCheck              = isset( $footnoteOptions['useLabel'] ) ? $footnoteOptions['useLabel'] : false;
	$hide_easy_footnote_after_posts = isset( $footnoteOptions['hide_easy_footnote_after_posts'] ) ? $footnoteOptions['hide_easy_footnote_after_posts'] : false;
	$show_easy_footnote_on_front    = isset( $footnoteOptions['show_easy_footnote_on_front'] ) ? $footnoteOptions['show_easy_footnote_on_front'] : false;
}
?>

<div class="wrap">
	<?php echo '<h2>' . esc_html__( 'Easy Footnotes Settings', 'easy-footnotes' ) . '</h2>'; ?>

	<form name="easy_footnotes_form" method="post">
		<input type="hidden" name="easy_footnote_hidden" value="Y">
		<?php wp_nonce_field( 'easy_footnotes_settings_nonce' ); ?>
		<?php echo '<h4>' . esc_html__( 'Easy Footnotes Settings', 'easy-footnotes' ) . '</h4>'; ?>
		<p><?php esc_html_e( 'Want to add a label to your footnotes section at the bottom of your post? Just enter some text here and check the box and you\'re good to go.', 'easy-footnotes' ); ?></p>
		<p><?php esc_html_e( 'Easy Footnotes Label: ', 'easy-footnotes' ); ?><input type="text" name="easy_footnotes_label" value="<?php echo esc_attr( $easyFootnoteLabel ); ?>" size="20"></p>

		<p><?php esc_html_e( 'Insert Easy Footnotes Label: ', 'easy-footnotes' ); ?><input type="checkbox" name="easy_footnote_check" <?php checked( $easyFootnoteCheck ); ?> size="20"></p>

		<p><?php esc_html_e( 'Hide Footnotes after post content: ', 'easy-footnotes' ); ?><input type="checkbox" name="hide_easy_footnote_after_posts" <?php checked( $hide_easy_footnote_after_posts ); ?> size="20"></p>

		<p id="easy_footnote_on_front"><?php esc_html_e( 'Show Footnotes on Front Page: ', 'easy-footnotes' ); ?><input type="checkbox" name="show_easy_footnote_on_front" <?php checked( $show_easy_footnote_on_front ); ?> size="20"></p>

		<p class="submit">
		<input type="submit" name="Submit" value="<?php esc_attr_e( 'Update Options', 'easy_footnotes_trdom' ); ?>" />
		</p>
	</form>

	<div class="easy-footnotes-shortcode-hint">
		<p><?php echo esc_html__( 'Shortcode: [efn_note]Insert your note here.[/efn_note]', 'easy-footnotes' ); ?></p>
	</div>

	<div class="efn-preview">
		<a class="efn-theme-link" href="<?php echo esc_url( 'https://www.themes.pizza/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' ); ?>" target="_blank"><img src="<?php echo esc_url( plugins_url( '/assets/zuul-wordpress-theme.jpg', __FILE__ ) ); ?>" alt="Zuul WordPress Theme homepage in various color options" /></a>
		<div class="efn-preview-copy">
			<h2><?php esc_html_e( 'Tasty WordPress Themes', 'easy-footnotes' ); ?></h2>
			<p>
			<?php
			printf(
				wp_kses_post( 'Love easy footnotes? Check out my premium themes now available on Themes.Pizza. Each theme is hand crafted from the finest ingredients with a specific purpose in mind. Need to start a side project / membership site? Try out <a href="%1s" target="_blank">Zuul</a>. Looking to establish yourself as an authoirty on a subject? Try out <a href="%2s" target="_blank">The Authority Pro</a>.', 'easy-footnotes' ),
				esc_url( 'https://www.themes.pizza/downloads/zuul-pro/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' ),
				esc_url( 'https://www.themes.pizza/downloads/the-authority-pro/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' )
			);
			?>
			</p>
			<p><?php echo wp_kses_post( 'All themes are 100% GPL. Use them on as many sites as you want and make something awesome! And for being a faithful Easy Footnotes user get 20% off with the code <strong>TASTYZA</strong>.', 'easy-footnotes' ); ?></p>
			<a class="efn-theme-button" href="<?php echo esc_url( 'https://www.themes.pizza/?utm_source=easy-footnotes&utm_medium=button&utm_campaign=efnupsell' ); ?>" target="_blank"><?php esc_html_e( 'Shop Now', 'easy-footnotes' ); ?></a>
		</div>
	</div>
</div>
