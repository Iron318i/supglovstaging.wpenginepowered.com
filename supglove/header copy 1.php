<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Supglove
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_site_icon(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
<!--	
<div class="preloader">
  <div class="layer"></div>
  <div class="inner">
    <figure> <img src="<?php echo get_template_directory_uri() . '/img/SG-logo.svg'; ?>" alt="Superior Glove"> </figure></div>
</div>
 -->
	
	
<div id="page" class="hfeed site">

	<?php do_action( 'supro_before_header' ); ?>

	<header id="masthead" class="site-header 
		<?php 
		 //if(     get_post_meta($post->ID, '_wpb_vc_js_status', true) === 'true'  ) { echo 'wpb_animate_when_almost_visible wpb_fadeInDown fadeInDown'; }
		?>">
		<?php do_action( 'supro_header' ); ?>
	</header><!-- #masthead -->

	<?php
	/*
	 *  supro_show_page_header - 20
	 */
	do_action( 'supro_after_header' );
	?>



<?php 

    //CUSTOM SINGLE BLOG POST BACKGROUND HEADER
    	$cssimage = '';
    if ( is_single() ) {
		$background = (supro_get_page_header_single_post()); 
		//array(5) { ["bg_image"]=> string(3) "148" ["bg_position"]=> string(13) "center center" ["bg_size"]=> string(5) "cover" ["bg_repeat"]=> string(9) "no-repeat" ["bg_attachment"]=> string(0) "" }

	
		if( !empty($background) ){	
			$cssimage .= 'background-image: url(\''.wp_get_attachment_url( $background["bg_image"] ).'\'); ';
			$cssimage .= 'background-position: '. $background["bg_position"].'; ';
			$cssimage .= 'background-size: '.$background["bg_size"].'; ';
			$cssimage .= 'background-repeat: '.$background["bg_repeat"].'; ';
			
			
			if(!$bg_attachment == ''){
				$cssimage .= 'background-attachment: '.$background["bg_attachment"].'; ';
			}
		}

		if( $cssimage !== ''){
			$styleback = ' style= "'.$cssimage .'" ';
		}
	}

?>



	<div id="content" class="site-content <?php if( $cssimage !== ''){echo "singheaderpic"; }else{echo "singheadernopic 123";} ?>">
		
		
		

		<?php 
		
		if ( is_singular('post')  ) {
		do_action( 'supro_before_post_list' );
		}

        $category = '';
        $fields   = (array) supro_get_option( 'post_entry_meta' );
        if ( in_array( 'scat', $fields ) ) {
            $category = get_the_terms( get_the_ID(), 'category' );
        }
    if ( is_single() && $cssimage !== '' ) {
    	?>
    	
		<div class="headpicdetails"  <?php echo $styleback; ?>>
            <?php
            if ( ! is_wp_error( $category ) && $category ) {
                echo sprintf( '<a href="%s" class="entry-cat image_cat">%s</a>', esc_url( get_term_link( $category[0], 'category' ) ), esc_html( $category[0]->name ) );
            } ?>
        </div>
	   <?php
	   } 
	   ?>


		
		
		<?php
		/*
		 *  supro_site_content_open - 20
		 */
		do_action( 'supro_site_content_open' );
		?>

		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header-sidebar') ) : 
 
endif; ?>