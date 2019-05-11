<?php

/*
Plugin Name: Address Module
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Плагин сбора адресов
Version: 1.0
Author: Grebenev Oleg
Author URI: http://portfolio.infoblog72.ru/
License: GPL2
*/

defined('ABSPATH') or die('Nope, not accessing this');

require plugin_dir_path(__FILE__) . 'inc/admin-panel.php';
require plugin_dir_path(__FILE__) . 'inc/post-type.php';
require plugin_dir_path(__FILE__) . 'inc/post-fields.php';
require plugin_dir_path(__FILE__) . 'inc/ajax-wp.php';
require plugin_dir_path(__FILE__) . 'shortcode/address-shortcode.php';

add_image_size('billboard-mini', 300, 200, true);
add_image_size('billboard-full', 900, 500, true);

$shortcode = new Address_Shortcode();
$shortcode->init();
