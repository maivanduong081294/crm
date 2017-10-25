<?php
if (class_exists('ImageOptimize')) {
    add_filter('wp_generate_attachment_metadata', 'optimize_upload_image', 9999);
    function optimize_upload_image($meta)
    {
        if(strtoupper(substr(PHP_OS, 0, 3))=='WIN') {
            $pngsrc = THEME_LIB.'/optipng';
            $jpgsrc = THEME_LIB.'/jpegoptim';
        }
        elseif(strtoupper(substr(PHP_OS, 0, 3))=='LIN') {
            $pngsrc = THEME_LIB.'/optipng';
            $jpgsrc = THEME_LIB.'/jpegoptim';
        }
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
        $check = false;
        foreach ($sizes as $key=>$size) {
            $url = $path . '/' . $size['file'];
            if (file_exists($url)) {
                $check = true;
                if($key=='full'){
                    $meta['original_size'] = filesize($url);
                }
                else {
                    $meta['original_size_' . $key] = filesize($url);
                }
                $filetype = (substr(strrchr($meta['file'], '.'), 1));
                if($filetype == 'png') {
                    $cmd = $pngsrc.' -o2 --strip all '.$url;
                    exec($cmd, $output, $return_var);
                    if($return_var !== 0){
                        $check = false;
                    }
                }
                elseif($filetype == 'jpg' || $filetype == 'jpeg'){
                    $cmd = $jpgsrc.' -o2 --max=90 --strip-all '.$url;
                    exec($cmd, $output, $return_var);
                    if($return_var !== 0){
                        $check = false;
                    }
                }
                clearstatcache();
                if ($key == 'full') {
                    $json['current'] = filesize($url);
                    $meta['current_size'] = filesize($url);
                } else {
                    $meta['current_size' . $key] = filesize($url);
                }
            }
        }
        if($check) {
            $meta['optimized'] = 1;
        }
        return $meta;
    }
}