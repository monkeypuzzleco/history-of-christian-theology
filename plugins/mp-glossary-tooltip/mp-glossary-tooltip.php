<?php
/*
 * Plugin Name: MP Glossary Tooltip
 * Description: Glossary Tooltip on timeline that links to glossary page
 * Version: 2.4
 * Author: Monkey Puzzle LLC
 * Author URI: http://monkeypuzzle.co
 * Requires at least: ?
 * Tested up to: 4.0
 *
 * Text Domain: -
 * Domain Path: -
 *
 */

class MP_glossary_tooltip {

    private static $excerpt_limit;

    public function __construct() {
        $this->init();
    }

    private function init() {
        // Retrieve the glossary settings option and unserialize it
        $glossary_settings = get_option('glossary-settings');
        self::$excerpt_limit = isset($glossary_settings['excerpt_limit']) ? intval($glossary_settings['excerpt_limit']) : 12; // Default to 12 if not set

        add_action('wp_enqueue_scripts', array($this, 'add_mp_glossary_tooltip_scripts'));
        add_action('wp_ajax_get_post_excerpt', array($this, 'get_post_excerpt'));
        add_action('wp_ajax_nopriv_get_post_excerpt', array($this, 'get_post_excerpt'));
        

    }

    function add_mp_glossary_tooltip_scripts() {
        wp_enqueue_script(
            'ajax-script', plugin_dir_url(__FILE__) . 'js/mp-glossary-tooltip.js',
            array('jquery'),
            '1.0',
            true
        );
        wp_enqueue_style('mp-glossary-tooltip-styles', plugin_dir_url(__FILE__) . 'css/mp-glossary-tooltip.css', array(), '1.0.0');
  

        // Localize script to pass AJAX URL to JavaScript
        wp_localize_script('ajax-script', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('get_post_excerpt_nonce')
        ));
    }

  /* function run_on_activate_glossary_tooltip()
    {


    } // end run_on_activate_glossary_tooltip()

    function run_on_deactivate_glossary_tooltip() {

    }*/

    public function get_post_excerpt() {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'get_post_excerpt_nonce')) {
            wp_send_json_error(['message' => 'Invalid nonce']);
            return;
        }
        if (isset($_POST['title'])) {
            $title = sanitize_text_field($_POST['title']);
            
            // Use WP_Query to fetch the post by title
            $query = new WP_Query([
                'post_type' => 'glossary', // Replace with your custom post type
                'title' => $title,
                'posts_per_page' => 1
            ]);

            if ($query->have_posts()) {
                $query->the_post();
        

                $excerpt = $this->wp_trim_characters(get_the_content()); // Adjust the word count as needed
                $post_url = get_permalink();
    
                wp_send_json_success(['excerpt' => $excerpt, 'glossary_url' => $post_url]);
            } else {
                wp_send_json_error(['message' => 'Post not found']);
            }

            // Restore original Post Data
            wp_reset_postdata();
        } else {
            wp_send_json_error(['message' => 'Invalid request']);
        }
    }
    private function wp_trim_characters($text, $more = '...') {
        if (mb_strlen($text) > self::$excerpt_limit) {
            $text = mb_substr($text, 0, self::$excerpt_limit) . $more;
        }
        return $text;
    }
 
}

new MP_glossary_tooltip;
?>
