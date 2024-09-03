<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Control core classes for avoid errors
if ( class_exists( 'CTL' ) ) {

	$user_roles = array();
	if ( is_user_logged_in() ) {
		global $wp_roles;
		$user_roles_arr = $wp_roles->get_names();
		$user_roles     = array_filter(
			$user_roles_arr,
			function ( $v, $k ) {
				return ! in_array( $v, array( 'Administrator', 'Subscriber', 'Translator' ) );
			},
			ARRAY_FILTER_USE_BOTH
		);
	}

	//
	// Set a unique slug-like ID
	$prefix = 'cool_timeline_settings';

	//
	// Create options
	CTL::createOptions(
		$prefix,
		array(
			'framework_title'    => 'Cool Timeline Pro Settings',
			'menu_title'         => 'Timeline Settings',
			'menu_slug'          => 'cool_timeline_settings',
			'menu_type'          => 'submenu',
			'menu_parent'        => 'cool-plugins-timeline-addon',
			'nav'                => 'inline',
			'menu_icon'          => CTP_PLUGIN_URL . 'assets/images/cool-timeline-icon.svg',
			'menu_position'      => 6,
			'show_reset_section' => false,
			'show_reset_all'     => false,
			'show_bar_menu'      => false,
		)
	);

	//
	// Create a section
	CTL::createSection(
		$prefix,
		array(
			'title'  => 'General Settings',

			'fields' => array(
				// Create a Fieldset

				array(
					'id'      => 'post_type_slug',
					'type'    => 'text',
					'title'   => __( 'Custom slug of timeline stories', 'cool-timeline1' ),
					'default' => '',
					'desc'    => __( 'Remember to save the permalink again in settings -> Permalinks.', 'cool-timeline1' ),
				),

				array(
					'id'     => 'story_content_settings',
					'type'   => 'fieldset',
					'title'  => 'Story Content',
					'fields' => array(
						array(
							'id'      => 'read_more_lbl',
							'type'    => 'text',
							'title'   => 'Stories Read more Text',
							'default' => '',
						),
						array(
							'id'        => 'story_link_target',
							'type'      => 'radio',
							'title'     => 'Open read more link in ? ',
							'options'   => array(
								'_self'  => 'Same Tab',
								'_blank' => 'new Tab',
							),
							'inline'    => true,
							'()default' => '_self',
						),

						array(
							'id'    => 'default_icon',
							'type'  => 'icon',
							'title' => 'Stories default Icon',
							'std'   => '',

						),

					),
				), // End Fieldset

			// Create a Fieldset
				array(
					'id'     => 'story_media_settings',
					'type'   => 'fieldset',
					'title'  => 'Story Media',
					'fields' => array(

						// Create a Fieldset
						array(
							'id'      => 'stories_images',
							'type'    => 'radio',
							'title'   => 'Stories Images ? ',
							'options' => array(
								'popup'         => 'In Popup( CT Lightbox )',
								'theme-popup'   => 'In Popup( Theme Lightbox )',
								'single'        => 'Story detail link',
								'disable_links' => 'Disable links',
							),
							'inline'  => true,
							'default' => 'popup',
							'desc'    => ' * Choose theme lightbox if your theme supports an image lightbox . ',
						),

						array(
							'id'      => 'ctl_slideshow',
							'type'    => 'radio',
							'title'   => 'Stories Slideshow ? ',
							'options' => array(
								true  => 'Enable',
								false => 'Disable',
							),
							'inline'  => true,
							'default' => 'true',
							'desc'    => ' * Enable or Disable Media slider autoplay . ',
						),

						array(
							'id'         => 'animation_speed',
							'type'       => 'text',
							'title'      => 'Slide Show Speed( for Image Slideshow in Vertical Timeline ) ? ',
							'default'    => '5000',
							'desc'       => 'Enter the speed in milliseconds 1000 = 1 second',
							'dependency' => array( 'ctl_slideshow', ' == ', 'true' ),
						),

					),
				), // End Fieldset

				array(
					'id'      => 'disable_FA',
					'type'    => 'radio',
					'title'   => 'Disable Font Awesome CSS ? ',
					'options' => array(
						'yes' => 'Yes',
						'no'  => 'No',
					),
					'inline'  => true,
					'default' => 'no',
					'desc'    => 'Remove Font Awesome icons CSS from all pages',
				),

				array(
					'id'      => 'disable_GF',
					'type'    => 'radio',
					'title'   => 'Disable Google Font ? ',
					'options' => array(
						'yes' => 'Yes',
						'no'  => 'No',
					),
					'inline'  => true,
					'default' => 'no',
					'desc'    => 'Remove google fonts CSS from all pages',
				),

				array(
					'id'      => 'disable_vr_slider',
					'type'    => 'radio',
					'title'   => 'Disable Slideshow in Vertical Layout ? ',
					'options' => array(
						'yes' => 'Yes',
						'no'  => 'No',
					),
					'inline'  => true,
					'default' => 'no',
					'desc'    => 'Remove Swiper JS and CSS from all pages',
				),

				array(
					'id'          => 'ctl_user_role',
					'type'        => 'select',
					'title'       => 'Timeline User Roles',
					'placeholder' => 'Select User Role',
					'options'     => $user_roles,
				),
			),
		)
	);


	// Create a section
	CTL::createSection(
		$prefix,
		array(
			'title'  => 'Style Settings',
			'fields' => array(

				array(
					'id'      => 'first_story_position',
					'type'    => 'button_set',
					'title'   => 'Vertical Timeline Stories Starts From',
					'desc'    => 'Not for Compact and Horizontal layout',
					'options' => array(
						'left'  => 'Left',
						'right' => 'Right',
					),
					'default' => 'right',
				),

				array(
					'id'      => 'content_bg_color',
					'type'    => 'color',
					'title'   => 'Story Background Color',
					'default' => '#ffffff',
				),

				array(
					'id'      => 'content_color',
					'type'    => 'color',
					'title'   => 'Content Font Color',
					'default' => '#666666',
				),

				array(
					'id'      => 'title_color',
					'type'    => 'color',
					'title'   => 'Story Title Color',
					'default' => '#ffffff',
				),

				array(
					'id'      => 'circle_border_color',
					'type'    => 'color',
					'title'   => 'Year Background Color',
					'default' => '#025149',
				),

				array(
					'id'      => 'year_label_color',
					'type'    => 'color',
					'title'   => 'Year Label Color',
					'default' => '#ffffff',
				),

				array(
					'id'      => 'line_color',
					'type'    => 'color',
					'title'   => 'Line Color',
					'default' => '#025149',
				),

				array(
					'id'      => 'line_filling_color',
					'type'    => 'color',
					'title'   => 'Line Filling Color',
					'default' => '#38aab7',
				),

				array(
					'id'      => 'first_post',
					'type'    => 'color',
					'title'   => 'First Color',
					'default' => '#02C5BE',
				),

				array(
					'id'      => 'second_post',
					'type'    => 'color',
					'title'   => 'Second Color',
					'default' => '#F12945',
				),
				array(
					'id'      => 'custom_date_color',
					'type'    => 'radio',
					'title'   => 'Enable custom date color',
					'options' => array(
						'yes' => 'Yes',
						'no'  => 'No(Default style)',
					),
					'inline'  => true,
					'default' => 'no',
				),

				array(
					'id'         => 'ctl_date_color',
					'type'       => 'color',
					'title'      => 'Stories date color',
					'default'    => '#000000',
					'dependency' => array( 'custom_date_color', '==', 'yes' ),
				),

				array(
					'id'       => 'custom_styles',
					'type'     => 'code_editor',
					'title'    => 'Custom Styles',
					'settings' => array(
						'theme' => 'mbo',
						'mode'  => 'css',
					),
				),

			),
		)
	);

	// Create a section
	CTL::createSection(
		$prefix,
		array(
			'title'  => 'Typography Setings',
			'fields' => array(


				array(
					'id'         => 'ctl_date_typo',
					'type'       => 'typography',
					'title'      => 'Story Date',
					'default'    => array(
						'font-family' => 'Maven Pro',
						'font-size'   => '21',
						'line-height' => '',
						'unit'        => 'px',
						'type'        => 'google',
						'text-align'  => 'center',
						'font-weight' => '700',
					),
					'text_align' => false,
					'color'      => false,
				),

				array(
					'id'      => 'post_title_typo',
					'type'    => 'typography',
					'title'   => 'Story Title',
					'default' => array(
						'font-family' => 'Maven Pro',
						'font-size'   => '20',
						'line-height' => '',
						'unit'        => 'px',
						'type'        => 'google',
						'font-weight' => '700',
					),
					'color'   => false,
				),

				// A textarea field

				array(
					'id'      => 'post_content_typo',
					'type'    => 'typography',
					'title'   => 'Story Content',
					'default' => array(
						'font-family' => 'Maven Pro',
						'font-size'   => '16',
						'line-height' => '',
						'unit'        => 'px',
						'type'        => 'google',
					),
					'color'   => false,
				),

			),
		)
	);

	// Create a section
	CTL::createSection(
		$prefix,
		array(
			'title'  => 'Get Started',
			'fields' => array(
				array(
					'id'      => 'timeline_display',
					'type'    => 'content',
					'content' => ctl_demo_page_content(),
				),
			),
		)
	);
	// End Section

}

function ctl_demo_page_content() {
	$data = '<div class="ctl_started-section">

			<a class="button button-primary" href="https://cooltimeline.com/docs/cool-timeline-pro/?utm_source=ctp_plugin&utm_medium=inside&utm_campaign=docs&utm_content=getting-started" target="_blank">Check Full Documentation</a>

            <div class="ctl_step">
                <div class="ctl_step-content">
                    <!-- <div class="ctl_steps">
                        <h6>' . 'Step 1' . '</h6>
                    </div> -->
                    <div class="ctl_steps-title">
                        <h2>' . 'Add License Key' . '</h2>
                    </div>
                    <div class="ctl_steps-list">
                        <ol>
                            <li class="ctl_step-data">

                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' .
							 'Navigate to the License settings page inside Timeline Addons Section' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' .
							'Enter your <strong>license key</strong>.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'Please enter the <strong>email</strong> you used to buy the plugin.' . '.</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'Click on the <strong>Verify Key</strong> button.' . '</span>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="ctl_video-section">
                    <video class="ctl_timeline-video" controls="">
                        <source src="https://cooltimeline.com/wp-content/uploads/2023/09/Cool-Timeline-Product-Registration-‹-test-—-WordPress.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <div class="ctl_step ctl_col-rev">
                <div class="ctl_video-section">
                    <video class="ctl_timeline-video" controls="">
                        <source src="https://cooltimeline.com/wp-content/uploads/2023/05/cool_timeline_add_new_story.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="ctl_step-content">
                    <!-- <div class="ctl_steps">
                        <h6>' . 'Step 2' . '</h6>
                    </div> -->
                    <div class="ctl_steps-title">
                        <h2>' . 'Add Timeline Stories' . '</h2>
                    </div>
                    <div class="ctl_steps-list">
                        <ol>
                            <li class="ctl_step-data">

                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'After activating Cool Timeline Pro, you will see a new menu item called <strong>“Timeline Stories”</strong> in your WordPress Dashboard.' . '
                                </span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'To create a new story for your timeline, go to “Timeline Addons” and select <strong>“Add New Story”</strong>.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'You can add details about your story, such as the title, date, image, and description.' . '
                                </span>
                            </li>

                        </ol>
                    </div>
                </div>

            </div>

            <div class="ctl_step">
                <div class="ctl_step-content">
                    <!-- <div class="ctl_steps">
                        <h6>' . 'Step 3' . '</h6>
                    </div> -->
                    <div class="ctl_steps-title">
                        <h2>' . 'Add Timeline Inside The Page' . '
                        </h2>
                        <div class="ctl_high-txt"> ' . 'Using shortcodes' . ':</div>
                    </div>

                    <div class="ctl_steps-list">

                        <ol>
                            <li class="ctl_step-data">

                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'Just Copy Shortcode from the Demo website and Paste it to your Page or Post.' . '
                                </span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'You can also generate shortcodes using Shortcodes Generator.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'Using Gutenberg Timeline Story Block.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'Using Visual Composer Timeline Stories Addon.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'Using ShortCode in Elementor.' . '</strong></span>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="ctl_video-section">
                    <video class="ctl_timeline-video" controls="">
                        <source src="https://cooltimeline.com/wp-content/uploads/2023/05/how-to-add-ctl-timeline-inside-the-page.mp4" type="video/mp4">
                    </video>
                </div>
            </div>

            <div class="ctl_step ctl_col-rev">
                <div class="ctl_video-section">
                    <video class="ctl_timeline-video" controls="">
                        <source src="https://cooltimeline.com/wp-content/uploads/2023/05/ctl-timeline-settings.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="ctl_step-content">
                   <!-- <div class="ctl_steps">
                        <h6>' . 'Step 4' . '</h6>
                    </div> -->
                    <div class="ctl_steps-title">
                        <h2>' . 'Configure Timeline Stories' . '</h2>
                        <div class="ctl_high-txt"> ' . 'Settings (Layout / Design etc.)' . ':</div>
                    </div>

                    <div class="ctl_steps-list">

                        <ol>
                            <li class="ctl_step-data">

                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'The Cool Timeline Pro setting tab is located on the right-hand side of the WordPress editor.' . '
                                </span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'It allows you to adjust attribute values inside your shortcodes.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'You can use it for customization of various options, such as Layout, Design, Category, Stories Per Page, and Order.' . '
                                </span>
                            </li>

                        </ol>
                    </div>
                </div>

            </div>

            <div class="ctl_step ctl_row-rev">
                <div class="ctl_video-section">
                    <video class="ctl_timeline-video" controls="">
                        <source src="https://cooltimeline.com/wp-content/uploads/2023/09/post-timeline.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="ctl_step-content">
                   <!-- <div class="ctl_steps">
                        <h6>' . 'Step 4' . '</h6>
                    </div> -->
                    <div class="ctl_steps-title">
                        <h2>' . 'Configure Post Timeline' . '</h2>
                       <div class="ctl_high-txt"> ' . 'Settings (Post / pages etc.)' . ':</div> 
                    </div>

                    <div class="ctl_steps-list">

                        <ol>
                            <li class="ctl_step-data">

                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'The Post Timeline block setting tab is located on the right-hand side of the WordPress editor.' . '
                                </span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'You can create a timeline based on Posts and Pages.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'Allows you to display custom post type using post timeline block.' . '
                                </span>
                            </li>

                        </ol>
                    </div>
                </div>

            </div>

            <div class="ctl_step ctl_col-rev">
                <div class="ctl_video-section">
                    <video class="ctl_timeline-video" controls="">
                        <source src="https://cooltimeline.com/wp-content/uploads/2023/09/Untitled-design-3-2.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="ctl_step-content">
                   <!-- <div class="ctl_steps">
                        <h6>' . 'Step 4' . '</h6>
                    </div> -->
                    <div class="ctl_steps-title">
                        <h2>' . 'Configure Timeline Block' . '</h2>
                        <!-- <div class="ctl_high-txt"> ' . 'Settings (Layout / Design etc.)' . ':</div> -->
                    </div>

                    <div class="ctl_steps-list">

                        <ol>
                            <li class="ctl_step-data">

                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'You can use the Cool Timeline Block to instantly edit your timeline stories with the power of Gutenberg.' . '
                                </span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'The timeline block consists of two elements: parent and child.' . '</span>
                            </li>
                            <li class="ctl_step-data">
                                <!-- <span class="ctl_list-icon"><i class="fa fa-check" aria-hidden="true"></i></span> -->
                                <span class="ctl_list-text">' . 'You can customize several options, including colors, layout, design, and media.' . '
                                </span>
                            </li>

                        </ol>
                    </div>
                </div>

            </div>
			
        </div>';

	return $data;
}
