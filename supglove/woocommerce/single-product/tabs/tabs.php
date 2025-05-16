<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) {
  $new_tabs = array();
  
  foreach ( $product_tabs as $key => $product_tab ) {
    $tab_content = '';

    ob_start();
    if ( isset( $product_tab['callback'] ) ) {
      call_user_func( $product_tab['callback'], $key, $product_tab );
    }
    $tab_content = ob_get_clean();
    
    if ( !empty($tab_content) ) {
      $new_tabs[] = array(
        'tab_key' => $key,
        'tab_title' => ( isset($product_tab['title']) ? $product_tab['title'] : 'Tab' ),
        'tab_content' => $tab_content
      );
    }
  }
}

if ( ! empty( $new_tabs ) ) : 
  $product_cats = array();
  $terms = get_the_terms($product->ID, 'product_cat');

  if ( !is_wp_error($terms) && !empty($terms) ) {
    foreach ( $terms as $term ) {
      $product_cats[] = $term->slug;
    }
  }

  $product_cats = implode( ' ', $product_cats );
  
  if ( $product_cats !== '' ) {
    $product_cats = ' ' . $product_cats;
  }
?>
	<div class="newtabs clearfix horizontal minimal_style<?php echo $product_cats; ?>">
		<ul class="resp-tabs-list movtabstop">
			<?php foreach ( $new_tabs as $new_tab ) : ?>
				<li 
          id="tab-title-<?php echo esc_attr( $new_tab['key'] ); ?>" 
          class="<?php echo esc_attr( $new_tab['key'] ); ?>_tab" 
          role="tab" 
          aria-controls="tab-<?php echo esc_attr( $new_tab['key'] ); ?>"
        >
					<div class="anhc">
						<?php 
              echo wp_kses_post( apply_filters( 
                'woocommerce_product_' . $new_tab['key'] . '_tab_title', 
                $new_tab['tab_title'], 
                $new_tab['key'] 
              ) ); ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		<div class="resp-tabs-container ">
      <?php foreach ( $new_tabs as $new_tab ) : ?>
        <div 
          id="tabnew-<?php echo esc_attr( $new_tab['key'] ); ?>" 
          class="new-tabs-container tabct-<?php echo esc_attr( $new_tab['key'] ); ?>" 
          role="tabpanel" 
          aria-labelledby="tab-title-<?php echo esc_attr( $new_tab['key'] ); ?>"
        >
          <?php echo wp_kses_post( $new_tab['tab_content'] ); ?>
        </div>
      <?php endforeach; ?>
		</div>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>
<?php endif; ?>