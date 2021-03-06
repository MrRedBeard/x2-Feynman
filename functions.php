<?php
/**
 * Feynman 2018 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage feynman2018
 * @since 1.0
 */

/**
 * Feynman 2018 only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) )
{
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'search-form' ) );

register_nav_menus( array(
	'top'    => __( 'Top Menu', 'twentyseventeen' ),
	'social' => __( 'Social Links Menu', 'twentyseventeen' ),
));

function change_howdy($translated, $text, $domain)
{

    if (!is_admin() || 'default' != $domain)
        return $translated;

    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy', 'Welcome', $translated);

    return $translated;
}
add_filter('gettext', 'change_howdy', 10, 3);


//Add active menu item class of active
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

/**
 * Hide WordPress Updates from all but Admins
 */
function hide_update_notice_to_all_but_admin()
{
	if ( !current_user_can( 'update_core' ) ) 
	{
		remove_action( 'admin_notices', 'update_nag', 3 );
	}
}
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin', 1 );

/** 
 * Include navigation menu editor
 */
function register_my_menu() 
{
  register_nav_menu('nav-menu',__( 'Navigation Menu' ));
}
add_action( 'init', 'register_my_menu' );

/**
 * Add Categories for Attachments
 */
function add_categories_for_attachments() 
{
	register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'add_categories_for_attachments' );

/**
 * Add Tags for Attachments
 */
function add_tags_for_attachments()
{
	register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'add_tags_for_attachments' );


// Add scripts and stylesheets
function x2feynman_scripts() 
{
	//ToDo: All Scripts need to be called here
	
	/*** CSS ***/
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_enqueue_style( 'bkw1', get_template_directory_uri() . '/css/ie10-viewport-bug-workaround.css');
	wp_enqueue_style( 'bootstraptheme', get_template_directory_uri() . '/css/bootstrap-theme.min.css', array(), 'v3.3.7' );
	wp_enqueue_style( 'bootstrapthemeextended', get_template_directory_uri() . '/css/theme-extended.css', array(), '0.0.1' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0' );
	wp_enqueue_style( 'main', get_template_directory_uri() . '/style.css' );
	
	/*** JS ***/
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
	wp_enqueue_script( 'ieEm', get_template_directory_uri() . '/js/ie-emulation-modes-warning.js', array( 'jquery' ), '1', true );
	wp_enqueue_script( 'docs', get_template_directory_uri() . '/js/docs.min.js', array( 'jquery' ), '2.6.0', true );
	// IE10 viewport hack for Surface/desktop Windows 8 bug
	wp_enqueue_script( 'ie10', get_template_directory_uri() . '/js/ie10-viewport-bug-workaround', array( 'jquery' ), '1', true );

}

add_action( 'wp_enqueue_scripts', 'x2feynman_scripts' );

// Add Google Fonts
function x2feynman_google_fonts() 
{
	wp_register_style('OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800');
	wp_enqueue_style( 'OpenSans');
}

add_action('wp_print_styles', 'x2feynman_google_fonts');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function feynman2018_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'feynman2018' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'feynman2018' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Front Page Tile Widgets', 'feynman2018' ),
		'id'            => 'x2-fptw',
		'description'	=> 'Only use the Text & Image Widgets. To add text with image use image caption and title',
		'before_widget' => '<div class="fptw-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="fptw-title">',
		'after_title'   => '</h2>',
	));
	
	register_sidebar( array(
		'name'          => __( 'Full Width Page Footer Widgets', 'feynman2018' ),
		'id'            => 'x2-ftrw',
		'description'	=> 'Only use the Text Widgets',
		'before_widget' => '<div class="ftrw-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	));
}
add_action( 'widgets_init', 'feynman2018_widgets_init' );




require get_parent_theme_file_path( '/inc/btsrpMenuWalker.php' );


