<?php

/**
 * @package Supglove
 */

function print_terms( $terms, $filter_id, $term_type, $active_term, $parent = 0, $ancestors = array(), $default_term = null ) {
  if ( !empty($terms) ) {
    foreach ( $terms as $key => $term ) {
      if ( $term->parent == $parent ) {
        if ( !empty($parent) && !in_array($parent, $ancestors) ) {
          $ancestors[] = $parent;
        } else {
          if ( empty($parent) ) {
            $ancestors = array();
          }
        }
        
        $term_name = '';
        $language_code = '';
        
        if ( $term_type == 'language' ) {
          $term_name = get_term_meta( $term->term_id, 'language_custom_title', true );
          $language_code = get_term_meta( $term->term_id, 'language_code', true );
        }
        
        if ( empty($term_name) ) {
          $term_name = $term->name;
        }
        
        // "' . esc_attr( $filter_id ) . '_sg_filter_' . $term_type . '[' . $key . ']"
        echo 
          '<div 
            class="sg-filter-form__input-wrapper sg-filter-form__input-wrapper--radio sg-filter-form__input-wrapper--dropdown ' . $term->slug . '-wrapper" 
            data-parent-id="' . esc_attr( $term->parent ) . '"' 
            . ( 
              !empty($ancestors) 
              ? ' data-parents="' . esc_attr(implode(',', $ancestors)) . '" data-level="' . count($ancestors) . '"' 
              : ' data-level="0"' 
            ) . '
          >
            <input 
              type="radio" 
              name="' . esc_attr( $filter_id ) . '_sg_filter_' . $term_type . '" 
              value="' . $term->slug . '" 
              id="' . esc_attr($filter_id) . '_sg_filter_' . $term_type 
                    . ( (!empty($default_term) && $default_term->slug == $term->slug) ? '_default' : '[' . $key . ']' ) . '"  
              class="sg-filter-form__radio sg-filter-form__radio--dropdown sg-filter-form__radio--' . $term_type . ' sg-filter-form__radio--level-' 
                . ( !empty($ancestors) ? count($ancestors) : '0' ) . '"' 
              . ( (!empty($active_term) && is_string($active_term) && ($term->slug == $active_term)) ? ' checked="checked"' : '' ) 
              . ( !empty($language_code) ? ' data-language_code="' . esc_attr($language_code) . '"' : '' )
              . ' 
            />
            <label 
              class="sg-filter-form__label sg-filter-form__label--radio sg-filter-form__label--' . $term_type . ' sg-filter-form__label--dropdown ' 
                . 'sg-filter-form__label--radio-level-' . ( !empty($ancestors) ? count($ancestors) : '0' ) 
              . '" 
              for="' . esc_attr( $filter_id ) . '_sg_filter_' . $term_type . '" 
              data-text="' . esc_attr( $term_name ) . '"
            >' . esc_html( $term_name ) . '</label>
          </div>';

          print_terms( $terms, $filter_id, $term_type, $active_term, $term->term_id, $ancestors, $default_term );
      }
    }
  }
}


function print_terms_nav( $terms, $filter_id, $term_type, $parent = 0, $ancestors = array(), $opn_drpdwn = false ) {
  if ( !empty($terms) ) {
    foreach ( $terms as $key => $term ) {
      if ( $term->parent == $parent ) {
        if ( !empty($parent) && !in_array($parent, $ancestors) ) {
          $ancestors[] = $parent;
        } else {
          if ( empty($parent) ) {
            $ancestors = array();
          }
        }
        
        $taxonomy = ( ($term_type == 'type' || $term_type == 'topic') ? 'sg_' . $term_type : $term_type );
        $term_children = get_term_children( $term->term_id, $taxonomy );
        $has_children_in_terms = false;
        
        if ( !is_wp_error($term_children) && !empty($term_children) ) {
          foreach ($terms as $key2 => $term2) {
            if ( in_array($term2->term_id, $term_children) ) {
              $has_children_in_terms = true;
              break;
            }
          }
        }
        
        $term_link = get_term_meta( $term->term_id, 'type_archive_url', true );
        $term_link_new_tab = false;
        
        if ( !$term_link ) {
          $term_link = get_term_link( $term );
          
          if ( is_wp_error($term_link) ) {
            $term_link = null;
          }
        }
        
        if ( !empty($term_link) ) {
          $term_link_host = parse_url($term_link, PHP_URL_HOST);
          $site_host = parse_url(get_site_url(), PHP_URL_HOST);
          
          $term_link_host = explode('.', $term_link_host);
          $site_host = explode('.', $site_host);
          
          $term_link_host = array_reverse($term_link_host);
          $site_host = array_reverse($site_host);
          
          $term_link_host = array_filter($term_link_host, function( $value ) {
            return ( $value != 'www' );
          });
          $site_host = array_filter($site_host, function( $value ) {
            return ( $value != 'www' );
          });
      
          $term_link_host = array_values($term_link_host);
          $site_host = array_values($site_host);
          
          foreach ( $site_host as $key => $host_part ) {
            if ( !isset($term_link_host[ $key ]) || $host_part != $term_link_host[ $key ] ) {
              $term_link_new_tab = true;
              break;
            }
          }
        }
        
        if ( empty($ancestors) ) {
          if ( $opn_drpdwn ) {
            echo 
              '</div></details>';
            $opn_drpdwn = false;
          }
          
          if ( $has_children_in_terms ) {
            echo 
              '<details class="sg-filter-form__nav-group">'
                . '<summary class="sg-filter-form__nav-group-heading">'
                  . '<span class="sg-filter-form__nav-group-heading-text">' . $term->name . '</span>'
                . '</summary>'
                . '<div class="sg-filter-form__nav-group-content">';
            $opn_drpdwn = true;
          } else {
            echo '<div class="sg-filter-form__nav-item">';
          }
        } else {
          echo '<div class="sg-filter-form__nav-group-item">';
        }
        
        echo 
          '<' . ( $term_link ? 'a href="' . esc_url($term_link) . '"' : 'span' ) 
            . ' class="sg-filter-form__nav-link sg-filter-form__nav-link--level-' . ( !empty($ancestors) ? count($ancestors) : '0' ) . '"' 
            . ( $term_link_new_tab ? ' target="_blank"' : '' ) 
          .'>' 
            . (
              (empty($ancestors) && $has_children_in_terms)
                ? sprintf( _x('All %s', '[sg_resources_filter_results]', 'SuperiorGlove'), $term->name )
                : $term->name
            ) 
          . '</' . ( $term_link ? 'a' : 'span' ) . '>';
          
        if ( !empty($ancestors) || (empty($ancestors) && !$has_children_in_terms) ) {
          echo '</div>';
        }
        
        print_terms_nav( $terms, $filter_id, $term_type, $term->term_id, $ancestors, $opn_drpdwn );
      }
    }
  }
}

if ( empty($args['filter_id']) ) {
  $args['filter_id'] = 'sg-resources-filter';
}

if ( empty($args['filter_class']) ) {
  $args['filter_class'] = '';
}

if ( empty($args['filter_search']) ) {
  $args['filter_active_search'] = '';
}

if ( empty($args['filter_active_topic']) ) {
  $args['filter_active_topic'] = '';
}

if ( empty($args['filter_active_language']) ) {
  $args['filter_active_language'] = '';
}
?>
<div class="sg-resources-filter<?php echo ( ($args['filter_class'] !== '') ? ' ' . esc_attr($args['filter_class']) : '' ); ?>">
  <div class="sg-resources-filter__inner">
    <form method="post" <?php echo 'id="' . esc_attr( $args['filter_id'] ) . '"'; ?> class="sg-filter-form" action="">
      <div class="sg-filter-form__all-fields-dropdown">
        <div class="sg-filter-form__filters-switcher"
          ><span class="sg-filter-form__filters-toggle"><?php 
            _ex('Show Filters', '[sg_resources_filter]', 'SuperiorGlove'); 
          ?></span
        ></div>
        <div class="sg-filter-form__filters">
          <div class="sg-filter-form__filters-inner">
            <?php if ( empty($args['filter_hide_search']) ) : ?>
              <fieldset class="sg-filter-form__fieldset sg-filter-form__fieldset--search">
                <div class="sg-filter-form__input-wrapper sg-filter-form__input-wrapper--search">
                  <input 
                    type="search" 
                    name="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_search" 
                    class="sg-filter-form__search" 
                    value="<?php echo esc_attr( $args['filter_search'] ); ?>" 
                    placeholder="<?php echo esc_attr( esc_html_x('Search Resources', '[sg_resources_filter]', 'SuperiorGlove') ); ?>" 
                  />
                  <label 
                    class="sg-filter-form__label sg-filter-form__label--search" 
                    for="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_search"
                  >
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5.87381 0.0167823C2.63482 0.0167823 0 2.6516 0 5.89059C0 9.12957 2.63482 11.7644 5.87381 11.7644C6.86396 11.7644 7.83734 11.5294 8.65967 11.0763C8.72554 11.1556 8.79857 11.2286 8.87784 11.2945L10.5561 12.9727C10.711 13.1471 10.9 13.2879 11.1114 13.3866C11.3227 13.4853 11.5521 13.5398 11.7852 13.5467C12.0184 13.5535 12.2505 13.5126 12.4673 13.4266C12.6841 13.3405 12.8811 13.211 13.046 13.046C13.211 12.8811 13.3405 12.6841 13.4266 12.4673C13.5126 12.2505 13.5535 12.0184 13.5466 11.7852C13.5398 11.5521 13.4853 11.3227 13.3866 11.1114C13.2879 10.9 13.1471 10.711 12.9727 10.5561L11.2945 8.87784C11.2127 8.79606 11.1228 8.72295 11.026 8.65967C11.4791 7.83734 11.7644 6.88075 11.7644 5.87381C11.7644 2.63482 9.12957 0 5.89059 0L5.87381 0.0167823ZM5.87381 1.69501C8.20655 1.69501 10.0694 3.55785 10.0694 5.89059C10.0694 6.99822 9.66661 8.02194 8.96175 8.77715C8.94497 8.79393 8.92819 8.81071 8.9114 8.82749C8.83214 8.89336 8.7591 8.9664 8.69323 9.04566C7.95481 9.71696 6.94787 10.1029 5.85702 10.1029C3.52428 10.1029 1.66145 8.24011 1.66145 5.90737C1.66145 3.57463 3.52428 1.7118 5.85702 1.7118L5.87381 1.69501Z" fill="#58585A" />
                    </svg>
                  </label>
                </div>
              </fieldset>
            <?php endif; ?>

            <?php if ( !empty($args['filter_topics']) ) : ?>
              <fieldset class="sg-filter-form__fieldset sg-filter-form__fieldset--dropdown sg-filter-form__fieldset--topic">
                <details class="sg-filter-form__dropdown sg-filter-form__dropdown--topic">
                  <summary class="sg-filter-form__dropdown-heading sg-filter-form__dropdown-heading--topic">
                    <legend class="sg-filter-form__legend sg-filter-form__legend--dropdown sg-filter-form__legend--topic"
                      ><span class="sg-filter-form__legend-text sg-filter-form__legend-text--dropdown sg-filter-form__legend-text--topic"><?php 
                        _ex('Topics', '[sg_resources_filter]', 'SuperiorGlove'); 
                      ?></span
                    ></legend>
                  </summary>
                  <div class="sg-filter-form__dropdown-content sg-filter-form__dropdown-content--topic">
                    <div 
                      class="sg-filter-form__input-wrapper sg-filter-form__input-wrapper--radio sg-filter-form__input-wrapper--dropdown topics-wrapper" 
                      data-parent-id="0"
                      data-level="0"
                    >
                      <input 
                        type="radio" 
                        name="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_topic" 
                        value="" 
                        id="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_topic_default" 
                        class="sg-filter-form__radio sg-filter-form__radio--dropdown sg-filter-form__radio--topic sg-filter-form__radio--level-0"
                      />
                      <label 
                        class="sg-filter-form__label sg-filter-form__label--radio sg-filter-form__label--topic sg-filter-form__label--dropdown sg-filter-form__label--radio-level-0" 
                        for="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_topic" 
                        data-text="<?php _ex('Topics', '[sg_resources_filter]', 'SuperiorGlove'); ?>"
                      ><?php 
                        _ex('See All Topics', '[sg_resources_filter]', 'SuperiorGlove'); 
                      ?></label>
                    </div>
                    <?php print_terms( $args['filter_topics'], $args['filter_id'], 'topic', $args['filter_active_topic'] ); ?>
                  </div>
                </details>
              </fieldset>
            <?php endif; ?>
            
            <?php if ( !empty($args['filter_languages']) && empty($args['filter_hide_languages']) ) : 
              $default_language_name = _x('Languages', '[sg_resources_filter]', 'SuperiorGlove');
              $default_language_code  = '';
              
              if ( !empty($args['filter_default_language']) ) {
                $default_language_term = get_term_by( 'slug', $args['filter_default_language'], 'sg_language' );
                
                if ( !empty($default_language_term) && !empty($default_language_term->term_id) ) {
                  $default_language_name = get_term_meta( $default_language_term->term_id, 'language_custom_title', true );
                  $default_language_code = get_term_meta( $default_language_term->term_id, 'language_code', true );
                  
                  if ( empty($default_language_name) ) {
                    $default_language_name = $default_language_term->name;
                  }
                }
              }
            ?>
              <fieldset class="sg-filter-form__fieldset sg-filter-form__fieldset--dropdown sg-filter-form__fieldset--language">
                <details class="sg-filter-form__dropdown sg-filter-form__dropdown--language">
                  <summary class="sg-filter-form__dropdown-heading sg-filter-form__dropdown-heading--language">
                    <legend class="sg-filter-form__legend sg-filter-form__legend--dropdown sg-filter-form__legend--language"
                      ><span class="sg-filter-form__legend-text sg-filter-form__legend-text--dropdown sg-filter-form__legend-text--language"><?php 
                        esc_html( $default_language_name ); 
                      ?></span
                    ></legend>
                  </summary>
                  <div class="sg-filter-form__dropdown-content sg-filter-form__dropdown-content--language">
                    <?php if ( empty($default_language_term) || empty($default_language_term->term_id) ) : ?>
                      <div 
                        class="sg-filter-form__input-wrapper sg-filter-form__input-wrapper--radio sg-filter-form__input-wrapper--dropdown languages-wrapper" 
                        data-parent-id="0"
                        data-level="0"
                      >
                        <input 
                          type="radio" 
                          name="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_language" 
                          value="" 
                          id="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_language_default" 
                          class="sg-filter-form__radio sg-filter-form__radio--dropdown sg-filter-form__radio--language sg-filter-form__radio--level-0"
                          data-language_code="<?php echo esc_attr( $default_language_code ); ?>"
                          <?php if ( empty($args['filter_active_language']) || ($args['filter_active_language'] == 'all') ) { echo ' checked'; } ?>
                        />
                        <label 
                          class="sg-filter-form__label sg-filter-form__label--radio sg-filter-form__label--language sg-filter-form__label--dropdown sg-filter-form__label--radio-level-0" 
                          for="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_language" 
                          data-text="<?php _ex('Languages', '[sg_resources_filter]', 'SuperiorGlove'); ?>"
                        ><?php 
                          _ex('All Languages', '[sg_resources_filter]', 'SuperiorGlove'); 
                        ?></label>
                      </div>
                    <?php endif; ?>
                    <?php print_terms( 
                      $args['filter_languages'], 
                      $args['filter_id'], 
                      'language', 
                      $args['filter_active_language'], 
                      0,
                      array(),
                      ( ( !empty($default_language_term) && !empty($default_language_term->term_id) ) ? $default_language_term : null ),
                    ); ?>
                  </div>
                </details>
              </fieldset>
            <?php endif; ?>

            <?php if ( !empty($args['filter_types']) && empty($args['filter_hide_types']) ) : ?>
              <fieldset class="sg-filter-form__fieldset sg-filter-form__fieldset--nav sg-filter-form__fieldset--type">
                <legend class="sg-filter-form__legend sg-filter-form__legend--nav sg-filter-form__legend--type"
                  ><span class="sg-filter-form__legend-text sg-filter-form__legend-text--nav sg-filter-form__legend-text--type"><?php 
                    _ex('Click to Navigate', '[sg_resources_filter]', 'SuperiorGlove'); 
                  ?></span
                ></legend>
                <div class="sg-filter-form__nav sg-filter-form__nav--type">
                  <?php print_terms_nav( $args['filter_types'], $args['filter_id'], 'type' ); ?>
                </div>
              </fieldset>
            <?php endif; ?>
            
            <?php if ( !empty($args['filter_nav_menu']) ) : ?>
              <fieldset class="sg-filter-form__fieldset sg-filter-form__fieldset--nav">
                <legend class="sg-filter-form__legend sg-filter-form__legend--nav"
                  ><span class="sg-filter-form__legend-text sg-filter-form__legend-text--nav"><?php 
                    _ex('Click to Navigate', '[sg_resources_filter]', 'SuperiorGlove'); 
                  ?></span
                ></legend>
                <?php wp_nav_menu( array(
                  'menu' => $args['filter_nav_menu'],
                  'menu_class' => 'sg-filter-form__menu',
                  'menu_id' => $args['filter_id'] . '__menu',
                  'container' => false,
                  'walker' => new SG_Sidebar_Menu_Walker(),
                  'fallback_cb' => false
                ) ); ?>
              </fieldset>
            <?php endif; ?>
            
            <div class="sg-filter-form__filters-submit">
              <button type="submit" class="sg-filter-form__button sg-filter-form__button--submit"
                ><span class="sg-filter-form__button-text sg-filter-form__button-text--submit"><?php 
                  _ex('Apply Filters', '[sg_resources_filter]', 'SuperiorGlove'); 
                ?></span
              ></button>
              <button type="reset" class="sg-filter-form__button sg-filter-form__button--reset"
                ><span class="sg-filter-form__button-text sg-filter-form__button-text--reset"><?php 
                  _ex('Reset Filters', '[sg_resources_filter]', 'SuperiorGlove'); 
                ?></span
              ></button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>