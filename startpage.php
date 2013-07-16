<?php
/*
Template Name: Startpage
*/

/** Remove the post info function */
remove_action( 'genesis_entry_footer', 'genesis_post_info' );

/** Remove the post category */
remove_action( 'genesis_entry_header', 'do_post_category' );

/** Remove breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

/** Remove comments */
remove_action( 'genesis_entry_header', 'do_post_category' );

/** Remove the post meta function */
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/** Remove the author box */
remove_action('genesis_entry_footer', 'author_box_after_post');

remove_action( 'genesis_after_header', 'abcwebb_header_widget_area' );

/** Remove page title */
remove_action('genesis_entry_header', 'genesis_do_post_title');

add_action( 'genesis_after_header', 'abcwebb_start_header_widget_area' );
function abcwebb_start_header_widget_area() {
genesis_widget_area( 'start-after-header-widget-area', array(
      'before' => '<div id="after-header-widget-area"><div class="wrap">',
      'after' => '</div></div>',
    ) );
}

add_action( 'genesis_before_footer', 'abcwebb_start_content_widget_area', 5 );
function abcwebb_start_content_widget_area() {
genesis_widget_area( 'start-after-content-widget-area', array(
      'before' => '<div id="after-content-widget-area"><div class="wrap">',
      'after' => '</div></div>',
    ) );
}

add_action( 'genesis_before_footer', 'portfoliotest', 6 );
function portfoliotest() {
  global $post;
  $args = array( 'numberposts' => 3, 'offset'=> 0, 'post_type' => 'portfolio' );
  $myposts = get_posts( $args );
  echo '<section class="front-portfolio-container">';
  echo '<div class="wrap">';
  echo '<h2>Tidigare uppdrag</h2>';
  foreach( $myposts as $post ) : setup_postdata($post);
  	$portftitle = get_the_title();
  	$portfpermalink = get_permalink();
  	$portftitleattr = the_title_attribute( 'echo=0' );
    echo '<article class="portfolio type-portfolio" itemscope="" itemtype="http://schema.org/CreativeWork">';
    echo '<h2 class="entry-title"><a href="' . $portfpermalink . '" title="' . $portftitleattr . '">' . $portftitle . '</a></h2>';
    if ( has_post_thumbnail() ){
      echo '<div class="portfolio-featured-image">';
      echo '<a href="' . $portfpermalink .'" title="' . $portftitleattr . '">';
      echo get_the_post_thumbnail($thumbnail->ID, 'portfolio');
      echo '</a>';
      echo '</div>';
    }
    echo '</article>';
  endforeach;
  echo '<a href="/portfolio" class="cta-button clear margintop">Se hela vår portfolio</a>';
  echo '</div>';
  echo '</section>';
}

genesis();