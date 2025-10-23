<?php
/**
 * Product Settings Page (NATIVE WordPress Implementation)
 *
 * Creates settings page with tabs and native repeater
 * using only WordPress Settings API and PHP/JS.
 */

// === 1. TABS: Define tabs ===
if ( ! function_exists( 'product_settings_get_tabs' ) ) {
    function product_settings_get_tabs() {
        return [
                'specifications' => 'Product Specifications',
                'hazard'         => 'Product Hazard Protections',
                'features'       => 'Product Features and Tech',
        ];
    }
}

// === 2. WC ATTRIBUTES: Get all WooCommerce attributes ===
if ( ! function_exists( 'get_wc_product_attributes' ) ) {
    function get_wc_product_attributes() {
        if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
            return [];
        }
        $attributes = [];
        $taxonomies = wc_get_attribute_taxonomies();

        if ( $taxonomies ) {
            foreach ( $taxonomies as $tax ) {
                $taxonomy_name = 'pa_' . $tax->attribute_name;
                $attributes[ $taxonomy_name ] = $tax->attribute_label;
            }
        }
        return $attributes;
    }
}

// === 3. PAGE: Add settings page ===
if ( ! function_exists( 'product_settings_add_options_page' ) ) {
    function product_settings_add_options_page() {
        add_submenu_page(
                'themes.php',           // Parent menu (Appearance)
                'Product Settings',     // Page title
                'Product Settings',     // Menu title
                'manage_options',       // Capability
                'product_settings',     // Page slug
                'product_settings_content' // Content function
        );
    }
    add_action( 'admin_menu', 'product_settings_add_options_page' );
}

// === 4. OUTPUT: Display page content with tabs ===
if ( ! function_exists( 'product_settings_content' ) ) {
    function product_settings_content() {
        $tabs = product_settings_get_tabs();
        $current_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'specifications';

        if ( ! array_key_exists( $current_tab, $tabs ) ) {
            $current_tab = 'specifications';
        }

        // Key for settings group and option (must match option_name)
        $option_name = "product_settings_{$current_tab}";

        ?>
        <div class="wrap">
            <h1>Product Settings</h1>

            <h2 class="nav-tab-wrapper">
                <?php foreach ( $tabs as $tab_id => $tab_name ): ?>
                    <a href="?page=product_settings&tab=<?php echo esc_attr( $tab_id ); ?>"
                            class="nav-tab <?php echo $current_tab === $tab_id ? 'nav-tab-active' : ''; ?>">
                        <?php echo esc_html( $tab_name ); ?>
                    </a>
                <?php endforeach; ?>
            </h2>

            <form method="post" action="options.php">
                <?php
                // Register nonce hidden fields for saving
                settings_fields( $option_name );

                // Display sections and fields
                do_settings_sections( $option_name );

                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

// === 5. SETTINGS API: Register sections, fields and data sanitization ===
if ( ! function_exists( 'product_settings_register_sections' ) ) {
    function product_settings_register_sections() {
        $tabs = product_settings_get_tabs();

        foreach ( $tabs as $tab_id => $tab_name ) {
            $option_name = "product_settings_{$tab_id}"; // Unique settings group slug

            // 1. Register settings group and sanitization function
            register_setting(
                    $option_name,
                    $option_name,
                    'product_settings_sanitize_repeater'
            );

            // 2. Add section
            add_settings_section(
                    $tab_id . '_section',         // Section ID
                    'Field Management: ' . $tab_name, // Section title
                    '__return_false',             // Section display callback
                    $option_name                  // Settings group slug
            );

            // 3. Add field (our native repeater)
            add_settings_field(
                    $tab_id . '_repeater_field',  // Field ID
                    'Items',                      // Field title
                    'product_settings_repeater_callback', // Repeater display callback
                    $option_name,                 // Settings group slug
                    $tab_id . '_section',         // Section ID
                    [ 'option_name' => $option_name, 'tab_id' => $tab_id ] // Callback arguments
            );
        }
    }
    add_action( 'admin_init', 'product_settings_register_sections' );
}

// === 6. SANITIZE: Repeater data sanitization function ===
if ( ! function_exists( 'product_settings_sanitize_repeater' ) ) {
    function product_settings_sanitize_repeater( $input ) {
        $sanitized_output = [];

        // Ensure data comes in expected format
        if ( ! is_array( $input ) || empty( $input['item_name'] ) ) {
            return $sanitized_output;
        }

        $names = array_map( 'sanitize_text_field', $input['item_name'] );
        $attributes = array_map( 'sanitize_key', $input['item_attribute'] );

        // Combine and sanitize data, removing empty rows
        foreach ( $names as $key => $name ) {
            if ( ! empty( $name ) ) {
                $sanitized_output[] = [
                        'item_name'      => $name,
                        'item_attribute' => isset( $attributes[$key] ) ? $attributes[$key] : '',
                ];
            }
        }

        return $sanitized_output;
    }
}

// === 7. REPEATER OUTPUT: Callback function for repeater HTML display ===
if ( ! function_exists( 'product_settings_repeater_callback' ) ) {
    function product_settings_repeater_callback( $args ) {
        $option_name = $args['option_name'];
        $tab_id = $args['tab_id'];
        $items = get_option( $option_name, [] );
        $wc_attributes = get_wc_product_attributes();

        echo '<table class="form-table product-settings-repeater" data-option-name="' . esc_attr( $option_name ) . '">';
        echo '<thead><tr><th></th><th>Name</th><th>WC Attribute</th><th>Actions</th></tr></thead>';
        echo '<tbody class="sortable-table-body">';

        if ( ! empty( $items ) && is_array( $items ) ) {
            foreach ( $items as $index => $item ) {
                $item_name = isset( $item['item_name'] ) ? esc_attr( $item['item_name'] ) : '';
                $item_attr = isset( $item['item_attribute'] ) ? esc_attr( $item['item_attribute'] ) : '';

                echo '<tr class="product-setting-row sortable-row">';
                echo '<td class="drag-handle">';
                echo '<span class="dashicons dashicons-menu"></span>';
                echo '</td>';
                echo '<td>';
                echo '<input type="text" name="' . esc_attr( $option_name ) . '[item_name][]" value="' . $item_name . '" class="regular-text" placeholder="e.g. Size Label" />';
                echo '</td>';
                echo '<td>';
                echo '<select name="' . esc_attr( $option_name ) . '[item_attribute][]">';
                echo '<option value="">Select attribute...</option>';

                foreach ( $wc_attributes as $slug => $label ) {
                    $selected = selected( $item_attr, $slug, false );
                    echo '<option value="' . esc_attr( $slug ) . '" ' . $selected . '>' . esc_html( $label ) . '</option>';
                }

                echo '</select>';
                echo '</td>';
                echo '<td>';
                echo '<button type="button" class="button button-secondary remove-row">Remove</button>';
                echo '</td>';
                echo '</tr>';
            }
        }

        // Empty row for template
        echo '<tr class="product-setting-row template-row" style="display: none;">';
        echo '<td class="drag-handle">';
        echo '<span class="dashicons dashicons-menu"></span>';
        echo '</td>';
        echo '<td>';
        echo '<input type="text" name="' . esc_attr( $option_name ) . '[item_name][]" value="" class="regular-text" placeholder="e.g. Size Label" />';
        echo '</td>';
        echo '<td>';
        echo '<select name="' . esc_attr( $option_name ) . '[item_attribute][]">';
        echo '<option value="">Select attribute...</option>';

        foreach ( $wc_attributes as $slug => $label ) {
            echo '<option value="' . esc_attr( $slug ) . '">' . esc_html( $label ) . '</option>';
        }

        echo '</select>';
        echo '</td>';
        echo '<td>';
        echo '<button type="button" class="button button-secondary remove-row">Remove</button>';
        echo '</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        echo '<button type="button" class="button button-primary add-new-row">Add New Item</button>';

        // Display helper text
        echo '<p class="description">Add items that will be used in the ' . esc_html( $tab_id ) . ' section. Each item can be linked to a WooCommerce attribute. Drag and drop to reorder items.</p>';
    }
}

// === 8. JS: Enqueue scripts for repeater ===
if ( ! function_exists( 'product_settings_enqueue_scripts' ) ) {
    function product_settings_enqueue_scripts( $hook ) {
        // Load only on our settings page
        if ( strpos( $hook, 'product_settings' ) === false ) {
            return;
        }

        // Enqueue jQuery and jQuery UI Sortable
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-sortable' );

        // We don't load external file, but embed script directly in footer
        add_action( 'admin_footer', 'product_settings_inline_script' );
    }
    add_action( 'admin_enqueue_scripts', 'product_settings_enqueue_scripts' );
}

// === 9. JS: Inline script for repeater handling ===
if ( ! function_exists( 'product_settings_inline_script' ) ) {
    function product_settings_inline_script() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // 1. Add new row
                $('.add-new-row').on('click', function() {
                    var repeaterTable = $(this).prev('.product-settings-repeater');
                    var templateRow = repeaterTable.find('.template-row').clone();

                    templateRow.removeClass('template-row');
                    templateRow.addClass('sortable-row');
                    templateRow.show();
                    templateRow.insertBefore(repeaterTable.find('.template-row'));
                });

                // 2. Remove row
                $(document).on('click', '.remove-row', function() {
                    // Don't remove the last row, always keep at least one
                    if ($(this).closest('tbody').find('.product-setting-row:not(.template-row)').length > 1) {
                        $(this).closest('.product-setting-row').remove();
                    } else {
                        alert('At least one item must remain');
                    }
                });

                // 3. Initialize sortable functionality
                $('.sortable-table-body').sortable({
                    handle: '.drag-handle',
                    axis: 'y',
                    placeholder: 'sortable-placeholder',
                    forcePlaceholderSize: true,
                    opacity: 0.7,
                    tolerance: 'pointer',
                    start: function(e, ui) {
                        ui.placeholder.height(ui.item.height());
                        ui.placeholder.css('visibility', 'visible');
                    },
                    update: function(event, ui) {
                        // Optional: Add any logic to run after reordering
                        console.log('Items reordered');
                    }
                });

                // 4. Disable text selection on drag handle for better UX
                $('.drag-handle').css({
                    'user-select': 'none',
                    '-webkit-user-select': 'none',
                    '-moz-user-select': 'none',
                    '-ms-user-select': 'none'
                });
            });
        </script>

        <style type="text/css">
            .product-settings-repeater {
                width: 100%;
                margin-bottom: 15px;
                border-collapse: collapse;
            }
            .product-settings-repeater th,
            .product-settings-repeater td {
                padding: 8px 10px;
                border: 1px solid #ccd0d4;
                vertical-align: middle;
            }
            .product-settings-repeater th {
                background: #f8f9fa;
                font-weight: 600;
            }
            .product-settings-repeater th:first-child {
                width: 30px;
            }
            .product-settings-repeater th:last-child {
                width: 100px;
            }
            .product-settings-repeater input.regular-text {
                width: 100%;
            }
            .product-settings-repeater select {
                width: 100%;
            }
            .add-new-row {
                margin-top: 10px;
            }

            /* Drag handle styles */
            .drag-handle {
                text-align: center;
                cursor: move;
                width: 30px;
            }
            .drag-handle .dashicons {
                color: #72777c;
                font-size: 16px;
            }
            .drag-handle:hover .dashicons {
                color: #0073aa;
            }

            /* Sortable styles */
            .sortable-row {
                cursor: move;
            }
            .sortable-placeholder {
                background: #f0f0f1;
                border: 2px dashed #c3c4c7;
                height: 50px;
            }
            .sortable-table-body tr.ui-sortable-helper {
                background: #fff;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            /* Improve row appearance during drag */
            .ui-sortable-helper {
                display: table;
            }
        </style>
        <?php
    }
}