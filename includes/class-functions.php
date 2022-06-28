<?php
// ═══════════════════════════ :هشدار: ═══════════════════════════

// ‫ تمامی حقوق مادی و معنوی این افزونه متعلق به سایت پیامیتو به آدرس payamito.com می باشد
// ‫ و هرگونه تغییر در سورس یا استفاده برای درگاهی غیراز پیامیتو ،
// ‫ قانوناً و شرعاً غیرمجاز و دارای پیگرد قانونی می باشد.

// © 2022 Payamito.com, Kian Dev Co. All rights reserved.

// ════════════════════════════════════════════════════════════════


namespace Payamito\VV\Funtions;

/**
 * Plugin public functions
 *
 * @package"payamito_vv
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

if (!class_exists("Functions")) {

    class Functions
    {

        /**
         * Getting user meta key from database
         *
         * @access public
         * @since 1.0.0
         * @return array
         * @static
         */
        public static function get_meta_keys()
        {
            global $wpdb;

            $final = array();

            $results = $wpdb->get_results("SELECT DISTINCT `meta_key` FROM $wpdb->usermeta ", ARRAY_A);
            if (is_array($results)) {
                foreach ($results as  $result) {
                    $final[$result['meta_key']] = $result['meta_key'];
                }
            }
            return  $final;
        }
        /**
         * What type of request is this?
         *
         * @param  string $type admin, ajax, cron or frontend.
         * @return bool
         */
        public static function is_request($type)
        {
            switch ($type) {
                case 'admin':
                    return is_admin();
                case 'ajax':
                    return defined('DOING_AJAX');
                case 'cron':
                    return defined('DOING_CRON');
                case 'frontend':
                    return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
            }
        }
    }
}
