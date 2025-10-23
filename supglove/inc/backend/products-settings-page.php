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
                    [ 'option_name' => $option_name ] // Аргументы для callback
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
        $items = get_option( $option_name, [] );
        $wc_attributes = get_wc_product_attributes();

        // Шаблон строки репитера
        $row_template = '
            <tr class="product-setting-row">
                <td>
                    <input type="text" name="' . esc_attr( $option_name ) . '[item_name][]" 
                           value="%1$s" class="regular-text" placeholder="e.g. Size Label" />
                </td>
                <td>
                    <select name="' . esc_attr( $option_name ) . '[item_attribute][]">
                        <option value="">Выберите атрибут...</option>
                        %2$s
                    </select>
                </td>
                <td>
                    <button type="button" class="button button-secondary remove-row">Удалить</button>
                </td>
            </tr>
        ';

        // Создание опций для SELECT
        $select_options = '';
        foreach ( $wc_attributes as $slug => $label ) {
            $select_options .= '<option value="' . esc_attr( $slug ) . '">%s' . esc_html( $label ) . '</option>';
        }

        echo '<table class="form-table product-settings-repeater" data-option-name="' . esc_attr( $option_name ) . '">';
        echo '<thead><tr><th>Название</th><th>Атрибут WC</th><th></th></tr></thead>';
        echo '<tbody>';

        if ( ! empty( $items ) && is_array( $items ) ) {
            foreach ( $items as $item ) {
                $item_name = isset( $item['item_name'] ) ? esc_attr( $item['item_name'] ) : '';
                $item_attr = isset( $item['item_attribute'] ) ? esc_attr( $item['item_attribute'] ) : '';

                // Вывод сохраненной строки
                $current_options = str_replace(
                        sprintf( '<option value="%s">', $item_attr ),
                        sprintf( '<option value="%s" selected="selected">', $item_attr ),
                        $select_options
                );

                printf( $row_template, $item_name, $current_options );
            }
        }

        echo '</tbody>';
        echo '</table>';
        echo '<button type="button" class="button button-primary add-new-row" data-template="' . esc_attr( urlencode( $row_template ) ) . '">Добавить элемент</button>';
    }
}

// === 8. JS: Подключение скриптов для репитера ===
if ( ! function_exists( 'product_settings_enqueue_scripts' ) ) {
    function product_settings_enqueue_scripts( $hook ) {
        // Подключаем только на нашей странице настроек
        if ( strpos( $hook, 'product_settings' ) === false ) {
            return;
        }

        // Мы не подключаем внешний файл, а встраиваем скрипт прямо в footer
        add_action( 'admin_footer', 'product_settings_inline_script' );
    }
    add_action( 'admin_enqueue_scripts', 'product_settings_enqueue_scripts' );
}

// === 9. JS: Встроенный скрипт для обработки репитера ===
if ( ! function_exists( 'product_settings_inline_script' ) ) {
    function product_settings_inline_script() {
        // Создание опций для SELECT
        $wc_attributes = get_wc_product_attributes();
        $select_options_html = '<option value="">Выберите атрибут...</option>';
        foreach ( $wc_attributes as $slug => $label ) {
            $select_options_html .= '<option value="' . esc_attr( $slug ) . '">' . esc_html( $label ) . '</option>';
        }

        // PHP-переменные для использования в JS
        $js_vars = [
                'select_options_html' => $select_options_html,
                'row_template_html'   => '
                <tr class="product-setting-row">
                    <td>
                        <input type="text" name="__NAME__[item_name][]" value="" class="regular-text" placeholder="e.g. Size Label" />
                    </td>
                    <td>
                        <select name="__NAME__[item_attribute][]">__OPTIONS__</select>
                    </td>
                    <td>
                        <button type="button" class="button button-secondary remove-row">Удалить</button>
                    </td>
                </tr>
            ',
        ];
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var repeaterData = <?php echo wp_json_encode( $js_vars ); ?>;

                // 1. Добавление новой строки
                $('.add-new-row').on('click', function() {
                    var repeaterTable = $(this).prev('.product-settings-repeater');
                    var optionName = repeaterTable.data('option-name');

                    var newRowHtml = repeaterData.row_template_html
                        .replace(/__NAME__/g, optionName)
                        .replace(/__OPTIONS__/g, repeaterData.select_options_html);

                    repeaterTable.find('tbody').append(newRowHtml);
                });

                // 2. Удаление строки
                $(document).on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                });
            });
        </script>
        <?php
    }
}