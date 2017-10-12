<?php
require_once get_template_directory()."/framework/abstract.php";
$theme = new Thenatives(array(
    'theme_name'	=>	"Thenatives",
    'theme_slug'	=>	'thenatives'
));
$theme->init();
require_once ('admin/index.php');