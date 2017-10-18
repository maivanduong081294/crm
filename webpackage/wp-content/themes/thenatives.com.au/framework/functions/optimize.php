<?php
if (class_exists('ImageOptimize')) {
    add_filter('wp_generate_attachment_metadata', 'optimize_upload_image', 9999);
    function optimize_upload_image($meta)
    {
        $path = wp_upload_dir();
        $path = $path['basedir'];
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
        $sizes = $meta['sizes'];
        $sizes['full'] = array(
            'file' => substr(strrchr($meta['file'], '/'), 1),
            'width' => $meta['width'],
            'height' => $meta['height'],
        );
        foreach ($sizes as $key=>$size) {
            $url = $path . '/' . $size['file'];
            if (file_exists($url)) {
                if($key=='full'){
                    $meta['original_size'] = filesize($url);
                }
                else {
                    $meta['original_size_' . $key] = filesize($url);
                }
                $width = $size['width'];
                $height = $size['height'];
                $resizeObj = new ImageOptimize($url);
                $resizeObj->resizeImage($width, $height);
                $resizeObj->saveImage($url, 80);
                clearstatcache();
                if ($key == 'full') {
                    $json['current'] = filesize($url);
                    $meta['current_size'] = filesize($url);
                } else {
                    $meta['current_size' . $key] = filesize($url);
                }
            }
        }
        $meta['optimize'] = 1;
        return $meta;
    }
}