<?php

class Address_Shortcode
{
    static $add_script;

    static function init()
    {
        add_shortcode('address-module', array(__CLASS__, 'address_func'));
        add_action('init', array(__CLASS__, 'register_script'));
        add_action('wp_footer', array(__CLASS__, 'js_variables'));
        add_action('wp_footer', array(__CLASS__, 'print_script'));
    }

    static function address_func($atts)
    {
        self::$add_script = true;
        $html = "<div id=\"address-module\"><demo></demo></div>";
        return $html;
    }

    static function register_script()
    {
        $url = plugin_dir_url(__FILE__);
        wp_register_style('adds-module', plugin_dir_url(__FILE__) . 'dist/adds.css', null, time(), 'all');
        wp_register_script('vue', plugin_dir_url(__FILE__) . 'js/vue.min.js', array(), null, true);
        wp_register_script('adds-module-lib', plugin_dir_url(__FILE__) . 'dist/adds.umd.min.js', array('vue'), time(), true);
        wp_register_script('main', plugin_dir_url(__FILE__) . 'js/main.js', array('adds-module-lib'), time(), true);
    }

    static function print_script()
    {
        if (!self::$add_script) {
            return;
        }
        wp_enqueue_style('adds-module');
        wp_print_scripts('vue');
        wp_print_scripts('adds-module-lib');
        wp_print_scripts('main');
    }

    static function js_variables()
    {
        if (!self::$add_script) {
            return;
        }

        $variables = array(
            'plugin_dir_url' => plugin_dir_url(__FILE__),
            'url_ajax' => admin_url('admin-ajax.php'),
//            'api_key' => carbon_get_theme_option('crb_apikey'),
            'nonce' => wp_create_nonce('myajax-nonce123')
        );
        echo('<script type="text/javascript">window.wp_data=' . json_encode($variables) . ';</script>');
    }
}
