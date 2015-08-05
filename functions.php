<?php

function incir_add_stylesheet_to_head()
{
    $path = get_stylesheet_uri();
    echo "<link rel='stylesheet' type='text/css' href='{$path}' />";
}

add_action('wp_head', 'incir_add_stylesheet_to_head');

function incir_add_javascript_to_head()
{
    $path = get_template_directory_uri();
    echo "<script src='{$path}/js/modernizr.js'></script>";
}

add_action('wp_head', 'incir_add_javascript_to_head');

function incir_meta_tags()
{
    if (!is_front_page() && (is_single() || is_page())) {

    }
}

add_action('wp_head', 'incir_meta_tags');

function incir_wp_title($title, $sep)
{
    global $paged, $page;

    if (is_feed())
        return $title;

    // Add the site name.
    $title .= get_bloginfo('name', 'display');

    // Add the site description for the home/front page.
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page()))
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if (($paged >= 2 || $page >= 2) && !is_404())
        $title = "$title $sep " . sprintf(__('Page %s'), max($paged, $page));

    return $title;
}

add_filter('wp_title', 'incir_wp_title', 10, 2);

function incir_add_javascript_to_footer()
{
    $path = get_template_directory_uri();
    echo "<script src='{$path}/js/jquery.min.js'></script>";
    echo "<script src='{$path}/js/foundation.min.js'></script>";
    echo "<script src='{$path}/js/functions.js'></script>";
    echo "<script src='{$path}/js/app.js'></script>";
}

add_action('wp_footer', 'incir_add_javascript_to_footer');

function incir_add_script_to_widget($hook)
{
    if ('widgets.php' != $hook) {
        return;
    }

    wp_enqueue_script('incir-marked-post', get_template_directory_uri() . '/js/marked_post.js');
    wp_enqueue_style('incir-marked-post', get_template_directory_uri() . '/css/marked_post.css');

}

add_action('admin_enqueue_scripts', 'incir_add_script_to_widget');

function incir_body_class()
{
    $classes = get_body_class();
    if (is_front_page()) {
        $template = basename(get_page_template());
        switch ($template) {
            case 'page-front-1.php':
                $classes[] = 'home-1';
                break;
            case 'page-front-2.php':
                $classes[] = 'home-2';
                break;
            case 'page-front-3.php':
                $classes[] = 'home-3';
                break;
            case 'page.php':
                $classes[] = 'home-1';
                break;
            case 'index.php':
                $classes[] = 'home-1';
                break;
        }
    }
    $classes = implode(' ', $classes);
    return $classes;
}

function incir_template_settings($wp_customize)
{
}

/**
 * return array
 */
function incir_social_share()
{
    $post['title'] = urlencode(get_the_title(get_the_ID()));
    $post['url'] = urlencode(get_permalink(get_the_ID()));
//    $post['desc'] = urlencode(get_the_excerpt(get_the_ID()));
    $post['thumb'] = urlencode(get_the_post_thumbnail(get_the_ID(), 'full'));
    $social = array('facebook', 'twitter', 'gplus', 'linkedin', 'pinterest');
    $layout = array(
        'facebook' => '<a href="http://www.facebook.com/share.php?u=' . $post['url'] . '&title=' . $post['title'] . '"><span class="fi-social-facebook"></span></a>',
        'twitter' => '<a href="http://twitter.com/intent/tweet?status=' . $post['title'] . '+' . $post['url'] . '"><span class="fi-social-twitter"></span></a>',
        'gplus' => '<a href="https://plus.google.com/share?url=' . $post['url'] . '"><span class="fi-social-google-plus"></span></a>',
        'linkedin' => '<a href="http://www.linkedin.com/shareArticle?mini=true&url=' . $post['url'] . '&title=' . $post['title'] . '&source=' . $post['url'] . '"><span class="fi-social-linkedin"></span></a>',
        'pinterest' => '<a href="http://pinterest.com/pin/create/bookmarklet/?url=' . $post['url'] . '&is_video=false&description=' . $post['title'] . '"><span class="fi-social-pinterest"></span></a>',
    );
    $list = array();
    foreach ($social as $row) {
        if (get_theme_mod('incir_social_' . $row) != false) {
            $list[] = $layout[$row];
        }
    }

    return $list;
}

add_action('customize_register', 'incir_template_settings');

/**
 * @param $post_id int
 * @return bool|string
 */
function incir_get_thumbnails_url($post_id)
{
    return wp_get_attachment_url(get_post_thumbnail_id($post_id));
}

function incir_nav_menu()
{
    $defaults = array(
        'theme_location' => '',
        'menu' => '',
        'container' => '',
        'container_class' => '',
        'container_id' => '',
        'menu_class' => 'menu',
        'menu_id' => '',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth' => 0,
        'walker' => new incir_nav_walker(),
    );

    wp_nav_menu($defaults);
}

function incir_nav_class($classes, $item)
{

    return $classes;
}

add_filter('nav_menu_css_class', 'incir_nav_class', 10, 2);

class incir_nav_walker extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class='submenu'>\n";
    }
}

function incir_home_query()
{
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'posts_per_page' => get_option('posts_per_page'),
        'post__in' => get_option('sticky_posts'),
        'paged' => $page,
    );
    query_posts($args);
}

function incir_post_format($post_id)
{
    $format = get_post_format($post_id);
    switch ($format) {
        case false:
            return 'post-normal';
            break;
        case 'video':
            return 'post-video';
            break;
        case 'image':
            return 'post-image';
            break;
        case 'audio':
            return 'post-music';
            break;
        case 'quote':
            return 'post-quote';
            break;
    }
}

function incir_add_class_to_embed($html, $url, $attr)
{
    $html = str_replace('width', 'class="large-12 small-12 medium-12" width', $html);
    return $html;

}

add_filter('embed_oembed_html', 'incir_add_class_to_embed', 10, 3);

function incir_pagination()
{
    return paginate_links(array('type' => 'list'));
}

function incir_excerpt_more($more)
{
    return '...';
}

add_filter('excerpt_more', 'incir_excerpt_more');

function incir_setup()
{

    load_theme_textdomain('incir', get_template_directory() . '/languages');
    $locale = get_locale();
    $locale_file = get_template_directory() . "/languages/$locale.php";

    if (is_readable($locale_file)) {
        require_once($locale_file);
    }

    // Add RSS feed links to <head> for posts and comments.
    add_theme_support('automatic-feed-links');
    add_theme_support('post-formats', array('image', 'quote', 'video', 'audio'));
    add_theme_support('post-thumbnails');
    register_nav_menus(array(
        'header_menu' => 'Header Menu',
        'footer_menu' => 'Footer Menu',
    ));
    register_sidebar(array(
        'name' => __('Sidebar', 'incir'),
        'id' => 'sidebar',
        'before_widget' => '<div id="%1$s" class="column widget-marked widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>',
    ));
    include(get_template_directory() . '/widgets/marked_post.php');
    include(get_template_directory() . '/widgets/last_comments.php');
    register_widget('marked_post');
    register_widget('last_comments');
}

add_action('after_setup_theme', 'incir_setup');

function incir_like_post_title($where, &$wp_query)
{
    global $wpdb;
    if ($post_title_like = $wp_query->get('post_title_like')) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($post_title_like)) . '%\'';
    }
    return $where;
}

add_filter('posts_where', 'incir_like_post_title', 10, 2);

function incir_the_excerpt($charlength)
{
    $excerpt = get_the_excerpt();
    $charlength++;

    if (mb_strlen($excerpt) > $charlength) {
        $subex = mb_substr($excerpt, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut = -(mb_strlen($exwords[count($exwords) - 1]));
        if ($excut < 0) {
            echo mb_substr($subex, 0, $excut);
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}

function incir_search_form($form)
{
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url('/') . '" >
                <div class="column large-12 small-12 medium-12 search-form">
                  <span class="icon"><i class="fi-magnifying-glass"></i></span>
                  <input type="search" id="search" value="' . get_search_query() . '" name="s" placeholder="' . __('Search') . '..." />
                </div>
            </form>';

    return $form;
}

add_filter('get_search_form', 'incir_search_form');

function incir_comment_list($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    $class = implode(' ', get_comment_class());
    $output = '<li ' . $class . ' id="comment-' . get_comment_ID() . '"><article>';
    $output .= '<div class="comment">';

    if ($comment->comment_approved == '0') {
        $output .= '<div data-alert class="comment-approved alert-box secondary">';
        $output .= __('Your comment is awaiting moderation.', 'incir');
        $output .= '</div>';
    }

    $output .= '<div class="comment-author">';
    $output .= '<div class="author-avatar">';
    if (strlen(esc_url(get_comment_author_url())) != 0) {
        $output .= sprintf('<a href="%s">', esc_url(get_comment_author_url()));
        $output .= get_avatar($comment, $size = '82');
        $output .= '</a>';
    } else {
        $output .= get_avatar($comment, $size = '82');
    }
    $output .= '</div>';
    $output .= '<div class="author-name">';
    $output .= get_comment_author_link();
    $output .= '</div>';
    $output .= '</div>';

    $output .= '<div class="comment-meta">';
    $output .= '<div class="reply">' . get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) . '</div>';
    $output .= '<div class="publish-date">';
    $output .= get_comment_date('F j, Y g:i a');
    $output .= '</div>';
    if (!is_null(get_edit_comment_link())) {
        $output .= '<div class="edit">';
        $output .= sprintf('<a href="%s">' . __('Edit') . '</a>', get_edit_comment_link($comment));
        $output .= '</div>';
    }
    $output .= '</div>';
    $output .= '<div class="comment-content"><p>';
    $output .= get_comment_text();
    $output .= '</p></div></div>';
    $output .= '</article></li>';

    echo $output;
}

add_filter('template_include', 'incir_page_template', 99);

function incir_404_form()
{
    $form = '<form role="erro-404-search" method="get" id="error-404-searchform" class="error-404-searchform" action="' . home_url('/') . '" >
                <div class="search-form collapse">
                  <input type="search" id="search" value="' . get_search_query() . '" name="s" placeholder="' . __('Search') . '..." />
                  <input type="submit" value="' . __("Submit") . '" class="button postfix" />
                </div>
            </form>';
    return $form;
}

function incir_page_template($template)
{
    if (is_search()) {
        $file = get_theme_mod('incir_search');
        if ($file == FALSE) {
            $file = 'search';
        }

        if (locate_template($file . '.php') != '') {
            return locate_template($file . '.php');
        }
    }

    if (is_category()) {
        $file = get_theme_mod('incir_cat');
        if ($file == FALSE) {
            $file = 'category';
        }

        if (locate_template($file . '.php') != '') {
            return locate_template($file . '.php');
        }
    }

    if (is_tag()) {
        $file = get_theme_mod('incir_tag');
        if ($file == FALSE) {
            $file = 'tag';
        }

        if (locate_template($file . '.php') != '') {
            return locate_template($file . '.php');
        }
    }

    if (is_404()) {
        $file = get_theme_mod('incir_404');
        if ($file == FALSE) {
            $file = '404';
        }

        if (locate_template($file . '.php') != '') {
            return locate_template($file . '.php');
        }
    }

    if (is_single()) {
        $file = get_theme_mod('incir_single');
        if ($file == FALSE) {
            $file = 'single';
        }

        if (locate_template($file . '.php') != '') {
            return locate_template($file . '.php');
        }
    }

    if (is_archive()) {
        $file = get_theme_mod('incir_archive');
        if ($file == FALSE) {
            $file = 'archive';
        }

        if (locate_template($file . '.php') != '') {
            return locate_template($file . '.php');
        }
    }

    if (is_front_page()) {
        if (basename($template) == 'page.php') {
            return locate_template('page-front-1.php');
        }

        if (basename($template) == 'index.php') {
            return locate_template('page-front-1.php');
        }
    }

    return $template;
}

class incir_Customize
{

    public static function layout($wp_customize)
    {
        /**
         * Search Settings
         */
        $wp_customize->add_section('incir_search', array(
            'title' => __('Search Page', 'incir'),
        ));

        $wp_customize->add_setting('incir_search', array(
                'default' => 'Sidebar Layout'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_search',
                array(
                    'label' => __('Template of the searching page?', 'incir'),
                    'section' => 'incir_search',
                    'settings' => 'incir_search',
                    'type' => 'select',
                    'choices' => array(
                        'search' => __('Sidebar View', 'incir'),
                        'search-full' => __('Full Width View', 'incir')
                    )
                )
            )
        );

        /**
         * Category settings
         */
        $wp_customize->add_section('incir_cat', array(
            'title' => __('Category Page', 'incir'),
        ));

        $wp_customize->add_setting('incir_cat', array(
                'default' => 'Category Layout'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_cat',
                array(
                    'label' => __('Template of the category page', 'incir'),
                    'section' => 'incir_cat',
                    'settings' => 'incir_cat',
                    'type' => 'select',
                    'choices' => array(
                        'category' => __('Sidebar View', 'incir'),
                        'category-full' => __('Full Width', 'incir')
                    )
                )
            )
        );

        /**
         * Tag settings
         */
        $wp_customize->add_section('incir_tag', array(
            'title' => __('Tag Page', 'incir'),
        ));

        $wp_customize->add_setting('incir_tag', array(
                'default' => 'Tag Layout'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_tag',
                array(
                    'label' => __('Template of the tag page', 'incir'),
                    'section' => 'incir_tag',
                    'settings' => 'incir_tag',
                    'type' => 'select',
                    'choices' => array(
                        'tag' => __('Sidebar View', 'incir'),
                        'tag-full' => __('Full Width', 'incir')
                    )
                )
            )
        );

        /**
         * 404 settings
         */
        $wp_customize->add_section('incir_404', array(
            'title' => __('404 Page', 'incir'),
        ));

        $wp_customize->add_setting('incir_404', array(
                'default' => '404 Layout'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_404',
                array(
                    'label' => __('Template of the 404 page', 'incir'),
                    'section' => 'incir_404',
                    'settings' => 'incir_404',
                    'type' => 'select',
                    'choices' => array(
                        '404' => __('Sidebar View', 'incir'),
                        '404-full' => __('Full Width', 'incir')
                    )
                )
            )
        );

        /**
         * Archive settings
         */
        $wp_customize->add_section('incir_archive', array(
            'title' => __('Archive Page', 'incir'),
        ));

        $wp_customize->add_setting('incir_archive', array(
                'default' => 'Archive Layout'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_archive',
                array(
                    'label' => __('Template of the archive page', 'incir'),
                    'section' => 'incir_archive',
                    'settings' => 'incir_archive',
                    'type' => 'select',
                    'choices' => array(
                        'archive' => __('Sidebar View', 'incir'),
                        'archive-full' => __('Full Width', 'incir')
                    )
                )
            )
        );

        /**
         * Single settings
         */
        $wp_customize->add_section('incir_single', array(
            'title' => __('Single Page', 'incir'),
        ));

        $wp_customize->add_setting('incir_single', array(
                'default' => 'Single Layout'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_single',
                array(
                    'label' => __('Template of the single page', 'incir'),
                    'section' => 'incir_single',
                    'settings' => 'incir_single',
                    'type' => 'select',
                    'choices' => array(
                        'single' => __('Sidebar View', 'incir'),
                        'single-full' => __('Full Width', 'incir')
                    )
                )
            )
        );
    }

    public static function footer($wp_customize)
    {
        $wp_customize->add_section('incir_footer', array(
            'title' => __('Footer'),
        ));

        $wp_customize->add_setting('incir_footer_left', array(
                'default' => '© Copyright ' . date('Y') . '. Powered by <a hreF="https://wordpress.org">Wordpress</a>',
            )
        );

        $wp_customize->add_setting('incir_footer_right', array(
                'default' => '<cite>incir</cite> Theme by <a hreF="http://incirtheme.com">incirTheme</a>',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_footer_left',
                array(
                    'label' => __('Footer left position', 'incir'),
                    'section' => 'incir_footer',
                    'settings' => 'incir_footer_left',
                    'type' => 'textarea',
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_footer_right',
                array(
                    'label' => __('Footer right position'),
                    'section' => 'incir_footer',
                    'settings' => 'incir_footer_right',
                    'type' => 'textarea',
                )
            )
        );
    }

    public static function social_share($wp_customize)
    {

        $wp_customize->add_section('incir_social_share', array(
            'title' => __('Social Share', 'incir'),
        ));

        $wp_customize->add_setting('incir_social_facebook', array(
            'default' => false,
        ));
        $wp_customize->add_setting('incir_social_twitter', array(
            'default' => false,
        ));
        $wp_customize->add_setting('incir_social_gplus', array(
            'default' => false,
        ));
        $wp_customize->add_setting('incir_social_linkedin', array(
            'default' => false,
        ));
        $wp_customize->add_setting('incir_social_pinterest', array(
            'default' => false,
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_social_facebook',
                array(
                    'label' => __('Facebook'),
                    'section' => 'incir_social_share',
                    'settings' => 'incir_social_facebook',
                    'type' => 'checkbox',
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_social_twitter',
                array(
                    'label' => __('Twitter'),
                    'section' => 'incir_social_share',
                    'settings' => 'incir_social_twitter',
                    'type' => 'checkbox',
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_social_gplus',
                array(
                    'label' => __('Google+'),
                    'section' => 'incir_social_share',
                    'settings' => 'incir_social_gplus',
                    'type' => 'checkbox',
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_social_linkedin',
                array(
                    'label' => __('Linkedin'),
                    'section' => 'incir_social_share',
                    'settings' => 'incir_social_linkedin',
                    'type' => 'checkbox',
                )
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'incir_social_pinterest',
                array(
                    'label' => __('Pinterest'),
                    'section' => 'incir_social_share',
                    'settings' => 'incir_social_pinterest',
                    'type' => 'checkbox',
                )
            )
        );
    }

}

add_action('customize_register', array('incir_Customize', 'layout'));
add_action('customize_register', array('incir_Customize', 'footer'));
add_action('customize_register', array('incir_Customize', 'social_share'));

