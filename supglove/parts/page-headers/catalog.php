<?php
$breadcrumb = supro_get_option( 'catalog_page_header_breadcrumbs' );
$banner     = intval( supro_get_option( 'catalog_page_header_banner' ) );
$ph_class   = $breadcrumb ? '' : 'no-breadcrumb';
$ph_class .= ' layout-3';
?>
<div id="page-header-catalog" class="page-header page-header-catalog <?php echo esc_attr( $ph_class ) ?>">
	<div class="page-header-wrapper">
		<div class="page-header-shop-toolbar">
			<?php do_action( 'supro_page_header_shop_toolbar' ) ?>
		</div>
	</div>
</div>