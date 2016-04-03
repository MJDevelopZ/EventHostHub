<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Module Name: Contact
 */
class TB_Contact_Module extends Themify_Builder_Module {
	function __construct() {
		parent::__construct(array(
			'name' => __('Contact', 'builder-contact'),
			'slug' => 'contact'
		));
	}

	public function get_options() {
		return array(
			array(
				'id' => 'mod_title_contact',
				'type' => 'text',
				'label' => __('Module Title', 'builder-contact'),
				'class' => 'large'
			),
			array(
				'id' => 'layout_contact',
				'type' => 'layout',
				'label' => __('Layout', 'builder-contact'),
				'options' => array(
					array('img' => Builder_Contact::get_instance()->url . 'assets/style1.png', 'value' => 'style1', 'label' => __('Style 1', 'builder-contact')),
					array('img' => Builder_Contact::get_instance()->url . 'assets/style2.png', 'value' => 'style2', 'label' => __('Style 2', 'builder-contact')),
					array('img' => Builder_Contact::get_instance()->url . 'assets/style3.png', 'value' => 'style3', 'label' => __('Style 3', 'builder-contact')),
				),
			),
			array(
				'id' => 'mail_contact',
				'type' => 'text',
				'label' => __('Send to', 'builder-contact'),
				'class' => 'large',
				'after' => '<br><small>' . __( 'To send the form to multiple recipients, comma-separate the mail addresses.', 'builder-contact' ) . '</small>',
			),
			array(
				'id' => 'default_subject',
				'type' => 'text',
				'label' => __( 'Default Subject', 'builder-contact' ),
				'class' => 'large',
				'after' => '<br><small>' . __( 'This will be used as the subject of the mail if the Subject field is not shown on the contact form.', 'builder-contact' ) . '</small>',
			),
			array(
				'id' => 'fields_contact',
				'type' => 'contact_fields',
				'label' => __('Fields', 'builder-contact'),
				'class' => 'large'
			),
		);
	}

	public function get_styling() {
		return array(
			// Animation
			array(
				'id' => 'separator_animation',
				'title' => '',
				'description' => '',
				'type' => 'separator',
				'meta' => array('html'=>'<h4>'.__('Animation', 'builder-contact').'</h4>'),
			),
			array(
				'id' => 'animation_effect',
				'type' => 'animation_select',
				'label' => __( 'Effect', 'builder-contact' )
			),
			// Background
			array(
				'type' => 'separator',
				'meta' => array('html'=>'<hr />')
			),
			array(
				'id' => 'separator_image_background',
				'title' => '',
				'description' => '',
				'type' => 'separator',
				'meta' => array('html'=>'<h4>'.__('Background', 'builder-contact').'</h4>'),
			),
			array(
				'id' => 'background_color',
				'type' => 'color',
				'label' => __('Background Color', 'builder-contact'),
				'class' => 'small',
				'prop' => 'background-color',
				'selector' => '.module-contact'
			),
			// Font
			array(
				'type' => 'separator',
				'meta' => array('html'=>'<hr />')
			),
			array(
				'id' => 'separator_font',
				'type' => 'separator',
				'meta' => array('html'=>'<h4>'.__('Font', 'builder-contact').'</h4>'),
			),
			array(
				'id' => 'font_family',
				'type' => 'font_select',
				'label' => __('Font Family', 'builder-contact'),
				'class' => 'font-family-select',
				'prop' => 'font-family',
				'selector' => array( '.module-contact' )
			),
			array(
				'id' => 'font_color',
				'type' => 'color',
				'label' => __('Font Color', 'builder-contact'),
				'class' => 'small',
				'prop' => 'color',
				'selector' => array( '.module-contact' )
			),
			array(
				'id' => 'multi_font_size',
				'type' => 'multi',
				'label' => __('Font Size', 'builder-contact'),
				'fields' => array(
					array(
						'id' => 'font_size',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'font-size',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'font_size_unit',
						'type' => 'select',
						'meta' => array(
							array('value' => '', 'name' => ''),
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => 'em', 'name' => __('em', 'builder-contact'))
						)
					)
				)
			),
			array(
				'id' => 'multi_line_height',
				'type' => 'multi',
				'label' => __('Line Height', 'builder-contact'),
				'fields' => array(
					array(
						'id' => 'line_height',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'line-height',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'line_height_unit',
						'type' => 'select',
						'meta' => array(
							array('value' => '', 'name' => ''),
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => 'em', 'name' => __('em', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					)
				)
			),
			array(
				'id' => 'text_align',
				'label' => __( 'Text Align', 'builder-contact' ),
				'type' => 'radio',
				'meta' => array(
					array( 'value' => '', 'name' => __( 'Default', 'builder-contact' ), 'selected' => true ),
					array( 'value' => 'left', 'name' => __( 'Left', 'builder-contact' ) ),
					array( 'value' => 'center', 'name' => __( 'Center', 'builder-contact' ) ),
					array( 'value' => 'right', 'name' => __( 'Right', 'builder-contact' ) ),
					array( 'value' => 'justify', 'name' => __( 'Justify', 'builder-contact' ) )
				),
				'prop' => 'text-align',
				'selector' => '.module-contact'
			),
			// Padding
			array(
				'type' => 'separator',
				'meta' => array('html'=>'<hr />')
			),
			array(
				'id' => 'separator_padding',
				'type' => 'separator',
				'meta' => array('html'=>'<h4>'.__('Padding', 'builder-contact').'</h4>'),
			),
			array(
				'id' => 'multi_padding_top',
				'type' => 'multi',
				'label' => __('Padding', 'builder-contact'),
				'fields' => array(
					array(
						'id' => 'padding_top',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'padding-top',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'padding_top_unit',
						'type' => 'select',
						'description' => __('top', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			array(
				'id' => 'multi_padding_right',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'padding_right',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'padding-right',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'padding_right_unit',
						'type' => 'select',
						'description' => __('right', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			array(
				'id' => 'multi_padding_bottom',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'padding_bottom',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'padding-bottom',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'padding_bottom_unit',
						'type' => 'select',
						'description' => __('bottom', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			array(
				'id' => 'multi_padding_left',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'padding_left',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'padding-left',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'padding_left_unit',
						'type' => 'select',
						'description' => __('left', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			// Margin
			array(
				'type' => 'separator',
				'meta' => array('html'=>'<hr />')
			),
			array(
				'id' => 'separator_margin',
				'type' => 'separator',
				'meta' => array('html'=>'<h4>'.__('Margin', 'builder-contact').'</h4>'),
			),
			array(
				'id' => 'multi_margin_top',
				'type' => 'multi',
				'label' => __('Margin', 'builder-contact'),
				'fields' => array(
					array(
						'id' => 'margin_top',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'margin-top',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'margin_top_unit',
						'type' => 'select',
						'description' => __('top', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			array(
				'id' => 'multi_margin_right',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'margin_right',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'margin-right',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'margin_right_unit',
						'type' => 'select',
						'description' => __('right', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			array(
				'id' => 'multi_margin_bottom',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'margin_bottom',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'margin-bottom',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'margin_bottom_unit',
						'type' => 'select',
						'description' => __('bottom', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			array(
				'id' => 'multi_margin_left',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'margin_left',
						'type' => 'text',
						'class' => 'xsmall',
						'prop' => 'margin-left',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'margin_left_unit',
						'type' => 'select',
						'description' => __('left', 'builder-contact'),
						'meta' => array(
							array('value' => 'px', 'name' => __('px', 'builder-contact')),
							array('value' => '%', 'name' => __('%', 'builder-contact'))
						)
					),
				)
			),
			// Border
			array(
				'type' => 'separator',
				'meta' => array('html'=>'<hr />')
			),
			array(
				'id' => 'separator_border',
				'type' => 'separator',
				'meta' => array('html'=>'<h4>'.__('Border', 'builder-contact').'</h4>'),
			),
			array(
				'id' => 'multi_border_top',
				'type' => 'multi',
				'label' => __('Border', 'builder-contact'),
				'fields' => array(
					array(
						'id' => 'border_top_color',
						'type' => 'color',
						'class' => 'small',
						'prop' => 'border-top-color',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'border_top_width',
						'type' => 'text',
						'description' => 'px',
						'class' => 'xsmall',
						'prop' => 'border-top-width',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'border_top_style',
						'type' => 'select',
						'description' => __('top', 'builder-contact'),
						'meta' => array(
							array( 'value' => '', 'name' => '' ),
							array( 'value' => 'solid', 'name' => __( 'Solid', 'builder-contact' ) ),
							array( 'value' => 'dashed', 'name' => __( 'Dashed', 'builder-contact' ) ),
							array( 'value' => 'dotted', 'name' => __( 'Dotted', 'builder-contact' ) ),
							array( 'value' => 'double', 'name' => __( 'Double', 'builder-contact' ) )
						),
						'prop' => 'border-top-style',
						'selector' => '.module-contact'
					)
				)
			),
			array(
				'id' => 'multi_border_right',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'border_right_color',
						'type' => 'color',
						'class' => 'small',
						'prop' => 'border-right-color',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'border_right_width',
						'type' => 'text',
						'description' => 'px',
						'class' => 'xsmall'
					),
					array(
						'id' => 'border_right_style',
						'type' => 'select',
						'description' => __('right', 'builder-contact'),
						'meta' => array(
							array( 'value' => '', 'name' => '' ),
							array( 'value' => 'solid', 'name' => __( 'Solid', 'builder-contact' ) ),
							array( 'value' => 'dashed', 'name' => __( 'Dashed', 'builder-contact' ) ),
							array( 'value' => 'dotted', 'name' => __( 'Dotted', 'builder-contact' ) ),
							array( 'value' => 'double', 'name' => __( 'Double', 'builder-contact' ) )
						),
						'prop' => 'border-right-style',
						'selector' => '.module-contact'
					)
				)
			),
			array(
				'id' => 'multi_border_bottom',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'border_bottom_color',
						'type' => 'color',
						'class' => 'small',
						'prop' => 'border-bottom-color',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'border_bottom_width',
						'type' => 'text',
						'description' => 'px',
						'class' => 'xsmall',
						'prop' => 'border-bottom-width',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'border_bottom_style',
						'type' => 'select',
						'description' => __('bottom', 'builder-contact'),
						'meta' => array(
							array( 'value' => '', 'name' => '' ),
							array( 'value' => 'solid', 'name' => __( 'Solid', 'builder-contact' ) ),
							array( 'value' => 'dashed', 'name' => __( 'Dashed', 'builder-contact' ) ),
							array( 'value' => 'dotted', 'name' => __( 'Dotted', 'builder-contact' ) ),
							array( 'value' => 'double', 'name' => __( 'Double', 'builder-contact' ) )
						),
						'prop' => 'border-bottom-style',
						'selector' => '.module-contact'
					)
				)
			),
			array(
				'id' => 'multi_border_left',
				'type' => 'multi',
				'label' => '',
				'fields' => array(
					array(
						'id' => 'border_left_color',
						'type' => 'color',
						'class' => 'small',
						'prop' => 'border-left-color',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'border_left_width',
						'type' => 'text',
						'description' => 'px',
						'class' => 'xsmall',
						'prop' => 'border-left-width',
						'selector' => '.module-contact'
					),
					array(
						'id' => 'border_left_style',
						'type' => 'select',
						'description' => __('left', 'builder-contact'),
						'meta' => array(
							array( 'value' => '', 'name' => '' ),
							array( 'value' => 'solid', 'name' => __( 'Solid', 'builder-contact' ) ),
							array( 'value' => 'dashed', 'name' => __( 'Dashed', 'builder-contact' ) ),
							array( 'value' => 'dotted', 'name' => __( 'Dotted', 'builder-contact' ) ),
							array( 'value' => 'double', 'name' => __( 'Double', 'builder-contact' ) )
						),
						'prop' => 'border-left-style',
						'selector' => '.module-contact'
					)
				)
			),
			// Additional CSS
			array(
				'type' => 'separator',
				'meta' => array( 'html' => '<hr/>')
			),
			array(
				'id' => 'css_class_contact',
				'type' => 'text',
				'label' => __('Additional CSS Class', 'builder-contact'),
				'class' => 'large exclude-from-reset-field',
				'description' => sprintf( '<br/><small>%s</small>', __('Add additional CSS class(es) for custom styling', 'builder-contact') )
			)
		);
	}
}

function themify_builder_field_contact_fields( $field, $mod_name ) {
	?>
	<div class="themify_builder_field builder_contact_fields">
		<div class="themify_builder_label"><?php _e( 'Fields', 'builder-contact' ) ?></div>
		<div class="themify_builder_input">
		<table class="contact_fields">
		<thead>
			<tr>
				<th><?php _e( 'Field', 'builder-contact' ); ?></th>
				<th><?php _e( 'Label', 'builder-contact' ); ?></th>
				<th><?php _e( 'Show', 'builder-contact' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php _e( 'Name', 'builder-contact' ) ?></td>
				<td><input type="text" id="field_name_label" name="field_name_label" value="" class="tfb_lb_option" placeholder="<?php _e( 'Name', 'builder-contact' ) ?>"  /></td>
				<td></td>
			</tr>
			<tr>
				<td><?php _e( 'Email', 'builder-contact' ) ?></td>
				<td><input type="text" id="field_email_label" name="field_email_label" value="" class="tfb_lb_option" placeholder="<?php _e( 'Email', 'builder-contact' ) ?>" /></td>
				<td></td>
			</tr>
			<tr>
				<td><?php _e( 'Subject', 'builder-contact' ) ?></td>
				<td><input type="text" id="field_subject_label" name="field_subject_label" value="" class="tfb_lb_option" placeholder="<?php _e( 'Subject', 'builder-contact' ) ?>" /></td>
				<td class="tfb_lb_option themify-checkbox" id="field_subject_active"><input type="checkbox" name="field_subject_active" value="yes" class="tf-checkbox" /></td>
			</tr>
			<tr>
				<td><?php _e( 'Captcha', 'builder-contact' ) ?></td>
				<td><input type="text" id="field_captcha_label" name="field_captcha_label" value="" class="tfb_lb_option" placeholder="<?php _e( 'Captcha', 'builder-contact' ) ?>" />
				<p class="description"><?php printf( __( 'To use Captcha please make sure you have configured the <a href="%s">reCAPTCHA settings</a>.', 'builder-contact' ), admin_url( 'admin.php?page=builder-contact' ) ); ?></p>
				</td>
				<td class="tfb_lb_option themify-checkbox" id="field_captcha_active"><input type="checkbox" name="field_captcha_active" value="yes" class="tf-checkbox" /></td>
			</tr>
			<tr>
				<td><?php _e( 'Message', 'builder-contact' ) ?></td>
				<td><input type="text" id="field_message_label" name="field_message_label" value="" class="tfb_lb_option" placeholder="<?php _e( 'Message', 'builder-contact' ) ?>" /></td>
				<td class=""></td>
			</tr>
			<tr>
				<td><?php _e( 'Send Copy', 'builder-contact' ) ?></td>
				<td><input type="text" id="field_sendcopy_label" name="field_sendcopy_label" value="" class="tfb_lb_option" placeholder="<?php _e( 'Send Copy', 'builder-contact' ) ?>" /></td>
				<td class="tfb_lb_option themify-checkbox" id="field_sendcopy_active"><input type="checkbox" name="field_sendcopy_active" value="yes" class="tf-checkbox" /></td>
			</tr>
			<tr>
				<td><?php _e( 'Send Button', 'builder-contact' ) ?></td>
				<td><input type="text" id="field_send_label" name="field_send_label" value="" class="tfb_lb_option" placeholder="<?php _e( 'Send', 'builder-contact' ) ?>" /></td>
				<td class="">&nbsp;</td>
			</tr>
		</tbody>
		</table>
		</div>
	</div>
	<?php
}

Themify_Builder_Model::register_module( 'TB_Contact_Module' );