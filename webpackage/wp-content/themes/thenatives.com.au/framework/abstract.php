<?php
class Thenatives {
	protected $options = array();
	protected $arrFunctions = array();
	protected $arrShortcodes = array();
	protected $arrWidgets = array();
	protected $arrIncludes = array();
	public function __construct($options){
		$this->options = $options;
		$this->initArrFunctions();
		$this->initArrWidgets();
		$this->initArrShortcodes();
		$this->initArrIncludes();
		$this->constant($options);
	}

	public function init(){
		$this->initIncludes();
		add_action('after_setup_theme', array($this,'themesetup'));
		add_action('wp_enqueue_scripts', array($this,'themestyle'));
		$this->initFunctions();
		$this->initShortcodes();
		$this->initWidgets();
	}

	protected function constant($options){
		define('THEME_NAME', $options['theme_name']);
		define('THEME_SLUG', $options['theme_slug'].'_');
		define('THEME_DIR', get_template_directory());
		define('THEME_CACHE', get_template_directory().'/cache_theme/');
		define('THEME_URI', get_template_directory_uri());
		define('THEME_FRAMEWORK', THEME_DIR . '/framework');
		define('THEME_FRAMEWORK_URI', THEME_URI . '/framework');
		define('THEME_FUNCTIONS', THEME_FRAMEWORK . '/functions');
		define('THEME_SHORTCODE', THEME_FRAMEWORK . '/shortcodes');
		define('THEME_WIDGETS', THEME_FRAMEWORK . '/widgets');
		define('THEME_INCLUDES', THEME_FRAMEWORK . '/includes');
		define('THEME_INCLUDES_URI', THEME_URI . '/framework/includes');
		define('THEME_EXTENSION', THEME_FRAMEWORK . '/extension');
		define('THEME_IMAGES', THEME_URI . '/images');
        define('THEME_SCSS', THEME_URI . '/scss');
		define('THEME_CSS', THEME_URI . '/css');
		define('THEME_JS', THEME_URI . '/js');
		define('THEME_FONT', THEME_URI . '/fonts');
		define('USING_CSS_CACHE', true);
	}

	protected function initArrFunctions(){
		$this->arrFunctions = array('filter_theme','general','header','footer','style');
	}
	
	protected function initFunctions(){
		foreach($this->arrFunctions as $function){
			if(file_exists(THEME_FUNCTIONS."/{$function}.php"))
			{
				require_once THEME_FUNCTIONS."/{$function}.php";
			}
		}
	}
	
	protected function initArrShortcodes(){
		$this->arrShortcodes = array('');
	}
	
	protected function initShortcodes(){
		foreach($this->arrShortcodes as $shortcode){
			if(file_exists(THEME_SHORTCODE."/{$shortcode}.php")){
				require_once THEME_SHORTCODE."/{$shortcode}.php";
			}
		}
	}
	
	protected function initArrWidgets(){
		$this->arrWidgets = array();
	}

	protected function initWidgets(){
		foreach($this->arrWidgets as $widget){
			if(file_exists(THEME_WIDGETS."/{$widget}.php"))
			{
				require_once THEME_WIDGETS."/{$widget}.php";
			}
		}
		add_action( 'widgets_init', array($this,'loadWidgets'));
	}
	
	public function loadWidgets(){
		foreach($this->arrWidgets as $widget)
		register_widget( 'WP_Widget_'.ucfirst($widget) );
	}
	
	protected function initArrIncludes(){
		$this->arrIncludes = array('class-tgm-plugin-activation');
	}

	protected function initIncludes(){
		foreach($this->arrIncludes as $include){
			if(file_exists(THEME_LIB."/{$include}.php")){
				require_once THEME_LIB."/{$include}.php";
			}
		}
	}

	public function themesetup() {
        add_editor_style();
        //add_theme_support( 'post-formats', array( 'link', 'gallery', 'quote', 'image' ) );
        add_theme_support( 'title-tag' );
        if ( ! function_exists( '_wp_render_title_tag' ) ) {
            add_action( 'wp_head', 'theme_slug_render_title' );
        }
        add_theme_support( 'post-thumbnails' );
        $defaults = array(
            'default-color' => '#e8e8e8',
        );
        add_theme_support( 'custom-background', $defaults );
		load_theme_textdomain( 'thenatives', get_template_directory() . '/languages' );
		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );
		$this->addMenuWidget();
	}

	public function themestyle() {
        wp_register_script( 'main', THEME_JS . "/main.js", array('jquery'), '', true );
        wp_enqueue_script('main');
        wp_register_style( 'bootstrap', THEME_CSS . "/bootstrap.min.css" );
        wp_enqueue_style('bootstrap');
        wp_register_style( 'fontawesome', THEME_CSS . "/font-awesome.min.css" );
        wp_enqueue_style('fontawesome');
        wp_register_style( 'theme', THEME_URI . "/style.css" );
        wp_enqueue_style('theme');
        wp_register_style( 'main', THEME_SCSS . "/main.css" );
        wp_enqueue_style('main');
	}

	private function addMenuWidget() {
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'thenatives' )
		));
	}
}