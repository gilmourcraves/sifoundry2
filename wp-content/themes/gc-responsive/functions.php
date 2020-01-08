<?php
require_once('functions/wp_bootstrap_navwalker.php');
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

register_default_headers( array(
    'header' => array(
        'url'   => get_template_directory_uri() . '/images/logo-holder.png',
        'thumbnail_url' => get_template_directory_uri() . '/images/logo-holder.png',
        'description'   => _x( 'header', 'the logo', 'gc-responsive' )),
));

$args = array(
    'width'         => 440,
    'height'        => 60,
    'default-image' => get_template_directory_uri() . '/images/logo-holder.png',
    'uploads'       => true,
);
add_theme_support( 'custom-header', $args );

function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

remove_filter('the_content','wpautop');

do_shortcode( get_post_meta( $post->ID, 'content', true ) );

//decide when you want to apply the auto paragraph

add_filter('the_content','my_custom_formatting');

function my_custom_formatting($content){
    if(get_post_type()=='home') //if it does not work, you may want to pass the current post object to get_post_type
        return $content;//no autop
    else
        return wpautop($content);
}

// Marketo filters for trial form

function capriza_enqueue_marketo_form_sdk() {
    wp_enqueue_script( 'capriza-market-subscribe-helper', '//app-ab21.marketo.com/js/forms2/js/forms2.min.js' );
}
add_action( 'wp_enqueue_scripts', 'capriza_enqueue_marketo_form_sdk' );

/**
 * Block non business emails. Added by Capriza Feb 2, 2017.
 */
function block_non_biz_emails( $error, $name, $val, $field ){

    if( $name == 'email' ){

        $non_biz_domains = array( 'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'yahoo.co.in',
            'aol.com',
            'abc.com',
            'xyz.com',
            'pqr.com',
            'rediffmail.com',
            'live.com',
            'outlook.com',
            'me.com',
            'msn.com',
            'ymail.com' );

        $domain = array_pop(explode('@', $val));

        if( in_array( $domain, $non_biz_domains ) ){
            $error['valid'] = false;
            $error['message'] = 'Please enter a business email addresss.';
        }

    }

    return $error;
}
add_filter('sfwp2l_validate_field','block_non_biz_emails', 10, 4);

// Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 825, 510, true );

/*============================================
Register navbar and sidebar
=============================================*/

register_nav_menus( array(
    'primary' => __( 'Main Menu', 'gcbootssimple' ),
    'footer' => __( 'Footer Menu', 'gcbootssimple' ),
    'social'  => __( 'Social Links Menu', 'gcbootssimple' ),
) );


add_action('wp_enqueue_scripts', 'header_enqueue_css');
add_action('wp_enqueue_scripts', 'footer_enqueue_js');


/*============================================
Enqueue js and css
=============================================*/

function header_enqueue_css() {
    //load css files
    wp_enqueue_style('bootstrap', get_template_directory_uri(). '/css/bootstrap/dist/css/bootstrap.css', 'style');
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css', 'style');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/font-awesome/css/font-awesome.min.css', 'style');
    wp_enqueue_style('aoscss', get_template_directory_uri() . '/js/vendor/aos/aos.css', 'style');
}

function footer_enqueue_js() {

    //load js files
    wp_enqueue_script('jquery', get_template_directory_uri() . '/js/vendor/jquery-1.9.min.js', 'jquery','1.9.1',TRUE);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/css/bootstrap/dist/js/bootstrap.min.js','bootstrap', '1.4.8', TRUE);


    // vendor scripts
    wp_enqueue_script('easing', get_template_directory_uri() . '/js/vendor/jquery-easing/jquery.easing.js','easing', '2.0', TRUE);
    wp_enqueue_script('aos', get_template_directory_uri() . '/js/vendor/aos/aos.js','aos', '2.0', TRUE);
    wp_enqueue_script('appear', get_template_directory_uri() . '/js/vendor/appear-js/appear.min.js','appear', '2.0', TRUE);
    wp_enqueue_script('lottie', get_template_directory_uri() . '/js/vendor/lottie/lottie.min.js','lottie', '1.0', TRUE);
    wp_enqueue_script('parallaxbg', get_template_directory_uri() . '/js/vendor/parallax-background/parallax-background-gc.js','parallaxbg', '1.3', TRUE);

    // Chris Gannon animation

    wp_register_script( 'gsap', get_stylesheet_directory_uri() . '/js/vendor/gannon/gsap.js',null, null, true );
    wp_enqueue_script( 'gsap' );

    wp_register_script( 'customEase', get_stylesheet_directory_uri() . '/js/vendor/gannon/CustomEase.js',null, null, true );
    wp_enqueue_script( 'customEase' );

    wp_register_script( 'customWiggle', get_stylesheet_directory_uri() . '/js/vendor/gannon/CustomWiggle.js',null, null, true );
    wp_enqueue_script( 'customWiggle' );

    wp_register_script( 'gannonScript', get_stylesheet_directory_uri() . '/js/vendor/gannon/script.js',null, null, true );
    wp_enqueue_script( 'gannonScript' );

    // vendor scripts

    wp_register_script( 'flickity', get_stylesheet_directory_uri() . '/js/vendor/flickity/flickity.pkgd.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'flickity' );

    wp_register_script( 'imagesLoaded', get_stylesheet_directory_uri() . '/js/vendor/imagesLoaded/imagesloaded.pkgd.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'imagesLoaded' );

    wp_register_script( 'jqueryVisible', get_stylesheet_directory_uri() . '/js/vendor/jquery-visible/jquery.visible.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'jqueryVisible' );

    wp_register_script( 'particleJS', get_stylesheet_directory_uri() . '/js/vendor/particles.js/particles.min.js', null, null, true );
    wp_enqueue_script( 'particleJS' );

    wp_enqueue_script('main', get_template_directory_uri() . '/js/site.js', 'main','1.3',TRUE);

}

/*============================================
Custom Post Types
=============================================*/

// Register Custom Post Types
function custom_post_types() {

    $labels = array(
        'name'                => _x( 'Press Coverage', 'Post Type General Name', 'roots' ),
        'singular_name'       => _x( 'Press Item', 'Post Type Singular Name', 'roots' ),
        'menu_name'           => __( 'Press Items', 'roots' ),
        'parent_item_colon'   => __( 'Parent Press Item:', 'roots' ),
        'all_items'           => __( 'All Press Items', 'roots' ),
        'view_item'           => __( 'View Press Item', 'roots' ),
        'add_new_item'        => __( 'Add New Press Item', 'roots' ),
        'add_new'             => __( 'Add New', 'roots' ),
        'edit_item'           => __( 'Edit Press Item', 'roots' ),
        'update_item'         => __( 'Update Press Item', 'roots' ),
        'search_items'        => __( 'Search Press Item', 'roots' ),
        'not_found'           => __( 'Not found', 'roots' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'roots' ),
    );
    $rewrite = array(
        'slug'                => 'press',
        'with_front'          => false,
        'pages'               => true,
        'feeds'               => true,
    );
    $args = array(
        'label'               => __( 'press_item', 'roots' ),
        'description'         => __( 'Press Items', 'roots' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes', ),
        'taxonomies'          => array( 'press_items_types' ),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'             => $rewrite,
        'menu_icon'          => 'dashicons-media-text'
    );
    register_post_type( 'press_item', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_types', 0 );

// Register Custom Taxonomies
function custom_taxonomies() {

    $labels = array(
        'name'                       => _x( 'Press Item Types', 'Taxonomy General Name', 'roots' ),
        'singular_name'              => _x( 'Press Item Type', 'Taxonomy Singular Name', 'roots' ),
        'menu_name'                  => __( 'Press Item Types', 'roots' ),
        'all_items'                  => __( 'All Item Types', 'roots' ),
        'parent_item'                => __( 'Parent Item Type', 'roots' ),
        'parent_item_colon'          => __( 'Parent Item Type:', 'roots' ),
        'new_item_name'              => __( 'New Type Name', 'roots' ),
        'add_new_item'               => __( 'Add New Type', 'roots' ),
        'edit_item'                  => __( 'Edit Type', 'roots' ),
        'update_item'                => __( 'Update Type', 'roots' ),
        'separate_items_with_commas' => __( 'Separate types with commas', 'roots' ),
        'search_items'               => __( 'Search Types', 'roots' ),
        'add_or_remove_items'        => __( 'Add or remove types', 'roots' ),
        'choose_from_most_used'      => __( 'Choose from the most used items', 'roots' ),
        'not_found'                  => __( 'Not Found', 'roots' ),
    );
    $rewrite = array(
        'slug'                       => 'newsroom',
        'with_front'                 => false,
        'hierarchical'               => true,
    );
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => $rewrite,
    );
    register_taxonomy( 'press_items_types', array( 'press_item' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomies', 0 );

/**
 * Register our sidebars and widgetized areas.
 *
 */

function sidebar_widget_init() {

    register_sidebar(array(
        'name' => 'Primary Sidebar Widgets',
        'id' => 'primary_sidebar',
        'description' => 'These are widgets for primary sidebar.',
        'before_widget' => '<div class="sidebar">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ));
}
add_action( 'widgets_init', 'sidebar_widget_init' );

function social_widget_init() {

    register_sidebar( array(
        'name' => 'Social Widget',
        'id' => 'social_widget',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="hide">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'social_widget_init' );

function copyright_widget_init() {

    register_sidebar( array(
        'name' => 'Copyright Widget',
        'id' => 'copyright_widget',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ) );
}
add_action( 'widgets_init', 'copyright_widget_init' );

function lightbox_widget_init() {

	register_sidebar( array(
		'name' => 'Lightbox Widget',
		'id' => 'lightbox_widget',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'lightbox_widget_init' );

function footer_widget_init() {

	register_sidebar( array(
		'name' => 'Footer Widget',
		'id' => 'footer_widget',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'footer_widget_init' );

function disclaimer_widget_init() {

	register_sidebar( array(
		'name' => 'Disclaimer Widget',
		'id' => 'disclaimer_widget',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'disclaimer_widget_init' );

function externallink_widget_init() {

	register_sidebar( array(
		'name' => 'External Link Disclaimer Widget',
		'id' => 'externallink_widget',
		'before_widget' => '<div>',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'externallink_widget_init' );

function four04_widget_init() {

    register_sidebar( array(
        'name' => '404 Widget',
        'id' => '404_widget',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ) );
}
add_action( 'widgets_init', 'four04_widget_init' );

// Excerpt customizations

function get_excerpt($count){
    $excerpt = get_the_excerpt();
    $excerpt = strip_tags($excerpt);
    if(strlen($excerpt) > $count){
        $excerpt = substr($excerpt, 0, $count) . '&#8230;';
    }
    return $excerpt. '<br /><a class="moretag" href="'. get_permalink($post->ID) . '"> Read the full article...</a>' ;
}

function list_scroll_spy( $section_id, $title, $first_item ) {

    if ( $first_item == true ) {
        $list_scroll_spy = '<li class="active"><a href="#' . $section_id . '"><span class="item">' . $title . '</span></a></li>';
    } else {
        $list_scroll_spy = $list_scroll_spy . '<li><a href="#' . $section_id . '"><span class="item">' . $title . '</span></a></li>';
    }

    return $list_scroll_spy;
}


// Reduce nav classes, leaving only 'current-menu-item'

function nav_class_filter( $var, $item) {
    $resultArray = is_array($var) ? array_intersect($var, array('current-menu-item', 'menu-item', 'current-page-parent')) : array();
    $resultArray[] = 'nav-'.cleanname($item->title);
    return $resultArray;
}
add_filter('nav_menu_css_class', 'nav_class_filter', 100, 2);

function cleanname($v) {
    $v = preg_replace('/[^a-zA-Z0-9s]/', '', $v);
    $v = str_replace(' ', '-', $v);
    $v = strtolower($v);
    return $v;
}


// Bootstrap pagination function

function gc_pagination( $pages = '', $range = 4 ) {

    $showitems = ( $range * 2 ) + 1;

    global $paged;

    if ( empty( $paged ) ) {
        $paged = 1;
    }

    if ( $pages == '' ) {

        global $wp_query;

        $pages = $wp_query->max_num_pages;

        if ( ! $pages ) {
            $pages = 1;
        }

    }


    if ( 1 != $pages ) {

        echo '<nav><ul class="pagination"><li class="disabled hidden-xs"><span><span aria-hidden="true">Page ' . $paged . ' of ' . $pages . '</span></span></li>';

        if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
            echo "<li><a href='" . get_pagenum_link( 1 ) . "' aria-label='First'>&laquo;<span class='hidden-xs'> First</span></a></li>";
        }

        if ( $paged > 1 && $showitems < $pages ) {
            echo "<li><a href='" . get_pagenum_link( $paged - 1 ) . "' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Previous</span></a></li>";
        }

        for ( $i = 1; $i <= $pages; $i ++ ) {

            if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {

                echo ( $paged == $i ) ? "<li class=\"active\"><span>" . $i . " <span class=\"sr-only\">(current)</span></span>

    </li>" : "<li><a href='" . get_pagenum_link( $i ) . "'>" . $i . "</a></li>";

            }
        }


        if ( $paged < $pages && $showitems < $pages ) {
            echo "<li><a href=\"" . get_pagenum_link( $paged + 1 ) . "\"  aria-label='Next'><span class='hidden-xs'>Next </span>&rsaquo;</a></li>";
        }

        if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
            echo "<li><a href='" . get_pagenum_link( $pages ) . "' aria-label='Last'><span class='hidden-xs'>Last </span>&raquo;</a></li>";
        }

        echo "</ul></nav>";
    }

}

//for blogs with no featured image

function get_primary_image($id, $size){
    $featured = wp_get_attachment_image_src( get_post_thumbnail_id($id), $size, false);
    if($featured){
        $childURL = $featured['0'];
    }else{
        $children = get_children(array('post_parent' => $id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => 1));
        reset($children);
        $childID = key($children);
        //$childURL = wp_get_attachment_url($childID);
        $childArray = wp_get_attachment_image_src($childID, $size, false);
        $childURL = $childArray['0'];
        if(empty($childURL)){
            $childURL = get_bloginfo('template_url')."/images/default.png";
        } else {
            update_post_meta($id, '_thumbnail_id', $childID);
        }
    }
    return($childURL);
}




/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.0
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once dirname( __FILE__ ) . '/functions/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

function my_theme_register_required_plugins() {

    $plugins = array(

        array(
            'name'      => 'Simple 301 Redirects',
            'slug'      => 'simple-301-redirects',
            'required'  => true,
        ),

        array(
            'name'      => 'Page Links To',
            'slug'      => 'page-links-to',
            'required'  => true,
        ),

        array(
            'name'      => 'Simple Custom Post Order',
            'slug'      => 'simple-custom-post-order',
            'required'  => true,
        ),

        array(
            'name'      => 'SVG Support',
            'slug'      => 'svg-support',
            'required'  => true,
        ),

        array(
            'name'      => "IT's Tracking Code",
            'slug'      => 'its-tracking-code',
            'required'  => true,
        ),

        array(
            'name'      => 'All-in-One WP Migration',
            'slug'      => 'all-in-one-wp-migration',
            'required'  => false,
        ),

        array(
            'name'      => 'The SEO Framework',
            'slug'      => 'autodescription',
            'required'  => false,
        ),

        array(
            'name'      => 'Autoptimize',
            'slug'      => 'autoptimize',
            'required'  => false,
        ),

        array(
            'name'      => 'Google Analytics Dashboard for WP',
            'slug'      => 'google-analytics-dashboard-for-wp',
            'required'  => false,
        ),

        array(
            'name'      => 'WP Retina 2x',
            'slug'      => 'wp-retina-2x',
            'required'  => false,
        )

    );

    /*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );
}

