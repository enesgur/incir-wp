<?php

require('../../../../wp-blog-header.php');

if (!current_user_can('edit_themes') || !isset($_POST['title'])) {
    wp_send_json_error();
}

$title = (string)$_POST['title'];
$args = array(
    'post_title_like' => $title,
    'posts_per_page' => 5,
);

if (isset($_POST['not_in']) && !empty($_POST['not_in'])) {
    $not_in = (string)$_POST['not_in'];
    $not_in = explode(',', $not_in);

    if (!empty($not_in)) {
        $args['post__not_in'] = $not_in;
    }
}

$result = new WP_Query($args);

while ($result->have_posts()) {
    $result->the_post();
    $json[get_the_ID()] = array(
        'id' => get_the_ID(),
        'post_format' => incir_post_format(get_the_ID()),
        'post_title' => get_the_title(),
    );
}

if (!isset($json)) {
    wp_send_json_error();
}

wp_send_json_success($json);