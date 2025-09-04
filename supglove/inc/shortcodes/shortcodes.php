<?php

/*
 * ArtsMarket Shortcodes
 */


// Add button to editor in Admin
add_action('admin_head', 'boc_add_button');


// Add buttons for our shortcodes
function boc_add_button() {
  if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
    add_filter('mce_external_plugins', 'add_plugin');
    add_filter('mce_buttons', 'register_button');
  }
}


function add_plugin( $plugin_array ) {
  $plugin_array['boc_shortcodes_dropdown'] = get_template_directory_uri() . '/inc/shortcodes/customcodes.js';

  return $plugin_array;
}


function register_button( $buttons ) {
  array_push($buttons, "boc_shortcodes_dropdown");

  return $buttons;
}



/*
 * Base Shortcodes
 */

// Spacing
function boc_shortcode_spacing( $atts ) {
  $atts = vc_map_get_attributes( 'boc_spacing', $atts );

  extract( $atts );

  return '<div class="boc_spacing ' . esc_attr( $css_classes ) . '" style="height: ' . esc_attr( $height ) . '"></div>';
}
add_shortcode( 'boc_spacing', 'boc_shortcode_spacing' );


// Button Link
if ( !function_exists('shortcode_boc_button') ) {
    function shortcode_boc_button( $atts, $content = null ) {
        $atts = vc_map_get_attributes( 'boc_button', $atts );
        extract( $atts );

        $target = ( $target ? " target='" . esc_attr($target) . "'" : '' );
        $icon = ( $icon ? " <i class='" . esc_attr($icon) . "'></i> " : '' );
        $icon_pos = ( $icon ? $icon_pos : '' );
        $icon_effect = ( ($icon && isset($icon_effect) && ($icon_effect != 'none')) ? $icon_effect : '' );
        $icon_before = ( $icon_pos == 'icon_pos_before' ? wp_kses_post($icon) : '' );
        $icon_after = ( $icon_pos == 'icon_pos_after' ? wp_kses_post($icon) : '' );

        // Default output
        $classes = 'buttonogs ' . esc_attr($size . ' ' . $color . ' ' . $icon_pos . ' ' . $icon_effect . ' ' . $css_classes);

        if (preg_match('/\?add-to-cart=(\d+)/', $href, $matches)) {
            $product_id = absint($matches[1]);
            $product = wc_get_product($product_id);

            if ($product) {
                $product_url = get_permalink($product_id);
                $product_sku = $product->get_sku();
                $product_name = $product->get_name();

                return '<a href="' . esc_url($href) . '" 
          aria-describedby="woocommerce_loop_add_to_cart_link_describedby_' . $product_id . '" 
          data-quantity="1" 
          class="' . $classes . 'product_type_simple add_to_cart_button ajax_add_to_cart" 
          data-product_id="' . $product_id . '" 
          data-product_sku="' . esc_attr($product_sku) . '" 
          aria-label="Add to cart: “' . esc_attr($product_name) . '”" 
          rel="nofollow" 
          data-success_message="“' . esc_attr($product_name) . '” has been added to your cart">'
                    .'<span>' . do_shortcode( esc_html($btn_content) ) . '</span> <i class="t-icon icon-cartboxadd"></i>'
                    . '</a>';
            }
        }
        return '<a href="' . esc_url($href) . '" class="' . $classes . '" ' . $target . '>'
            . $icon_before . '<span>' . do_shortcode( esc_html($btn_content) ) . '</span>' . $icon_after .
            '</a>';
    }

    add_shortcode( 'boc_button', 'shortcode_boc_button' );
}


// Font Icon 
if ( !function_exists('shortcode_vc_boc_icon') ) {
  function shortcode_vc_boc_icon( $atts, $content = null ) {
    $atts = vc_map_get_attributes( 'boc_icon', $atts );

    extract( $atts );

    $color_css = 'color:' . $icon_color . ';';
    $background_css = $border_radius_css = $icon_padding_css = $margin_bottom_css = $css_animation_classes = '';

    if ( $has_icon_bg == 'yes' ) {
      if ( $icon_bg != '#ffffff' ) {
        $background_css = 'background-color:' . $icon_bg . ';';
      }

      if ( $icon_bg_border != '#ffffff' ) {
        $background_css .= 'border: 1px solid ' . $icon_bg_border . ';';
      }

      if ( $border_radius != '100%' ) {
        $border_radius_css = 'border-radius:' . $border_radius . ';';
      }

      $css_classes .= 'with_bgr';
    }

    if ( $margin_top ) {
      $margin_top_css = 'margin-top: ' . $margin_top;
    }

    if ( $margin_bottom ) {
      $margin_bottom_css = 'margin-bottom: ' . $margin_bottom;
    }

    if ( $css_animation !== '' ) {
      $css_animation_classes = 'wpb_animate_when_almost_visible wpb_' . $css_animation . '';
    }

    $str = '<div class="boc_icon_holder boc_icon_size_' . esc_attr( $size ) . -' boc_icon_pos_' . esc_attr( $icon_position ) . ' '
            . esc_attr( $css_animation_classes ) . ' ' . esc_attr( $css_classes ) . '" style="'
            . esc_attr( 
              $background_css . $border_radius_css . (isset($margin_top_css) ? $margin_top_css : "") 
              . (isset($margin_bottom_css) ? $margin_bottom_css : "") 
            )
            . '">' 
              . '<span class="boc_icon ' . esc_attr( $icon ) . '" style="' . esc_attr( $color_css ) . '"></span>' 
            . '</div>';

    return $str;
  }

  add_shortcode( 'boc_icon', 'shortcode_vc_boc_icon' );
}



/*
 * Resources Shortcodes
 */
 if ( !function_exists('get_term_children_by_slug') ) {
  function get_term_children_slugs_by_term_slug( $slug, $taxonomy ) {
    $term_children_slugs = [];
    $term = get_term_by( 'slug', $slug, $taxonomy );
    
    if ( !is_wp_error($term) && !empty($term) ) {
      $term_children_ids = get_term_children( $term->term_id, $taxonomy );
      
      if ( !is_wp_error($term_children_ids) && !empty($term_children_ids) ) {
        foreach( $term_children_ids as $term_children_id ) {
          $child_term = get_term_by( 'id', $term_children_id, $taxonomy );
          
          if ( !is_wp_error($child_term) && !empty($child_term) ) {
            $term_children_slugs[] = $child_term->slug;
          }
        }
      }
    }
    
    return $term_children_slugs;
  }
}
 
 
if ( !function_exists('get_all_resource_types') ) {
  function get_all_resource_types( $top_level_only = false ) {
    $types = array();
    $args = array(
      'taxonomy'   => 'sg_type',
      'hide_empty' => false,
    );
    
    if ( $top_level_only ) {
      $args['parent'] = 0;
    }
    
    $type_terms = get_terms( $args );
    
    if ( !is_wp_error($type_terms) && !empty($type_terms) ) {
      foreach ( $type_terms as $term ) {
        $types[] = $term->slug;
      }
    }
    
    return $types;
  }
}


if ( !function_exists('get_all_resource_topics') ) {
  function get_all_resource_topics() {
    $topics = array();
    
    $topic_terms = get_terms( array(
      'taxonomy'   => 'sg_topic',
      'hide_empty' => false,
    ) );
    
    if ( !is_wp_error($topic_terms) && !empty($topic_terms) ) {
      foreach ( $topic_terms as $term ) {
        $topics[] = $term->slug;
      }
    }
    
    return $topics;
  }
}

if ( !function_exists('get_all_resource_languages') ) {
  function get_all_resource_languages() {
    $languages = array();
    
    $language_terms = get_terms( array(
      'taxonomy'   => 'sg_language',
      'hide_empty' => false,
    ) );
    
    if ( !is_wp_error($language_terms) && !empty($language_terms) ) {
      foreach ( $language_terms as $term ) {
        $languages[] = $term->slug;
      }
    }
    
    return $languages;
  }
}


if ( !function_exists('sanitize_positive_number') ) {
  function sanitize_positive_number( $value ) {
    settype($value, 'integer');
    $positive_number = absint( intval($value, 10) );
    
    return $positive_number;
  }
}


if ( !function_exists('validate_shortcode_sg_resources_filter_list_to_array_filter_callback') ) {
  function validate_shortcode_sg_resources_filter_list_to_array_filter_callback( $sanitize = false, $sanitization_func = 'sanitize_key' ) {
    return function($value) use ($sanitize, $sanitization_func) {
      if ( empty($value) ) {
        // remove empty values
        return false;
      }
      
      if ( $sanitize ) {
        $value = call_user_func( $sanitization_func, $value );
      }
      
      if ( empty($value) ) {
        // remove empty values
        return false;
      }
      
      return true;
    };
  }
}


if ( !function_exists('validate_shortcode_sg_resources_filter_list_to_array') ) {
  function validate_shortcode_sg_resources_filter_list_to_array( $str, $sanitize = false, $sanitization_func = 'sanitize_key' ) {
    $result = array();
    
    // turn into an array
    if ( !empty($str) ) {
      $result = explode( ',', $str );
    }
    
    if ( !empty($result) ) {
      // remove extra white spaces
      array_walk($result, function($value, $key) {
        $value = trim($value);
      });
      
      $filter_callback = validate_shortcode_sg_resources_filter_list_to_array_filter_callback( $sanitize, $sanitization_func );
      
      $result = array_filter($result, $filter_callback);
    }
    
    if ( !empty($result) ) {
      // reindex
      $result = array_values($result);
    }

    return $result;
  }
}


if ( !function_exists('validate_shortcode_sg_resources_filter_bool') ) {
  function validate_shortcode_sg_resources_filter_bool( $variable, $default = true ) {
    if ( $default === true ) {
      if ( $variable === 0 || $variable === '0' || $variable === false || $variable === 'false' || $variable === 'FALSE' ) {
        $variable = false;
      } else {
        $variable = true;
      }
    } else {
      if ( $variable === 1 || $variable === '1' || $variable === true || $variable === 'true' || $variable === 'TRUE' ) {
        $variable = true;
      } else {
        $variable = false;
      }
    }

    return $variable;
  }
}


if ( !function_exists('validate_shortcode_sg_resources_filter_POST_terms') ) {
  function validate_shortcode_sg_resources_filter_POST_terms( $key ) {
    $term_slugs = null;

    // validate and  sanitize
    if ( !empty($_POST[$key]) && is_array($_POST[$key]) ) {
      $term_slugs = filter_var_array( $_POST[$key], FILTER_SANITIZE_URL );
    }

    // extra sanitization
    if ( !empty($term_slugs) ) {
      $term_slugs = array_filter( $term_slugs, function ($value) {
        $value = sanitize_title(trim($value));

        return (!empty($value));
      } );
    }

    return $term_slugs;
  }
}

if ( !function_exists('validate_shortcode_sg_resources_filter_POST_term') ) {
  function validate_shortcode_sg_resources_filter_POST_term( $key ) {
    $term_slug = null;

    // validate and  sanitize
    if ( !empty($_POST[$key]) && is_string($_POST[$key]) ) {
      $term_slug = filter_var( $_POST[$key], FILTER_SANITIZE_URL );
    }

    // extra sanitization
    if ( !empty($term_slug) ) {
      $term_slug = sanitize_title( trim($term_slug) );
    }
    
    if ( empty($term_slug) ) {
      $term_slug = null;
    }

    return $term_slug;
  }
}


if ( !function_exists('validate_shortcode_sg_resources_filter_GET_terms') ) {
  function validate_shortcode_sg_resources_filter_GET_terms( $key ) {
    $GET_data = null;

    // validate and sanitize
    if ( !empty($_GET[$key]) && is_string($_GET[$key]) ) {
      $GET_data = filter_var( htmlentities(stripslashes(trim($_GET[$key]))), FILTER_SANITIZE_URL );

      if ( $GET_data === '' || $GET_data === false ) {
        $GET_data = null;
      }
    }

    // extra sanitization
    if ( !empty($GET_data) ) {
      $GET_data = array_filter( explode(',', $GET_data), function ($value) {
        $value = sanitize_title(trim($value));

        return (!empty($value));
      } );
    }

    return $GET_data;
  }
}

if ( !function_exists('validate_shortcode_sg_resources_filter_GET_term') ) {
  function validate_shortcode_sg_resources_filter_GET_term( $key ) {
    $term_slug = null;

    // validate and sanitize
    if ( !empty($_GET[$key]) && is_string($_GET[$key]) ) {
      $term_slug = filter_var( htmlentities(stripslashes(trim($_GET[$key]))), FILTER_SANITIZE_URL );

      if ( $term_slug === '' ) {
        $term_slug = null;
      }
    }

    // extra sanitization
    if ( !empty($term_slug) ) {
      $term_slug = sanitize_title( trim($term_slug) );
    }
    
    if ( empty($term_slug) ) {
      $term_slug = null;
    }

    return $term_slug;
  }
}


if ( !function_exists('validate_shortcode_sg_resources_filter_terms_existance') ) {
  function validate_shortcode_sg_resources_filter_terms_existance( $data_array, $terms = null ) {
    if ( !empty($data_array) && !empty($terms) && is_array($terms) ) {
      foreach ( $data_array as $key => $term_slug ) {
        $term_slug_found = false;

        foreach ( $terms as $term ) {
          if ( $term->slug === $term_slug ) {
            $term_slug_found = true;
            break;
          }
        }

        if ( !$term_slug_found ) {
          unset( $data_array[ $key ] );
        }
      }
    }

    return $data_array;
  }
}


if ( !function_exists('handle_shortcode_sg_resources_filter') ) {
  function handle_shortcode_sg_resources_filter( $atts ) {
    $atts['types'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['types'], true );
    
    if ( empty($atts['types']) ) {
      $atts['types'] = get_all_resource_types();
    }
    
    $atts['exclude_types'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['exclude_types'], true );
      
    $atts['hide_types'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_types'], false );
    
    $atts['languages'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['languages'], true );
    
    if ( empty($atts['languages']) ) {
      $atts['languages'] = get_all_resource_languages();
    }
    
    if ( !empty($atts['default_language']) && is_string($atts['default_language']) ) {
      $atts['default_language'] = sanitize_title( $atts['default_language'] );
    }
    
    $atts['hide_languages'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_languages'], false );
    
    $atts['topics'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['topics'], true );
    
    if ( empty($atts['topics']) ) {
      $atts['topics'] = get_all_resource_topics();
    }
    
    $atts['hide_search'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_search'], false );
    
    if ( !empty($atts['nav_menu']) && is_string($atts['nav_menu']) ) {
      $atts['nav_menu'] = sanitize_title( $atts['nav_menu'] );
    }
    
    if ( empty($atts['nav_menu']) || ( !is_int($atts['nav_menu']) && !is_string($atts['nav_menu']) ) || !is_nav_menu($atts['nav_menu']) ) {
      $atts['nav_menu'] = null;
    }
    
    if ( !empty($atts['id']) ) {
      $atts['id'] = sanitize_html_class( $atts['id'] );
    }
    
    if ( !empty($atts['class']) ) {
      $atts['class'] = sanitize_html_class( $atts['class'] );
    }
    
    return $atts;
  }
}


if ( !function_exists('handle_shortcode_sg_resources_filter_results') ) {
  function handle_shortcode_sg_resources_filter_results( $atts ) {
    $atts['load_subtypes'] = validate_shortcode_sg_resources_filter_bool( $atts['load_subtypes'], false );
    
    $atts['hide_empty_subtypes'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_empty_subtypes'], false );
    
    $atts['load_top_types'] = validate_shortcode_sg_resources_filter_bool( $atts['load_top_types'], false );
    
    $atts['hide_empty_top_types'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_empty_top_types'], false );
    
    $atts['post_types'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['post_types'], true );
    
    if ( empty($atts['post_types']) ) {
      $atts['post_types'] = array( 'any' );
    }
    
    $atts['types'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['types'], true );
    
    if ( empty($atts['types']) ) {
      $atts['types'] = get_all_resource_types( ($atts['load_subtypes'] || $atts['load_top_types']) );
    }
    
    $atts['exclude_types'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['exclude_types'], true );
    
    if ( empty($atts['exclude_types']) ) {
      $atts['exclude_types'] = null;
    }
    
    if ( !empty($atts['topic']) ) {
      $atts['topic'] = sanitize_title( trim($atts['topic']) );
    }
    
    if ( empty($atts['topic']) ) {
      $atts['topic'] = null;
    }
    
    if ( !empty($atts['default_language']) ) {
      $atts['default_language'] = sanitize_title( trim($atts['default_language']) );
    }
    
    if ( empty($atts['default_language']) ) {
      $atts['default_language'] = null;
    }
	  
	if ( $atts['posts_number'] === '0' || $atts['posts_number'] === 0 ) {
		$atts['posts_number'] = 0;
	} else {
		if ( empty($atts['posts_number']) || ($atts['posts_number'] !== -1)) {
		  settype($atts['posts_number'], 'integer');
		  $atts['posts_number'] = intval($atts['posts_number'], 10);
		}

		if ( empty($atts['posts_number']) || ($atts['posts_number'] < -1) ) {
		  $atts['posts_number'] = -1;
		}
	}

    $atts['featured_posts'] = validate_shortcode_sg_resources_filter_list_to_array( $atts['featured_posts'], true, 'sanitize_positive_number' );
    
    if ( !empty($atts['featured_links']) ) {
      $atts['featured_links'] = preg_replace( '/\s+/', ' ', $atts['featured_links'] );
    }
    
    if ( !empty($atts['featured_links']) ) {
      // turn into an array
      $atts['featured_links'] = explode( ' ', $atts['featured_links'] );
      
      // remove extra white spaces and sanitize links
      array_walk($atts['featured_links'], function($value, $key) {
        $value = sanitize_url( trim($value) );
      });
    }
    
    $allowed_layouts = array( 'default', 'compact-1', 'compact-2', 'compact-3', 'compact-4', 'compact-5', '2-columns', '2-columns-2', '2-columns-3', '2-columns-4', 'wide' );

    if ( empty($atts['layout']) || !in_array($atts['layout'], $allowed_layouts) ) {
      $atts['layout'] = 'default';
    }
    
    if ( empty($atts['type_layout']) || !in_array($atts['type_layout'], $allowed_layouts) ) {
      $atts['type_layout'] = 'default';
    }
    
    $allowed_orderby = array( 'title', 'date', 'rand', 'relevance' );

    if ( !empty($atts['orderby']) && !in_array($atts['orderby'], $allowed_orderby) ) {
      $atts['orderby'] = '';
    }
    
    $allowed_order = array( 'DESC', 'ASC' );

    if ( !in_array($atts['order'], $allowed_order) ) {
      $atts['order'] = '';
    }
    
    $atts['hide_tags'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_tags'], false );
    $atts['load_type_tags'] = validate_shortcode_sg_resources_filter_bool( $atts['load_type_tags'], false );
    
    if ( !empty($atts['post_link_text']) ) {
      $atts['post_link_text'] = sanitize_text_field( $atts['post_link_text'] );
    }
    if ( empty($atts['post_link_text']) ) {
      // if empty after sanitization
      $atts['post_link_text'] = _x( 'Read Now', '[sg_resources_filter_results]', 'SuperiorGlove' );
    }
    
    $atts['show_post_link_arrow'] = validate_shortcode_sg_resources_filter_bool( $atts['show_post_link_arrow'], false );
    
    $atts['hide_section_heading'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_section_heading'], false );
    
    if ( !empty($atts['section_heading']) ) {
      $atts['section_heading'] = sanitize_text_field( $atts['section_heading'] );
    }
    
    if ( !empty($atts['section_link']) ) {
      $atts['section_link'] = sanitize_url( $atts['section_link'] );
    }
    
    if ( !empty($atts['section_link_text']) ) {
      $atts['section_link_text'] = sanitize_text_field( $atts['section_link_text'] );
    }
    if ( empty($atts['section_link_text']) ) {
      // if empty after sanitization
      $atts['section_link_text'] = _x( 'View All', '[sg_resources_filter_results]', 'SuperiorGlove' );
    }
    
    if ( !empty($atts['not_found_text']) ) {
      $atts['not_found_text'] = sanitize_text_field( $atts['not_found_text'] );
    }
    
    if ( empty($atts['not_found_text']) ) {
      // if empty after sanitization
      $atts['not_found_text'] = _x( 'Resources not found.', '[sg_resources_filter_results]', 'SuperiorGlove' );
    }
    
    if ( !empty($atts['id']) ) {
      $atts['id'] = sanitize_html_class( $atts['id'] );
    }
    
    if ( !empty($atts['class']) ) {
      $atts['class'] = sanitize_html_class( $atts['class'] );
    }
    
    if ( !empty($atts['filter_id']) ) {
      $atts['filter_id'] = sanitize_html_class( $atts['filter_id'] );
    }
    
    $atts['ajax_request'] = validate_shortcode_sg_resources_filter_bool( $atts['ajax_request'], false );
    
    return $atts;
  }
}


if ( !function_exists('shortcode_sg_resources_filter') ) {
  function shortcode_sg_resources_filter( $atts ) {
    global $wp;
    static $count = 0;
    
    $atts = handle_shortcode_sg_resources_filter( shortcode_atts(
      array(
        'types' => '',
        'topics' => '',
        'exclude_types' => '',
        'hide_types' => false,
        'languages' => '',
        'default_language' => '',
        'hide_languages' => '',
        'hide_search' => false,
        'nav_menu' => null,
        'id' => '',
        'class' => ''
      ),
      $atts,
      'sg_resources_filter'
    ) );
    
    $type_terms = null;
    $topic_terms = null;
    $language_terms = null;
    $_POST_search = null;
    $_POST_topic = null;
    $_POST_language = null;
    $_GET_search = null;
    $_GET_topic = null;
    $_GET_language = null;
    
    $html = '';
    
    // create filter id, if user didn't add it
    if ( empty($atts['id']) ) {
      $atts['id'] = 'sg-resources-filter-' . $count;
    }
    
    $count++;
    
    if ( ! empty($atts['types']) && ! empty($atts['exclude_types']) ) {
      foreach ( $atts['types'] as $key => $type_slug ) {
        if ( in_array($type_slug, $atts['exclude_types']) ) {
          unset($atts['types'][ $key ]);
        }
      }
      
      if ( ! empty($atts['types']) ) {
        $atts['types'] = array_values($atts['types']);
      }
    }
    
    // get all types or user defined types and their descendants
    if ( ! empty($atts['types']) ) {
      $args = array(
        'taxonomy' => 'sg_type',
        'hide_empty' => false
      );
      
      if ( !empty($atts['types']) ) {
        $args['slug'] = $atts['types'];
      }
      
      $type_terms = get_terms( $args );
      
      if ( is_wp_error($type_terms) || empty($type_terms) ) {
        $type_terms = null;
      }
    }
    
    // get all topics or user defined topics and their descendants
    if ( !empty($atts['topics']) ) {
      $args = array(
        'taxonomy' => 'sg_topic',
        'hide_empty' => true
      );
    
      $args['slug'] = $atts['topics'];
      
      $topic_terms = get_terms( $args );
      
      if ( is_wp_error($topic_terms) || empty($topic_terms) ) {
        $topic_terms = null;
      }
    }
    
    // get all languages or user defined languages and their descendants
    if ( !empty($atts['languages']) ) {
      $args = array(
        'taxonomy' => 'sg_language',
        'hide_empty' => true
      );
    
      $args['slug'] = $atts['languages'];
      
      $language_terms = get_terms( $args );
      
      if ( is_wp_error($language_terms) || empty($language_terms) ) {
        $language_terms = null;
      } else if ( empty($atts['default_language']) ) {
        $weglot_site_language = null;
      
        if ( function_exists('weglot_get_current_language') ) {
          $weglot_site_language = weglot_get_current_language();
        }
        
        foreach ( $language_terms as $language_term ) {
          $language_code = get_term_meta( $language_term->term_id, 'language_code', true );
          
          if ( $language_code && $language_code === $weglot_site_language ) {
            $atts['default_language'] = $language_term->slug;
          }
        }
        
        if ( empty($atts['default_language']) ) {
          $atts['default_language'] = $language_terms[0]>slug;
        }
      }
    }
    
    if ( !empty($type_terms) && (!empty($topic_terms) || !empty($language_terms)) ) {
      // remove topics and/or languages which have no posts of defined types
      $types_list = array();
      $languages_list = array();
      $topics_list = array();
      
      foreach ( $type_terms as $type ) {
        $types_list[] = $type->term_id;
      }
      
      if ( !empty($topic_terms) ) {
        foreach ( $topic_terms as $topic ) {
          $topics_list[] = $topic->term_id;
        }
      }
      
      if ( !empty($language_terms) ) {
        foreach ( $language_terms as $language ) {
          $languages_list[] = $language->term_id;
        }
      }
      
      if ( !empty($topic_terms) ) {
        foreach ( $topic_terms as $topic_key => $topic_value ) {
          $args = array(
            'post_type' => 'any',
            'posts_per_page' => -1,
            'tax_query' => array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'sg_topic',
                'field' => 'term_id',
                'terms' => $topic_value->term_id,
              ),
              array(
                'taxonomy' => 'sg_type',
                'field' => 'term_id',
                'terms' => $types_list,
              ),
            ),
          );
          
          if ( !empty($languages_list) ) {
            $args['tax_query'][] = array(
              'taxonomy' => 'sg_language',
              'field' => 'term_id',
              'terms' => $languages_list,
            );
          }
          
          $sg_query = new WP_Query( $args );
          
          if ( empty($sg_query->found_posts) ) {
            unset( $topic_terms[$topic_key] );
          }
        }

        if ( !empty($topic_terms) ) {
          // if topics array is not empty after all checks, reindex it
          $topic_terms = array_values($topic_terms);
        }
      }
      
      if ( !empty($language_terms) ) {
        foreach ( $language_terms as $language_key => $language_value ) {
          $args = array(
            'post_type' => 'any',
            'posts_per_page' => -1,
            'tax_query' => array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'sg_language',
                'field' => 'term_id',
                'terms' => $language_value->term_id,
              ),
              array(
                'taxonomy' => 'sg_type',
                'field' => 'term_id',
                'terms' => $types_list,
              ),
            ),
          );
          
          if ( !empty($topics_list) ) {
            $args['tax_query'][] = array(
              'taxonomy' => 'sg_topic',
              'field' => 'term_id',
              'terms' => $topics_list,
            );
          }
          
          $sg_query = new WP_Query( $args );
          
          if ( empty($sg_query->found_posts) ) {
            unset( $language_terms[$language_key] );
          }
        }

        if ( !empty($language_terms) ) {
          // if topics array is not empty after all checks, reindex it
          $language_terms = array_values($language_terms);
        }
      }
    }
    
    if ( empty($type_terms) && !empty($atts['types']) ) {
      // there are user defined types, but the obtained type terms list is empty
      // this means that there are no posts of those types
      // so we don't need topics and languages too
      $topic_terms = null;
      $language_terms = null;
      $atts['hide_search'] = true;
    }
    
    // form was submitted and there is search text
    if ( isset($_POST[$atts['id'] . '_sg_filter_search']) ) {
      $_POST_search = sanitize_text_field( $_POST[$atts['id'] . '_sg_filter_search'] );
    }
    
    // form was submitted and there is selected topic
    if ( isset($_POST[$atts['id'] . '_sg_filter_topic']) ) {
      $_POST_topic = validate_shortcode_sg_resources_filter_POST_term( $atts['id'] . '_sg_filter_topic' );
    }
    
    // form was submitted and there is selected topic
    if ( isset($_POST[$atts['id'] . '_sg_filter_language']) ) {
      $_POST_language = validate_shortcode_sg_resources_filter_POST_term( $atts['id'] . '_sg_filter_language' );
    }
     
    // form was not submitted or there is no selected topics and search text
    if ( 
      /*!isset($_POST[$atts['id'] . '_sg_filter_topic']) && 
      !isset($_POST[$atts['id'] . '_sg_filter_search']) && 
      !isset($_POST[$atts['id'] . '_sg_filter_language']) */
      empty($_POST_search) && empty($_POST_topic) && empty($_POST_language) 
    ) {
      if ( isset($_GET['sg_filter_search']) ) {
        // user opened a page with pre-selected search text
        $_GET_search = sanitize_text_field( urldecode($_GET['sg_filter_search']) );
      }
      
      if ( isset($_GET['sg_filter_topic']) ) {
        // user opened a page with pre-selected topic
        $_GET_topic = validate_shortcode_sg_resources_filter_GET_term( 'sg_filter_topic' );
      }
      
      if ( isset($_GET['sg_filter_language']) ) {
        // user opened a page with pre-selected topic
        $_GET_language = validate_shortcode_sg_resources_filter_GET_term( 'sg_filter_language' );
      }
    }

    ob_start();

    get_template_part( 'inc/shortcodes/sg/sg-resources-filter', null, array(
      'filter_types' => $type_terms, // array || null
      'filter_topics' => $topic_terms, // array || null
      'filter_languages' => $language_terms, // array || null
      'filter_hide_types' => $atts['hide_types'], // true || false
      'filter_hide_languages' => $atts['hide_languages'], // true || false
      'filter_hide_search' => $atts['hide_search'], // true || false
      'filter_nav_menu' => $atts['nav_menu'], // string || int || null
      'filter_search' => ( $_POST_search ? $_POST_search : $_GET_search ), // string || null
      'filter_active_topic' => ( $_POST_topic ? $_POST_topic : $_GET_topic ), // string || null
      'filter_active_language' => ( $_POST_language ? $_POST_language : ($_GET_language ? $_GET_language : $atts['default_language']) ), // string || null
      'filter_default_language' => $atts['default_language'], // string || null
      'filter_id' => $atts['id'], // string
      'filter_class' => $atts['class'], // string, may be empty
    ) );

    $html .= ob_get_contents();

    ob_end_clean();

    return $html;
  }
  
  add_shortcode( 'sg_resources_filter', 'shortcode_sg_resources_filter' );
}


if ( !function_exists('sg_wrap_resources_filter_results') ) {
  function sg_wrap_resources_filter_results( $html, $atts, $posts_are_empty, $subtypes_are_empty, $top_types_are_empty ) {
    $result = '';
    
    ob_start();
    get_template_part( 
      'inc/shortcodes/sg/sg-resources-wrapper', 
      null, 
      array(
        'resources_html' => $html,
        'resources_atts' => $atts,
        'resources_section_id' => $atts['id'],
        'resources_section_class' => $atts['class'],
        'resources_filter_id' => $atts['filter_id'],
        'resources_layout' => $atts['layout'],
        'resources_posts_are_empty' => $posts_are_empty,
        'resources_subtypes_are_empty' => $subtypes_are_empty,
        'resources_top_types_are_empty' => $top_types_are_empty,
      ) 
    );
    $result = ob_get_contents();
    ob_end_clean();
    
    return $result;
  }
}


if ( !function_exists('sg_resources_filter_results_query_args') ) {
  function sg_resources_filter_results_query_args(
    $post_types, $default_types, $posted_types, $excluded_types, $default_topic, $posted_topic, $search_text, $default_language, $posted_language, $orderby = '', $order = ''
  ) {
    $args = array(
      'post_type' => $post_types,
      'post_status' => 'publish', 
      'posts_per_page' => -1,
      'tax_query' => array(
        'relation' => 'AND'
      )
    );
    
    $types_args = array(
      'relation' => 'AND',
      array(
        'taxonomy' => 'sg_type',
        'field' => 'slug',
        'terms' => $default_types
      )
    );
    
    if ( !empty($posted_types) ) {
      $types_args[] = array(
        'taxonomy' => 'sg_type',
        'field' => 'slug',
        'terms' => $posted_types
      );
    }
    
    $args['tax_query'][] = $types_args;
    
    if ( ! empty($default_topic) ) {
      $topics_args = array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'sg_topic',
          'field' => 'slug',
          'terms' => $default_topic
        )
      );
      
      if ( !empty($posted_topic) ) {
        $topics_args[] = array(
          'taxonomy' => 'sg_topic',
          'field' => 'slug',
          'terms' => $posted_topic
        );
      }
      
      $args['tax_query'][] = $topics_args;
    }
    
    if ( ! empty($posted_language) || !empty($default_language) ) {
      if ( ! empty($posted_language) ) {
        $language_args = array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'sg_language',
            'field' => 'slug',
            'terms' => $posted_language
          )
        );
      } else if ( !empty($default_language) ) {
        $language_args = array(
          'relation' => 'AND',
          array(
            'taxonomy' => 'sg_language',
            'field' => 'slug',
            'terms' => $default_language
          )
        );
      }
      
      $args['tax_query'][] = $language_args;
    }
    
    if ( !empty($excluded_types) ) {
      $args['tax_query'][] = array(
        'taxonomy' => 'sg_type',
        'field' => 'slug',
        'terms' => $excluded_types,
        'operator' => 'NOT IN'
      );
    }
    
    if ( !empty($search_text) ) { 
      $args['s'] = $search_text;
    }
    
    if ( !empty($orderby) ) {
      $args['orderby'] = $orderby;
    }
    
    if ( !empty($order) ) {
      $args['order'] = $order;
    }
    
    return $args;
  }
}


if ( !function_exists('shortcode_sg_resources_filter_results') ) {
  function shortcode_sg_resources_filter_results( $atts ) {
    static $system_id_count = 0;
    
    $atts = handle_shortcode_sg_resources_filter_results( shortcode_atts(
      array(
        'post_types' => 'any',
        'types' => '',
        'exclude_types' => '',
        'topic' => '',
        'default_language' => '',
        'posts_number' => -1,
        'featured_posts' => '',
        'featured_links' => '',
        'load_subtypes' => false,
        'load_top_types' => false,
        'hide_empty_subtypes' => false,
        'hide_empty_top_types' => false,
        'order' => '', // DESC, ASC
        'orderby' => '', // title, date, rand, relevance
        'layout' => 'default',
        'type_layout' => 'default',
        'hide_tags' => false,
        'load_type_tags' => false,
        'post_link_text' => _x( 'Read Now', '[sg_resources_filter_results]', 'SuperiorGlove'),
        'show_post_link_arrow' => false,
        'hide_section_heading' => false,
        'section_heading' => '',
        'section_link' => '',
        'section_link_text' => _x( 'View All', '[sg_resources_filter_results]', 'SuperiorGlove' ),
        'not_found_text' => _x( 'Resources not found.', '[sg_resources_filter_results]', 'SuperiorGlove' ),
        'id' => '',
        'class' => '',
        'filter_id' => '',
        'ajax_request' => false // true for ajax request
      ),
      $atts,
      'sg_resources_filter_results'
    ) );
    
    $_POST_topic = null;
    $_GET_topic = null;
    $_POST_search = null;
    $_GET_search = null;
    $_POST_language = null;
    $_GET_language = null;
    
    $subtypes = null;
    $top_types = null;
    
    $posts_number = $atts['posts_number'];
    
    $sg_featured = null;
    $sg_posts = null;
    $sg_found_posts = 0;
    
    $html = '';
    
    $posts_are_empty = true;
    $subtypes_are_empty = true;
    $top_types_are_empty = true;
    $types_are_empty = true;
    
    $atts['system_id'] = $system_id_count;-
    $system_id_count++;
    
    $language_terms = get_terms( array(
      'taxonomy' => 'sg_language',
      'hide_empty' => true
    ) );
    
    $site_languages = null;
    
    if ( is_wp_error($language_terms) || empty($language_terms) ) {
      $language_terms = null;
    } else {
      $weglot_site_language = null;
      
      if ( !$atts['ajax_request'] && function_exists('weglot_get_current_language') ) {
        $weglot_site_language = weglot_get_current_language();
      }
      
      foreach ( $language_terms as $language_term ) {
        $temp_language = array(
          'slug' => $language_term-> slug,
          'name' => $language_term-> name,
          //'custom_title' => '',
          'short_title' => '',
          //'code' => ''
        );

        //$language_custom_title = get_term_meta( $language_term->term_id, 'language_short_title', true );
        $language_short_title = get_term_meta( $language_term->term_id, 'language_short_title', true );
        $language_code = get_term_meta( $language_term->term_id, 'language_code', true );
        
        /*if ( $language_custom_title ) {
          $temp_language['custom_title'] = $language_custom_title;
        }*/
        
        if ( $language_short_title ) {
          $temp_language['short_title'] = $language_short_title;
        }
        
        if ( $language_code ) {
          $temp_language['code'] = $language_code;
        }
        
        if ( empty($atts['default_language']) ) {
          if ( $language_code && $weglot_site_language && $language_code === $weglot_site_language ) {
            $atts['default_language'] = $language_term->slug;
          }
        }

        $site_languages[] = $temp_language;
      }
      
      if ( empty($atts['default_language']) ) {
        $atts['default_language'] = $language_terms[0]->slug;
      }
    }
  
    // Check, sanitize & validate $_POST data
    if ( isset($_POST[$atts['filter_id'] . '_sg_filter_search']) ) {
      $_POST_search = sanitize_text_field( $_POST[$atts['filter_id'] . '_sg_filter_search'] );
    }
    
    if ( isset($_POST[$atts['filter_id'] . '_sg_filter_topic']) ) {
      $_POST_topic = validate_shortcode_sg_resources_filter_POST_term( $atts['filter_id'] . '_sg_filter_topic' );
      
      if ( empty($atts['topic']) && !empty($_POST_topic) ) {
        $atts['topic'] = $_POST_topic;
        //$_POST_topic = null;
      }
    }
    
    if ( isset($_POST[$atts['filter_id'] . '_sg_filter_language']) ) {
      $_POST_language = validate_shortcode_sg_resources_filter_POST_term( $atts['filter_id'] . '_sg_filter_language' );
      
      if ( empty($atts['default_language']) && !empty($_POST_language) ) {
        $atts['default_language'] = $_POST_language;
        //$_POST_language = null;
      }
    }
    
    if ( 
      /*!isset($_POST[$atts['filter_id'] . '_sg_filter_topic']) && 
      !isset($_POST[$atts['filter_id'] . '_sg_filter_search']) && 
      !isset($_POST[$atts['filter_id'] . '_sg_filter_language']) &&
      */
      empty($_POST_search) && empty($_POST_topic) && empty($_POST_language) && 
      empty($atts['ajax_request'])
    ) {
      // it is not a filter submit or filter ajax reques, check if it is a load of a page with GET parameters
      // Check, sanitize & validate $_GET data
      if ( isset($_GET['sg_filter_search']) ) {
        $_GET_search = sanitize_text_field( urldecode($_GET['sg_filter_search']) );
      }
      
      if ( isset($_GET['sg_filter_topic']) ) {
        $_GET_topic = validate_shortcode_sg_resources_filter_GET_term( 'sg_filter_topic' );
        
        if ( empty($atts['topic']) ) {
          $atts['topic'] = $_GET_topic;
          //$_GET_topic = null;
        }
      }
      
      if ( isset($_GET['sg_filter_language']) ) {
        $_GET_language = validate_shortcode_sg_resources_filter_GET_term( 'sg_filter_language' );
        
        if ( empty($atts['default_language']) ) {
          $atts['default_language'] = $_GET_language;
          //$_GET_language = null;
        }
      }
    }
    
    if ( !empty($atts['types']) ) {
      // there are terms in sg_type taxonomy
      
      if ( 
        $atts['load_top_types'] && 
        /*!isset($_POST[$atts['filter_id'] . '_sg_filter_topic']) && 
        !isset($_POST[$atts['filter_id'] . '_sg_filter_search']) && 
        !isset($_POST[$atts['filter_id'] . '_sg_filter_language']) && 
        !isset($_GET['sg_filter_topic']) && 
        !isset($_GET['sg_filter_search']) && 
        !isset($_GET['sg_filter_language'])*/
        empty($_POST_search) && empty($_POST_topic) && (empty($_POST_language) || ($_POST_language == $atts['default_language'])) && 
        empty($_GET_search) && empty($_GET_topic) && (empty($_GET_language) || ($_GET_language == $atts['default_language']))
        // load top types only in non-filtered page
      ) {
        $top_types = array();
        
        // walking through shortcode defined content type slugs
        foreach ( $atts['types'] as $top_type_slug ) {
          $top_type = get_term_by('slug', $top_type_slug, 'sg_type');
          $add_top_type = false;
          
          if ( 
            !empty($top_type) && 
            !empty($top_type->term_id) && 
            ( empty($atts['exclude_types']) || !in_array($top_type->slug, $atts['exclude_types']) ) && 
            empty($top_type->parent)
          ) {
            // it is top level type term out of exclusion list
            $add_top_type = true;
            
            if ( $atts['hide_empty_top_types'] ) {
              // check if this top type is empty
              
              $add_top_type = false;
              
              $args = sg_resources_filter_results_query_args(
                $atts['post_types'], 
                $top_type_slug, 
                null, 
                null, 
                $atts['topic'], 
                null, 
                null,
                $atts['default_language'], 
                null
              );

              $top_type_query = new WP_Query( $args );
              
              if ( $top_type_query->have_posts() ) {
                $add_top_type = true;
              }
            }
            
            if ( $add_top_type ) {
              $top_types[] = $top_type;
            }
          }
        }
        
        if ( !empty($top_types) ) {
          // reindex array of found top types
          $top_types_are_empty = false;
          
          if ( !empty($atts['order']) ) {
            usort( $top_types, function($a, $b) use ($atts) { 
              if ( $atts['order'] == 'DESC' ) {
                return strcmp($b->name, $a->name);
              } else {
                return strcmp($a->name, $b->name);
              }
            } );
          }
        } else {
          $top_types = null;
        }
      }
      
      if ( 
        $atts['load_subtypes'] &&
        empty($_POST_search) && empty($_POST_topic) && (empty($_POST_language) || ($_POST_language == $atts['default_language'])) && 
        empty($_GET_search) && empty($_GET_topic) && (empty($_GET_language) || ($_GET_language == $atts['default_language']))
        // load subtypes only in non-filtered page
      ) {
        $subtypes = array();
        
        // walking through shortcode defined content type slugs
        foreach ( $atts['types'] as $type_slug ) {
          $type = get_term_by('slug', $type_slug, 'sg_type');
          
          if ( 
            !empty($type) && !empty($type->term_id) && 
            ( 
      			!isset($atts['exclude_types']) || empty($atts['exclude_types']) || !is_array($atts['exclude_types']) || 
      			!in_array($type->slug, $atts['exclude_types']) 
    		)
          ) {
            // Merges all term children into a single array of their IDs.
            $subtype_ids = get_term_children( $type->term_id, 'sg_type' );
            
            if ( !is_wp_error($subtype_ids) && !empty($subtype_ids) ) {
              foreach ( $subtype_ids as $subtype_id ) {
                // get content type child term
                $subtype = get_term_by( 'id', $subtype_id, 'sg_type' );
                
                // check if this term is a direct child of the parent content type
                if ( 
          			!empty($subtype) && ($subtype->parent == $type->term_id) && 
          			( 
            			!isset($atts['exclude_types']) || empty($atts['exclude_types']) || !is_array($atts['exclude_types']) || 
            			!in_array($subtype->slug, $atts['exclude_types']) 
          			)
        		) {
                  // if any topic is selected, add subtype only if it has posts with this topic
                  $add_subtype = true;
                  
                  if ( 
                    $atts['hide_empty_subtypes'] || 
                    !empty($_POST_topic) || !empty($_GET_topic) || 
                    !empty($_POST_language) || !empty($_GET_language)
                  ) {
                    // check if subtype has posts with such conditions
                    $add_subtype = false;
                    
                    $args = sg_resources_filter_results_query_args(
                      $atts['post_types'], 
                      $subtype->slug, 
                      null, 
                      null, 
                      $atts['topic'], 
                      null, 
                      null,
                      $atts['default_language'], 
                      null
                    );

                    $subtype_query = new WP_Query( $args );
                    
                    if ( $subtype_query->have_posts() ) {
                      $add_subtype = true;
                    }
                  }
                  
                  if ( $add_subtype ) {
                    $subtypes[] = $subtype;
                  }
                }
              }
            }
          }
        }
        
        if ( !empty($subtypes) ) {
          // reindex array of found subypes
          $subtypes_are_empty = false;
          
          if ( !empty($atts['order']) ) {
            usort( $subtypes, function($a, $b) use ($atts) { 
              if ( $atts['order'] == 'DESC' ) {
                return strcmp($b->name, $a->name);
              } else {
                return strcmp($a->name, $b->name);
              }
            } );
          }
        }
      }
      
      if ( 
        !empty($atts['featured_posts']) && 
        /*!isset($_POST[$atts['filter_id'] . '_sg_filter_topic']) && 
        !isset($_POST[$atts['filter_id'] . '_sg_filter_search']) && 
        !isset($_POST[$atts['filter_id'] . '_sg_filter_language']) && 
        !isset($_GET['sg_filter_topic']) && 
        !isset($_GET['sg_filter_search']) && 
        !isset($_GET['sg_filter_language'])*/
        empty($_POST_search) && empty($_POST_topic) && (empty($_POST_language) || ($_POST_language == $atts['default_language'])) && 
        empty($_GET_search) && empty($_GET_topic) && (empty($_GET_language) || ($_GET_language == $atts['default_language']))
      ) {
        // obtain featured posts on default page load only
        $sg_featured = array();
        
        foreach ( $atts['featured_posts'] as $post_id ) {
          $featured_post = get_post( $post_id );
          
          if ( !empty($featured_post) ) {
            $sg_featured[] = $featured_post;
          }
        }
        
        if ( !empty($sg_featured) ) {
          if ( $posts_number > 0 ) {
            $posts_number -= count($sg_featured);
          }
        } else {
          $sg_featured = null;
        }
      }
      
      if (
		($posts_number !== 0 && $posts_number !== '0') &&
		(
          !empty($_POST_search) || !empty($_POST_topic) || (!empty($_POST_language) && ($_POST_language != $atts['default_language'])) || 
          !empty($_GET_search) || !empty($_GET_topic) || (!empty($_GET_language) && ($_GET_language != $atts['default_language'])) || 
          ( empty($atts['load_top_types']) && empty($atts['load_subtypes']) )
		)
      ) {
        // not default load or there is not top type request and no subtypes request
        // get usual posts
        $args = sg_resources_filter_results_query_args(
          $atts['post_types'], 
          $atts['types'], 
          null, 
          $atts['exclude_types'], 
          $atts['topic'], 
          ( $_POST_topic ? $_POST_topic : $_GET_topic ), 
          ( $_POST_search ? $_POST_search : $_GET_search ),
          $atts['default_language'], 
          ( $_POST_language ? $_POST_language : $_GET_language ),
          ( ($atts['orderby'] != 'title') ? $atts['orderby'] : '' ),
          ( ($atts['orderby'] != 'title') ? $atts['order'] : '' )
        );
        
        $sg_query = new WP_Query( $args );
        
        if ( $sg_query->have_posts() ) {
          $sg_posts = $sg_query->get_posts();
          $sg_found_posts = $sg_query->found_posts;
        }
        
        if ( empty($sg_posts) || !is_array($sg_posts) ) {
          $sg_posts = null;
        } else if ( $atts['orderby'] == 'title' ) {
          // sort posts
          usort( $sg_posts, function($a, $b) use ($atts) { 
            $a_title = rwmb_meta( 'sg_post_custom_title', '', $a->ID );
            $b_title = rwmb_meta( 'sg_post_custom_title', '', $b->ID );
        
            if ( empty($a_title) )
              $a_title = apply_filters( 'the_title', get_the_title($a->ID), $a->ID );
            
            if ( empty($b_title) )
              $b_title = apply_filters( 'the_title', get_the_title($b->ID), $b->ID );

            if ( $atts['order'] == 'DESC' ) {
              return strcmp( $b_title, $a_title );
            } else {
              return strcmp( $a_title, $b_title );
            }
          } );
        }
        
        if ( !empty($sg_featured) ) {
          if ( empty($sg_posts) ) {
            $sg_posts = array();
          }
          
          $sg_posts = array_merge( $sg_featured, $sg_posts );
        }
        
        if ( !empty($sg_posts) ) {
          $posts_are_empty = false;
          
          if ( $posts_number < $sg_found_posts ) {
			if ( $posts_number === 0 ) {
				$sg_posts = array();
			} else {
				$sg_posts = array_splice( $sg_posts, 0, (($posts_number > 0) ? $posts_number : $sg_found_posts) );
			}
          }
        }
      }
      
      ob_start();

      get_template_part( 'inc/shortcodes/sg/sg-resources', null, array(
        'resources_post_types' => $atts['post_types'],
        'resources_types' => $atts['types'],
        'resources_exclude_types' => $atts['exclude_types'],
        'resources_topic' => $atts['topic'],
        'resources_default_language' => $atts['default_language'],
        'resources_current_language' => (!empty($_POST_language) ? $_POST_language : (!empty($_GET_language) ? $_GET_language : $atts['default_language'])),
        'resources_featured_posts' => $atts['featured_posts'], 
        'resources_found_featured_posts' => $sg_featured, // null || array
        'resources_featured_links' => $atts['featured_links'],
        'resources_active_search' => ( $_POST_search ? $_POST_search : $_GET_search ),
        'resources_posts' => $sg_posts, // null || array
        'resources_found_posts' => $sg_found_posts, // null || array
        'resources_per_load' => $atts['posts_number'],
        'resources_load_subtypes' => $atts['load_subtypes'],
        'resources_hide_empty_subtypes' => $atts['hide_empty_subtypes'],
        'resources_load_top_types' => $atts['load_top_types'],
        'resources_hide_empty_top_types' => $atts['hide_empty_top_types'],
        'resources_subtypes' => $subtypes, // null || array
        'resources_top_types' => $top_types, // null || array
        'resources_layout' => $atts['layout'],
        'resources_type_layout' => $atts['type_layout'],
        'resources_hide_tags' => $atts['hide_tags'],
        'resources_load_type_tags' => $atts['load_type_tags'],
        'resources_post_link_text' => $atts['post_link_text'],
        'resources_show_post_link_arrow' => $atts['show_post_link_arrow'],
        'resources_hide_section_heading' => $atts['hide_section_heading'],
        'resources_section_heading' => $atts['section_heading'],
        'resources_section_link' => $atts['section_link'],
        'resources_section_link_text' => $atts['section_link_text'],
        'resources_section_id' => $atts['id'],
        'resources_section_class' => $atts['class'],
        'resources_filter_id' => $atts['filter_id'],
        'resources_not_found_text' => $atts['not_found_text'],
        'resources_system_id' => $atts['system_id'],
        'resources_posts_are_empty' => $posts_are_empty,
        'resources_subtypes_are_empty' => $subtypes_are_empty,
        'resources_top_types_are_empty' => $top_types_are_empty,
        'resources_site_languages' => $site_languages,
      ) );

      $html .= ob_get_contents();
      
      ob_end_clean();
    }

    if ( empty($atts['ajax_request']) ) {
      $html = sg_wrap_resources_filter_results( $html, $atts, $posts_are_empty, $subtypes_are_empty, $top_types_are_empty );
    }

    return $html;
  }
  
  add_shortcode( 'sg_resources_filter_results', 'shortcode_sg_resources_filter_results' );
}


if ( !function_exists('sg_resources_filter_results_by_ajax') ) {
  function sg_resources_filter_results_by_ajax() {
    $type_terms = get_terms( array(
      'taxonomy' => 'sg_type',
      'hide_empty' => true
    ) );
    
    $list_keys = array( 'post_types', 'types', 'exclude_types', 'featured_posts', 'layout', 'type_layout' );
    $int_keys = array( 
      'posts_number', 'load_subtypes', 'hide_empty_subtypes', 'load_top_types', 'hide_empty_top_types', 
      'hide_tags', 'show_post_link_arrow', 'hide_section_heading' 
    );
    $text_keys = array( 'post_link_text', 'section_heading', 'section_link_text', 'not_found_text' );
    $id_keys = array( 'id', 'filter_id' );
    
    $atts = array();
    $shortcode_html = '';
    $result_html = '';
    
    $response = array(
      'log' => array(),
      'result_html' => '',
      'typeSlugs' => array(),
    );
    
    ob_start();
    $response['log'][] = '$_POST: ';
    var_dump($_POST);
    $response['log'][] = ob_get_contents();
    ob_end_clean();
    
    if ( isset($_POST['sg_filter_atts']) && is_array($_POST['sg_filter_atts']) && !empty($_POST['sg_filter_atts']) ) {
      $response['log'][] = 'Got shortcode attributes as array';
      
      $atts = $_POST['sg_filter_atts'];
      
      $response['log'][] = 'Validating attributes.';
      
      foreach ( $atts as $key => $value ) {
        $log_str = 'Attribute ["' . $key . '"] must be';
        
        if ( in_array($key, $list_keys) ) {
          $log_str .= ' a string of a list.';
          
          if ( !is_string($value) ) {
            $log_str .= ' Variable type check fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $log_str .= ' Variable type check success. Initial value: /' . $atts[$key] . '/.';
            
            $value = explode( ',', trim($value) );
            
            $log_str .= ' Attribute items:';
            
            foreach ( $value as $key2 => $value2 ) {
              $log_str .= ' ' . $value2 . ':';
              
              $value2 = sanitize_title( $value2 );
              
              $log_str .= ' sanitization';
              
              if ( !empty($value2) ) {
                $value[$key2] = $value2;
                
                $log_str .= ' success;';
              } else {
                unset( $value[$key2] );
                
                $log_str .= ' fail, value is removed;';
              }
            }
            
            if ( !empty($value) ) {
              $value = implode( ',', $value );
              $atts[$key] = $value;
              
              $log_str .= ' Attribute passed sanitization. Current value: /' . $atts[$key] . '/.';
            } else {
              $log_str .= ' All items failed the sanitization.';
              
              unset( $atts[$key] );
              
              $log_str .= ' Attribute is removed.';
            }
          }
        } else if ( in_array($key, $int_keys) ) {
          $log_str .= ' an integer or a boolean. Initial value: /' . $atts[$key] . '/.';
          
          if ( !is_int($value) && !is_bool($value) ) {
            $log_str .= ' Attribute type check fail.';
            
            $atts[$key] = intval( $value, 10 );
            
            $log_str .= ' Attribute converted to decimal integer. Current value: /' . $atts[$key] . '/.';
          }
        } else if ( in_array($key, $text_keys) ) {
          $log_str .= ' a text string. Initial value: /' . $atts[$key] . '/.';
          
          $value = (string) $value;
          $value = preg_replace( '/[^-\w\s\p{P}]/', '', $value );
          
          if ( empty($value) ) {
            $log_str .= ' Sanitization fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $atts[$key] = $value;
            
            $log_str .= ' Sanitization success. Current value: /' . $atts[$key] . '/.';
          }
        } else if ( in_array($key, $id_keys) ) {
          $log_str .= ' an id string. Initial value: /' . $atts[$key] . '/.';
          
          $value = (string) $value;
          $value = str_replace ( ' ', '', $value );
          $value = sanitize_html_class( $value );
          
          if ( empty($value) ) {
            $log_str .= ' Sanitization fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $atts[$key] = $value;
            
            $log_str .= ' Sanitization success. Current value: /' . $atts[$key] . '/.';
          }
        } else if ( $key == 'section_link' ) {
          $log_str .= ' an URL string. Initial value: /' . $atts[$key] . '/.';
          
          $value = filter_var( $value, FILTER_VALIDATE_URL );
          
          $log_str .= ' Validation';
          
          if ( !empty($value) ) {
            $log_str .= ' success.';
            
            $value = filter_var( $value, FILTER_SANITIZE_URL );
            
            $log_str .= ' Sanitization';
          } else {
            $log_str .= ' fail.';
          }
          
          if ( empty($value) ) {
            $log_str .= ' fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $log_str .= ' success.';
            
            $atts[$key] = $value;
            
            $log_str .= ' Current value: /' . $atts[$key] . '/.';
          }
        } else if ( $key == 'class' ) {
          $log_str .= ' a class string. Initial value: /' . $atts[$key] . '/.';
          
          $value = (string) $value;
          $value = sanitize_html_class( trim($value) );
          
          if ( empty($value) ) {
            $log_str .= ' Sanitization fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $atts[$key] = $value;
            
            $log_str .= ' Sanitization success. Current value: /' . $atts[$key] . '/.';
          }
        } else if ( $key == 'topic' ) {
          $log_str .= ' a topic slug string. Initial value: /' . $atts[$key] . '/.';
          
          $value = (string) $value;
          $value = sanitize_title( $value );
          
          $log_str .= ' sanitization';
              
          if ( empty($value) ) {
            $log_str .= ' Sanitization fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $atts[$key] = $value;
            
            $log_str .= ' Sanitization success. Current value: /' . $atts[$key] . '/.';
          }
        } else if ( $key == 'default_language' ) {
          $log_str .= ' a default language slug string. Initial value: /' . $atts[$key] . '/.';
          
          $value = (string) $value;
          $value = sanitize_title( $value );
          
          $log_str .= ' sanitization';
          
          if ( empty($value) ) {
            $log_str .= ' Sanitization fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $atts[$key] = $value;
            
            $log_str .= ' Sanitization success. Current value: /' . $atts[$key] . '/.';
          }
        } else if ( $key == 'featured_links' ) {
          $log_str .= ' a string of a url list.';
          
          if ( !is_string($value) ) {
            $log_str .= ' Variable type check fail.';
            
            unset( $atts[$key] );
            
            $log_str .= ' Attribute is removed.';
          } else {
            $log_str .= ' Variable type check success. Initial value: /' . $atts[$key] . '/.';
            
            $value = preg_replace( '/\s+/', ' ', $value );

            if ( !empty($value) && $value != ' ' ) {
              // turn into an array
              $value = explode( ' ', $value );
              
              $log_str .= ' Attribute items:';
              
              foreach ( $value as $key2 => $value2 ) {
                $log_str .= ' ' . $value2 . ':';
                
                $value2 = sanitize_url( trim($value2) );
                
                $log_str .= ' sanitization';
                
                if ( !empty($value2) ) {
                  $value[$key2] = $value2;
                  
                  $log_str .= ' success;';
                } else {
                  unset( $value[$key2] );
                  
                  $log_str .= ' fail, value is removed;';
                }
              }
              
              if ( !empty($value) ) {
                $value = implode( ' ', $value );
                $atts[$key] = $value;
                
                $log_str .= ' Attribute passed sanitization. Current value: /' . $atts[$key] . '/.';
              } else {
                $log_str .= ' All items failed the sanitization.';
                
                unset( $atts[$key] );
                
                $log_str .= ' Attribute is removed.';
              }
            } else {
              $log_str .= ' Variable space char sanitization fail.';
              
              unset( $atts[$key] );
              
              $log_str .= ' Attribute is removed.';
            }
          }
        } 
        
        $response['log'][] = $log_str;
      }
    }
    
    $response['log'][] = 'Attributes are validated.';
    
    if ( empty($atts) ) {
      $response['log'][] = 'All attributes are invalid. Shortcode will be called with the default attributes.';
    }
    
    $response['log'][] = 'Preparing the shortcode.';
    
    $atts['ajax_request'] = true;
    
    if ( class_exists('WPBMap') and method_exists('WPBMap', 'addAllMappedShortcodes') ) {
      WPBMap::addAllMappedShortcodes();
    }
    
    $response['result_html'] = shortcode_sg_resources_filter_results( $atts );
    
    $response['log'][] = 'Shortcode was called.';
    
    $response['posts_are_empty'] = 0;
    $response['subtypes_are_empty'] = 0;
    $response['top_types_are_empty'] = 0;
    
    if ( empty($response['result_html']) || strpos($response['result_html'], 'sg-resources-not-found') !== false ) {
      $response['top_types_are_empty'] = 1;
      $response['posts_are_empty'] = 1;
      $response['subtypes_are_empty'] = 1;
      
      $response['log'][] = 'No resources found';
    } else {
      if ( strpos($response['result_html'], 'sg-resources-list--toptypes') === false ) {
        $response['top_types_are_empty'] = 1;
        $response['log'][] = 'No top types found';
      }
      
      if ( strpos($response['result_html'], 'sg-resources-list--subtypes') === false ) {
        $response['subtypes_are_empty'] = 1;
        $response['log'][] = 'No subtypes found';
      }
      
      if ( strpos($response['result_html'], 'sg-resources-list--posts') === false ) {
        $response['posts_are_empty'] = 1;
        $response['log'][] = 'No posts found';
      }
    }
    
    $response['log'][] = 'Encoding the result.';
    
    echo json_encode($response);
    wp_die();
  }
}
add_action( 'wp_ajax_sg_resources_filter_results_by_ajax', 'sg_resources_filter_results_by_ajax' ); // If called from admin panel
add_action( 'wp_ajax_nopriv_sg_resources_filter_results_by_ajax', 'sg_resources_filter_results_by_ajax' ); // If called from front end


if ( !function_exists('sg_resources_filter_get_active_types_for_nav_by_ajax') ) {
  function sg_resources_filter_get_active_types_for_nav_by_ajax() {
    $type_terms = get_terms( array(
      'taxonomy' => 'sg_type',
      'hide_empty' => true
    ) );
    
    if ( is_wp_error($type_terms) || empty($type_terms) ) {
      $type_terms = null;
      $response['log'][] = 'Error: Could\'nt find types.';
    } else {
      $topic = null;
      $language = null;
      $search_text = '';
      $types_list = array();
      $response = array(
        'log' => array(),
        'typeSlugs' => array(),
      );
      
      ob_start();
      $response['log'][] = '$_POST: ';
      var_dump($_POST);
      $response['log'][] = ob_get_contents();
      ob_end_clean();
      
      $response['log'][] = 'Validating $_POST data.';
      
      if ( isset($_POST['filter_search']) && is_string($_POST['filter_search']) && !empty($_POST['filter_search']) ) {
        $response['log'][] = 'Search text. Initial value: /' . $_POST['filter_search'] . '/.';
        
        $search_text = sanitize_text_field( $_POST['filter_search'] );
        
        if ( empty($search_text) ) {
          $response['log'][] = 'Search text sanitization fail.';
        } else {
          $response['log'][] = 'Search text sanitization success. Current value: /' . $search_text . '/.';
        }
      }
      
      if ( isset($_POST['filter_topic']) && is_string($_POST['filter_topic']) && !empty($_POST['filter_topic']) ) {
        $response['log'][] = 'Topic slug string. Initial value: /' . $_POST['filter_topic'] . '/.';
        
        $topic = validate_shortcode_sg_resources_filter_POST_term( 'filter_topic' );
        
        if ( empty($topic) ) {
          $topic = null;
          $response['log'][] = 'Topic slug sanitization fail.';
        } else {
          $response['log'][] = 'Topic slug sanitization success. Current value: /' . $topic . '/.';
        }
      }
      
      if ( isset($_POST['filter_language']) && is_string($_POST['filter_language']) && !empty($_POST['filter_language']) ) {
        $response['log'][] = 'Language slug string. Initial value: /' . $_POST['filter_language'] . '/.';
        
        $language = validate_shortcode_sg_resources_filter_POST_term( 'filter_language' );
        
        if ( empty($language) ) {
          $language = null;
          $response['log'][] = 'Language slug sanitization fail.';
        } else {
          $response['log'][] = 'Language slug sanitization success. Current value: /' . $language . '/.';
        }
      }
      
      foreach ( $type_terms as $type ) {
        if ( !$search_text && !$topic && !$language ) {
          $types_list[] = $type->slug;
        } else {
          $args = array(
            'post_type' => 'any',
            'posts_per_page' => -1,
            'tax_query' => array(
              'relation' => 'AND',
              array(
                'taxonomy' => 'sg_type',
                'field' => 'slug',
                'terms' => $type->slug,
              ),
            ),
          );
          
          if ($topic) {
            $args['tax_query'][] = array(
              'taxonomy' => 'sg_topic',
              'field' => 'slug',
              'terms' => $topic,
            );
          }
          
          if ($language) {
            $args['tax_query'][] = array(
              'taxonomy' => 'sg_language',
              'field' => 'slug',
              'terms' => $language,
            );
          }
          
          if ($search_text) {
            $args['s'] = $search_text;
          }
          
          $sg_query = new WP_Query( $args );
          
          if ( !empty($sg_query->found_posts) ) {
            $types_list[] = $type->slug;
          }
        }
      }
      
      if ( !empty($types_list) ) {
        $response['typeSlugs'] = $types_list;
      }
    }
    
    $response['log'][] = 'Encoding the result.';
    
    echo json_encode($response);
    wp_die();
  }
}
add_action( 'wp_ajax_sg_resources_filter_get_active_types_for_nav_by_ajax', 'sg_resources_filter_get_active_types_for_nav_by_ajax' ); // If called from admin panel
add_action( 'wp_ajax_nopriv_sg_resources_filter_get_active_types_for_nav_by_ajax', 'sg_resources_filter_get_active_types_for_nav_by_ajax' ); // If called from front end


if ( !function_exists('shortcode_sg_featured_product') ) {
  function shortcode_sg_featured_product( $atts ) {
    $atts = shortcode_atts(
      array(
        'product_id' => '',
        'layout' => 'default',
        'title' => '',
        'subtitle' => '',
        'hide_add_to_cart' => false,
        'show_product_id' => false,
        'add_to_cart_link' => '',
        'add_to_cart_text' => '',
        'learn_more_link' => false,
      ),
      $atts,
      'sg_featured_product'
    );
    $html = '';
    
    if ( empty($atts['product_id']) ) {
      return '';
    }
    
    if ( !is_integer($atts['product_id']) ) {
      $atts['product_id'] = intval($atts['product_id'], 10);
    }
    
    if ( empty($atts['product_id']) || $atts['product_id'] <= 0 ) {
      return '';
    }
    
    $allowed_layouts = array( 'default', 'columns', 'columns-2' );

    if ( empty($atts['layout']) || !in_array($atts['layout'], $allowed_layouts) ) {
      $atts['layout'] = 'default';
    }
    
    if ( !empty($atts['title']) ) {
      $atts['title'] = esc_html( sanitize_text_field( $atts['title'] ) );
    }
    
    if ( !empty($atts['subtitle']) ) {
      $atts['subtitle'] = esc_html( sanitize_text_field( $atts['subtitle'] ) );
    }
    
    if ( !empty($atts['add_to_cart_text']) ) {
      $atts['add_to_cart_text'] = esc_html( sanitize_text_field( $atts['add_to_cart_text'] ) );
    }
    
    if ( !empty($atts['add_to_cart_link']) ) {
      $atts['add_to_cart_link'] = esc_url( $atts['add_to_cart_link'] );
    }
    
    $atts['hide_add_to_cart'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_add_to_cart'], false );
    
    $atts['show_product_id'] = validate_shortcode_sg_resources_filter_bool( $atts['show_product_id'], false );

    $atts['learn_more_link'] = validate_shortcode_sg_resources_filter_bool( $atts['learn_more_link'], false );
    
    $product = wc_get_product( $atts['product_id'] );
    
    if ( !empty($product) ) {
      ob_start();
      
      get_template_part( 'inc/shortcodes/sg/sg-featured-product', null, array(
        'featured_product' => $product,
        'title' => $atts['title'],
        'subtitle' => $atts['subtitle'],
        'layout' => $atts['layout'],
        'hide_add_to_cart' => $atts['hide_add_to_cart'],
        'show_product_id' => $atts['show_product_id'],
        'add_to_cart_link' => $atts['add_to_cart_link'],
        'add_to_cart_text' => $atts['add_to_cart_text'],
        'learn_more_link' => $atts['learn_more_link'],
      ) );
      
      $html .= ob_get_contents();
      
      ob_end_clean();
    }
    
    return $html;
  }
  
  add_shortcode( 'sg_featured_product', 'shortcode_sg_featured_product' );
}


if ( !function_exists('shortcode_sg_new_products') ) {
  function shortcode_sg_new_products( $atts ) {
    $atts = shortcode_atts(
      array(
        'start_date' => '',
        'days_ago' => '',
        'items_limit' => 50,
        'layout' => 'default',
        'hide_add_to_cart' => false
      ),
      $atts,
      'sg_new_products'
    );
    $html = '';
    
    $allowed_layouts = array( 'default', 'columns' );

    if ( empty($atts['layout']) || !in_array($atts['layout'], $allowed_layouts) ) {
      $atts['layout'] = 'default';
    }
    
    $atts['hide_add_to_cart'] = validate_shortcode_sg_resources_filter_bool( $atts['hide_add_to_cart'], false );
    
    $limit = 50;
    $start_date = '';
    $end_date = date('Y-m-d', strtotime('2100-12-31'));
    
    if ( !empty($atts['start_date']) ) {
      $dateTime = DateTime::createFromFormat('Y-m-d', $atts['start_date']);
      
      if (!$dateTime || $dateTime->format('Y-m-d') !== $atts['start_date']) {
        $start_date = '';
      } else {
        $start_date = $atts['start_date'];
      }
    }
    
    if ( !$start_date && !empty($atts['days_ago']) ) {
      $date = '';
      
      if ( !is_integer($atts['days_ago']) ) {
        $atts['days_ago'] = intval($atts['days_ago'], 10);
      }
      
      if ( !empty($atts['days_ago']) && $atts['days_ago'] > 0 ) {
        $date = date( 'Y-m-d', strtotime($atts['days_ago'] . ' day' . (($atts['days_ago'] > 1) ? 's' : '') . ' ago') );
      } else if ( $atts['days_ago'] === 0 ) {
        $date = date( 'Y-m-d', strtotime('today') );
      }
      
      if ( $date ) {
        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        
        if ($dateTime && $dateTime->format('Y-m-d') === $date) {
          $start_date = $date;
        }
      }
    }
    
    if ( !is_integer($atts['items_limit']) ) {
      $atts['items_limit'] = intval($atts['items_limit'], 10);
    }
    
    if ( empty($atts['items_limit']) || $atts['items_limit'] < -1 ) {
      $limit = 50;
    } else {
      $limit = $atts['items_limit'];
    }
    
    $args = array(
      'limit' => $atts['items_limit'],
      'orderby' => 'modified',
      'order' => 'DESC',
      'status' => 'publish',
    );
    
    if ( $start_date ) {
      $args['date_modified'] = $start_date . '...' . $end_date;
    }
    
    $products = wc_get_products( $args );
    
    if ( !empty($products) ) {
      ob_start();
      
      get_template_part( 'inc/shortcodes/sg/sg-new-products', null, array(
        'new_products' => $products,
        'layout' => $atts['layout'],
        'hide_add_to_cart' => $atts['hide_add_to_cart']
      ) );
      
      $html .= ob_get_contents();
      
      ob_end_clean();
    }
    
    return $html;
  }
  
  add_shortcode( 'sg_new_products', 'shortcode_sg_new_products' );
}