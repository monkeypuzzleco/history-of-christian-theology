<?php

/**
 * Glossary
 *
 * @package   Glossary
 * @author  Codeat <support@codeat.co>
 * @copyright 2020
 * @license   GPL 3.0+
 * @link      https://codeat.co
 */

namespace Glossary\Integrations;

/**
 * All the CMB related code.
 */
class CMB_Metabox_Premium extends CMB_Metabox {

	/**
	 * CMB metabox
	 *
	 * @var object
	 */
	public $cmb_post;

	/**
	 * Initialize class.
	 *
	 * @since 2.0
	 * @return bool
	 */
	public function initialize() {
		parent::initialize();

		if ( empty( $this->settings[ 'posttypes' ] ) ) {
			$this->settings[ 'posttypes' ] = array( 'post' );
		}

		\add_action( 'cmb2_init', array( $this, 'glossary_custom_fields' ) );
		\add_action( 'cmb2_init', array( $this, 'post_override_premium' ) );

		return true;
	}

	/**
	 * Metabox for post types for Premium
	 *
	 * @return void
	 */
	public function post_override_premium() {
		$taxs = $this->get_terms( 0 );

		if ( !\is_array( $taxs ) ) {
				return;
		}

		$cmb_tax = array();

		foreach ( $taxs as $item ) {
			$cmb_tax[ $item->term_id ] = $item->name;

			$terms_of_taxonomy = $this->get_terms( $item->term_id );

			if ( !\is_array( $terms_of_taxonomy ) ) {
				continue;
			}

			foreach ( $terms_of_taxonomy as $subitem ) {
				$cmb_tax[ $subitem->term_id ] = '- ' . $subitem->name;
			}
		}

		$this->cmb_post->add_field(
			array(
				'name'    => \__( 'Select specific glossary categories', 'glossary-by-codeat' ),
				'desc'    => \__(
					'By selecting one or more categories, only terms belonging to these will be linked',
					'glossary-by-codeat'
				),
				'id'      => GT_SETTINGS . '_filter_tax',
				'type'    => 'multicheck',
				'options' => $cmb_tax,
			)
		);
	}

	/**
	 * Metabox for custom fields
	 *
	 * @return bool
	 */
	public function glossary_custom_fields() {
		$custom_fields = \gl_get_settings_extra();

		if ( !\is_iterable( $custom_fields ) || !isset( $custom_fields[ 'custom_fields' ] ) ) {
			return false;
		}

		$custom_fields = $custom_fields[ 'custom_fields' ];
		$cmb_custom    = \new_cmb2_box(
		array(
			'id'           => 'glossary_custom_metabox',
			'title'        => \__( 'Glossary Custom Fields', 'glossary-by-codeat' ),
			'object_types' => array( 'glossary' ),
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true,
			)
		);

		if ( empty( $custom_fields ) ) {
			return false;
		}

		foreach ( $custom_fields as $field_name ) {
			$field_name = \trim( $field_name );
			$field_id   = \str_replace( ' ', '', \strtolower( $field_name ) );
			$cmb_custom->add_field(
				array(
					'name' => $field_name,
					'id'   => 'glossary-by-codeat_' . $field_id,
					'type' => \apply_filters( 'glossary_custom_field_type', 'text', $field_id ),
				)
			);
		}

		return true;
	}

	/**
	 * Get taxonomy terms of Glossary
	 *
	 * @param int $parent_id The parent ID.
	 * @return bool|array
	 */
	private function get_terms( int $parent_id ) {
		$terms = \get_terms( array( 'taxonomy' => 'glossary-cat', 'hide_empty' => false, 'orderby' => 'name', 'parent' => $parent_id ) );

		if ( !\is_iterable( $terms ) || empty( $terms ) ) {
			return false;
		}

		return $terms;
	}

}
