<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



//Removes Title and Description on CPT Archive
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
//Removes Title and Description on Blog Archive
remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
//Removes Title and Description on Date Archive
remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
//Removes Title and Description on Archive, Taxonomy, Category, Tag
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
//Removes Title and Description on Author Archive
remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
//Removes Title and Description on Blog Template Page
remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );

function rva_remove_archive_content() {

    //* Remove the entry footer markup (requires HTML5 theme support)
    remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
    remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

    //* Remove the entry meta in the entry footer (requires HTML5 theme support)
    remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

    //* Remove the post content (requires HTML5 theme support)
    remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

}