<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}



/*
<table class="woocommerce-product-attributes shop_attributes">
	<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
		<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
			<th class="woocommerce-product-attributes-item__label"><?php echo wp_kses_post( $product_attribute['label'] ); ?></th>
			<td class="woocommerce-product-attributes-item__value"><?php echo wp_kses_post( $product_attribute['value'] ); ?></td>
		</tr>
	<?php endforeach; ?>
</table>
*/



global $product;

$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();
$rowcounter = 0;
$attributeclasses = "col-xs-12 col-sm-4 col-md-4 col-lg-4 attributeholder";



/***SPECS****/
$productspecs = [
  __( 'Product ID', 'woocommerce' ) => ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ),
  __( 'Sizes', 'woocommerce' ) => ( $sizes = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_available_sizes', array( 'fields' => 'names' ) ) ) ) ) ? $sizes : __( 'N/A', 'woocommerce' ),
  __( 'Ladies Sizes', 'woocommerce' ) => ( $ladies = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_ladies_sizing', array( 'fields' => 'names' ) ) ) ) ) ? $ladies : __( 'No', 'woocommerce' ),
  __( 'Material', 'woocommerce' ) =>
      ($material = implode(", ", array_values(wc_get_product_terms($product->id, 'pa_material', array('fields' => 'names'))))) ? $material : (($material = implode(", ", array_values(wc_get_product_terms($product->id, 'pa_material', array('fields' => 'names')))))
          ? $material
          : __('N/A', 'woocommerce')),
  __( 'Gauge / Thickness', 'woocommerce' )  => ( $materialgauge = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_material_gauge', array( 'fields' => 'names' ) ) ) ) ) ? $materialgauge : __( 'N/A', 'woocommerce' ),
  __( 'Palm Coating', 'woocommerce' ) => ( $paulcoating = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_palm_coating', array( 'fields' => 'names' ) ) ) ) ) ? $paulcoating : __( 'N/A', 'woocommerce' ),
  __( 'Coating Style', 'woocommerce' ) => ( $paulcoating = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_coating_style', array( 'fields' => 'names' ) ) ) ) ) ? $paulcoating : __( 'N/A', 'woocommerce' ),
  // __( 'CE Certification Code', 'woocommerce' ) => ( $ce_en38 = get_post_meta( get_the_ID(), 'ce_en388_certification_code', true ) ) ? $ce_en38 : __( 'N/A', 'woocommerce' ),
  // __( 'Other Certification Codes', 'woocommerce' ) => ( $other_ce = get_post_meta( get_the_ID(), 'other_ce_certification_codes', true ) ) ? $other_ce : __( 'N/A', 'woocommerce' ),

  // __( 'Sizing Nomenclature', 'woocommerce' ) => ( $minclature = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_sizing_minclature', array( 'fields' => 'names' ) ) ) ) ) ? $minclature : __( 'N/A', 'woocommerce' ),

	// __( 'Length', 'woocommerce' ) => ( $length = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_chem_dispos_gloves_length', array( 'fields' => 'names' ) ) ) ) ) ? $length : __( 'N/A', 'woocommerce' ),

	// __( 'Thickness', 'woocommerce' ) => ( $thickness = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_chem_dispos_gloves_thickss', array( 'fields' => 'names' ) ) ) ) ) ? $thickness : __( 'N/A', 'woocommerce' ),
 	// __( 'Support', 'woocommerce' ) => ( $support = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_chem_dispos_gloves_unsupsup', array( 'fields' => 'names' ) ) ) ) ) ? $support : __( 'N/A', 'woocommerce' ),
 	// __( 'Made In', 'woocommerce' ) => ( $madein = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_country_of_origin', array( 'fields' => 'names' ) ) ) ) ) ? $madein : __( 'N/A', 'woocommerce' ),
     // __( 'Care Instructions', 'woocommerce' ) => ( $instructions = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_laundering_instructions', array( 'fields' => 'names' ) ) ) ) ) ? $instructions : __( 'N/A', 'woocommerce' ),
];

$ptype1 = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_product_type', array( 'fields' => 'names' ) ) ) ) ;


/*GLOVE ONLY*/
if ( $ptype1 == "Glove" ) {
  $productspecs +=[
    __( 'Cuff Length', 'woocommerce' ) =>
        ($cufflength = implode(", ", array_values(wc_get_product_terms($product->id, 'pa_feat_tech_cuff_length', array('fields' => 'names'))))) ? $cufflength : (($cufflength = implode(", ", array_values(wc_get_product_terms($product->id, 'pa_cuff_length', array('fields' => 'names')))))
            ? $cufflength
            : __('N/A', 'woocommerce')),
    __( 'Cuff Style', 'woocommerce' ) =>
        ($cuffstyle = implode(", ", array_values(wc_get_product_terms($product->id, 'pa_feat_tech_cuff_style', array('fields' => 'names'))))) ? $cuffstyle : (($cuffstyle = implode(", ", array_values(wc_get_product_terms($product->id, 'pa_cuff_style', array('fields' => 'names')))))
            ? $cuffstyle
            : __('N/A', 'woocommerce')),
  ];
}

/*CHEMICAL GLOVE ONLY*/

$ptype_chem_glove_length = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_product_type', array( 'fields' => 'names' ) ) ) ) ;

if ( $ptype_chem_glove_length  ) {
	$productspecs += [
  __( 'Chemical Glove Length', 'woocommerce' ) => ( $gllength = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_chem_dispos_gloves_length', array( 'fields' => 'names' ) ) ) ) ) ? $gllength : __( 'N/A', 'woocommerce' ),

];
}

$productspecs += [
	//__( 'Material', 'woocommerce' ) => ( $material = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_material', array( 'fields' => 'names' ) ) ) ) ) ? $material : __( 'N/A', 'woocommerce' ),
  __( 'Care', 'woocommerce' ) => ( $diptype = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_laundering_instructions', array( 'fields' => 'names' ) ) ) ) ) ? $diptype : __( 'N/A', 'woocommerce' ),
 	// __( 'Dip Type', 'woocommerce' ) => ( $diptype = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_palm_coating_dip_type', array( 'fields' => 'names' ) ) ) ) ) ? $diptype : __( 'N/A', 'woocommerce' ),
  __( 'Made In', 'woocommerce' ) => ( $madein = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_country_of_origin', array( 'fields' => 'names' ) ) ) ) ) ? $madein : __( 'N/A', 'woocommerce' ),
  __( 'HS Code', 'woocommerce' ) => ( $hs_code = get_post_meta( get_the_ID(), 'hs_code', true ) ) ? $hs_code : __( 'N/A', 'woocommerce' ),
  __( 'UNSPSC Code', 'woocommerce' ) => ( $unspsc_code = get_post_meta( get_the_ID(), 'unspsc_code', true ) ) ? $unspsc_code : __( 'N/A', 'woocommerce' ),
  __( 'CE Certification', 'woocommerce' ) => ( $ce_code = get_post_meta( get_the_ID(), 'other_ce_certification_codes', true ) ) ? $ce_code : __( 'N/A', 'woocommerce' ),
  __( 'UKCA Code', 'woocommerce' ) => ( $ukca_code = get_post_meta( get_the_ID(), 'ukca_code', true ) ) ? $ukca_code : __( 'N/A', 'woocommerce' ),
];


/*SLEEVES ONLY*/
if ( $ptype1 == "Sleeve" ) {
	$productspecs += [
	 	__( 'Available Lengths (Inches) With Thumbhole', 'woocommerce' ) => ( $thumb1 = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_sleeve_lengths_w_thumb_in', array( 'fields' => 'names' ) ) ) ) ) ? $thumb1 : __( 'N/A', 'woocommerce' ),
	 	__( 'Available Lengths (Inches) With/Without Thumbhole', 'woocommerce' ) => ( $thumb2 = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_sleeve_lengths_wo_thumbs_in', array( 'fields' => 'names' ) ) ) ) ) ? $thumb2 : __( 'N/A', 'woocommerce' ),
    __( 'Arm Anchor Technology', 'woocommerce' ) => ( $armtech = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_arm_anchor_techlogy', array( 'fields' => 'names' ) ) ) ) ) ? $armtech : __( 'N/A', 'woocommerce' ),
	 	__( 'Tubular or Tapered', 'woocommerce' ) => ( $tubular = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_tubular_or_tapered', array( 'fields' => 'names' ) ) ) ) ) ? $tubular : __( 'N/A', 'woocommerce' ),
	];
}


$filtered_productspecs = array();

foreach ( $productspecs as $spec_name => $spec_value ) {
  if ( $spec_value !== 'N/A' ) {
    $filtered_productspecs[$spec_name] = $spec_value;
  }
}



/***SHIPPING****/
$productshippack = [
  __( 'UNSPSC Code', 'woocommerce' ) => ( $ce_en38 = get_post_meta( get_the_ID(), 'unspsc_code', true ) ) ? $ce_en38 : __( 'N/A', 'woocommerce' ),
  __( 'Ship Pack Quantity', 'woocommerce' ) => ( $ship_pack_qty = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_ship_pack_quantity', array( 'fields' => 'names' ) ) ) ) ) ? $ship_pack_qty : __( 'N/A', 'woocommerce' ),
  __( 'Weight (lb)', 'woocommerce' ) => ( $weight = get_post_meta( get_the_ID(), 'weight_in_lbs', true ) ) ? $weight : __( 'N/A', 'woocommerce' ),
  __( 'Country of Origin', 'woocommerce' ) => ( $origin_country = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_country_of_origin', array( 'fields' => 'names' ) ) ) ) ) ? $origin_country : __( 'N/A', 'woocommerce' ),
  __( 'SKID Quantity', 'woocommerce' ) => ( $skid_qty = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_skid_quantity', array( 'fields' => 'names' ) ) ) ) ) ? $skid_qty : __( 'N/A', 'woocommerce' ),
	__( 'Case Dimensions (In)', 'woocommerce' ) => ( $case_dimensions = get_post_meta( get_the_ID(), 'case_dimensions_in', true ) ) ? $case_dimensions : __( 'N/A', 'woocommerce' ),
  __( 'Unit of Measure', 'woocommerce' ) => ( $unit_of_measure = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_unit_of_measure', array( 'fields' => 'names' ) ) ) ) ) ? $unit_of_measure : __( 'N/A', 'woocommerce' ),
];


$filtered_productshippack = array();
foreach ( $productshippack as $pack_name => $pack_value ) {
  if ( $pack_value !== 'N/A' ) {
    $filtered_productshippack[$pack_name] = $pack_value;
  }
}



/***HAZARDS****/
$producthazards = [];
$term_parent_array = [];
$hazards_array = array_values( wc_get_product_terms( $product->id, 'pa_hazards' ) );

if ( $hazards_array ) {
  foreach ( $hazards_array as $hazards_val ) {
    if ( $hazards_val->parent != 0 ) {
      $term_parent = get_term( $hazards_val->parent, 'pa_hazards' );
      $term_parent_array[] = $term_parent->name;

      if ( in_array($term_parent->name, $term_parent_array) ) {
        $first_term_val = $producthazards[$term_parent->name];
        $producthazards[$term_parent->name] = ($first_term_val) ? $first_term_val . ', ' . $hazards_val->name : $hazards_val->name;
      } else {
        $producthazards[$term_parent->name] = $hazards_val->name;
      }
    }
  }
}

// __( 'Hazards', 'woocommerce' ) => ( $hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_hazards', array( 'fields' => 'names' ) ) ) ) ) ? $hazards : __( 'N/A', 'woocommerce' ),

$producthazards_all = [
  __( 'Abrasion', 'woocommerce' ) => ( $abrasion_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_abrasion', array( 'fields' => 'names' ) ) ) ) ) ? $abrasion_hazards : __( 'N/A', 'woocommerce' ),
  __( '360 Cut', 'woocommerce' ) => ( $cut360_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_hazards_cut_360', array( 'fields' => 'names' ) ) ) ) ) ? $cut360_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Arc Flash', 'woocommerce' ) => ( $arc_flash_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_arch_flash', array( 'fields' => 'names' ) ) ) ) ) ? $arc_flash_hazards : __( 'N/A', 'woocommerce' ),
	__( 'Chemical', 'woocommerce' ) => ( $chemical_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_chemical', array( 'fields' => 'names' ) ) ) ) ) ? $chemical_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Cold', 'woocommerce' ) => ( $cold_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_hazards_cold', array( 'fields' => 'names' ) ) ) ) ) ? $cold_hazards : __( 'N/A', 'woocommerce' ),
	__( 'Crush', 'woocommerce' ) => ( $crush_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_crush', array( 'fields' => 'names' ) ) ) ) ) ? $crush_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Cut', 'woocommerce' ) => ( $cut_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_cut', array( 'fields' => 'names' ) ) ) ) ) ? $cut_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Heat', 'woocommerce' ) => ( $heat_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_hazards_heat', array( 'fields' => 'names' ) ) ) ) ) ? $heat_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Flame', 'woocommerce' ) => ( $flame_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_flame', array( 'fields' => 'names' ) ) ) ) ) ? $flame_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Impact', 'woocommerce' ) => ( $impact_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_impact', array( 'fields' => 'names' ) ) ) ) ) ? $impact_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Puncture (Probe)', 'woocommerce' ) => ( $puncture_probe_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_puncture_probe', array( 'fields' => 'names' ) ) ) ) ) ? $puncture_probe_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Puncture (Hypodermic Needle)', 'woocommerce' ) => ( $puncture_hypodermic_needle_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_hypodermic_needle', array( 'fields' => 'names' ) ) ) ) ) ? $puncture_hypodermic_needle_hazards : __( 'N/A', 'woocommerce' ),
  __( 'Vibration', 'woocommerce' ) => ( $vibration_hazards = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_vibration', array( 'fields' => 'names' ) ) ) ) ) ? $vibration_hazards : __( 'N/A', 'woocommerce' ),
];


$filtered_producthazards = array();

foreach ( $producthazards_all as $hazard_name => $hazard_value ) {
  if ( $hazard_value !== 'N/A' ) {
    $filtered_producthazards[$hazard_name] = $hazard_value;
  }
}



/***FEATURES AND TECH ****/
$productfeatures = [];
$features_tech_array = array_values( wc_get_product_terms( $product->id, 'pa_features_and_technology', array( 'fields' => 'names' ) ) );
$features_and_technology_terms = get_terms('pa_features_and_technology');

if ( $features_and_technology_terms ) {
  foreach ( $features_and_technology_terms as $tech_val ) {
    if ( in_array( $tech_val->name, $features_tech_array ) ) {
      $productfeatures[$tech_val->name] = 'Yes';
    } else {
      // $productfeatures[$tech_val->name] = 'None';
      $productfeatures[$tech_val->name] = 'No';
    }
  }
}

$productfeatures_sizes = [
  __( 'Sizes', 'woocommerce' ) => ( $features_sizes = implode(", ", array_values( wc_get_product_terms( $product->id, 'features__techlogy_sizes', array( 'fields' => 'names' ) ) ) ) ) ? $features_sizes : __( 'N/A', 'woocommerce' ),
  __( 'Cuff Length', 'woocommerce' ) => ( $features_cuff_length = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_feat_tech_cuff_length', array( 'fields' => 'names' ) ) ) ) ) ? $features_cuff_length : __( 'N/A', 'woocommerce' ),
  __( 'Cuff Style', 'woocommerce' ) => ( $features_cuff_style = implode(", ", array_values( wc_get_product_terms( $product->id, 'pa_feat_tech_cuff_style', array( 'fields' => 'names' ) ) ) ) ) ? $features_cuff_style : __( 'N/A', 'woocommerce' ),
];

$productfeatures = array_merge( $productfeatures, $productfeatures_sizes );


$filtered_productfeatures = array();
$excluded_features = ['made-in-canada.png', 'none', 'water resistent (material)', 'oil/water repelleant (treatment)', 'made in americas', 'made in canada'];

foreach ( $productfeatures as $features_name => $features_value ) {
  if ( $features_value !== 'N/A' && !in_array(strtolower($features_name), $excluded_features) ) {
    $filtered_productfeatures[$features_name] = $features_value;
  }
}

ob_start();
?>

<div class="singattributesblock">

  <?php // SPECS ACCORDION ?>
  <div class="acc_holder specsaccord border">

    <?php
    // SPECIFICATIONS ACCORDION ITEM
    if ( ! empty( $filtered_productspecs ) ) :
      $colsx = array_chunk( $filtered_productspecs, ceil(count($filtered_productspecs)/3), true );
    ?>
      <div class="acc_item">
        <h5 class="accordion"><span class="acc_control acc_is_open"></span><span class="acc_heading">Specifications</span></h5>
        <div class="accordion_content" style="display: none;">
          <?php
          foreach ($colsx as $rowcolumn1){
            echo '<div class="'.$attributeclasses.'"><div class="specstable">';

              foreach($rowcolumn1 as $key1 => $value1) {
                echo '<div class="specsrow">'
                        . '<div class="specscell" data-title="' . $key1 . '">'
                          . '<h6>' . $key1 . '</h6>'
                        . '</div>'
                        . '<div class="specscell" data-title="' . $value1 . '">' . $value1 . '</div>'
                      . '</div>';
              }

            echo '</div></div>';
          }
          ?>
        </div>
      </div>
    <?php endif; ?>

    <?php
    // SHIPPING AND PACKAGING ACCORDION ITEM
    /*if ( ! empty( $filtered_productshippack ) ) :
      $colsx2 = array_chunk( $filtered_productshippack, ceil(count($filtered_productshippack)/3), true );
		?>
      <div class="acc_item">
        <h5 class="accordion"><span class="acc_control"></span><span class="acc_heading">Shipping and Packaging</span></h5>
        <div class="accordion_content" style="display: none;">
          <?php
          foreach ($colsx2 as $rowcolumn2){
            echo '<div class="' . $attributeclasses . '"><div class="specstable">';

              foreach ( $rowcolumn2 as $key2 => $value2 ) {
                echo '<div class="specsrow 1">'
                        . '<div class="specscell" data-title="' . $key2 . '">'
                          . '<h6>' . $key2 . '</h6>'
                        . '</div>'
                        . '<div class="specscell" data-title="' . $value2 . '">' . $value2 . '</div>'
                      . '</div>';
              }

            echo '</div></div>';
          }
          ?>
        </div>
      </div>
    <?php endif;*/ ?>

    <?php
    // HAZARD PROTECTION ACCORDION ITEM
    if ( ! empty( $filtered_producthazards ) ) :
      $colsx3 = array_chunk( $filtered_producthazards, ceil(count($filtered_producthazards)/3), true );
		?>
      <div class="acc_item hazarrdallnewclass">
        <h5 class="accordion"><span class="acc_control"></span><span class="acc_heading">Hazard Protections</span></h5>
        <div class="accordion_content" style="display: none;">
          <?php
            foreach ($colsx3 as $rowcolumn3){
              echo '<div class="' . $attributeclasses . '"><div class="specstable">';

                foreach ( $rowcolumn3 as $key3 => $value3 ) {
                  echo '<div class="specsrow 2">'
                          . '<div class="specscell" data-title="' . $key3 . '">'
                            . '<h6>' . $key3 . '</h6>'
                          . '</div>'
                          . '<div class="specscell" data-title="' . $value3 . '">' . $value3 . '</div>'
                        . '</div>';
                }

              echo '</div></div>';
            }
          ?>
        </div>
      </div>
    <?php endif; ?>

    <?php
    // FEATURES ANS TECH ACCORDION ITEM
    if ( ! empty( $filtered_productfeatures ) ) :
      $filtered_productfeatures_count = count($filtered_productfeatures);
      $filtered_productfeatures_count_ceil = ceil($filtered_productfeatures_count/3);
      $filtered_productfeatures_chunks = array_chunk( $filtered_productfeatures, $filtered_productfeatures_count_ceil, true );
      $colsx4 = array_chunk( $filtered_productfeatures, ceil(count($filtered_productfeatures)/3), true );
      $arrayalltechs = array();
		?>
      <div class="acc_item">
        <h5 class="accordion"><span class="acc_control"></span><span class="acc_heading">Features and Tech</span></h5>
        <div class="accordion_content" style="display: none;" data-chunks="<?php echo $filtered_productfeatures_count_ceil; ?>">
          <?php
            foreach ( $colsx4 as $rowcolumn4 ) {
              echo '<div class="' . $attributeclasses . '"><div class="specstable">';
                foreach ( $rowcolumn4 as $key4 => $value4 ) {
                  /*if (
                    strtolower($key4) != "made-in-canada.png" && strtolower($key4) != "none" &&
                    strtolower($key4) != "water resistent (material)" && strtolower($key4) != "oil/water repelleant (treatment)"
                  ) {*/
                    if ( ! in_array(strtolower($key4), $arrayalltechs) ) {
                      $arrayalltechs[] = strtolower($key4);

                      echo '<div class="specsrow 3">'
                            . '<div class="specscell" data-title="' . $key4 . '">'
                              . '<h6>' . $key4 . '</h6>'
                            . '</div>'
                            . '<div class="specscell" data-title="' . $value4 . '">' . $value4 . '</div>'
                          . '</div>';
                    }
                  /*}*/
                }

              echo '</div></div>';
            }
          ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

	<div class="clear"></div>

  <?php
  /*
  if ($product->get_sku() !== '') {
  ?>
    <div class="<?php echo $attributeclasses; ?>">
      <div class="addinfoprod"><?php _e( 'Product ID:', 'woocommerce' ); ?><h6><?php echo ( $sku = $product->get_sku() ) ? $sku : __( 'N/A', 'woocommerce' ); ?></h6></div>
    </div>
  <?php
    $rowcounter++;
  }


  $unspsc = get_post_meta( get_the_ID(), 'unspsc', true );

  if ( $unspsc != "") {
  ?>
		<div class="<?php echo $attributeclasses; ?>">
      <div class="addinfoprod"><?php echo _e( 'UNSPSC CODE', 'woocommerce' ); ?><h6><?php echo $unspsc; ?></h6></div>
    </div>
	<?php
		$rowcounter++;
	}


  $skidquantity = get_post_meta( get_the_ID(), 'skidquantity', true );

  if ( $skidquantity != "") {
  ?>
		<div class="<?php echo $attributeclasses; ?>">
      <div class="addinfoprod"><?php echo _e( 'Skid Quantity', 'woocommerce' ); ?><h6><?php echo $skidquantity; ?></h6></div>
    </div>
	<?php
		$rowcounter++;
	}


  $shippackquantity = get_post_meta( get_the_ID(), 'shippackquantity', true );

  if ( $shippackquantity != "") {
  ?>
		<div class="<?php echo $attributeclasses; ?>">
      <div class="addinfoprod"><?php echo _e( 'Ship Pack Quantity', 'woocommerce' ); ?><h6><?php echo $shippackquantity; ?></h6></div>
    </div>
	<?php
		$rowcounter++;
	}


	if ( $rowcounter % 4 == 0) {
	  echo '<div class="clear"></div>';
	}


  if ( $product->has_weight() ) {
    $has_row = true;
  ?>
		<div class="<?php echo $attributeclasses; ?>">
      <div class="addinfoprod"><?php _e( 'Weight', 'woocommerce' ) ?><h6><?php echo $product->get_weight() . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) ); ?></h6></div>
    </div>
	<?php
		$rowcounter++;
	}


	$dimensionsz = wc_format_dimensions($product->get_dimensions(false));

	if ( $product->has_dimensions() ) {
    $has_row = true;
  ?>
		<div class="<?php echo $attributeclasses; ?>">
      <div class="addinfoprod"><?php echo _e( 'Case Dimensions', 'woocommerce' ); ?><?php echo '<h6>'.$dimensionsz .'</h6>'; ?></div>
    </div>
  <?php
		$rowcounter++;
	}


  foreach ( $attributes as $attribute ) {
		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
			continue;
		} else {
			$has_row = true;
		}

		$mymeta_datais = '';

		if ( $attribute['name'] !== 'pa_recommended' &&  $attribute['name'] !== 'pa_application' &&  $attribute['name'] !== 'application' ) {
			if ( $attribute['is_taxonomy']  ) {
        $values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) );
        // echo apply_filters( 'woocommerce_attribute',  wptexturize( implode( ', ', $values ) ), $attribute, $values );
        $mymeta_datais =  wptexturize( implode( ', ', $values ));
			} else {
        // Convert pipes to commas and display values
        $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
        // echo wptexturize( implode( ', ', $values ) );
        // echo apply_filters( 'woocommerce_attribute',  '<strong>'. $attribute . '</strong> ' .  wptexturize( implode( ', ', $values ) ) );
        $mymeta_datais =  wptexturize( implode( ', ', $values )) . ' ';
        // echo apply_filters( 'woocommerce_attribute',  wptexturize( implode( ', ', $values ) ), $attribute, $values );
			}
		}

		if ($mymeta_datais != '') {
		?>
		  <div class="<?php echo $attributeclasses; ?>">
        <div class="addinfoprod"><?php echo wc_attribute_label( $attribute['name'] ); ?><h6><?php echo $mymeta_datais; ?></h6></div>
			</div>
	  <?php
      $rowcounter++;
	  }

	  if( $rowcounter % 4 == 0) {
	  	echo '<div class="clear"></div>';
	  }
	}

  if ( $has_row ) {
    echo ob_get_clean();
  } else {
    ob_end_clean();
  }
  */
  ?>
</div>