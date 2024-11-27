=== Easy Footnotes ===
Contributors: yingling017, twinpictures
Donate link: http://jasonyingling.me
Tags: footnotes, read, blogging, hover, tooltips, editing, endnotes, Formatting, writing, bibliography, notes, reference
Requires at least: 3.0.1
Tested up to: 6.7.1
Stable tag: 1.1.12
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy Footnotes lets you quickly and easily add footnotes throughout your WordPress posts using a simple shortcode in the text editor.

== Description ==

Easy Footnotes lets you add footnotes throughout your WordPress posts by using the shortcode [efn_note]Footnote content.[/efn_note]. Easy Footnotes will automatically add the number of the footnote where the shortcode was entered and add the full footnote text to the bottom of your post in an ordered list with a corresponding number.

Hovering the footnote label will show the user the full text of the footnote using the jQuery Qtip2 plugin. Clicking on the footnote label will take the user down the page to the corresponding footnote at the bottom of the WordPress post. Each footnote at the bottom of the post has a icon that can be clicked to return to that particular footnote within the post copy.

That's all it takes to start adding footnotes to your WordPress blog!

== Installation ==

1. Upload the 'easy-footnotes' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it! Now simply start using the [efn_note]Footnote content goes here.[/efn_note] shortcode within your posts.

== Frequently Asked Questions ==

= How do I insert a footnote into my post. =

Simply use the shortcode [efn_note]Footnote content goes here[/efn_note] and Easy Footnotes will enter numeric footnotes into your post that open on hover and take the user to the footnote at the bottom of the page on click.

= That's awesome! =

I know, but that's not really a question.

= Oh right, why is that so awesome? =

Because it's easy. And it's integrated with the qTip2 jQuery plugin to display your footnotes in lovely tooltips on hover. Plus it automatically numbers your footnotes in the order you enter them into your post.

= How can I change the markup for the footnote label? =

Just use the `efn_footnote_label` filter in your functions.php to edit the output.

<pre>
<code>function efn_change_label_markup( $output, $label ) {
    return '<h5>' . $label . '</h5>';
}
add_filter( 'efn_footnote_label', 'efn_change_label_markup', 10, 2 );</code>
</pre>

= Can I disable the qTip functionality? =

Place the following code in your functions.php file to disable the qTip features.

<pre>
<code>function efn_deregister_scripts() {
	wp_deregister_style( 'qtipstyles' );
	wp_deregister_script( 'imagesloaded' );
	wp_deregister_script( 'qtip' );
	wp_deregister_script( 'qtipcall' );
}
add_action( 'wp_enqueue_scripts', 'efn_deregister_scripts' );</code>
</pre>

= How can I reset the footnote count? =

Use on the beginning of your page with the short code: `[efn_reset][/efn_reset]`

This is a hard reset to fix a bug with themes/plugins using `do_shortcode( get_the_content() )` outside the main loop and causing duplicate footnotes. 1.1.9 should have updates to not require this.

== Screenshots ==

1. Displaying a footnote on hover.
2. Several footnotes (feetnote?) at the bottom of the post.

== Changelog ==

= 1.1.12 =
* Bugfix for instances where `the_content` is called multiple times in a page.

= 1.1.11 =
* Made combined footnote functionality from 1.1.9 enabled by a setting to avoid breaking sites that rely on the old behavior.
* Now can be turned on with "Combine duplicate footnotes" setting in Easy Footnotes settings.

= 1.1.10 =
* Fixes a bug with sites that called the_content() multiple times not displaying footnotes due to `easy_footnote_reset` running.
* `easy_footnote_reset` now only runs when an option is activated. This had previously been implemented as a workaround for a bug that was addressed in 1.1.9.

= 1.1.9 =
* Adds support for duplicate footnotes using the same number
* Fixes a bug with multiple footnotes showing at the bottom when do_shortcode() is run on the_content outside the main loop.
* Add better i18n support for the plugin
* Adds [efn_reset] shortcode to reset the footnote count

= 1.1.8 =
* WordPress 6.6 support

= 1.1.6 =
* Removing themes.pizza references
* WordPress 6.0.2 support
* PHP 8.0 support

= 1.1.5 =
* WordPress 5.5 compatability

= 1.1.4 =
* Fixing typo on FAQ page

= 1.1.3 =
* Adding div.easy-footnote-title into $footnote_label for filtering with `efn_footnote_label`

= 1.1.2 =
* Fixed issue with default settings not being set on new installations
* Added conditional logic check if settings exist to avoid PHP Warnings
* Fixed undefined index of $efn_output when not using Easy Footnotes label

= 1.1.1 =
* Added `efn_footnote_list_output` filter for editing entire Easy Footnote output after content
* Updating SVN to include missing JS file

= 1.1.0 =
* Improved accessibility for keyboard navigation of footnotes
* Started improving code to follow WordPress Coding Standards guidelines
* Added second option for footnotes using `[efn_note]` to phase out non-prefixed `[note]`
* Added `easy_footnote_label` hook to filter footnote labels
* Added `before_footnote` and `after_footnote` filters to add content before or after footnote lists after content.

= 1.0.16 =
* Fixing footnote counts for the last time! (Hopefully)
* Added post ID to footnote IDs to make them more unique
* New setting to hide the footnotes after content in Settings > Easy Footnotes
* Prep for a bigger update and beginning Gutenberg support

= 1.0.15 =
* Being a noob and not testing a link added in on settings page. It works now.

= 1.0.14 =
* CSS tweak in admin screen

= 1.0.13 =
* Fixing PHP notice on shortcode when content not found

= 1.0.12 =
* Changing how footnotes are numbered to avoid duplicates caused by `the_content` filtering being applied earlier in themes.

= 1.0.11 =
* Fixed bug to prevent tooltips from opening off the screen

= 1.0.10 =
* Added in extra sanitization for user inputs within admin

= 1.0.9 =
* Fixed issue causing notice of undefined index on admin screen. Adjustment to how footnote's handle html special chars.

= 1.0.8 =
* Added the Qtip2 unfocus event for hiding footnotes on iPad and other touch devices.

= 1.0.7 =
* Fixed issue where Footnote title was showing on pages without any footnotes once activated through the settings. Also changed the priority of the add_filter('the_content') call to be 20 in order to show above Jetpack Related Posts

= 1.0.6 =
* Added the ability to insert a title above the footnote section at the bottom of the post content. This is controlled in the Easy Footnotes Settings page that can be found under Settings in the WordPress Dashboard.

= 1.0.5 =
* Updating logic for appending footnotes to the bottom of posts. Now only appends to single posts, custom post types and pages that are using the main post query. Also fixed footnote count when multiple posts are shown in the content on one page, such as the home page. Footnotes outside of the single post also now link to the footnote within the single post.

= 1.0.4 =
* Fixed bug where footnotes were being appended to the end of the content on home pages and ignoring the more tag

= 1.0.3 =
* Added a delay of 400ms to the footnote closing so it stays open better when hovered

= 1.0.2 =
* I messed up the version tag on 1.0.1. Just upping ti 1.0.2 for precautions.

= 1.0.1 =
* Footnotes now stay open when moused over for interacting with links

= 1.0.0 =
* Initial release
