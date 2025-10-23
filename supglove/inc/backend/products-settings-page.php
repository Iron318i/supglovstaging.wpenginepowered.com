<?php
/**
 * Product Settings Page (NATIVE WordPress Implementation)
 *
 * Создает страницу настроек с вкладками и нативным репитером
 * используя только WordPress Settings API и PHP/JS.
 */

// === 1. TABS: Определение вкладок ===
if ( ! function_exists( 'product_settings_get_tabs' ) ) {
    function product_settings_get_tabs() {
        return [
                'specifications' => 'Product Specifications',
                'hazard'         => 'Product Hazard Protections',
                'features'       => 'Product Features and Tech',
        ];
    }
}

// === 2. WC ATTRIBUTES: Получение всех атрибутов WooCommerce ===
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

// === 3. PAGE: Добавление страницы настроек ===
if ( ! function_exists( 'product_settings_add_options_page' ) ) {
    function product_settings_add_options_page() {
        add_submenu_page(
                'themes.php',           // Родительское меню (Внешний вид)
                'Product Settings',     // Заголовок страницы
                'Product Settings',     // Заголовок меню
                'manage_options',       // Права доступа
                'product_settings',     // Slug страницы
                'product_settings_content' // Функция, выводящая контент
        );
    }
    add_action( 'admin_menu', 'product_settings_add_options_page' );
}

// === 4. OUTPUT: Вывод контента страницы с табами ===
if ( ! function_exists( 'product_settings_content' ) ) {
    function product_settings_content() {
        $tabs = product_settings_get_tabs();
        $current_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'specifications';

        if ( ! array_key_exists( $current_tab, $tabs ) ) {
            $current_tab = 'specifications';
        }

        // Ключ для группы настроек и опции (должен соответствовать option_name)
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
                // Регистрирует скрытые поля nonce для сохранения
                settings_fields( $option_name );

                // Выводит секции и поля
                do_settings_sections( $option_name );

                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}

// === 5. SETTINGS API: Регистрация секций, полей и очистка данных ===
if ( ! function_exists( 'product_settings_register_sections' ) ) {
    function product_settings_register_sections() {
        $tabs = product_settings_get_tabs();

        foreach ( $tabs as $tab_id => $tab_name ) {
            $option_name = "product_settings_{$tab_id}"; // Уникальный slug группы настроек

            // 1. Регистрируем группу настроек и функцию для очистки данных
            register_setting(
                    $option_name,
                    $option_name,
                    'product_settings_sanitize_repeater'
            );

            // 2. Добавляем секцию
            add_settings_section(
                    $tab_id . '_section',         // ID секции
                    'Управление полями: ' . $tab_name, // Заголовок секции
                    '__return_false',             // Callback-функция для вывода секции
                    $option_name                  // Slug группы настроек
            );

            // 3. Добавляем поле (наш нативный репитер)
            add_settings_field(
                    $tab_id . '_repeater_field',  // ID поля
                    'Элементы',                   // Заголовок поля
                    'product_settings_repeater_callback', // Callback-функция для вывода репитера
                    $option_name,                 // Slug группы настроек
                    $tab_id . '_section',         // ID секции
                    [ 'option_name' => $option_name, 'tab_id' => $tab_id ] // Аргументы для callback
            );
        }
    }
    add_action( 'admin_init', 'product_settings_register_sections' );
}

// === 6. SANITIZE: Функция очистки данных репитера ===
if ( ! function_exists( 'product_settings_sanitize_repeater' ) ) {
    function product_settings_sanitize_repeater( $input ) {
        $sanitized_output = [];

        // Убедимся, что данные пришли в ожидаемом формате
        if ( ! is_array( $input ) || empty( $input['item_name'] ) ) {
            return $sanitized_output;
        }

        $names = array_map( 'sanitize_text_field', $input['item_name'] );
        $attributes = array_map( 'sanitize_key', $input['item_attribute'] );

        // Объединяем и очищаем данные, убирая пустые строки
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

// === 7. REPEATER OUTPUT: Callback-функция для вывода HTML репитера ===
if ( ! function_exists( 'product_settings_repeater_callback' ) ) {
    function product_settings_repeater_callback( $args ) {
        $option_name = $args['option_name'];
        $tab_id = $args['tab_id'];
        $items = get_option( $option_name, [] );
        $wc_attributes = get_wc_product_attributes();

        echo '<table class="form-table product-settings-repeater" data-option-name="' . esc_attr( $option_name ) . '">';
        echo '<thead><tr><th>Название</th><th>Атрибут WC</th><th></th></tr></thead>';
        echo '<tbody>';

        if ( ! empty( $items ) && is_array( $items ) ) {
            foreach ( $items as $index => $item ) {
                $item_name = isset( $item['item_name'] ) ? esc_attr( $item['item_name'] ) : '';
                $item_attr = isset( $item['item_attribute'] ) ? esc_attr( $item['item_attribute'] ) : '';

                echo '<tr class="product-setting-row">';
                echo '<td>';
                echo '<input type="text" name="' . esc_attr( $option_name ) . '[item_name][]" value="' . $item_name . '" class="regular-text" placeholder="e.g. Size Label" />';
                echo '</td>';
                echo '<td>';
                echo '<select name="' . esc_attr( $option_name ) . '[item_attribute][]">';
                echo '<option value="">Выберите атрибут...</option>';

                foreach ( $wc_attributes as $slug => $label ) {
                    $selected = selected( $item_attr, $slug, false );
                    echo '<option value="' . esc_attr( $slug ) . '" ' . $selected . '>' . esc_html( $label ) . '</option>';
                }

                echo '</select>';
                echo '</td>';
                echo '<td>';
                echo '<button type="button" class="button button-secondary remove-row">Удалить</button>';
                echo '</td>';
                echo '</tr>';
            }
        }

        // Пустая строка для шаблона
        echo '<tr class="product-setting-row template-row" style="display: none;">';
        echo '<td>';
        echo '<input type="text" name="' . esc_attr( $option_name ) . '[item_name][]" value="" class="regular-text" placeholder="e.g. Size Label" />';
        echo '</td>';
        echo '<td>';
        echo '<select name="' . esc_attr( $option_name ) . '[item_attribute][]">';
        echo '<option value="">Выберите атрибут...</option>';

        foreach ( $wc_attributes as $slug => $label ) {
            echo '<option value="' . esc_attr( $slug ) . '">' . esc_html( $label ) . '</option>';
        }

        echo '</select>';
        echo '</td>';
        echo '<td>';
        echo '<button type="button" class="button button-secondary remove-row">Удалить</button>';
        echo '</td>';
        echo '</tr>';

        echo '</tbody>';
        echo '</table>';
        echo '<button type="button" class="button button-primary add-new-row">Добавить элемент</button>';
    }
}

// === 8. JS: Подключение скриптов для репитера ===
if ( ! function_exists( 'product_settings_enqueue_scripts' ) ) {
    function product_settings_enqueue_scripts( $hook ) {
        // Подключаем только на нашей странице настроек
        if ( strpos( $hook, 'product_settings' ) === false ) {
            return;
        }

        // Подключаем jQuery (уже есть в админке WordPress)
        wp_enqueue_script( 'jquery' );

        // Мы не подключаем внешний файл, а встраиваем скрипт прямо в footer
        add_action( 'admin_footer', 'product_settings_inline_script' );
    }
    add_action( 'admin_enqueue_scripts', 'product_settings_enqueue_scripts' );
}

// === 9. JS: Встроенный скрипт для обработки репитера ===
if ( ! function_exists( 'product_settings_inline_script' ) ) {
    function product_settings_inline_script() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // 1. Добавление новой строки
                $('.add-new-row').on('click', function() {
                    var repeaterTable = $(this).prev('.product-settings-repeater');
                    var templateRow = repeaterTable.find('.template-row').clone();

                    templateRow.removeClass('template-row');
                    templateRow.show();
                    templateRow.insertBefore(repeaterTable.find('.template-row'));
                });

                // 2. Удаление строки
                $(document).on('click', '.remove-row', function() {
                    // Не удаляем последнюю строку, чтобы всегда была хотя бы одна
                    if ($(this).closest('tbody').find('.product-setting-row:not(.template-row)').length > 1) {
                        $(this).closest('.product-setting-row').remove();
                    } else {
                        alert('Должен остаться хотя бы один элемент');
                    }
                });
            });
        </script>

        <style type="text/css">
            .product-settings-repeater {
                width: 100%;
                margin-bottom: 15px;
            }
            .product-settings-repeater th,
            .product-settings-repeater td {
                padding: 8px 10px;
            }
            .product-settings-repeater input.regular-text {
                width: 100%;
            }
            .product-settings-repeater select {
                width: 100%;
            }
        </style>
        <?php
    }
}