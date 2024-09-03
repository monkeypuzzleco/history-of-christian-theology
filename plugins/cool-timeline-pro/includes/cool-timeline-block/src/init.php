<?php


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_assets', 'GCTLP_timeline_block_editor_assets' );

function GCTLP_timeline_block_editor_assets() {
	$id = get_the_ID();

	$blocks                  = parse_blocks( get_the_content( null, false, $id ) );
	$timeline_reusable_block = false;
	foreach ( $blocks as $block ) {
		if ( isset( $block['blockName'] ) && 'core/block' === $block['blockName'] ) {
			$reusableBlockid = isset( $block['attrs']['ref'] ) ? $block['attrs']['ref'] : false;
			if ( false !== $reusableBlockid && 'integer' === gettype( $reusableBlockid ) ) {
				$timeline_reusable_block = has_block( 'cp-timeline/content-timeline', $reusableBlockid );
			}
		}
	}

	if ( has_block( 'cp-timeline/content-timeline', $id ) || $timeline_reusable_block ) {
		if ( ! wp_style_is( 'ctl_swiper_style', 'enqueued' ) ) {
			wp_enqueue_style(
				'ctl_swiper_style', // Handle
				CTP_PLUGIN_URL . 'includes/shortcodes/assets/css/swiper.min.css',
				null,
				CTLPV,
				'all'
			);
		}

		if ( ! wp_script_is( 'ctl_swiper_script', 'enqueued' ) ) {
			wp_enqueue_script( 'ctl_swiper_script', CTP_PLUGIN_URL . 'includes/shortcodes/assets/js/swiper.min.js', array( 'jquery' ), CTLPV, false );
		}

		if ( ! wp_style_is( 'aos_css', 'enqueued' ) ) {
			wp_enqueue_style( 'aos_css', CTP_PLUGIN_URL . 'includes/shortcodes/assets/css/aos.css', null, CTLPV, 'all' );
		}

		if ( ! wp_script_is( 'aos_js', 'enqueued' ) ) {
			wp_enqueue_script( 'aos_js', CTP_PLUGIN_URL . 'includes/shortcodes/assets/js/aos.js', array( 'jquery' ), CTLPV, true );
		}

		wp_enqueue_script(
			'timeline-block-block-slider-js', // Handle.
			plugin_dir_url( __FILE__ ) . '../assets/js/slider.min.js',
			array( 'jquery' ),
			null,
			true
		);

		wp_enqueue_script(
			'timeline-block-block-vr-js', // Handle.
			plugin_dir_url( __FILE__ ) . '../assets/js/ctlb-vertical.min.js',
			array( 'jquery' ),
			null,
			true
		);

		wp_enqueue_style(
			'cp_timeline-cgb-style-css', // Handle.
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
			is_admin() ? array( 'wp-editor' ) : null,
			null
		);

	}

}

add_action( 'enqueue_block_editor_assets', 'GCTLP_editor_side_css' );
function GCTLP_editor_side_css() {
		wp_enqueue_style(
			'ctl_swiper_style',
			CTP_PLUGIN_URL . 'includes/shortcodes/assets/css/swiper.min.css',
			null,
			CTLPV,
			'all'
		);
		wp_enqueue_style(
			'timeline-block-block-common-css', // Handle
			plugin_dir_url( __FILE__ ) . '../assets/common-block-editor.css'
		);
		wp_enqueue_script( 'ctl_swiper_script', CTP_PLUGIN_URL . 'includes/shortcodes/assets/js/swiper.min.js', array( 'jquery' ), CTLPV, false );

		wp_enqueue_script(
			'timeline-block-block-slider-js', // Handle.
			plugin_dir_url( __FILE__ ) . '../assets/js/slider.min.js',
			array( 'jquery' ),
			null,
			true
		);

		wp_enqueue_style(
			'cp_timeline-cgb-style-css', // Handle.
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
			is_admin() ? array( 'wp-editor' ) : null,
			null
		);

		wp_enqueue_script(
			'cp_timeline-cgb-block-js', // Handle.
			plugins_url( 'dist/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
			null,
			true
		);

		wp_enqueue_style(
			'cp_timeline-cgb-block-editor-css', // Handle.
			plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
			array( 'wp-edit-blocks' ),
			null
		);

		wp_localize_script(
			'cp_timeline-cgb-block-js',
			'cp_timeline',
			array(
				'pluginDirPath' => plugin_dir_path( __DIR__ ),
				'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			)
		);

}

add_action( 'wp_head', 'GCTLP_timeline_block_load_post_assets' );
function GCTLP_timeline_block_load_post_assets() {
	global $post;
	$this_post = $post;
	if ( ! is_object( $this_post ) ) {
		return;
	}
	$this_post = apply_filters( 'timeline-block_post_for_stylesheet', $this_post );
	if ( ! is_object( $this_post ) ) {
		return;
	}

	if ( ! isset( $this_post->ID ) ) {
		return;
	}

	if ( has_blocks( $this_post->ID ) && isset( $this_post->post_content ) ) {

		$blocks      = parse_blocks( $this_post->post_content );
		$page_blocks = $blocks;

		if ( ! is_array( $page_blocks ) || empty( $page_blocks ) ) {
			return;
		}
		foreach ( $page_blocks as $i => $block ) {

			if ( is_array( $block ) ) {

				if ( '' === $block['blockName'] ) {
					continue;
				}
				$default_Fonts = array( '', 'Arial', 'Helvetica', 'Times New Roman', 'Georgia' );
				if ( isset( $block['attrs']['headFontFamily'] ) ) {
					if ( ! in_array( $block['attrs']['headFontFamily'], $default_Fonts ) ) {
						$headFont = array();
						array_push( $headFont, $block['attrs']['headFontFamily'] );
						if ( isset( $block['attrs']['headFontWeight'] ) ) {
							array_push( $headFont, $block['attrs']['headFontWeight'] );
						}
						if ( isset( $block['attrs']['headFontSubset'] ) ) {
							array_push( $headFont, $block['attrs']['headFontSubset'] );
						}
						echo '<link href="//fonts.googleapis.com/css?family=' . esc_attr( implode( ':', $headFont ) ) . '" rel="stylesheet">';
					}
				}
				if ( isset( $block['attrs']['subHeadFontFamily'] ) ) {
					if ( ! in_array( $block['attrs']['subHeadFontFamily'], $default_Fonts ) ) {
						$subheadFont = array();
						array_push( $subheadFont, $block['attrs']['subHeadFontFamily'] );
						if ( isset( $block['attrs']['subHeadFontWeight'] ) ) {
							array_push( $subheadFont, $block['attrs']['subHeadFontWeight'] );
						}
						if ( isset( $block['attrs']['subHeadFontSubset'] ) ) {
							array_push( $subheadFont, $block['attrs']['subHeadFontSubset'] );
						}
						echo '<link href="//fonts.googleapis.com/css?family=' . esc_attr( implode( ':', $subheadFont ) ) . '" rel="stylesheet">';
					}
				}
				if ( isset( $block['attrs']['dateFontFamily'] ) ) {
					if ( ! in_array( $block['attrs']['dateFontFamily'], $default_Fonts ) ) {
						$dateFont = array();
						array_push( $dateFont, $block['attrs']['dateFontFamily'] );
						if ( isset( $block['attrs']['dateFontWeight'] ) ) {
							array_push( $dateFont, $block['attrs']['dateFontWeight'] );
						}
						if ( isset( $block['attrs']['dateFontSubset'] ) ) {
							array_push( $dateFont, $block['attrs']['dateFontSubset'] );
						}
						echo '<link href="//fonts.googleapis.com/css?family=' . esc_attr( implode( ':', $dateFont ) ) . '" rel="stylesheet">';
					}
				}
			}
		}
	}

}


function GCTLP_cp_timeline_cgb_block_assets() {

	if ( function_exists( 'register_block_type' ) ) {
		register_block_type(
			'cp-timeline/content-timeline',
			array(
				'api_version' => 2,
			)
		);
		register_block_type(
			'cp-timeline/content-timeline-child',
			array(
				'api_version' => 2,
			)
		);
	}
}

// Hook: Block assets.
add_action( 'init', 'GCTLP_cp_timeline_cgb_block_assets' );
