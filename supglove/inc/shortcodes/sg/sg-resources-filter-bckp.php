<?php

/**
 * @package Supglove
 */

function print_terms( $terms, $filter_id, $term_type, $active_term, $parent = 0, $ancestors = array() ) {
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
              id="' . esc_attr( $filter_id ) . '_sg_filter_' . $term_type . '[' . $key . ']" 
              class="sg-filter-form__radio sg-filter-form__radio--' . $term_type . ' sg-filter-form__radio--level-' 
                . ( !empty($ancestors) ? count($ancestors) : '0' ) . '"' 
              . ( (!empty($active_term) && is_array($active_term) && in_array($term->slug, $active_term)) ? ' checked="checked"' : '' ) 
              . ' 
            />
            <label 
              class="sg-filter-form__label sg-filter-form__label--radio sg-filter-form__label--dropdown sg-filter-form__label--radio-level-'
                . ( !empty($ancestors) ? count($ancestors) : '0' ) 
              . '" 
              for="' . esc_attr( $filter_id ) . '_sg_filter_' . $term_type . '"
            >' . $term->name . '</label>
          </div>';

          print_terms( $terms, $filter_id, $term_type, $active_term, $term->term_id, $ancestors );
      }
    }
  }
}

function print_terms_nav( $terms, $filter_id, $term_type, $parent = 0, $ancestors = array() ) {
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
              id="' . esc_attr( $filter_id ) . '_sg_filter_' . $term_type . '[' . $key . ']" 
              class="sg-filter-form__radio sg-filter-form__radio--' . $term_type . ' sg-filter-form__radio--level-' 
                . ( !empty($ancestors) ? count($ancestors) : '0' ) . '"' 
              . ' 
            />
            <label 
              class="sg-filter-form__label sg-filter-form__label--radio sg-filter-form__label--dropdown sg-filter-form__label--radio-level-'
                . ( !empty($ancestors) ? count($ancestors) : '0' ) 
              . '" 
              for="' . esc_attr( $filter_id ) . '_sg_filter_' . $term_type . '"
            >' . $term->name . '</label>
          </div>';

          print_terms( $terms, $filter_id, $term_type, $term->term_id, $ancestors );
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
  $args['filter_active_topics'] = array();
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
            <fieldset class="sg-filter-form__fieldset sg-filter-form__fieldset--search">
              <div class="sg-filter-form__input-wrapper sg-filter-form__input-wrapper--text">
                <input 
                  type="search" 
                  name="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_search" 
                  class="sg-filter-form__text" 
                  value="<?php echo esc_attr( $args['filter_search'] ); ?>" 
                  placeholder="<?php echo esc_attr( esc_html_x('Search Resources', '[sg_resources_filter]', 'SuperiorGlove') ); ?>" 
                />
                <label 
                  class="sg-filter-form__label sg-filter-form__label--text sg-filter-form__label--search" 
                  for="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_search"
                >
                  <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.87381 0.0167823C2.63482 0.0167823 0 2.6516 0 5.89059C0 9.12957 2.63482 11.7644 5.87381 11.7644C6.86396 11.7644 7.83734 11.5294 8.65967 11.0763C8.72554 11.1556 8.79857 11.2286 8.87784 11.2945L10.5561 12.9727C10.711 13.1471 10.9 13.2879 11.1114 13.3866C11.3227 13.4853 11.5521 13.5398 11.7852 13.5467C12.0184 13.5535 12.2505 13.5126 12.4673 13.4266C12.6841 13.3405 12.8811 13.211 13.046 13.046C13.211 12.8811 13.3405 12.6841 13.4266 12.4673C13.5126 12.2505 13.5535 12.0184 13.5466 11.7852C13.5398 11.5521 13.4853 11.3227 13.3866 11.1114C13.2879 10.9 13.1471 10.711 12.9727 10.5561L11.2945 8.87784C11.2127 8.79606 11.1228 8.72295 11.026 8.65967C11.4791 7.83734 11.7644 6.88075 11.7644 5.87381C11.7644 2.63482 9.12957 0 5.89059 0L5.87381 0.0167823ZM5.87381 1.69501C8.20655 1.69501 10.0694 3.55785 10.0694 5.89059C10.0694 6.99822 9.66661 8.02194 8.96175 8.77715C8.94497 8.79393 8.92819 8.81071 8.9114 8.82749C8.83214 8.89336 8.7591 8.9664 8.69323 9.04566C7.95481 9.71696 6.94787 10.1029 5.85702 10.1029C3.52428 10.1029 1.66145 8.24011 1.66145 5.90737C1.66145 3.57463 3.52428 1.7118 5.85702 1.7118L5.87381 1.69501Z" fill="#58585A" />
                  </svg>
                </label>
              </div>
            </fieldset>

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
                        class="sg-filter-form__radio sg-filter-form__radio--topic sg-filter-form__radio--level-0"
                      />
                      <label 
                        class="sg-filter-form__label sg-filter-form__label--radio sg-filter-form__label--dropdown sg-filter-form__label--radio-level-0" 
                        for="<?php echo esc_attr( $args['filter_id'] ); ?>_sg_filter_topic"
                      ><?php 
                        _ex('Clear Filter', '[sg_resources_filter]', 'SuperiorGlove'); 
                      ?></label>
                    </div>
                    <?php print_terms( $args['filter_topics'], $args['filter_id'], 'topic', $args['filter_active_topic'] ); ?>
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
            
            <div class="sg-filter-form__filters-submit">
              <button type="submit" class="sg-filter-form__button sg-filter-form__button--submit"
                ><span class="sg-filter-form__button-text sg-filter-form__button-text--submit"><?php 
                  _ex('Apply Filters', '[sg_resources_filter]', 'SuperiorGlove'); 
                ?></span
              ></button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>