<?php

/**
 * Class Give_cPayMK_Settings
 *
 * @since 3.0.2
 */
class Give_cPayMK_Settings
{

	/**
	* @access private
	* @var Give_cPayMK_Settings $instance
	*/
	private static $instance;

	/**
	* @access private
	* @var string $section_id
	*/
	private $section_id;

	/**
	* @access private
	*
	* @var string $section_label
	*/
	private $section_label;

	/**
	* Give_cPayMK_Settings constructor.
	*/
	private function __construct() {

	}

	/**
	* get class object.
	*
	* @return Give_cPayMK_Settings
	*/
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

			$this->section_id = 'cpaymk';
			$this->section_label = __('cPayMK', 'give-cpaymk');

			if (is_admin()) {
						// Add settings.
						add_filter('give_get_settings_gateways', array($this, 'add_settings'), 99);
						add_filter('give_get_sections_gateways', array($this, 'add_sections'), 99);
			}
	}

	/**
	* Add setting section.
	*
	* @param array $sections Array of section.
	*
	* @return array
	*/
	public function add_sections($sections) {
		$sections[$this->section_id] = $this->section_label;

		return $sections;
	}

	/**
	* Add plugin settings.
	*
	* @param array $settings Array of setting fields.
	*
	* @return array
	*/
	public function add_settings($settings) {
		$current_section = give_get_current_setting_section();

		if ($current_section != 'cpaymk') {
			return $settings;
		}

		$give_cpaymk_settings = array(
			array(
				'name'			=> __('cPayMK Settings', 'give-cpaymk'),
				'id'				=> 'give_title_gateway_cpaymk',
				'type'			=> 'title',
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
				'type'			=> 'radio_inline',
				'default'		=> 'disabled',
				'options'		=> array(
					'enabled'		=> __('Enabled',  'give-cpaymk'),
					'disabled'		=> __('Disabled', 'give-cpaymk'),
				),
			),
			array(
				'type'			=> 'sectionend',
				'id'				=> 'give_title_gateway_cpaymk',
			),
		);

		return array_merge($settings, $give_cpaymk_settings);
	}
}

Give_cPayMK_Settings::get_instance()->setup_hooks();
