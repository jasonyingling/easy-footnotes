<?php
/**
 * Plugin Name: Easy Footnotes
 * Plugin URI: https://jasonyingling.me/easy-footnotes-wordpress/
 * Description: Easily add footnotes to your posts with a simple shortcode.
 * Version: 1.0.17
 * Author: Jason Yingling
 * Author URI: https://jasonyingling.me
 * License: GPL2
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

class easyFootnotes {

	// Add label option using add_option if it does not already exist.
	public $footnotes     = array();
	public $footnoteCount = 0;
	public $prevPost;
	public $footnoteOptions;

	private $footnoteSettings;
	
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

	public function register_qtip_scripts() {
		wp_register_script( 'imagesloaded', plugins_url( '/assets/qtip/imagesloaded.pkgd.min.js', __FILE__ ), null, false, true );
		wp_register_script( 'qtip', plugins_url( '/assets/qtip/jquery.qtip.min.js', __FILE__ ), array( 'jquery', 'imagesloaded' ), false, true );
		wp_register_script( 'qtipcall', plugins_url( '/assets/qtip/jquery.qtipcall.js', __FILE__ ), array( 'jquery', 'qtip' ), false, true );
		wp_register_style( 'qtipstyles', plugins_url( '/assets/qtip/jquery.qtip.min.css', __FILE__ ), null, false, false );
		wp_register_style( 'easyfootnotescss', plugins_url( '/assets/easy-footnotes.css', __FILE__ ), null, false, false );
	}

	public function easy_footnote_shortcode( $atts, $content = null ) {
		if ( $this->footnoteOptions['show_easy_footnote_on_front'] ) {
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

		extract( shortcode_atts( array(
		), $atts ) );

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

	public function easy_footnote_content( $content ) {
		$this->footnotes[ $this->footnoteCount ] = $content;

		return $this->footnotes;
	}

	public function easy_footnote_count( $count, $currentPost ) {
		if ( $this->prevPost != $currentPost ) {
			$count = 0;
		}

		$this->prevPost = $currentPost;

		$count++;

		$this->footnoteCount = $count;

		return $this->footnoteCount;
	}

	public function easy_footnote_after_content( $content )
	{
		if ( $this->footnoteOptions['hide_easy_footnote_after_posts'] ) {
			return $content;
		}

		if ( $this->footnoteOptions['show_easy_footnote_on_front'] ) {
			$efn_show_on_front = is_front_page();
		} else {
			$efn_show_on_front = false;
		}

		if ( ( is_singular() || $efn_show_on_front ) && is_main_query() ) {
			$footnotesInsert = $this->footnotes;

			$footnoteCopy = '';

			$useLabel = $this->footnoteOptions['useLabel'];
			$efLabel = $this->footnoteOptions['footnoteLabel'];

			$post_id = get_the_ID();

			foreach ( $footnotesInsert as $count => $footnote ) {
				$footnoteCopy .= '<li class="easy-footnote-single"><span id="easy-footnote-bottom-' .esc_attr( $count ) . '-' . $post_id . '" class="easy-footnote-margin-adjust"></span>' . wp_kses_post( $footnote ) . '<a class="easy-footnote-to-top" href="' . esc_url( '#easy-footnote-' . $count . '-' . $post_id ) . '"></a></li>';
			}
			if ( !empty( $footnotesInsert ) ) {
				if ( $useLabel === true ) {
					$content .= '<div class="easy-footnote-title"><h4>' . esc_html( $efLabel ) . '</h4></div><ol class="easy-footnotes-wrapper">' . $footnoteCopy . '</ol>';
				} else {
					$content .= '<ol class="easy-footnotes-wrapper">' . $footnoteCopy . '</ol>';
				}
			}
		}

		return $content;
	}

	/**
	 * Reset the footnote count and footnote array each time the_content has been run.
	 */
	public function easy_footnote_reset( $content ) {
		$this->footnoteCount = 0;

		$this->footnotes = array();

		return $content;
	}

	// Functions to create Reading Time admin pages
	public function easy_footnotes_admin() {
		include( 'easy-footnotes-admin.php' );
	}

	public function easy_footnotes_admin_actions() {
		add_options_page( "Easy Footnotes Settings", "Easy Footnotes", "manage_options", "easy-footnotes-settings", array( $this, "easy_footnotes_admin" ) );
	}

	public function easy_footnotes_admin_scripts() {
		wp_enqueue_style( 'easy-footnotes-admin-styles', plugins_url( '/assets/easy-footnotes-admin.css', __FILE__ ), '', '1.0.13') ;

		wp_register_script( 'easy-footnotes-admin-scripts', plugins_url( '/assets/js/easy-footnotes-admin.js', __FILE__ ), array( 'jquery' ), '1.0.1' );
		wp_enqueue_script( 'easy-footnotes-admin-scripts' );
	}
}

$easyFootnotes = new easyFootnotes();
