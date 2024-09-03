<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'CP_Timeline_Helper' ) ) {

	/**
	 * Class 
	 */
	final class CP_Timeline_Helper {


		/**
		 * Member Variable
		 *
		 * @since 0.0.1
		 * @var instance
		 */
		private static $instance;
	
		/**
		 *  Initiator
		 *
		 * @since 0.0.1
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		

        public static function cp_timeline_post_type(){
            $post_types = get_post_types(
                array(
                    'public'       => true,
                    'show_in_rest' => true,
                ),
                'objects'
            );
        
            $options = array();
    
            foreach ( $post_types as $post_type ) {
                if ( 'attachment' === $post_type->name ) {
                    continue;
                }
                if ( 'page' === $post_type->name ) {
                    continue;
                }
        
                $options[] = array(
                    'value' => $post_type->name,
                    'label' => $post_type->label,
                );
            }
        
            return apply_filters( 'cp_timeline_loop_post_types', $options );
        }

        public static function get_related_taxonomy() {

			$post_types = self::cp_timeline_post_type();

			$return_array = array();

			foreach ( $post_types as $key => $value ) {
				$post_type = $value['value'];

				$taxonomies = get_object_taxonomies( $post_type, 'objects' );
				$data       = array();

				foreach ( $taxonomies as $tax_slug => $tax ) {
					if ( ! $tax->public || ! $tax->show_ui || ! $tax->show_in_rest ) {
						continue;
					}

					$data[ $tax_slug ] = $tax;

					$terms = get_terms( $tax_slug );

					$related_tax = array();

					if ( ! empty( $terms ) ) {
						foreach ( $terms as $t_index => $t_obj ) {
							$related_tax[] = array(
								'id'    => $t_obj->term_id,
								'name'  => $t_obj->name,
								'child' => get_term_children( $t_obj->term_id, $tax_slug ),
							);
						}
						$return_array[ $post_type ]['terms'][ $tax_slug ] = $related_tax;
					}
				}

				$return_array[ $post_type ]['taxonomy'] = $data;

			}

			return apply_filters( 'cp_timeline_post_loop_taxonomies', $return_array );
		}


		public static function get_query( $attributes, $block_type ) {

		
			$query_args = array(
				'posts_per_page'      => ( isset( $attributes['post_per_page'] ) ) ? $attributes['post_per_page'] : 6,
				'post_status'         => (isset( $attributes['postStatus'] ) ) ? $attributes['postStatus'] : 'publish',
				'post_type'           => ( isset( $attributes['post_type'] ) ) ? $attributes['post_type'] : 'post',
				'order'               => ( isset( $attributes['order'] ) ) ? $attributes['order'] : 'desc',
				'orderby'             => ( isset( $attributes['orderBy'] ) ) ? $attributes['orderBy'] : 'date',
				'ignore_sticky_posts' => 1,
				'paged'               => 1,
			);

			$query_args['post__not_in'] = array( get_the_ID() );

			if ( isset( $attributes['categories'] ) && '' !== $attributes['categories'] ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => ( isset( $attributes['taxonomyType'] ) ) ? $attributes['taxonomyType'] : 'category',
					'field'    => 'id',
					'terms'    => $attributes['categories'],
					'operator' => 'IN',
				);
			}

		
			$query_args = apply_filters( "cp_timeline_post_query_args_{$block_type}", $query_args, $attributes );

			return new WP_Query( $query_args );
		}

		public static function cp_timeline_get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes       = get_intermediate_image_sizes();
			$image_sizes = array();

			$image_sizes[] = array(
				'value' => 'full',
				'label' => esc_html__( 'Full' ),
			);

			foreach ( $sizes as $size ) {
				if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ), true ) ) {
					$image_sizes[] = array(
						'value' => $size,
						'label' => ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
					);
				} else {
					$image_sizes[] = array(
						'value' => $size,
						'label' => sprintf(
							'%1$s (%2$sx%3$s)',
							ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
							$_wp_additional_image_sizes[ $size ]['width'],
							$_wp_additional_image_sizes[ $size ]['height']
						),
					);
				}
			}

			$image_sizes = apply_filters( 'cp_timeline_post_featured_image_sizes', $image_sizes );

			return $image_sizes;
		}


		/**
		 * Generate SVG.
		 *
		 * @since 1.8.1
		 * @param  array $icon Decoded fontawesome json file data.
		 */
		public static function render_svg_html( $icon ) {
			$icon = str_replace( 'far', '', $icon );
			$icon = str_replace( 'fas', '', $icon );
			$icon = str_replace( 'fab', '', $icon );
			$icon = str_replace( 'fa-', '', $icon );
			$icon = str_replace( 'fa', '', $icon );
			$icon = sanitize_text_field( esc_attr( $icon ) );
			$json_file =  CTP_PLUGIN_DIR.'includes/cool-timeline-block/assets/icon/CTBIcon.json';
			if ( ! file_exists( $json_file ) ) {
				return array();
			}
			$res = file_get_contents($json_file);
			$json = json_decode($res); 
			$path = isset( $json->$icon->svg->brands ) ? $json->$icon->svg->brands->path : $json->$icon->svg->solid->path;
			$view = isset( $json->$icon->svg->brands ) ? $json->$icon->svg->brands->viewBox : $json->$icon->svg->solid->viewBox;
			if ( $view ) {
				$view = implode( ' ', $view );
			}
			?>
			<svg xmlns="https://www.w3.org/2000/svg" viewBox= "<?php echo esc_html( $view ); ?>"><path d="<?php echo esc_html( $path ); ?>"></path></svg>
			<?php
		}
    }
    CP_Timeline_Helper::get_instance();
    }