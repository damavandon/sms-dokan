<?php
// ═══════════════════════════ :هشدار: ═══════════════════════════

// ‫ تمامی حقوق مادی و معنوی این افزونه متعلق به سایت پیامیتو به آدرس payamito.com می باشد
// ‫ و هرگونه تغییر در سورس یا استفاده برای درگاهی غیراز پیامیتو ،
// ‫ قانوناً و شرعاً غیرمجاز و دارای پیگرد قانونی می باشد.

// © 2022 Payamito.com, Kian Dev Co. All rights reserved.

// ════════════════════════════════════════════════════════════════



namespace Payamito\VV\Settings;


/**
 * Register an options panel.
 *
 * @package Payamito
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

class  Settings
{
	/**
	 * Holds the options panel controller.
	 *
	 * @var object
	 */
	protected $panel;
	public $meta_keys;
	/**
	 * Get things started.
	 */
	public function __construct()
	{
		add_filter('payamito_add_section', [$this, 'register_settings'], 1);
	}

	public function register_settings($section)
	{

		$awesome_support_sms_settings = array(
			'title'  => esc_html__('Vendor Verification', 'payamito-vendor-verification'),
			'fields' =>	array(
					array(
					'id'    => 'payamito_vv_otp_active',
					'type'  => 'switcher',
					'title'  => esc_html__('Active', 'payamito-vendor-verification'),
				),
				array(
					'id'    => 'payamito_vv_otp_active_p',
					'type'  => 'switcher',
					'title'      => payamito_dynamic_text( 'pattern_active_title' ),
					'desc'       => payamito_dynamic_text( 'pattern_active_desc' ),
					'help'       => payamito_dynamic_text( 'pattern_active_help' ),
					'dependency' => array("payamito_vv_otp_active", '==', 'true'),
				),
				array(
					'id'   => 'payamito_vv_otp_p',
					'type'    => 'text',
					'title'      => payamito_dynamic_text( 'pattern_ID_title' ),
					'desc'       => payamito_dynamic_text( 'pattern_ID_desc' ),
					'help'       => payamito_dynamic_text( 'pattern_ID_help' ),
					'dependency' => array("payamito_vv_otp_active|payamito_vv_otp_active_p", '==|==', 'true|true'),
				),
				array(
					'id'     => 'payamito_vv_otp_repeater',
					'type'   => 'repeater',
					'title'      => payamito_dynamic_text( 'pattern_Variable_title' ),
					'desc'       => payamito_dynamic_text( 'pattern_Variable_desc' ),
					'help'       => payamito_dynamic_text( 'pattern_Variable_help' ),
					'max' => '2',
					'dependency' => array("payamito_vv_otp_active|payamito_vv_otp_active_p", '==|==', 'true|true'),
					'fields' => array(
						array(
							'id'   => 'payamito_vv_opt_tags',
							'placeholder' =>  esc_html__("Tags", "payamito-vendor-verification"),
							'type' => 'select',
							'options' =>
							array(
								"{OTP}" => esc_html__('OTP', 'payamito-vendor-verification'),
								"{site_name}" => esc_html__('Wordpress title', 'payamito-vendor-verification'),
							)
						),
						array(
							'id'    => 'payamito_vv_otp_user_otp',
							'type'  => 'number',
							'placeholder' =>  esc_html__("Your tag", "payamito-vendor-verification"),
							'default' => '0',
						),
					)
				),
				array(
					'id'   => 'payamito_vv_otp_sms',
					'title'      => payamito_dynamic_text( 'send_content_title' ),
					'desc'       => payamito_dynamic_text( 'send_content_desc' ),
					'help'       => payamito_dynamic_text( 'send_content_help' ),
					'type' => 'textarea',
					'dependency' => array("payamito_vv_otp_active|payamito_vv_otp_active_p", '==|!=', 'true|true'),
				),

				array(
					'id'   => 'payamito_vv_number_of_code',
					'title' => esc_html__('Number of OTP code', 'payamito-vendor-verification'),
					'desc' => esc_html__('Number of OTP code that you want send for user', 'payamito-vendor-verification'),
					'type' => 'select',
					'dependency' => array("payamito_vv_otp_active", '==', 'true'),
					'options' => apply_filters("payamito_vv_again_send_number", array(
						"4" => "4",
						"5" => "5",
						"6" => "6",
						"7" => "7",
						"8" => "8",
						"9" => "9",
						"10" => "10",
					)),
				),
				array(
					'id'   => 'payamito_vv_again_send_time',
					'title' => esc_html__('Send Again', 'payamito-vendor-verification'),
					'desc' => esc_html__('When you want the user to re-request OTP.', 'payamito-vendor-verification'),
					'type' => 'select',
					'dependency' => array("payamito_vv_otp_active", '==', 'true'),
					'options' => apply_filters("payamito_vv_again_send_time", array(
						"30" => "30",
						"60" => "60",
						"90" => "90",
						"120" => "120",
						"300" => "300",
					)),
				),
			)
		);
		array_push($section, $awesome_support_sms_settings);

		return $section;
	}
	public function option_get_admin_phone_number()
	{
		return array(
			'id'     => 'admin_phone_number_repeater',
			'type'   => 'repeater',
			'title' => esc_html__("phone number", "payamito-vendor-verification"),
			'max' => '20',

			'dependency' => array("administrator_active", '==', 'true'),
			'fields' => array(
				array(
					'id'    => 'admin_phone_number',
					'type'  => 'text',
					'placeholder' => esc_html__("Phone number ", "payamito-vendor-verification"),
					'class' => 'payamito-vendor-verification-phone-number ',
					'attributes'  => array(
						'type'      => 'tel',
						'maxlength' => 11,
						'minlength' => 11,
						"pattern" => "[0-9]{3}-[0-9]{3}-[0-9]{4}"
					),
				),
			),
		);
	}

}
