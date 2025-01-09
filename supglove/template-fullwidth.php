<?php
/**
 * Template Name: Full Width
 *
 * The template file for displaying service page.
 *
 * @package Supglove
 */

get_header(); ?>

<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
endif;
?>

<?php get_footer(); ?>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header-sidebar') ) : 
 
endif; ?>