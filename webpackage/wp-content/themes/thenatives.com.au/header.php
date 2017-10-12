<?php global $thenatives; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> />
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="profile" href="http://gmgp.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
    <?php do_action('thenative_before_body'); ?>
	<div id="wrapper">
        <header id="header">
            <div class="header-wrapper">
                <?php do_action('thenatives_logo'); ?>
                <?php if (has_nav_menu('primary')) : ?>
                    <nav id="menu" class="nav menu">
                        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
                    </nav>
                <?php endif; ?>
            </div>
        </header>
        <div id="body" class="site-main">