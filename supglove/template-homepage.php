<?php
/**
 * Template Name: HomePage
 *
 * The template file for displaying Home page.
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
