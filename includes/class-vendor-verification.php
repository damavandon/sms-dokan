<?php
// ═══════════════════════════ :هشدار: ═══════════════════════════

// ‫ تمامی حقوق مادی و معنوی این افزونه متعلق به سایت پیامیتو به آدرس payamito.com می باشد
// ‫ و هرگونه تغییر در سورس یا استفاده برای درگاهی غیراز پیامیتو ،
// ‫ قانوناً و شرعاً غیرمجاز و دارای پیگرد قانونی می باشد.

// © 2022 Payamito.com, Kian Dev Co. All rights reserved.

// ════════════════════════════════════════════════════════════════

?><?php


namespace Payamito\VV\Verification;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Payamito_OTP;

if (!defined('ABSPATH')) {

    die('Invalid request.');
}
if (!class_exists('Vendor_Verification')) {

    class Vendor_Verification
    {
        private $OTP;
        public function __construct()
        {
            global $pvv_otp_options;
            if (!isset($pvv_otp_options['active']) ||  $pvv_otp_options['active'] == false) {
                return;
            }
            add_filter('wedevs_dokan_sms_gateways', [$this, 'add_gateway'], 99, 1);

            add_filter('wedevs_sms_via_payamito', [$this, 'sms'], 99, 1);
        }

        /**
         * add payamito gateway to dokan gateways
         *
         * @since 1.0.0
         * @return array
         */
        public function add_gateway($gateway)
        {
            $options = get_option('dokan_verification_sms_gateways');
            $options['active_gateway'] = 'payamito';
            $options['payamito_username'] = 'payamito_username';
            $options['payamito_username'] = 'payamito_username';

           // $gateway['payamito'] = ['label' => __('Payamito', ' payamito-vendor-verification')];
            update_option('dokan_verification_sms_gateways', $options);
            return $gateway;
        }

        /**
         * response message
         *
         * @since 1.0.0
         * @return array
         */
        public static function message($key)
        {
            $messages = array(
                __('phone number number is incorrect', 'payamito-vendor-verification'),
                __('SMS code sent successfully', 'payamito-vendor-verification'),
                __('Failed to send SMS code ', 'payamito-vendor-verification'),
                __('An unexpected error occurred. Please contact support ', 'payamito-vendor-verification'),
                __('Enter OTP number ', 'payamito-vendor-verification'),
                __(' SMS code is Incorrect ', 'payamito-vendor-verification'),
                __('Pattern id is empty', 'payamito-vendor-verification'),
                __('Pattern is Incorrect ', 'payamito-vendor-verification'),
                __('Please wait until the end of the resend time ', 'payamito-vendor-verification'),
                __('Message content is empty ', 'payamito-vendor-verification'),

            );
            return $messages[$key];
        }

         /**
         * send sms
         *
         * @since 1.0.0
         * @return array
         */
        public function sms($sms_data)
        {
            $status = [];
            global $pvv_otp_options;

            $phone_number = $sms_data['to'];
            $options = $pvv_otp_options;

            if (!payamito_verify_moblie_number($phone_number)) {

                $status['success'] = false;
                $status['message'] = self::message(0);
                return $status;
            }
            if (!$this->resent_time_check($phone_number, $options['time_again'])) {

                $status['success'] = false;
                $status['message'] = self::message(8);
                return $status;
            }
            if ($options['pattern_active'] == true) {

                $pattern_id = trim($options['pattern_id']);

                if (empty($pattern_id)) {

                    $status['success'] = false;
                    $status['message'] = self::message(6);
                    return $status;
                }

                if (!is_array($options['pattern']) || count($options['pattern']) == 0) {

                    $status['success'] = false;
                    $status['message'] = self::message(7);
                    return $status;
                }
                $pattern = $this->set_otp_pattern($options['pattern'], $options['number_of_code']);

                $result = payamito_vv()->send->Send_pattern($phone_number, $pattern, $pattern_id);

                if ($result['result'] === true ) {
                    $phone_number = (string)$phone_number;
                    $OTP = (string)$this->OTP;
                    $status['success'] = true;
                    $status['code'] = $OTP;
                    $status['message'] = self::message(1);
                    Payamito_OTP::payamito_set_session($phone_number, $OTP);
                    return $status;
                } else {
                    $status['success'] = false;
                    $status['message'] = $result['message'];
                    return $status;
                }
            } else {

                $messages = trim($options['text']);

                if (empty($messages)) {

                    $status['success'] = false;
                    $status['message'] = self::message(9);
                    return $status;
                }
                $messages_value = $this->set_value($messages, $options['number_of_code_otp']);

                $result = payamito_vv()->send->Send($phone_number, $messages_value);

                if ($result === true) {
                    $phone_number = (string)$phone_number;
                    $OTP = (string)$this->OTP;
                    $status['success'] = true;
                    $status['code'] = $OTP;
                    $status['message'] = self::message(1);
                    Payamito_OTP::payamito_set_session($phone_number, $OTP);
                    return $status;
                } else {
                    $status['success'] = false;
                    $status['message'] = $result['message'];
                    return $status;
                }
            }
        }

         /**
         * set pattern tag
         *
         * @since 1.0.0
         * @return array
         */
        public function set_otp_pattern($pattern, $count = 4)
        {
            $send_pattern = [];
            foreach ($pattern as $item) {

                switch ($item['payamito_vv_opt_tags']) {
                    case 'OTP':
                    case '{OTP}':
                        $this->OTP = Payamito_OTP::payamito_generate_otp($count);
                        $send_pattern[$item['payamito_vv_otp_user_otp']] = $this->OTP;
                        break;
                    case 'site_name':
                    case '{site_name}':
                        $send_pattern[$item['payamito_vv_otp_user_otp']] = get_bloginfo('name');
                        break;
                }
            }
            return $send_pattern;
        }

         /**
         * set pattern tag value
         *
         * @since 1.0.0
         * @return array
         */
        public function set_value($text, $count = 4)
        {

            $tags = ['{site_name}', '{OTP}'];
            $value = [];

            foreach ($tags as  $tag) {

                switch ($tag) {
                    case "OTP":
                    case "{OTP}":
                        $this->OTP = Payamito_OTP::payamito_generate_otp($count);
                        array_push($value, $this->OTP);
                        break;
                    case "site_name":
                    case "{site_name}":
                        array_push($value, get_bloginfo('name'));
                        break;
                }
            }

            $message = str_replace($tags, $value, $text);

            return $message;
        }
      
        public function resent_time_check($phone_number, $period_send)
        {
            if (current_user_can("manage_options")) {
                return true;
            }
            if (!isset($_SESSION[$phone_number])) {
                return true;
            }
            $period_send = (int)$period_send;
            $time_send = (int)$_SESSION[$phone_number . "T"];
            $R = time() - $time_send;
            if ($R < $period_send) {
                return false;
            }
            return true;
        }
    }
}
