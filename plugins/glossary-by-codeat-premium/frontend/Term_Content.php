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

namespace Glossary\Frontend;

use Glossary\Engine;

/**
 * Generate the css in the frontend
 */
class Term_Content extends Engine\Base {

	/**
	 * Initialize the class
	 *
	 * @param bool $nocontent Add the_content filter support.
	 */
	public function __construct( bool $nocontent = false ) {
		if ( $nocontent ) {
			return;
		}

		// 9998 To avoid Ninja Forms
		\add_filter( 'the_content', array( $this, 'add_custom_fields' ), 9998 );
	}

	/**
	 * Append custom fields to content
	 *
	 * @param string $content The post content.
	 * @since 2.1.0
	 * @return string HTML
	 */
	public function add_custom_fields( string $content ) {
		if ( 'glossary' === \get_post_type() && !\is_post_type_archive() && !\is_search() ) {
			return $this->custom_fields( (int) \get_the_ID(), $content );
		}

		return $content;
	}

	/**
	 * Append the list of custom fields in the term content
	 *
	 * @param int    $post_id The post ID.
	 * @param string $content The post content.
	 * @since 1.2.0
	 * @return string HTML
	 */
	public function custom_fields( int $post_id, string $content ) {
		$custom_fields = \gl_get_settings_extra();

		if ( empty( $custom_fields[ 'custom_fields' ] ) ) {
			return $content;
		}

		$content .= $this->table_output( $post_id, $custom_fields[ 'custom_fields' ] );

		return $content;
	}

	/**
	 * Table output of custom fields
	 *
	 * @param int   $post_id       The post ID.
	 * @param array $custom_fields List of fields.
	 * @return string
	 */
	public function table_output( int $post_id, array $custom_fields ) {
		$print  = '';
		$fields = array();

		if ( !empty( $custom_fields ) ) {
			foreach ( $custom_fields as $field_name ) {
				$field_name          = \trim( $field_name );
				$field_id            = \str_replace( ' ', '', \strtolower( $field_name ) );
				$fields[ $field_id ] = $field_name;
			}

			/**
			 * Array with all the fields and their values before to print it
			 *
			 * @param array $fields The array.
			 * @since 1.2.0
			 * @return array $fields The array filtered.
			*/
			$fields = \apply_filters( 'glossary_customizer_fields_list', $fields );
			$print  = $this->generate_table( $post_id, $fields );
		}

		/**
		 * String with all the HTML before to print
		 *
		 * @param string $print HTML.
		 * @param array $fields The array.
		 * @since 1.2.0
		 * @return string $print HTML filtered.
		 */
		return \apply_filters( 'glossary_customizer_fields_output', $print, $fields );
	}

	/**
	 * Generate table by fields
	 *
	 * @param int   $post_id The post ID.
	 * @param array $fields  List of fields.
	 * @return string
	 */
	public function generate_table( int $post_id, array $fields ) {
		$print = $table_content = '';

		foreach ( $fields as $field_id => $field_name ) {
			$value = \get_post_meta( (int) $post_id, 'glossary-by-codeat_' . $field_id, true );

			if ( empty( $value ) ) {
				continue;
			}

			$table_content .= '<tr>';
			$table_content .= '<td>' . $field_name . '</td>';
			$table_content .= '<td>' . $value . '</td>';
			$table_content .= '</tr>';
		}

		if ( !empty( $table_content ) ) {
			$print = '<table class="glossary-custom-fields">' . $table_content . '</table>';
		}

		return $print;
	}

}
