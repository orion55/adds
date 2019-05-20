<?php
add_action('wp_ajax_nopriv_get_billboards', 'get_billboards');
add_action('wp_ajax_get_billboards', 'get_billboards');

function get_billboards()
{
    function is_coordinates($val)
    {
        $i = $val;
        if (!is_float($i)) {
            $i = 0;
        }
        return $i;
    }

    $result = [];
    $args = array(
        'posts_per_page' => '-1',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'ASC',
        'post_type' => 'billboard_type'
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();

            $meta = new stdClass;
            $chars = range('A', 'Z');
            foreach ((array)get_post_meta($id) as $k => $v) $meta->$k = $v[0];

            $sides = [];
            $slides = carbon_get_the_post_meta('billboard_slides');
            if (count($slides) > 0) {
                $i = 0;
                foreach ($slides as $slide) {
                    if ($slide['billboard_active']) {

                        $id_img = $slide['billboard_image'];
                        $img_full_link = '';
                        $img_small_link = '';
                        if (!empty($id_img)) {
                            $img_full_link = wp_get_attachment_image_url($id_img, 'billboard-full');
                            $img_small_link = wp_get_attachment_image_url($id_img, 'billboard-mini');
                        }

                        $section = [
                            'name' => $chars[$i],
                            'status' => false,
                            'img_full' => $img_full_link,
                            'img_small' => $img_small_link,
                            'lighting' => $slide['billboard_lighting']
                        ];
                        $i++;
                        array_push($sides, $section);
                    }
                }
            }

            $row = [
                'id' => $id,
                'check' => false,
                'city' => $meta->_billboard_name,
                'street' => esc_html(get_the_title()),
                'coordinates' => ['lat' => is_coordinates((float)$meta->_billboard_lat), 'lng' => is_coordinates((float)$meta->_billboard_lng)],
                'code' => $meta->_billboard_code,
                'size' => $meta->_billboard_size,
                'sides' => $sides
            ];

            array_push($result, $row);
        }
    }

    if (empty($result)) {
        echo wp_send_json_error('The list of billboards is empty!');
    } else {
        echo wp_send_json_success($result);
    }

    wp_die();
}

add_action('wp_ajax_nopriv_billboards_add', 'billboards_add');
add_action('wp_ajax_billboards_add', 'billboards_add');

function billboards_add()
{
    if (empty($_POST['nonce'])) {
        wp_die('Nonce bad');
    }

    $check_ajax_referer = check_ajax_referer('myajax-nonce123', 'nonce', false);

    if (!$check_ajax_referer) {
        wp_send_json_error('Эх! Сработала защита');
    }

    $info = [];
    $info['contactName'] = (isset($_POST['contactName']) ? sanitize_text_field($_POST['contactName']) : '');
    $info['contactPhone'] = (isset($_POST['contactPhone']) ? sanitize_text_field($_POST['contactPhone']) : '');
    $info['contactEmail'] = (isset($_POST['contactEmail']) ? sanitize_text_field($_POST['contactEmail']) : '');

    $errorArr = [];

//    contact_send($info);

    if (count($errorArr) > 0) {
        wp_send_json_error($errorArr);
    } else {
//        wp_send_json_success('Заявка успешно зарегистрирована!');
//        wp_send_json_success($info);
        wp_send_json_success($_POST);
    }
    wp_die();
}
