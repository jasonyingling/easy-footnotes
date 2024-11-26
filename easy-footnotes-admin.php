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
		$easyFootnoteLabel              = ( isset( $_POST['easy_footnotes_label'] ) ) ? sanitize_text_field( wp_unslash( $_POST['easy_footnotes_label'] ) ) : '';
		$easyFootnoteCheck              = isset( $_POST['easy_footnote_check'] ) ? true : false;
		$hide_easy_footnote_after_posts = isset( $_POST['hide_easy_footnote_after_posts'] ) ? true : false;
		$show_easy_footnote_on_front    = isset( $_POST['show_easy_footnote_on_front'] ) ? true : false;
		$reset_footnotes                = isset( $_POST['reset_footnotes'] ) ? true : false;
		$combine_duplicate_footnotes    = isset( $_POST['combine_duplicate_footnotes'] ) ? true : false;

		$updateOptions = array(
			'footnoteLabel'                  => sanitize_text_field( $easyFootnoteLabel ),
			'useLabel'                       => $easyFootnoteCheck,
			'hide_easy_footnote_after_posts' => $hide_easy_footnote_after_posts,
			'show_easy_footnote_on_front'    => $show_easy_footnote_on_front,
			'reset_footnotes'                => $reset_footnotes,
			'combine_duplicate_footnotes'    => $combine_duplicate_footnotes,
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
	$easyFootnoteLabel              = isset( $footnoteOptions['footnoteLabel'] ) ? esc_html( $footnoteOptions['footnoteLabel'] ) : __( 'Footnotes', 'easy-footnotes' );
	$easyFootnoteCheck              = isset( $footnoteOptions['useLabel'] ) ? $footnoteOptions['useLabel'] : false;
	$hide_easy_footnote_after_posts = isset( $footnoteOptions['hide_easy_footnote_after_posts'] ) ? $footnoteOptions['hide_easy_footnote_after_posts'] : false;
	$show_easy_footnote_on_front    = isset( $footnoteOptions['show_easy_footnote_on_front'] ) ? $footnoteOptions['show_easy_footnote_on_front'] : false;
	$reset_footnotes                = isset( $footnoteOptions['reset_footnotes'] ) ? $footnoteOptions['reset_footnotes'] : false;
	$combine_duplicate_footnotes    = isset( $footnoteOptions['combine_duplicate_footnotes'] ) ? $footnoteOptions['combine_duplicate_footnotes'] : false;
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

		<p><?php esc_html_e( 'Combine duplicate footnotes: ', 'easy-footnotes' ); ?><input type="checkbox" name="combine_duplicate_footnotes" <?php checked( $combine_duplicate_footnotes ); ?> size="20"></p>

		<p><?php esc_html_e( 'Reset Footnotes to avoid duplication after the content: ', 'easy-footnotes' ); ?><input type="checkbox" name="reset_footnotes" <?php checked( $reset_footnotes ); ?> size="20">
			<br>
			<span><?php esc_html_e( 'If you have "Combine duplicate footnotes" turned on, you should leave this setting off. ', 'easy-footnotes' ); ?><span>
		</p>

		<p class="submit">
		<input type="submit" name="Submit" value="<?php esc_attr_e( 'Update Options', 'easy-footnotes' ); ?>" />
		</p>
	</form>

	<div class="easy-footnotes-shortcode-hint">
		<p><?php echo esc_html__( 'Shortcode: [efn_note]Insert your note here.[/efn_note]', 'easy-footnotes' ); ?></p>
	</div>

</div>
