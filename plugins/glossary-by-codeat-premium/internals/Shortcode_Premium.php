<?php

/**
 * Glossary
 *
 * @package   Glossary
 * @author    Codeat <support@codeat.co>
 * @copyright 2020
 * @license   GPL 3.0+
 * @link      https://codeat.co
 */

namespace Glossary\Internals;

use Glossary\Frontend\Core;

/**
 * Shortcodes of this plugin
 */
class Shortcode_Premium extends Shortcode {

	/**
	 * Instance of this G_Is_Methods.
	 *
	 * @var object
	 */
	public $is = null;

	/**
	 * Instance of this Glossary\Frontend\Core\Search_Engine.
	 *
	 * @var \Glossary\Frontend\Core\Search_Engine
	 */
	public $search_engine = null;

	/**
	 * Initialize the class.
	 *
	 * @return bool
	 */
	public function initialize() {
		parent::initialize();

		$this->is = new \Glossary\Engine\Is_Methods;

		\add_shortcode( 'glossary-list', array( $this, 'list' ) );
		\add_shortcode( 'glossary-ignore', array( $this, 'ignore' ) );
		\add_shortcode( 'glossary', array( $this, 'parser' ) );

		return true;
	}

	/**
	 * Convert old parameters to new
	 *
	 * @param string|array $atts List of parameters.
	 * @param array        $attributes Array to evaluate.
	 * @param array        $old_attributes Old parameters.
	 * @return array
	 */
	public function shortcode_atts( $atts, array $attributes, array $old_attributes = array() ) {
		if ( !\is_array( $atts ) ) {
			return $attributes;
		}

		$attributes = \shortcode_atts( $attributes, $atts );

		if ( !empty( $old_attributes ) ) {
			foreach ( $old_attributes as $old_attr => $new_attr ) {
				$attributes = $this->remap_old_proprierty( $atts, $attributes, $old_attr, $new_attr );
			}
		}

		return $attributes;
	}

	/**
	 * Generate a navigable list of terms
	 *
	 * @param array|string $atts An array with all the parameters.
	 * @global object $wpdb WPDB object.
	 * @return string
	 */
	public function list( $atts ) {
		$attributes = array(
			'letter-anchor'      => 'true',
			'empty-letters'      => 'true',
			'excerpt'            => 'false',
			'content'            => 'false',
			'term-anchor'        => 'true',
			'term-anchor-target' => 'false',
			'search'             => 'disabled',
			'custom-url'         => 'false',
			'theme'              => '',
			'accordion'          => 'false',
			'show-letter'        => '',
			'taxonomy'           => '',
			'custom-fields'      => 'false',
			'featured-image'     => 'false',
		);

		$attributes = $this->shortcode_atts(
			$atts,
			$attributes,
			array( 'anchor' => 'letter-anchor', 'customurl' => 'custom-url', 'empty' => 'empty-letters', 'show-letter' => 'letters', '_content' => 'content' )
		);

		if ( \is_array( $atts ) ) {
			$attributes = $this->remap_old_proprierty( $atts, $attributes, 'noanchorterms', 'term-anchor', true );
		}

		$html           = '';
		$transient_html = '';
		$prepend_html   = '<span class="components-notice is-warning" style="margin:0;margin-bottom: 14px;">' . \__( 'The preview of this block is limited for performance reasons. Check out the editor\'s full page preview if you have more than 30 terms to display.', GT_SETTINGS ) . '</span>';
		$key            = 'glossary_list_page-' . \get_locale() . '-' . \md5( (string) \wp_json_encode( $attributes ) );

		if ( $this->is->request( 'cli' ) || $this->is->not_admin_ajax() ) {
			$transient_html = \get_transient( $key );
			$prepend_html   = '';
			$html           = $transient_html;
		}

		if ( false === $html
			|| empty( $html )
			|| \current_user_can( 'manage_options' ) ) { // Last check to don't use the cache with admin user
			$alphabets_bar = new Core\Alphabetical_Index_Bar;
			$alphabets_bar->initialize();
			$alphabets_bar->generate_index( $attributes );

			$html = $prepend_html . $alphabets_bar->generate_html_index() . $alphabets_bar->generate_html_content();
		}

		if ( $this->is->not_admin_ajax() && empty( $prepend_html ) && $transient_html !== $html ) {
			\set_transient( $key, $html, DAY_IN_SECONDS );
		}

		$html = \trim( \str_replace( array( "\r\n", "\r", "\n" ), ' ', \strval( $html ) ) );

		return $html;
	}

	/**
	 * Wrap the content to be ignored
	 *
	 * @param array|string $atts The attributes, not used.
	 * @param string       $content The text to ignore.
	 * @return string
	 */
	public function ignore( $atts, string $content = '' ) { //phpcs:ignore
		return '<glwrap>' . \do_shortcode( $content ) . '</glwrap>';
	}

	/**
	 * Parse the content with Glossary
	 *
	 * @param array|string $atts The attributes, not used.
	 * @param string       $text The text to parse.
	 * @return string
	 */
	public function parser( $atts, string $text ) { //phpcs:ignore
		if ( !\is_object( $this->search_engine ) ) {
			$this->search_engine = \apply_filters( 'glossary_instance_Glossary\Frontend\Core\Search_Engine', '' );

			if ( $this->search_engine === '' ) {
				$this->search_engine = new \Glossary\Frontend\Core\Search_Engine;
			}
		}

		return $this->search_engine->auto_link( $text );
	}

}
