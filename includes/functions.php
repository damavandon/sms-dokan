<?php
// ═══════════════════════════ :هشدار: ═══════════════════════════

// ‫ تمامی حقوق مادی و معنوی این افزونه متعلق به سایت پیامیتو به آدرس payamito.com می باشد
// ‫ و هرگونه تغییر در سورس یا استفاده برای درگاهی غیراز پیامیتو ،
// ‫ قانوناً و شرعاً غیرمجاز و دارای پیگرد قانونی می باشد.

// © 2022 Payamito.com, Kian Dev Co. All rights reserved.

// ════════════════════════════════════════════════════════════════

?><?php

// don't call the file directly
if (!defined('ABSPATH')) {
    die();
}

if (!function_exists('payamito_vv_load_core')) {

    function payamito_vv_load_core()
    {
        $core = get_option("payamito_core_version");
        if ($core === false) {
            return PAYAMITO_CORE_DIR_VV;
        }
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $core = unserialize($core);
        if (
            file_exists($core['core_path']) && is_plugin_active($core['absolute_path'])
        ) {
            return $core['core_path'];
        } else {
            return PAYAMITO_CORE_DIR_VV;
        }
        return PAYAMITO_CORE_DIR_VV;
    }
}
