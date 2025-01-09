<?php
/**
 * @package Supglove
 */

global $wp_query;

$current = $wp_query->current_post + 1;

$size           = 'supro-blog-grid-small';
$blog_style     = supro_get_option( 'blog_style' );
$blog_layout    = supro_get_option( 'blog_layout' );
$excerpt_length = intval( supro_get_option( 'excerpt_length' ) );

$css_class = 'blog-wrapper';

if ( 'grid' == $blog_style ) {
	if ( 'full-content' == $blog_layout ) {
		$css_class .= ' col-md-4 col-sm-6 col-xs-6';
	} else {
		$css_class .= ' col-md-6 col-sm-6 col-xs-6';
	}

} elseif ( 'list' == $blog_style ) {
	$size = 'supro-blog-list';

} elseif ( 'masonry' == $blog_style ) {

	if ( $current % 9 == 1 || $current % 9 == 6 || $current % 9 == 8 ) {
		$size = 'supro-blog-masonry-1';
	} elseif ( $current % 9 == 3 || $current % 9 == 4 || $current % 9 == 7 ) {
		$size = 'supro-blog-masonry-3';
	} else {
		$size = 'supro-blog-masonry-2';
	}
}


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>
<?php if ( $blog_style == 'masonry' && $current == 1 )  : ?>
	<div class="blog-masonry-sizer"></div>
	<div class="blog-gutter-sizer"></div>
<?php endif; 

if($current == 1 && $paged == 1){
	$css_class = 'blog-wrapper col-md-8 col-sm-6 col-xs-6 feature';
	$size = 'supro-blog-grid';
}
if(has_post_format( 'link' )  ){
	$css_class .= ' linkfeature';
}


?>

<?php
	$stylelink = '';
	if(has_post_format( 'link' )  ){
		//PROMO lINK format
		if ( has_post_thumbnail() ){
			$backimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
			$stylelink = 'style="background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)), url('.$backimage[0].');"';
		}
		
		$postlinktext = get_post_meta( get_the_ID(), 'post_link_cta_text', true );  
		 $postlinkurl = get_post_meta( get_the_ID(), 'post_link_cta_url', true );  
		
		//getlink
		
?>


<article id="post-<?php the_ID(); ?>" <?php post_class( $css_class ); ?>  >
	<div class="shadowbox" <?php echo $stylelink; ?>  >
	<div class="entry-summary">
		<div class="entry-header-link">

			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		
		
		
		 <div class="entry-excerpt-link"><?php echo supro_content_limit( $excerpt_length, '' ); ?></div>
						
						
			<a href="<?php echo $postlinkurl; ?>" class="buttonogs btn_small btn_theme_color"><?php echo $postlinktext; ?></a>

		</div>

	</div>
	</div>
</article>




<?php
	}else{
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $css_class ); ?>>
	<div class="shadowbox">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a class="blog-thumb" href="<?php the_permalink() ?>"><?php the_post_thumbnail( $size ); ?></a>
		</div>
	<?php endif; ?>

	<div class="entry-summary">
		<div class="entry-header">
			<?php supro_entry_meta_cats(); ?>
			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			
		<?php if ( 'grid' == $blog_style ) : ?>
			<div class="entry-excerpt"><?php echo supro_content_limit( $excerpt_length, '' ); ?></div>
		<?php endif ?>
			
			<?php supro_entry_meta(); ?>
		</div>
		<?php if ( 'list' == $blog_style ) : ?>
			<div class="entry-excerpt"><?php echo supro_content_limit( $excerpt_length, '' ); ?></div>
			<a href="<?php the_permalink() ?>" class="read-more">
				<?php echo apply_filters( 'supro_blog_read_more_text', esc_html__( 'READ MORE', 'supro' ) ); ?>
			</a>
		<?php endif ?>
	</div>
	</div>
</article>

<?php
	}