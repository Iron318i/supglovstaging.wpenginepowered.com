<?php
$breadcrumb = supro_get_option( 'catalog_page_header_breadcrumbs' );
$banner     = intval( supro_get_option( 'catalog_page_header_banner' ) );
$ph_class   = $breadcrumb ? '' : 'no-breadcrumb';
$ph_class .= ' layout-3';
?>
<div id="page-header-catalog-main-head" class="page-header page-header-catalog <?php echo esc_attr( $ph_class ) ?> col-xs-12 col-sm-12">
	<div class="page-header-wrapper">

		<?php if ( $banner ) : ?>
			<div class="page-header-banner">
				<?php echo do_shortcode( wp_kses( supro_get_option( 'catalog_page_header_banner_shortcode' ), wp_kses_allowed_html( 'post' ) ) ); ?>
			</div>
		<?php endif; ?>
		
			<div class="page-header-title">
			<?php
			//Sthe_archive_title( '<h1>', '</h1>' );
			supro_get_breadcrumbs();
			?>
		</div>
	</div>
</div>