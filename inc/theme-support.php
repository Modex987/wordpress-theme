<?php

add_action('after_setup_theme', function(){

    // post formats
    $post_formats = get_option('post_formats');
    if(!empty($post_formats)){
        add_theme_support('post-formats', array_keys($post_formats));
    }

    // custom header
    $custom_header = get_option('custom_header');
    if(!empty($custom_header)){
        add_theme_support('custom-header', array(
            'default-image'          => '',
            'width'                  => 0,
            'height'                 => 0,
            'flex-height'            => false,
            'flex-width'             => false,
            'uploads'                => true,
            'random-default'         => false,
            'header-text'            => true,
            'default-text-color'     => '',
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
        ));
    }

    // custom header
    $custom_background = get_option('custom_background');
    if(!empty($custom_background)){
        add_theme_support('custom-background', array(
            'default-color'          => '',
            'default-image'          => '',
            'default-repeat'         => 'repeat',
            'default-position-x'     => 'left',
            'default-position-y'     => 'top',
            'default-size'           => 'auto',
            'default-attachment'     => 'scroll',
            'wp-head-callback'       => '_custom_background_cb',
            'admin-head-callback'    => '',
            'admin-preview-callback' => ''
        ));
    }


    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support('post-thumbnails');

    add_theme_support('custom-logo', array(
        'height'                => 100,
        'width'                 => 100,
        'flex-height'           => true,
        'flex-width'            => true,
        'header-text'           => array( 'site-title', 'site-description' ),
        'unlink-homepage-logo'  => true, 
    ));

    register_nav_menus(array(
        'primary' => esc_html__( 'Primary menu', 'Modexy' ),
        'secondary'  => __( 'Secondary menu', 'Modexy' ),
        'footer'  => __( 'Footer menu', 'Modexy' ),
    ));

});



/**
 * Register our sidebars and widgetized areas.
 *
 */
add_action('widgets_init', function() {

    $sidebars = get_option('sidebars');

    if(empty($sidebars)){
        return;
    }

    foreach ($sidebars as $key => $name) {
        if(empty($name)){
            continue;
        }

        register_sidebar(array(
            'name'          => $name,
            'id'            => 'sidebar-' . ($key + 1),
            'before_widget' => '<div class="widget-item">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
} );


add_filter('excerpt_length', function ($length) {
    global $post;
    if ($post->post_type == 'message'){
        return 13;
    }
    return get_option('excerpt_lenght');
}, 100);


add_filter('the_content', function($content){

    global $twitter, $facebook, $google_plus, $whatsapp;

    // add share buttons

    if(!is_single()){
        return $content;
    }

    $message = 'Hey Read This: ' . get_the_title();
    $permal_link = get_the_permalink();
    $twitter_handler = get_option('twitter') ? esc_attr(get_option('twitter')) : '';
    
    $twitter_share_link = 'https://twitter.com/intent/tweet?text=' . $message . '&amp;url=' . $permal_link . '&amp;via=' . $twitter_handler;
    $facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $permal_link;
    $whatsapp_share_link = 'https://api.whatsapp.com/send?text=' . $permal_link;
    
    $content .= '
        <div class="modexy-share">
            <ul>
                <li><a class="share-item" href="' . esc_url($twitter_share_link) . '" target="_blank" rel="nofollow">' . $twitter . '</a></li>
                <li><a class="share-item" href="' . esc_url($facebook_share_link) . '" target="_blank" rel="nofollow">' . $facebook . '</a></li>
                <li><a class="share-item" href="' . esc_url($whatsapp_share_link) . '" target="_blank" rel="nofollow">' . $whatsapp . '</a></li>
            </ul>
        </div>
    ';

    return $content;
});