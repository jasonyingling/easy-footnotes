<?php
/**
 * Plugin Name: Easy Footnotes
 * Plugin URI: https://jasonyingling.me/easy-footnotes-wordpress/
 * Description: Easily add footnotes to your posts with a simple shortcode.
 * Version: 1.1.0
 * Author: Jason Yingling
 * Author URI: https://jasonyingling.me
 * License: GPL2
 *
 * @package easy-footnotes
 */

/*
	Copyright 2018  Jason Yingling  (email : yingling017@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/**
 * The Easy Footnotes class. In camel case. Because I didn't follow WPCS way back when.
 */
class easyFootnotes {

	/**
	 * Add label option using add_option if it does not already exist.
	 *
	 * @var array $footnotes An array for the footnotes to be stored.
	 */
	public $footnotes     = array();
	public $footnoteCount = 0;
	public $prevPost;
	public $footnoteOptions;

	private $footnoteSettings;

	/**
	 * Constructing the initial plugin options, shortcodes, and hooks.
	 */
	public function __construct() {
		$footnoteSettings = array(
			'footnoteLabel'                  => __( 'Footnotes', 'easy-footnotes' ),
			'useLabel'                       => false,
			'hide_easy_footnote_after_posts' => false,
			'show_easy_footnote_on_front'    => false,
		);

		add_option( 'easy_footnotes_options', $this->footnoteSettings );
		add_shortcode( 'note', array( $this, 'easy_footnote_shortcode' ) );
		add_shortcode( 'efn_note', array( $this, 'easy_footnote_shortcode' ) );
		add_filter( 'the_content', array( $this, 'easy_footnote_after_content' ), 20 );
		add_filter( 'the_content', array( $this, 'easy_footnote_reset' ), 999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_qtip_scripts' ) );
		add_action( 'admin_menu', array( $this, 'easy_footnotes_admin_actions' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'easy_footnotes_admin_scripts' ) );

		$this->footnoteOptions = get_option( 'easy_footnotes_options' );
	}

	/**
	 * Registering the scripts and styles used by jQuery qTip.
	 */
	public function register_qtip_scripts() {
		wp_register_script( 'imagesloaded', plugins_url( '/assets/qtip/imagesloaded.pkgd.min.js', __FILE__ ), array(), '3.1.8', true );
		wp_register_script( 'qtip', plugins_url( '/assets/qtip/jquery.qtip.min.js', __FILE__ ), array( 'jquery', 'imagesloaded' ), '3.0.3', true );
		wp_register_script( 'qtipcall', plugins_url( '/assets/qtip/jquery.qtipcall.js', __FILE__ ), array( 'jquery', 'qtip' ), '1.1.0', true );
		wp_register_style( 'qtipstyles', plugins_url( '/assets/qtip/jquery.qtip.min.css', __FILE__ ), array(), '3.0.3', false );
		wp_register_style( 'easyfootnotescss', plugins_url( '/assets/easy-footnotes.css', __FILE__ ), array(), '1.1.0', false );
	}

	/**
	 * Create the Easy Footnotes shortcode.
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content Content within the shortcode.
	 */
	public function easy_footnote_shortcode( $atts, $content = null ) {
		if ( isset( $this->footnoteOptions['show_easy_footnote_on_front'] ) && $this->footnoteOptions['show_easy_footnote_on_front'] ) {
			$efn_show_on_front = is_front_page();
		} else {
			$efn_show_on_front = false;
		}

		wp_enqueue_style( 'qtipstyles' );
		wp_enqueue_style( 'easyfootnotescss' );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'qtip' );
		wp_enqueue_script( 'qtipcall' );
		wp_enqueue_style( 'dashicons' );

		$atts = shortcode_atts(
			array(
				// Future home of shortcode atts.
			),
			$atts
		);

		$post_id = get_the_ID();

		$content = do_shortcode( $content );

		$count = $this->footnoteCount;

		// Increment the counter.
		$count++;

		// Set the footnoteCount (This whole process needs reworked).
		$this->footnoteCount = $count;

		$this->easy_footnote_content( $content );

		if ( ( is_singular() || $efn_show_on_front ) && is_main_query() ) {
			$footnoteLink = '#easy-footnote-bottom-' . $this->footnoteCount . '-' . $post_id;
		} else {
			$footnoteLink = get_permalink( get_the_ID() ) . '#easy-footnote-bottom-' . $this->footnoteCount . '-' . $post_id;
		}

		$footnoteContent = "<span id='easy-footnote-" . esc_attr( $this->footnoteCount ) . '-' . $post_id . "' class='easy-footnote-margin-adjust'></span><span class='easy-footnote'><a href='" . esc_url( $footnoteLink ) . "' title='" . htmlspecialchars( $content, ENT_QUOTES ) . "'><sup>" . esc_html( $this->footnoteCount ) . "</sup></a></span>";

		return $footnoteContent;
	}

	/**
	 * The content of a particular footnote.
	 *
	 * @param string $content The content from a particular call of the shortcode.
	 */
	public function easy_footnote_content( $content ) {
		$this->footnotes[ $this->footnoteCount ] = $content;

		return $this->footnotes;
	}

	/**
	 * Display the list of footnotes after the post content.
	 *
	 * @param string $content The content of the current post.
	 */
	public function easy_footnote_after_content( $content ) {
		if ( isset( $this->footnoteOptions['hide_easy_footnote_after_posts'] ) && $this->footnoteOptions['hide_easy_footnote_after_posts'] ) {
			return $content;
		}

		if ( isset( $this->footnoteOptions['show_easy_footnote_on_front'] ) && $this->footnoteOptions['show_easy_footnote_on_front'] ) {
			$efn_show_on_front = is_front_page();
		} else {
			$efn_show_on_front = false;
		}

		if ( ( is_singular() || $efn_show_on_front ) && is_main_query() ) {
			$footnotesInsert = $this->footnotes;

			$footnoteCopy = '';

			$useLabel = $this->footnoteOptions['useLabel'];
			$efLabel  = $this->footnoteOptions['footnoteLabel'];
			$efCustomLabelMarkup = $this->footnoteOptions['customLabelMarkup'];

			$post_id = get_the_ID();

			foreach ( $footnotesInsert as $count => $footnote ) {
				$footnoteCopy .= '<li class="easy-footnote-single"><span id="easy-footnote-bottom-' .esc_attr( $count ) . '-' . $post_id . '" class="easy-footnote-margin-adjust"></span>' . wp_kses_post( $footnote ) . '<a class="easy-footnote-to-top" href="' . esc_url( '#easy-footnote-' . $count . '-' . $post_id ) . '"></a></li>';
			}
			
			if ( ! empty( $footnotesInsert ) ) {
				if ( true === $useLabel ) {
					if ($efCustomLabelMarkup) {
                        $content .= str_replace('{{label}}', esc_html($efLabel), $efCustomLabelMarkup);
                    } else {
						$footnote_label = '<h4>' . esc_html( $efLabel ) . '</h4>';
						// Filter for editing footnote label markup and output.
						$footnote_label = apply_filters( 'efn_footnote_label', $footnote_label, $efLabel );

						$content .= sprintf(
							'<div class="easy-footnote-title">
								%s
							</div>',
							$footnote_label
						);
					}
				}

				$footnote_content = '';

				// Add filter before footnote list.
				$footnote_content  = apply_filters( 'before_footnote', $footnote_content );
				$footnote_content .= '<ol class="easy-footnotes-wrapper">' . $footnoteCopy . '</ol>';

				// Add filter after footnote list.
				$footnote_content = apply_filters( 'after_footnote', $footnote_content );

				$content .= do_shortcode( $footnote_content );
			}
		}

		return $content;
	}

	/**
	 * Reset the footnote count and footnote array each time the_content has been run.
	 *
	 * @param string $content The content of the post from the_content filter.
	 */
	public function easy_footnote_reset( $content ) {
		$this->footnoteCount = 0;

		$this->footnotes = array();

		return $content;
	}

	/**
	 * Include the easy-footnotes-admin.php file.
	 */
	public function easy_footnotes_admin() {
		include 'easy-footnotes-admin.php';
	}

	/**
	 * Function to add options page for Easy Footnote Settings.
	 */
	public function easy_footnotes_admin_actions() {
		add_options_page(
			__( 'Easy Footnotes Settings', 'easy-footnotes' ),
			__( 'Easy Footnotes', 'easy-footnotes' ),
			'manage_options',
			'easy-footnotes-settings',
			array( $this, 'easy_footnotes_admin' )
		);
	}

	/**
	 * Function for enqueuring EAsy Footnotes admin scripts.
	 */
	public function easy_footnotes_admin_scripts() {
		wp_enqueue_style( 'easy-footnotes-admin-styles', plugins_url( '/assets/easy-footnotes-admin.css', __FILE__ ), '', '1.0.13' );
		wp_enqueue_script( 'easy-footnotes-admin-scripts', plugins_url( '/assets/js/easy-footnotes-admin.js', __FILE__ ), array( 'jquery' ), '1.0.1', true );
	}
}

$easyFootnotes = new easyFootnotes();