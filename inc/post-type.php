<?php
// Register Custom Post Type
function billboard_post_type()
{

    $labels = array(
        'name' => 'Щиты',
        'singular_name' => 'Щит',
        'menu_name' => 'Щиты',
        'name_admin_bar' => 'Щиты',
        'archives' => 'Архив элементов',
        'attributes' => 'Аттрибуты элемента',
        'parent_item_colon' => 'Родительский элемент',
        'all_items' => 'Все элементы',
        'add_new_item' => 'Добавить новый элемент',
        'add_new' => 'Добавить новый щит',
        'new_item' => 'Новый элемент',
        'edit_item' => 'Редактировать элемент',
        'update_item' => 'Обновить элемент',
        'view_item' => 'Просмотреть элемент',
        'view_items' => 'Просмотреть элементы',
        'search_items' => 'Поиск элемента',
        'not_found' => 'Не найдено',
        'not_found_in_trash' => 'Ничего не найдено в корзине',
        'featured_image' => 'Рекомендуемое изображение',
        'set_featured_image' => 'Установить рекомендуемое изображение',
        'remove_featured_image' => 'Удалить рекомендуемое изображение',
        'use_featured_image' => 'Использовать как изображение',
        'insert_into_item' => 'Вставить в элемент',
        'uploaded_to_this_item' => 'Обновить текущий элемент',
        'items_list' => 'Список элементов',
        'items_list_navigation' => 'Навигация по списку элементов',
        'filter_items_list' => 'Фильтрация списка элементов',
    );
    $args = array(
        'label' => 'Щит',
        'description' => 'Рекламный щит',
        'labels' => $labels,
        'supports' => array('title'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 10,
        'menu_icon' => 'dashicons-format-gallery',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('billboard_type', $args);

}

add_action('init', 'billboard_post_type', 0);
