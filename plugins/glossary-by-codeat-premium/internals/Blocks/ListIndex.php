<?php

/**
 * Glossary
 *
 * @package   Glossary
 * @author    Codeat <support@codeat.co>
 * @copyright 2020
 * @license   GPL 2.0+
 * @link      https://codeat.co
 */

namespace Glossary\Internals\Blocks;

/**
 * Glossary List Block
 */
class ListIndex extends \WP_V2_Super_Duper {

	/**
	 * Empty method to support the parent class
	 */
	public function __construct() {
	}

	/**
	 * Initialize the Glossary List Block
	 *
	 * @return void
	 */
	public function initialize() {
		\add_action( 'init', array( $this, 'load_options' ), 9999 );
	}

	/**
	 * Execute after init so taxonomies are defined
	 *
	 * @return void
	 */
	public function load_options() {
		$categories = get_terms( array(
			'taxonomy' => 'glossary-cat',
		) );

		$glossary_cat = array('' => __( 'Disabled', GT_TEXTDOMAIN ) );
		if ( is_array( $categories ) ) {
			foreach($categories as $cat) {
				if ( is_object( $cat ) ) {
					$glossary_cat[$cat->slug] = $cat->name;
				}
			}
		}

		$options = array(
			'textdomain'       => GT_TEXTDOMAIN,
			'block-icon'       => 'book-alt',
			'block-category'   => 'text',
			'block-keywords'   => "['glossary','list','index']",
			'block-editor-style'   => \plugins_url( 'assets/css/css-pro/shortcode.css', GT_PLUGIN_ABSOLUTE ),
			'widget_ops'       => array(
				'description' => \esc_html__( 'Glossary Index', GT_TEXTDOMAIN ),
			),
			'class_name'       => 'list',
			'base_id'          => 'glossary-list',
			'output_types'     => array( 'block' ),
			'name'             => \__( 'Glossary List', GT_TEXTDOMAIN ),
			'arguments'        => array(
				'letter-anchor' => array(
					'type'     => 'checkbox',
					'title'    => \__( 'Letter Anchor', GT_TEXTDOMAIN ),
					'desc'     => \__( 'Regulates how the letter is linked to its anchorage: within the same list or to its archive page', GT_TEXTDOMAIN ),
					'desc_tip' => true,
					'default'  => true,
					'advanced' => false,
				),
				'term-anchor' => array(
					'type'     => 'checkbox',
					'title'    => \__( 'Term Anchor', GT_TEXTDOMAIN ),
					'desc'     => \__( 'The terms in the list will have links', GT_TEXTDOMAIN ),
					'desc_tip' => true,
					'default'  => true,
					'advanced' => false,
				),
				'custom-url' => array(
					'type'     => 'checkbox',
					'title'    => \__( 'Custom Term Url', GT_TEXTDOMAIN ),
					'desc'     => \__( 'Print the Internal/External URL set in the term', GT_TEXTDOMAIN ),
					'desc_tip' => true,
					'default'  => false,
					'advanced' => false,
				),
				'empty-letters' => array(
					'type'     => 'checkbox',
					'title'    => \__( 'Alphabetical Bar Letters visibility', GT_TEXTDOMAIN ),
					'desc'     => \__( 'Show all letters, including those containing no terms', GT_TEXTDOMAIN ),
					'desc_tip' => true,
					'default'  => true,
					'advanced' => false,
				),
				'show-letter'      => array(
					'type'        => 'text',
					'title'       => \__( 'Letters and their terms to show', GT_TEXTDOMAIN ),
					'desc'        => \__( 'If you need to enter more than one letter, separate them with a comma.', GT_TEXTDOMAIN ),
					'desc_tip'    => true,
					'default'     => '',
					'advanced'    => false,
				),
				'theme'       => array(
					'type'     => 'select',
					'title'    => \__( 'Theme', GT_TEXTDOMAIN ),
					'options'  => array(
						'default' => __( 'Default', GT_TEXTDOMAIN ),
						'grid' => __( 'Grid', GT_TEXTDOMAIN ),
						'summary' => __( 'Summary', GT_TEXTDOMAIN ),
					),
					'default'  => 'default',
					'advanced' => false,
				),
				'search'       => array(
					'type'     => 'select',
					'title'    => \__( 'Search', GT_TEXTDOMAIN ),
					'options'  => array(
						'disabled' => __( 'Disabled', GT_TEXTDOMAIN ),
						'scroll' => __( 'Scroll', GT_TEXTDOMAIN ),
						'scroll-bottom' => __( 'Bottom Scroll', GT_TEXTDOMAIN ),
						'no-=scroll' => __( 'No Scroll', GT_TEXTDOMAIN ),
					),
					'desc_tip' => true,
					'default'  => 'default',
					'advanced' => false,
				),
				'taxonomy'       => array(
					'type'     => 'multiselect',
					'title'    => \__( 'Taxonomy', GT_TEXTDOMAIN ),
					'desc'     => \__( 'Allows you to filter your list through Glossary taxonomies', GT_TEXTDOMAIN ),
					'options'  => $glossary_cat,
					'desc_tip' => true,
					'default'  => '',
					'advanced' => false,
				),
				'_content' => array(
					'type'     => 'checkbox',
					'title'    => \__( 'Show the content', GT_TEXTDOMAIN ),
					'desc'     => \__( 'Show the content alongside the term', GT_TEXTDOMAIN ),
					'desc_tip' => true,
					'default'  => false,
					'advanced' => false,
				),
				'excerpt' => array(
					'type'     => 'checkbox',
					'title'    => \__( 'Show the excerpt', GT_TEXTDOMAIN ),
					'desc'     => \__( 'Show the excerpt alongside the term', GT_TEXTDOMAIN ),
					'desc_tip' => true,
					'default'  => false,
					'advanced' => false,
				),
			),
		);

		parent::__construct( $options );
	}

}

