<?php
/**
 * Product compare
 *
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;
$features_and_technology_terms = get_terms('pa_features_and_technology');

if ( empty( $product ) || ! $product->exists() ) {
  return;
}

//if ( ! $related = $product->get_related( 3 ) ) {
//  return;
//}

// Get ID of current product, to exclude it from the related products query
$current_product_id = $product->get_id();

// Get current  product object
$current_product = wc_get_product( $current_product_id );

if ( empty($current_product) ) {
  return;
}

function groupstart($header)
{
  $result = '
    <div class="comparerow block-separator">
      <div class="col col-xs-5ths col-md-5ths col-md-5ths firstcell"><strong>' . $header . '</strong></div>
      <div class="clear"></div>
    </div>
  ';
  echo $result;
}

function htmlrowforcompare( $rowname, array $rowvalues ){
  if (!empty($rowvalues)) {
    $result = '<div class="comparerow"><div class="col col-xs-5ths col-md-5ths col-md-5ths firstcell">' . $rowname . '</div>';
    // $checkrowvalue = 0;
    $countitems = 0;
    $thelast = '';
    $totalitems = count( $rowvalues );

    foreach ( $rowvalues as $rowcolumnvalue ) {
      $countitems++;

      if ( $countitems == $totalitems ) {
        $thelast = ' last';
      }

      if ( $rowcolumnvalue == "" ) {
        // $checkrowvalue++;
        $rowcolumnvalue = __( 'None', 'supro' );
      }

      //if we need to convert PIPE values into comma separated
      // Convert pipes to commas and display values
      $rowcolumnvalue = array_map( 'trim', explode( WC_DELIMITER, $rowcolumnvalue ) );
      $rowcolumnvalue =  wptexturize( implode( ', ', $rowcolumnvalue ) ) . ' ';

      $result .= '<div class="col col-xs-5ths col-md-5ths col-md-5ths' . $thelast . '">' . $rowcolumnvalue . '</div>';
    }

    //if row is empty then we don't need to show it
    //basically if the all values in the row are going to be empty then we don't need to show it
    //if ( $checkrowvalue == 4 ) {
      //$result = '';
    //} else {
      $result .= '<div class="clear"></div></div>';
    //}

    return $result;
  }
}


//build compared product objects
//Array will hold THIS (FIRST) product
$compares_needed = 3;
$product_categories = array();
$products_to_compare = array( $current_product );
$post_not_in = array( $current_product_id );
$compareoverrides = get_post_meta( $current_product_id, '_related_ids2', true );

if ( is_array( $compareoverrides ) ) {
	$num_of_overrides = count( $compareoverrides );
} else {
	$num_of_overrides = 0;
}

// count how many override products given, MUST be 1 to 3 ONLY
if ( $num_of_overrides > 0 && $num_of_overrides < 4 ) {
  // Add the users initial compare override products to our main products to compare array
  foreach ( $compareoverrides as $productcompareid ) {
    $productcompare_obj = wc_get_product( $productcompareid );

    if ( ! empty( $productcompare_obj ) ) {
      array_push( $products_to_compare, $productcompare_obj );
      array_push( $post_not_in, $productcompareid );
    } else {
      $num_of_overrides--;
    }
  }
}

$compares_needed = $compares_needed - $num_of_overrides;

// get categories
$current_product_terms = wp_get_post_terms( $product->get_id(), 'product_cat' );

if ( ! is_wp_error( $current_product_terms ) && ! empty( $current_product_terms ) ) {
  // select only the category which doesn't have any children
  foreach ( $current_product_terms as $current_product_single_term ) {
    $current_product_single_term_children = get_term_children( $current_product_single_term->term_id, 'product_cat' );

    if ( ! sizeof( $current_product_single_term_children ) ) {
      $product_categories[] = $current_product_single_term->term_id;
    }
  }
}

if ( $compares_needed > 0 ) {
  // Here we are getting only the amnount of additional products needed
  // ie if user added 2 overrides then we only need one more,
  // if user added 1 override then we need 2 more etc....
  $args = array(
    'post_type' => 'product',
    'post__not_in' => $post_not_in, // exclude all products currently choosen
    'ignore_sticky_posts' => 1,
    'no_found_rows' => 1,
    'posts_per_page' => ( $compares_needed + 5 ) // in case we can't get some product objects later
  );

  if ( ! empty($orderby) ) {
    $args['orderby'] = $orderby;
  }

  if ( ! empty( $product_categories ) ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $product_categories
      ),
    );
  }

  $args = apply_filters( 'woocommerce_related_products_args', $args );
  $loopproducts = new WP_Query( $args );

  if ( $loopproducts->have_posts() ) {
    while ( $loopproducts->have_posts() ) {
      $loopproducts->the_post();

      if ( $compares_needed > 0 ) {
        $loop_single_product = wc_get_product( $loopproducts->post->ID );

        if ( ! empty($loop_single_product) ) {
          //Add additional products to the array not picked by user but from same category
          array_push( $products_to_compare, $loop_single_product );
          $compares_needed--;
        }
      }
    }
  }

  wp_reset_postdata();
}

// can't get products to compare
if ( empty($products_to_compare) || count($products_to_compare) == 1 ) {
  return;
}

$comparerecords = array();

//for each woocommerce product let's create an array to hold the values we want
foreach ( $products_to_compare as $thecompareproduct ) {
  // Hazards array
  $hazards = array(
    'abrasion' => '',
    'arc-flash' => '',
    'cut' => '',
    'heat' => '',
    'hypodermic_needle' => '',
    'puncture-probe' => '',
  );

  $hazards_terms = wc_get_product_terms( $thecompareproduct->get_id(), 'pa_hazards', array( 'fields' => 'all' ) );

  if ( ! is_wp_error( $hazards_terms ) && ! empty( $hazards_terms ) ) {
    foreach ( $hazards_terms as $single_hazard_term ) {
      if ( $single_hazard_term->parent ) {
        $single_hazard_term_parent = get_term( $single_hazard_term->parent, 'pa_hazards' );
      } else {
        $single_hazard_term_parent = 0;
      }

      if ( ! is_wp_error( $single_hazard_term_parent ) && ! empty( $single_hazard_term_parent ) && is_object( $single_hazard_term_parent ) ) {
        if ( $single_hazard_term_parent->slug == 'abrasion' ) {
          $hazards['abrasion'] = $single_hazard_term->name;
        }

        if ( $single_hazard_term_parent->slug == 'cut' ) {
          $hazards['cut'] = $single_hazard_term->name;
        }

        if ( $single_hazard_term_parent->slug == 'heat' ) {
          $hazards['heat'] = $single_hazard_term->name;
        }

        if ( $single_hazard_term_parent->slug == 'arc-flash' ) {
          $hazards['arc-flash'] = $single_hazard_term->name;
        }

        if ( $single_hazard_term_parent->slug == 'hypodermic_needle' ) {
          $hazards['hypodermic_needle'] = $single_hazard_term->name;
        }

        if ( $single_hazard_term_parent->slug == 'puncture-probe' ) {
          $hazards['puncture-probe'] = $single_hazard_term->name;
        }
      }
    }
  }

  $newcompare_record = array(
    'id' => $thecompareproduct->get_id(),
    'product_name' => $thecompareproduct->get_name(),
    'product_permalink' => $thecompareproduct->get_permalink(),
    'application' => $thecompareproduct->get_attribute( 'application' ),
    'arm_anchor_techlogy' => $thecompareproduct->get_attribute( 'pa_arm_anchor_techlogy' ),
    'arch_flash' => $thecompareproduct->get_attribute( 'pa_arch_flash' ),
    'abrasion-resistant' => $thecompareproduct->get_attribute( 'pa_abrasion' ),
    'available_sizes' => $thecompareproduct->get_attribute( 'pa_available_sizes' ),
    'chemical_and_disposable_gloves_material' => $thecompareproduct->get_attribute( 'pa_chem_dispos_gloves_material' ),
    'chemical_and_disposable_gloves_thickss' => $thecompareproduct->get_attribute( 'pa_chem_dispos_gloves_thickss' ),
    'chemical_and_disposable_gloves_unsupportedsupported' => $thecompareproduct->get_attribute( 'pa_chem_dispos_gloves_unsupsup' ),
    'country_of_origin' => $thecompareproduct->get_attribute( 'pa_country_of_origin' ),
    'cut' => $thecompareproduct->get_attribute( 'pa_cut' ),
    'features_and_techlogy' => $thecompareproduct->get_attribute( 'pa_features_and_techlogy' ),
    'features_and_techlogy_cuff_length' => $thecompareproduct->get_attribute( 'pa_feat_tech_cuff_length' ),
    'features_and_techlogy_cuff_style' => $thecompareproduct->get_attribute( 'pa_feat_tech_cuff_style' ),
    'features_and_techlogy_sizes' => $thecompareproduct->get_attribute( 'pa_features_and_techlogy_sizes' ),
    'hazards_cold' => $thecompareproduct->get_attribute( 'pa_hazards_cold' ),
    'care' => $thecompareproduct->get_attribute( 'pa_laundering_instructions' ),
    'crush' => $thecompareproduct->get_attribute( 'pa_crush' ),
    'chemical' => $thecompareproduct->get_attribute( 'pa_chemical' ),
    'hazards_cut_360' => $thecompareproduct->get_attribute( 'pa_hazards_cut_360' ),
    'hazards_heat' => $thecompareproduct->get_attribute( 'pa_hazards_heat' ),
    'flame' => $thecompareproduct->get_attribute( 'pa_flame' ),
    'hypodermic_needle' => $thecompareproduct->get_attribute( 'pa_hypodermic_needle' ),
    'vibration' => $thecompareproduct->get_attribute( 'pa_vibration' ),
    'impact' => $thecompareproduct->get_attribute( 'pa_impact' ),
    'ladies_sizing' => $thecompareproduct->get_attribute( 'pa_ladies_sizing' ),
    'laundering_instructions' => $thecompareproduct->get_attribute( 'pa_laundering_instructions' ),
    'material' => $thecompareproduct->get_attribute( 'pa_material' ),
    'material_gauge' => $thecompareproduct->get_attribute( 'pa_material_gauge' ),
    'palm_coating' => $thecompareproduct->get_attribute( 'pa_palm_coating' ),
    'coating_style' => $thecompareproduct->get_attribute( 'pa_coating_style' ),
    'palm_coating_dip_type' => $thecompareproduct->get_attribute( 'pa_palm_coating_dip_type' ),
    'primary_industry' => $thecompareproduct->get_attribute( 'pa_primary_industry' ),
    'country_of_origin' => $thecompareproduct->get_attribute( 'pa_country_of_origin' ),
    'product_type' => $thecompareproduct->get_attribute( 'pa_product_type' ),
    'puncture_probe' => $thecompareproduct->get_attribute( 'pa_puncture_probe' ),
    'recommended_industry' => $thecompareproduct->get_attribute( 'pa_recommended_industry' ),
    'ship_pack_quantity' => $thecompareproduct->get_attribute( 'pa_ship_pack_quantity' ),
    'sizing_minclature' => $thecompareproduct->get_attribute( 'pa_sizing_minclature' ),
    'skid_quantity' => $thecompareproduct->get_attribute( 'pa_skid_quantity' ),
    'sleeve_lengths_with_thumbholes_in' => $thecompareproduct->get_attribute( 'pa_sleeve_lengths_w_thumb_in' ),
    'sleeve_lengths_without_thumbholes_in' => $thecompareproduct->get_attribute( 'pa_sleeve_lengths_wo_thumbs_in' ),
    'sub_brand' => $thecompareproduct->get_attribute( 'pa_sub_brand' ),
    'tubular_or_tapered' => $thecompareproduct->get_attribute( 'pa_tubular_or_tapered' ),
    'unit_of_measure' => $thecompareproduct->get_attribute( 'pa_unit_of_measure' ),
    'case_dimensions_in' => get_post_meta( $thecompareproduct->get_id(), 'case_dimensions_in', true ),
    'ce_en388_certification_code' => get_post_meta( $thecompareproduct->get_id(), 'ce_en388_certification_code', true ),
    'other_ce_certification_codes' => get_post_meta( $thecompareproduct->get_id(), 'other_ce_certification_codes', true ),
    'unspsc_code' => get_post_meta( $thecompareproduct->get_id(), 'unspsc_code', true ),
    'hs_code' => get_post_meta( $thecompareproduct->get_id(), 'hs_code', true ),
    'ukca_code' => get_post_meta( $thecompareproduct->get_id(), 'ukca_code', true ),
    'product_id' => $thecompareproduct->get_sku(),
	);

  $newcompare_record = array_merge( $hazards, $newcompare_record );

  array_push( $comparerecords, $newcompare_record );

  $productfeatures = [];
  $features_tech_array = array_values( wc_get_product_terms( $thecompareproduct->get_id(), 'pa_features_and_technology', array( 'fields' => 'names' ) ) );

  if ( $features_and_technology_terms ) {
    foreach ( $features_and_technology_terms as $tech_val ) {
      if ( in_array( $tech_val->name, $features_tech_array ) ) {
        $productfeatures['pf_' . $tech_val->slug] = 'Yes';
      } else {
        // $productfeatures[$tech_val->name] = 'None';
        $productfeatures['pf_' . $tech_val->slug] = 'No';
      }
    }
  }

  array_push( $comparerecords, $productfeatures );
}
?>
<div class="comparearea">
  <div class="row zeromag">
    <div class="containerx">

      <div class="col col-sm-12 col-md-12">
        <h3 class="comptitle"><?php _e( 'Compare with similar items', 'woocommerce' ); ?></h3>

        <div class="special-text">
          <div id="comparetop" class="rowx">

  	  			<div class="container compareheadcont">
  	  				<div class="col col-xs-5ths col-md-5ths col-md-5ths">&nbsp;</div>
              <?php
  	            // build product objects
                // $sentinal = 0;
                $count_products_to_compare = 0;
                $total_products_to_compare_thelast = '';
                $total_products_to_compare = count( $products_to_compare );

                foreach ( $products_to_compare as $someproduct ) {
                  $count_products_to_compare++;

                  $someproduct_image_size = 'shop_catalog';
                  $someproduct_tag_names = array();

                  // $someproduct_attachment_ids = $someproduct->get_gallery_image_ids();

                  $someproduct_image_id = get_post_thumbnail_id( $someproduct->get_id() );
                  $someproduct_tags = wp_get_post_terms( $someproduct->get_id(), 'product_tag' );
                  $enquired_product = get_post_meta($someproduct->get_id(), '_enquired_product', true) == 'yes';

                  if ( $count_products_to_compare == $total_products_to_compare ) {
                    $total_products_to_compare_thelast = ' last';
                  }

                  if ( $someproduct_image_id ) {
                    $someproduct_image = wp_get_attachment_image_src( $someproduct_image_id, $someproduct_image_size );
                  } else {
                    $someproduct_image = null;
                  }

                  if ( ! empty($someproduct_image) ) {
                    $someproduct_image = $someproduct_image[0];
                  } else {
                    $someproduct_image = wc_placeholder_img_src();
                  }

                  if ( ! empty( $someproduct_tags ) && ! is_wp_error( $someproduct_tags ) ) {
                    foreach ( $someproduct_tags as $tag ) {
                      $someproduct_tag_names[] = $tag->name;
                    }

                    $someproduct_tag_names = implode(', ',  $someproduct_tag_names);
                  }
              ?>
                  <div class="col col-xs-5ths col-md-5ths col-md-5ths compareheader<?php echo $total_products_to_compare_thelast; ?>">
                    <div class="un-product-thumbnail">
                      <a href="<?php echo esc_url( get_permalink( $someproduct->get_id() ) ); ?>" ><img src="<?php echo $someproduct_image; ?>" data-id="<?php echo esc_attr( $someproduct->get_id() ); ?>"></a>
                      <div class="footer-button2">
                        <?php if (!$enquired_product) : ?>
                          <a
                            href="?add-to-cart=<?php echo $someproduct->get_id(); ?>" data-quantity="1" data-title="<?php echo $someproduct->get_name(); ?>"
                            data-product_id="<?php echo $someproduct->get_id(); ?>" data-product_sku="<?php echo $someproduct->get_sku(); ?>"
                            class="button product_type_simple add_to_cart_button ajax_add_to_cart buttonogs btn_small btn_theme_color" rel="nofollow" tabindex="0"><span
                              class="hidebuttxt"><?php _e( 'Add to Box', 'supro' ); ?> <i class="t-icon icon-ion-android-add"></i></span><i class="showmobile t-icon icon-cartboxadd"></i>
                          </a>
                        <?php else : ?>
                          <button
                            type="button"
                            data-id="<?= $someproduct->get_sku() ?>"
                            data-link="<?= $someproduct->get_permalink() ?>"
                            data-title="<?= esc_html($someproduct->get_title()) ?>"
                            class="enquire-button-full compare open-enquire-modal"
                          >
                            <span>Contact Us</span>
                            <span class="icon-enquire inside-button"></span>
                          </button>
                        <?php endif ?>
                      </div>
                      <div class="quicky2"><a
                        href="<?php echo $someproduct->get_permalink(); ?>" data-id="<?php echo esc_attr( $someproduct->get_id() ); ?>" class="buttonogs btn_small btn_dark2"><span
                          class="hidebuttxt"><?php _e( 'View Item', 'supro' ); ?></span><i class="showmobile t-icon icon-eye"></i></a></div>
                    </div>
                    <div class="comparedetails">
                      <h3><a href="<?php echo esc_url( $someproduct->get_permalink() ); ?>"><?php echo $someproduct->get_name(); ?></a></h3>
                      <?php if ( ! empty( $someproduct_tag_names ) ) : ?>
                        <div class="productdetails2"><?php echo $someproduct_tag_names; ?></div>
                      <?php endif; ?>
                    </div>
                  </div>
              <?php
                  // $sentinal++;
                }
              ?>
            </div>

            <div class="container comparebodycont">
              <div class="coparetable">
                <?php
                  echo htmlrowforcompare(__( 'Product name', 'woocommerce' ), array_column($comparerecords, 'product_name'));
                  echo htmlrowforcompare(__( 'Product ID', 'woocommerce' ), array_column($comparerecords, 'product_id'));

                  echo groupstart('SPECIFICATIONS');
                  echo htmlrowforcompare(__( 'Sizes', 'woocommerce' ),  array_column($comparerecords, 'available_sizes'));
                  echo htmlrowforcompare(__( 'Ladies Sizes', 'woocommerce' ), array_column($comparerecords, 'ladies_sizing'));
                  echo htmlrowforcompare(__( 'Materials', 'woocommerce' ), array_column($comparerecords, 'material'));
                  echo htmlrowforcompare(__( 'Gauge / Thickness', 'woocommerce' ), array_column($comparerecords, 'material_gauge'));
                  echo htmlrowforcompare(__( 'Palm Coating', 'woocommerce' ), array_column($comparerecords, 'palm_coating'));
                  echo htmlrowforcompare(__( 'Coating Style', 'woocommerce' ), array_column($comparerecords, 'coating_style'));
                  echo htmlrowforcompare(__( 'Cuff Length', 'woocommerce' ), array_column($comparerecords, 'features_and_techlogy_cuff_length'));
                  echo htmlrowforcompare(__( 'Cuff Style', 'woocommerce' ), array_column($comparerecords, 'features_and_techlogy_cuff_style'));
                  echo htmlrowforcompare(__( 'Care', 'woocommerce' ), array_column($comparerecords, 'care'));
                  echo htmlrowforcompare(__( 'Made In', 'woocommerce' ), array_column($comparerecords, 'country_of_origin'));
                  // echo htmlrowforcompare(__( 'HS Code', 'woocommerce' ), array_column($comparerecords, 'hs_code'));
                  // echo htmlrowforcompare(__( 'UNSPSC Code', 'woocommerce' ), array_column($comparerecords, 'unspsc_code'));
                  // echo htmlrowforcompare(__( 'CE Certification', 'woocommerce' ), array_column($comparerecords, 'other_ce_certification_codes'));
                  // echo htmlrowforcompare(__( 'UKCA Code', 'woocommerce' ), array_column($comparerecords, 'ukca_code'));

                  echo groupstart('HAZARD PROTECTIONS');
                  echo htmlrowforcompare(__( 'Abrasion', 'woocommerce' ), array_column($comparerecords, 'abrasion-resistant'));
                  echo htmlrowforcompare(__( 'Arc Flash', 'woocommerce' ), array_column($comparerecords, 'arch_flash'));
                  echo htmlrowforcompare(__( 'Chemical', 'woocommerce' ), array_column($comparerecords, 'chemical'));
                  echo htmlrowforcompare(__( 'Cold', 'woocommerce' ), array_column($comparerecords, 'hazards_cold'));
                  echo htmlrowforcompare(__( 'Crush', 'woocommerce' ), array_column($comparerecords, 'crush'));
                  echo htmlrowforcompare(__( 'Cut', 'woocommerce' ),  array_column($comparerecords, 'cut'));
                  echo htmlrowforcompare(__( 'Heat', 'woocommerce' ), array_column($comparerecords, 'hazards_heat'));
                  echo htmlrowforcompare(__( 'Flame', 'woocommerce' ), array_column($comparerecords, 'flame'));
                  echo htmlrowforcompare(__( 'Impact', 'woocommerce' ), array_column($comparerecords, 'impact'));
                  echo htmlrowforcompare(__( 'Puncture (probe)', 'woocommerce' ), array_column($comparerecords, 'puncture_probe'));
                  echo htmlrowforcompare(__( 'Puncture (hypodermic needle)', 'woocommerce' ), array_column($comparerecords, 'hypodermic_needle'));
                  echo htmlrowforcompare(__( 'Vibration', 'woocommerce' ), array_column($comparerecords, 'vibration'));
				  echo htmlrowforcompare(__( 'CE Certification', 'woocommerce' ), array_column($comparerecords, 'other_ce_certification_codes'));
                  echo htmlrowforcompare(__( 'UKCA Code', 'woocommerce' ), array_column($comparerecords, 'ukca_code'));

                  echo groupstart('OTHER FEATURES');
                  echo htmlrowforcompare(__( 'Anti-Microbial', 'woocommerce' ), array_column($comparerecords, 'pf_anti-microbial'));
                  echo htmlrowforcompare(__( 'Biodegradable', 'woocommerce' ), array_column($comparerecords, 'pf_biodegradable'));
                  echo htmlrowforcompare(__( 'CFIA Compliant', 'woocommerce' ), array_column($comparerecords, 'pf_cfia-compliant'));
                  echo htmlrowforcompare(__( 'Cleanroom Processed', 'woocommerce' ), array_column($comparerecords, 'pf_cleanroom-friendly'));
                  echo htmlrowforcompare(__( 'Disposable', 'woocommerce' ), array_column($comparerecords, 'pf_disposable'));
                  echo htmlrowforcompare(__( 'ESD / Anti Static', 'woocommerce' ), array_column($comparerecords, 'pf_esd-anti-static'));
                  echo htmlrowforcompare(__( 'FDA Compliant', 'woocommerce' ), array_column($comparerecords, 'pf_fda-compliant'));
                  echo htmlrowforcompare(__( 'High Visibility', 'woocommerce' ), array_column($comparerecords, 'pf_high-visibility'));
                  echo htmlrowforcompare(__( 'Latex Free', 'woocommerce' ), array_column($comparerecords, 'pf_latex-free'));
                  echo htmlrowforcompare(__( 'Low Lint', 'woocommerce' ), array_column($comparerecords, 'pf_low-linting'));
                  echo htmlrowforcompare(__( 'Non-Marring', 'woocommerce' ), array_column($comparerecords, 'pf_non-marring'));
                  echo htmlrowforcompare(__( 'Recyclable', 'woocommerce' ), array_column($comparerecords, 'pf_recyclable'));
                  echo htmlrowforcompare(__( 'Recyclable Material', 'woocommerce' ), array_column($comparerecords, 'pf_recyclable_material'));
                  echo htmlrowforcompare(__( 'Reinforcements', 'woocommerce' ), array_column($comparerecords, 'pf_reinforced-thumb-crotch'));
                  echo htmlrowforcompare(__( 'Silicon Free', 'woocommerce' ), array_column($comparerecords, 'pf_silicone-free'));
                  echo htmlrowforcompare(__( 'Touchscreen', 'woocommerce' ), array_column($comparerecords, 'pf_touchscreen-friendly'));
                  echo htmlrowforcompare(__( 'Water Resistant', 'woocommerce' ), array_column($comparerecords, 'pf_water-resistent-material'));
                  echo htmlrowforcompare(__( 'Waterproof', 'woocommerce' ), array_column($comparerecords, 'pf_waterproof'));
                ?>
              </div>
            </div>

          </div>
          <div class="clear"></div>
        </div>

        <div class="container comparebodycontbut">
          <div class="expand-button">
              <h5 class="all_features"><?php _e( 'Show all Features', 'supro' ); ?></h5>
              <h5 class="less_features"><?php _e( 'Show less Features', 'supro' ); ?></h5>

              <i class="icon icon-uni3F"></i></div>
        </div>
      </div>

    </div>
  </div>