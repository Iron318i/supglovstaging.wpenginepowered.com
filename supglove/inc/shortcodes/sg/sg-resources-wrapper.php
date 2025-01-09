<?php 
/**
 * @package Supglove
 */
 
if ( !empty($args['resources_atts']) && is_array($args['resources_atts']) ) {
  $atts = $args['resources_atts'];
} else {
  $atts = array();
}

if ( !isset($atts['post_types']) ) {
  $atts['post_types'] = 'any';
} else if ( is_array($atts['post_types']) ) {
  $atts['post_types'] = implode( ',', $atts['post_types'] );
}

if ( !isset($atts['types']) ) {
  $atts['types'] = '';
} else if ( is_array($atts['types']) ) {
  $atts['types'] = implode( ',', $atts['types'] );
}

if ( !isset($atts['exclude_types']) ) {
  $atts['exclude_types'] = '';
} else if ( is_array($atts['exclude_types']) ) {
  $atts['exclude_types'] = implode( ',', $atts['exclude_types'] );
}

if ( !isset($atts['topic']) || !is_string($atts['topic']) ) {
  $atts['topic'] = '';
}

if ( !isset($atts['default_language']) || !is_string($atts['default_language']) ) {
  $atts['default_language'] = '';
}

if ( !isset($atts['posts_number']) ) {
  $atts['posts_number'] = -1;
}

if ( !isset($atts['featured_posts']) ) {
  $atts['featured_posts'] = '';
} else if ( is_array($atts['featured_posts']) ) {
  $atts['featured_posts'] = implode( ',', $atts['featured_posts'] );
}

if ( !isset($atts['featured_links']) ) {
  $atts['featured_links'] = '';
} else if ( is_array($atts['featured_links']) ) {
  $atts['featured_links'] = implode( ' ', $atts['featured_links'] );
}

if ( !isset($atts['load_subtypes']) ) {
  $atts['load_subtypes'] = 0;
}

if ( !isset($atts['hide_empty_subtypes']) ) {
  $atts['hide_empty_subtypes'] = 0;
}

if ( !isset($atts['load_top_types']) ) {
  $atts['load_top_types'] = 0;
}

if ( !isset($atts['hide_empty_top_types']) ) {
  $atts['hide_empty_top_types'] = 0;
}

if ( !isset($atts['layout']) ) {
  $atts['layout'] = 'default';
}

if ( !isset($atts['hide_tags']) ) {
  $atts['hide_tags'] = 0;
}

if ( !isset($atts['load_type_tags']) ) {
  $atts['load_type_tags'] = 0;
}

if ( !isset($atts['post_link_text']) ) {
  $atts['post_link_text'] = _x( 'Read Now', '[sg_resources_filter_results]', 'SuperiorGlove');
}

if ( !isset($atts['show_post_link_arrow']) ) {
  $atts['show_post_link_arrow'] = 0;
}

if ( !isset($atts['hide_section_heading']) ) {
  $atts['hide_section_heading'] = 0;
}

if ( !isset($atts['section_heading']) ) {
  $atts['section_heading'] = '';
}

if ( !isset($atts['section_link']) ) {
  $atts['section_link'] = '';
} else if ( $atts['section_link'] ) {
  $weglot_site_languages_list = null;
  $weglot_site_language = null;
  $weglot_original_language = null;
  $weglot_site_language_obj = null;
  $weglot_language_services = null;
  $weglot_request_url_services = null;

  if ( 
    function_exists('weglot_get_destination_languages') &&
    function_exists('weglot_get_current_language') && 
    function_exists('weglot_get_original_language') && 
    function_exists('weglot_get_service') 
  ) {
    $weglot_site_languages_list = weglot_get_destination_languages();
    
    if ( !empty($weglot_site_languages_list) ) {
      $weglot_original_language = weglot_get_original_language();
      $weglot_site_language = weglot_get_current_language();
    }
    
    if ( $weglot_original_language /*|| $weglot_site_language */) {
      $weglot_language_services = weglot_get_service( 'Language_Service_Weglot' );
      $weglot_request_url_services = weglot_get_service( 'Request_Url_Service_Weglot' );
    }
    
    if ( $weglot_site_language && !empty($weglot_language_services) && !empty($weglot_request_url_services) ) {
      $weglot_site_language_obj = $weglot_language_services->get_language_from_internal( $weglot_site_language );
    }
    
    if  ( $weglot_site_language_obj ) {
      $weglot_section_url_object = $weglot_request_url_services->create_url_object( $atts['section_link'] );
    }
    
    if ( !empty($weglot_section_url_object) ) {
      $weglot_section_link = $weglot_section_url_object->getForLanguage( $weglot_site_language_obj );
    }
    
    if ( !empty($weglot_section_link) ) { 
      $atts['section_link'] = $weglot_section_link;
    }
  }
}

if ( !isset($atts['section_link_text']) ) {
  $atts['section_link_text'] = _x( 'View All', '[sg_resources_filter_results]', 'SuperiorGlove');
}

if ( !isset($atts['not_found_text']) ) {
  $atts['not_found_text'] = _x( 'Resources not found.', '[sg_resources_filter_results]', 'SuperiorGlove');
}

if ( !isset($atts['orderby']) ) {
  $atts['orderby'] = '';
}

if ( !isset($atts['order']) ) {
  $atts['order'] = '';
}
?>
<<?php echo ( 
  (!empty($args['resources_posts_are_empty']) && !empty($args['resources_subtypes_are_empty']) && !empty($args['resources_top_types_are_empty'])) 
  ? 'section' : 'div' 
); ?> 
  class="sg-resources sg-resources--layout-<?php echo $args['resources_layout'] 
    . ( !empty($atts['load_subtypes']) ? ' sg-resources--load-subtypes' : '' )
    . ( !empty($atts['load_top_types']) ? ' sg-resources--load-toptypes' : '' )
    . ( !empty($args['resources_posts_are_empty']) ? ' sg-resources--no-posts' : '' ) 
    . ( !empty($args['resources_subtypes_are_empty']) ? ' sg-resources--no-subtypes' : '' ) 
    . ( !empty($args['resources_top_types_are_empty']) ? ' sg-resources--no-toptypes' : '' ) 
    . ( 
      (
        !empty($args['resources_posts_are_empty']) && 
        !empty($args['resources_subtypes_are_empty']) && 
        !empty($args['resources_top_types_are_empty'])
      ) 
      ? ' sg-resources--empty' : '' 
    ) 
    . ' ' . esc_attr( implode(' ', explode(',', $atts['types'])) ); ?>"
  <?php if ( !empty($args['resources_filter_id']) ) { echo ' data-filter="' . esc_attr( $args['resources_filter_id'] ) . '" '; } ?>
>
  <section 
    <?php if ( !empty($args['resources_section_id']) ) { echo 'id="' . esc_attr($args['resources_section_id']) . '" '; } ?>
    class="sg-resources-section sg-resources-section--layout-<?php echo $args['resources_layout'] 
      . ( !empty($args['resources_section_class']) ? ' ' . esc_attr($args['resources_section_class']) : '' ); 
    ?>" 
    <?php if ( !empty($args['resources_filter_id']) ) { echo 'data-filter="' . esc_attr( $args['resources_filter_id'] ) . '" '; } ?>
    data-section_class="<?php echo esc_attr( $atts['class'] ); ?>"
    data-post_types="<?php echo esc_attr( $atts['post_types'] ); ?>" 
    data-types="<?php echo esc_attr( $atts['types'] ); ?>" 
    data-exclude_types="<?php echo esc_attr( $atts['exclude_types'] ); ?>" 
    data-topic="<?php echo esc_attr( $atts['topic'] ); ?>" 
    data-default_language="<?php echo esc_attr( $atts['default_language'] ); ?>" 
    data-posts_number="<?php echo esc_attr( $atts['posts_number'] ); ?>" 
    data-featured_posts="<?php echo esc_attr( $atts['featured_posts'] ); ?>" 
    data-featured_links="<?php echo esc_attr( $atts['featured_links'] ); ?>" 
    data-load_subtypes="<?php echo esc_attr( $atts['load_subtypes'] ); ?>" 
    data-hide_empty_subtypes="<?php echo esc_attr( $atts['hide_empty_subtypes'] ); ?>" 
    data-load_top_types="<?php echo esc_attr( $atts['load_top_types'] ); ?>" 
    data-hide_empty_top_types="<?php echo esc_attr( $atts['hide_empty_top_types'] ); ?>" 
    data-orderby="<?php echo esc_attr( $atts['orderby'] ); ?>" 
    data-order="<?php echo esc_attr( $atts['order'] ); ?>" 
    data-layout="<?php echo esc_attr( $atts['layout'] ); ?>" 
    data-type_layout="<?php echo esc_attr( $atts['type_layout'] ); ?>" 
    data-hide_tags="<?php echo esc_attr( $atts['hide_tags'] ); ?>" 
    data-load_type_tags="<?php echo esc_attr( $atts['load_type_tags'] ); ?>" 
    data-post_link_text="<?php echo esc_attr( $atts['post_link_text'] ); ?>" 
    data-show_post_link_arrow="<?php echo esc_attr( $atts['show_post_link_arrow'] ); ?>" 
    data-hide_section_heading="<?php echo esc_attr( $atts['hide_section_heading'] ); ?>" 
    data-section_heading="<?php echo esc_attr( $atts['section_heading'] ); ?>" 
    data-section_link="<?php echo esc_attr( $atts['section_link'] ); ?>" 
    data-section_link_text="<?php echo esc_attr( $atts['section_link_text'] ); ?>" 
    data-not_found_text="<?php echo esc_attr( $atts['not_found_text'] ); ?>" 
  >
    <div class="sg-resources-container sg-resources-container--layout-<?php echo $args['resources_layout'] ; ?>">
      <?php if ( !empty($args['resources_html']) ) { echo $args['resources_html']; } ?>
    </div>
    <div class="sg-resources-overlay">
      <svg class="sg-resources-overlay__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100">
        <path fill="currentColor" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
          <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
        </path>
        <path fill="currentColor" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
          <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="-360 50 50" repeatCount="indefinite" />
        </path>
        <path fill="currentColor" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5L82,35.7z">
          <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite" />
        </path>
      </svg>
    </div>
  </section>
</<?php echo ( 
  (!empty($args['resources_posts_are_empty']) && !empty($args['resources_subtypes_are_empty']) && !empty($args['resources_top_types_are_empty'])) 
  ? 'section' : 'div' 
); ?>>
