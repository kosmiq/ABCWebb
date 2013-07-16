<?php
/**
 * The custom portfolio post type single post template
 */
 
 /** Force full width content layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/** Remove the post info function */
remove_action( 'genesis_entry_header', 'genesis_post_info' );

/** Remove the author box on single posts */
remove_action( 'genesis_entry_footer', 'genesis_do_author_box_single' );

/** Remove the post meta function */
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

/** Remove the comments template */
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

/** Remove the post category */
remove_action( 'genesis_entry_header', 'do_post_category' );

/** Remove single post navigation */
remove_action('genesis_entry_footer', 'genesis_post_navigation');

/** Remove the author box */
remove_action('genesis_after_entry', 'author_box_after_post');

genesis();