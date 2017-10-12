<?php
if (!function_exists('thenatives_logo')) {
	function thenatives_logo() {
		global $thenatives;
		?>
		<div id="logo">
			<h2>
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
			</h2>
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

if (!function_exists('thenatives_header_bg')) {
	function thenatives_header_bg() {
		global $thenatives;
		$bg = $thenatives['thenatives_banner']?$thenatives['thenatives_banner']:'';
		if(is_front_page() && $thenatives['thenatives_banner_fp']){
			$bg = $thenatives['thenatives_banner_fp'];
		}
		if(is_post_type_archive('about-us')){
			if($thenatives['thenatives_about_us_banner']){
				$bg = $thenatives['thenatives_about_us_banner'];
			}
		}
		elseif(is_post_type_archive('service')){
			if($thenatives['thenatives_service_banner']){
				$bg = $thenatives['thenatives_service_banner'];
			}
		}
		elseif(is_post_type_archive('language')){
			if($thenatives['thenatives_language_banner']){
				$bg = $thenatives['thenatives_language_banner'];
			}
		}
		elseif(is_post_type_archive('contact')){
			if($thenatives['thenatives_contact_banner']){
				$bg = $thenatives['thenatives_contact_banner'];
			}
		}
		elseif(is_single() || is_page()) {
			if(get_post_meta( get_the_ID(), '_post_cover', true )){
				$bg = get_post_meta( get_the_ID(), '_post_cover', true );
			}
			elseif(has_post_thumbnail()) {
				$bg = get_the_post_thumbnail_url();
			}
		}
		elseif(is_taxonomy('study-abroad-categories') && !is_single()){
			global $wp_query;
			$term = $wp_query->get_queried_object();
			$term_id = $term->term_id;
			$bg = get_term_meta($term_id, 'category-cover', true)?get_term_meta($term_id, 'category-cover', true):$bg;
		}
		if($bg){
			echo ' style="background-image: url('.$bg.');"';
		}
	}
	add_action('thenatives_header_bg','thenatives_header_bg');
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