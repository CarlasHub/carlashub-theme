<?php
/**
 * CarlasHub functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CarlasHub
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function carlashub_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on CarlasHub, use a find and replace
		* to change 'carlashub' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'carlashub', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'carlashub' ),
			'footer'  => esc_html__( 'Footer', 'carlashub' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'carlashub_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Block editor support.
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );

	add_editor_style( 'assets/css/theme.css' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'carlashub_setup' );

/**
 * Register block style variations.
 */
function carlashub_register_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'ghost',
			'label' => __( 'Ghost', 'carlashub' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'frame',
			'label' => __( 'Frame', 'carlashub' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'editorial-wide',
			'label' => __( 'Editorial Wide', 'carlashub' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'editorial-narrow',
			'label' => __( 'Editorial Narrow', 'carlashub' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'editorial-full',
			'label' => __( 'Editorial Full', 'carlashub' ),
		)
	);
	register_block_style(
		'core/cover',
		array(
			'name'  => 'veil',
			'label' => __( 'Veil', 'carlashub' ),
		)
	);
	register_block_style(
		'core/image',
		array(
			'name'  => 'ornament',
			'label' => __( 'Ornament', 'carlashub' ),
		)
	);
	register_block_style(
		'core/separator',
		array(
			'name'  => 'sigil',
			'label' => __( 'Sigil', 'carlashub' ),
		)
	);
	register_block_style(
		'core/quote',
		array(
			'name'  => 'editorial',
			'label' => __( 'Editorial', 'carlashub' ),
		)
	);
	register_block_style(
		'core/table',
		array(
			'name'  => 'ruled',
			'label' => __( 'Ruled', 'carlashub' ),
		)
	);
	register_block_style(
		'core/navigation',
		array(
			'name'  => 'arc',
			'label' => __( 'Arc', 'carlashub' ),
		)
	);
	register_block_style(
		'core/search',
		array(
			'name'  => 'field',
			'label' => __( 'Field', 'carlashub' ),
		)
	);
	register_block_style(
		'core/post-template',
		array(
			'name'  => 'cards',
			'label' => __( 'Cards', 'carlashub' ),
		)
	);
}
add_action( 'init', 'carlashub_register_block_styles' );

/**
 * Register block pattern categories.
 */
function carlashub_register_pattern_categories() {
	register_block_pattern_category(
		'carlashub-hero',
		array(
			'label' => __( 'CarlasHub Hero', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-content',
		array(
			'label' => __( 'CarlasHub Content', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-page-home',
		array(
			'label' => __( 'CarlasHub — Home', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-page-blog',
		array(
			'label' => __( 'CarlasHub — Blog', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-page-portfolio',
		array(
			'label' => __( 'CarlasHub — Portfolio', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-page-about',
		array(
			'label' => __( 'CarlasHub — About', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-page-contact',
		array(
			'label' => __( 'CarlasHub — Contact', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-page-style',
		array(
			'label' => __( 'CarlasHub — Style Guide', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-page-case-study',
		array(
			'label' => __( 'CarlasHub — Case Study', 'carlashub' ),
		)
	);
	register_block_pattern_category(
		'carlashub-layout',
		array(
			'label' => __( 'CarlasHub — Layout Variants', 'carlashub' ),
		)
	);
}
add_action( 'init', 'carlashub_register_pattern_categories' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function carlashub_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'carlashub_content_width', 640 );
}
add_action( 'after_setup_theme', 'carlashub_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function carlashub_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'carlashub' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'carlashub' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'carlashub_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function carlashub_scripts() {
	wp_enqueue_style(
		'carlashub-fonts',
		'https://fonts.googleapis.com/css2?family=Allura&family=Cormorant+Garamond:wght@400;500;600&family=Sora:wght@400;500;600&display=swap',
		array(),
		_S_VERSION
	);
	wp_enqueue_style(
		'carlashub-style',
		get_theme_file_uri( '/assets/css/theme.css' ),
		array(),
		filemtime( get_theme_file_path( '/assets/css/theme.css' ) )
	);
	wp_style_add_data( 'carlashub-style', 'rtl', 'replace' );

	if ( file_exists( get_theme_file_path( '/assets/css/woocommerce.css' ) ) ) {
		wp_enqueue_style(
			'carlashub-woocommerce',
			get_theme_file_uri( '/assets/css/woocommerce.css' ),
			array( 'carlashub-style' ),
			filemtime( get_theme_file_path( '/assets/css/woocommerce.css' ) )
		);
	}

	wp_enqueue_script(
		'carlashub-theme',
		get_theme_file_uri( '/assets/js/theme.js' ),
		array(),
		filemtime( get_theme_file_path( '/assets/js/theme.js' ) ),
		true
	);


	wp_enqueue_script( 'carlashub-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script(
		'carlashub-components-registry',
		get_theme_file_uri( '/js/components/registry.js' ),
		array(),
		filemtime( get_theme_file_path( '/js/components/registry.js' ) ),
		true
	);

	$component_modules = array(
		'/js/components/toggle.js',
		'/js/components/tooltip.js',
		'/js/components/dropdown.js',
		'/js/components/modal.js',
		'/js/components/drawer.js',
		'/js/components/tabs.js',
		'/js/components/accordion.js',
		'/js/components/alert.js',
		'/js/components/toast.js',
		'/js/components/table-row-actions.js',
		'/js/components/file-upload.js',
		'/js/components/search-input.js',
		'/js/components/filter-group.js',
	);

	foreach ( $component_modules as $module_path ) {
		$handle = 'carlashub-components-' . md5( $module_path );
		wp_enqueue_script(
			$handle,
			get_theme_file_uri( $module_path ),
			array( 'carlashub-components-registry' ),
			filemtime( get_theme_file_path( $module_path ) ),
			true
		);
	}

	wp_enqueue_script(
		'carlashub-components',
		get_theme_file_uri( '/js/components/index.js' ),
		array( 'carlashub-components-registry' ),
		filemtime( get_theme_file_path( '/js/components/index.js' ) ),
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'carlashub_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Demo content seeding.
 */
require get_template_directory() . '/inc/demo-content.php';

/**
 * Admin setup helper.
 */
require get_template_directory() . '/inc/admin-setup.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
