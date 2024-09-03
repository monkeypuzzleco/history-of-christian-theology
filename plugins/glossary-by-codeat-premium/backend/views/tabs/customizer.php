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

$preview_url = add_query_arg(
		array(
			'gt_preview'    => '1',
			'avoid_caching' => time(),
		),
		get_admin_url()
);
?>
<div id="tabs-customizer" class="metabox-holder">
<div class="glossary-customizer-wrapper">
<div id="gl-sticky">
<div class="glossary-customizer-preview">
	<h2><?php _e( 'Tooltip Preview', GT_TEXTDOMAIN ); ?></h2>
	<p><?php _e( 'What you see is what you get!', GT_TEXTDOMAIN ); ?></p>
</div>
<iframe class="preview" src="<?php echo $preview_url; ?>" frameborder="0" scrolling="no" style="width:100%;height:225px" id="gt_preview"></iframe>
</div>
</div>
<?php
	$cmb = new_cmb2_box(
		array(
			'id'         => GT_SETTINGS . '_options2',
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
			'name' => __( 'Tooltip Text Style Settings', GT_TEXTDOMAIN ),
			'desc' => __( 'Customize here the text and background options for your tooltips', GT_TEXTDOMAIN ),
			'id'   => 'text_title',
			'type' => 'title',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Color', GT_TEXTDOMAIN ),
			'id'      => 'text_color',
			'type'    => 'colorpicker',
			'default' => '',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Background Color', GT_TEXTDOMAIN ),
			'id'      => 'text_background',
			'type'    => 'colorpicker',
			'default' => '',
		)
	);
	$cmb->add_field(
		array(
			'name'        => __( 'Font Size in px', GT_TEXTDOMAIN ),
			'id'          => 'text_size',
			'type'        => 'text_small',
			'description' => 'e.g. 18px',
		)
	);
	$cmb->add_field(
		array(
			'name' => __( 'Remove padding from terms on front-end', GT_TEXTDOMAIN ),
			'id'   => 'no_padding_text',
			'type' => 'checkbox',
		)
	);
	$cmb->add_field(
		array(
			'name' => __( 'Key Term Text Style Settings', GT_TEXTDOMAIN ),
			'desc' => __( 'Customize here the text and background options for your key terms in your text - leave black to use your current link style', GT_TEXTDOMAIN ),
			'id'   => 'keyterm_title',
			'type' => 'title',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Color', GT_TEXTDOMAIN ),
			'id'      => 'keyterm_color',
			'type'    => 'colorpicker',
			'default' => '',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Background Color', GT_TEXTDOMAIN ),
			'id'      => 'keyterm_background',
			'type'    => 'colorpicker',
			'default' => '',
		)
	);
	$cmb->add_field(
		array(
			'name'        => __( 'Font Size in px', GT_TEXTDOMAIN ),
			'id'          => 'keyterm_size',
			'type'        => 'text_small',
			'description' => 'e.g. 18px',
		)
	);
	$cmb->add_field(
		array(
			'name' => __( 'Tooltip Link Style Settings', GT_TEXTDOMAIN ),
			'desc' => __( 'Customize here the color for the links in the tooltip - leave black to use your current link style', GT_TEXTDOMAIN ),
			'id'   => 'link_keyterm_title',
			'type' => 'title',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Color', GT_TEXTDOMAIN ),
			'id'      => 'link_keyterm_color',
			'type'    => 'colorpicker',
			'default' => '',
		)
	);
	$cmb->add_field(
		array(
			'name' => __( 'Mobile', GT_TEXTDOMAIN ),
			'id'   => 'mobile_title',
			'type' => 'title',
		)
	);
	$cmb->add_field(
		array(
			'name'    => __( 'Mobile Tooltip behavior', GT_TEXTDOMAIN ),
			'id'      => 'on_mobile',
			'type'    => 'select',
			'options' => array(
				'disable'    => __( 'Disable tooltips on mobile', GT_TEXTDOMAIN ),
				'responsive' => __( 'Responsive tooltips on mobile', GT_TEXTDOMAIN ),
				'default'    => __( 'Default tooltips on mobile', GT_TEXTDOMAIN ),
			),
			'default' => 'default',
		)
	);

	cmb2_metabox_form( GT_SETTINGS . '_options2', GT_SETTINGS . '-customizer' );
	?>

</div>
