<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

/** Localization */
load_child_theme_textdomain( 'abcwebb', get_stylesheet_directory() . '/languages' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'ABCWebb' );
define( 'CHILD_THEME_URL', 'http://www.abcwebb.se/' );

//* Add HTML5 markup structure
add_theme_support( 'genesis-html5' );

/** Register default layout setting */
genesis_set_default_layout( 'full-width-content' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add and load apple touch icons
add_action('wp_head','abc_add_favicon');
function abc_add_favicon() {
  echo '<link rel="apple-touch-icon" href="' . get_stylesheet_directory_uri() . '/images/touch-icon-iphone.png" />';
  echo '<link rel="apple-touch-icon" sizes="72x72" href="' . get_stylesheet_directory_uri() . '/images/touch-icon-ipad.png" />';
  echo '<link rel="apple-touch-icon" sizes="114x114" href="' . get_stylesheet_directory_uri() . '/images/touch-icon-iphone-retina.png" />';
  echo '<link rel="apple-touch-icon" sizes="144x144" href="' . get_stylesheet_directory_uri() . '/images/touch-icon-ipad-retina.png" />';
}


/**-----------------------------------------------------------------------------------
  Add FitVids script for embedded video
  Load stylesheet based on version
  Add CSS-classes to the body based on page, subpage parent and Internet Explorer version
------------------------------------------------------------------------------------*/
add_action('genesis_meta', 'do_something');
function do_something() {
    //wp_register_script( 'mobile-menu-js', get_stylesheet_directory_uri() . '/js/mobilemenu.js', array('jquery') );
    //wp_enqueue_script( 'mobile-menu-js' );
    //wp_register_script( 'scroll-to-top-js', get_stylesheet_directory_uri() . '/js/smooth_scroll.js', array('jquery') );
    //wp_enqueue_script( 'scroll-to-top-js' );
    wp_register_script( 'combined-js', get_stylesheet_directory_uri() . '/js/combined.min.js', array('jquery') );
    wp_enqueue_script( 'combined-js' );
}

/** Load fitvids, jquery is already included in the theme */
  add_action('wp_footer', 'crc_fitVids');
  function crc_fitVids() {
    echo '<script>
            jQuery(document).ready(function($) {
              $(".entry-content").fitVids();
            });
          </script>';
   }

/** Load CSS stylesheet based on it's version to make sure changes reaches visitors.
    Remember to update the version number in the CSS-file.
*/
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
add_action( 'genesis_meta', 'jpry_load_stylesheet' );
function jpry_load_stylesheet() {
  $theme_info = wp_get_theme();
  wp_enqueue_style( 'dyn-load-version', get_stylesheet_directory_uri() . '/style.min.css', array(), $theme_info->Version, 'screen' );
  //wp_enqueue_style( 'dyn-load-version', get_stylesheet_directory_uri() . '/style.css', array(), $theme_info->Version, 'screen' );
}
add_action( 'genesis_meta', 'entypo_load_stylesheet' );
function entypo_load_stylesheet() {
    if ( is_page( 'vara-tjanster' ) ) {
        $theme_info = wp_get_theme();
        wp_enqueue_style( 'dyn-load-entypo', get_stylesheet_directory_uri() . '/entypo.css', array(), $theme_info->Version, 'screen' );
    }
}

/** Set a css-class for the current page based on its parent */
add_filter('body_class','parent_name_in_body_class');
function parent_name_in_body_class($classes) {
  global $wp_query;
  // if the page/post has a parent, it's a child, give it a class of its parent name
  if($wp_query->post->post_parent > 0 ) {
    $parent_title = get_the_title($wp_query->post->post_parent);
    $parent_title = preg_replace('#\s#','-', $parent_title);
    $parent_title = strtolower($parent_title);
    $classes[] = 'parent-'.$parent_title;
  };
  return array_unique($classes);
};
/** Set the current page as css-class */
add_filter( 'body_class', 'post_name_in_body_class' );
function post_name_in_body_class( $classes ){
	if( is_singular() )
	{
		global $post;
		array_push( $classes, "{$post->post_type}-{$post->post_name}" );
	}
	return $classes;
}

add_filter('body_class','add_category_name_to_single');
function add_category_name_to_single( $classes ) {
  if (is_single() ) {
    global $post;
    foreach((get_the_category($post->ID)) as $category) {
      // add category slug to the $classes array
      $classes[] = 'category-'.$category->category_nicename;
    }
  }
  // return the $classes array
  return $classes;
}

/** Outputs specific classes for IE* to <body> tag allowing for some specific CSS-classes. */
add_filter('body_class','bp_conditional_ie_classes');
function bp_conditional_ie_classes($classes)   {
    $ie_check = array();
    $ie_classes = array( 'ie7', 'ie8', 'ie9' );
    $version = 7;
    while ( $version < 10 ) {
        $ie_check[] = strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE ' . $version . '.') !== FALSE;
        ++$version;
    }
    foreach ( $ie_check as $key => $value  )    {
        if ( $value == 1 )  {
            $ie = $ie_classes[$key];
        }
    }
    $classes[] = $ie;
    return $classes;
}

/**-----------------------------------------------------------------------------------
  Other styling-related functions
------------------------------------------------------------------------------------*/
/** Add support for structural wraps */
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
  wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Lato:100,300,400|Open+Sans:300italic,400italic,400,300', array(), PARENT_THEME_VERSION );
}

/** Remove the fixed widths of embedded tweets */
add_filter('oembed_result','twitter_no_width',10,3);
function twitter_no_width($html, $url, $args) {
	if (false !== strpos($url, 'twitter.com')) {
		$html = str_replace('width="500"','',$html); /* The value 500 may need to be changed depending on the theme and whatever twitter sends back*/
	}
	return $html;
}

// Add support for custom background
add_theme_support( 'custom-background' );

// Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas */
genesis_register_sidebar( array(
  'id'        => 'after-header-widget-area',
  'name'      => __( 'After header widget area', 'abcwebb' ),
  'description' => __( 'This is the After header widget area.', 'abcwebb' ),
) );
genesis_register_sidebar( array(
  'id'        => 'start-after-header-widget-area',
  'name'      => __( 'Startpage After header widget area', 'abcwebb' ),
  'description' => __( 'This is the After header widget area.', 'abcwebb' ),
  'before_title' => '<h2 class="widgettitle">',
  'after_title' => '</h2>'
) );
genesis_register_sidebar( array(
  'id'        => 'start-after-content-widget-area',
  'name'      => __( 'Startpage After content widget area', 'abcwebb' ),
  'description' => __( 'This is the After content widget area.', 'abcwebb' ),
  'before_title' => '<h2 class="widgettitle">',
  'after_title' => '</h2>'
) );

add_action( 'genesis_after_header', 'abcwebb_header_widget_area' );
function abcwebb_header_widget_area() {
genesis_widget_area( 'after-header-widget-area', array(
      'before' => '<div id="after-header-widget-area"><div class="wrap">',
      'after' => '</div></div>',
    ) );
}

/** Add a read more link to excerpts */
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
  global $post;
  return '... <a class="read-more-link" href="'. get_permalink($post->ID) . '">' . __('Read more &raquo;', 'abcwebb') . '</a>';
}

/** Remove paragraph-container from images */
add_filter('the_content', 'filter_ptags_on_images');
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

/** Amend breadcrumb arguments. */
add_filter( 'genesis_breadcrumb_args', 'child_breadcrumb_args' );
function child_breadcrumb_args( $args ) {
    $args['home']                    = __('Home', 'abcwebb');
    $args['sep']                     = ' / ';
    $args['list_sep']                = ', '; // Genesis 1.5 and later
    $args['prefix']                  = '<div class="breadcrumb">';
    $args['suffix']                  = '</div>';
    $args['heirarchial_attachments'] = true; // Genesis 1.5 and later
    $args['heirarchial_categories']  = true; // Genesis 1.5 and later
    $args['display']                 = true;
    $args['labels']['prefix']        = __('You are here: ', 'abcwebb');
    $args['labels']['author']        = __('Archive for ', 'abcwebb');
    $args['labels']['category']      = __('Archive for ', 'abcwebb'); // Genesis 1.6 and later
    $args['labels']['tag']           = __('Archive for ', 'abcwebb');
    $args['labels']['date']          = __('Archive for ', 'abcwebb');
    $args['labels']['search']        = __('Search for ', 'abcwebb');
    $args['labels']['tax']           = __('Archive for ', 'abcwebb');
    $args['labels']['post_type']     = __('Archive for ', 'abcwebb');
    $args['labels']['404']           = __('Not found ', 'abcwebb'); // Genesis 1.5 and later
    return $args;
}

/**-----------------------------------------------------------------------------------
  Add code for portfolio post types
------------------------------------------------------------------------------------*/
/** Create portfolio custom post type */
add_action( 'init', 'portfolio_post_type' );
function portfolio_post_type() {
  register_post_type( 'portfolio',
    array(
      'labels' => array(
        'name' => __( 'Portfolio', 'abcwebb' ),
        'singular_name' => __( 'Portfolio', 'abcwebb' ),
      ),
      'exclude_from_search' => true,
      'has_archive' => true,
      'hierarchical' => true,
      'public' => true,
      'rewrite' => array( 'slug' => 'portfolio' ),
      'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'genesis-seo' ),
    )
  );
}
/** Add support for custom taxonomies in Portfolio post type */
add_action( 'init', 'create_my_taxonomies', 0 );
function create_my_taxonomies() {
  register_taxonomy(
    'portfolio',
    'portfolio',
    array(
      'labels' => array(
        'name' => 'Type',
        'add_new_item' => 'Add New Type',
        'new_item_name' => "New Type"
      ),
      'show_ui' => true,
      'show_tagcloud' => false,
      'hierarchical' => true
    )
  );
}

/** Add new image sizes */
add_image_size( 'portfolio', 353, 246, TRUE );
add_image_size( 'featured-image', 1100, 9999, FALSE );


/** Add Featured Image to single Posts - the Webonanza style  */
add_action( 'genesis_entry_header', 'child_do_single_post_image' );
function child_do_single_post_image() {
    if( is_single() ) {
        //echo get_the_post_thumbnail( $post_id, 'featured-image', array('class' => 'fullwidth-featured') );
        printf ( '<div class="featured-image-single">' . get_the_post_thumbnail( $post_id, 'featured-image', array('class' => 'fullwidth-featured') ) );
        if ( (get_post(get_post_thumbnail_id())->post_excerpt) != '' ) {
          printf ( '<p class="featured-image-caption-text">' . get_post(get_post_thumbnail_id())->post_excerpt . '</p>' );
        }
        printf ( '</div>' );

    }
}


/** Customize footer text */

/** Customize the return to top of page text */
add_filter( 'genesis_footer_backtotop_text', 'custom_footer_backtotop_text' );
function custom_footer_backtotop_text($backtotop) {
    $backtotop = '[footer_backtotop text="Till toppen av sidan"]';
    return $backtotop;
}

/** Customize the credits */
add_filter( 'genesis_footer_creds_text', 'custom_footer_creds_text' );
function custom_footer_creds_text() {
    echo '<div class="creds"><p>';
    echo 'Copyright &copy; ';
    echo date('Y');
    echo ' &middot; <a href="http://abcwebb.se">ABCWebb</a> &middot; en del av Nordic e-handel KB &middot; innehar F-Skattsedel';
    echo '</p></div>';
}

add_action('wp_footer','smooth_scrool_footer');
function smooth_scrool_footer()
{
  echo '<a href="#" class="scrollup"></a>';
}

// Remove Contact Form 7 CSS + JS form all pages except Contact
add_action( 'wp_print_scripts', 'deregister_cf7_javascript', 15 );
function deregister_cf7_javascript() {
    if ( !is_page( 'kontakta-oss' ) ) {
        wp_deregister_script( 'contact-form-7' );
    }
}
add_action( 'wp_print_styles', 'deregister_cf7_styles', 15 );
function deregister_cf7_styles() {
    if ( !is_page( 'kontakta-oss' ) ) {
        wp_deregister_style( 'contact-form-7' );
    }
}

/** Make sure that Shortcodes can execute in text widgets */
add_filter('widget_text', 'do_shortcode');