<?php

/**
 * @package Supglove
 */

if ( !empty($args['new_products']) ) : 
  $i = 0;
  $products_count = count( $args['new_products'] );
  
  if ( empty($args['layout']) ) {
    $args['layout'] = 'default';
  }
  
  if ( !empty($args['hide_add_to_cart']) && ($args['hide_add_to_cart'] === true || $args['hide_add_to_cart'] === 1) ) {
    $args['hide_add_to_cart'] = true;
  } else {
    $args['hide_add_to_cart'] = false;
  }
  
  if ( !empty($args['show_product_id']) && ($args['show_product_id'] === true || $args['show_product_id'] === 1) ) {
    $args['show_product_id'] = true;
  } else {
    $args['show_product_id'] = false;
  }
  
  $columns = 3;
  
  if ( count($args['new_products']) % 4 == 0 )  {
    $columns = 4;
  }
?>
  <div class="sg-new-products sg-new-products--layout-<?php 
    echo $args['layout'] . ( ($args['layout'] == 'columns') ? ' sg-new-products--columns-' . $columns : '' ); 
  ?>">
    <?php 
      foreach ($args['new_products'] as $product ) {
        $i++; 
        
        get_template_part( 'inc/shortcodes/sg/sg-featured-product', null, array(
          'featured_product' => $product,
          'layout' => $args['layout'],
          'hide_add_to_cart' => $args['hide_add_to_cart'],
          'show_product_id' => $args['show_product_id']
        ) );
        
        if ( $i < $products_count && $args['layout'] !== 'columns' ) {
          echo '<div class="sg-new-products__divider sg-new-products__divider--layout-'. $args['layout'] .'"></div>';
        }
      } 
    ?>
  </div>
<?php 
endif; 
?>