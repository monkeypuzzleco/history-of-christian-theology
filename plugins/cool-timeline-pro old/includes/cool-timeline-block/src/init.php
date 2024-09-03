<?php


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_assets','GCTLP_timeline_block_editor_assets'  );

function GCTLP_timeline_block_editor_assets(){
			$id = get_the_ID();	
			
			if (has_block('cp-timeline/content-timeline', $id) || has_block('cp-timeline/post-timeline', $id) ) {
		wp_enqueue_style(
			'timeline-block
		-block-swiper-css', // Handle
			 plugin_dir_url( __FILE__ ). '../assets/swiper/swiper.css'
		);
	
		wp_enqueue_script(
			'timeline-block
		-block-swiper-js', // Handle.
			 plugin_dir_url( __FILE__ ). '../assets/swiper/swiper.js', array(),null,true
			
		);
	
		wp_enqueue_script(
			'timeline-block
		-block-slider-js', // Handle.
			 plugin_dir_url( __FILE__ ). '../assets/js/slider.js', array("jquery"),null,true
			
		);
		wp_enqueue_style(
			'cp_timeline-cgb-style-css', // Handle.
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), 
			is_admin() ? array( 'wp-editor' ) : null, 
			null 
		);

	}
	
}

add_action("enqueue_block_editor_assets","GCTLP_editor_side_css");
function GCTLP_editor_side_css(){
		wp_enqueue_style(
			'timeline-block
		-block-swiper-css', // Handle
			 plugin_dir_url( __FILE__ ). '../assets/swiper/swiper.css'
		);
		wp_enqueue_style(
			'timeline-block
		-block-common-css', // Handle
			 plugin_dir_url( __FILE__ ). '../assets/common-block-editor.css'
		);
	
		wp_enqueue_script(
			'timeline-block
		-block-swiper-js', // Handle.
			 plugin_dir_url( __FILE__ ). '../assets/swiper/swiper.js', array(),null,true
			
		);
	
		wp_enqueue_script(
			'timeline-block
		-block-slider-js', // Handle.
			 plugin_dir_url( __FILE__ ). '../assets/js/slider.js', array("jquery"),null,true
			
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
			[
				'pluginDirPath' => plugin_dir_path( __DIR__ ),
				'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
				'post_type'  => CP_Timeline_Helper::cp_timeline_post_type(),
				'all_taxnomy'  => CP_Timeline_Helper::get_related_taxonomy(),
				'image_sizes'  => CP_Timeline_Helper::cp_timeline_get_image_sizes()
				
			]
		);

}

add_action( 'wp_head','GCTLP_timeline_block_load_post_assets');
	function GCTLP_timeline_block_load_post_assets(){ 
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

			$blocks= parse_blocks( $this_post->post_content );
			$page_blocks = $blocks;

			if ( ! is_array( $page_blocks ) || empty( $page_blocks ) ) {
				return;
			}
			foreach ( $page_blocks as $i => $block ) {
	
				if ( is_array( $block ) ) {
	
					if ( '' === $block['blockName'] ) {
						continue;
					}
					$default_Fonts = ["","Arial","Helvetica","Times New Roman","Georgia"];
					if(isset($block['attrs']['headFontFamily'])){
						if(!in_array($block['attrs']['headFontFamily'],$default_Fonts)){
							$headFont=array();
							array_push($headFont,$block['attrs']['headFontFamily']);
							if(isset($block['attrs']['headFontWeight'])){
								array_push($headFont,$block['attrs']['headFontWeight']);
							}
							if(isset($block['attrs']['headFontSubset'])){
								array_push($headFont,$block['attrs']['headFontSubset']);
							}
							echo '<link href="//fonts.googleapis.com/css?family=' . esc_attr( implode(":",$headFont)) . '" rel="stylesheet">';
						}
					}
					if(isset($block['attrs']['subHeadFontFamily'])){
						if(!in_array($block['attrs']['subHeadFontFamily'],$default_Fonts)){
							$subheadFont=array();
							array_push($subheadFont,$block['attrs']['subHeadFontFamily']);
							if(isset($block['attrs']['subHeadFontWeight'])){
								array_push($subheadFont,$block['attrs']['subHeadFontWeight']);
							}
							if(isset($block['attrs']['subHeadFontSubset'])){
								array_push($subheadFont,$block['attrs']['subHeadFontSubset']);
							}
							echo '<link href="//fonts.googleapis.com/css?family=' . esc_attr( implode(":",$subheadFont)) . '" rel="stylesheet">';
						}
					}
					if(isset($block['attrs']['dateFontFamily'])){
						if(!in_array($block['attrs']['dateFontFamily'],$default_Fonts)){
							$dateFont=array();
							array_push($dateFont,$block['attrs']['dateFontFamily']);
							if(isset($block['attrs']['dateFontWeight'])){
								array_push($dateFont,$block['attrs']['dateFontWeight']);
							}
							if(isset($block['attrs']['dateFontSubset'])){
								array_push($dateFont,$block['attrs']['dateFontSubset']);
							}
							echo '<link href="//fonts.googleapis.com/css?family=' . esc_attr( implode(":",$dateFont)) . '" rel="stylesheet">';
						}
					}
				}
			}
		}

	}


function GCTLP_cp_timeline_cgb_block_assets() { 

	
	if ( function_exists( 'register_block_type' ) ) {
	register_block_type(
		'cp-timeline/content-timeline', array(
			'api_version' => 2
		)
	);
	register_block_type(
		'cp-timeline/content-timeline-child', array(
			'api_version' => 2
		)
	);

	register_block_type(
		'cp-timeline/post-timeline',
		array(
		'attributes' => array(
			"cp_timeline_block_id"=>  array(
				"default"=>"",
				"type" =>"string"
			),
			"timelineLayout"=>  array(
				"type" =>"string",
				"default"=>"vertical"
			),
			"timelineDesign"=>  array(
				"type" =>"string",
				"default"=>"both-sided"
			),
			"Orientation"=>  array(
				"type" =>"string",
				"default"=>"right"
			),
			"post_type"=>  array(
				"type" =>"string",
				"default"=>"post"
			),
			"post_per_page"=>  array(
				"type" =>"number",
				"default"=>10
			),
			"taxonomyType"=>  array(
				"type" =>"string",
				"default" => 'category'
			),
			"categories"=>  array(
				"type" =>"string",
			),
			"order"=>  array(
				"type" =>"string",
				"default"=>"desc"
			),
			"orderBy"=>  array(
				"type" =>"string",
				"default"=>"date"
			),
			"displayPostTitle"=>  array(
				"type" =>"boolean",
				"default"=>true
			),
			"displayPostDate"=>  array(
				"type" =>"boolean",
				"default"=>true
			),
			"excludeCurrentPost"=>  array(
				"type" =>"boolean",
				"default"=>false
			),
			"dateFormat"=>  array(
				"type" =>"string",
				"default"=>"m/d/Y"
			),
			"displayPostExcerpt"=>  array(
				"type" =>"boolean",
				"default"=>true
			),
			"displayPostLink"=>  array(
				"type" =>"boolean",
				"default"=>true
			),
			"titleLink"=>  array(
				"type" =>"boolean",
				"default"=>true
			),
			"displayPostImage"=>  array(
				"type" =>"boolean",
				"default"=>true
			),
			
			'imageSize'               => array(
				'type'    => 'string',
				'default' => 'full'
			),
			
			'icon'=> array(
				'type'    => 'string',
				'default' => 'fab fa fa-calendar-alt'
			),
			'iconToggle'=> array(
				'type'    => 'string',
				'default' => "false"
			),
			'LineColor'=> array(
				'type'    => 'string',
				'default' => '#D91B3E'
			),
			'iconColor'=> array(
				'type'    => 'string',
				'default' => '#333'
			),
			'iconBg'=> array(
				'type'    => 'string',
				'default' => '#D91B3E'
			),
			'storyBorderColor'=> array(
				'type'    => 'string',
				'default' => '#D91B3E'
			),
			
			"exerptLength"=>  array(
				"type" =>"number",
				"default"=>13
			),
			"headFontSize" =>  array(
				"type" =>"number",
				"default"=>18
			),
			"headFontSizeType"=> array(
				"type"=> "string",
				"default"=> "px"
			),
			"headFontSizeTablet"=>array(
				"type"=> "number"
			),
			"headFontSizeMobile"=> array(
				"type"=> "number"
			),
			"headFontFamily"=> array(
				"type"=> "string",
				"default"=> "Abel"
			),
			"headFontWeight"=> array(
				"type"=> "string",
				"default"=>"500"
			),
			"headFontSubset"=> array(
				"type"=> "string"
			),
			"headLineHeightType"=> array(
				"type"=> "string",
				"default"=> "px"
			),
			"headLineHeight"=> array(
				"type"=> "number",
				"default"=>"24"
			),
			"headLineHeightTablet"=> array(
				"type"=> "number"
			),
			"headLineHeightMobile"=> array(
				"type"=> "number"
			),
			"headLoadGoogleFonts"=> array(
				"type"=> "boolean",
				"default"=> false
			),
			"subHeadFontSizeType"=> array(
				"type"=> "string",
				"default"=> "px"
			),
			"subHeadFontSize"=> array(
				"type"=> "number",
				"default"=>14
			),
			"subHeadFontSizeTablet"=> array(
				"type"=> "number"
			),
			"subHeadFontSizeMobile"=> array(
				"type"=> "number"
			),
			"subHeadFontFamily"=> array(
				"type"=> "string",
				"default"=> "Abel"
			),
			"subHeadFontWeight"=> array(
				"type"=> "string",
				"default"=>"400"
			),
			"subHeadFontSubset"=> array(
				"type"=> "string"
			),
			"subHeadLineHeightType"=> array(
				"type"=> "string",
				"default"=> "px"
			),
			"subHeadLineHeight"=> array(
				"type"=> "number",
				"default"=>24
			),
			"subHeadLineHeightTablet"=> array(
				"type"=> "number"
			),
			"subHeadLineHeightMobile"=> array(
				"type"=> "number"
			),
			"subHeadLoadGoogleFonts"=> array(
				"type"=> "boolean",
				"default"=> false
			),
			"dateFontsizeType"=> array(
				"type"=> "string",
				"default"=> "px"
			),
			"dateFontsize"=> array(
				"type"=> "number",
				"default"=>18
			),
			"dateFontsizeTablet"=> array(
				"type"=> "number"
			),
			"dateFontsizeMobile"=> array(
				"type"=> "number"
			),
			"dateFontFamily"=> array(
				"type"=> "string",
				"default"=> "Abel"
			),
			"dateFontWeight"=>array(
				"type"=> "string",
				"default"=>"500"
			),
			"dateFontSubset"=> array(
				"type"=> "string",
			),
			"dateLineHeightType"=> array(
				"type"=> "string",
				"default"=> "em"
			),
			"dateLineHeight"=> array(
				"type"=> "number",
				"default"=>1.1
			),
			"dateLineHeightTablet"=> array(
				"type"=> "number"
			),
			"dateLineHeightMobile"=> array(
				"type"=> "number"
			),
			"dateLoadGoogleFonts"=> array(
				"type"=> "boolean",
				"default"=> false
			),
			"readMoreFontsizeType"=> array(
				"type"=> "string",
				"default"=> "px"
			),
			"readMoreFontsize"=> array(
				"type"=> "number",
				"default"=>18
			),
			"readMoreFontsizeTablet"=> array(
				"type"=> "number"
			),
			"readMoreFontsizeMobile"=> array(
				"type"=> "number"
			),
			"readMoreFontFamily"=> array(
				"type"=> "string",
				"default"=> "Abel"
			),
			"readMoreFontWeight"=>array(
				"type"=> "string",
				"default"=>"500"
			),
			"readMoreFontSubset"=> array(
				"type"=> "string"
			),
			"readMoreLineHeightType"=> array(
				"type"=> "string",
				"default"=> "em"
			),
			"readMoreLineHeight"=> array(
				"type"=> "number",
				"default"=>1.1
			),
			"readMoreLineHeightTablet"=> array(
				"type"=> "number"
			),
			"readMoreLineHeightMobile"=> array(
				"type"=> "number"
			),
			"readMoreLoadGoogleFonts"=> array(
				"type"=> "boolean",
				"default"=> false
			),
			"backgroundColor"=> array(
				"type"=> "string",
				"default"=> "#fff"
			),
			"dateColor" =>  array(
				"type" =>"string",
				"default" => "#333",
			),
			"headingColor" =>  array(
				"type" =>"string",
				"default" => "#333"
			),
			"subHeadingColor" =>  array(
				"type" =>"string",
				"default" => "#333"
			),
			"readMoreColor" =>  array(
				"type" =>"string",
				"default" => "#333"
			),
			"readMoreText" =>  array(
				"type" =>"string",
				"default" => "Read More"
			),
			"linkTarget" =>  array(
				"type" =>"boolean",
				"default" => true
			),
			"slidePerView" =>  array(
				"type" =>"number",
				"default" => 3
			),
			"slideMount" =>  array(
				"type" =>"boolean",
				"default" => false
			),
			"showDateType" =>  array(
				"type" =>"string",
				"default" => "publish_date"
			),
			"storyStart" =>  array(
				"type" =>"string",
				"default" => "right"
			),
			"imageWidth" =>  array(
				"type" =>"number",
				"default" => 600
			),
			"imageHeight" =>  array(
				"type" =>"number",
				"default" => 600
			),
			"postStatus" =>  array(
				"type" =>"string",
				"default" => "publish"
			),
			"customDateFormat" =>  array(
				"type" =>"string",
				"default" => "Y/m/d"
			),
			"autoplay" =>  array(
				"type" =>"boolean",
				"default" => false
			),
			"autoplayTimer" =>  array(
				"type" =>"number",
				"default" => 3000
			),
			"customMeta" =>  array(
				"type" =>"string",
				"default" => ""
			)
			),
		'render_callback' =>  'cp_post_timeline_callback'
		)
	);
}

	
}

// Hook: Block assets.
add_action( 'init', 'GCTLP_cp_timeline_cgb_block_assets' );

function cp_post_timeline_callback($attributes){
	$recent_posts = CP_Timeline_Helper::get_query( $attributes, 'timeline' );
	ob_start();
	if($recent_posts->have_posts()){
		include_once CTP_PLUGIN_DIR . 'includes/cool-timeline-block/helper/cp-timeline-block-style.php';
		include_once CTP_PLUGIN_DIR . 'includes/cool-timeline-block/helper/cp-timeline-block-function.php';
		include_once CTP_PLUGIN_DIR . 'includes/cool-timeline-block/helper/cp-timeline-block-layout.php';
		$font_family_array= array($attributes['dateFontFamily'],
		$attributes['headFontFamily'],
								$attributes['subHeadFontFamily'],
								$attributes['readMoreFontFamily']
								
							);
			$build_url = 'https://fonts.googleapis.com/css?family=';
			$build_url.=implode("|",array_filter($font_family_array));
			wp_enqueue_style('cp-post-timeline-google-font',"$build_url", array(), null, null, 'all');
			get_timeline_post_html($attributes,$recent_posts);
			
	}
	else{
		esc_html_e( 'No posts found' );
	}
	return ob_get_clean();
}

function cp_blocks_register_rest_fields(){
	$post_type = CP_Timeline_Helper::cp_timeline_post_type();
	
				foreach ( $post_type as $key => $value ) {
			
					register_rest_field(
						$value['value'],
						'cp_meta_data',
						array(
							'get_callback'    => 'get_meta' ,
							'update_callback' => null,
							'schema'          => null,
						)
					);
	
				}
			}
	
			function get_meta($object, $field_name, $request ){
				$id = $object['id'];
				$data =get_post_meta($id);
				return $data;
			}
	
add_action( 'rest_api_init',  'cp_blocks_register_rest_fields'  );
