<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
function crb_attach_theme_options()
{
    Container::make('theme_options', __('Опции плагина сбора адресов', 'crb'))
        ->set_icon('dashicons-external')
        ->set_page_menu_title('Сбор адресов')
        ->set_page_parent('options-general.php')
        ->add_fields(array(
            Field::make('html', 'crb_information_text')
                ->set_html("<div><b>[address-module]</b> - шорткод для сбора адресов</div>"),
            Field::make('text', 'crb_email', 'Email')
                ->set_help_text('Email для отправки заказа'),
            Field::make('text', 'crb_apikey', 'Ключ API Яндекс.Карт')
                ->set_help_text('Ключ API для доступа к Яндекс.Картам')
        ));

}
