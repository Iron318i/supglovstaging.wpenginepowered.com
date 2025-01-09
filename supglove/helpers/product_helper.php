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

add_action('woocommerce_product_options_shipping_product_data', 'woocommerce_product_helper_add_custom_shipping_fields');
function woocommerce_product_helper_add_custom_shipping_fields(){
  global $woocommerce, $post;

  echo '<div class="product_custom_field">';
  woocommerce_wp_text_input(
      array(
          'id' => 'sold_in_multiples',
          'label'   => 'Sold in Multiple of',
      )
  );
  echo '</div>';

  echo '<div class="product_custom_field">';
  woocommerce_wp_text_input(
      array(
          'id' => 'case_quantity',
          'label'   => 'Case Quantity',
      )
  );
  echo '</div>';
}

// save addded fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_helper_save_custom_fields');
function woocommerce_product_helper_save_custom_fields($post_id){
    update_post_meta( $post_id, '_enquired_product', (isset($_POST['_enquired_product']) ? $_POST['_enquired_product'] : '') );
    update_post_meta( $post_id, '_p65_product', (isset($_POST['_p65_product']) ? $_POST['_p65_product'] : '') );
    update_post_meta( $post_id, 'hs_code', (isset($_POST['hs_code']) ? $_POST['hs_code'] : '') );
    update_post_meta( $post_id, 'ukca_code', (isset($_POST['ukca_code']) ? $_POST['ukca_code'] : '') );
    update_post_meta( $post_id, 'sold_in_multiples', (isset($_POST['sold_in_multiples']) ? $_POST['sold_in_multiples'] : '') );
    update_post_meta( $post_id, 'case_quantity', (isset($_POST['case_quantity']) ? $_POST['case_quantity'] : '') );
    update_post_meta( $post_id, 'dimensions_width', (isset($_POST['dimensions_width']) ? $_POST['dimensions_width'] : '') );
    update_post_meta( $post_id, 'dimensions_length', (isset($_POST['dimensions_length']) ? $_POST['dimensions_length'] : '') );
    update_post_meta( $post_id, 'thumbhole', (isset($_POST['thumbhole']) ? $_POST['thumbhole'] : '') );
    update_post_meta( $post_id, 'made_to_order', (isset($_POST['made_to_order']) ? $_POST['made_to_order'] : '') );
    update_post_meta( $post_id, 'show_info_table', (isset($_POST['show_info_table']) ? $_POST['show_info_table'] : '') );
    update_post_meta( $post_id, 'info_table_id', (isset($_POST['info_table_id']) ? $_POST['info_table_id'] : '') );
    update_post_meta( $post_id, 'show_info_table_in_tab', (isset($_POST['show_info_table_in_tab']) ? $_POST['show_info_table_in_tab'] : '') );
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

add_filter( 'woocommerce_product_data_tabs', 'add_info_table_data_tab', 10, 1 );
function add_info_table_data_tab( $tabs ) {
  $tabs['infotabledata'] = array(
      'label'   =>  'Info Table Data',
      'icon'  => '',
      'target'  =>  'info_table_data',
      'priority' => 10,
      'class'   => array()
  );
  return $tabs;
}

add_action( 'woocommerce_product_data_panels', 'info_table_data' );
function info_table_data() {

  $args = array(
    'numberposts' => -1,
    'post_type'   => 'info_table'
  );
  $tables_posts = get_posts( $args );

  $tables = [
    '' => 'Select ... '
  ];

  foreach ($tables_posts as $table) {
    $tables[$table->ID] = $table->post_title;
  }

  echo '<div id="info_table_data" class="panel woocommerce_options_panel">';
  woocommerce_wp_checkbox(
    array(
        'id' => 'show_info_table',
        'name' => 'show_info_table',
        'label'   => 'Show Info Table',
        'desc_tip' => true,
        'description'		=> __( 'Check if you want to show additional info table on product page', 'woocommerce' ),
    )
  );
  woocommerce_wp_select(
    array(
        'id' => 'info_table_id',
        'name' => 'info_table_id',
        'label'   => 'Select Info Table',
        'desc_tip' => true,
        'description'		=> __( 'Select what table do you want to show on product page', 'woocommerce' ),
        'options' => $tables,
    )
  );
  woocommerce_wp_checkbox(
    array(
        'id' => 'show_info_table_in_tab',
        'name' => 'show_info_table_in_tab',
        'label'   => 'Show In Option Tab',
        'desc_tip' => true,
        'description'		=> __( 'Check if you want to show additional info table in Option tab', 'woocommerce' ),
    )
  );
  echo '<hr>';
  woocommerce_wp_text_input(
      array(
          'id' => 'dimensions_width',
          'name' => 'dimensions_width',
          'label'   => 'Width (in)',
          'desc_tip' => true,
				  'description'		=> __( 'Enter width in inches', 'woocommerce' ),
      )
  );
  woocommerce_wp_text_input(
    array(
        'id' => 'dimensions_length',
        'name' => 'dimensions_length',
        'label'   => 'Length (in)',
        'desc_tip' => true,
        'description'		=> __( 'Enter length in inches', 'woocommerce' ),
    )
  );
  woocommerce_wp_checkbox(
    array(
        'id' => 'thumbhole',
        'name' => 'thumbhole',
        'label'   => 'Thumbhole',
        'desc_tip' => true,
        'description'		=> __( 'Check if has thumbhole', 'woocommerce' ),
    )
  );
  woocommerce_wp_checkbox(
    array(
        'id' => 'made_to_order',
        'name' => 'made_to_order',
        'label'   => 'Made To Order',
        'desc_tip' => true,
        'description'		=> __( 'Check if made to order', 'woocommerce' ),
    )
  );
  echo '</div>';
}

function action_admin_head() {
  echo '<style>
      #woocommerce-product-data ul.wc-tabs li.infotabledata_options a::before {
          content: "\f535";
      }
  </style>';
}
add_action( 'admin_head', 'action_admin_head' );


function my_edit_wc_attribute_short_title() {
  $id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
  $value = $id ? get_option( "wc_attribute_short_title-$id" ) : '';
  ?>
      <tr class="form-field">
          <th scope="row" valign="top">
              <label for="my-field">Short title</label>
          </th>
          <td>
              <input name="short_title" id="short_title" type="text" value="<?php echo esc_attr( $value ); ?>" />
          </td>
      </tr>
  <?php
}
add_action( 'woocommerce_after_add_attribute_fields', 'my_edit_wc_attribute_short_title' );
add_action( 'woocommerce_after_edit_attribute_fields', 'my_edit_wc_attribute_short_title' );

function my_save_wc_attribute_short_title( $id ) {
  if ( is_admin() && isset( $_POST['short_title'] ) ) {
      $option = "wc_attribute_short_title-$id";
      update_option( $option, sanitize_text_field( $_POST['short_title'] ) );
  }
}
add_action( 'woocommerce_attribute_added', 'my_save_wc_attribute_short_title' );
add_action( 'woocommerce_attribute_updated', 'my_save_wc_attribute_short_title' );

add_action( 'woocommerce_attribute_deleted', function ( $id ) {
  delete_option( "wc_attribute_short_title-$id" );
});

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
