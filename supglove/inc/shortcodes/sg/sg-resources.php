<?php

/**
 * @package Supglove
 */

global $post;

if ( empty($args['resources_section_heading']) && !$args['resources_hide_section_heading'] && !empty($args['resources_types']) ) {
  $args['resources_section_heading'] = array();
  
  foreach ( $args['resources_types'] as $resource_type ) {
    $type = get_term_by( 'slug', $resource_type, 'sg_type' );
    
    if ( !empty($type) && !empty($type->name) ) {
      $args['resources_section_heading'][] = esc_html__( $type->name, 'SuperiorGlove' );
    }
  }
  
  $args['resources_section_heading'] = implode( ', ', $args['resources_section_heading'] );
}

if ( empty($args['resources_post_link_text']) ) {
  $args['resources_post_link_text'] = _x('Read Now', '[sg_resources_filter_results]', 'SuperiorGlove');
}

if ( empty($args['resources_section_link_text']) ) {
  $args['resources_section_link_text'] = _x( 'View All', '[sg_resources_filter_results]', 'SuperiorGlove' );
}

$excerpt_length = intval( supro_get_option('excerpt_length') );

if ( !$excerpt_length ) {
  $excerpt_length = 35;
}

if ( !empty($args['resources_layout']) ) {
  $posts_layout = esc_attr( $args['resources_layout'] );
}

if ( empty($posts_layout) ) {
  $posts_layout = 'default';
}

if ( !empty($args['resources_type_layout']) ) {
  $types_layout = esc_attr( $args['resources_type_layout'] );
}

if ( empty($types_layout) ) {
  $types_layout = 'default';
}

if ( empty($args['resources_not_found_text']) ) {
  $args['resources_not_found_text'] = _x( 'Resources not found.', '[sg_resources_filter_results]', 'SuperiorGlove' );
}

if ( empty($args['resources_current_language']) || !is_string($args['resources_current_language']) ) {
  $args['resources_current_language'] = '';
}

$section_link = '';
$section_link_language_get_part = true;

if ( !empty($args['resources_section_link']) ) {
  $q_pos = strpos( $args['resources_section_link'], '?' );
  $get_part = '';
  
  if ( !empty($args['resources_active_search']) ) {
    $get_part .= ( ($q_pos !== false || $get_part != '') ? '&' : '?' ) . 'sg_filter_search=' . urlencode( $args['resources_active_search'] );
    $q_pos = true;
  }
  
  if ( $args['resources_topic'] ) {
    $get_part .= ( ($q_pos !== false) ? '&' : '?' ) . 'sg_filter_topic=' . $args['resources_topic'];
    $q_pos = true;
  }
  
  $section_link = $args['resources_section_link'] . ( !empty($get_part) ? $get_part : '' );
}

$posts_per_load = -1;

if ( isset($args['resources_per_load']) && $args['resources_per_load'] >= -1 ) {
	$posts_per_load = $args['resources_per_load'];
}

$weglot_site_languages_list = null;
$weglot_site_language = null;
$weglot_site_language_external_code = null;
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
  
  //var_dump($weglot_site_languages_list); echo '<br />'; echo '<br />';
  
  /*
    array(3) {
      [0]=> array(5) {
        ["language_to"] => string(2) "fr"
        ["custom_code"] => NULL
        ["custom_name"] => NULL
        ["custom_local_name"] => NULL
        ["public"] => bool(true)
      }
      [1] => array(5) {
        ["language_to"] => string(2) "es"
        ["custom_code"] => NULL
        ["custom_name"] => NULL
        ["custom_local_name"] => NULL
        ["public"] => bool(true)
      }
      [2] => array(5) {
        ["language_to"] => string(2) "br"
        ["custom_code"] => NULL
        ["custom_name"] => NULL
        ["custom_local_name"] => NULL
        ["public"] => bool(true)
      }
    }
  */
  
  if ( !empty($weglot_site_languages_list) ) {
    $weglot_original_language = weglot_get_original_language();
    
    //var_dump( $weglot_original_language ); echo '<br />'; echo '<br />';
    
    /*
      string(2) "en"
    */
    
    $weglot_site_language = weglot_get_current_language();
    
    //var_dump( $weglot_site_language ); echo '<br />'; echo '<br />';
    
    /*
      string(2) "en"
      string(2) "fr"
      string(2) "es"
      string(2) "br"
    */
  }
  
  if ( $weglot_original_language /*|| $weglot_site_language */) {
    $weglot_language_services = weglot_get_service( 'Language_Service_Weglot' );
    $weglot_request_url_services = weglot_get_service( 'Request_Url_Service_Weglot' );
  }
  
  if ( $weglot_site_language && !empty($weglot_language_services) && !empty($weglot_request_url_services) ) {
    $weglot_site_language_obj = $weglot_language_services->get_language_from_internal( $weglot_site_language );
    
    /*
      object(Weglot\Client\Api\LanguageEntry)#2471 (5) {
        ["internalCode":protected]=> string(2) "en" 
        ["externalCode":protected]=> string(2) "en" 
        ["englishName":protected]=> string(7) "English" 
        ["localName":protected]=> string(7) "English" 
        ["isRtl":protected]=> bool(false) 
      }
      
      object(Weglot\Client\Api\LanguageEntry)#2368 (5) { 
        ["internalCode":protected]=> string(2) "fr" 
        ["externalCode":protected]=> string(2) "fr" 
        ["englishName":protected]=> string(6) "French" 
        ["localName":protected]=> string(9) "Français" 
        ["isRtl":protected]=> bool(false) 
      }
      
      object(Weglot\Client\Api\LanguageEntry)#2465 (5) { 
        ["internalCode":protected]=> string(2) "es" 
        ["externalCode":protected]=> string(2) "es" 
        ["englishName":protected]=> string(7) "Spanish" 
        ["localName":protected]=> string(8) "Español" 
        ["isRtl":protected]=> bool(false) 
      }
      
      object(Weglot\Client\Api\LanguageEntry)#2401 (5) { 
        ["internalCode":protected]=> string(2) "br" 
        ["externalCode":protected]=> string(5) "pt-br" 
        ["englishName":protected]=> string(20) "Brazilian Portuguese" 
        ["localName":protected]=> string(21) "Português Brasileiro" 
        ["isRtl":protected]=> bool(false) 
      }
      
      public function getInternalCode()
      public function getExternalCode()
      public function getEnglishName()
      public function getLocalName()
    */
  }
  
  if  ( $weglot_site_language_obj ) {
    $weglot_site_language_external_code = $weglot_site_language_obj->getExternalCode();
    
    if ( !empty($section_link) ) {
      $weglot_section_url_object = $weglot_request_url_services->create_url_object( $section_link );
      
      if ( !empty($weglot_section_url_object) ) {
        $weglot_section_link = $weglot_section_url_object->getForLanguage( $weglot_site_language_obj );
        
        if ( !empty($weglot_section_link) ) { 
          $section_link = $weglot_section_link;
          $section_link_language_get_part = false;
        }
      }
    }
  }
}

if ( 
  !empty($section_link) && $section_link_language_get_part && 
  !empty($args['resources_current_language']) && is_string($args['resources_current_language']) 
) {
  $get_part = ( ($q_pos !== false) ? '&' : '?' ) . 'sg_filter_language=' . $args['resources_current_language'];
  $section_link .= $get_part;
}
?>
<?php if ( !empty($args['resources_section_heading']) && !$args['resources_hide_section_heading'] ) : ?>
  <h2 class="sg-resources-section-heading sg-resources-section-heading--layout-<?php
  echo $args['resources_layout'] . ( 
    (empty($args['resources_posts']) && empty($args['resources_subtypes']) && empty($args['resources_top_types'])) 
    ? ' sg-resources-section-heading--empty' : '' 
  ); ?>">
    <span class="sg-resources-section-heading-text sg-resources-section-heading-text--layout-<?php echo $args['resources_layout']; ?>"><?php
      echo esc_html( $args['resources_section_heading'] ); 
    ?></span>
    <?php if ( 
      !empty($section_link) && (
        ( !empty($args['resources_posts']) && (count($args['resources_posts']) < $args['resources_found_posts']) ) || 
        !empty($args['resources_subtypes']) || 
        !empty($args['resources_top_types'])
      ) 
    ) : ?>
      <a 
        class="sg-resources-section-heading-viewmore-link sg-resources-section-heading-viewmore-link--layout-<?php echo $args['resources_layout']; ?>" 
        href="<?php echo esc_url( $section_link ); ?>"
      >
        <span 
          class="sg-resources-section-heading-viewmore-text sg-resources-section-heading-viewmore-text--layout-<?php echo $args['resources_layout']; ?>" 
        ><?php 
          echo esc_html( $args['resources_section_link_text'] );
          // echo esc_html_x( $args['resources_section_link_text'], '[sg_resources_filter_results]', 'SuperiorGlove' ); 
        ?></span>
        <span class="sg-resources-section-heading-viewmore-icon sg-resources-section-heading-viewmore-icon--layout-<?php echo $args['resources_layout']; ?>">
          <svg width="100%" height="100%" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.2391 5.27029H0.625977V6.75579H13.2138L8.12598 12H10.1178L15.9392 5.99993L10.1178 0H8.12598L13.2391 5.27029Z" fill="currentColor" />
          </svg>
        </span>
      </a>
    <?php endif; ?>
  </h2>
<?php endif; ?>

<?php if (!empty($args['resources_posts']) || !empty($args['resources_subtypes']) || !empty($args['resources_top_types']) ) : 
  static $list_count = 0;
  
  if ( empty($args['resources_system_id']) && $args['resources_system_id'] !== 0 && $args['resources_system_id'] !== '0' ) {
    $args['resources_system_id'] = $list_count++;
  }
?>
  <?php if ( !empty($args['resources_posts']) ) : 
    $items_with_language_links = 0;
    $featured_posts_count = 0;
    
    if ( !empty($args['resources_found_featured_posts']) ) {
      $featured_posts_count = count( $args['resources_found_featured_posts'] );
    }
    
    if ( !empty($args['resources_featured_links']) && !$featured_posts_count ) {
      $args['resources_featured_links'] = null;
    }
  ?>
    <div class="sg-resources-list sg-resources-list--posts sg-resources-list--layout-<?php echo $posts_layout; ?> sg-resources-list--num-<?php 
    echo esc_attr( $args['resources_system_id'] ); ?>">
      
      <?php foreach ($args['resources_posts'] as $key => $post) : setup_postdata($post);
        $thumbnail = get_the_post_thumbnail(
          get_the_ID(),
          'large',
          array('class' => 'sg-resource-item__thumbnail sg-resource-item__thumbnail--layout-' . $posts_layout)
        );
        $the_permalink = apply_filters( 'the_permalink', get_the_permalink( get_the_ID() ) );
        $the_slug = get_post_field( 'post_name', get_the_ID() );
        $language_links = array();
        $primary_term_id = null;
        $is_video = false;
        $type_classes = '';
        $topic_classes = '';
        $post_excerpt = '';
        $the_title = '';
        $the_subtitle = '';
        $terms = null;

        $type_terms = wp_get_post_terms(
          get_the_ID(),
          'sg_type',
          array(
            'hide_empty' => true
          )
        );
        
        $topic_terms = wp_get_post_terms(
          get_the_ID(),
          'sg_topic',
          array(
            'hide_empty' => true
          )
        );
        
        $language_terms = wp_get_post_terms(
          get_the_ID(),
          'sg_language',
          array(
            'hide_empty' => true
          )
        );
        
        if ( !is_wp_error($type_terms) && !empty($type_terms) ) {
          foreach ( $type_terms as $term ) {
            if ( $term->slug == 'videos' ) {
              $is_video = true;
              $args['resources_post_link_text'] = _x( 'Watch Now', '[sg_resources_filter_results]', 'SuperiorGlove' );
            }
            
            $type_classes .= ' sg-resource-item--type-' . $term->slug;
          }
        }
        
        if ( !is_wp_error($topic_terms) && !empty($topic_terms) ) {
          foreach ( $topic_terms as $term ) {
            $topic_classes .= ' sg-resource-item--topic-' . $term->slug;
          }
        }
        
        if ( empty($args['resources_hide_tags']) ) {
          if ( !empty($args['resources_load_type_tags']) ) {
            $terms = $type_terms;
          } else {
            $terms = $topic_terms;
          }
        }
        
        if ( !is_wp_error($terms) && !empty($terms) && function_exists('yoast_get_primary_term') ) {
          if ( !empty($args['resources_load_type_tags']) ) {
            $primary_term_id = yoast_get_primary_term_id( 'sg_type', get_the_ID() );
          } else {
            $primary_term_id = yoast_get_primary_term_id( 'sg_topic', get_the_ID() );
          }
        }
        
        $post_excerpt = supro_content_limit( $excerpt_length, '' );
        
        if ( $post_excerpt == '<div></div>' || $post_excerpt == '<p></p>' ) {
          $post_excerpt = '';
        }
        
        $weglot_URL_object = null;
        
        if ( !empty($args['resources_site_languages']) && !is_wp_error($language_terms) && !empty($language_terms) ) {
          if ( !empty($weglot_site_languages_list) && !empty($weglot_request_url_services) && !empty($weglot_language_services) ) {
            $weglot_URL_object = $weglot_request_url_services->create_url_object( $the_permalink );
          }
          
          foreach( $language_terms as $language_term ) {
            $language_short_title = get_term_meta( $language_term->term_id, 'language_short_title', true );
            $language_term_code = get_term_meta( $language_term->term_id, 'language_code', true );

            if ( $weglot_URL_object && $language_term_code ) {
              // original language
              if ( $weglot_original_language && $language_term_code === $weglot_original_language ) {
                $tag = 'span';
                $link = '';
                $weglot_permalink = '';
                $data_language_code = '';
                $data_attributes = '';
                
                $weglot_url_object = $weglot_request_url_services->create_url_object( $the_permalink );
                $weglot_original_language_object = $weglot_language_services->get_language_from_internal( $weglot_original_language );
                
                if ( !empty($weglot_url_object) && !empty($weglot_original_language_object) ) {
                  $weglot_permalink = $weglot_url_object->getForLanguage( $weglot_original_language_object );
                  $data_language_code = $weglot_original_language_object->getExternalCode();
                  
                  if ( $data_language_code ) {
                    $data_attributes .= ' data-translation-language="' . esc_attr( $data_language_code ) . '"';
                  }
                  
                  if ( $weglot_site_language_external_code ) {
                    $data_attributes .= ' data-site-language="' . esc_attr( $weglot_site_language_external_code ) . '"';
                  }
                }
                
                if ( $weglot_permalink ) {
                  if ( empty($args['resources_current_language']) || $args['resources_current_language'] !== $language_term->slug ) {
                    $tag = 'a';
                    $link = ' href="' . esc_url( $weglot_permalink ) . '"' . $data_attributes;
                  } else if ( !empty($args['resources_current_language']) && $args['resources_current_language'] === $language_term->slug ) {
                    $new_permalink = $weglot_permalink;
                    $new_permalink_attr = $data_attributes;
                  }
                }
                
                $language_links[] = 
                  '<'. $tag . ' class="sg-resource-item__language-link sg-resource-item__language-link--' . $posts_layout . '"' . $link . '>' 
                    . ( $language_short_title ? $language_short_title : $language_term->name ) 
                  . '</'. $tag . '>';
              }
              
              // destination languages (original language is not included)
              foreach( $weglot_site_languages_list as $weglot_language ) {
                if ( $language_term_code === $weglot_language['language_to'] ) {
                  $tag = 'span';
                  $link = '';
                  $weglot_permalink = '';
                  $data_attributes = '';
                  $data_language_code = '';
                  
                  $weglot_url_object = $weglot_request_url_services->create_url_object( $the_permalink );
                  $weglot_destination_language_object = $weglot_language_services->get_language_from_internal( $weglot_language['language_to'] );
                  
                  if ( !empty($weglot_url_object) && !empty($weglot_destination_language_object) ) {
                    $weglot_permalink = $weglot_url_object->getForLanguage( $weglot_destination_language_object );
                    $data_language_code = $weglot_destination_language_object->getExternalCode();
                    
                    if ( $data_language_code ) {
                      $data_attributes .= ' data-translation-language="' . esc_attr( $data_language_code ) . '"';
                    }
                    
                    if ( $weglot_site_language_external_code ) {
                      $data_attributes .= ' data-site-language="' . esc_attr( $weglot_site_language_external_code ) . '"';
                    }
                  }
                  
                  if ( $weglot_permalink ) {
                    if ( empty($args['resources_current_language']) || $args['resources_current_language'] !== $language_term->slug ) {
                      $tag = 'a';
                      $link = ' href="' . esc_url( $weglot_permalink ) . '"' . $data_attributes;
                    } else if ( !empty($args['resources_current_language']) && $args['resources_current_language'] === $language_term->slug ) {
                      $new_permalink = $weglot_permalink;
                      $new_permalink_attr = $data_attributes;
                    }
                  }

                  $language_links[] = 
                    '<'. $tag . ' class="sg-resource-item__language-link sg-resource-item__language-link--' . $posts_layout . '"' . $link . '>' 
                      . ( $language_short_title ? $language_short_title : $language_term->name ) 
                    . '</'. $tag . '>';
                }
              }
            } else {
              foreach( $args['resources_site_languages'] as $site_language ) {
                if ( $site_language['slug'] == $language_term->slug ) {
                  // this resource has active language category 
                  if ( $args['resources_current_language'] != $language_term->slug ) {
                    $tag = 'a';
                    $link = ' href="' . esc_url($the_permalink . ( (strpos($the_permalink, '?') === false) ? '?' : '&' ) . 'sg_lang=' . $language_term->slug) . '"';
                  } else {
                    $tag = 'span';
                    $link = '';
                  }
                  
                  $language_links[] = 
                    '<'. $tag . ' class="sg-resource-item__language-link sg-resource-item__language-link--' . $posts_layout . '"' . $link . '>' 
                      . ( $language_short_title ? $language_short_title : $language_term->name ) 
                    . '</'. $tag . '>';
                }
              }
            }
          }
        }
        
        if ( !empty($new_permalink) ) {
          $the_permalink = $new_permalink;
        }

          if ( function_exists('rwmb_meta') ) {
              $the_title = '';
              $the_subtitle = '';

              if ( function_exists('weglot_get_current_language') ) {
                  $current_lang = weglot_get_current_language();

                  switch ( $current_lang ) {
                      case 'fr':
                          $the_title = rwmb_meta( 'sg_post_custom_title_fr' );
                          $the_subtitle = rwmb_meta( 'sg_post_custom_subtitle_fr' );
                          break;
                      case 'pt-br':
                          $the_title = rwmb_meta( 'sg_post_custom_title_pt' );
                          $the_subtitle = rwmb_meta( 'sg_post_custom_subtitle_pt' );
                          break;
                      case 'es':
                          $the_title = rwmb_meta( 'sg_post_custom_title_es' );
                          $the_subtitle = rwmb_meta( 'sg_post_custom_subtitle_es' );
                          break;
                      case 'en':
                      default:
                          $the_title = rwmb_meta( 'sg_post_custom_title' );
                          $the_subtitle = rwmb_meta( 'sg_post_custom_subtitle' );
                          break;
                  }
              } else {
                  $the_title = rwmb_meta( 'sg_post_custom_title' );
                  $the_subtitle = rwmb_meta( 'sg_post_custom_subtitle' );
              }

              if ( empty($the_title) ) {
                  $the_title = apply_filters( 'the_title', get_the_title(), get_the_ID() );
              }

              if ( !isset($the_subtitle) || empty($the_subtitle) ) {
                  $the_subtitle = '';
              }
          }
      ?>
        <div 
          id="resource-item--<?php echo $the_slug; ?>" 
          class="sg-resource-item sg-resource-item--layout-<?php echo $posts_layout . $type_classes . $topic_classes; ?>"
        >
          <div class="sg-resource-item__inner sg-resource-item__inner--layout-<?php echo $posts_layout; ?>">
            <div class="sg-resource-item__image sg-resource-item__image--layout-<?php echo $posts_layout; ?>">
              <div class="sg-resource-item__image-wrap sg-resource-item__image-wrap--layout-<?php echo $posts_layout 
                . ( empty($thumbnail) ? ' sg-resource-item__image-inner--empty' : '' ); ?>">
                <div class="sg-resource-item__image-inner sg-resource-item__image-inner--layout-<?php echo $posts_layout 
                  . ( empty($thumbnail) ? ' sg-resource-item__image-inner--empty' : '' ); 
                ?>">
                  <?php if (!empty($thumbnail)) : echo $thumbnail; ?>
                  <?php else : ?>
                    <img 
                      src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/hand-gloves-protective-icon.svg' ); ?>" 
                      class="sg-resource-item__thumbnail sg-resource-item__thumbnail--dummy sg-resource-item__thumbnail--layout-<?php 
                        echo $posts_layout; 
                      ?>" 
                    />
                  <?php endif; ?>
                </div>
                <?php if ( $is_video ) : ?>
                  <svg 
                    xmlns="http://www.w3.org/2000/svg" width="140" height="140" viewBox="0 0 140 140" fill="none" 
                    class="sg-resource-item__image-icon sg-resource-item__image-icon--layout-<?php echo $posts_layout; ?>"
                  >
                    <path d="M70 140C31.4033 140 0 108.597 0 70C0 31.4033 31.4033 0 70 0C108.597 0 140 31.3999 140 70C140 108.6 108.6 140 70 140ZM70 7.66996C35.6309 7.66654 7.66654 35.6309 7.66654 70C7.66654 104.369 35.6274 132.33 69.9966 132.33C104.366 132.33 132.327 104.369 132.327 70C132.327 35.6309 104.369 7.66654 70 7.66654V7.66996Z" fill="currentColor"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M57.0371 100.248V41.4824L100.247 70.8617L57.0371 100.248Z" fill="currentColor"></path>
                  </svg>
                <?php endif; ?>
                <?php if ( !is_wp_error($terms) && !empty($terms) ) : ?>
                  <p class="sg-resource-item__topic-list sg-resource-item__topic-list--top sg-resource-item__topic-list--top-layout-<?php 
                    echo $posts_layout; 
                  ?>">
                    <?php foreach ( $terms as $term ) : 
                      $is_primary_term = false;
                      
                      if ( !is_wp_error($primary_term_id) && ((!empty($primary_term_id) && $primary_term_id == $term->term_id) || count($terms) == 1) ) {
                        $is_primary_term = true;
                      }
                    ?>
                      <span class="sg-resource-item__topic sg-resource-item__topic--top sg-resource-item__topic--top-layout-<?php 
                        echo $posts_layout . ( $is_primary_term ? ' sg-resource-item__topic--primary' : ''); 
                      ?>"><?php
                        echo esc_html( $term->name ); 
                      ?></span>
                    <?php endforeach; ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
            <div class="sg-resource-item__content sg-resource-item__content--layout-<?php echo $posts_layout; ?>">
              <div class="sg-resource-item__content-inner sg-resource-item__content-inner--layout-<?php echo $posts_layout; ?>">
                <?php if ( !is_wp_error($terms) && !empty($terms) ) : ?>
                  <p class="sg-resource-item__topic-list sg-resource-item__topic-list--layout-<?php echo $posts_layout; ?>">
                    <?php foreach ( $terms as $term ) : 
                      $is_primary_term = false;
                      
                      if ( !is_wp_error($primary_term_id) && ((!empty($primary_term_id) && $primary_term_id == $term->term_id) || count($terms) == 1) ) {
                        $is_primary_term = true;
                      }
                    ?>
                      <span class="sg-resource-item__topic sg-resource-item__topic--layout-<?php 
                        echo $posts_layout . ( $is_primary_term ? ' sg-resource-item__topic--primary' : ''); 
                      ?>"><?php 
                        echo esc_html( $term->name ); 
                      ?></span>
                    <?php endforeach; ?>
                  </p>
                <?php endif; ?>
                <?php if ( $the_title || $the_subtitle ) : ?>
                  <h3 class="sg-resource-item__title sg-resource-item__title--layout-<?php echo $posts_layout; ?>"
                  ><?php if ( $the_title ) : 
                      ?><span class="sg-resource-item__title-text sg-resource-item__title-text--layout-<?php echo $posts_layout; ?>"
                        ><?php echo esc_html( $the_title ); ?></span
                      ><?php endif; 
                    ?><?php if ( $the_subtitle ) : 
                      ?><span class="sg-resource-item__subtitle-text sg-resource-item__subtitle-text--layout-<?php echo $posts_layout; ?>"
                        ><?php echo esc_html( $the_subtitle ); ?></span
                      ><?php endif; 
                  ?></h3>
                <?php endif; ?>
                <?php if ( !empty($post_excerpt) ) : ?>
                  <div class="sg-resource-item__excerpt sg-resource-item__excerpt--layout-<?php echo $posts_layout; ?>"><?php 
                    echo $post_excerpt; 
                  ?></div>
                <?php endif; ?>
                <div class="sg-resource-item__readmore sg-resource-item__readmore--layout-<?php echo $posts_layout 
                . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore--has-arrow' : ''); ?>">
                  <span class="sg-resource-item__readmore-content sg-resource-item__readmore-content--layout-<?php echo $posts_layout 
                  . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore-content--has-arrow' : ''); ?>">
                    <span class="sg-resource-item__readmore-text sg-resource-item__readmore-text--layout-<?php echo $posts_layout 
                    . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore-text--has-arrow' : ''); ?>"><?php 
                      echo esc_html( $args['resources_post_link_text'] ); 
                    ?></span>  
                    <?php if ( ! empty($args['resources_show_post_link_arrow']) ) : ?>
                      <span class="sg-resource-item__readmore-icon sg-resource-item__readmore-icon--layout-<?php echo $posts_layout; ?>">
                        <svg width="100%" height="100%" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M13.2391 5.27029H0.625977V6.75579H13.2138L8.12598 12H10.1178L15.9392 5.99993L10.1178 0H8.12598L13.2391 5.27029Z" fill="currentColor" />
                        </svg>
                      </span>
                    <?php endif; ?>
                  </span>
                  <a 
                    href="<?php 
                      if ( !empty($args['resources_featured_links']) && !empty($args['resources_featured_links'][$key]) ) {
                        echo esc_url( $args['resources_featured_links'][$key] );
                      } else {
                        echo esc_url( $the_permalink );
                      }
                    ?>"
                    class="sg-resource-item__readmore-link sg-resource-item__readmore-link--layout-<?php echo $posts_layout; ?>"
                    <?php if ( !empty( $new_permalink_attr ) ) { echo ' ' . $new_permalink_attr; } ?>
                  ></a>
                </div>
              </div>
            </div>
          </div>
          <?php if ( !empty($language_links) ) : /*$items_with_language_links++; */ ?>
            <p class="sg-resource-item__languages sg-resource-item__languages--layout-<?php echo $posts_layout; ?>"
              ><span class="sg-resource-item__languages-inner sg-resource-item__languages-inner--<?php echo $posts_layout; ?>"><?php 
                echo implode( 
                  '<span class="sg-resource-item__language-delimiter sg-resource-item__language-delimiter--' . $posts_layout . '"></span>', 
                  $language_links 
                );
              ?></span
            ></p>
          <?php endif; ?>
        </div>
      <?php endforeach;
      wp_reset_postdata(); ?>

    </div>
  <?php endif; ?>
  
  <?php if ( !empty($section_link) && !empty($args['resources_posts']) && (count($args['resources_posts']) < $args['resources_found_posts']) ) : ?>
    <div class="sg-resources-section-viewmore sg-resources-section-viewmore--layout-<?php echo $posts_layout; ?>">
      <a 
        class="sg-resources-section-viewmore-text sg-resources-section-viewmore-text--layout-<?php echo $posts_layout; ?>" 
        href="<?php echo esc_url( $section_link ); ?>"
      ><?php
        echo esc_html( $args['resources_section_link_text'] ); 
      ?></a>
    </div>
  <?php endif; ?>
  
  <?php if ( !empty($args['resources_subtypes']) ) : ?>
    <div class="sg-resources-list sg-resources-list--subtypes sg-resources-list--layout-<?php echo $types_layout; ?> sg-resources-list--num-<?php 
    echo esc_attr( $args['resources_system_id'] ); ?>">
      <?php foreach ( $args['resources_subtypes'] as $key => $subtype ) :
        $subtype_title = get_term_meta( $subtype->term_id, 'type_custom_title', true );
        
        if ( !$subtype_title ) {
          $subtype_title = $subtype->name;
        }
      
        $subtype_link = get_term_meta( $subtype->term_id, 'type_archive_url', true );
        
        if ( !$subtype_link ) {
          $subtype_link = get_term_link( $subtype );
          
          if ( is_wp_error($subtype_link) ) {
            $subtype_link = null;
          }
        }
         
        if ( !empty($subtype_link) ) {
          $subtype_link_host = parse_url($subtype_link, PHP_URL_HOST);
          $site_host = parse_url(get_site_url(), PHP_URL_HOST);
          
          $subtype_link_host = explode('.', $subtype_link_host);
          $site_host = explode('.', $site_host);
          
          $subtype_link_host = array_reverse($subtype_link_host);
          $site_host = array_reverse($site_host);
          
          $subtype_link_host = array_filter($subtype_link_host, function( $value ) {
            return ( $value != 'www' );
          });
          $site_host = array_filter($site_host, function( $value ) {
            return ( $value != 'www' );
          });
      
          $subtype_link_host = array_values($subtype_link_host);
          $site_host = array_values($site_host);
          
          foreach ( $site_host as $key => $host_part ) {
            if ( !isset($subtype_link_host[ $key ]) || $host_part != $subtype_link_host[ $key ] ) {
              $subtype_link_target = '_blank';
              break;
            }
          }
          
          $q_pos = strpos( $subtype_link, '?' );
          $get_part = '';
  
          if ( !empty($args['resources_active_search']) ) {
            $get_part .= ( ($q_pos !== false || $get_part != '') ? '&' : '?' ) . 'sg_filter_search=' . urlencode( $args['resources_active_search'] );
            $q_pos = true;
          }
          
          if ( !empty($args['resources_topic']) && is_string($args['resources_topic']) ) {
            $get_part .= ( ($q_pos !== false) ? '&' : '?' ) . 'sg_filter_topic=' . $args['resources_topic'];
            $q_pos = true;
          }
          
          if ( $args['resources_current_language'] ) {
            $get_part .= ( ($q_pos !== false) ? '&' : '?' ) . 'sg_filter_language=' . $args['resources_current_language'];
          }
          
          $subtype_link = $subtype_link . ( !empty($get_part) ? $get_part : '' );
        }
        
        $subtype_image_id = null;

          // Check if the Weglot plugin is active
          if ( function_exists('weglot_get_current_language') ) {
              $current_lang = weglot_get_current_language();
              $subtype_image_url = '';

              // Use a switch statement to get the correct image URL based on the current language
              switch ( $current_lang ) {
                  case 'fr':
                      // Try to get the French image URL
                      $subtype_image_url = get_term_meta( $subtype->term_id, 'type_featured_image_url_fr', true );
                      break;
                  case 'pt-br':
                      // Try to get the Portuguese image URL
                      $subtype_image_url = get_term_meta( $subtype->term_id, 'type_featured_image_url_pt', true );
                      break;
                  case 'es':
                      // Try to get the Spanish image URL
                      $subtype_image_url = get_term_meta( $subtype->term_id, 'type_featured_image_url_es', true );
                      break;
                  case 'en':
                  default:
                      // For English or any other language, we will get the default meta field later
                      break;
              }

              // Fallback: If the language-specific field is empty, use the default one.
              if ( empty( $subtype_image_url ) ) {
                  $subtype_image_url = get_term_meta( $subtype->term_id, 'type_featured_image_url', true );
              }

          } else {
              // If Weglot is not active, fall back to the default meta field
              $subtype_image_url = get_term_meta( $subtype->term_id, 'type_featured_image_url', true );
          }

        if ( $subtype_image_url ) {
          $subtype_image_id = attachment_url_to_postid( $subtype_image_url );
        }
        
        if ( !empty($subtype_image_id) ) {
          $thumbnail = wp_get_attachment_image(
            $subtype_image_id,
            'large',
            false,
            array('class' => 'sg-resource-item__thumbnail sg-resource-item__thumbnail--layout-' . $types_layout)
          );
        } else {
          $thumbnail = null;
        }
      ?>
        <div class="sg-resource-item sg-resource-item--layout-<?php echo $types_layout; ?>">
          <div class="sg-resource-item__inner sg-resource-item__inner--layout-<?php echo $types_layout; ?>">
            <div class="sg-resource-item__image sg-resource-item__image--layout-<?php echo $types_layout; ?>">
              <div class="sg-resource-item__image-wrap<?php if (empty($thumbnail)) { echo ' sg-resource-item__image-inner--empty'; } ?>">
                <div class="sg-resource-item__image-inner sg-resource-item__image-inner--layout-<?php echo $types_layout; ?><?php 
                  if ( empty($thumbnail) ) { echo ' sg-resource-item__image-inner--empty'; } 
                ?>">
                  <?php if ( !empty($thumbnail) ) : echo $thumbnail;
                  else : ?>
                    <img 
                      src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/hand-gloves-protective-icon.svg' ); ?>" 
                      class="sg-resource-item__thumbnail sg-resource-item__thumbnail--dummy sg-resource-item__thumbnail--layout-<?php 
                        echo $types_layout; 
                      ?>" 
                    />
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="sg-resource-item__content sg-resource-item__content--layout-<?php echo $types_layout; ?>">
              <div class="sg-resource-item__content-inner sg-resource-item__content-inner--layout-<?php echo $types_layout; ?>">
                <h3 class="sg-resource-item__title sg-resource-item__title--layout-<?php echo $types_layout; ?>"><?php 
                  echo esc_html( $subtype_title );
                ?></h3>
                <?php if ( !empty($subtype->description) ) : ?>
                  <div class="sg-resource-item__excerpt sg-resource-item__excerpt--layout-<?php echo $types_layout;?>">
                    <?php echo wp_filter_nohtml_kses($subtype->description); ?>
                  </div>
                <?php endif; ?>
                <div class="sg-resource-item__readmore sg-resource-item__readmore--layout-<?php echo $types_layout 
                . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore--has-arrow' : '') ; ?>">
                  <span class="sg-resource-item__readmore-content sg-resource-item__readmore-content--layout-<?php echo $types_layout 
                  . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore-content--has-arrow' : '') ; ?>">
                    <span class="sg-resource-item__readmore-text sg-resource-item__readmore-text--layout-<?php echo $types_layout 
                    . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore-text--has-arrow' : ''); ?>"><?php 
                      echo esc_html( $args['resources_post_link_text'] ); 
                    ?></span>  
                    <?php if ( !empty($args['resources_show_post_link_arrow']) ) : ?>
                      <span class="sg-resource-item__readmore-icon sg-resource-item__readmore-icon--layout-<?php echo $types_layout; ?>">
                        <svg width="100%" height="100%" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M13.2391 5.27029H0.625977V6.75579H13.2138L8.12598 12H10.1178L15.9392 5.99993L10.1178 0H8.12598L13.2391 5.27029Z" fill="currentColor" />
                        </svg>
                      </span>
                    <?php endif; ?>
                  </span>
                  <a 
                    href="<?php echo ( !empty($subtype_link) ? esc_url($subtype_link) : '#' ); ?>" 
                    class="sg-resource-item__readmore-link sg-resource-item__readmore-link--layout-<?php echo $types_layout; ?>"
                    <?php if ( !empty($subtype_link_target) ) { echo ' target="' . $subtype_link_target . '"'; } ?>
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  
  <?php if ( !empty($args['resources_top_types']) ) : ?>
    <div class="sg-resources-list sg-resources-list--toptypes sg-resources-list--layout-<?php echo $types_layout; ?> sg-resources-list--num-<?php 
    echo esc_attr( $args['resources_system_id'] ); ?>">
      <?php foreach ( $args['resources_top_types'] as $key => $top_type ) :
        $top_type_title = get_term_meta( $top_type->term_id, 'type_custom_title', true );
        
        if ( !$top_type_title ) {
          $top_type_title = $top_type->name;
        }
      
        $top_type_link = get_term_meta( $top_type->term_id, 'type_archive_url', true );
        
        if ( !$top_type_link ) {
          $top_type_link = get_term_link( $top_type );
          
          if ( is_wp_error($top_type_link) ) {
            $top_type_link = null;
          }
        }
         
        if ( !empty($top_type_link) ) {
          $top_type_link_host = parse_url($top_type_link, PHP_URL_HOST);
          $site_host = parse_url(get_site_url(), PHP_URL_HOST);
          
          $top_type_link_host = explode('.', $top_type_link_host);
          $site_host = explode('.', $site_host);
          
          $top_type_link_host = array_reverse($top_type_link_host);
          $site_host = array_reverse($site_host);
          
          $top_type_link_host = array_filter($top_type_link_host, function( $value ) {
            return ( $value != 'www' );
          });
          $site_host = array_filter($site_host, function( $value ) {
            return ( $value != 'www' );
          });
      
          $top_type_link_host = array_values($top_type_link_host);
          $site_host = array_values($site_host);
          
          foreach ( $site_host as $key => $host_part ) {
            if ( !isset($top_type_link_host[ $key ]) || $host_part != $top_type_link_host[ $key ] ) {
              $top_type_link_target = '_blank';
              break;
            }
          }
          
          $q_pos = strpos( $top_type_link, '?' );
          $get_part = '';
  
          if ( !empty($args['resources_active_search']) ) {
            $get_part .= ( ($q_pos !== false || $get_part != '') ? '&' : '?' ) . 'sg_filter_search=' . urlencode( $args['resources_active_search'] );
            $q_pos = true;
          }
          
          if ( !empty($args['resources_topic']) && is_string($args['resources_topic']) ) {
            $get_part .= ( ($q_pos !== false) ? '&' : '?' ) . 'sg_filter_topic=' . $args['resources_topic'];
            $q_pos = true;
          }
          
          if ( !empty($args['resources_current_language']) && is_string($args['resources_current_language']) ) {
            $get_part .= ( ($q_pos !== false) ? '&' : '?' ) . 'sg_filter_language=' . $args['resources_current_language'];
          }
          
          $top_type_link = $top_type_link . ( !empty($get_part) ? $get_part : '' );
        }
        
        $top_type_image_id = null;
          // Check if the Weglot plugin is active to determine the current language.
          if ( function_exists('weglot_get_current_language') ) {
              $current_lang = weglot_get_current_language();
              $top_type_image_url = '';

              // Use a switch statement to get the correct language-specific image URL.
              switch ( $current_lang ) {
                  case 'fr':
                      // Try to get the French image URL.
                      $top_type_image_url = get_term_meta( $top_type->term_id, 'type_featured_image_url_fr', true );
                      break;
                  case 'pt-br':
                      // Try to get the Portuguese image URL.
                      $top_type_image_url = get_term_meta( $top_type->term_id, 'type_featured_image_url_pt', true );
                      break;
                  case 'es':
                      // Try to get the Spanish image URL.
                      $top_type_image_url = get_term_meta( $top_type->term_id, 'type_featured_image_url_es', true );
                      break;
                  case 'en':
                  default:
                      // For English or any other language, we'll get the default URL in the next step.
                      break;
              }

              // Fallback: If the language-specific field is empty, use the default image URL.
              if ( empty( $top_type_image_url ) ) {
                  $top_type_image_url = get_term_meta( $top_type->term_id, 'type_featured_image_url', true );
              }

          } else {
              // If Weglot is not active, always use the default meta field.
              $top_type_image_url = get_term_meta( $top_type->term_id, 'type_featured_image_url', true );
          }
        
        if ( $top_type_image_url ) {
          $top_type_image_id = attachment_url_to_postid( $top_type_image_url );
        }
        
        if ( !empty($top_type_image_id) ) {
          $thumbnail = wp_get_attachment_image(
            $top_type_image_id,
            'large',
            false,
            array('class' => 'sg-resource-item__thumbnail sg-resource-item__thumbnail--layout-' . $types_layout)
          );
        } else {
          $thumbnail = null;
        }
      ?>
        <div class="sg-resource-item sg-resource-item--layout-<?php echo $types_layout; ?>">
          <div class="sg-resource-item__inner sg-resource-item__inner--layout-<?php echo $types_layout; ?>">
            <div class="sg-resource-item__image sg-resource-item__image--layout-<?php echo $types_layout; ?>">
              <div class="sg-resource-item__image-wrap<?php if (empty($thumbnail)) { echo ' sg-resource-item__image-inner--empty'; } ?>">
                <div class="sg-resource-item__image-inner sg-resource-item__image-inner--layout-<?php echo $types_layout; ?><?php 
                  if ( empty($thumbnail) ) { echo ' sg-resource-item__image-inner--empty'; } 
                ?>">
                  <?php if ( !empty($thumbnail) ) : echo $thumbnail;
                  else : ?>
                    <img 
                      src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/hand-gloves-protective-icon.svg' ); ?>" 
                      class="sg-resource-item__thumbnail sg-resource-item__thumbnail--dummy sg-resource-item__thumbnail--layout-<?php 
                        echo $types_layout; 
                      ?>" 
                    />
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="sg-resource-item__content sg-resource-item__content--layout-<?php echo $types_layout; ?>">
              <div class="sg-resource-item__content-inner sg-resource-item__content-inner--layout-<?php echo $types_layout; ?>">
                <h3 class="sg-resource-item__title sg-resource-item__title--layout-<?php echo $types_layout; ?>"><?php 
                  echo esc_html( $top_type_title );
                ?></h3>
                <?php if ( !empty($top_type->description) ) : ?>
                  <div class="sg-resource-item__excerpt sg-resource-item__excerpt--layout-<?php echo $types_layout;?>">
                    <?php echo wp_filter_nohtml_kses($top_type->description); ?>
                  </div>
                <?php endif; ?>
                <div class="sg-resource-item__readmore sg-resource-item__readmore--layout-<?php echo $types_layout 
                . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore--has-arrow' : '') ; ?>">
                  <span class="sg-resource-item__readmore-content sg-resource-item__readmore-content--layout-<?php echo $types_layout 
                  . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore-content--has-arrow' : '') ; ?>">
                    <span class="sg-resource-item__readmore-text sg-resource-item__readmore-text--layout-<?php echo $types_layout 
                    . ( ! empty($args['resources_show_post_link_arrow']) ? ' sg-resource-item__readmore-text--has-arrow' : ''); ?>"><?php 
                      echo esc_html( $args['resources_post_link_text'] ); 
                    ?></span>  
                    <?php if ( !empty($args['resources_show_post_link_arrow']) ) : ?>
                      <span class="sg-resource-item__readmore-icon sg-resource-item__readmore-icon--layout-<?php echo $types_layout; ?>">
                        <svg width="100%" height="100%" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M13.2391 5.27029H0.625977V6.75579H13.2138L8.12598 12H10.1178L15.9392 5.99993L10.1178 0H8.12598L13.2391 5.27029Z" fill="currentColor" />
                        </svg>
                      </span>
                    <?php endif; ?>
                  </span>
                  <a 
                    href="<?php echo ( !empty($top_type_link) ? esc_url($top_type_link) : '#' ); ?>" 
                    class="sg-resource-item__readmore-link sg-resource-item__readmore-link--layout-<?php echo $types_layout; ?>"
                    <?php if ( !empty($top_type_link_target) ) { echo ' target="' . $top_type_link_target . '"'; } ?>
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  
<?php else : ?>
  <div class="sg-resources-not-found sg-resources-not-found--layout-<?php echo $posts_layout; ?>">
    <p class="sg-resources-not-found__text sg-resources-not-found__text--layout-<?php echo $posts_layout; ?>"><?php 
      echo esc_html( $args['resources_not_found_text'] ); 
    ?></p>
  </div>
<?php endif; ?>