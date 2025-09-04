<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

//wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/js/print-helper.js');

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
  echo get_the_password_form(); // WPCS: XSS ok.
  return;
}

$columns = wc_get_default_products_per_row();

$classes = array('supro-single-product');
// $classes[] = 'supro-product-layout-1';
$classes[] = 'supro-product-layout-2';
$classes[] = 'supro-product-slider';

if ($columns == '5') {
  $classes[] = 'supro-product-slider';
}


$sku = $product->get_sku();
$product_name = str_replace( $sku, '', $product->get_name() );
$subtitle = get_post_meta( $product->get_id(), '_bhww_prosubtitle', true );


$product_image1_id = $product->get_image_id();
$gallery = $product->get_gallery_image_ids();
$image1 = false;
$image2 = false;
$image3 = false;

if ( $product_image1_id ) {
  $image1 = wp_get_attachment_url( $product_image1_id );
}

if ( !empty($gallery[0]) ) {
  $image2 = wp_get_attachment_url( $gallery[0] );
}

if ( !empty($gallery[1]) ) {
  $image3 = wp_get_attachment_url( $gallery[1] );
}


// Alternate versions
$alternate_versions = [];
$alternate_fields = ['pa_alternate_version_1', 'pa_alternate_version_2', 'pa_alternate_version_3', 'pa_alternate_version_4'];

foreach ( $alternate_fields as $field ) {
  $names_arr = array_column( wc_get_product_terms($product->get_ID(), $field), 'name' );
  
  if ( !empty($names_arr) ) {
    foreach ( $names_arr as $name ) {
      if ( strtolower($name) !== 'none' ) 
        $alternate_versions[] = $name;
    }
  }
}

$alternate_versions = implode( ', ', $alternate_versions );


// Applications
$applications = implode( ', ', array_column(wc_get_product_terms(get_the_ID(), 'pa_primary_industry'), 'name') );
$recommended_for = implode( ', ', array_column(wc_get_product_terms(get_the_ID(), 'pa_recommended_industry'), 'name') );
$available_sizes = implode( ', ', array_column(wc_get_product_terms(get_the_ID(), 'pa_available_sizes'), 'name') );

$unit_of_measure = implode(', ', array_column(wc_get_product_terms(get_the_ID(), 'pa_unit_of_measure'), 'name'));
$country_of_origin = implode(', ', array_column(wc_get_product_terms(get_the_ID(), 'pa_country_of_origin'), 'name'));

$sold_in_multiples = get_post_meta($product->get_ID(), 'sold_in_multiples', true);
$case_quantity = get_post_meta($product->get_ID(), 'case_quantity', true);
$features_and_technology = array_column(wc_get_product_terms(get_the_ID(), 'pa_features_and_technology'), 'name');

$features_and_technology = array_diff($features_and_technology, ['None']);
$laundering_instructions = array_column(wc_get_product_terms(get_the_ID(), 'pa_laundering_instructions'), 'name');
$laundering_instructions = array_diff($laundering_instructions, ['None']);

$chem_dispos_gloves_length = array_column(wc_get_product_terms(get_the_ID(), 'pa_chem_dispos_gloves_length'), 'name');
$chem_dispos_gloves_length = array_diff($chem_dispos_gloves_length, ['None']);


$p65 = false;

if ( get_post_meta($product->get_id(), '_p65_product', true) == 'yes' ) {
  $p65 = true;
  $icon_path = get_template_directory_uri() . '/img/products_messages/p65_warning.jpg';
}


$kevlar_icon = supro_get_product_kevlar_icon();


$material = wc_get_product_terms( $product->get_ID(), 'pa_material' );
$material_icon = false;
$material_description = false;

if ( count($material) ) {
  $material_description = $material[0]->description;
  $files = scandir( './wp-content/themes/supglove/img/product_attribute_icons/' );

  foreach ( $files as $file ) {
    if ( strstr($file, $material[0]->slug) ) {
      $material_icon = get_template_directory_uri() . '/img/product_attribute_icons/' . $file;
    }
  }
}


$is_sample_box = get_post_meta( $product->get_id(), 'sg_sample_box_marker', true );
$box_products = null;
$box_products_title = '';
$cta_is_hidden = true;
$cta_title = '';
$cta_content = '';
$cta_button_text = '';

if ( $is_sample_box ) {
  $classes[] = 'sample-box';
  
  // Products section
  $box_products_title = get_post_meta( $post_id, 'sg_sample_box_products_section_title', true );
  //$box_products = array_filter( array_map( 'wc_get_product', $product->get_children() ), 'wc_products_array_filter_visible_grouped' );
  $box_products = get_post_meta( $product->get_id(), 'sg_sample_box_products' );

    if ( empty($box_products) ) {
    $box_products = null;
  }


  // Call to Action section
  $cta_is_hidden = get_post_meta( $product->get_id(), 'sg_sample_box_cta_section_hide', true );

  if ( empty($cta_is_hidden) ) {
    $cta_title = get_post_meta( $product->get_id(), 'sg_sample_box_cta_section_title', true );
    $cta_content = get_post_meta( $product->get_id(), 'sg_sample_box_cta_section_text', true );
    $cta_button_text = get_post_meta( $product->get_id(), 'sg_sample_box_cta_section_button_text', true );
  }
  
  if ( empty($cta_button_text) || ( is_string($cta_button_text) && trim($cta_button_text) == '' ) ) {
    $cta_button_text = $product->add_to_cart_text();
  }
  
  if ( empty($box_products_title) || ( is_string($box_products_title) && trim($box_products_title) == '' ) ) {
    $box_products_title = __( "What's in the Box" , 'SuperiorGlove' );
  }
}
?>
  <?php if ( !$is_sample_box ) : ?>
	<?php if ( array_key_exists( 'action', $_GET ) && !empty($_GET['action']) && $_GET['action'] == 'print' ) : ?>
	<style>
		:root {
		  --color-sgw-grey: #939396;
		}

		@page {
		  size: A4;
		  margin: 0;
		  margin-top: 0;
		  margin-bottom: 0;
		}

		html {
		  margin-top: 0  !important;
		}

		.sgw-grey {
		  color: var(--color-sgw-grey) !important;
		}

		body {
		  padding: 4rem 0;
		  padding: 0;
		  min-height: 100px;
		  min-width: 100px;
		  -webkit-print-color-adjust:exact !important;
		  print-color-adjust:exact !important;
		}

		body > div {
		  display: none;
		}

		body #page {
		  display: block;
		}

		#page > * {
		  display: none;
		}

		#page #content, #page #content .container {
		  display: block;
		}

		#wpseo-frontend-inspector, #wpseo-frontend-inspector *, #wpseo-frontend-inspector > *, #wpseo-frontend-inspector section {
		  display: none !important;
		  border-bottom: none !important;
		  border-bottom-color: transparent !important;
		}

		#masthead,
		#colophon.site-footer {
		  display: none;
		}

		.single-product .site-content {
		  background-color: transparent;
		}

		#primary-print {
		  display: block;
		  width: 720px;
		  margin: 0 auto;
		  padding-top: 40px;
		  padding-bottom: 40px;
		}

		#primary-print .second-print-page {
		  page-break-before: always;
		  margin-top: 140px;
		}

		#primary-print .second-print-page .product-info-table {
		  padding: 0;
		  margin-bottom: 36px;
		}

		#primary-print .second-print-page .product-info-table .product-info-table__subtitle {
		  font-size: 10px;
		  margin-bottom: 12px;
		  line-height: 1;
		}

		#primary-print .second-print-page .table-wrapper table tr td {
		  font-size: 8px;
		  padding: 2px 12px;
		}

		#primary-print .second-print-page .fitsizingTab {
		  display: flex;
		  width: 100%;
		  gap: 20px;
		  align-items: center;
		}

		#primary-print .second-print-page .fitsizingTab .sleevespecspic {
		  margin: unset;
		}

		#primary-print .second-print-page .fitsizingTab .col {
		  padding: 0 !important;
		  float: unset !important;
		}

		#primary-print .second-print-page .fitsizingTab .col.col-md-6 {
		  max-width: 400px !important;
		}

		#primary-print .second-print-page .fitsizingTab h6,
		#primary-print .second-print-page .fitsizingTab p {
		  font-size: 10px;
		  margin: 0;
		}

		#primary-print .second-print-page .fitsizingTab p {
		  margin: 12px 0;
		  line-height: 1;
		}

		#primary-print .fitsizingTab .col img {
		  max-width: 80% !important;
		  width: 100% !important;
		  height: auto;
		  margin: 0 !important;
		}

		#primary-print .header .title {
		  display: flex;
		  font-size: 16pt;
		  font-weight: 700;
		color: #000;
		}

		#primary-print .header .title .brand {
		  padding-right: 12px;
		  border-right: 3px solid #fd8541 !important;
		}

		#primary-print .header .title .sku {
		  padding-left: 12px;
		}

		#primary-print .header .description-short {
		  font-size: 12pt;
		  padding-top: 6px;
		}

		#primary-print .header {
		  border-bottom: 1px solid var(--color-sgw-grey);
		  padding-bottom: 12px;
		  position: fixed;
		  width: inherit;
		  top: 40px;
		  position: relative;
		  top: 0;
		}

		#primary-print .gallery {
		  display: flex;
		  gap: 30px;
		  padding-top: 40px;
		  margin: 0;
		}

		#primary-print .gallery .image-wrapper {
		  max-width: 50%;
		  height: auto;
		}

		#primary-print .icons {
		  border-bottom: 1px solid var(--color-sgw-grey);
		  margin: 20px 0 0 0;
		}

		#primary-print .description {
		  display: flex;
		  gap: 30px;
		  font-size: 8pt;
		  margin-top: 20px;
		}

		#primary-print .description .col {
		  flex-grow: 1;
		  flex-basis: 0;
		}

		#primary-print .description .col p {
		  margin: 0 0 6px 0;
		  line-height: 1.2;
		  color: var(--color-sgw-grey) !important;
		}

		#primary-print .description .col-title {
		  text-transform: uppercase;
		  font-weight: 700;
		  line-height: 1.2;
		  margin-bottom: 6px;
			color: #000;
		}

		#primary-print .description .specs p {
		  text-transform: uppercase;
		}

		#primary-print .description .spec-with-title {
		  display: flex;
		  justify-content: space-between;
		}

		#primary-print .description .col .col-title {
		  margin-top: 12px;
		}

		#primary-print .description .col .col-title:first-of-type {
		  margin-top: 0;
		}

		#primary-print .footer {
		  border-top: 1px solid var(--color-sgw-grey) !important;
		  margin-top: 20px;
		  display: flex;
		  gap: 18px;
		  justify-content: space-between;
		  padding-top: 20px;
		  /* fixed to bottom */
		  position: fixed;
		  bottom: 4rem;
		  width: inherit;
		  position: relative;
		  bottom: 0;
		}

		#primary-print .footer p {
		  margin: 0;
		  line-height: 1.5;
		  font-size: 8pt;
		  color: var(--color-sgw-grey) !important;
		}

		#primary-print .footer img {
		  height: auto;
		}

		#primary-print .warning-message {
		  align-items: center;
		  margin-top: 20px;
		}

		#primary-print .warning-message p {
		  color: var(--color-sgw-grey) !important;
		  margin: 0 !important;
		  max-width: calc(60% - 36px) !important;
		  line-height: 1.2;
		  font-size: 8pt;
		}

		#primary-print .description .col .warning-message p {
		  max-width: calc(100% - 36px) !important;
		}

		#primary-print .glovelabels {
		  margin: 0 !important;
		  padding-bottom: 10px;
		  gap: 12px;
		}

		#primary-print .glovelabels li {
		  padding: 0;
		}

		#primary-print .glovelabels li img {
		  max-height: 44px !important;
		  width: auto;
		}

		#primary-print .material-section {
		  margin-top: 30px;
		}

		#primary-print .material-section img {
		  max-width: 100px !important;
		}

		#primary-print .material-section p {
		  max-width: 60% !important;
		  font-size: 8pt;
		  color: var(--color-sgw-grey) !important;
		  line-height: 1.2;
		}

		#primary-print .description .col .material-section {
		  margin-top: 12px;
		}

		#primary-print .description .col .material-section img {
		  width: auto;
		  float: left;
		  margin: 0 5px 5px 0;
		}

		#primary-print .description .col .material-section p {
		  max-width: 100% !important;
		}

		#primary-print .description-short p {
		  font-size: 12pt;
		  min-height: 40px;
		  margin-bottom: 0;
		  line-height: 1.2;
		  color: var(--color-sgw-grey) !important;
		}

		#primary-print .description_image{
		  /*display: none;*/
		  /*width:100%;*/
		  margin-bottom: 100px;
		  height: auto;
		  margin-top: 10px;
		}

		#primary-print .description_image img{
		  max-height: 180px;
		}
		
		#primary-print .kevlar_icon {
		  position: absolute;
		  width: 70px;
		  right: 7px;
		  bottom: 10px;
		  z-index: 1;
		}

		#primary-print .kevlar_icon_wrapper{
		  position: relative;
		}
	</style>
	<?php endif; ?>
    <div id="primary-print">
      <div class="header">
        <div class="title">
          <div class="brand"><?= $product_name ?></div>
          <div class="sku"><?= $sku ?></div>
        </div>

        <div class="dsgw-grey description-short "><p><?php echo esc_html( $subtitle ); ?></p></div>
      </div>

      <div class="gallery">
        <div class="image-wrapper kevlar_icon_wrapper">
          <img src="<?= $image1 ?>" alt="<?= $name ?> image">

          <?php if ($kevlar_icon) : ?>
            <div class="kevlar_icon"><? echo $kevlar_icon ?></div>
          <?php endif ?>
        </div>

        <div class="image-wrapper">
          <img src="<?= $image2 ?>" alt="<?= $name ?> image">
        </div>
      </div>

      <div class="icons">
		   <?php do_action('woocommerce_single_product_print_icons'); ?>
		</div>

      <div class="description">
        <div class="col">
          <div class="col-title">About The Product</div>

          <?php echo apply_filters('the_content', $product->get_short_description()) ?>

          <?php if (($material_description || $material_icon) && $image3) : ?>
            <div class="material-section">
              <div class="col-title">Materials</div>

              <?php if ($material_icon) : ?>
                <img src="<?= $material_icon ?>">
              <?php endif ?>

              <?php if ($material_description) : ?>
                <p><?= $material_description ?></p>
              <?php endif ?>
            </div>
          <?php endif ?>

          <?php if ($image3 && $p65) : ?>
            <div class="p65-warning">
              <div class="warning-message">
                <img src="<?= $icon_path ?>" alt="P65 Warning" width="24">
                <p><?= strip_tags(get_option('p65_warning')) ?></p>
              </div>
            </div>
          <?php endif ?>
        </div>

        <div class="col specs">
          <?php if (strlen($alternate_versions)) : ?>
            <div class="col-title">Alternative Versions</div>
            <p><?= $alternate_versions ?></p>
          <?php endif ?>

          <?php if (strlen($applications)) : ?>
            <div class="col-title">Applications</div>
            <p><?= $applications ?></p>
          <?php endif ?>

          <?php if (strlen($recommended_for)) : ?>
            <div class="col-title">Recommended For</div>
            <p><?= $recommended_for ?></p>
          <?php endif ?>

          <?php if (strlen($available_sizes)) : ?>
            <div class="col-title">Available Sizing</div>
            <p><?= $available_sizes ?></p>
          <?php endif ?>
        </div>

        <div class="col">
          <div class="col-title">Shipping And Packaging</div>

          <?php if (strlen($unit_of_measure)) : ?>
            <div class="spec-with-title">
              <p>Unit of Measure</p>
              <p><?= $unit_of_measure ?></p>
            </div>
          <?php endif ?>

          <?php if (strlen($sold_in_multiples)) : ?>
            <div class="spec-with-title">
              <p>Sold in Multiples of</p>
              <p><?= $sold_in_multiples ?></p>
            </div>
          <?php endif ?>

          <?php if (strlen($case_quantity)) : ?>
            <div class="spec-with-title">
              <p>Case Quantity</p>
              <p><?= $case_quantity ?></p>
            </div>
          <?php endif ?>

          <?php if (strlen($country_of_origin)) : ?>
            <div class="spec-with-title">
              <p>Country of Origin</p>
              <p><?= $country_of_origin ?></p>
            </div>
          <?php endif ?>

          <?php if (count($features_and_technology)) : ?>
            <div class="col-title">Features And Tech</div>

            <?php foreach ($features_and_technology as $fnt) : ?>
              <div class="spec-with-title">
                <p><?= $fnt ?></p>
                <p>Yes</p>
              </div>
            <?php endforeach ?>
          <?php endif ?>

          <?php if (count($laundering_instructions)) : ?>
            <div class="col-title">Laundering Instructions</div>

            <?php foreach ($laundering_instructions as $lin) : ?>
              <div class="spec-with-title">
                <p><?= $lin ?></p>
              </div>
            <?php endforeach ?>
          <?php endif ?>

          <?php if (!empty($chem_dispos_gloves_length)) : ?>
            <div class="col-title">Chemical Glove Length</div>

            <?php foreach ($chem_dispos_gloves_length as $lnghh) : ?>
              <div class="spec-with-title">
                <p><?= $lnghh ?></p>
              </div>
            <?php endforeach ?>
          <?php endif ?>

          <?php if ($image3) : ?>
            <div class="description_image">
              <div class="image-wrapper">
                <img src="<?= $image3 ?>" alt="<?= $name ?> image">
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <?php if ( ($material_description || $material_icon) && !$image3 ) : ?>
        <div class="material-section">
          <?php if ($material_icon) : ?>
            <img src="<?= $material_icon ?>" />
          <?php endif ?>

          <?php if ($material_description) : ?>
            <p><?= $material_description ?></p>
          <?php endif ?>
        </div>
      <?php endif ?>

      <?php if ( $p65 && !$image3 ) : ?>
        <div class="p65-warning">
          <div class="warning-message">
            <img src="<?= $icon_path ?>" alt="P65 Warning" width="24" />
            <p><?= strip_tags(get_option('p65_warning')) ?></p>
          </div>
        </div>
      <?php endif ?>

      <?php if ( tableExists() ) : ?>
        <div class="second-print-page">
          <?= renderTable(false); ?>
          <?php
            $product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
            $product_tab = $product_tabs['fitsizing_tab'];

            if ( !empty( $product_tab ) && isset( $product_tab['callback'] ) ) {
              echo '<div class="fitsizingTab">';
                call_user_func( $product_tab['callback'], 0, $product_tab );
              echo '</div>';
            }
          ?>
        </div>
      <?php endif ?>

      <div class="footer">
        <div class="col">
          <p>USA, Canada, Mexico Sales</p>
          <p>business.development@superiorglove.com</p>
          <p>800-265-7617 / 519-853-1920</p>
        </div>

        <div class="col">
          <p>International Sales</p>
          <p>international@superiorglove.com</p>
          <p>Date printed: <?= date('m/d/Y'); ?></p>
        </div>

        <div class="col">
          <img src="<?= get_template_directory_uri() . '/img/logomobile.svg'; ?>" />
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php if ( $is_sample_box || !array_key_exists( 'action', $_GET ) || empty($_GET['action']) || $_GET['action'] != 'print' ) : ?>
  <div id="product-<?php echo esc_attr( $product->get_ID() ); ?>" <?php wc_product_class( $classes, $product ); ?>>
    <div class="supro-single-product-detail">
      <?php if ( isset( $product_layout ) && !empty( $product_layout ) && !in_array( $product_layout, array('5', '6') ) ) : ?>
        <div class="container">
      <?php endif; ?>

          <?php do_action('supro_before_single_product'); ?>

          <div class="product-images-wrapper">
            <?php
            /**
             * woocommerce_before_single_product_summary hook.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
          </div>

          <div class="product-summary">
            <div class="summary entry-summary">
              <?php the_title( '<h4 class="product_title entry-title">', '</h4>' ); ?>

              <?php if ( !empty($subtitle) ) : ?>
                <p class="lead"><?php echo esc_html( $subtitle ); ?></p>
              <?php endif; ?>

              <?php
              /**
               * woocommerce_single_product_summary hook.
               *
               * @hooked woocommerce_template_single_title - 5
               * @hooked woocommerce_template_single_rating - 10
               * @hooked woocommerce_template_single_price - 10
               * @hooked woocommerce_template_single_excerpt - 20
               * @hooked woocommerce_template_single_add_to_cart - 30
               * @hooked woocommerce_template_single_meta - 40
               * @hooked woocommerce_template_single_sharing - 50
               * @hooked WC_Structured_Data::generate_product_data() - 60
               */
              remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
              do_action('woocommerce_single_product_summary');
              ?>
            </div>
          </div><!-- .summary -->

      <?php if ( isset( $product_layout ) && !empty( $product_layout ) && !in_array( $product_layout, array('5', '6') ) ) : ?>
          <div class="clear"></div>
        </div>
      <?php endif; ?>
    </div>

    <div class="clear"></div>
  </div>

</div>
</div>
</div>
</div>

<div class="bottomsingle-product<?php echo ( $is_sample_box ? ' sample-box' : '' ); ?>">
  <div>
    <div>

      <?php if ( $is_sample_box && !empty($box_products) && is_array($box_products) ) : ?>
        <div class="product-box">
          <div class="container">
            <h2 class="sample-box__products-title"><?php echo esc_textarea( $box_products_title ); ?></h2>

            <div class="sg-new-products sg-new-products--layout-columns-2 sg-new-products--columns-3 sg-new-products--sample-box">
              <?php
                foreach ( $box_products as $box_product_id ) {
                  $box_product = wc_get_product( $box_product_id );

                  if ( !empty($box_product) ) {
                    $box_product_permalink = $box_product->get_permalink( $box_product_id );
                    
                    get_template_part( 'inc/shortcodes/sg/sg-featured-product', null, array(
                      'featured_product' => $box_product,
                      'title' => '',
                      'subtitle' => '',
                      'layout' => 'columns-2',
                      'hide_add_to_cart' => false,
                      'show_product_id' => true,
                      'add_to_cart_link' => ( !empty($box_product_permalink) ? $box_product_permalink : '' ),
                      'add_to_cart_text' => false,
                      'add_to_cart_target' => '_blank',
                    ) );
                  }
                }
              ?>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <?php 
        if ( !$is_sample_box ) {
			?>
		<div>
        <div class="product">
          <div class="container">
            <?php
            /**
             * woocommerce_after_single_product_summary hook.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            do_action('woocommerce_after_single_product_summary');
            ?>

            <meta content="<?php the_permalink(); ?>"/>
          </div>
        </div><!-- #product-<?php the_ID(); ?> -->
      </div>
		<?php
          wc_get_template('single-product/product-compare.php'); 
        }
      ?>
      
      <?php if ( $is_sample_box && !$cta_is_hidden && (!empty($image1) || !empty($cta_title) || !empty($cta_content)) ) : ?>
        <div class="sample-box-cta">
          <div class="container">
            <div class="row">
              <?php if ( !empty($image1) ) : ?>
                <div class="sample-box-cta-featured-image-wrapper col-md-6">
                  <img class="sample-box-cta-featured-image" src="<?php echo esc_url($image1); ?>" />
                </div>
              <?php endif; ?>

              <div class="sample-box-cta-summary<?php if ( !empty($image1) ) : ?> col-md-6<?php endif; ?>">
                <?php if ( !empty($cta_title) ) : ?>
                  <h2 class="sample-box-cta-title"><?php echo esc_textarea( $cta_title ); ?></h2>
                <?php endif; ?>

                <?php if ( !empty($cta_content) ) : ?>
                  <div class="sample-box-cta-content">
                    <?php echo esc_textarea( $cta_content ); ?>
                  </div>
                <?php endif; ?>

                <div class="sample-box-cta-add-to-cart-form">
                  <?php do_action( 'woocommerce_' . $product->get_type() . '_add_to_cart' ); ?>
                </div>
              </div>
            </div>
          </div>
        </div><!-- .sample-box__cta -->
      <?php endif; ?>

      <?php
      add_action('woocommerce_after_single_product_summary_2', 'woocommerce_upsell_display', 15);
      add_action('woocommerce_after_single_product_summary_2', 'woocommerce_output_related_products', 20);
      do_action('woocommerce_after_single_product_summary_2');
      ?>

      <?php if (intval(supro_get_option('product_cta'))) : 
        $product_cta_title = wp_kses_post( supro_get_option('product_cta_title') );
        $product_cta_title_color = wp_kses_post( supro_get_option('product_cta_title_color') );
        $product_cta_subtitle = wp_kses_post( supro_get_option('product_cta_subtitle') );
        $product_cta_subtitle_color = wp_kses_post( supro_get_option('product_cta_subtitle_color') );
        $product_cta_buttontext = wp_kses_post( supro_get_option('product_cta_buttontext') );
        $product_cta_buttonurl = wp_kses_post( supro_get_option('product_cta_buttonurl') );
        $product_cta_button_color = wp_kses_post( supro_get_option('product_cta_button_color') );

        $ctabackground = supro_get_option( 'ctabackground' );
        $product_cta_bck_color = wp_kses_post( supro_get_option('product_cta_bck_color') );
        $thebackstyles = "";

        if ( $ctabackground !== '' ) 
          $thebackstyles .= ' background-image: url(' . $ctabackground . '); ';

        if ( $product_cta_bck_color !== '' ) 
          $thebackstyles .= ' background-color: ' . $product_cta_bck_color . '; ';

        if ( $ctabackground !== '' || $product_cta_bck_color !== '' ) 
          $thestyle = 'style="' . $thebackstyles . '"';
      ?>
        <div class="single-product-cta" <?php echo $thestyle; ?> >
          <div class="container">
            <?php if ( $product_cta_title !== '' ) :
              $prottilecolor = ( ($product_cta_title_color !== '') ? ' style = "color:' . $product_cta_title_color . '"' : '' );
            ?>
              <h2 class="ctatitle"<?php echo $prottilecolor; ?>><?php echo $product_cta_title; ?></h2>
            <?php endif; ?>

            <?php if ( $product_cta_subtitle !== '' ) :
              $subttilecolor = ( ($product_cta_subtitle_color !== '')  ? ' style= "color:' . $product_cta_subtitle_color . '"' : '');
            ?>
              <p class="subtitle lead"<?php echo $subttilecolor; ?>><?php echo $product_cta_subtitle; ?></p>
            <?php endif; ?>

            <?php if ( $product_cta_buttonurl !== '' && $product_cta_buttontext !== '' ) : 
              $butcolorcolor = ( ($product_cta_button_color !== '') ? ' style= "background-color:' . $product_cta_button_color . '"' : '' );
            ?>
              <a 
                href="<?php echo $product_cta_buttonurl; ?>" 
                class=" buttonogs btn_large btn_theme_color"<?php echo $butcolorcolor; ?>><?php 
                  echo $product_cta_buttontext; 
              ?></a>
            <?php endif; ?>
          </div>
        </div>

        <div class="clear"></div>
      <?php endif; ?>

      <?php do_action('woocommerce_after_single_product'); ?>
<?php endif; ?>