<?php
/**
 * Supro theme customizer
 *
 * @package Supglove
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Supro_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {

		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][$name] ) ) {
			return false;
		}

		return isset( $this->config['fields'][$name]['default'] ) ? $this->config['fields'][$name]['default'] : false;
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function supro_get_option( $name ) {
	global $supro_customize;

	if ( empty( $supro_customize ) ) {
		return false;
	}

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( $supro_customize->get_theme(), $name );
	} else {
		$value = $supro_customize->get_option( $name );
	}

	return apply_filters( 'supro_get_option', $value, $name );
}

/**
 * Get default option values
 *
 * @param $name
 *
 * @return mixed
 */
function supro_get_option_default( $name ) {
	global $supro_customize;

	if ( empty( $supro_customize ) ) {
		return false;
	}

	return $supro_customize->get_option_default( $name );
}

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function supro_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'supro_customize_modify' );


/**
 * Get product attributes
 *
 * @return string
 */
function supro_product_attributes() {
	$output = array();
	if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
		$attributes_tax = wc_get_attribute_taxonomies();
		if ( $attributes_tax ) {
			$output['none'] = esc_html__( 'None', 'supro' );

			foreach ( $attributes_tax as $attribute ) {
				$output[$attribute->attribute_name] = $attribute->attribute_label;
			}
		}
	}

	return $output;
}

function supro_customize_settings() {
	/**
	 * Customizer configuration
	 */

	$settings = array(
		'theme' => 'supro',
	);

	$panels = array(
		'general'    => array(
			'priority' => 5,
			'title'    => esc_html__( 'General', 'supro' ),
		),
		'header'     => array(
			'priority' => 10,
			'title'    => esc_html__( 'Header', 'supro' ),
		),
		'page'       => array(
			'title'      => esc_html__( 'Page', 'supro' ),
			'priority'   => 10,
			'capability' => 'edit_theme_options',
		),
		'blog'       => array(
			'title'      => esc_html__( 'Blog', 'supro' ),
			'priority'   => 10,
			'capability' => 'edit_theme_options',
		),
		'footer'     => array(
			'title'    => esc_html__( 'Footer', 'supro' ),
			'priority' => 50,
		),
		'mobile'     => array(
			'title'      => esc_html__( 'Mobile', 'supro' ),
			'priority'   => 50,
			'capability' => 'edit_theme_options',
		),
	);

	$sections = array(
		'maintenance'            => array(
			'title'      => esc_html__( 'Maintenance', 'supro' ),
			'priority'   => 5,
			'capability' => 'edit_theme_options',
		),
		
		
		
		
		

		
		
		
		
		
		'topbar'                 => array(
			'title'       => esc_html__( 'Topbar', 'supro' ),
			'description' => '',
			'priority'    => 5,
			'capability'  => 'edit_theme_options',
			'panel'       => 'header',
		),
		'header'                 => array(
			'title'       => esc_html__( 'Header', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'header',
		),


		'page_header'            => array(
			'title'       => esc_html__( 'Page Header', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'page',
		),
		'search_page'            => array(
			'title'       => esc_html__( 'Search Page', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'page',
		),
		'blog_page_header'       => array(
			'title'       => esc_html__( 'Blog Page Header', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
		'blog_page'              => array(
			'title'       => esc_html__( 'Blog Page', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
		'single_post'            => array(
			'title'       => esc_html__( 'Single Post', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'blog',
		),
		'catalog_notification'   => array(
			'title'       => esc_html__( 'Catalog Notification', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'panel'       => 'woocommerce',
			'capability'  => 'edit_theme_options',
		),
		'shop'                   => array(
			'title'       => esc_html__( 'Shop', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'panel'       => 'woocommerce',
			'capability'  => 'edit_theme_options',
		),
		'shop_badge'             => array(
			'title'       => esc_html__( 'Badges', 'supro' ),
			'description' => '',
			'priority'    => 40,
			'panel'       => 'woocommerce',
			'capability'  => 'edit_theme_options',
		),
		'catalog_page_header'    => array(
			'title'       => esc_html__( 'Catalog Page Header', 'supro' ),
			'description' => '',
			'priority'    => 40,
			'panel'       => 'woocommerce',
			'capability'  => 'edit_theme_options',
		),
		'single_product'         => array(
			'title'       => esc_html__( 'Single Product', 'supro' ),
			'description' => '',
			'priority'    => 90,
			'panel'       => 'woocommerce',
			'capability'  => 'edit_theme_options',
		),
		
		'single_product_CTA_extra'         => array(
			'title'       => esc_html__( 'Single Product CTA', 'supro' ),
			'description' => '',
			'priority'    => 90,
			'panel'       => 'woocommerce',
			'capability'  => 'edit_theme_options',
		),
		
		'footer_newsletter'      => array(
			'title'       => esc_html__( 'Footer Newsletter', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_layout'          => array(
			'title'       => esc_html__( 'Footer Layout', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_widgets'         => array(
			'title'       => esc_html__( 'Footer Widgets', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_copyright'       => array(
			'title'       => esc_html__( 'Footer Copyright', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'footer_recently_viewed' => array(
			'title'       => esc_html__( 'Footer Recently Viewed', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'footer',
		),
		'menu_mobile'            => array(
			'title'       => esc_html__( 'Menu Sidebar', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'mobile',
		),
		'catalog_mobile'         => array(
			'title'       => esc_html__( 'Catalog Mobile', 'supro' ),
			'description' => '',
			'priority'    => 10,
			'capability'  => 'edit_theme_options',
			'panel'       => 'mobile',
		),
	);

	$fields = array(
		// Maintenance
		'maintenance_enable'                               => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Enable Maintenance Mode', 'supro' ),
			'description' => esc_html__( 'Put your site into maintenance mode', 'supro' ),
			'default'     => false,
			'section'     => 'maintenance',
		),
		'maintenance_mode'                                 => array(
			'type'        => 'radio',
			'label'       => esc_html__( 'Mode', 'supro' ),
			'description' => esc_html__( 'Select the correct mode for your site', 'supro' ),
			'tooltip'     => wp_kses_post( sprintf( __( 'If you are putting your site into maintenance mode for a longer perior of time, you should set this to "Coming Soon". Maintenance will return HTTP 503, Comming Soon will set HTTP to 200. <a href="%s" target="_blank">Learn more</a>', 'supro' ), 'https://yoast.com/http-503-site-maintenance-seo/' ) ),
			'default'     => 'maintenance',
			'section'     => 'maintenance',
			'choices'     => array(
				'maintenance' => esc_attr__( 'Maintenance', 'supro' ),
				'coming_soon' => esc_attr__( 'Coming Soon', 'supro' ),
			),
		),
		'maintenance_page'                                 => array(
			'type'    => 'dropdown-pages',
			'label'   => esc_html__( 'Maintenance Page', 'supro' ),
			'default' => 0,
			'section' => 'maintenance',
		),
		'maintenance_textcolor'                            => array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Text Color', 'supro' ),
			'default' => 'dark',
			'section' => 'maintenance',
			'choices' => array(
				'dark'  => esc_attr__( 'Dark', 'supro' ),
				'light' => esc_attr__( 'Light', 'supro' ),
			),
		),


		// Topbar
		'topbar_enable'                                    => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show topbar', 'supro' ),
			'section'  => 'topbar',
			'default'  => 1,
			'priority' => 10,
		),
		'topbar_border_bottom'                             => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show border bottom', 'supro' ),
			'section'  => 'topbar',
			'default'  => 0,
			'priority' => 10,
		),
		'topbar_background_color'                          => array(
			'type'     => 'color',
			'label'    => esc_html__( 'Background Color', 'supro' ),
			'default'  => '',
			'section'  => 'topbar',
			'priority' => 10,
		),
		'topbar_color'                                     => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Color', 'supro' ),
			'section'  => 'topbar',
			'default'  => 'default',
			'priority' => 10,
			'choices'  => array(
				'default' => esc_html__( 'Default', 'supro' ),
				'custom'  => esc_html__( 'Custom', 'supro' ),
			),
		),
		'topbar_custom_color'                              => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Custom Color', 'supro' ),
			'default'         => '',
			'section'         => 'topbar',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'topbar_color',
					'operator' => '==',
					'value'    => 'custom',
				),
			),
		),
		'topbar_custom_field_1'                            => array(
			'type'    => 'custom',
			'section' => 'topbar',
			'default' => '<hr/>',
		),

		'topbar_mobile_content'                            => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Topbar Mobile justify content', 'supro' ),
			'section'  => 'topbar',
			'default'  => 'flex-start',
			'priority' => 10,
			'choices'  => array(
				'flex-start'    => esc_html__( 'Flex Start', 'supro' ),
				'flex-end'      => esc_html__( 'Flex End', 'supro' ),
				'center'        => esc_html__( 'Center', 'supro' ),
				'space-between' => esc_html__( 'Space Between', 'supro' ),
			),
		),
		
		
		'topbar_orange_text'                                 => array(
			'type'     => 'text',
			'label'    => esc_html__( 'Orange Top Bar Text CTA', 'supro' ),
			'section'  => 'topbar',
			'default'  => '',
			'priority' => 10,
		),
		
		

		// Header layout

		'header_sticky'                                    => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Header Sticky', 'supro' ),
			'default'  => 1,
			'section'  => 'header',
			'priority' => 10,
		),



		
		

		'menu_extras'                                      => array(
			'type'     => 'multicheck',
			'label'    => esc_html__( 'Menu Extras', 'supro' ),
			'section'  => 'header',
			'default'  => array( 'search', 'account', 'wishlist', 'cart' ),
			'priority' => 10,
			'choices'  => array(
				'search'   => esc_html__( 'Search', 'supro' ),
				'account'  => esc_html__( 'Account', 'supro' ),
				'cart'     => esc_html__( 'Cart', 'supro' ),
				'sidebar'  => esc_html__( 'Sidebar', 'supro' ),
			),
		),
		'header_menu_text'                                 => array(
			'type'     => 'text',
			'label'    => esc_html__( 'Menu Text', 'supro' ),
			'section'  => 'header',
			'default'  => '',
			'priority' => 10,
		),
		
		
		'header_menu_text'                                 => array(
			'type'     => 'text',
			'label'    => esc_html__( 'Menu Text', 'supro' ),
			'section'  => 'header',
			'default'  => '',
			'priority' => 10,
		),

		'header_custom_field_1'                            => array(
			'type'    => 'custom',
			'section' => 'header',
			'default' => '<hr/>',
		),
		'menu_animation'                                   => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Menu Hover Animation', 'supro' ),
			'section'  => 'header',
			'default'  => 'fade',
			'priority' => 30,
			'choices'  => array(
				'none'  => esc_html__( 'No Animation', 'supro' ),
				'fade'  => esc_html__( 'Fade', 'supro' ),
				'slide' => esc_html__( 'Slide', 'supro' ),
			),
		),
		'header_ajax_search'                               => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'AJAX Search', 'supro' ),
			'section'     => 'header',
			'default'     => 1,
			'priority'    => 90,
			'description' => esc_html__( 'Check this option to enable AJAX search in the header', 'supro' ),
		),
		'search_content_type'                              => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Search Content Type', 'supro' ),
			'section'  => 'header',
			'default'  => 'all',
			'priority' => 90,
			'choices'  => array(
				'all'      => esc_html__( 'All', 'supro' ),
				'products' => esc_html__( 'Only products', 'supro' ),
			),
		),

		// Blog Layout
		'blog_style'                                       => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Blog Style', 'supro' ),
			'section'  => 'blog_page',
			'default'  => 'list',
			'priority' => 10,
			'choices'  => array(
				'grid'    => esc_html__( 'Grid', 'supro' ),
				'list'    => esc_html__( 'List', 'supro' ),
				'masonry' => esc_html__( 'Masonry', 'supro' ),
			),
		),
		'blog_layout'                                      => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Blog Grid Layout', 'supro' ),
			'section'         => 'blog_page',
			'default'         => 'content-sidebar',
			'priority'        => 10,
			'description'     => esc_html__( 'Select default sidebar for blog classic.', 'supro' ),
			'choices'         => array(
				'content-sidebar' => esc_html__( 'Right Sidebar', 'supro' ),
				'sidebar-content' => esc_html__( 'Left Sidebar', 'supro' ),
				'full-content'    => esc_html__( 'Full Content', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'blog_style',
					'operator' => '==',
					'value'    => 'grid',
				),
			),
		),
		'blog_entry_meta'                                  => array(
			'type'     => 'multicheck',
			'label'    => esc_html__( 'Entry Metas', 'supro' ),
			'section'  => 'blog_page',
			'default'  => array( 'cat', 'date' ),
			'choices'  => array(
				'cat'  => esc_html__( 'Category', 'supro' ),
				'date' => esc_html__( 'Date', 'supro' ),
			),
			'priority' => 10,
		),
		'excerpt_length'                                   => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Excerpt Length', 'supro' ),
			'section'         => 'blog_page',
			'default'         => '20',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'blog_style',
					'operator' => '==',
					'value'    => 'list',
				),
			),
		),
		'blog_custom_field_1'                              => array(
			'type'    => 'custom',
			'section' => 'blog_page',
			'default' => '<hr/>',
		),
		'blog_cat_filter'                                  => array(
			'type'     => 'toggle',
			'default'  => 0,
			'label'    => esc_html__( 'Categories Filter', 'supro' ),
			'section'  => 'blog_page',
			'priority' => 10,
		),
		'blog_categories_numbers'                          => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Categories Numbers', 'supro' ),
			'section'         => 'blog_page',
			'default'         => '5',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'blog_cat_filter',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'blog_categories'                                  => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Custom Categories', 'supro' ),
			'section'         => 'blog_page',
			'default'         => '',
			'priority'        => 10,
			'description'     => esc_html__( 'Enter categories slug you want to display. Each slug is separated by comma character ",". If empty, it will display default', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'blog_cat_filter',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		// Page Header of Page
		'page_header'                                      => array(
			'type'        => 'toggle',
			'default'     => 1,
			'label'       => esc_html__( 'Enable Page Header', 'supro' ),
			'section'     => 'page_header',
			'description' => esc_html__( 'Enable to show a page header for page below the site header', 'supro' ),
			'priority'    => 10,
		),
		'page_header_breadcrumbs'                          => array(
			'type'            => 'toggle',
			'default'         => 1,
			'label'           => esc_html__( 'Enable Breadcrumbs', 'supro' ),
			'section'         => 'page_header',
			'description'     => esc_html__( 'Enable to show a breadcrumbs for page below the site header', 'supro' ),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'page_header_parallax'                             => array(
			'type'            => 'toggle',
			'label'           => esc_html__( 'Enable Parallax', 'supro' ),
			'section'         => 'page_header',
			'default'         => 1,
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'page_header_text_color'                           => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Page Header Text Color', 'supro' ),
			'section'         => 'page_header',
			'default'         => 'dark',
			'choices'         => array(
				'dark'  => esc_html__( 'Dark', 'supro' ),
				'light' => esc_html__( 'Light', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'page_header_custom_field_1'                       => array(
			'type'    => 'custom',
			'section' => 'page_header',
			'default' => '<hr/>',
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => 1,
			),
		),
		// Page Header Background
		'page_header_device'                               => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Device', 'supro' ),
			'section'         => 'page_header',
			'default'         => 'desktop',
			'choices'         => array(
				'desktop' => esc_html__( 'Desktop', 'supro' ),
				'tablet'  => esc_html__( 'Tablet', 'supro' ),
				'mobile'  => esc_html__( 'Mobile', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		/*======Desktop======*/
		'page_header_background'                           => array(
			'type'            => 'image',
			'label'           => esc_html__( 'Background Image', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'desktop',
				),
			),
		),
		'page_header_background_position'                  => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Position', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''              => esc_html__( 'Default', 'supro' ),
				'top left'      => esc_html__( 'Top Left', 'supro' ),
				'top center'    => esc_html__( 'Top Center', 'supro' ),
				'top right'     => esc_html__( 'Top Right', 'supro' ),
				'center left'   => esc_html__( 'Center Left', 'supro' ),
				'center center' => esc_html__( 'Center Center', 'supro' ),
				'center right'  => esc_html__( 'Center Right', 'supro' ),
				'bottom left'   => esc_html__( 'Bottom Left', 'supro' ),
				'bottom center' => esc_html__( 'Bottom Center', 'supro' ),
				'bottom right'  => esc_html__( 'Bottom Right', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'desktop',
				),
			),
		),
		'page_header_background_repeat'                    => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Repeat', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''          => esc_html__( 'Default', 'supro' ),
				'no-repeat' => esc_html__( 'No Repeat', 'supro' ),
				'repeat'    => esc_html__( 'Repeat', 'supro' ),
				'repeat-x'  => esc_html__( 'Repeat-x', 'supro' ),
				'repeat-y'  => esc_html__( 'Repeat-y', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'desktop',
				),
			),
		),
		'page_header_background_size'                      => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Size', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''        => esc_html__( 'Default', 'supro' ),
				'auto'    => esc_html__( 'Auto', 'supro' ),
				'cover'   => esc_html__( 'Cover', 'supro' ),
				'contain' => esc_html__( 'Contain', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'desktop',
				),
			),
		),
		'page_header_background_attachment'                => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Attachment', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''       => esc_html__( 'Default', 'supro' ),
				'scroll' => esc_html__( 'Scroll', 'supro' ),
				'fixed'  => esc_html__( 'Fixed', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'desktop',
				),
			),
		),
		/*======Tablet======*/
		'page_header_background_tablet'                    => array(
			'type'            => 'image',
			'label'           => esc_html__( 'Background Image', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'tablet',
				),
			),
		),
		'page_header_background_position_tablet'           => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Position', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''              => esc_html__( 'Default', 'supro' ),
				'top left'      => esc_html__( 'Top Left', 'supro' ),
				'top center'    => esc_html__( 'Top Center', 'supro' ),
				'top right'     => esc_html__( 'Top Right', 'supro' ),
				'center left'   => esc_html__( 'Center Left', 'supro' ),
				'center center' => esc_html__( 'Center Center', 'supro' ),
				'center right'  => esc_html__( 'Center Right', 'supro' ),
				'bottom left'   => esc_html__( 'Bottom Left', 'supro' ),
				'bottom center' => esc_html__( 'Bottom Center', 'supro' ),
				'bottom right'  => esc_html__( 'Bottom Right', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'tablet',
				),
			),
		),
		'page_header_background_repeat_tablet'             => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Repeat', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''          => esc_html__( 'Default', 'supro' ),
				'no-repeat' => esc_html__( 'No Repeat', 'supro' ),
				'repeat'    => esc_html__( 'Repeat', 'supro' ),
				'repeat-x'  => esc_html__( 'Repeat-x', 'supro' ),
				'repeat-y'  => esc_html__( 'Repeat-y', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'tablet',
				),
			),
		),
		'page_header_background_size_tablet'               => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Size', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''        => esc_html__( 'Default', 'supro' ),
				'auto'    => esc_html__( 'Auto', 'supro' ),
				'cover'   => esc_html__( 'Cover', 'supro' ),
				'contain' => esc_html__( 'Contain', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'tablet',
				),
			),
		),
		/*======Mobile======*/
		'page_header_background_mobile'                    => array(
			'type'            => 'image',
			'label'           => esc_html__( 'Background Image', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'mobile',
				),
			),
		),
		'page_header_background_position_mobile'           => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Position', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''              => esc_html__( 'Default', 'supro' ),
				'top left'      => esc_html__( 'Top Left', 'supro' ),
				'top center'    => esc_html__( 'Top Center', 'supro' ),
				'top right'     => esc_html__( 'Top Right', 'supro' ),
				'center left'   => esc_html__( 'Center Left', 'supro' ),
				'center center' => esc_html__( 'Center Center', 'supro' ),
				'center right'  => esc_html__( 'Center Right', 'supro' ),
				'bottom left'   => esc_html__( 'Bottom Left', 'supro' ),
				'bottom center' => esc_html__( 'Bottom Center', 'supro' ),
				'bottom right'  => esc_html__( 'Bottom Right', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'mobile',
				),
			),
		),
		'page_header_background_repeat_mobile'             => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Repeat', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''          => esc_html__( 'Default', 'supro' ),
				'no-repeat' => esc_html__( 'No Repeat', 'supro' ),
				'repeat'    => esc_html__( 'Repeat', 'supro' ),
				'repeat-x'  => esc_html__( 'Repeat-x', 'supro' ),
				'repeat-y'  => esc_html__( 'Repeat-y', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'mobile',
				),
			),
		),
		'page_header_background_size_mobile'               => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Background Size', 'supro' ),
			'section'         => 'page_header',
			'default'         => '',
			'choices'         => array(
				''        => esc_html__( 'Default', 'supro' ),
				'auto'    => esc_html__( 'Auto', 'supro' ),
				'cover'   => esc_html__( 'Cover', 'supro' ),
				'contain' => esc_html__( 'Contain', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'page_header',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'page_header_device',
					'operator' => '==',
					'value'    => 'mobile',
				),
			),
		),



		// Single Posts
		'single_post_layout'                               => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Single Post Layout', 'supro' ),
			'section'     => 'single_post',
			'default'     => 'full-content',
			'priority'    => 5,
			'description' => esc_html__( 'Select default sidebar for the single post page.', 'supro' ),
			'choices'     => array(
				'content-sidebar' => esc_html__( 'Right Sidebar', 'supro' ),
				'sidebar-content' => esc_html__( 'Left Sidebar', 'supro' ),
				'full-content'    => esc_html__( 'Full Content', 'supro' ),
			),
		),
		'post_entry_meta'                                  => array(
			'type'     => 'multicheck',
			'label'    => esc_html__( 'Entry Meta', 'supro' ),
			'section'  => 'single_post',
			'default'  => array( 'author', 'scat', 'date' ),
			'choices'  => array(
				'scat'   => esc_html__( 'Category', 'supro' ),
				'author' => esc_html__( 'Author', 'supro' ),
				'date'   => esc_html__( 'Date', 'supro' ),
			),
			'priority' => 10,
		),
		'post_custom_field_1'                              => array(
			'type'    => 'custom',
			'section' => 'single_post',
			'default' => '<hr/>',
		),
		
		

		'show_author_box'                                  => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Author Box', 'supro' ),
			'section'  => 'single_post',
			'default'  => 1,
			'priority' => 10,
		),
		'post_custom_field_2'                              => array(
			'type'    => 'custom',
			'section' => 'single_post',
			'default' => '<hr/>',
		),
		'related_posts'                                    => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Related Posts', 'supro' ),
			'section'     => 'single_post',
			'description' => esc_html__( 'Check this option to show related posts in the single post page.', 'supro' ),
			'default'     => 1,
			'priority'    => 20,
		),
		'related_posts_title'                              => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Related Posts Title', 'supro' ),
			'section'         => 'single_post',
			'default'         => esc_html__( 'You may also like', 'supro' ),
			'priority'        => 20,

			'active_callback' => array(
				array(
					'setting'  => 'related_post',
					'operator' => '==',
					'value'    => true,
				),
			),
		),
		'related_posts_numbers'                            => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Related Posts Numbers', 'supro' ),
			'section'         => 'single_post',
			'default'         => '2',
			'priority'        => 20,
			'active_callback' => array(
				array(
					'setting'  => 'related_post',
					'operator' => '==',
					'value'    => true,
				),
			),
		),
		// Catalog Notification
		
		
		'sampleboxmessage'             => array(
			'type'            => 'textarea',
			'default'         => '',
			'label'           => esc_html__( 'Sample Message for Businesses', 'supro' ),
			'section'         => 'woocommerce_checkout',
			'description'     => esc_html__( 'Enter Text for Samples Messages.', 'supro' ),
			'tooltip'         => wp_kses_post( esc_html__( 'HTML Allowed', 'supro' ) ),
			'priority'        => 70,
		),
		
		
		
		'added_to_cart_notice'                             => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Added to Cart Notification', 'supro' ),
			'description' => esc_html__( 'Display a notification when a product is added to cart', 'supro' ),
			'section'     => 'catalog_notification',
			'priority'    => 70,
			'default'     => 1,
		),
		'cart_notice_auto_hide'                            => array(
			'type'        => 'number',
			'label'       => esc_html__( 'Cart Notification Auto Hide', 'supro' ),
			'description' => esc_html__( 'How many seconds you want to hide the notification.', 'supro' ),
			'section'     => 'catalog_notification',
			'priority'    => 70,
			'default'     => 3,
		),
		'catalog_notification_custom_'                     => array(
			'type'     => 'custom',
			'section'  => 'catalog_notification',
			'default'  => '<hr>',
			'priority' => 70,
		),
		'added_to_wishlist_notice'                         => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Added to Wislist Notification', 'supro' ),
			'description' => esc_html__( 'Display a notification when a product is added to wishlist', 'supro' ),
			'section'     => 'catalog_notification',
			'priority'    => 70,
			'default'     => 0,
		),
		'wishlist_notice_auto_hide'                        => array(
			'type'        => 'number',
			'label'       => esc_html__( 'Wishlist Notification Auto Hide', 'supro' ),
			'description' => esc_html__( 'How many seconds you want to hide the notification.', 'supro' ),
			'section'     => 'catalog_notification',
			'priority'    => 70,
			'default'     => 3,
		),
		// Catalog
		'product_attribute'                                => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Product Attribute', 'supro' ),
			'section'     => 'shop',
			'default'     => 'none',
			'priority'    => 70,
			'choices'     => supro_product_attributes(),
			'description' => esc_html__( 'Show product attribute for each item listed under the item name.', 'supro' ),
		),
		'catalog_custom'                                   => array(
			'type'     => 'custom',
			'section'  => 'shop',
			'default'  => '<hr>',
			'priority' => 70,
		),
		'catalog_layout'                                   => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Catalog Layout', 'supro' ),
			'default'     => 'full-content',
			'section'     => 'shop',
			'priority'    => 70,
			'description' => esc_html__( 'Select layout for catalog.', 'supro' ),
			'choices'     => array(
				'sidebar-content' => esc_html__( 'Left Sidebar', 'supro' ),
				'content-sidebar' => esc_html__( 'Right Sidebar', 'supro' ),
				'full-content'    => esc_html__( 'Full Content', 'supro' ),
				'masonry-content' => esc_html__( 'Masonry Content', 'supro' ),
			),
		),
		'catalog_full_width'                               => array(
			'type'            => 'toggle',
			'label'           => esc_html__( 'Catalog Full Width', 'supro' ),
			'default'         => '0',
			'section'         => 'shop',
			'priority'        => 70,
			'active_callback' => array(
				array(
					'setting'  => 'catalog_layout',
					'operator' => 'in',
					'value'    => array( 'sidebar-content', 'content-sidebar', 'full-content' ),
				),
			),
		),
		'shop_view'                                        => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Catalog View', 'supro' ),
			'description'     => esc_html__( 'Select Catalog View', 'supro' ),
			'section'         => 'shop',
			'priority'        => 70,
			'default'         => 'grid',
			'choices'         => array(
				'grid' => esc_html__( 'Grid', 'supro' ),
				'list' => esc_html__( 'List', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'catalog_layout',
					'operator' => 'in',
					'value'    => array( 'sidebar-content', 'content-sidebar', 'full-content' ),
				),
			),
		),
		'shop_toolbar_masonry'                             => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Masonry ToolBar Elements', 'supro' ),
			'section'         => 'shop',
			'default'         => array( 'categories', 'filter' ),
			'priority'        => 70,
			'choices'         => array(
				'categories' => esc_html__( 'Categories', 'supro' ),
				'filter'     => esc_html__( 'Filters', 'supro' ),
			),
			'description'     => esc_html__( 'Select which elements you want to show.', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'catalog_layout',
					'operator' => 'in',
					'value'    => array( 'masonry-content' )
				),
			),
		),
		'catalog_categories_numbers'                       => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Categories Numbers', 'supro' ),
			'section'         => 'shop',
			'default'         => 3,
			'priority'        => 70,
			'active_callback' => array(
				array(
					'setting'  => 'catalog_layout',
					'operator' => 'in',
					'value'    => array( 'masonry-content' )
				),
			),
		),
		'catalog_categories'                               => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Custom Categories', 'supro' ),
			'section'         => 'shop',
			'default'         => '',
			'priority'        => 70,
			'description'     => esc_html__( 'Enter categories slug you want to display. Each slug is separated by comma character ",". If empty, it will display default', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'catalog_layout',
					'operator' => 'in',
					'value'    => array( 'masonry-content' )
				),
			),
		),
		'catalog_custom_2'                                 => array(
			'type'     => 'custom',
			'section'  => 'shop',
			'default'  => '<hr>',
			'priority' => 70,
		),
		'add_to_cart_action'                               => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Catalog Add to Cart Action', 'supro' ),
			'section'  => 'shop',
			'priority' => 70,
			'default'  => 'notice',
			'choices'  => array(
				'notice' => esc_html__( 'Show Notice', 'supro' ),
				'cart'   => esc_html__( 'Show Cart Sidebar', 'supro' ),
			),
		),
		'catalog_ajax_filter_custom'                       => array(
			'type'     => 'custom',
			'section'  => 'shop',
			'default'  => '<hr>',
			'priority' => 70,
		),

		'disable_secondary_thumb'                          => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Disable Secondary Product Thumbnail', 'supro' ),
			'section'     => 'shop',
			'default'     => 0,
			'priority'    => 70,
			'description' => esc_html__( 'Check this option to disable secondary product thumbnail when hover over the main product image.', 'supro' ),
		),
		'shop_nav_type'                                    => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Type of Navigation', 'supro' ),
			'section'  => 'shop',
			'default'  => 'numbers',
			'priority' => 90,
			'choices'  => array(
				'numbers'  => esc_html__( 'Page Numbers', 'supro' ),
				'ajax'     => esc_html__( 'Ajax Loading', 'supro' ),
				'infinite' => esc_html__( 'Infinite Scroll', 'supro' ),
			),
		),


		// Catalog Page Header
		'catalog_page_header'                              => array(
			'type'        => 'toggle',
			'default'     => 1,
			'label'       => esc_html__( 'Enable Page Header', 'supro' ),
			'section'     => 'catalog_page_header',
			'description' => esc_html__( 'Enable to show a page header for catalog page below the site header', 'supro' ),
			'priority'    => 70,
		),
		'catalog_page_header_breadcrumbs'                  => array(
			'type'            => 'toggle',
			'default'         => 1,
			'label'           => esc_html__( 'Enable Breadcrumbs', 'supro' ),
			'section'         => 'catalog_page_header',
			'description'     => esc_html__( 'Enable to show a breadcrumbs for catalog page below the site header', 'supro' ),
			'priority'        => 70,
			'active_callback' => array(
				array(
					'setting'  => 'catalog_page_header',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		'catalog_page_header_custom'                       => array(
			'type'     => 'custom',
			'section'  => 'catalog_page_header',
			'default'  => '<hr>',
			'priority' => 70,
		),

		'shop_toolbar'                                     => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Shop Toolbar', 'supro' ),
			'section'         => 'catalog_page_header',
			'default'         => array( 'result', 'sort_by', 'shop_view' ),
			'priority'        => 70,
			'choices'         => array(
				'result'    => esc_html__( 'Result', 'supro' ),
				'sort_by'   => esc_html__( 'Sort By', 'supro' ),
				'shop_view' => esc_html__( 'Shop View', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'catalog_page_header',
					'operator' => '==',
					'value'    => 1,
				),
			),
			'description'     => esc_html__( 'Select which elements you want to show on shop toolbar', 'supro' ),
		),

		'catalog_page_header_custom_2'                     => array(
			'type'     => 'custom',
			'section'  => 'catalog_page_header',
			'default'  => '<hr>',
			'priority' => 70,
		),

		'catalog_page_header_banner'                       => array(
			'type'            => 'toggle',
			'default'         => 1,
			'label'           => esc_html__( 'Enable Catalog Banner', 'supro' ),
			'section'         => 'catalog_page_header',
			'description'     => esc_html__( 'Enable to show a page header banner for catalog page', 'supro' ),
			'priority'        => 70,
			'active_callback' => array(
				array(
					'setting'  => 'catalog_page_header_layout',
					'operator' => '==',
					'value'    => '3',
				),
			),
		),
		'catalog_page_header_banner_shortcode'             => array(
			'type'            => 'textarea',
			'default'         => '',
			'label'           => esc_html__( 'Catalog Banner Shortcode', 'supro' ),
			'section'         => 'catalog_page_header',
			'description'     => esc_html__( 'Enter banner shortcode.', 'supro' ),
			'tooltip'         => wp_kses_post( esc_html__( 'You can build banner by RevSlider then copy that shortcode into here', 'supro' ) ),
			'priority'        => 70,
			'active_callback' => array(
				array(
					'setting'  => 'catalog_page_header_layout',
					'operator' => '==',
					'value'    => '3',
				),
				array(
					'setting'  => 'catalog_page_header_banner',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),

		//Badge
		'show_badges'                                      => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Show Badges', 'supro' ),
			'section'     => 'shop_badge',
			'default'     => 1,
			'priority'    => 20,
			'description' => esc_html__( 'Check this to show badges on every products.', 'supro' ),
		),
		'badges'                                           => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Badges', 'supro' ),
			'section'         => 'shop_badge',
			'default'         => array( 'hot', 'new', 'sale', 'outofstock' ),
			'priority'        => 20,
			'choices'         => array(
				'hot'        => esc_html__( 'Hot', 'supro' ),
				'new'        => esc_html__( 'New', 'supro' ),
				'sale'       => esc_html__( 'Sale', 'supro' ),
				'outofstock' => esc_html__( 'Out Of Stock', 'supro' ),
			),
			'description'     => esc_html__( 'Select which badges you want to show', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'show_badges',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'sale_badge_custom'                                => array(
			'type'     => 'custom',
			'label'    => '<hr/>',
			'default'  => '<h2>' . esc_html__( 'Sale Badge', 'supro' ) . '</h2>',
			'section'  => 'shop_badge',
			'priority' => 20,
		),
		'sale_behaviour'                                   => array(
			'type'            => 'radio',
			'label'           => esc_html__( 'Sale Behaviour', 'supro' ),
			'default'         => 'text',
			'section'         => 'shop_badge',
			'priority'        => 20,
			'choices'         => array(
				'text'       => esc_attr__( 'Show Text', 'supro' ),
				'percentage' => esc_attr__( 'Show Percentage Discount', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'sale',
				),
			),
		),
		'sale_text'                                        => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Custom Sale Text', 'supro' ),
			'section'         => 'shop_badge',
			'default'         => esc_html__( 'Sale', 'supro' ),
			'priority'        => 20,
			'active_callback' => array(
				array(
					'setting'  => 'show_badges',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'sale_behaviour',
					'operator' => '==',
					'value'    => 'text',
				),
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'sale',
				),
			),
		),
		'sale_color'                                       => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'supro' ),
			'default'         => '',
			'section'         => 'shop_badge',
			'priority'        => 20,
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'sale',
				),
			),
		),
		'sale_bg_color'                                    => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'supro' ),
			'default'         => '',
			'section'         => 'shop_badge',
			'priority'        => 20,
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'sale',
				),
			),
		),
		'hot_badge_custom'                                 => array(
			'type'     => 'custom',
			'label'    => '<hr/>',
			'default'  => '<h2>' . esc_html__( 'Hot Badge', 'supro' ) . '</h2>',
			'section'  => 'shop_badge',
			'priority' => 20,
		),
		'hot_text'                                         => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Custom Hot Text', 'supro' ),
			'section'         => 'shop_badge',
			'priority'        => 20,
			'default'         => esc_html__( 'Hot', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'show_badges',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'hot',
				),
			),
		),
		'hot_color'                                        => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'supro' ),
			'default'         => '',
			'priority'        => 20,
			'section'         => 'shop_badge',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'hot',
				),
			),
		),
		'hot_bg_color'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'supro' ),
			'default'         => '',
			'priority'        => 20,
			'section'         => 'shop_badge',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'hot',
				),
			),
		),
		'outofstock_badge_custom'                          => array(
			'type'     => 'custom',
			'label'    => '<hr/>',
			'default'  => '<h2>' . esc_html__( 'Out of stock Badge', 'supro' ) . '</h2>',
			'section'  => 'shop_badge',
			'priority' => 20,
		),
		'outofstock_text'                                  => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Custom Out Of Stock Text', 'supro' ),
			'section'         => 'shop_badge',
			'default'         => esc_html__( 'Out Of Stock', 'supro' ),
			'priority'        => 20,
			'active_callback' => array(
				array(
					'setting'  => 'show_badges',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'outofstock',
				),
			),
		),
		'outofstock_color'                                 => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'supro' ),
			'default'         => '',
			'priority'        => 20,
			'section'         => 'shop_badge',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'outofstock',
				),
			),
		),
		'outofstock_bg_color'                              => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'supro' ),
			'default'         => '',
			'priority'        => 20,
			'section'         => 'shop_badge',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'outofstock',
				),
			),
		),
		'new_badge_custom'                                 => array(
			'type'     => 'custom',
			'label'    => '<hr/>',
			'default'  => '<h2>' . esc_html__( 'New Badge', 'supro' ) . '</h2>',
			'section'  => 'shop_badge',
			'priority' => 20,
		),
		'new_text'                                         => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Custom New Text', 'supro' ),
			'section'         => 'shop_badge',
			'default'         => esc_html__( 'New', 'supro' ),
			'priority'        => 20,
			'active_callback' => array(
				array(
					'setting'  => 'show_badges',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'new',
				),
			),
		),
		'new_color'                                        => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'supro' ),
			'default'         => '',
			'section'         => 'shop_badge',
			'priority'        => 20,
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'new',
				),
			),
		),
		'new_bg_color'                                     => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'supro' ),
			'default'         => '',
			'section'         => 'shop_badge',
			'priority'        => 20,
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'new',
				),
			),
		),
		'product_newness'                                  => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Product Newness', 'supro' ),
			'section'         => 'shop_badge',
			'default'         => 3,
			'priority'        => 20,
			'description'     => esc_html__( 'Display the "New" badge for how many days?', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'show_badges',
					'operator' => '==',
					'value'    => 1,
				),
				array(
					'setting'  => 'badges',
					'operator' => 'contains',
					'value'    => 'new',
				),
			),
		),
		'custom_badge_custom'                              => array(
			'type'     => 'custom',
			'label'    => '<hr/>',
			'default'  => '<h2>' . esc_html__( 'Custom Badge', 'supro' ) . '</h2>',
			'section'  => 'shop_badge',
			'priority' => 20,
		),
		'custom_badge'                                     => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Custom Badge', 'supro' ),
			'section'  => 'shop_badge',
			'default'  => 0,
			'priority' => 20,
		),
		'custom_badge_color'                               => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Color', 'supro' ),
			'default'         => '',
			'section'         => 'shop_badge',
			'priority'        => 20,
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'custom_badge',
					'operator' => '=',
					'value'    => 1,
				),
			),
		),
		'custom_badge_bg_color'                            => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'supro' ),
			'default'         => '',
			'section'         => 'shop_badge',
			'priority'        => 20,
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'custom_badge',
					'operator' => '=',
					'value'    => 1,
				),
			),
		),
		// Single Product
		'product_zoom'                                     => array(
			'type'            => 'toggle',
			'label'           => esc_html__( 'Product Zoom', 'supro' ),
			'section'         => 'single_product',
			'default'         => 0,
			'description'     => esc_html__( 'Check this option to show a bigger size product image on mouseover', 'supro' ),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'single_product_layout',
					'operator' => 'in',
					'value'    => array( '1', '2' ),
				),
			),
		),
		'product_images_lightbox'                          => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Product Images Gallery', 'supro' ),
			'section'     => 'single_product',
			'default'     => 1,
			'description' => esc_html__( 'Check this option to open product gallery images in a lightbox', 'supro' ),
			'priority'    => 10,
		),
		'product_add_to_cart_ajax'                         => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Add to cart with AJAX', 'supro' ),
			'section'     => 'single_product',
			'default'     => 1,
			'priority'    => 10,
			'description' => esc_html__( 'Check this option to enable add to cart with AJAX on the product page.', 'supro' ),
		),

		'product_add_to_cart_sticky'                       => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Add to cart Sticky', 'supro' ),
			'section'     => 'single_product',
			'default'     => 1,
			'priority'    => 10,
			'description' => esc_html__( 'Check this option to enable add to cart sticky on the product page on mobile.', 'supro' ),
		),
		'single_product_custom'                            => array(
			'type'     => 'custom',
			'section'  => 'single_product',
			'default'  => '<hr>',
			'priority' => 10,
		),
		'single_product_sidebar'                           => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Single Product Sidebar', 'supro' ),
			'section'         => 'single_product',
			'default'         => 'full-content',
			'priority'        => 10,
			'choices'         => array(
				'sidebar-content' => esc_html__( 'Left Sidebar', 'supro' ),
				'content-sidebar' => esc_html__( 'Right Sidebar', 'supro' ),
				'full-content'    => esc_html__( 'Full Content', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'single_product_layout',
					'operator' => '==',
					'value'    => '1',
				),
			),
		),
		'single_product_background_color'                  => array(
			'type'            => 'color',
			'label'           => esc_html__( 'Background Color', 'supro' ),
			'default'         => '#f2f1f0',
			'section'         => 'single_product',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'single_product_layout',
					'operator' => '==',
					'value'    => '2',
				),
			),
		),

		'product_badges'                                   => array(
			'type'            => 'toggle',
			'label'           => esc_html__( 'Show Badges', 'supro' ),
			'section'         => 'single_product',
			'default'         => 1,
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'single_product_layout',
					'operator' => 'in',
					'value'    => array( '1' ),
				),
			),
		),
		'single_product_custom_1'                          => array(
			'type'     => 'custom',
			'section'  => 'single_product',
			'default'  => '<hr>',
			'priority' => 10,
		),
		'product_buy_now'                                  => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Buy Now Button', 'supro' ),
			'section'     => 'single_product',
			'default'     => 1,
			'description' => esc_html__( 'Show buy now in the single product.', 'supro' ),
			'priority'    => 10,
		),
		'product_buy_now_text'                             => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Buy Now Text', 'supro' ),
			'description'     => esc_html__( 'Enter Buy not button text.', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( 'Buy Now', 'supro' ),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'product_buy_now',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_buy_now_link'                             => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Buy Now Link', 'supro' ),
			'section'         => 'single_product',
			'default'         => '',
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'product_buy_now',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'single_product_custom_2'                          => array(
			'type'     => 'custom',
			'section'  => 'single_product',
			'default'  => '<hr>',
			'priority' => 10,
		),
		'show_product_socials'                             => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Product Socials', 'supro' ),
			'section'  => 'single_product',
			'default'  => 1,
			'priority' => 10,
		),
		'single_product_socials_share'                     => array(
			'type'            => 'multicheck',
			'label'           => esc_html__( 'Socials Share', 'supro' ),
			'section'         => 'single_product',
			'default'         => array( 'facebook', 'twitter', 'pinterest' ),
			'choices'         => array(
				'facebook'  => esc_html__( 'Facebook', 'supro' ),
				'twitter'   => esc_html__( 'Twitter', 'supro' ),
				'google'    => esc_html__( 'Google Plus', 'supro' ),
				'tumblr'    => esc_html__( 'Tumblr', 'supro' ),
				'pinterest' => esc_html__( 'Pinterest', 'supro' ),
				'linkedin'  => esc_html__( 'Linkedin', 'supro' ),
			),
			'priority'        => 10,
			'active_callback' => array(
				array(
					'setting'  => 'show_product_socials',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'single_product_custom_3'                          => array(
			'type'     => 'custom',
			'section'  => 'single_product',
			'default'  => '<hr>',
			'priority' => 40,
		),
		'show_product_meta'                                => array(
			'type'        => 'multicheck',
			'label'       => esc_html__( 'Show Product Meta', 'supro' ),
			'section'     => 'single_product',
			'default'     => array( 'sku', 'categories', 'tags' ),
			'priority'    => 40,
			'choices'     => array(
				'sku'        => esc_html__( 'SKU', 'supro' ),
				'categories' => esc_html__( 'Categories', 'supro' ),
				'tags'       => esc_html__( 'Tags', 'supro' ),
				'brand'      => esc_html__( 'Brand', 'supro' )
			),
			'description' => esc_html__( 'Select which product meta you want to show in single product page. Brand product just show if Brand Product Plugin is activated', 'supro' ),
		),
		
		
	
	
		'fittabdetailsgloveheader'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Glove Details Header', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( '', 'supro' ),
			'priority'        => 40,
		),
		
		
		
		'fittabdetailsgloveinfo'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Glove Details', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( '', 'supro' ),
			'priority'        => 40,
		),
		
				
		'fittabdetailsinfoglovediagram'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Glove Details Diagram', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( '', 'supro' ),
			'priority'        => 40,
		),
		
		
		
	
		'fittabdetailssleeveheader'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Glove Details Header', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( '', 'supro' ),
			'priority'        => 40,
		),
		
	
		
		'fittabdetailssleeveinfo'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Sleeve Details', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( '', 'supro' ),
			'priority'        => 40,
		),
		
				
		'fittabdetailsinfosleevediagram'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Other Details Diagram', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( '', 'supro' ),
			'priority'        => 40,
		),
		'fitsleevetitle'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Other Details Diagram', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( 'To find the best fit, measure the circumference of your bicep and choose sizing according to the chart below.', 'supro' ),
			'priority'        => 40,
		),

		'fitsleevebottomtext'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Other Details Diagram', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( 'For a more natural fit, sleeves come in a tapered version which provide better comfort and staying power. Tapered sleeves are designed to fit the contours of your arm and won\'t lose shape due to stretching.', 'supro' ),
			'priority'        => 40,
		),
		


		
		'fitsleevetext'                            => array(
			'type'            => 'textarea',
			'label'           => esc_html__( 'Specs TAB Other Details Diagram', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( 'Sleeves come in multiple lengths.', 'supro' ),
			'priority'        => 40,
		),

        'fittabdetailsotherheader'                            => array(
            'type'            => 'textarea',
            'label'           => esc_html__( 'Specs TAB Other Details Header', 'supro' ),
            'section'         => 'single_product',
            'default'         => esc_html__( '', 'supro' ),
            'priority'        => 40,
        ),



        'fittabdetailsotherinfo'                            => array(
            'type'            => 'textarea',
            'label'           => esc_html__( 'Specs TAB Other Details', 'supro' ),
            'section'         => 'single_product',
            'default'         => esc_html__( '', 'supro' ),
            'priority'        => 40,
        ),


        'fittabdetailsinfootherdiagram'                            => array(
            'type'            => 'textarea',
            'label'           => esc_html__( 'Specs TAB Sleeve Details Diagram', 'supro' ),
            'section'         => 'single_product',
            'default'         => esc_html__( '', 'supro' ),
            'priority'        => 40,
        ),
		
		
		
		
		
		'single_product_custom_4'                          => array(
			'type'     => 'custom',
			'section'  => 'single_product',
			'default'  => '<hr>',
			'priority' => 40,
		),
		'single_product_toolbar'                           => array(
			'type'        => 'multicheck',
			'label'       => esc_html__( 'Product Toolbar', 'supro' ),
			'section'     => 'single_product',
			'default'     => array( 'breadcrumb', 'navigation' ),
			'priority'    => 40,
			'choices'     => array(
				'breadcrumb' => esc_html__( 'Breadcrumb', 'supro' ),
				'navigation' => esc_html__( 'Navigation', 'supro' ),
			),
			'description' => esc_html__( 'Select element you want to show on product toolbar in single product page', 'supro' ),
		),
		'product_related_custom'                           => array(
			'type'     => 'custom',
			'section'  => 'single_product',
			'default'  => '<hr>',
			'priority' => 40,
		),
		
		
		
		
		
		
		
		
		
	
		'product_cta'                                  => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Product CTA', 'supro' ),
			'section'  => 'single_product_CTA_extra',
			'default'  => 1,
			'priority' => 40,
		),
		'product_cta_title'                            => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Product CTA Title', 'supro' ),
			'section'         => 'single_product_CTA_extra',
			'default'         => esc_html__( 'Not What Your Looking For?', 'supro' ),
			'priority'        => 40,
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_cta_title_color'                                 => array(
			'type'            => 'color',
			'label'           => esc_html__( 'CTA Title Color', 'supro' ),
			'default'         => '',
			'priority'        => 40,
			'section'         => 'single_product_CTA_extra',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_cta_subtitle'                            => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Product CTA Sub-title', 'supro' ),
			'section'         => 'single_product_CTA_extra',
			'default'         => esc_html__( 'Find th right glove for your industry', 'supro' ),
			'priority'        => 40,
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_cta_subtitle_color'                                 => array(
			'type'            => 'color',
			'label'           => esc_html__( 'CTA Sub-title Color', 'supro' ),
			'default'         => '',
			'priority'        => 40,
			'section'         => 'single_product_CTA_extra',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_cta_buttontext'                            => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Product CTA Button Text', 'supro' ),
			'section'         => 'single_product_CTA_extra',
			'default'         => esc_html__( 'Shop All', 'supro' ),
			'priority'        => 40,
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_cta_buttonurl'                            => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Product CTA Button URL', 'supro' ),
			'section'         => 'single_product_CTA_extra',
			'default'         => esc_html__( '#', 'supro' ),
			'priority'        => 40,
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_cta_button_color'                                 => array(
			'type'            => 'color',
			'label'           => esc_html__( 'CTA Button Color', 'supro' ),
			'default'         => '',
			'priority'        => 40,
			'section'         => 'single_product_CTA_extra',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		
		// Logo
		'ctabackground'                                             => array(
			'type'     => 'image',
			'label'    => esc_html__( 'CTA Background Image', 'supro' ),
			'section'  => 'single_product_CTA_extra',
			'default'  => '',
			'priority' => 40,
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		
		'product_cta_bck_color'                                 => array(
			'type'            => 'color',
			'label'           => esc_html__( 'CTA Background Color', 'supro' ),
			'default'         => '',
			'priority'        => 40,
			'section'         => 'single_product_CTA_extra',
			'choices'         => array(
				'alpha' => true,
			),
			'active_callback' => array(
				array(
					'setting'  => 'product_cta',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		'product_related'                                  => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Related Products', 'supro' ),
			'section'  => 'single_product',
			'default'  => 1,
			'priority' => 40,
		),
		'product_related_title'                            => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Related Products Title', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( 'Related products', 'supro' ),
			'priority'        => 40,
			'active_callback' => array(
				array(
					'setting'  => 'product_related',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'related_products_columns'                         => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Related Products Columns', 'supro' ),
			'section'         => 'single_product',
			'default'         => '4',
			'priority'        => 40,
			'description'     => esc_html__( 'Specify how many columns of related products you want to show on single product page', 'supro' ),
			'choices'         => array(
				'3' => esc_html__( '3 Columns', 'supro' ),
				'4' => esc_html__( '4 Columns', 'supro' ),
				'5' => esc_html__( '5 Columns', 'supro' ),
				'6' => esc_html__( '6 Columns', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'product_related',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'related_products_numbers'                         => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Related Products Numbers', 'supro' ),
			'section'         => 'single_product',
			'default'         => 4,
			'priority'        => 40,
			'description'     => esc_html__( 'Specify how many numbers of related products you want to show on single product page', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'product_related',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'product_upsells_custom'                           => array(
			'type'     => 'custom',
			'section'  => 'single_product',
			'default'  => '<hr>',
			'priority' => 40,
		),
		'product_upsells'                                  => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Show Up-sells Products', 'supro' ),
			'section'  => 'single_product',
			'default'  => 0,
			'priority' => 40,
		),
		'product_upsells_title'                            => array(
			'type'            => 'text',
			'label'           => esc_html__( 'Up-sells Products Title', 'supro' ),
			'section'         => 'single_product',
			'default'         => esc_html__( 'You may also like', 'supro' ),
			'priority'        => 40,
			'active_callback' => array(
				array(
					'setting'  => 'product_upsells',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'upsells_products_columns'                         => array(
			'type'            => 'select',
			'label'           => esc_html__( 'Up-sells Products Columns', 'supro' ),
			'section'         => 'single_product',
			'default'         => '4',
			'priority'        => 40,
			'description'     => esc_html__( 'Specify how many columns of up-sells products you want to show on single product page', 'supro' ),
			'choices'         => array(
				'3' => esc_html__( '3 Columns', 'supro' ),
				'4' => esc_html__( '4 Columns', 'supro' ),
				'5' => esc_html__( '5 Columns', 'supro' ),
				'6' => esc_html__( '6 Columns', 'supro' ),
			),
			'active_callback' => array(
				array(
					'setting'  => 'product_upsells',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),
		'upsells_products_numbers'                         => array(
			'type'            => 'number',
			'label'           => esc_html__( 'Up-sells Products Numbers', 'supro' ),
			'section'         => 'single_product',
			'default'         => 4,
			'priority'        => 40,
			'description'     => esc_html__( 'Specify how many numbers of up-sells products you want to show on single product page', 'supro' ),
			'active_callback' => array(
				array(
					'setting'  => 'product_upsells',
					'operator' => '==',
					'value'    => 1,
				),
			),
		),




		// Footer Newsletter
		'footer_newsletter'                                => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Newsletter', 'supro' ),
			'section'  => 'footer_newsletter',
			'default'  => 0,
			'priority' => 10,
		),
		'footer_newsletter_home'                           => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Show on HomePage', 'supro' ),
			'section'     => 'footer_newsletter',
			'default'     => 1,
			'priority'    => 10,
			'description' => esc_html__( 'Just show newsletter on HomePage', 'supro' ),
		),
		'newsletter_style'                                 => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Style', 'supro' ),
			'section'     => 'footer_newsletter',
			'default'     => 'space-between',
			'priority'    => 10,
			'choices'     => array(
				'space-between' => esc_html__( 'Space Between', 'supro' ),
				'center'        => esc_html__( 'Center', 'supro' ),
			),
			'description' => esc_html__( 'Select Style for Newsletter', 'supro' ),
		),
		'newsletter_shape'                                 => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Shape', 'supro' ),
			'section'  => 'footer_newsletter',
			'default'  => 'square',
			'priority' => 10,
			'choices'  => array(
				'square' => esc_html__( 'Square', 'supro' ),
				'round'  => esc_html__( 'Round', 'supro' ),
			),
		),
		'newsletter_title'                                 => array(
			'type'     => 'text',
			'label'    => esc_html__( 'Newsletter Title', 'supro' ),
			'section'  => 'footer_newsletter',
			'default'  => esc_html__( 'Keep Connected', 'supro' ),
			'priority' => 10,
		),
		'newsletter_desc'                                  => array(
			'type'     => 'textarea',
			'label'    => esc_html__( 'Newsletter Description', 'supro' ),
			'section'  => 'footer_newsletter',
			'default'  => esc_html__( 'Get updates by subscribe our weekly newsletter', 'supro' ),
			'priority' => 10,
		),
		'newsletter_form'                                  => array(
			'type'        => 'textarea',
			'label'       => esc_html__( 'Newsletter Form', 'supro' ),
			'section'     => 'footer_newsletter',
			'default'     => '',
			'priority'    => 10,
			'description' => esc_html__( 'Go to MailChimp for WP/Form to get shortcode', 'supro' ),
		),
		'newsletter_text_color'                            => array(
			'type'     => 'color',
			'label'    => esc_html__( 'Color', 'supro' ),
			'default'  => '',
			'section'  => 'footer_newsletter',
			'priority' => 30,
		),
		'newsletter_background_color'                      => array(
			'type'     => 'color',
			'label'    => esc_html__( 'Background Color', 'supro' ),
			'default'  => '',
			'section'  => 'footer_newsletter',
			'priority' => 30,
		),

		// Footer
		'footer_layout'                                    => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Footer Layout', 'supro' ),
			'section'  => 'footer_layout',
			'default'  => '1',
			'priority' => 10,
			'choices'  => array(
				'1' => esc_html__( 'Layout 1', 'supro' ),
				'2' => esc_html__( 'Layout 2', 'supro' ),
				'3' => esc_html__( 'Layout 3', 'supro' ),
			),
		),
		'footer_skin'                                      => array(
			'type'     => 'radio',
			'label'    => esc_html__( 'Footer Skin', 'supro' ),
			'section'  => 'footer_layout',
			'priority' => 10,
			'default'  => 'light',
			'choices'  => array(
				'light' => esc_html__( 'Light', 'supro' ),
				'dark'  => esc_html__( 'Dark', 'supro' ),
			),
		),
		'footer_background_color'                          => array(
			'type'     => 'color',
			'label'    => esc_html__( 'Background Color', 'supro' ),
			'default'  => '',
			'section'  => 'footer_layout',
			'priority' => 10,
		),
		'footer_background_image'                          => array(
			'type'     => 'image',
			'label'    => esc_html__( 'Background Image', 'supro' ),
			'default'  => '',
			'section'  => 'footer_layout',
			'priority' => 10,
		),
		'footer_background_horizontal'                     => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Background Horizontal', 'supro' ),
			'section'  => 'footer_layout',
			'default'  => '',
			'priority' => 10,
			'choices'  => array(
				''       => esc_html__( 'None', 'supro' ),
				'left'   => esc_html__( 'Left', 'supro' ),
				'center' => esc_html__( 'Center', 'supro' ),
				'right'  => esc_html__( 'Right', 'supro' ),
			),
		),
		'footer_background_vertical'                       => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Background Vertical', 'supro' ),
			'section'  => 'footer_layout',
			'default'  => '',
			'priority' => 10,
			'choices'  => array(
				''       => esc_html__( 'None', 'supro' ),
				'top'    => esc_html__( 'Top', 'supro' ),
				'center' => esc_html__( 'Center', 'supro' ),
				'bottom' => esc_html__( 'Bottom', 'supro' ),
			),
		),
		'footer_background_repeat'                         => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Background Repeat', 'supro' ),
			'section'  => 'footer_layout',
			'default'  => '',
			'priority' => 10,
			'choices'  => array(
				''          => esc_html__( 'None', 'supro' ),
				'no-repeat' => esc_html__( 'No Repeat', 'supro' ),
				'repeat'    => esc_html__( 'Repeat', 'supro' ),
				'repeat-y'  => esc_html__( 'Repeat Vertical', 'supro' ),
				'repeat-x'  => esc_html__( 'Repeat Horizontal', 'supro' ),
			),
		),
		'footer_background_attachment'                     => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Background Attachment', 'supro' ),
			'section'  => 'footer_layout',
			'default'  => '',
			'priority' => 10,
			'choices'  => array(
				''       => esc_html__( 'None', 'supro' ),
				'scroll' => esc_html__( 'Scroll', 'supro' ),
				'fixed'  => esc_html__( 'Fixed', 'supro' ),
			),
		),
		'footer_background_size'                           => array(
			'type'     => 'select',
			'label'    => esc_html__( 'Background Size', 'supro' ),
			'section'  => 'footer_layout',
			'default'  => '',
			'priority' => 10,
			'choices'  => array(
				''        => esc_html__( 'None', 'supro' ),
				'auto'    => esc_html__( 'Auto', 'supro' ),
				'cover'   => esc_html__( 'Cover', 'supro' ),
				'contain' => esc_html__( 'Contain', 'supro' ),
			),
		),

		// Footer Widgets

		'footer_widgets'                                   => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Footer Widgets', 'supro' ),
			'section'  => 'footer_widgets',
			'default'  => 1,
			'priority' => 10,
		),
		'footer_widgets_columns'                           => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Footer Widgets Columns', 'supro' ),
			'section'     => 'footer_widgets',
			'default'     => '5',
			'priority'    => 10,
			'choices'     => array(
				'1' => esc_html__( '1 Columns', 'supro' ),
				'2' => esc_html__( '2 Columns', 'supro' ),
				'3' => esc_html__( '3 Columns', 'supro' ),
				'4' => esc_html__( '4 Columns', 'supro' ),
				'5' => esc_html__( '5 Columns', 'supro' ),
			),
			'description' => esc_html__( 'Go to Appearance/Widgets/Footer Widget 1, 2, 3, 4, 5 to add widgets content.', 'supro' ),
		),

		// Footer Copyright

		'footer_copyright'                                 => array(
			'type'     => 'toggle',
			'label'    => esc_html__( 'Footer Copyright', 'supro' ),
			'section'  => 'footer_copyright',
			'default'  => 1,
			'priority' => 10,
		),
		'footer_copyright_columns'                         => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Footer Copyright Columns', 'supro' ),
			'section'     => 'footer_copyright',
			'default'     => '3',
			'priority'    => 10,
			'choices'     => array(
				'1' => esc_html__( '1 Columns', 'supro' ),
				'2' => esc_html__( '2 Columns', 'supro' ),
				'3' => esc_html__( '3 Columns', 'supro' ),
			),
			'description' => esc_html__( 'Go to Appearance/Widgets/Footer Copyright 1, 2, 3 to add widgets content.', 'supro' ),
		),
		'footer_copyright_menu_style'                      => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Menu style', 'supro' ),
			'section'     => 'footer_copyright',
			'default'     => '1',
			'priority'    => 10,
			'choices'     => array(
				'1' => esc_html__( 'Capitalize', 'supro' ),
				'2' => esc_html__( 'Uppercase', 'supro' ),
			),
			'description' => esc_html__( 'Select text transform for menu on footer copyright', 'supro' ),
		),
		'footer_copyright_top_spacing'                     => array(
			'type'        => 'number',
			'label'       => esc_html__( 'Top Spacing', 'supro' ),
			'description' => esc_html__( 'Adjust the top spacing.', 'supro' ),
			'section'     => 'footer_copyright',
			'default'     => '20',
			'js_vars'     => array(
				array(
					'element'  => '.site-footer .footer-copyright',
					'property' => 'padding-top',
					'units'    => 'px',
				),
			),
			'transport'   => 'postMessage',
		),
		'footer_copyright_bottom_spacing'                  => array(
			'type'        => 'number',
			'label'       => esc_html__( 'Bottom Spacing', 'supro' ),
			'description' => esc_html__( 'Adjust the bottom spacing.', 'supro' ),
			'section'     => 'footer_copyright',
			'default'     => '10',
			'js_vars'     => array(
				array(
					'element'  => '.site-footer .footer-copyright',
					'property' => 'padding-bottom',
					'units'    => 'px',
				),
			),
			'transport'   => 'postMessage',
		),

		// Footer Recent Viewed
		'footer_recently_viewed'                           => array(
			'type'        => 'toggle',
			'label'       => esc_html__( 'Show Recently Viewed', 'supro' ),
			'section'     => 'footer_recently_viewed',
			'default'     => 1,
			'priority'    => 90,
			'description' => esc_html__( 'Check this option to show the recently viewed products above the footer.', 'supro' ),
		),
		'footer_recently_viewed_els'                       => array(
			'type'        => 'multicheck',
			'label'       => esc_html__( 'Show Recently Viewed in', 'supro' ),
			'section'     => 'footer_recently_viewed',
			'default'     => array( 'homepage', 'catalog', 'single_product' ),
			'priority'    => 90,
			'choices'     => array(
				'homepage'       => esc_html__( 'HomePage', 'supro' ),
				'catalog'        => esc_html__( 'Catalog', 'supro' ),
				'single_product' => esc_html__( 'Single Product', 'supro' ),
				'page'           => esc_html__( 'Page', 'supro' ),
				'post'           => esc_html__( 'Post', 'supro' ),
				'other'          => esc_html__( 'Other Pages', 'supro' ),
			),
			'description' => esc_html__( 'Check pages to show the recently viewed products above the footer.', 'supro' ),
		),
		'footer_recently_viewed_title'                     => array(
			'type'     => 'text',
			'label'    => esc_html__( 'Recently Viewed Title', 'supro' ),
			'section'  => 'footer_recently_viewed',
			'default'  => esc_html__( 'Your Recently Viewed Products', 'supro' ),
			'priority' => 90,
		),
		'footer_recently_viewed_number'                    => array(
			'type'     => 'number',
			'label'    => esc_html__( 'Products Per Page', 'supro' ),
			'section'  => 'footer_recently_viewed',
			'default'  => 12,
			'priority' => 90,
		),

		// Mobile
		'menu_mobile_behaviour'                            => array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Menu Mobile Icon Behaviour', 'supro' ),
			'default' => 'icon',
			'section' => 'menu_mobile',
			'choices' => array(
				'icon' => esc_attr__( 'Open sub menu by click on icon', 'supro' ),
				'item' => esc_attr__( 'Open sub menu by click on item', 'supro' ),
				'whole' => esc_attr__( 'Open sub menu by click on either', 'supro' ),
			),
		),
		// Catalog Mobile
		'catalog_mobile_columns'                           => array(
			'type'        => 'select',
			'label'       => esc_html__( 'Catalog Columns', 'supro' ),
			'default'     => '1',
			'section'     => 'catalog_mobile',
			'priority'    => 70,
			'description' => esc_html__( 'Select catalog columns on mobile.', 'supro' ),
			'choices'     => array(
				'1' => esc_html__( '1 Column', 'supro' ),
				'2' => esc_html__( '2 Columns', 'supro' ),
			),
		),
	);

	$settings['panels']   = apply_filters( 'supro_customize_panels', $panels );
	$settings['sections'] = apply_filters( 'supro_customize_sections', $sections );
	$settings['fields']   = apply_filters( 'supro_customize_fields', $fields );

	return $settings;
}

$supro_customize = new Supro_Customize( supro_customize_settings() );