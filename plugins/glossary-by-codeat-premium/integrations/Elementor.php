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

use Glossary\Engine;

/**
 * Improve the elementor integration
 */
class Elementor extends Engine\Base {

	/**
	 * Is_Methods class
	 *
	 * @var \Glossary\Engine\Is_Methods
	 */
	public $content;

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function initialize() {
		parent::initialize();

		if ( \defined( 'ELEMENTOR_VERSION' ) ) {
			$this->content = new Engine\Is_Methods;
			add_action( 'elementor/element/before_section_end', array( $this, 'custom_field' ), 9999, 3 );
			add_action( 'admin_print_footer_scripts', array( $this, 'add_assets_on_editor' ), 10 );
			add_action( 'elementor/frontend/before_render', array( $this, 'wrap_elements_with_glossary' ), 5, 1 );
		}

		return true;
	}

	/**
	 * Wrap specific elementor blocks with glossary
	 *
	 * @param object $element Elementor Block Object.
	 * @return void
	 */
	public function wrap_elements_with_glossary( $element ) {
		if ( $element->get_type() !== 'widget' ) {
			return;
		}

		if ( !$this->content->is_page_type_to_check() ) {
			return;
		}

		if ( $element->get_name() === 'icon-box' || $element->get_name() === 'image-box' ) {
			$this->wrap_in_glossary( $element, 'description_text' );
		} elseif ( $element->get_name() === 'blockquote' ) {
			$this->wrap_in_glossary( $element, 'blockquote_content' );
		} elseif ( $element->get_name() === 'testimonial' ) {
			$this->wrap_in_glossary( $element, 'testimonial_content' );
		} elseif ( $element->get_name() === 'html' ) {
			$this->wrap_in_glossary( $element, 'html' );
		}
	}

	/**
	 * Wrap specific elementor blocks with glossary
	 *
	 * @param object $element Elementor Block Object.
	 * @param string $section_id Elementor section id.
	 * @param array  $args Elementor args.
	 * @return void
	 */
	public function custom_field( $element, $section_id, $args ) { // phpcs:ignore
		if ( $section_id !== 'section_editor' ) {
			return;
		}

		if ( get_post_type() !== 'glossary' ) {
			return;
		}

		$element->add_control(
			$section_id . '-glossary-chatgpt',
			array(
				'label'   => \__( 'Autogenerate the term content with ChatGPT', GT_TEXTDOMAIN ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA, // @phpstan-ignore-line
				'default' => '',
			)
		);
		$element->add_control(
			$section_id . '-glossary-chatgpt-button',
			array(
				'text' => \__( 'Generate Content', GT_TEXTDOMAIN ),
				'type' => \Elementor\Controls_Manager::BUTTON, // @phpstan-ignore-line
			)
		);
	}

	/**
	 * Wrap string with glossary parse shortcode
	 *
	 * @param object $element Elementor class.
	 * @param string $setting THe ID for the setting.
	 * @return void
	 */
	public function wrap_in_glossary( $element, $setting ) {
		$element->set_settings( $setting, '[glossary]' . $element->get_settings( $setting ) . '[/glossary]' );
	}

	/**
	 * Print our assets on Elementor editor
	 *
	 * @return void
	 */
	public function add_assets_on_editor() {
		if ( isset( $_GET['action'] ) && $_GET['action'] !== 'elementor' ) { // phpcs:ignore
			return;
		}

		echo '<script id="glossary-admin-script-js-extra">
		var glossaryAdmindata = {"alert":"' . \__( 'Error with the ChatGPT request!', GT_TEXTDOMAIN ) . '","warning":"' . \__( 'Please provide a title to automatically generate the content for the term.', GT_TEXTDOMAIN ) . '","waiting":"' . \__( 'Waiting for server response', GT_TEXTDOMAIN ) . '","nonce":"' . \wp_create_nonce( 'generate_nonce' ) . '","wp_rest":"' . \wp_create_nonce( 'wp_rest' ) . '","prompt":"' . \__( 'Please provide a glossary term definition for \'[replaceme]\' and divide the text into paragraphs. Plain text only, do not use markdown or HTML. Ensure that the content consists of at least 350 words.', GT_TEXTDOMAIN ) . '"};</script>'; // phpcs:ignore
		echo '<script src="' . \plugins_url( 'assets/js/admin.js', GT_PLUGIN_ABSOLUTE ) . '"></script>'; // phpcs:ignore
	}

}
