<?php
show_admin_bar( false );
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_generator');

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

if (class_exists('ImageOptimize')) {
    add_filter('wp_generate_attachment_metadata', 'optimize_upload_image', 9999);
    function optimize_upload_image($meta){
        $dir = wp_upload_dir();
        $path = $dir['basedir'];
        $folder = '';
        $arr = explode('/', $meta['file']);
        $count = 1;
        foreach ($arr as $item) {
            if ($count >= count($arr)) {
                break;
            }
            $folder .= '/' . $item;
            $count++;
        }
        $path .= $folder;
        $dir = $dir['baseurl'] . $folder;
        $sizes = $meta['sizes'];
        $sizes['full'] = array(
            'file' => substr(strrchr($meta['file'], '/'), 1),
            'width' => $meta['width'],
            'height' => $meta['height'],
        );
        foreach ($sizes as $size) {
            $url = $path . '/' . $size['file'];
            if (file_exists($url)) {
                $width = $size['width'];
                $height = $size['height'];
                $resizeObj = new ImageOptimize($url);
                $resizeObj->resizeImage($width, $height);
                $resizeObj->saveImage($url, 80);
            }
        }
        return $meta;
    }
}