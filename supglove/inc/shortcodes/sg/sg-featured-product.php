<?php

/**
 * @package Supglove
 */

if ( !empty($args['featured_product']) ) : 
  global $wpdb;
  
  $product = $args['featured_product'];
  $short_description = get_post_meta( $product->get_id(), '_bhww_prosubtitle', true );
  $description = apply_filters( 'the_content', $product->get_short_description() );
  $enquired_product = get_post_meta($product->get_id(), '_enquired_product', true) == 'yes';

  $image_1 = '';
  $image_2 = '';
  $image_3 = '';
  
  $image_1_id = $product->get_image_id();
  if ( $image_1_id ) {
    $image_1 = wp_get_attachment_image( $image_1_id, 'full', 'false', array('class' => 'sg-featured-product__image') );
  }
  
  $gallery = $product->get_gallery_image_ids();
  if ( !empty($gallery[0]) ) {
    $image_2 = wp_get_attachment_image( $gallery[0], 'full', 'false', array('class' => 'sg-featured-product__image') );
  }
  if ( !empty($gallery[1]) ) {
    $image_3 = wp_get_attachment_image( $gallery[1], 'full', 'false', array('class' => 'sg-featured-product__image') );
  }
  
  $material_icon_urls = array();
  
  $attributes = array(
    'cut', 'abrasion', 'arch_flash', 'hazards_cold', 'hazards_heat', 'impact', 'puncture_probe', 
    'hypodermic_needle', 'flame', 'crush', 'vibration', 'features_and_technology', 
    'ce_en388_certification_code', 'other_ce_certification_codes' 
  );
  $all_attributes = $product->get_attributes();
  
  foreach ( $attributes as $attribute ) {
    if ( empty($all_attributes['pa_'. $attribute]) ) {
      continue;
    }
    
    $attribute_slugs = $all_attributes['pa_'. $attribute]->get_slugs();
    
    if ( !empty($attribute_slugs) ) {
      foreach ( $attribute_slugs as $attribute_value ) {
        $icon_path = '/img/product_attribute_icons/'. $attribute .'/'. $attribute_value .'.png';
        
        $icon_root_path = get_template_directory() .'/'. $icon_path;
        $icon_uri_path = get_template_directory_uri() .'/'. $icon_path;
        
        if ( file_exists($icon_root_path) ) {
          $material_icon_urls[] = $icon_uri_path .'?'. time();
        }
      }
    }
  }
  
  $additional_icons = explode( '|', get_post_meta($product->get_id(), 'supglove_icons', true) );
  
  if ( $additional_icons ) {
    foreach ( $additional_icons as $icon ) {
      $attachment_name = sanitize_title( $icon );
      $icon_id = $wpdb->get_results( $wpdb->prepare( 
        "SELECT * FROM wpilce_posts ps WHERE ps.post_type = 'attachment' AND ps.post_name = '%s'", $attachment_name 
      ) );
			
      if( !empty($icon_id[0]) && !empty($icon_id[0]->ID) ) {
        $icon_attributes = wp_get_attachment_image_src( $icon_id[0]->ID, 'full');
        
        if ( !empty($icon_attributes[0]) ) {
          $material_icon_urls[] = $icon_attributes[0] .'?'. time();
        }
      }
    }
  }
  
  if ( empty($args['layout']) ) {
    $args['layout'] = 'default';
  }
  
  if ( !empty($args['title'] ) ) {
    $product_title = $args['title'];
  } else if ( !empty($product->name) ) {
    $product_title = $product->name;
  } else {
    $product_title = '';
  }
  
  if ( !empty($args['subtitle'] ) ) {
    $product_subtitle = $args['subtitle'];
  } else {
    $product_subtitle = '';
  }
  
  if ( !empty($args['hide_add_to_cart']) && ($args['hide_add_to_cart'] === true || $args['hide_add_to_cart'] === 1) ) {
    $args['hide_add_to_cart'] = true;
  } else {
    $args['hide_add_to_cart'] = false;
  }
  
  if ( !empty($args['show_product_id']) && ($args['show_product_id'] === true || $args['show_product_id'] === 1) ) {
    $args['show_product_id'] = true;
    
    $sku = $product->get_sku();
  } else {
    $args['show_product_id'] = false;
    $sku = null;
  }
  
  if ( !empty($args['learn_more_link']) && ($args['learn_more_link'] === true || $args['learn_more_link'] === 1) ) {
      $args['learn_more_link'] = true;
  } else {
      $args['learn_more_link'] = false;
  }
?>
  <div class="sg-featured-product sg-featured-product--layout-<?php echo esc_attr( $args['layout'] ); ?>">
    <div class="sg-featured-product__inner-wrapper sg-featured-product__inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
      <?php if ( 
        $image_1 || $image_2 || $image_3 || (!empty($material_icon_urls) && $args['layout'] != 'columns' && $args['layout'] != 'columns-2') 
      ) : ?>
        <div class="sg-featured-product__gallery sg-featured-product__gallery--layout-<?php echo esc_attr( $args['layout'] ); ?>">
          <div class="sg-featured-product__gallery-inner-wrapper sg-featured-product__gallery-inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
          
            <?php if ( $image_1 || (($image_2 || $image_3) && $args['layout'] != 'columns') ) : ?>
              <div class="sg-featured-product__images sg-featured-product__images--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                <?php if ( $image_1 ) : ?>
                  <div class="sg-featured-product__image-wrapper sg-featured-product__image-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                    <div class="sg-featured-product__image-inner-wrapper sg-featured-product__image-inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                      <?php echo $image_1; ?>
                    </div>
                  </div>
                <?php endif; ?>
                
                <?php if ( $image_2 && $args['layout'] != 'columns' ) : ?>
                  <div class="sg-featured-product__image-wrapper sg-featured-product__image-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                    <div class="sg-featured-product__image-inner-wrapper sg-featured-product__image-inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                      <?php echo $image_2; ?>
                    </div>
                  </div>
                <?php endif; ?>
                
                <?php if ( $image_3 && $args['layout'] != 'columns' && $args['layout'] != 'columns-2' ) : ?>
                  <div class="sg-featured-product__image-wrapper sg-featured-product__image-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                    <div class="sg-featured-product__image-inner-wrapper sg-featured-product__image-inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                      <?php echo $image_3; ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <?php if ( !empty($material_icon_urls) && $args['layout'] != 'columns' && $args['layout'] != 'columns-2' ) : ?>
              <div class="sg-featured-product__icons sg-featured-product__icons--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                <?php foreach ( $material_icon_urls as $icon_url ) : ?>
                  <div class="sg-featured-product__icon-wrapper sg-featured-product__icon-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                    <div class="sg-featured-product__icon-inner-wrapper sg-featured-product__icon-inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                      <img 
                        class="sg-featured-product__icon sg-featured-product__icon--layout-<?php echo esc_attr( $args['layout'] ); ?>" 
                        src="<?php echo esc_url( $icon_url ); ?>" 
                      />
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          
          </div>
        </div>
      <?php endif; ?>
      
      <div class="sg-featured-product__info sg-featured-product__info--layout-<?php echo esc_attr( $args['layout'] ); ?>">
        <div class="sg-featured-product__info-inner-wrapper sg-featured-product__info-inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
          <?php if ( $product_title || $product_subtitle ) : ?>
            <h3 class="sg-featured-product__name sg-featured-product__name--layout-<?php echo esc_attr( $args['layout'] ); ?>"><?php 
              if ( $product_subtitle ) : 
                ?><span class="sg-featured-product__subtitle sg-featured-product__subtitle--layout-<?php echo esc_attr( $args['layout'] ); ?>"><?php 
                  echo esc_html( $product_subtitle ); 
                ?></span><?php 
              endif; 
            ?><?php 
              if ( $product_title ) : 
                ?><span class="sg-featured-product__title sg-featured-product__title--layout-<?php echo esc_attr( $args['layout'] ); ?>"><?php 
                  echo esc_html( $product_title ); 
                ?></span><?php 
              endif; 
            ?></h3>
          <?php endif; ?>
          
          <?php if ( $sku ) : ?>
            <div class="sg-featured-product__product-id sg-featured-product__product-id--layout-<?php echo esc_attr( $args['layout'] ); ?>">
              <?php printf( esc_html( __('Product ID: %s', 'SuperiorGlove') ), $sku ); ?>
            </div>
          <?php endif; ?>
          
          <?php if ( $short_description ) : ?>
            <div class="sg-featured-product__short-description sg-featured-product__short-description--layout-<?php echo esc_attr( $args['layout'] ); ?>">
              <?php echo wp_kses_post( $short_description ); ?>
            </div>
          <?php endif; ?>

          <?php if ( $description && $args['layout'] != 'columns' && $args['layout'] != 'columns-2' ) : ?>
            <div class="sg-featured-product__description sg-featured-product__description--layout-<?php echo esc_attr( $args['layout'] ); ?>">
              <?php echo wp_kses_post( $description ); ?>
            </div>
          <?php endif; ?>
            
            <?php if ( $args['learn_more_link'] ) : ?>
            <p>
                <a href="<?php the_permalink($product->get_id()); ?>" target="_blank" style="color: #fd8541;text-decoration: underline"><?php esc_html_e( 'Learn More', 'supro' ); ?></a>
            </p>
            <?php endif; ?>
          
          <?php if ( !empty($material_icon_urls) && ($args['layout'] == 'columns' || $args['layout'] == 'columns-2') ) : ?>
            <div class="sg-featured-product__icons sg-featured-product__icons--layout-<?php echo esc_attr( $args['layout'] ); ?>">
              <?php foreach ( $material_icon_urls as $icon_url ) : ?>
                <div class="sg-featured-product__icon-wrapper sg-featured-product__icon-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                  <div class="sg-featured-product__icon-inner-wrapper sg-featured-product__icon-inner-wrapper--layout-<?php echo esc_attr( $args['layout'] ); ?>">
                    <img 
                      class="sg-featured-product__icon sg-featured-product__icon--layout-<?php echo esc_attr( $args['layout'] ); ?>" 
                      src="<?php echo esc_url( $icon_url ); ?>" 
                    />
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          
          <?php if ( !$args['hide_add_to_cart'] ) : 
            $args['add_to_cart_text'] = (
              isset( $args['add_to_cart_text'] )
                ? ( 
                  ( $args['add_to_cart_text'] === false ) 
                    ? '' 
                    : ( 
                      !empty( $args['add_to_cart_text'] ) 
                        ? esc_html( $args['add_to_cart_text'] ) 
                        : "ADD TO SAMPLE BOX <span style='font-weight:bold;'>+</span>"
                  )
                )
                : "ADD TO SAMPLE BOX <span style='font-weight:bold;'>+</span>"
            );   
          ?>
            <div class="sg-featured-product__add-to-cart sg-featured-product__add-to-cart--layout-<?php 
              echo esc_attr( 
                $args['layout'] . 
                ( (!empty($args['add_to_cart_link']) && $args['add_to_cart_text'] === '') ? ' sg-featured-product__add-to-cart--cover' : '' )
              );
            ?>">
          <?php if(!$enquired_product) : ?>

            <?php 
            
              if ( !empty($args['add_to_cart_link']) )  {
                                         
                
                echo '<a ' 
                        . 'href="'. esc_url( $args['add_to_cart_link'] ) .'" ' 
                        . 'rel="nofollow" ' 
                        . 'data-product_id="' . esc_attr( $product->get_id() ) . '" ' 
                        . 'data-product_sku="' . esc_attr( $product->get_sku() ) . '" ' 
                        . 'class="sg-featured-product__add-to-cart-button sg-featured-product__add-to-cart-button--layout-' . esc_attr( $args['layout'] ) 
                          . ' button product_type_' . $product->get_type() 
                          . ( ($args['add_to_cart_text'] === '') ? ' sg-featured-product__add-to-cart-button--cover' : '' ) . '" ' 
                        . 'target="' . ( !empty($args['add_to_cart_target']) ? esc_attr( $args['add_to_cart_target'] ) : '_self' ) . '"'
                    . '>'
                        . esc_html( $args['add_to_cart_text'] )
                    . '</a>';
              } else {
                echo apply_filters( 
                  'woocommerce_loop_add_to_cart_link',
                  sprintf( 
                    '<a ' 
                      . 'href="%s" ' 
                      . 'rel="nofollow" ' 
                      . 'data-product_id="%s" ' 
                      . 'data-product_sku="%s" ' 
                      . 'class="sg-featured-product__add-to-cart-button sg-featured-product__add-to-cart-button--layout-' 
                        . esc_attr( $args['layout']  )  . ' button %s product_type_%s"' 
                    . '>%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( $product->get_id() ),
                    esc_attr( $product->get_sku() ),
                    $product->is_purchasable() ? 'add_to_cart_button' : '',
                    esc_attr( $product->get_type() ),
                    "ADD TO SAMPLE BOX <span style='font-weight:bold;'>+</span>"
                  ),
                  $product 
                );
              }
            ?>   
            <?php else : ?>
              <button
                type="button"
                data-id="<?= $product->get_sku() ?>"
                data-link="<?= $product->get_permalink() ?>"
                data-title="<?= esc_html($product->get_title()) ?>"
                class="enquire-button-full open-enquire-modal"
              >
                <span>Contact Us</span>
                <span class="icon-enquire inside-button"></span>
              </button>
            <?php endif ?>
      
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php 
endif; 
?>
