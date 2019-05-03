<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options1');
function crb_attach_theme_options1()
{
    Container::make('post_meta', __('Параметры щита', 'crb'))
        ->where('post_type', '=', 'billboard_type')
        ->add_fields(array(
                Field::make('text', 'billboard_name', 'Город')
                    ->set_attribute('type', 'text')
                    ->set_required(true)
                    ->set_width(33),
                Field::make('text', 'billboard_code', 'Код')
                    ->set_width(33),
                Field::make('text', 'billboard_size', 'Размер щита')
                    ->set_attribute('type', 'text')
                    ->set_width(33),

                Field::make('text', 'billboard_lat', 'Координаты: Широта')
                    ->set_attribute('type', 'text')
                    ->set_required(true)
                    ->set_width(50),
                Field::make('text', 'billboard_lng', 'Координаты: Долгота')
                    ->set_attribute('type', 'text')
                    ->set_required(true)
                    ->set_width(50)

            )
        );

    $billboard_labels = array(
        'plural_name' => 'Стороны',
        'singular_name' => 'Сторона',
    );

    Container::make('post_meta', __('Стороны щита', 'crb'))
        ->where('post_type', '=', 'billboard_type')
        ->add_fields(array(
            Field::make('complex', 'billboard_slides', 'Сторона')
                ->setup_labels($billboard_labels)
                ->set_layout('tabbed-horizontal')
                ->set_min(1)
                ->add_fields(array(
                    Field::make('checkbox', 'billboard_active', 'Активна')
                        ->set_value(true),
                    Field::make('image', 'billboard_image', 'Изображение')
                        ->set_conditional_logic(array(
                            array(
                                'field' => 'billboard_active',
                                'value' => true,
                            )
                        )),
                    Field::make('checkbox', 'billboard_lighting', 'Освещение')
                        ->set_conditional_logic(array(
                            array(
                                'field' => 'billboard_active',
                                'value' => true,
                            )
                        ))
                ))
                ->set_default_value(array(
                    array(
                        'billboard_active' => true,
                    )
                )),
        ));
}

function wpb_change_title_text($title)
{
    $screen = get_current_screen();

    if ('billboard_type' == $screen->post_type) {
        $title = 'Введите название улицы и описание щита';
    }

    return $title;
}

add_filter('enter_title_here', 'wpb_change_title_text');
