<?php
/**
 * The custom portfolio post type archive template
 */

/** Force full width content layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/** Add the script in the document for filtering */
add_action('wp_footer', 'portf_filter');
function portf_filter() {
  echo '<script>';
    echo 'jQuery(document).ready(function() { ';
      echo 'jQuery(".content").filterable();';
    echo '});';
  echo '</script>';
}

/** Remove the post info function */
remove_action( 'genesis_entry_header', 'genesis_post_info' );

/** Remove the post content */
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

/** Remove the post category */
remove_action( 'genesis_entry_header', 'do_post_category' );

/** Remove breadcrumbs */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

/** Remove comments */
remove_action( 'genesis_after_post_title', 'do_post_category' );

/** Remove the post meta function */
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/** Remove the author box */
remove_action('genesis_entry_footer', 'author_box_after_post');

/** Add the menu for filtering portfolio */
add_action ('genesis_before_content', 'portfolio_filter_link');
function portfolio_filter_link() {
  $taxonomy = 'portfolio';
  $queried_term = get_query_var($taxonomy);
  $terms = get_terms($taxonomy, 'slug='.$queried_term);
  if ($terms) {
    echo '<div id="portfolio-filter-container">';
    echo '<ul id="portfolio-filter">';
    echo '<li><a href="#all">' . __('All', 'cleanwhite') . '</a></li>';
    foreach($terms as $term) {
      $termname = $term->name;
      $termslug = $term->slug;
      echo '<li><a href="#' . $termslug . '" rel="' . $termslug . '">' . $termname . '</a></li> ';
    }
    echo '</ul>';
    echo '</div>';
  }
}

/** Add the featured image after post title */
add_action( 'genesis_entry_header', 'minimum_portfolio_grid' );
function minimum_portfolio_grid() {
  if ( has_post_thumbnail() ){
    echo '<div class="portfolio-featured-image">';
    echo '<a href="' . get_permalink() .'" title="' . the_title_attribute( 'echo=0' ) . '">';
    echo get_the_post_thumbnail($thumbnail->ID, 'portfolio');
    echo '</a>';
    echo '</div>';
  }
}

/** Add the portfolio type to the portfolio item as CSS-class */
add_filter( 'post_class', 'my_post_class' );
function my_post_class( $classes ) {
  global $post;
  $terms = wp_get_object_terms( $post->ID, 'portfolio' );
  foreach ( $terms as $type ) {
      $classes[] = $type->slug;
  }
  return $classes;
}

genesis();