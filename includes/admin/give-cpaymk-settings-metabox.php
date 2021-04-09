<?php

class Give_cPayMK_Settings_Metabox {
	private static $instance;

	private function __construct() {

	}

	public static function get_instance() {
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	* Setup hooks.
	*/
	public function setup_hooks() {
		if (is_admin()) {
			add_action('admin_enqueue_scripts', array($this, 'enqueue_js'));
			add_filter('give_forms_cpaymk_metabox_fields', array($this, 'give_cpaymk_add_settings'));
			add_filter('give_metabox_form_data_settings', array($this, 'add_cpaymk_setting_tab'), 0, 1);
		}
	}

	public function add_cpaymk_setting_tab($settings) {
		if (give_is_gateway_active('cpaymk')) {
			$settings['cpaymk_options'] = apply_filters('give_forms_cpaymk_options', array(
				'id'			=> 'cpaymk_options',
				'title'		=> __('cPayMK', 'give'),
				'icon-html'	=> '<span class="give-icon give-icon-purse"></span>',
				'fields'		=> apply_filters('give_forms_cpaymk_metabox_fields', array()),
			));
		}

		return $settings;
	}

	public function give_cpaymk_add_settings($settings) {

			// Bailout: Do not show offline gateways setting in to metabox if its disabled globally.
			if (in_array('cpaymk', (array) give_get_option('gateways'))) {
				return $settings;
			}

			$is_gateway_active = give_is_gateway_active('cpaymk');

			//this gateway isn't active
			if (!$is_gateway_active) {
				//return settings and bounce
				return $settings;
			}

			//Fields
			$check_settings = array(

			array(
				'name'			=> __('cPayMK', 'give-cpaymk'),
				'desc'			=> __('Do you want to customize the donation instructions for this form?', 'give-cpaymk'),
				'id'				=> 'cpaymk_customize_cpaymk_donations',
				'type'			=> 'radio_inline',
				'default'		=> 'global',
				'options'		=> apply_filters('give_forms_content_options_select', array(
					'global'			=> __('Global Option',	'give-cpaymk'),
					'enabled'		=> __('Customize', 		'give-cpaymk'),
					'disabled'		=> __('Disable',			'give-cpaymk'),
				)
				),
			),
			array(
				'name'			=> __('API Secret Key', 'give-cpaymk'),
				'desc'			=> __('Enter your API Secret Key, found in your cPayMK Account Settings.', 'give-cpaymk'),
				'id'				=> 'cpaymk_api_key',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('Collection ID', 'give-cpaymk'),
				'desc'			=> __('Enter your Billing Collection ID.', 'give-cpaymk'),
				'id'				=> 'cpaymk_collection_id',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('X Signature Key', 'give-cpaymk'),
				'desc'			=> __('Enter your X Signature Key, found in your cPayMK Account Settings.', 'give-cpaymk'),
				'id'				=> 'cpaymk_x_signature_key',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('Bill Description', 'give-cpaymk'),
				'desc'			=> __('Enter description to be included in the bill.', 'give-cpaymk'),
				'id'				=> 'cpaymk_description',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('Reference 1 Label', 'give-cpaymk'),
				'desc'			=> __('Enter reference 1 label.', 'give-cpaymk'),
				'id'				=> 'cpaymk_reference_1_label',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('Reference 1', 'give-cpaymk'),
				'desc'			=> __('Enter reference 1.', 'give-cpaymk'),
				'id'				=> 'cpaymk_reference_1',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('Reference 2 Label', 'give-cpaymk'),
				'desc'			=> __('Enter reference 2 label.', 'give-cpaymk'),
				'id'				=> 'cpaymk_reference_2_label',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('Reference 2', 'give-cpaymk'),
				'desc'			=> __('Enter reference 2.', 'give-cpaymk'),
				'id'				=> 'cpaymk_reference_2',
				'type'			=> 'text',
				'row_classes'	=> 'give-cpaymk-key',
			),
			array(
				'name'			=> __('Billing Fields', 'give-cpaymk'),
				'desc'			=> __('This option will enable the billing details section for cPayMK which requires the donor\'s address to complete the donation. These fields are not required by cPayMK to process the transaction, but you may have the need to collect the data.', 'give-cpaymk'),
				'id'				=> 'cpaymk_collect_billing',
				'row_classes'	=> 'give-subfield give-hidden',
				'type'			=> 'radio_inline',
				'default'		=> 'disabled',
				'options'		=> array(
					'enabled'		=> __('Enabled',  'give-cpaymk'),
					'disabled'		=> __('Disabled', 'give-cpaymk'),
				),
			),
		);

		return array_merge($settings, $check_settings);
	}

	public function enqueue_js($hook) {
		if ('post.php' === $hook || $hook === 'post-new.php') {
			wp_enqueue_script('give_cpaymk_each_form', GIVE_CPAYMK_PLUGIN_URL . '/includes/js/meta-box.js');
		}
	}
}

Give_cPayMK_Settings_Metabox::get_instance()->setup_hooks();
