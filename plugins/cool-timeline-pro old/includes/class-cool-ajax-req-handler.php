<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
    class CoolAjaxReqHandler{
         /**
         * The Constructor
         */
        public function __construct() {
            /*
                Story timeline ajax load more ajax request handler hooks
            */
            add_action( 'wp_ajax_ctl_ajax_load_more', array($this,'ctl_stories_load_more_handler'));
            add_action( 'wp_ajax_nopriv_ctl_ajax_load_more',  array($this,'ctl_stories_load_more_handler'));
            // category based filter hooks
            add_action( 'wp_ajax_st_cat_filters', array($this,'storytm_cat_filters_handler'));
            add_action( 'wp_ajax_nopriv_st_cat_filters',  array($this,'storytm_cat_filters_handler'));
            /*
                Content timeline ajax load more ajax request handler hooks
            */
            add_action( 'wp_ajax_ct_ajax_load_more', array($this, 'ctl_content_load_more_handler'));
            add_action( 'wp_ajax_nopriv_ct_ajax_load_more', array($this, 'ctl_content_load_more_handler'));
            // category based filter hooks
            add_action( 'wp_ajax_ct_cat_filters', array($this, 'contenttm_cat_filters_handler'));
            add_action( 'wp_ajax_nopriv_ct_cat_filters',  array($this,'contenttm_cat_filters_handler'));

        }


    // stories timeline ajax load more handler
    function ctl_stories_load_more_handler() {

         // Check for nonce security
        $nonce = $_POST['nonce'];
        if ( ! wp_verify_nonce( $nonce, 'ctl-ajax-nonce' ) ){
             die ( 'Please refresh your window and try again');
            }
            
        // get incomming vars in ajax request
        $last_year = isset( $_POST['last_year'] )? $_POST['last_year']:0;
        $alternate = isset( $_POST['alternate'] )? $_POST['alternate']:0; 
        $main_wrp_id=isset( $_POST['main_wrp_id'] ) ? $_POST['main_wrp_id'] : '';
        $attribute = isset( $_POST['attribute'] ) ? array_map( 'esc_attr', $_POST['attribute'] ) : array();
        $layout=isset($_POST['layout'])?$_POST['layout']:'vertical';
        $dates_li='';
        $year_label='';
        // render WPBakery shortcodes after ajax load more
        if (method_exists('WPBMap', 'addAllMappedShortcodes')) {
            WPBMap::addAllMappedShortcodes();
        }
        // It's load dynamic styles
        if($layout == 'horizontal'){
            require( CTP_PLUGIN_DIR .'includes/shortcodes/common/class-ctl-h-styles.php');
        }else{
            require( CTP_PLUGIN_DIR .'includes/shortcodes/common/class-ctl-v-styles.php');
        }
        // for grabing dynamic icon
        

        // create classes based on design 
        if($attribute['designs'])
        {
            $design_cls='main-'.$attribute['designs'];
            $design=$attribute['designs'];
        }else{
            $gn_cls='main-default';
            $design='default';
        }
        // set default var for later use
        $output = ''; $ctl_html = '';$ctl_format_html = ''; $ctl_animation='';
        $ctl_avtar_html = '';  $timeline_id = ''; $cls_icons='';
        $layout=$attribute['layout'] ?$attribute['layout']:'default';
        $ctl_animation=$attribute['animations'] ?$attribute['animations']:'none';
        $pagination=$attribute['pagination'];
        if (isset($attribute['icons']) && $attribute['icons']=="YES"){
            $cls_icons='icons_yes';
        }else{
            $cls_icons='icons_no';
        }

        // build quries based on incomming vers
        require(CTP_PLUGIN_DIR.'/includes/shortcodes/story-timeline/ctl-build-query.php');
        $args['paged']=esc_attr( $_POST['page'] );
        //load main vertical story timeline story content
        if($layout == 'horizontal'){
            require(CTP_PLUGIN_DIR.'/includes/shortcodes/story-timeline/layouts/story-horizontal-layout.php');
        }else{
            require(CTP_PLUGIN_DIR.'/includes/shortcodes/story-timeline/layouts/story-vertical-layout.php');
        }
        // send back in json format
        $data=array('html'=>$ctl_html,'date_html'=>$dates_li,'hr_year_label'=>$year_label);
        wp_send_json_success( $data );
        // stop processes
        wp_die();
    }

    // content timeline load more ajax handler
    function ctl_content_load_more_handler() {
        $ctl_html='';
        $output='';
        
         // Check for nonce security
         $nonce = $_POST['nonce'];
         if ( ! wp_verify_nonce( $nonce, 'ctl-ajax-nonce' ) ){
              die ( 'Please refresh your window and try again');
             }
        
        // render WPBakery shortcodes after ajax load more
        if (method_exists('WPBMap', 'addAllMappedShortcodes')) {
            WPBMap::addAllMappedShortcodes();
        }
        // grabing incomming var in ajax request
        $last_year = isset( $_POST['last_year'] )? $_POST['last_year']:0;
        $alternate = isset( $_POST['alternate'] )? $_POST['alternate']:0;
        $args['paged']=esc_attr( $_POST['page'] );
        $attribute = isset( $_POST['attribute'] ) ? array_map( 'esc_attr', $_POST['attribute'] ) : array();
        $layout=$attribute['layout']?$attribute['layout']:'default';
        $ctl_animation=$attribute['animations'] ?$attribute['animations']:'none';
        $pagination=$attribute['pagination'];
        // $layout=isset($_POST['layout'])?$_POST['layout']:'vertical';
        $term_slug     = isset( $_POST['termslug'] ) ?$_POST['termslug']:'all';
        if ( $term_slug != 'all' ) {
			$attribute['post-category'] = $term_slug;
             $attribute['category'] = $term_slug;
		}
        // set dynamic classes based on design type
        if ($attribute['designs']) {
                        $design_cls = 'main-' . $attribute['designs'];
                        $design = $attribute['designs'];
                    } else {
                        $design_cls = 'main-default';
                        $design = 'default';
                    }
        
        // load content timeline content 
        require(CTP_PLUGIN_DIR.'/includes/shortcodes/content-timeline/layouts/loop-content-timeline.php');
    // send back in json format
    $data=array('html'=>$ctl_html,'layout'=>$layout,'date_html'=>$dates_li,'page'=>$args['posts_per_page'],'hr_year_label'=>$year_label);
        wp_send_json_success( $data );
        wp_die();
        }

        // content timeline cateogry based filter ajax request handler
    function contenttm_cat_filters_handler() {
        $ctl_html='';
        $output='';
         // Check for nonce security
         $nonce = $_POST['nonce'];
         if ( ! wp_verify_nonce( $nonce, 'ctl-ajax-nonce' ) ){
              die ( 'Please refresh your window and try again');
             }

        if (method_exists('WPBMap', 'addAllMappedShortcodes')) {
            WPBMap::addAllMappedShortcodes();
        }

        $term_slug=esc_attr( $_POST['termslug'] );
        $attribute = isset( $_POST['attribute'] ) ? array_map( 'esc_attr', $_POST['attribute'] ) : array();
        $layout=$attribute['layout']?$attribute['layout']:'default';
        $pagination=$attribute['pagination'];
        $ctl_animation=$attribute['animations'] ?$attribute['animations']:'none';
        $last_year = isset( $_POST['last_year'] )? $_POST['last_year']:0;
        $alternate = isset( $_POST['alternate'] )? $_POST['alternate']:0;
        if($term_slug!="all"){
        $attribute['post-category']=$term_slug;
        }
        if ($attribute['designs']) {
                        $design_cls = 'main-' . $attribute['designs'];
                        $design = $attribute['designs'];
                    } else {
                        $design_cls = 'main-default';
                        $design = 'default';
                    }
                    // render WPBakery shortcodes after ajax load more
        
        // loading content file
        require(CTP_PLUGIN_DIR.'/includes/shortcodes/content-timeline/layouts/loop-content-timeline.php');
        $html=$ctl_html_empty != '' ? $ctl_html_empty : $ctl_html;
        $data=array('html'=>$html,'pagination'=>$ctl_custom_pagi,'cust_pagination'=>$ctl_cust_pagi_array);
        wp_send_json_success( $data );
        wp_die();
        }

    // stories timeline category fitler ajax request handler
   function storytm_cat_filters_handler() {
      
     // Check for nonce security
     $nonce = $_POST['nonce'];
     if ( ! wp_verify_nonce( $nonce, 'ctl-ajax-nonce' ) ){
          die ( 'Please refresh your window and try again');
         }
         
        $term_slug=esc_attr( $_POST['termslug'] );
        $attribute = isset( $_POST['attribute'] ) ? array_map( 'esc_attr', $_POST['attribute'] ) : array();
        $ctl_category=$term_slug;
        $alternate = isset( $_POST['alternate'] )? $_POST['alternate']:0; 
        $last_year = isset( $_POST['last_year'] )? $_POST['last_year']:0;
        $pagination=$attribute['pagination'];
        if($attribute['designs'])
        {
            $design_cls='main-'.$attribute['designs'];
                $design=$attribute['designs'];
            }else{
                $gn_cls='main-default';
                $design='default';
            }

            if (method_exists('WPBMap', 'addAllMappedShortcodes')) {
                WPBMap::addAllMappedShortcodes();
            }
            // loads dynamic styles
            require( CTP_PLUGIN_DIR .'includes/shortcodes/common/class-ctl-v-styles.php');
    

            // set default vars for later use 
        $output = ''; $ctl_html = '';$ctl_format_html = ''; $ctl_animation='';
            $ctl_avtar_html = '';  $timeline_id = ''; $cls_icons='';
            $layout=$attribute['layout'] ?$attribute['layout']:'default';
            $ctl_animation=$attribute['animations'] ?$attribute['animations']:'none';
            if (isset($attribute['icons']) && $attribute['icons']=="YES"){
                $cls_icons='icons_yes';
            }else{
                $cls_icons='icons_no';
            }
            // generate custom query according the request
            require(CTP_PLUGIN_DIR.'/includes/shortcodes/story-timeline/ctl-build-query.php');
            $args['paged']=1;
            // load contents
            $ajax_pagination_request=true;
            require(CTP_PLUGIN_DIR.'/includes/shortcodes/story-timeline/layouts/story-vertical-layout.php');
            $html=$ctl_html_empty != '' ? $ctl_html_empty : $ctl_html;
            $data=array('html'=>$html,'pagination'=>$ctl_custom_pagi,'cust_pagination'=>$ctl_cust_pagi_array);
            wp_send_json_success( $data );
            wp_die();
        }

    } // class end

 