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

namespace Glossary\Integrations\Widgets;

/**
 * Search terms wdiget
 */
class Search extends \WPH_Widget {

	/**
	 * Initialize the widget
	 *
	 * @return void
	 */
	public function __construct() {
		$args = array(
			'label'       => \__( 'Glossary Search Terms', GT_TEXTDOMAIN ),
			'description' => \__( 'Search in Glossary Terms', GT_TEXTDOMAIN ),
			'slug'        => 'glossary-search-terms',
		);

		$args[ 'fields' ] = array(
			array(
				'name'     => \__( 'Title', GT_TEXTDOMAIN ),
				'desc'     => \__( 'Enter the widget title.', GT_TEXTDOMAIN ),
				'id'       => 'title',
				'type'     => 'text',
				'class'    => 'widefat',
				'validate' => 'alpha_dash',
				'filter'   => 'strip_tags|esc_attr',
			),
			array(
				'name'  => \__( 'Add a dropdown for category based filtering', GT_TEXTDOMAIN ),
				'id'    => 'taxonomy',
				'type'  => 'checkbox',
				'class' => 'widefat',
			),
		);

		$this->create_widget( $args );
	}

	/**
	 * Print the widget
	 *
	 * @param array $args     Parameters.
	 * @param array $instance Values.
	 * @return void
	 */
	public function widget( $args, $instance ) { //phpcs:ignore
		$search = $taxonomy = $cat = '';
		$out    = $args[ 'before_widget' ];
		$out   .= '<div class="glossary-search-terms">';

		if ( isset( $instance[ 'title' ] ) ) {
			$out .= $args[ 'before_title' ];
			$out .= $instance[ 'title' ];
			$out .= $args[ 'after_title' ];
		}

		if ( isset( $_GET[ 's' ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$search = \esc_html( $_GET[ 's' ] ); // phpcs:ignore WordPress.Security
			$cat    = \esc_html( $_GET[ 'glossary-cat' ] ); // phpcs:ignore WordPress.Security
		}

		if ( !empty( $instance[ 'taxonomy' ] ) ) {
			$taxonomy = \wp_dropdown_categories(
					array(
						'taxonomy'          => 'glossary-cat',
						'value_field'       => 'slug',
						'name'              => 'glossary-cat',
						'show_option_none'  => \__( 'Select Glossary Category', GT_TEXTDOMAIN ),
						'option_none_value' => '0',
						'echo'              => 0,
						'hierarchical'      => 1,
						'order'             => 'ASC',
						'selected'          => $cat,
					)
			);
			$taxonomy = '<label for="glossary-cat" class="screen-reader-text">' . \__( 'Select Glossary Category', GT_TEXTDOMAIN ) . '</label>' . $taxonomy;
		}

		$out .= '<form role="search" class="search-form" method="get" id="searchform" action="' . \home_url( '/' ) . '">'
			. '<input type="hidden" name="post_type" value="glossary" /><input type="text" aria-label="' . \__( 'Search', GT_TEXTDOMAIN ) . '" value="' . $search . '" name="s" />'
			. '<input type="submit" value="' . \__( 'Search', GT_TEXTDOMAIN ) . '" />'
			. $taxonomy . '</form>';
		$out .= '</div>' . $args[ 'after_widget' ];
		echo $out; // phpcs:ignore
	}

	/**
	 * Initialize the class.
	 *
	 * @return void
	 */
	public function initialize() {
		\add_action(
		'widgets_init',
		static function () {
			\register_widget( 'Glossary\Integrations\Widgets\Search' );
		}
		);
	}

}
