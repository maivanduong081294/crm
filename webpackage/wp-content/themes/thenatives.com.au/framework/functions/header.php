<?php
if (!function_exists('thenatives_logo')) {
	function thenatives_logo() {
		global $thenatives;
		$tag = is_front_page()?'h1':'h2';
		?>
		<div id="logo">
			<<?php echo $tag; ?>>
				<?php if($thenatives['thenatives_logo']): ?>
					<a href="<?php echo get_site_url(); ?>">
                        <?php
                            $logo =  $thenatives['thenatives_logo'];
                            echo '<img class="Logo" src="'.$thenatives['thenatives_logo'].'" alt="'.$thenatives['thenatives_title'].'"/>';
                        ?>
					</a>
				<?php else: ?>
                    <a href="<?php echo get_site_url(); ?>">
					    <?php echo $thenatives['thenatives_title']; ?>
                    </a>
				<?php endif; ?>
			</<?php echo $tag; ?>>
		</div>
		<?php 
	}
	add_action('thenatives_logo','thenatives_logo');
}

if (!function_exists('thenatives_favicon')) {
	function thenatives_favicon() {
		global $thenatives;
		if($thenatives['thenatives_favicon']) {
            echo '<link rel="shortcut icon" href="' . $thenatives['thenatives_favicon'] . '" type="image/x-icon" />' . "\n";
        }
	}
	add_action( 'wp_enqueue_scripts', 'thenatives_favicon', 10);
    add_action('admin_head', 'thenatives_favicon');
    add_action('login_head', 'thenatives_favicon');
}

if (!function_exists('thenatives_facebook_include')) {
	function thenatives_facebook_include() {
		global $thenatives;
		?>
		<?php if($thenatives['thenatives_footer_fanpage']) :?>
            <div id="fb-root"></div>
			<script>
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=177069522674587";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
        <?php endif; ?>
        <?php
	}
    add_action('body_before', 'thenatives_facebook_include');
}