<?php

function enquire_products_js() {
  wp_enqueue_script('enquire-products-script', get_template_directory_uri() . '/js/enquire-products.js');
}
add_action('wp_enqueue_scripts', 'enquire_products_js');


// display enquired checkbox
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_helper_add_custom_fields');
function woocommerce_product_helper_add_custom_fields(){
    global $woocommerce, $post;
    echo '<div class="product_custom_field">';
    woocommerce_wp_checkbox(
        array(
            'id' => '_enquired_product',
            'label'   => 'Enquired product',
            'description' => 'Check if product is enquired.',
            'desc_tip' => true
        )
    );
    echo '</div>';

    echo '<div class="product_custom_field">';
    woocommerce_wp_checkbox(
        array(
            'id' => '_p65_product',
            'label'   => 'P65 warning product',
            'description' => 'Check if you need warning message.',
            'desc_tip' => true
        )
    );
    echo '</div>';
}

// save addded fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_helper_save_custom_fields');
function woocommerce_product_helper_save_custom_fields($post_id){
    update_post_meta($post_id, '_enquired_product', $_POST['_enquired_product']);
    update_post_meta($post_id, '_p65_product', $_POST['_p65_product']);
    update_post_meta($post_id, 'hs_code', $_POST['hs_code']);
    update_post_meta($post_id, 'ukca_code', $_POST['ukca_code']);
}


// add new section to woo products settings
add_filter( 'woocommerce_get_sections_products' , 'freeship_add_settings_tab' );
function freeship_add_settings_tab( $settings_tab ){
     $settings_tab['product_warning_messages'] = __( 'Product Messages' );
     return $settings_tab;
}

add_filter( 'woocommerce_get_settings_products' , 'freeship_get_settings' , 10, 2 );
function freeship_get_settings( $settings, $current_section ) {
  $custom_settings = array();
  if( 'product_warning_messages' == $current_section ) {
    $custom_settings =  array(
      array(
        'name' => __( 'Messages for products' ),
        'type' => 'title',
        'desc' => __( 'Different messages for products' ),
        'id'   => 'warning_messages'
		  ),
      array(
				'name' => __( 'P65 Warning Message' ),
				'type' => 'textarea',
				'desc' => __( 'P65 Warning Message'),
				'desc_tip' => true,
				'id'	=> 'p65_warning'
        // $p65_message = get_option( 'p65_warning' )
			),
      array( 'type' => 'sectionend', 'id' => 'warning_messages' ),
		);
    return $custom_settings;
  } else {
    return $settings;
  }
}

// need do add /inc/backend/product-meta-box.php -> create_product_extra_fields2()

// echo '<div class="product_custom_field">';
// //Custom Product  Textarea
// woocommerce_wp_textarea_input(
//     array(
//         'id' => 'ukca_code',
//         'placeholder' => '',
//         'label' => __('ukca Code', 'woocommerce')
//     )
// );
// echo '</div>';

// echo '<div class="product_custom_field">';
// //Custom Product  Textarea
// woocommerce_wp_textarea_input(
//     array(
//         'id' => 'hs_code',
//         'placeholder' => '',
//         'label' => __('hs Code', 'woocommerce')
//     )
// );
// echo '</div>';

