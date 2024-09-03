<?php
/**
 * Plugin name
 *
 * @package   Plugin_name
 * @author    Codeat <support@codeat.co>
 * @copyright 2020
 * @license   GPL 3.0+
 * @link      https://codeat.co
 */

namespace Glossary\Integrations;

use Glossary\Engine;

/**
 * Provide support for ACF Admin
 */
class ACF extends Engine\Base {

	/**
	 * Instance of this Glossary\Frontend\Core\Search_Engine.
	 *
	 * @var \Glossary\Frontend\Core\Search_Engine
	 */
	public $search_engine;

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function initialize() {
		parent::initialize();

		if ( class_exists( 'ACF' ) ) {
			\add_action( 'acf/render_field_settings/type=flexible_content', array( $this, 'fieldv5' ), 9999 );
			\add_action( 'acf/render_field_settings/type=textarea', array( $this, 'fieldv5' ), 9999 );
			\add_action( 'acf/render_field_settings/type=text', array( $this, 'fieldv5' ), 9999 );
			\add_action( 'acf/render_field_settings/type=wysiwyg', array( $this, 'fieldv5' ), 9999 );
			\add_action( 'acf/create_field_options', array( $this, 'fieldv4' ), 9999 );
			\add_filter( 'acf/load_value', array( $this, 'execute_glossary_on_field' ), 10, 3 );
		}

		return true;
	}

	/**
	 * Add glossary settings to ACF v5
	 *
	 * @param array $field Object.
	 * @return void
	 */
	public function fieldv5( array $field ) {
		\acf_render_field_setting(
			$field,
			array(
				'label' => \__( 'Add support for Glossary in your fields', GT_TEXTDOMAIN ),
				'name'  => 'glossary_support',
				'type'  => 'true_false',
			),
			true
		);
	}

	/**
	 * Add glossary settings to ACF v4
	 *
	 * @param array $field Object.
	 * @return void
	 */
	public function fieldv4( array $field ) {
		$key   = $field[ 'name' ];
		$value = '';

		if ( isset( $field[ 'glossary_support' ] ) ) {
			$value = $field[ 'glossary_support' ];
		}

		?>
		<tr class="field_option field_option_mime_types">
			<td class="label">
				<label><?php \esc_html_e( 'Glossary', GT_TEXTDOMAIN ); ?></label>
				<p><?php \esc_html_e( 'Add support for Glossary in your fields', GT_TEXTDOMAIN ); ?></p>
			</td>
			<td>
		<?php
		\do_action( // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores -- ACF hooks are in that way.
			'acf/create_field', // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores -- ACF hooks are in that way.
			array(
				'type'  => 'true_false',
				'value' => $value,
				'name'  => 'fields[' . $key . '][glossary_support]',
			)
		);
		?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Execute Glossary in the value field
	 *
	 * @param string|array $value   The content.
	 * @param string|int   $post_id The post ID.
	 * @param object       $field   The field object.
	 * @return string|array
	 */
	public function execute_glossary_on_field( $value, $post_id, $field ) { //phpcs:ignore
		if ( !\is_admin() ) {
			if ( !\is_array( $value ) && \is_array( $field ) && (
				isset( $field[ 'glossary_support' ] ) &&
				! empty( $field[ 'glossary_support' ] )
				) ) {
				$pre_value = $value;
				$value     = \do_shortcode( $value );

				if ( !\has_shortcode( $pre_value, 'glossary-list' ) && $value[0] !== '<' ) {
					$value = \wpautop( $value );
				}

				if ( !\is_object( $this->search_engine ) ) {
					$this->search_engine = \apply_filters( 'glossary_instance_Glossary\Frontend\Core\Search_Engine', '' );

					if ( $this->search_engine === '' ) {
						$this->search_engine = new \Glossary\Frontend\Core\Search_Engine;
					}
				}

				$value = $this->search_engine->auto_link( $value );
			}
		}

		return $value;
	}

}
