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
    remove_action('embed_head','wp_print_styles',20);
    remove_action('wp_head', 'wp_print_styles', 8);
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_footer', 'wp_print_footer_scripts', 20);
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

add_action( 'wp_head', 'thenatives_print_styles_noscript', 8);
function thenatives_print_styles_noscript(){
    if(!is_admin()) {
        $handles = wp_styles()->queue;
        $expects = array();
        echo '<style>';
        $style = WP_Styles();
        foreach ($handles as $handle) {
            $file = $style->registered[$handle];
            $file = str_replace(get_bloginfo('url'), '', $file->src);
            $folder = str_replace('/' . substr(strrchr($file, '/'), 1), '', $file);
            $file = getcwd() . $file;
            if(file_exists($file)) {
                $content = stream_get_contents(fopen($file, "rb"));
                //$content = str_replace('','',$content);
                //echo $content;
                $arr = explode('/', $folder);
                $link = get_bloginfo('url');
                foreach ($arr as $i => $fold) {
                    $count = count($arr) - $i;
                    $replace1 = './';
                    $replace2 = '../';
                    $temp = 0;
                    while ($count > 1) {
                        if ($count > 2) {
                            $replace2 = $replace1 . '../';
                            $check1 = true;
                        }
                        $replace1 = $replace1 . '../';
                        $count--;
                        $temp++;
                    }
                    $link = $arr[$i] ? ($link . $arr[$i] . '/') : ($link . '/');
                    $content = str_replace($replace2, $link, $content);
                    $content = str_replace($replace1, $link, $content);
                }
                echo $content;
            }
            else {
                $expects[] = $handle;
            }
        }
        echo '</style>';
        foreach ($expects as $handle) {
            $style->do_item($handle);
        }
    }
}

add_action('wp_footer','thenatives_print_script' );
function thenatives_print_script() {
    print_footer_scripts();
}