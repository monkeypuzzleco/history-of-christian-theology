<?php
/**
 * CTL Ajax Handler
 *
 * @package CTL
 */

/**
 * Do not access the page directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle Cool Timeline ajax requests
 */
if ( ! class_exists( 'CTL_Ajax_Handler' ) ) {

	/**
	 * Class Ajax Hanlder.
	 *
	 * @package CTL
	 */
	class CTL_Ajax_Handler {


		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;


		/**
		 * Member Variable.
		 *
		 * @var array
		 */
		public $attributes;

		/**
		 * Member Variable.
		 *
		 * @var WP_Query
		 */
		public $wp_query;

		/**
		 * Member Variable.
		 *
		 * @var array
		 */
		public $settings;

		/**
		 * Member Variable.
		 *
		 * @var CTL_Loop_Helpers
		 */
		public $content_instance;


		/**
		 * Gets an instance of our plugin.
		 *
		 * @param object $settings_obj timeline settings.
		 */
		public static function get_instance( $settings_obj ) {
			if ( null === self::$instance ) {
				self::$instance = new self( $settings_obj );
			}
			return self::$instance;
		}

		/**
		 * Member Variable.
		 *
		 * @var Timeline_Id
		 */
		public $timeline_id;

		/**
		 * Constructor.
		 *
		 * @param object $settings_obj Plugin settings.
		 */
		public function __construct( $settings_obj ) {
			$this->settings = $settings_obj->ctl_get_settings();

			/*
			* Story timeline ajax load more ajax request handler hooks
			*/
			add_action( 'wp_ajax_ctl_ajax_load_more', array( $this, 'ctp_story_loadmore_handler' ) );
			add_action( 'wp_ajax_nopriv_ctl_ajax_load_more', array( $this, 'ctp_story_loadmore_handler' ) );

			/*
			* Post timeline ajax load more ajax request handler hooks
			*/
			add_action( 'wp_ajax_ctl_post_ajax_load_more', array( $this, 'ctp_post_loadmore_handler' ) );
			add_action( 'wp_ajax_nopriv_ctl_post_ajax_load_more', array( $this, 'ctp_post_loadmore_handler' ) );
		}

		/**
		 * Cool Timeline story load more handler
		 */
		public function ctp_story_loadmore_handler() {
			if ( ! check_ajax_referer( 'ctp_load_more_nonce', 'ajax_nonce', false ) ) {
				wp_send_json_error( __( 'Invalid security token sent.', 'cool-timeline' ) );
				wp_die( '0', 400 );
			}
			$attributes   = isset( $_POST['attributes'] ) ? json_decode( stripslashes( $_POST['attributes'] ), true ) : array();
			$paged        = isset( $_POST['page_number'] ) ? sanitize_text_field( $_POST['page_number'] ) : '';
			$new_timeline = isset( $_POST['new_timeline'] ) ? sanitize_text_field( $_POST['new_timeline'] ) : false;

			$active_year = isset( $_POST['active_year'] ) ? sanitize_text_field( $_POST['active_year'] ) : '';

			$last_story_index                    = isset( $_POST['last_story_index'] ) ? sanitize_text_field( $_POST['last_story_index'] ) : '';
			$response                            = '';
			$attributes['paged']                 = $paged;
			$wp_query                            = CTL_Query_Builder::story_get_query( $attributes, $this->settings );
			$attributes['config']['active_year'] = $active_year;
			$this->content_instance              = new CTL_Loop_Helpers( $attributes, $this->settings );

			$pagination = null;

			if ( 'true' === $new_timeline && $wp_query->max_num_pages > 1 ) {
				$pagination = CTL_Helpers::ctl_load_more( $wp_query, $paged );
			}

			$response                  = $this->ctl_render_loop( $wp_query, $last_story_index, $attributes );
			$response['newPagination'] = $pagination;

			wp_send_json_success( $response );
			wp_die();
		}

		/**
		 * Renders the story timeline.
		 *
		 * @param WP_Query $query WP_Query object.
		 * @param int      $index timeline index number.
		 * @param object   $attributes shortcode attributes.
		 * @return string The rendered stories HTML.
		 */
		private function ctl_render_loop( $query, $index, $attributes ) {
			$output             = '';
			$story_styles       = '';
			$hr_default_slider  = null;
			$nav_slider_designs = array( 'default', 'design-6' );
			// The Loop.
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					global $post;
					$output            .= $this->content_instance->ctl_render( $index, $post );
					$hr_default_slider .= $this->content_instance->ctl_hr_nav_slider( $index, $post->ID );
					if ( 'post_timeline' !== $attributes['ctl_type'] ) {
						$story_styles .= $this->content_instance->ctl_story_color( $post->ID );
					}
					$index++;
				}
			} else {
				$output .= '<div class="no-content"><h4>';
				$output .= __( 'Sorry,You have not added any story yet', 'cool-timeline' );
				$output .= '</h4></div>';
			}

			wp_reset_postdata();
			$data = array(
				'HTML' => $output,
			);

			if ( 'post_timeline' !== $attributes['ctl_type'] ) {
				$data['CSS'] = $story_styles;
			}

			if ( in_array( $attributes['designs'], $nav_slider_designs, true ) ) {
				$data['HR_NAV_SLIDER'] = $hr_default_slider;
			}

			return $data;
		}

		/**
		 * Cool Timeline Post load more handler
		 */
		public function ctp_post_loadmore_handler() {
			if ( ! check_ajax_referer( 'ctp_load_more_nonce', 'ajax_nonce', false ) ) {
				wp_send_json_error( __( 'Invalid security token sent.', 'cool-timeline' ) );
				wp_die( '0', 400 );
			}

			$attributes   = isset( $_POST['attributes'] ) ? json_decode( stripslashes( $_POST['attributes'] ), true ) : array();
			$paged        = isset( $_POST['page_number'] ) ? sanitize_text_field( $_POST['page_number'] ) : '';
			$new_timeline = isset( $_POST['new_timeline'] ) ? sanitize_text_field( $_POST['new_timeline'] ) : false;

			$active_year = isset( $_POST['active_year'] ) ? sanitize_text_field( $_POST['active_year'] ) : '';

			$last_story_index                    = isset( $_POST['last_story_index'] ) ? sanitize_text_field( $_POST['last_story_index'] ) : '';
			$response                            = '';
			$attributes['paged']                 = $paged;
			$attributes['post-category']         = isset( $attributes['category'] ) && 'all' !== $attributes['category'] ? $attributes['category'] : '';
			$wp_query                            = CTL_Query_Builder::post_get_query( $attributes, $this->settings );
			$attributes['config']['active_year'] = $active_year;
			$this->content_instance              = new CTL_Post_Loop_Helpers( $attributes, $this->settings );

			$pagination = null;

			if ( 'true' === $new_timeline && $wp_query->max_num_pages > 1 ) {
				$pagination = CTL_Helpers::ctl_load_more( $wp_query, $paged );
			}

			$response                  = $this->ctl_render_loop( $wp_query, $last_story_index, $attributes );
			$response['newPagination'] = $pagination;

			wp_send_json_success( $response );
			wp_die();
		}
	}
}
