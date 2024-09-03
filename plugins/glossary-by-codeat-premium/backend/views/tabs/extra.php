<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Glossary
 * @author    Codeat <support@codeat.co>
 * @copyright 2016 GPL 3.0+
 * @license   GPL-2.0+
 * @link      http://codeat.co
 *
 * @phpcs:disable WordPress.Security.EscapeOutput
 */
?>
<div id="tabs-extra" class="metabox-holder">
<?php

	$cmb = new_cmb2_box(
		array(
			'id'         => GT_SETTINGS . '_options3',
			'hookup'     => false,
			'show_on'    => array(
				'key'   => 'options-page',
				'value' => array( 'glossary-by-codeat' ),
			),
			'show_names' => true,
		)
	);
	$cmb->add_field(
		array(
			'name' => __( 'OpenAI ChatGPT', GT_TEXTDOMAIN ),
			'id'   => 'text_opeai_chatgpt',
			'desc' => __( 'A valid OpenAI key is needed. Please head over to <a href="https://docs.codeat.co/glossary/chatgpt/" target="_blank">the dedicated documentation page</a>.', GT_TEXTDOMAIN ),
			'type' => 'title',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Secret Key', GT_TEXTDOMAIN ),
			'id'      => 'openai_key',
			'type'    => 'text',
			'default' => '',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Temperature', GT_TEXTDOMAIN ),
			'id'      => 'openai_temperature',
			'type'    => 'text_small',
			'default' => '1',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'OpenAI Model', GT_TEXTDOMAIN ),
			'id'      => 'openai_model',
			'type'    => 'select',
			'default' => 'gpt-3.5-turbo',
			'options' => array(
				'gpt-3.5-turbo' => 'gpt-3.5-turbo',
				'gpt-4'         => 'gpt-4',
			),
		)
	);

	if ( gt_fs()->is_plan__premium_only( 'professional' ) ) {
		$cmb->add_field(
			array(
				'name' => __( 'Custom Fields', GT_TEXTDOMAIN ),
				'id'   => 'text_custom_field',
				'desc' => __( 'Do you need to create custom fields for your key terms? If so, please head over to <a href="http://docs.codeat.co/glossary/premium-features/#how-to-add-custom-fields-to-your-glossary" target="_blank">the dedicated documentation page</a> to see how to best implement them.', GT_TEXTDOMAIN ),
				'type' => 'title',
			)
		);
		$cmb->add_field(
			array(
				'name'       => __( 'Fields', GT_TEXTDOMAIN ),
				'id'         => 'custom_fields',
				'type'       => 'text_small',
				'default'    => '',
				'repeatable' => true,
			)
		);

		$cmb->add_field(
			array(
				'name' => __( 'Footnotes', GT_TEXTDOMAIN ),
				'id'   => 'text_footnotes',
				'desc' => __( 'Do you want footnotes with the links of your terms? Check our <a href="https://docs.codeat.co/glossary/premium-features/#footnotes" target="_blank">dedicated documentation page</a> how this feature works.', GT_TEXTDOMAIN ),
				'type' => 'title',
			)
		);
		$cmb->add_field(
			array(
				'name' => __( 'Links in footnotes list', GT_TEXTDOMAIN ),
				'id'   => 'footnotes_list_links',
				'type' => 'checkbox',
			)
		);
		$cmb->add_field(
			array(
				'name' => __( 'Excerpt in footnotes list', GT_TEXTDOMAIN ),
				'id'   => 'footnotes_list_excerpt',
				'type' => 'checkbox',
			)
		);
		$cmb->add_field(
			array(
				'name' => __( 'Post content in footnotes list', GT_TEXTDOMAIN ),
				'id'   => 'footnotes_list_content',
				'type' => 'checkbox',
			)
		);
		$cmb->add_field(
			array(
				'name' => __( 'Footnotes Title', GT_TEXTDOMAIN ),
				'id'   => 'footnotes_title',
				'type' => 'text',
				'desc' => __( 'Change the default title on top of the Footnotes', GT_TEXTDOMAIN ),
			)
		);
	}

	cmb2_metabox_form( GT_SETTINGS . '_options3', GT_SETTINGS . '-extra' );
	?>
</div>
