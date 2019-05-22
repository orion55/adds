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

    function contact_send($info, &$errorArr)
    {
        $title = 'Новый заказ - ' . $info['contactName'];

        $url = get_site_url();
        $url = str_replace("http://", '', $url);
        $url = str_replace("https://", '', $url);

        $headers[] = 'From: ' . $url . ' <mail@' . $url . '>';
        $headers[] = 'Content-type: text/html; charset=utf-8';

        $email = carbon_get_theme_option('crb_email');

        if (!empty($email)) {
            $message = '<html><body>';
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10" border="1">';
            $message .= "<tr style='background: #eee;'><td><strong>Имя:</strong></td><td>" . $info['contactName'] . "</td></tr>";
            $message .= "<tr><td><strong>Телефон:</strong> </td><td>" . $info['contactPhone'] . "</td></tr>";
            $message .= "<tr style='background: #eee;'><td><strong>Email:</strong></td><td>" . $info['contactEmail'] . "</td></tr>";

            $i = 1;
            foreach ($info['billboards'] as $board) {
                $message .= "<tr style='background: #bebebe;'><td  colspan='2'><strong>Щит №" . $i . "</strong></td></tr>";
                $message .= "<tr><td><strong>Город:</strong> </td><td>" . $board['city'] . "</td></tr>";
                $message .= "<tr style='background: #eee;'><td><strong>Улица:</strong></td><td>" . $board['street'] . "</td></tr>";
                $message .= "<tr><td><strong>Стороны:</strong> </td><td>" . $board['blocks'] . "</td></tr>";
                $message .= "<tr style='background: #eee;'><td><strong>Код:</strong></td><td>" . $board['code'] . "</td></tr>";
                $message .= "<tr><td><strong>Размер:</strong> </td><td>" . $board['size'] . "</td></tr>";
                $message .= "<tr style='background: #eee;'><td><strong>Широта:</strong></td><td>" . $board['coordLat'] . "</td></tr>";
                $message .= "<tr><td><strong>Долгота:</strong> </td><td>" . $board['coordLng'] . "</td></tr>";
                $i++;
            }

            $message .= "</table>";
            $message .= "</body></html>";

            if (!wp_mail($email, $title, $message, $headers)) {
                array_push($errorArr, 'Ошибка при отправки письма!');
            }
        } else {
            array_push($errorArr, 'Ошибка при отправки письма! Email отправки не указан!');
        }
    }

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
    $countBillboards = (isset($_POST['countBillboards']) ? intval($_POST['countBillboards']) : 0);

    $billboards = [];
    for ($i = 0; $i < $countBillboards; $i++) {
        $board = [];
        $board['id'] = (isset($_POST['id' . $i]) ? intval($_POST['id' . $i]) : 0);
        $board['blocks'] = (isset($_POST['blocks' . $i]) ? sanitize_text_field($_POST['blocks' . $i]) : '');
        $board['city'] = (isset($_POST['city' . $i]) ? sanitize_text_field($_POST['city' . $i]) : '');
        $board['code'] = (isset($_POST['code' . $i]) ? sanitize_text_field($_POST['code' . $i]) : '');
        $board['size'] = (isset($_POST['size' . $i]) ? sanitize_text_field($_POST['size' . $i]) : '');
        $board['street'] = (isset($_POST['street' . $i]) ? sanitize_text_field($_POST['street' . $i]) : '');
        $board['coordLat'] = (isset($_POST['coordLat' . $i]) ? floatval($_POST['coordLat' . $i]) : 0);
        $board['coordLng'] = (isset($_POST['coordLng' . $i]) ? floatval($_POST['coordLng' . $i]) : 0);

        array_push($billboards, $board);
    }
    $info['billboards'] = $billboards;

    $errorArr = [];

    contact_send($info, $errorArr);

    if (count($errorArr) > 0) {
        wp_send_json_error($errorArr);
    } else {
        wp_send_json_success('Заявка успешно зарегистрирована!');
//        wp_send_json_success($info);
//        wp_send_json_success($_POST);
    }
    wp_die();
}
