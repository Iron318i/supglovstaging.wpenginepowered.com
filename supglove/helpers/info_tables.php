<?php function create_product_info_table_posttype() {
  $args = array(
    'labels' => array(
      'menu_name' => 'Product Info Tables'
    ),
    'supports' => [ 'title' ],
    'menu_position' => 25,
    'public' => true,
    'has_archive' => false,
    'menu_icon' => 'dashicons-editor-table',
    'publicly_queryable'  => false,
  );
  register_post_type( 'info_table', $args );
}
add_action( 'init', 'create_product_info_table_posttype' );

// Register new version of table editor
function wporg_add_custom_box() {
	$screens = [ 'info_table' ];
	foreach ( $screens as $screen ) {
		add_meta_box(
			'wporg_box_id',
			'Table editor',
			'show_table_generator',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function show_table_generator( $post ) {
	?>
    <div class="table-editor">
      <div class="table-editor__controls">
        <div class="label hidden">Create new table:</div>
        <div class="new_table_form">
          <div class="form-group">
            <label for="columns" style="font-weight: bold;">Number of columns:</label>
            <input type="number" id="columns" name="columns" min="2">
          </div>
          <div class="form-group">
            <label for="columns" style="font-weight: bold;">Number of rows:</label>
            <input type="number" id="rows" name="rows" min="2">
          </div>
          <button type="button" class="button button-primary button-large">Create</button>
          <div class="button-secondary disabled" id="remove-table" onClick="removeTable()" style="height: 32px; align-self: end;">Delete table</div>
        </div>
      </div>
      <div class="table-editor__body">
        <div class="table">
          <div id="table-wrapper"></div>
        </div>
      </div>
    </div>
	<?php
}

// Register general table settings
add_filter( 'rwmb_meta_boxes', 'info_table_general_settings_register_metabox' );
function info_table_general_settings_register_metabox( $meta_boxes ) {
  $prefix = 'info_table';
  $meta_boxes[] = [
    'title'   => esc_html__( 'General Settings', 'online-generator' ),
    'id'      => 'info_table_general_settings_metabox',
    'post_types' => ['info_table'],
    'context' => 'normal',
    'fields'  => [
      [
        'type' => 'text',
        'name' => esc_html__( 'Table Title', 'online-generator' ),
        'id'   => $prefix . '_table_title',
      ],
      [
        'type' => 'text',
        'name' => esc_html__( 'Table Subtitle', 'online-generator' ),
        'id'   => $prefix . '_table_subtitle',
      ],
      [
        'type' => 'wysiwyg',
        'name' => esc_html__( 'Table holder', 'online-generator' ),
        'raw'  => true,
        'id'   => $prefix . '_result',
        'options' => [
          'default_editor' => 'mceu_36'
        ]
      ],
      [
        'type' => 'textarea',
        'name' => esc_html__( 'Table textarea', 'online-generator' ),
        'id'   => $prefix . '_textarea',
      ],
    ],
  ];
  return $meta_boxes;
}

add_action( 'admin_print_scripts-post-new.php', 'info_table_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'info_table_admin_script', 11 );

function info_table_admin_script() {
    global $post_type;
    if( 'info_table' == $post_type ) {
      wp_enqueue_script( 'info_table-admin-script', get_stylesheet_directory_uri() . '/helpers/js/info_table.js?v='.time() );
      wp_enqueue_style( 'info_table-admin-style', get_stylesheet_directory_uri() . '/helpers/css/info_table.css?v='.time() );
    }
}

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
  global $post;
  $show_table = get_post_meta($post->ID, 'show_info_table', true );
  $table_id = get_post_meta($post->ID, 'info_table_id', true );
  $new_tab = get_post_meta($post->ID, 'show_info_table_in_tab', true );

  if (!empty($show_table) && !empty($table_id) && $new_tab) {

    $args = [
      'title' =>  __( 'Options', 'woocommerce' ),
      'priority' 	=> 50,
      'callback' 	=> 'woo_new_product_tab_content'
    ];

    $tabs['new_tab'] = $args;
  }

  return $tabs;
}

//  The new tab content
function woo_new_product_tab_content() {
  renderTable(true);
}

function tableExists() {
  global $post;

  $show_in_tab = get_post_meta($post->ID, 'show_info_table_in_tab', true );

  if ($show_in_tab == 'yes' && !$tab) return;
	
  $table_id = get_post_meta($post->ID, 'info_table_id', true );
	
  if ($table_id == false || $table_id == '') return;
	
  $meta_fields = get_post_custom(intval($table_id));
	
  if (empty($meta_fields)) return;

  $table = ((!empty($meta_fields['info_table_textarea']) && is_array($meta_fields['info_table_textarea'])) ? $meta_fields['info_table_textarea'][0] : '');

  if (!empty($table)) {
    return true;
  } else {
    return false;
  }
}

function renderTable($tab) {
  global $post;

  $show_in_tab = get_post_meta($post->ID, 'show_info_table_in_tab', true );

  if ($show_in_tab == 'yes' && !$tab) return;
	
  $table_id = get_post_meta($post->ID, 'info_table_id', true );
	
  if ($table_id == false || $table_id == '') return;
	
  $meta_fields = get_post_custom(intval($table_id));
	
  if (empty($meta_fields)) return;

  $table = ((!empty($meta_fields['info_table_textarea']) && is_array($meta_fields['info_table_textarea'])) ? $meta_fields['info_table_textarea'][0] : '');
  $title = ((!empty($meta_fields['info_table_table_title']) && is_array($meta_fields['info_table_table_title'])) ? $meta_fields['info_table_table_title'][0] : '');
  $subtitle = ((!empty($meta_fields['info_table_table_subtitle']) && is_array($meta_fields['info_table_table_subtitle'])) ? $meta_fields['info_table_table_subtitle'][0] : '');

  if ($show_in_tab == 'yes') $title = str_replace('Options', '', $title);

  $wrapper_class = $tab ? 'product-info-table product-info-table--tab' : 'product-info-table';

  if (!empty($table)) {
    echo ('<div class="' . $wrapper_class . '">');
    echo '<div class="product-info-table__title">';
    echo $title;
    echo '</div>';
    echo '<div class="product-info-table__subtitle">';
    echo $subtitle;
    echo '</div>';
    echo '<div class="product-info-table__table">';
    echo '<div class="table-wrapper">';
    echo $table;
    echo '</div>';
    echo '</div>';
    echo '</div>';
  } else {
    return false;
  }
}

// function woo_new_product_tab_content() {
//   // The new tab content
//   echo '<p>Lorem Ipsum</p>';
// }

// function my_custom_save_post($post_id) {
//   $post_custom = get_post_custom(get_the_ID());

//   $rows = $post_custom['info_table_data_rows'] ? unserialize($post_custom['info_table_data_rows'][0]) : [];
//   $columns = $post_custom['info_table_data_columns'] ? unserialize($post_custom['info_table_data_columns'][0]) : [];

//   $result_table = '';

//   if (count($rows) && count($columns)) {
//     $table_header = ['Model'];
//     $table_body = [];

//     // Build table header //
//     foreach ($columns as $column) {
//       [$column_header, $column_field] = json_decode($column);
//       $table_header[] = $column_header;
//     }

//     foreach ($rows as $product_id) {
//       $row = [];
//       $product = wc_get_product( $product_id );

//       $row[]['value'] = $product->get_sku();

//       foreach ($columns as $column) {
//         [$column_header, $column_field] = json_decode($column);

//         if (substr($column_field, 0, 3) == 'pa_') {
//           $terms = array_column(wc_get_product_terms($product_id, $column_field), 'name');
//           if (count($terms) > 1) {
//             $row[] = [
//               'value' => $terms[0] . ' - ' . end($terms),
//               'class' => 'merged-values'
//             ];
//           } else {
//             $row[] = ['value' => $terms[0]];
//           }
//         } else {
//           $column_value = get_post_meta($product_id, $column_field, true );
//           $row[] = [
//             'value' => $column_value == 'yes' ? '' : $column_value,
//             'class' => $column_value == 'yes' ? 'green-dot' : false
//           ];
//         }
//       }
//       $table_body[] = $row;
//     }
//   }

//   if (count($table_header) || count($table_body)) {
//     $result_table .= '<div class="table-wrapper">';
//     $result_table .= '<table class="table">';

//     // HEADER START
//     $result_table .= '<tr>';
//     foreach ($table_header as $item) {
//       $result_table .= '<th>' . $item . '</th>';
//     }
//     $result_table .= '</tr>';
//     // HEADER END

//     // BODY START
//     foreach ($table_body as $row) {
//       $result_table .= '<tr>';
//       foreach ($row as $item) {
//         $result_table .= '<td class=' . $item['class'] . '>' . $item['value'] . '</td>';
//       }
//       $result_table .= '<tr>';
//     }
//     // BODY END

//     $result_table .= '</table>';
//     $result_table .= '</div>';
//   }

//   $result = json_encode($result_table);

//   delete_post_meta($post_id, 'table');
//   add_post_meta($post_id, 'table', $result_table, false);
// }
// add_action( 'save_post_info_table', 'my_custom_save_post' );



// Register metaboxes for Info Table Rows
// add_filter( 'rwmb_meta_boxes', 'info_table_rows_register_metabox' );
// function info_table_rows_register_metabox( $meta_boxes ) {
//   $prefix = 'info_table';
//   $meta_boxes[] = [
//     'title'   => esc_html__( 'Rows Settings', 'online-generator' ),
//     'id'      => 'info_table_rows_metabox',
//     'post_types' => ['info_table'],
//     'context' => 'normal',
//     'fields'  => [
//       [
//         'field_type' => 'select_advanced',
//         'type'       => 'post',
//         'name'       => esc_html__( 'Products in Row', 'online-generator' ),
//         'id'         => $prefix . '_data_rows',
//         'desc'       => esc_html__( 'Select products in the same order you want see on a product page', 'online-generator' ),
//         'post_type'  => 'product',
//         'clone'      => true,
//       ],
//     ],
//   ];
//   return $meta_boxes;
// }

// Register metaboxes for Info Table Columns
// add_filter( 'rwmb_meta_boxes', 'info_table_columns_register_metabox' );
// function info_table_columns_register_metabox( $meta_boxes ) {

//   $options = [];
//   $slugs = get_object_taxonomies( 'product' );

//   foreach($slugs as $slug) {
//     if (substr($slug, 0, 3) == 'pa_') {
//       $taxonomy = get_taxonomy($slug);
//       $taxonomy_id = wc_attribute_taxonomy_id_by_name($slug);
//       $taxonomy_short_title = get_option('wc_attribute_short_title-' . $taxonomy_id);
//       $taxonomy_header = strlen($taxonomy_short_title) ? $taxonomy_short_title : $taxonomy->label;
//       $options[json_encode([$taxonomy_header, $slug])] = $taxonomy->label;
//     }
//   }

//   $additional_options = [
//     json_encode(['Thumbhole', 'thumbhole']) => 'Thumbhole',
//     json_encode(['Made to order', 'made_to_order']) => 'Made To Order',
//     json_encode(['Length, in', 'dimensions_length']) => 'Length, IN',
//     json_encode(['Width, in', 'dimensions_width']) => 'Width, IN',
//   ];

//   $options = array_merge($additional_options, $options);

//   $prefix = 'info_table';
//   $meta_boxes[] = [
//     'title'   => esc_html__( 'Columns Settings', 'online-generator' ),
//     'id'      => 'info_table_columns_metabox',
//     'post_types' => ['info_table'],
//     'context' => 'normal',
//     'fields'  => [
//       [
//         'type'       => 'select_advanced',
//         'name'       => esc_html__( 'Options in Column', 'online-generator' ),
//         'id'         => $prefix . '_data_columns',
//         'options'    => $options,
//         'clone'      => true,
//       ],
//     ],
//   ];
//   return $meta_boxes;
// }
