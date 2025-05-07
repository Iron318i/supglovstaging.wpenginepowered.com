<?php

/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.0.0
 */

defined('ABSPATH') || exit;

global $post, $product;

$is_sample_box = get_post_meta( $product->get_id(), 'sg_sample_box_marker', true );
$enquired_product = get_post_meta($product->get_id(), '_enquired_product', true) == 'yes';

if ( !$is_sample_box ) {
  $heading = apply_filters('woocommerce_product_description_heading', __('Description', 'woocommerce'));
  $product_maindescritpiontightcontent = get_post_meta($post->ID, '_bhww_specsd_wysiwyg', true);

  if ($heading) { echo '<h2>' . esc_html($heading) . '</h2>'; }

  if ( !empty($product_maindescritpiontightcontent) ) {
    // Updated to apply the_content filter to WYSIWYG content
    echo '<div class="col col-sm-12 col-md-6 ">';
      //let's load attributes and meta here
      echo '<h6>'  .   __('Product Features', 'woocommerce')  . '</h6><div class="clear"></div>';
      the_content();
    echo '</div>';
    echo '<div class="col col-sm-12 col-md-6">';
      echo apply_filters('the_content', $product_maindescritpiontightcontent);
    echo '</div>';
  } else {
    $builProduct = wc_get_product($post->ID);
    $attributes = $builProduct->get_attributes();
    $names_string = $builProduct->get_attribute('pa_primary_industry');
    $names_string2 = $builProduct->get_attribute('pa_recommended_industry');
    $alternateVersion = $builProduct->get_attribute('pa_alternate_version');
    $is_p65_product = get_post_meta($product->get_id(), '_p65_product', true);
    
    /*
    crosssellProductIds   =   get_post_meta($post->ID, '_crosssell_ids');
    
    if ( ! empty($crosssellProductIds) ) {
      $crosssellProductIds    =   $crosssellProductIds[0];
    }
    */
    
    if ( !empty($names_string) || !empty($names_string2) || !empty($alternateVersion) || ($is_p65_product == 'yes') ) {
      $material = wc_get_product_terms($product->get_id(), 'pa_material');
      $material_description = false;

      if ( count($material) ) {
        $material_description = $material[0]->description;
      }
      
      echo '<div class="col col-sm-12 col-md-6 prodetailsleft prodetailsblock">';
        echo '<h6>' . __('Product Features', 'woocommerce') . '</h6><div class="clear"></div>';
        
        the_content();

        if ( $material_description ) {
          echo '<div class="material-description" style="margin: 12px 0;">';
            echo $material_description;
          echo '</div>';
        }

        if ( $is_p65_product == 'yes' ) {
          $icon_path = get_template_directory_uri() . '/img/products_messages/p65_warning.jpg';
          
          echo '<div class="warning-message">';
            echo '<img src="' . $icon_path . '" alt="P65 Warning" width="30">';
            echo '<p>' . get_option( 'p65_warning' ) . '</p>';
          echo '</div>';
        }

        if ( $enquired_product ) {
            $icon_path = get_template_directory_uri() . '/img/products_messages/attention-sign.svg';

            echo '<div class="warning-message">';
            echo '<img src="' . $icon_path . '" alt="Warning" width="35">';
            echo '<p>' . __( 'We will need a bit more information in order to push through this sample request', 'supro' ) . '</p>';
            echo '</div>';
        }

      echo '</div>';
      echo '<div class="col col-sm-12 col-md-6 prodetailsright prodetailsblock">';
      
        if ( !empty($names_string) ) {
          $names_array = explode('| ', $names_string); // Converting the string to an array of term names
          // Output
          echo '<div class="col col-sm-12 col-md-6 applist nopadcol">';
            echo '<h6>' . __('Applications', 'woocommerce') . '</h6><div class="clear"></div>';
            echo '<ul class="apps"><li><h6>';
              echo  implode('</h6></li><li><h6>', $names_array);
          echo '</h6></li></ul></div>';
        }
        
        if ( !empty($names_string2) ) {
            $names_array2 = explode('| ', $names_string2); // Converting the string to an array of term names
            // Output
            echo '<div class="col col-sm-12 col-md-6 reccolist nopadcol">';
              echo '<h6>' . __('Recommended for', 'woocommerce') . '</h6><div class="clear"></div>';
              echo '<ul class="reccos"><li><h6>';
              echo  implode('</h6></li><li><h6>', $names_array2);
            echo '</h6></li></ul></div>';
        }
        
        // Alternative versions
        $html_product_alternative = null;
        
        $product_alternative_sku = array();
        $product_alternative_sku[] = $product->get_attribute('alternate_version_1');
        $product_alternative_sku[] = $product->get_attribute('alternate_version_2');
        $product_alternative_sku[] = $product->get_attribute('alternate_version_3');
        $product_alternative_sku[] = $product->get_attribute('alternate_version_4');
        
        foreach( $product_alternative_sku as $alt_sku ) {
          if ( !empty($alt_sku) ) {
            $product_alternative_id = wc_get_product_id_by_sku($alt_sku);

            if ( !empty($product_alternative_id) ) {
                $product_alternative_url = get_permalink($product_alternative_id);

                $html_product_alternative .= '<a href="'. $product_alternative_url .'" class="buttonogs btn_small  btn_dark2">' . $alt_sku . '</a>';
            }
          }
        }
        
        if ( !empty($html_product_alternative) ) {
          $alternative_title = __('Alternative Versions', 'woocommerce');

          $html_product_alternative = <<<HTML
  <div class="col col-sm-12 col-md-12 reccolist nopadcol">
      <h6>{$alternative_title}</h6><div class="clear"></div>
      <div class="col col-sm-12 col-md-6 reccolist nopadcol">
        {$html_product_alternative}
      </div>
  </div>
  HTML;

            echo $html_product_alternative;
          }
        
        if ( !empty($names_string2) || !empty($names_string1) ) {
          echo '<div class="clear"></div>';
        }

        // LOAD THE DETAILS RIGHT SIDE ATTRIBUTES AND CROSS SELLS HERE
        $sential = 0;
        
        if ( !empty($alternateVersion) ) {
          foreach ( $alternateVersion as $id ) :
            if ( $sential == 0 ) {
              echo '<h6>' . __('Alternative Versions', 'woocommerce')  . '</h6><div class="clear"></div>';
            }
            
            $sential++;
            
            $crosssellProduct = wc_get_product($id);
            
            $alternative_url =  get_permalink($crosssellProduct->get_id());
            $alternative_name = $crosssellProduct->get_name();
            
            echo '<a href="' . $alternative_url . '" class="buttonogs btn_small btn_dark2   " target="_self" rel="noopener">' . $alternative_name . '</a>';
            
            if ( $sential  % 2 == 0 ) {
              echo '<div class="clear"></div>';
            }
          endforeach;
        }
    } else {
      echo '<div class="col col-sm-12 col-md-12 prodetailsleft prodetailsblock">';
        echo '<h6>'  .   __('Product Features', 'woocommerce')  . '</h6><div class="clear"></div>';
        the_content();
      echo '</div>';
      echo '<div class="col col-sm-12 col-md-6 prodetailsright prodetailsblock">';
    }
    
    echo '</div>';
    
    renderTable(false);

    echo '<div class="clear"></div>';
  }
}
?>