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
        $updateOptions = array(
        	'footnoteLabel' => $easyFootnoteLabel,
			'useLabel' => $easyFootnoteCheck,
        );

        update_option('easy_footnotes_options', $updateOptions);

        ?>
        <div class="updated"><p><strong><?php esc_html_e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        //Normal page display
        $easyFootnoteLabel = $footnoteOptions['footnoteLabel'];
        $easyFootnoteCheck = $footnoteOptions['useLabel'];
    }
?>

<div class="wrap">
    <?php    echo "<h2>" . esc_html__( 'Easy Footnotes Settings', 'easy_footnotes_trdom' ) . "</h2>"; ?>

    <form name="easy_footnotes_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    	<input type="hidden" name="easy_footnote_hidden" value="Y">
        <?php    echo "<h4>" . esc_html__( 'Easy Footnotes Settings', 'easy_footnotes_trdom' ) . "</h4>"; ?>
		<p><?php esc_html_e("Want to add a label to your footnotes section at the bottom of your post? Just enter some text here and check the box and you're good to go."); ?></p>
        <p><?php esc_html_e("Easy Footnotes Label: "); ?><input type="text" name="easy_footnotes_label" value="<?php echo esc_attr($easyFootnoteLabel); ?>" size="20"></p>

		<p><?php esc_html_e("Insert Easy Footnotes Label: "); ?><input type="checkbox" name="easy_footnote_check" <?php checked($easyFootnoteCheck); ?> size="20"><?php esc_html_e(""); ?></p>

        <p class="submit">
        <input type="submit" name="Submit" value="<?php esc_attr_e('Update Options', 'easy_footnotes_trdom' ) ?>" />
        </p>
    </form>

    <div class="easy-footnotes-shortcode-hint">
	    <p>Shortcode: [note]Insert your note here.[/note]</p>
    </div>
</div>
