<?php

global $pagenow;
$allowed_pages = ['term.php', 'edit-tags.php'];

if (in_array($pagenow, $allowed_pages)) {
  $attribute_taxonomies = wc_get_attribute_taxonomies();
  $attribute_taxonomies_arr = array();

  foreach($attribute_taxonomies as $attribute_taxonomie) {
    array_push($attribute_taxonomies_arr, 'pa_'.$attribute_taxonomie->attribute_name);
  }

  $taxonomy_name = $_GET['taxonomy'] ?: $_POST['taxonomy'];

  if (!in_array($taxonomy_name, $attribute_taxonomies_arr)) return;

  // add custom column to terms table
  function add_custom_column_to_term_table($columns){
    $columns['hide_term_in_filter'] = 'Hide in filter';
    return $columns;
  }
  add_filter('manage_edit-'.$taxonomy_name.'_columns', 'add_custom_column_to_term_table');

  // add column values to terms table
  function add_custom_column_content_to_term_table( $content, $column_name, $term_id ) {
    $value = get_term_meta( $term_id, 'hide_term_in_filter', true );
    switch ( $column_name ) {
        case 'hide_term_in_filter':
            $content = $value;
            break;
        default:
            break;
    }
    return '<div style="text-align: center;">'.$content.'</div>';
  }
  add_filter( 'manage_'.$taxonomy_name.'_custom_column', 'add_custom_column_content_to_term_table', 10, 3 );

  // add custom field to term edit page
  function add_custom_field_to_term($term) {
    $value = get_term_meta( $term->term_id, 'hide_term_in_filter', true );
    ?>
      <tr class="form-field">
        <th><label for="horns">Hide term in filters</label></th>
        <td><input type="checkbox" id="hide_term_in_filter" name="hide_term_in_filter" value="1" <?= !empty($value) ? 'checked' : null ?>></td>
      </tr>
    <?php
  }
  add_action( $taxonomy_name . '_edit_form_fields', 'add_custom_field_to_term', 1, 10 );


  // save term custom field value
  function save_custom_field_in_term($term_id) {
    update_term_meta(
      $term_id,
      'hide_term_in_filter',
      sanitize_text_field( $_POST[ 'hide_term_in_filter' ] )
    );
  }

  add_action('edited_'.$taxonomy_name, 'save_custom_field_in_term');
}






