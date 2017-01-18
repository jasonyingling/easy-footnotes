=== Easy Footnotes ===
Contributors: yingling017
Donate link: http://jasonyingling.me
Tags: footnotes, read, blogging, hover, tooltips, editing, endnotes, Formatting, writing, bibliography, notes, reference
Requires at least: 3.0.1
Tested up to: 4.7.1
Stable tag: 1.0.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy Footnotes let's you quickly and easily add footnotes throughout your WordPress posts using a simple shortcode in the text editor.

== Description ==

Easy Footnotes let's you add footnotes throughout your WordPress posts by using the shortcode [note]Footnote content.[/note]. Easy Footnotes will automatically add the number of the footnote where the shortcode was entered and add the full footnote text to the bottom of your post in an ordered list with a corresponding number.

Hovering the footnote label will show the user the full text of the footnote using the jQuery Qtip2 plugin. Clicking on the footnote label will take the user down the page to the corresponding footnote at the bottom of the WordPress post. Each footnote at the bottom of the post has a icon that can be clicked to return to that particular footnote within the post copy.

That's all it takes to start adding footnotes to your WordPress blog!

== Installation ==

1. Upload the 'easy-footnotes' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it! Now simply start using the [note]Footnote content goes here.[/note] shortcode within your posts.

== Frequently Asked Questions ==

= How do I insert a footnote into my post. =

Simply use the shortcode [note]Footnote content goes here[/note] and Easy Footnotes will enter numeric footnotes into your post that open on hover and take the user to the footnote at the bottom of the page on click.

= That's awesome! =

I know, but that's not really a question.

= Oh right, why is that so awesome? =

Because it's easy. And it's integrated with the qTip2 jQuery plugin to display your footnotes in lovely tooltips on hover. Plus it automatically numbers your footnotes in the order you enter them into your post.

= Any plans for the future? =

Yeah, I'll be integrating more of qTip's options for displaying the tooltips. Give users the ability to set their own icons and labels. And much more as I get user feedback.

= That sounds great, but I was thinking more personally. You know, are you up to anything tonight? Want to grab some pizza? =

How did you even get in here?

= It's cool I'll let myself out. One last question though. Any advice on filling up a new plugins FAQ section? =

Maecenas sed diam eget risus varius blandit sit amet non magna. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Maecenas faucibus mollis interdum.


== Screenshots ==

1. Displaying a footnote on hover.
2. Several footnotes (feetnote?) at the bottom of the post.

== Changelog ==

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

== Upgrade Notice ==

= 1.0.0 =
Initial release

= 1.0.1 =
Footnotes now stay open when moused over. Allows for adding links into footnotes.

= 1.0.2 =
I messed up the version tag on 1.0.1. Just upping it 1.0.2 for precautions.

= 1.0.3 =
Added a 400ms delay to the footnote closing via qTip. This allows the footnote to stay open better when mousing into for access to links.

= 1.0.4 =
Fixed bug where footnotes were being appended to the end of the content on home pages and ignoring the more tag

= 1.0.5 =
Updated logic for appending footnotes to the bottom of single posts and pages. Now using is_singular and is_main_query as opposed to just is_single. This allows for appending posts to the bottom of posts, custom post types, and pages. Also fixed logic for numbering posts on the home page when showing multiple posts. Footnotes outside of the single post also now link to the footnote within the single post.

= 1.0.6 =
Added the ability to insert a title above the footnote section at the bottom of the post content. This is controlled in the Easy Footnotes Settings page that can be found under Settings in the WordPress Dashboard.

= 1.0.7 =
Fixed issue where Footnote title was showing on pages without any footnotes once activated through the settings. Also changed the priority of the add_filter('the_content') call to be 20 in order to show above Jetpack Related Posts

= 1.0.8 =
Improved footnote usability on touch devices.

= 1.0.9 =
Fixed issue causing notice of undefined index on admin screen. Adjustment to how footnote's handle html special chars.
