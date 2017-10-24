<?php
if(!is_admin()) {
    show_admin_bar( false );
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'print_emoji_detection_script',7);
    remove_action('wp_print_styles','print_emoji_styles');
}

if(!function_exists ('thenatives_array_atts')){
    function thenatives_array_atts($pairs, $atts) {
        $atts = (array)$atts;
        $out = array();
        foreach($pairs as $name => $default) {
            if ( array_key_exists($name, $atts) ){
                if( strlen(trim($atts[$name])) > 0 ){
                    $out[$name] = $atts[$name];
                }else{
                    $out[$name] = $default;
                }
            }
            else{
                $out[$name] = $default;
            }
        }
        return $out;
    }
}

function thenatives_upload_media ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'thenatives_upload_media');