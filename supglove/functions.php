<?php
/**
 * Supglove functions and definitions
 *
 * @package Supglove
 */


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since  1.0
 *
 * @return void
 */
function order_review_heading() {
    // Check if it's the checkout page
    if (is_checkout()) {
        echo '<p id="order_review_heading"  class="checkoutheader">' . esc_html__( 'Your Products', 'supro' ) .'</p>
';
    }
}
add_action('woocommerce_checkout_before_order_review', 'order_review_heading');
function your_info_heading() {
    // Check if it's the checkout page
    if (is_checkout()) {
        echo '<p id="your_info_heading"  class="checkoutheader">'. esc_html__( 'Your Info', 'supro' ) .'</p>';
    }
}
add_action('woocommerce_checkout_affiliation', 'your_info_heading');
function woocommerce_checkout_step_2() {
    // Check if it's the checkout page
    if (is_checkout()) {
        echo '<p id="your_info_heading"  class="checkoutheader">'. esc_html__( 'Your Info', 'supro' ) .'</p>';
    }
}
add_action('woocommerce_checkout_step_2', 'woocommerce_checkout_step_2');
function woocommerce_checkout_info_email() {
    // Check if it's the checkout page
    if (is_checkout()) {
        echo '<p id="your_info_heading"  class="checkoutheader">'. esc_html__( 'Your Info', 'supro' ) .'</p>';
    }
}
add_action('woocommerce_checkout_info_email', 'woocommerce_checkout_info_email');
function woocommerce_checkout_info_contact() {
    // Check if it's the checkout page
    if (is_checkout()) {
        echo '<p id="your_info_heading"  class="checkoutheader">'. esc_html__( 'Your Info', 'supro' ) .'</p>';
    }
}
//add_action('woocommerce_checkout_info_contact', 'woocommerce_checkout_size_contact');

function woocommerce_checkout_size_info() {
  // Check if it's the checkout page
  if (is_checkout()) {
    echo '<p id="your_info_heading"  class="checkoutheader">'. esc_html__( 'Your Info', 'supro' ) .'</p>';
  }
}
add_action('woocommerce_checkout_info_contact', 'woocommerce_checkout_size_info');
function woocommerce_checkout_size_contact() {
  // Check if it's the checkout page
  if (is_checkout()) {
    do_action( 'woocommerce_checkout_order_review' );  
  }
}
add_action('woocommerce_checkout_info_contact', 'woocommerce_checkout_size_contact');

function woocommerce_checkout_enquired_info() {
    $has_enquired_product = false;

    // Check each product in cart for the _enquired_product meta
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = $cart_item['data'];
        if ( get_post_meta( $_product->get_id(), '_enquired_product', true ) === 'yes' ) {
            $has_enquired_product = true;
            break; // No need to check further if we found one
        }
    }
    if ( $has_enquired_product ) {
        echo '<div class="enquired_product_info ml-15" style="display: none">';
        echo '<small>*This item requires additional qualification and approval before a sample can be sent. Our sales team will contact you to discuss whether you meet qualification criteria to sample this product.</small>';
        echo '</div>';
    }
}

add_action('woocommerce_checkout_info_contact', 'woocommerce_checkout_enquired_info');

// Custom Email validation

add_action( 'woocommerce_after_checkout_validation', 'custom_validate_email', 10, 2 );
 
function custom_validate_email( $fields, $errors ){
  $emails = array('@gmail.com', '@yahoo.com', '@outlook.com', '@aol.com', '@protonmail.com', '@zoho.com', '@gmx.com', '@mail.com',
  '@yandex.com', '@tutanota.com', 'fastmail.com', '@hushmail.com', '@guerrillamail.com', '@tempmail.com',
  '@10minutemail.com', '@mailinator.com', '@countermail.com', '@runbox.com', '@scryptmail.com', '@lycos.com',
  '@inbox.com', '@mail.email', '@icewarp.com', '@luxsci.com', '@zimbra.com', '@rediffmail.com', '@tuffmail.com',
  '@bigstring.com', '@eclipso.com', '@startmail.com', '@vfemail.net', '@disroot.org', '@openmailbox.org', '@kolabnow.com',
  '@atmail.com', '@eclipso.de', '@posteo.net', '@aim.com', '@bluemail.me', '@myopera.com', '@naver.com', '@qq.com',
  '@sina.com', '@163.com', '@126.com', '@sohu.com', '@ymail.com', '@hushmail.com', '@openmailbox.org', '@lycos.com');
  foreach($emails as $email) {

    if ( isset($fields[ 'business_email_input' ]) && preg_match( "/$email/", $fields[ 'business_email_input' ] )  ){
        $errors->add( 'validation', 'Please provide a valid Business email.' );
    }
  }
}




function supro_setup() {
	// Sets the content width in pixels, based on the theme's design and stylesheet.
	$GLOBALS['content_width'] = apply_filters( 'supro_content_width', 840 );

	// Make theme available for translation.
	load_theme_textdomain( 'supro', get_template_directory() . '/lang' );

	// Supports WooCommerce plugin.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Theme supports
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
  add_theme_support( 'post-formats', array( 'link' ) );
	add_theme_support(
		'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
		)
	);
  
  // This theme styles the visual editor to resemble the theme style,  specifically font, colors.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Load default block styles.
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'align-full' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

  // Add excerpt to pages
  add_post_type_support( 'page', 'excerpt' );

  // Custom image sizes
	add_image_size( 'supro-blog-grid', 780, 252, true );
	add_image_size( 'supro-blog-grid-small', 380, 176, true );
	add_image_size( 'supro-blog-grid-2', 555, 375, true );
	add_image_size( 'supro-blog-list', 1170, 500, true );
	add_image_size( 'supro-blog-masonry-1', 450, 450, true );
	add_image_size( 'supro-blog-masonry-2', 450, 300, true );
	add_image_size( 'supro-blog-masonry-3', 450, 600, true );
	add_image_size( 'supro-product-masonry-normal', 300, 221, true );
	add_image_size( 'supro-product-masonry-long', 300, 441, true );

	// Register theme nav menu
	register_nav_menus(
		array(
			'primary'     => esc_html__( 'Primary Left Menu', 'supro' ),
			'primary2'     => esc_html__( 'Primary Right Menu', 'supro' ),
			'user_logged' => esc_html__( 'User Logged Menu', 'supro' ),
		)
	);

	if ( is_admin() ) {
		new Supro_Meta_Box_Product_Data;
	}
}
add_action( 'after_setup_theme', 'supro_setup', 100 );


// add post-formats to post_type 'page'
function sg_custom_post_formats_setup() {
  add_post_type_support( 'post', 'post-formats' );
}
add_action( 'init', 'sg_custom_post_formats_setup' );


function supro_init() {
	global $supro_woocommerce;
  
	$supro_woocommerce = new Supro_WooCommerce;
}
add_action( 'wp_loaded', 'supro_init' );


/**
 * Register widgetized area and update sidebar with default widgets.
 *
 * @since 1.0
 *
 * @return void
 */
function supro_register_sidebar() {
	$sidebars = array(
		'topbar-left'     => esc_html__( 'Topbar Left', 'supro' ),
		'topbar-right'    => esc_html__( 'Topbar Right', 'supro' ),
		'topbar-mobile'   => esc_html__( 'Mobile Topbar', 'supro' ),
		'blog-sidebar'    => esc_html__( 'Blog Sidebar', 'supro' ),
		'menu-sidebar'    => esc_html__( 'Mobile Menu Sidebar (Top)', 'supro' ),
		'catalog-sidebar' => esc_html__( 'Catalog Sidebar', 'supro' ),
		'product-sidebar' => esc_html__( 'Product Sidebar', 'supro' ),
		'catalog-filter'  => esc_html__( 'Catalog Filter', 'supro' ),
		'attribute-page'  => esc_html__( 'Attribute Page Sidebar', 'supro' ),
    'sample-box-product'  => esc_html__( 'Sample Box Sidebar', 'supro' ),

	);

	// Register sidebars
	foreach ( $sidebars as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'description'   => esc_html__( 'Add widgets here in order to display on pages', 'supro' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Mobile Menu (Right)', 'supro' ),
			'id'            => 'mobile-menu-sidebar',
			'description'   => esc_html__( 'Add widgets here in order to display menu sidebar on mobile', 'supro' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	// Register footer sidebars
	for ( $i = 1; $i <= 5; $i ++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget', 'supro' ) . " $i",
				'id'            => "footer-sidebar-$i",
				'description'   => esc_html__( 'Add widgets here in order to display on footer', 'supro' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h6 class="footer-title">',
				'after_title'   => '</h6>',
			)
		);
	}

	// Register footer sidebars
	for ( $i = 1; $i <= 3; $i ++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Copyright', 'supro' ) . " $i",
				'id'            => "footer-copyright-$i",
				'description'   => esc_html__( 'Add widgets here in order to display on footer', 'supro' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
  
  register_sidebar( array(
    'name' => __( 'Header Sidebar', 'smallenvelop' ),
    'id' => 'header-sidebar',
    'before_widget' => '<div>',
    'after_widget' => '</div>',
    'before_title' => '<h1>',
    'after_title' => '</h1>',
  ) );
}
add_action( 'widgets_init', 'supro_register_sidebar' );


/**
 * Load theme
 */
load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/shortcodes.php' );

// Frontend functions and shortcodes
require get_template_directory() . '/inc/functions/nav.php';
require get_template_directory() . '/inc/functions/entry.php';
require get_template_directory() . '/inc/functions/header.php';
require get_template_directory() . '/inc/functions/comments.php';
require get_template_directory() . '/inc/functions/breadcrumbs.php';
require get_template_directory() . '/inc/functions/footer.php';
require get_template_directory() . '/inc/functions/layout.php';
require get_template_directory() . '/inc/functions/style.php';

// Frontend hooks
require get_template_directory() . '/inc/frontend/layout.php';
require get_template_directory() . '/inc/frontend/header.php';
require get_template_directory() . '/inc/frontend/footer.php';
require get_template_directory() . '/inc/frontend/nav.php';
require get_template_directory() . '/inc/frontend/entry.php';
require get_template_directory() . '/inc/mega-menu/class-mega-menu-walker.php';
require get_template_directory() . '/inc/frontend/maintenance.php';

// Customizer
require get_template_directory() . '/inc/backend/customizer.php';

// Woocommerce hooks
require get_template_directory() . '/inc/frontend/woocommerce.php';

if ( is_admin() ) {
	require get_template_directory() . '/inc/backend/meta-boxes.php';
	require get_template_directory() . '/inc/mega-menu/class-mega-menu.php';
	require get_template_directory() . '/inc/backend/product-meta-box-data.php';
	require get_template_directory() . '/inc/backend/ajax.php';
}


// Initialize Visual Composer as part of the theme
if ( function_exists('vc_set_as_theme') ) {
	vc_set_as_theme( true );

	// Disable front end editor
	vc_disable_frontend();

	// Remove Brainstormforce link in Dashboard & Nag message
	define( 'BSF_UNREG_MENU', true );
	define( 'BSF_7320433_NAG', false );

	// Set custom VC templates DIR
	$vc_res_dir = get_template_directory() . '/vc_templates/';
	vc_set_shortcodes_templates_dir( $vc_res_dir );

	// Call custom method that extends VC shortcodes
	load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc_shortcodes.php' );

	// Extend VC
	boc_extend_VC_shortcodes();

	// Remove VC default modules
	boc_modify_default_VC_modules();

	// Set VC by default for Page & Portfolio post types
	// vc_set_default_editor_post_types(array('page',	'portfolio'));
	vc_set_default_editor_post_types( array('page') );

	// Replace VC waypoints, we'll use our own in libs.js
	function boc_remove_VC_default_waypoints() {
		// Dequeue VC waypoints.js that is dynamically included when an animated element is found
		wp_deregister_script( 'waypoints' );
	}
	add_action( 'vc_base_register_front_js', 'boc_remove_VC_default_waypoints', 100 );
}


// this is called from add_action( 'wp_footer', 'print_my_inline_script' ); that was placed in some of the VC shortcodes
// also using global $myscript;
function print_my_inline_script() {
	global $myscript;
  echo $myscript;
}


// remove emojies
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


function remove_block_css() {
  wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );


// Enqueue BOC Styles
function boc_styles() {
  wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'boc_styles' );


// Enqueue fixing styles 
function fixing_styles() {
  wp_enqueue_style( 'fixing-styles', get_stylesheet_directory_uri() . '/css/fixing_styles.css', array(), '1.3.0.0' );
}
add_action( 'wp_enqueue_scripts', 'fixing_styles' );


// Enqueue additional production styles
function additional_prod_styles() {
    $file_path = get_stylesheet_directory() . '/additional-prod-style.css';
    $file_url = get_stylesheet_directory_uri() . '/additional-prod-style.css';

    // Проверка существования файла
    $version = file_exists($file_path) ? filemtime($file_path) : false;

    wp_enqueue_style( 'additional-prod-styles', $file_url, array(), $version );
}
add_action( 'wp_enqueue_scripts', 'additional_prod_styles' );



// Enqueue additional production scripts
function pubsub_script() {
  wp_enqueue_script( 'pubsub-script', get_stylesheet_directory_uri() . '/pubsub.js', array(), '1.0.0.1', false );
  wp_enqueue_script( 'pubsub-script' );
}
add_action( 'wp_enqueue_scripts', 'pubsub_script' );


// Enqueue additional production scripts
function additional_prod_scripts() {
  $weglot_site_language = 'en';
  
  if ( function_exists('weglot_get_current_language') ) {
    $weglot_site_language = weglot_get_current_language();
  }
    
  $sg_ajax_data = array(
    'ajax_url' => admin_url( 'admin-ajax.php' ),
    'site_language' => $weglot_site_language,
  );

  wp_register_script( 'additional-prod-script', get_stylesheet_directory_uri() . '/additional-prod-script.js', array('jquery'), '1.13.0.3', true );
  wp_localize_script( 'additional-prod-script', 'sg_ajax_data', $sg_ajax_data );
  wp_enqueue_script( 'additional-prod-script' );
}
add_action( 'wp_enqueue_scripts', 'additional_prod_scripts', 999);


// Enqueue LinkedIn tracking scripts
function linkedin_tracking_scripts() {
  wp_enqueue_script( 'linkedin_tracking_scripts', get_stylesheet_directory_uri() . '/linkedin-tracking.js', array('jquery'), '1.1.5', true );
}
add_action( 'wp_enqueue_scripts', 'linkedin_tracking_scripts', 999);


function sg_deregister_javascript() {
  if ( !is_admin() ) {
    wp_deregister_script( 'wp-embed' );
  }
}
add_action( 'wp_print_scripts', 'sg_deregister_javascript', 100 );


/* ----------- WooCommerce customizations START ----------- */

// To change add to cart text on single product page
function woocommerce_custom_single_add_to_cart_text() {
  return __( 'Add to Sample Box', 'woocommerce' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );


// To change add to cart text on product archives(Collection) page
function woocommerce_custom_product_add_to_cart_text() {
  return __( 'Add to Sample Box', 'woocommerce' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );


remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );


function my_woocommerce_widget_shopping_cart_button_view_cart() {
  echo 
    '<a href="' . esc_url( wc_get_cart_url() ) . '" class="buttonogs btn_small btn_dark2">' 
      . esc_html__( 'View Sample Box', 'woocommerce' ) 
    . '</a>';
}
add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_button_view_cart', 10 );


function my_woocommerce_widget_shopping_cart_proceed_to_checkout() {
    if ( is_user_logged_in() ) {
        $url = wc_get_checkout_url();
    } else {
        $redirect_to = urlencode( wc_get_checkout_url() );
        $url = wc_get_page_permalink( 'myaccount' ) . '?redirect_to=' . $redirect_to;
    }

    echo '<a href="' . esc_url( $url ) . '" class="wc-forward buttonogs btn_large btn_theme_color">' . esc_html__( 'Get Samples', 'woocommerce' ) . '</a>';
}

add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );


function bbloomer_rename_description_product_tab_label() {
  return esc_html_x( 'Details', 'description product tab label', 'SuperiorGlove' );
}
add_filter( 'woocommerce_product_description_tab_title', 'bbloomer_rename_description_product_tab_label' );


// COMPARE OVERRIDE SELECT 3
//help from https://stackoverflow.com/questions/52023865/searchable-multiple-product-select-custom-field-for-woocommerce

function crp_get_product_related_ids2() {
  global $post, $woocommerce;

  $product_ids = get_post_meta( $post->ID, '_related_ids2', true );
  
  if ( empty($product_ids) )
    $product_ids = array();
  ?>
    <div class="options_group">
      <?php if ( $woocommerce->version >= '3.0' ) : ?>
        <p class="form-field">
          <label for="related_ids2"><?php _e( 'Compare Override (Choose 3 at MOST) ', 'woocommerce' ); ?></label>
          <select 
            name="related_ids2[]" 
            id="related_ids2" 
            class="wc-product-search" 
            multiple="multiple" 
            style="width: 50%;" 
            data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" 
            data-action="woocommerce_json_search_products_and_variations"
          >
            <?php
              foreach ( $product_ids as $product_id ) {
                $product = wc_get_product( $product_id );
                
                if ( is_object($product) ) {
                  echo 
                    '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' 
                      . wp_kses_post( $product->get_formatted_name() ) 
                    . '</option>';
                }
              }
            ?>
          </select> <?php echo wc_help_tip( __( 'Select products you want to show in the compare section.', 'woocommerce' ) ); ?>
        </p>
      <?php endif; ?>
    </div>
  <?php
}

function add_custom_fied_in_product_general_fields() {
  global $post, $woocommerce;
  
  crp_get_product_related_ids2();
}
add_action( 'woocommerce_product_options_general_product_data', 'add_custom_fied_in_product_general_fields', 20 );


function process_product_meta_custom_fied( $product_id ){
  if ( isset($_POST['related_ids2']) ) {
    update_post_meta( $product_id, '_related_ids2', array_map('intval', (array) wp_unslash($_POST['related_ids2'])) );
  } else {
    update_post_meta( $product_id, '_related_ids2', array() );
  }
}
add_action( 'woocommerce_process_product_meta', 'process_product_meta_custom_fied', 20, 1 );


// Disable all payment gateways on the checkout page and replace the "Pay" button by "Place order"
add_filter( 'woocommerce_cart_needs_payment', '__return_false' );


// Remove the additional information tab
function woo_remove_product_tabs( $tabs ) {
  unset( $tabs['additional_information'] );
  return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );


/* ---- WooCommerce customizations: Backend ---- */

// https://stackoverflow.com/questions/23287358/woocommerce-multi-select-for-single-product-field
function woocommerce_wp_select_multiple( $field ) {
  global $thepostid, $post, $woocommerce;

  $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
  $field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
  $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
  $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
  $field['value']         = isset( $field['value'] ) ? $field['value'] : ( get_post_meta( $thepostid, $field['id'], true ) ? get_post_meta( $thepostid, $field['id'], true ) : array() );

  // echo 
  //   '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '">' 
  //     . wp_kses_post( $field['label'] ) 
  //   . '</p>';
  
  // $field['value'] = array_merge( 
  //   explode(',', get_post_meta($thepostid, 'glovesizes', true)), 
  //   explode(',', get_post_meta($thepostid, 'glovelabels', true))
  // );
  
  $field['value'] = array_merge( explode('|', get_post_meta($thepostid, 'supglove_icons', true)) );
  
  foreach ( $field['options'] as $key => $value ) {
    echo 
      '<p class="form-fieldx" style="float: left;">'
        // . '<label for="' . esc_attr( $field['name'] ) . '">' . esc_html( $value ) . '</label>';
        . '<label style="border: 1px solid #ccc; border-radius: 32px; padding: 5px 10px !important; float: left; display: block; margin: 8px; width: auto;">' 
          . '<input type="checkbox" name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $key ) . '"' 
          . ( in_array( $key, $field['value'] ) ? ' checked="checked"' : '' ) . '> ' 
          . esc_attr( $value )  
        . '</label>' 
      . '</p>';
  }

  if ( !empty($field['description']) ) {
    if ( isset($field['desc_tip']) && false !== $field['desc_tip'] ) {
      echo 
        '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' 
        . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
    } else {
      echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
    }
  }
  
  echo '</p>';
}


// Display Fields
function woocommerce_product_custom_fields(){
  global $woocommerce, $post;
  
  echo '<div class="product_custom_field">';
  
  //Custom Product  Textarea
  woocommerce_wp_textarea_input(
    array(
      'id' => '_bhww_prosubtitle',
      'placeholder' => '',
      'label' => __('Subtitle Text', 'woocommerce')
    )
  );
  
  echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields' );


// Save Fields
function woocommerce_product_custom_fields_save($post_id){
  $labels = array();
  
  if ( !empty($_POST['supglove_icons']) ) {
    foreach( $_POST['supglove_icons'] as $check ) {
      // echoes the value set in the HTML form for each checked checkbox.
      // so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
      // in your case, it would echo whatever $row['Report ID'] is equivalent to.
      echo $labels[] = esc_html( $check ); 
    }
  }
  
  update_post_meta( $post_id, '_bhww_prosubtitle', (isset($_POST['_bhww_prosubtitle']) ? esc_html($_POST['_bhww_prosubtitle']) : '') );
  update_post_meta( $post_id, 'supglove_icons', ((!empty($labels) || $labels !== '') ? implode ("|", $labels) : '') );
  update_post_meta( $post_id, 'case_dimensions_in', (isset($_POST['case_dimensions_in']) ? $_POST['case_dimensions_in'] : '') );
  update_post_meta( $post_id, 'ce_en388_certification_code', (isset($_POST['ce_en388_certification_code']) ? $_POST['ce_en388_certification_code'] : '') );
  update_post_meta( $post_id, 'other_ce_certification_codes', (isset($_POST['other_ce_certification_codes']) ? $_POST['other_ce_certification_codes'] : '') );
  update_post_meta( $post_id, 'unspsc_code', (isset($_POST['unspsc_code']) ? $_POST['unspsc_code'] : '') );
  update_post_meta( $post_id, 'weight_in_lbs', (isset($_POST['weight_in_lbs']) ? $_POST['weight_in_lbs'] : '') );
}
add_action( 'woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save' );


//  Custom metabox content in admin product pages
if ( !function_exists('add_custom_product_content_meta_boxd') ) {
  function add_custom_product_content_meta_boxd( $post ) {
    // global $prefix;
    $prefix = '_bhww_'; 
    $specs = get_post_meta( $post->ID, $prefix . 'specsd_wysiwyg', true ) ? get_post_meta( $post->ID, $prefix . 'specsd_wysiwyg', true ) : '';
    $args['textarea_rows'] = 6;

    wp_editor( $specs, 'specsd_wysiwyg', $args );

    echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
  }
}

if ( ! function_exists('create_custom_product_meta_boxd') ) {
  function create_custom_product_meta_boxd() {
    add_meta_box( 
      'custom_product_meta_boxd', 
      __(
        'Details Right Area.  Will add content to the right of main description if used. Content will be 50/50 for the Details tab. <em>(optional)</em>', 
        'cmb'
      ),
      'add_custom_product_content_meta_boxd', 
      'product', 
      'normal', 
      'default' 
    );
  }
}
//add_action( 'add_meta_boxes', 'create_custom_product_meta_boxd' );


//  Custom metabox content in admin product pages
if ( !function_exists('add_custom_content_meta_box') ) {
  function add_custom_content_meta_box( $post ) {
    // global $prefix;
    $prefix = '_bhww_'; 
    $specs = get_post_meta( $post->ID, $prefix . 'specs_wysiwyg', true ) ? get_post_meta( $post->ID, $prefix . 'specs_wysiwyg', true ) : '';
    $args['textarea_rows'] = 6;

    wp_editor( $specs, 'specs_wysiwyg', $args );

    echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
  }
}

// ADD SPECS A-LEFT TAB TO BACKEND
if ( !function_exists('create_custom_meta_box') ) {
  function create_custom_meta_box() {
    add_meta_box( 
      'custom_product_meta_box', 
      __( 'Specs A (Left Content.  Will be full width of tab if Specs B is NOT used) <em>(optional)</em>', 'cmb' ), 
      'add_custom_content_meta_box', 
      'product', 
      'normal', 
      'default' 
    );
  }
}
add_action( 'add_meta_boxes', 'create_custom_meta_box' );


//  Custom metabox content in admin product pages
if ( !function_exists('add_custom_content_meta_boxb') ) {
  function add_custom_content_meta_boxb( $post ) {
    // global $prefix;
    $prefix = '_bhww_'; 
    $specs = get_post_meta( $post->ID, $prefix . 'specsb_wysiwyg', true) ? get_post_meta( $post->ID, $prefix . 'specsb_wysiwyg', true ) : '';
    $args['textarea_rows'] = 6;

    wp_editor( $specs, 'specsb_wysiwyg', $args );

    echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
  }
}

// ADD SPECS B-RIGHT TAB TO BACKEND
if ( !function_exists('create_custom_meta_boxb') ) {
  function create_custom_meta_boxb() {
    add_meta_box( 
      'custom_product_meta_boxb', 
      __( 'Specs B (Right Content) <em>(optional)</em>', 'cmb' ), 
      'add_custom_content_meta_boxb', 
      'product', 
      'normal', 
      'default' 
    );
  }
}
add_action( 'add_meta_boxes', 'create_custom_meta_boxb' );


//  Custom metabox content in admin product pages
if ( !function_exists('add_custom_content_meta_box2') ) {
  function add_custom_content_meta_box2( $post ) {
    // global $prefix;
    $prefix = '_bhww_'; 
    $fitsizing = get_post_meta( $post->ID, $prefix . 'fitsizing_wysiwyg', true ) ? get_post_meta( $post->ID, $prefix . 'fitsizing_wysiwyg', true ) : '';
    $args['textarea_rows'] = 6;
    
    wp_editor( $fitsizing, 'fitsizing_wysiwyg', $args );
    
    echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
  }
}

// ADD FIT SIZING A-LEFT TAB TO BACKEND
// Adding a custom Meta container to admin products pages
if ( !function_exists('create_custom_meta_box2') ) {
  function create_custom_meta_box2() {
    add_meta_box( 
      'custom_product_meta_box2', 
      __( 'Fit and Sizing (Left Content.  Will be full width of tab if Fit and Sizing Right is NOT used)<em>(optional)</em>', 'cmb' ), 
      'add_custom_content_meta_box2', 
      'product', 
      'normal', 
      'default' 
    );
  }
}
add_action( 'add_meta_boxes', 'create_custom_meta_box2' );


//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_box2b' ) ) {
  function add_custom_content_meta_box2b( $post ) {
    // global $prefix;
    $prefix = '_bhww_';
    $fitsizing = get_post_meta( $post->ID, $prefix . 'fitsizingb_wysiwyg', true ) ? get_post_meta( $post->ID, $prefix . 'fitsizingb_wysiwyg', true ) : '';
    $args['textarea_rows'] = 6;
    
    wp_editor( $fitsizing, 'fitsizingb_wysiwyg', $args );
    
    echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
  }
}

// ADD FIT SIZING B-RIGHT TAB TO BACKEND
// Adding a custom Meta container to admin products pages
if ( !function_exists('create_custom_meta_box2b') ) {
  function create_custom_meta_box2b() {
    add_meta_box( 
      'custom_product_meta_box2b', 
      __( 'Fit and Sizing (Right Content) <em>(optional)</em>', 'cmb' ), 
      'add_custom_content_meta_box2b', 
      'product', 
      'normal', 
      'default' 
    );
  }
}
add_action( 'add_meta_boxes', 'create_custom_meta_box2b' );


// Save the data of the Meta field

if ( !function_exists('save_custom_content_meta_box') ) {
  function save_custom_content_meta_box( $post_id ) {
    // global $prefix;
    $prefix = '_bhww_'; 
    
    // We need to verify this with the proper authorization (security stuff).
    
    // Check if our nonce is set.
    if ( !isset($_POST[ 'custom_product_field_nonce' ]) ) {
      return $post_id;
    }
    
    $nonce = $_REQUEST[ 'custom_product_field_nonce' ];
    
    // Verify that the nonce is valid.
    if ( !wp_verify_nonce($nonce) ) {
      return $post_id;
    }
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
      return $post_id;
    }
    
    // Check the user's permissions.
    if ( 'product' == $_POST[ 'post_type' ] ) {
      if ( !current_user_can('edit_product', $post_id) )
        return $post_id;
    } else {
      if ( !current_user_can( 'edit_post', $post_id) )
        return $post_id;
    }
    
    // Sanitize user input and update the meta field in the database.
    update_post_meta( $post_id, $prefix . 'specsd_wysiwyg', (isset($_POST[ 'specsd_wysiwyg' ]) ? wp_kses_post($_POST[ 'specsd_wysiwyg' ]) : '') );
    update_post_meta( $post_id, $prefix . 'specs_wysiwyg', (isset($_POST[ 'specs_wysiwyg' ]) ? wp_kses_post($_POST[ 'specs_wysiwyg' ]) : '') );
    update_post_meta( $post_id, $prefix . 'specsb_wysiwyg', (isset($_POST[ 'specsb_wysiwyg' ]) ? wp_kses_post($_POST[ 'specsb_wysiwyg' ]) : '') );
    update_post_meta( $post_id, $prefix . 'fitsizing_wysiwyg', (isset($_POST[ 'fitsizing_wysiwyg' ]) ? wp_kses_post($_POST[ 'fitsizing_wysiwyg' ]) : '') );
    update_post_meta( $post_id, $prefix . 'fitsizingb_wysiwyg', (isset($_POST[ 'fitsizingb_wysiwyg' ]) ? wp_kses_post($_POST[ 'fitsizingb_wysiwyg' ]) : '') );
  }
}
add_action( 'save_post', 'save_custom_content_meta_box', 10, 1 );


/* ---- WooCommerce customizations: Frontend ---- */

// Add content to custom tab in product single pages (1)
function specs_product_tab_content() {
  global $post, $product;
  
  $product_specs = get_post_meta( $post->ID, '_bhww_specs_wysiwyg', true );
  $product_specsb = get_post_meta( $post->ID, '_bhww_specsb_wysiwyg', true );
  
  if ( !empty($product_specs) && !empty($product_specsb) ) {
    // Updated to apply the_content filter to WYSIWYG content
    echo 
      '<div class="col col-sm-12 col-md-6">' . apply_filters( 'the_content', $product_specs ) . '</div>' 
    . '<div class="col col-sm-12 col-md-6">' . apply_filters( 'the_content', $product_specsb ) . '</div>';
  } else if ( !empty($product_specs) ) {
      echo '<div class="col col-sm-12 col-md-12">' . apply_filters( 'the_content', $product_specs ) . '</div>';
  } else {
    // let's load attributes and meta here
    // echo '<div class="col-xs-12"><h6>' . __( 'Product Specs', 'woocommerce' ) . '</h6></div><div class="clear"></div>';
    wc_display_product_attributes( $product );
  }
}

// Add content to custom tab in product single pages (2)
function fitsizing_product_tab_content() {
  global $post;

  $product_fitsizing = get_post_meta($post->ID, '_bhww_fitsizing_wysiwyg', true);
  $product_fitsizingb = get_post_meta($post->ID, '_bhww_fitsizingb_wysiwyg', true);
  $selectedfit = get_post_meta($post->ID, 'fittabdetails', true);
  global $product;
  $availible_sizes = $product->get_attribute('pa_available_sizes');

  if (!empty($product_fitsizing) && !empty($product_fitsizingb)) {
    // Updated to apply the_content filter to WYSIWYG content
    echo
      '<div class="col col-sm-12 col-md-6">' . apply_filters('the_content', $product_fitsizing)
      . '</div>' . '<div class="col col-sm-12 col-md-6">' . apply_filters('the_content', $product_fitsizingb) . '</div>';
  } else if (!empty($product_fitsizing)) {
    echo '<div class="col col-sm-12 col-md-12">' . apply_filters('the_content', $product_fitsizing) . '</div>';
  } else {
    //load global fit sizing details from customizer options
    if ($selectedfit == 'Gloves' || $selectedfit == 'gloves' || $selectedfit == 'glove' || $selectedfit == 'Glove') {
      $fitleft = wp_kses_post(supro_get_option('fittabdetailsgloveinfo'));
      $fitright = wp_kses_post(supro_get_option('fittabdetailsinfoglovediagram'));
      $fitheader = wp_kses_post(supro_get_option('fittabdetailsgloveheader'));


      if ($fitheader !== '') {
        echo
          '<div class="col col-sm-12 col-md-12">' . $fitheader . '</div>'
          . '<div class="clear"></div>';
      }


      $taxonomy = 'pa_available_sizes';
      $c_sizes = explode(',', $product->get_attribute($taxonomy));
      $size_h = 'SIZE';
      $size_width_m = 'WIDTH (MM)';
      $size_width_in = 'WIDTH (IN)';
      echo 
      '<div class="flex-row-reverse">' . '<div class="col col-sm-12 col-md-6 order-md-2">' . $fitright . '</div>' .
      '<div  class="col col-sm-12 col-md-6 order-md-1 ">' . '<div class="sizes-wrapper">';
      echo '<div class="size-row">' . '<span class="availible_size border_top">' . esc_html($size_h) . '<span class="">' . '</span>' . '</span>' . '<span class="size_mm availible_size border_top ">' . esc_html($size_width_m) . '</span>' . '<span class="size_inch availible_size border_top">' . esc_html($size_width_in) . '</span>' . '</div>';

      foreach ($c_sizes as $actualSize) {
        $c_size = trim(str_replace(" ","",$actualSize));


        if ($c_size == '5' || $c_size == '2XS') {
          $size_mm = '50 MM';
          $size_inches = '2IN';
        } elseif ($c_size == '6' ||  $c_size == 'XS') {
          $size_mm = '63 MM';
          $size_inches = '2.5 IN';
        } elseif ($c_size == '7' || $c_size == 'S') {
          $size_mm = '75 MM';
          $size_inches = '3 IN';
        } elseif ($c_size == 'M' || $c_size == '8' ) {
          $size_mm = '88 MM';
          $size_inches = '3.5 IN';
        } elseif ($c_size == '9' || $c_size == 'L') {
          $size_mm = '101 MM';
          $size_inches = '4 IN';
        }
        elseif ($c_size == '10' || $c_size == 'XL') {
          $size_mm = '113 MM';
          $size_inches = '4.5 IN';
        }
        elseif ($c_size == '11' || $c_size == '2XL') {
          $size_mm = '128 MM';
          $size_inches = '5 IN';
        } 
        elseif ($c_size == '12' || $c_size == '3XL') {
          $size_mm = '140 MM';
          $size_inches = '5.5 IN';
        } 
        elseif ($c_size == '2XL/3XL') {
          $size_mm = '410 - 445 mm';
          $size_inches = '16 - 17.5 IN';
        }

        echo '<div class="size-row">' . '<span class="availible_size size_' . strtolower(trim($c_size)) . '">' . '<span class="size_color">' . trim($c_size) . '</span>' . '</span>' . '<span class="size_mm availible_size ">' . strtolower(trim($size_mm)) . '</span>' . '<span class="size_inch availible_size ">' . strtolower(trim($size_inches)) . '</span>' . '</div>';

      }

      '</div>' . '</div>'. '</div>';

    } elseif ($selectedfit == 'Sleeves' || $selectedfit == 'sleeves') {
      $fitleft = wp_kses_post(supro_get_option('fittabdetailssleeveinfo'));
      $fitright = wp_kses_post(supro_get_option('fittabdetailsinfosleevediagram'));
      $fitheader = wp_kses_post(supro_get_option('fittabdetailssleeveheader'));
      $fitsleevetitle = wp_kses_post(supro_get_option('fitsleevetitle'));
      $fitsleevetext = wp_kses_post(supro_get_option('fitsleevetext'));
      $fitsleevebottomtext = wp_kses_post(supro_get_option('fitsleevebottomtext'));

      if ($fitheader !== '') {
        echo
          '<div class="col col-sm-12 col-md-12">' . $fitheader . '</div>'
          . '<div class="clear"></div>';
      }

      
      $taxonomy = 'pa_available_sizes';
      $c_sizes = explode(',', $product->get_attribute($taxonomy));
      $size_h = 'SIZE';
      $size_width_m = 'WIDTH (MM)';
      $size_width_in = 'WIDTH (IN)';
      foreach ($c_sizes as $actualSize_w) {
        $c_size = trim(str_replace(" ","",$actualSize_w));
        if ($c_size == 'one-size'  || $c_size == 'OneSize') {
          $one_size_box = 'one_size_container';
          
        } 
      }
      echo 
      '<div class="flex-row-reverse '. $one_size_box. '">' . '<div class="col col-sm-12 col-md-6 order-md-2">' . $fitright . '</div>' .
      '<div  class="col col-sm-12 col-md-6 order-md-1 ">' . '<div class="info-wrapper"> <h6>' .$fitsleevetitle . '</h6> <p>' .  $fitsleevetext . '</p> </div>'  .'<div class="sizes-wrapper">';
      echo '<div class="size-row">' . '<span class="availible_size border_top">' . esc_html($size_h) . '<span class="">' . '</span>' . '</span>' . '<span class="size_mm availible_size border_top ">' . esc_html($size_width_m) . '</span>' . '<span class="size_inch availible_size border_top">' . esc_html($size_width_in) . '</span>' . '</div>';

      foreach ($c_sizes as $actualSize) {
        $c_size = trim(str_replace(" ","",$actualSize));


        if ($c_size == '5' || $c_size == '2XS') {
          $size_mm = '250 MM';
          $size_inches = '9.75 IN';
        } elseif ($c_size == '6' ||  $c_size == 'XS') {
          $size_mm = '260 MM';
          $size_inches = '10.25 IN';
        } elseif ($c_size == '7' || $c_size == 'S') {
          $size_mm = '270 MM';
          $size_inches = '10.5 IN';
        } elseif ($c_size == 'M' || $c_size == '8' ) {
          $size_mm = '280 MM';
          $size_inches = '11 IN';
        } elseif ($c_size == '9' || $c_size == 'L') {
          $size_mm = '295 MM';
          $size_inches = '11.5 IN';
        }
        elseif ($c_size == '10' || $c_size == 'XL') {
          $size_mm = '380 MM';
          $size_inches = '15 IN';
        }
        elseif ($c_size == '11' || $c_size == '2XL') {
          $size_mm = '410 MM';
          $size_inches = '16 IN';
        } 
        elseif ( $c_size == '3XL') {
          $size_mm = '445 MM';
          $size_inches = '17 IN';
        } 
        elseif ($c_size == '2XS/XS' || $c_size == '2xs-xs') {
          $size_mm = '250 - 260 mm';
          $size_inches = '9.75 - 10.25 IN';
        }
        elseif ($c_size == 'XS/S' || $c_size == 'xs-s' ) {
          $size_mm = '260 - 270 mm';
          $size_inches = '10.25 - 10.5 IN';
        }
        elseif ($c_size == 'S/M') {
          $size_mm = '270 - 280 mm';
          $size_inches = '11.75 IN';
        }
        elseif ($c_size == 'M/L' ) {
          $size_mm = '280 - 295 mm';
          $size_inches = '11 - 11.5 IN';
        }
        elseif ($c_size == 'L/XL' ) {
          $size_mm = '295 - 380 mm';
          $size_inches = '11.5 - 15 IN';
        } 
        elseif ($c_size == 'XL/2XL') {
          $size_mm = '380 - 410 mm';
          $size_inches = '15 - 16 IN';
        } 
        elseif ($c_size == '2XL/3XL') {
          $size_mm = '410 - 445 mm';
          $size_inches = '16 - 17.5 IN';
        } 
        elseif ($c_size == 'one-size'  || $c_size == 'OneSize') {
          $size_mm = 'One Size Fits Most';
          $size_one = 'One Size';
        } 
     
        

        echo '<div class="size-row">' . '<span class="availible_size size_' . strtolower(str_replace("/", "", $c_size)) . '">' . '<span class="size_color">' . ($c_size == 'OneSize' ? 'One Size' : $c_size). '</span>' . '</span>' . '<span class="size_mm availible_size ">' . strtolower(trim($size_mm)) . '</span>' . '<span class="size_inch availible_size ">' . strtolower(trim($size_inches)) . '</span>' . '</div>';
        
      }
echo
      '</div>' ;
       echo '<div class ="fitsleevebottomtext"> <p>'  .  $fitsleevebottomtext .'</p> </div>' . '</div>' . '</div>' ;
    } elseif ( $selectedfit == 'Other' || $selectedfit == 'other' ) {
      $fitleft = wp_kses_post( supro_get_option('fittabdetailsotherinfo') );
      $fitright = wp_kses_post( supro_get_option('fittabdetailsinfootherdiagram') );
      $fitheader = wp_kses_post( supro_get_option('fittabdetailsotherheader') );
      
      if ( $fitheader !== '' ) {
        echo 
          '<div class="col col-sm-12 col-md-12">' . $fitheader . '</div>' 
        . '<div class="clear"></div>';
      }
      
      echo 
        '<div class="col col-sm-6 col-md-6">' . $fitleft . '</div>' 
      . '<div class="col col-sm-6 col-md-6">' . $fitright . '</div>';
    } else {
      // NONE Selected
      echo '';
    }
  }
}

// Create custom tabs in product single pages
function custom_product_tabs( $tabs ) {
  global $post;
  
  $product_specs = get_post_meta( $post->ID, '_bhww_specs_wysiwyg', true );
  $product_fitsizing = get_post_meta( $post->ID, '_bhww_fitsizing_wysiwyg', true );
  $selectedfitset = get_post_meta( $post->ID, 'fittabdetails', true );
  
  $tabs['specs_tab'] = array(
    'title'    => __( 'Specs', 'woocommerce' ),
    'priority' => 45,
    'callback' => 'specs_product_tab_content'
  );
  
  if ( $selectedfitset !== '' ) {
    $tabs['fitsizing_tab'] = array(
      'title'    => __(  'Fit & Sizing', 'woocommerce' ),
      'priority' => 50,
      'callback' => 'fitsizing_product_tab_content'
    );
  }
  
  return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'custom_product_tabs' );


/**
* @snippet       Display FREE if Price Zero or Empty - WooCommerce Single Product
* @how-to        Get CustomizeWoo.com FREE
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 3.8
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/
function bbloomer_price_free_zero_empty( $price, $product ) {
  if ( '' === $product->get_price() || 0 == $product->get_price() ) {
    $price = '';
  }
  
  return $price;
}
add_filter( 'woocommerce_get_price_html', 'bbloomer_price_free_zero_empty', 9999, 2 );


function custom_remove_downloads_my_account( $items ) {
  unset( $items['downloads'] );
  return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_remove_downloads_my_account', 999 );


// remove Total column
function sg_remove_my_orders_total_col( $columns ) {
  unset( $columns['order-total'] ); 
  return $columns;
}
add_filter( 'woocommerce_my_account_my_orders_columns','sg_remove_my_orders_total_col' );


/**
 * Allows to remove products in checkout page.
 *
 * @param string $product_name
 * @param array $cart_item
 * @param string $cart_item_key
 * @return string
 https://lionplugins.com/blog/remove-products-checkout-page/
 */
function lionplugins_woocommerce_checkout_remove_item( $product_name, $cart_item, $cart_item_key ) {
	if ( is_checkout() && !is_wc_endpoint_url('order-received') ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        $enquired_product = get_post_meta($_product->get_id(), '_enquired_product', true) == 'yes';
        $enquired_start = '';
        $enquired_end = '';
        if($enquired_product){
            $enquired_start = ' <span style="color: red">';
            $enquired_end = ' *<span>';
        }

		$thumbnail = $_product->get_image();
    $is_visible = $_product && $_product->is_visible();
    
		// $product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $_product->get_permalink( $cart_item ) : '', $cart_item, $order );
		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $is_visible ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

    // Add wrapper to image and add some css
    $image = 
      '<div class="ts-product-image">' 
      . '<div class="innexercheck">' 
        . '<a href="' .	esc_url( $product_permalink ) . '" class="product-url">' . $thumbnail . '</a>' 
      . '</div>' 
    . '</div>';
    
    $quickdetails = '<a href="'.$product_permalink .'" class="product-url-quick">' . __( 'View Items Details', 'SuperiorGlove' ) . '</a>';
    
		return 
      $image 
    . '<div class="cartitmedet">' 
      . '<div class="cartitmedetinner">'
        . $product_name . '<br/>'
        . '<h6 class="sku">' . __( 'PRODUCT ID: ', 'SuperiorGlove' ).$enquired_start . $_product->get_sku() .	$enquired_end .'</h6>'
        . $quickdetails 
      . '</div>' 
    . '</div>';
	}

	return $product_name;
}
add_filter( 'woocommerce_cart_item_name', 'lionplugins_woocommerce_checkout_remove_item', 10, 3 );


function lionplugins_woocommerce_checkout_remove_item2( $product_name, $cart_item, $cart_item_key ) {
	if ( is_checkout() && !is_wc_endpoint_url('order-received') ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
    
		$thumbnail = $_product->get_image();
    
    // Add wrapper to image and add some css
    $image = 
      '<div class="ts-product-image" style="width: 52px; height: 45px; display: inline-block; padding-right: 7px; vertical-align: middle;">'
        . $thumbnail 
    . '</div>';
    
		$remove_link = apply_filters( 
      'woocommerce_cart_item_remove_link', 
      sprintf(
        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon icon-uni4D"></i></a>',
        esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
        __( 'Remove this item', 'woocommerce' ),
        esc_attr( $product_id ),
        esc_attr( $_product->get_sku() )
      ), 
      $cart_item_key 
    );
    
		return '<span>' . $remove_link . '</span>';
	}

	return $product_name;
}
add_filter( 'woocommerce_cart_item_name2', 'lionplugins_woocommerce_checkout_remove_item2', 10, 3 );


// make sure the priority value is correct, running after the default priority.
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 20 );


function woo_custom_order_button_text() {
  return __( 'Request Samples', 'woocommerce' );
}
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' );


remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );

function custom_empty_cart_message() {
  $html = 
    '<div class="col-12">' 
    . '<p class="woocommerce-error">' 
      . wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your box  is currently empty.', 'woocommerce' ) ) ) 
    . '</p>' 
  . '</div>';
  
  echo $html ;
}
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );


/*
function custom_tab_template() {
  $tabs = apply_filters( 'woocommerce_product_tabs', array() );

	if ( !empty($tabs) ) : ?>
    <div class="woocommerce-tabs wc-tabs-wrapper">
      <ul class="tabs wc-tabs resp-tabs-list" role="tablist">
        <?php foreach ( $tabs as $key => $tab ) : ?>
          <li 
            id="tab-title-<?php echo esc_attr( $key ); ?>" 
            class="<?php echo esc_attr( $key ); ?>_tab" 
            role="tab" 
            aria-controls="tab-<?php echo esc_attr( $key ); ?>"
          >
            <a href="#tab-<?php echo esc_attr( $key ); ?>"><?php 
              echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); 
            ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="resp-tabs-container">
        <?php foreach ( $tabs as $key => $tab ) : ?>
          <div 
            id="tab-<?php echo esc_attr( $key ); ?>" 
            class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" 
            role="tabpanel" 
            aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>"
          >
            <?php call_user_func( $tab['callback'], $key, $tab ); ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
	<?php endif;
}
add_action( 'woocommerce_after_single_product_summary','custom_tab_template', 30 );
*/


function so_33134668_product_validation( $valid, $product_id, $quantity ) {
  // Set the max number of products before checking out
  $max_num_products = 3;
  
  // Get the Cart's total number of products
  $cart_num_products = WC()->cart->cart_contents_count;

  $future_quantity_in_cart = $cart_num_products + $quantity;

  // More than 5 products in the cart is not allowed
  if ( $future_quantity_in_cart > $max_num_products ) {
    // Display our error message
    wc_add_notice( 
      '<a href="' . wc_get_cart_url() . '" class="button wc-forward">' . __( 'View Sample Box', 'SuperiorGlove' ) . '</a> ' 
      . '<strong>' 
        . __( 
          'Sorry! Right now we only allow a maximum of 3 products to be added to your sample box. ' 
            . 'If you\'d like to add this product please go to your sample box and remove a product.', 
          'SuperiorGlove' 
        ) 
      . '</strong>',  
      'error' 
    );
    
    // don't add the new product to the cart
    $valid = false; 
  }
  
  return $valid;
}
add_filter( 'woocommerce_add_to_cart_validation', 'so_33134668_product_validation', 10, 3 );


function add_wooclass_tosearch_templates( $classes ) {
  if ( is_page_template('searchpage.php') ) {
    $classes[] = 'woocommerce';
  }
  
  return $classes;
}
add_filter('body_class', 'add_wooclass_tosearch_templates');


//disable undo message when removing items
add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');


function custom_override_checkout_fields( $fields ) {
  global $woocommerce;
  
  $cart_items = $woocommerce->cart->get_cart();
  
  if ( $cart_items ) {
    $count = 1;
    
    foreach ( $cart_items as $values ) {
      $_product =  wc_get_product( $values['data']->get_id() );
      
      $sku_array[] = $_product->get_sku();
      
      $fields['billing']['product_sku_' . $count]['default'] = $_product->get_sku();
      $fields['billing']['product_sku_' . $count]['label'] = sprintf( esc_html__( 'ProductSKU %u', 'SuperiorGlove' ), $count );
      $fields['billing']['product_sku_' . $count]['class'] = ['hidden_field'];
      
      $count++;
    }
  };
  
  return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );


function glove_custom_checkout_field_update_order_meta( $order_id ) {
  global $woocommerce;
  
  $cart_items = $woocommerce->cart->get_cart();
  
  if ( $cart_items ) {
    $count = 1;
    
    foreach ( $cart_items as $values ) {
      if ( !empty( $_POST['product_sku_' . $count]) ) {
        update_post_meta( $order_id, 'product_sku_' . $count, sanitize_text_field( $_POST['product_sku_' . $count] ) );
      } else {
        update_post_meta( $order_id, 'product_sku_' . $count, '' );
      }
      
      $count++;
    }
  }
}
add_action( 'woocommerce_checkout_update_order_meta', 'glove_custom_checkout_field_update_order_meta' );


function glove_custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
  global $woocommerce;
  
  $cart_items = $woocommerce->cart->get_cart();
  
  if ( $cart_items ) {
    $count = 1;
    
    foreach ( $cart_items as $values ) {
      $fields['product_sku_' . $count] = array(
        'label' => sprintf( esc_html__('ProductSKU %u', 'SuperiorGlove'), $count ),
        'value' => get_post_meta( $order->id, 'product_sku_' . $count, true ),
      );
      
      $count++;
    }
  }
  
  return $fields;
}
add_filter( 'woocommerce_email_order_meta_fields', 'glove_custom_woocommerce_email_order_meta_fields', 10, 3 );


function glove_get_attachment_by_post_name( $post_name ) {
  $args = array(
    'posts_per_page' => -1,
    'numberposts' => -1,
    'post_type' => 'attachment',
    'name' => trim( $post_name )
  );
  
  $get_attachment = new WP_Query( $args );
  
  if ( ! $get_attachment || ! isset( $get_attachment->posts, $get_attachment->posts[0] ) ) {
    return false;
  }
  
  return $get_attachment->posts[0];
}

function glove_replace_image() {
  $args = [
    'post_type' => 'product',
    'numberposts' => -1,
    'post_per_page' => -1,
  ];
  
  $posts = get_posts($args);

  if ( $posts ) {
    foreach ( $posts as $post ) {
      $thumbn_id = get_post_thumbnail_id( $post->ID );
      $image_data = wp_get_attachment_image_src( $thumbn_id, 'full' );
      
      if ( $image_data[2] === 0 ) {
        $sku = get_post_meta( $post->ID, '_sku', true );
        $attachment = glove_get_attachment_by_post_name( strtolower($sku) . '-top' );
        
        if ( $attachment ) {
          $attachment_id = $attachment->ID;
          
          set_post_thumbnail( $post->ID, $attachment_id );
        }
      }
    }
  }
}
// glove_replace_image();

function glove_replace_gallery_image() {
  $args = [
    'post_type' => 'product',
    'numberposts' => -1,
    'post_per_page' => -1,
  ];
  
  $posts = get_posts($args);
  
  if ( $posts ) {
    foreach ( $posts as $post ) {
      $product = new WC_product( $post->ID );
      $attachment_ids = $product->get_gallery_image_ids();
      
      if ( !empty($attachment_ids) ) {
        foreach ( $attachment_ids as $attachment_id ) {
          $image_data = wp_get_attachment_image_src( $attachment_id, 'full' );
          
          if ( $image_data[2] === 0 ) {
            $sku = get_post_meta( $post->ID, '_sku', true );
            $attachment = glove_get_attachment_by_post_name( strtolower($sku) . '-palm' );
            
            if ( $attachment ) {
              $attachment_id = $attachment->ID;
              update_post_meta( $post->ID, '_product_image_gallery', $attachment_id );
            } else {
              update_post_meta( $post->ID, '_product_image_gallery', '' );
            }
          }
        }
      } else {
        update_post_meta( $post->ID, '_product_image_gallery', '' );
      }
    }
  }
}
// glove_replace_gallery_image();


function glove_register_tax() {
  if ( !taxonomy_exists( 'pa_hazards' ) ) {
    register_taxonomy( 'pa_hazards', 'product', ['label' => 'Hazards'] );
  }
}
add_action('init', 'glove_register_tax');


function glove_hierarchical_hazards( $data ) {
  $data['hierarchical'] = true;
  
  return $data;
}
add_filter( 'woocommerce_taxonomy_args_pa_hazards', 'glove_hierarchical_hazards' );


function glove_hierarchical_palm_coating( $data ) {
  $data['hierarchical'] = true;
  
  return $data;
}
add_filter( 'woocommerce_taxonomy_args_pa_palm_coating', 'glove_hierarchical_palm_coating' );


function glove_hierarchical_material( $data ) {
  $data['hierarchical'] = true;
  
  return $data;
}
add_filter( 'woocommerce_taxonomy_args_pa_material','glove_hierarchical_material' );


function glove_hierarchical_automatic() {
  global $wpdb;
  
  $attr_taxonomy_label_array = ['Abrasion', 'Arch flash', 'Cold', 'Cut', 'Heat', 'Impact', 'Puncture probe', 'Hypodermic edle'];
  $attr_taxonomy_array = ['abrasion', 'arch_flash', 'hazards_cold', 'cut', 'hazards_heat', 'impact', 'puncture_probe', 'hypodermic_edle'];
  
  if ( is_array($attr_taxonomy_array) ) {
    foreach ( $attr_taxonomy_array as $key => $taxonomy ) {
      $result = $wpdb->get_results( $wpdb->prepare("SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy = %s", 'pa_' . $taxonomy));
      
      if(term_exists($taxonomy, 'pa_hazards')) {
        $term_data = get_term_by('slug', $taxonomy, 'pa_hazards');
      } else {
        $term_data = wp_insert_term( 
          $attr_taxonomy_label_array[ $key ], 
          'pa_hazards', 
          [
            'description' => '',
            'parent'      => 0,
            'slug'        => $taxonomy 
          ] 
        );
      }
      
      $term_parent_id = $term_data->term_id;

      if ( !empty($result) ) {
        foreach ( $result as $child_term_id ) {
          if ( !empty($term_parent_id) ) {
            $update = $wpdb->update(
              $wpdb->prefix . 'term_taxonomy',
              [ 'taxonomy' => 'pa_hazards', 'parent' => $term_parent_id ],
              [ 'term_taxonomy_id' => $child_term_id->term_id ]
            );

            $insert = $wpdb->insert(
              $wpdb->prefix . 'termmeta',
              [ 'term_id' => $child_term_id->term_id, 'meta_key' => 'order_pa_hazards' ]
            );
          }
        }
      }
    }
  }
}
// add_action('init', 'glove_hierarchical_automatic');


function glove_override_country_fields( $countries ) {
  $countries['UM'] = 'United States Minor Outlying Islands';
  $countries['US'] = 'United States';
  $countries['GB'] = 'United Kingdom';
  
  return $countries;
}
add_filter('woocommerce_countries','glove_override_country_fields');


function bbloomer_alter_checkout_fields_after_order( $order_id ) {
  $order = wc_get_order( $order_id );

  $calling_code = WC()->countries->countries[ $order->get_billing_country() ];

  update_post_meta( $order_id, '_billing_country', (!empty($calling_code) ? $calling_code : '') );
  update_post_meta( $order_id, 'billing_country', (!empty($calling_code) ? $calling_code : '') );
}
add_action( 'woocommerce_thankyou', 'bbloomer_alter_checkout_fields_after_order' );


function glove_override_states_fields( $states ) {
  $new_states = [];
  
  if ( $states['MX'] ) {
    foreach( $states['MX'] as $state ) {
      $new_states['MX'][$state] = ucfirst( strtolower($state) );
    }
  }
  
  return $new_states;
}
add_filter('woocommerce_states','glove_override_states_fields');


function before_checkout_create_order( $order, $data ) {
  if ( !empty($data['billing_state']) ) {
    $str = ucfirst( strtolower($data['billing_state']) );
    $data['billing_state'] = $str;
  }
  
  if ( !empty($str) ) {
    $order->set_address(array(
      'state'  => $str,
    ));
  }
}
add_action( 'woocommerce_checkout_create_order', 'before_checkout_create_order' , 20, 2);

/* ----------- WooCommerce customizations END ----------- */


$helpers_dir = get_template_directory() . '/helpers';
require_once( $helpers_dir . '/product_helper.php' );
require_once( $helpers_dir . '/info_tables.php' );


// hide uncategorized posts from the main blog query
function exclude_uncategorized( $query ) {
  if ( $query->is_home() && $query->is_main_query() ) {
    $query->set( 'cat', '-1' );
  }
}
add_action('pre_get_posts', 'exclude_uncategorized');


// Change Action Scheduler default purge to 1 week
function wc_action_scheduler_purge() {
 return WEEK_IN_SECONDS;
}
add_filter( 'action_scheduler_retention_period', 'wc_action_scheduler_purge' );


// Customizer Settings when there is no Kirki plugin installed
if ( ! function_exists('sg_customizer_sanitize_html') ) {
  function sg_customizer_sanitize_html( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
  }
}

if ( ! function_exists('sg_child_customizer') ) {
  function sg_child_customizer( $wp_customize ) {
    if ( class_exists( 'Kirki' ) ) {
			return;
		}
    
    $wp_customize->add_setting( 'checkoutheading', array(
      'type'                  => 'theme_mod',
      'capability'            => 'manage_woocommerce',
      'default'               => '',
      'sanitize_callback'     => 'sanitize_text_field',
      'transport'             => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'checkoutheading', array(
      'settings'        => 'checkoutheading',
      'type'            => 'text',
      'section'         => 'woocommerce_checkout',
      'label'           => esc_html__( 'Checkout Heading', 'supro' ),
      'description'     => esc_html__( 'Custom Heading for the Checkout page.', 'supro' ),
			'tooltip'         => wp_kses_post( esc_html__( 'HTML Not Allowed', 'supro' ) ),
      'priority'        => 70,
    ) );
    
    $wp_customize->add_setting( 'sampleboxheading', array(
      'type'                  => 'theme_mod',
      'capability'            => 'manage_woocommerce',
      'default'               => '',
      'sanitize_callback'     => 'sanitize_text_field',
      'transport'             => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'sampleboxheading', array(
      'settings'        => 'sampleboxheading',
      'type'            => 'text',
      'section'         => 'woocommerce_checkout',
      'label'           => esc_html__( 'Sample Message Heading', 'supro' ),
      'description'     => esc_html__( 'Enter Heading for Samples Messages.', 'supro' ),
			'tooltip'         => wp_kses_post( esc_html__( 'HTML Not Allowed', 'supro' ) ),
      'priority'        => 70,
    ) );

    $wp_customize->add_setting( 'sampleboxmessage', array(
      'type'                  => 'theme_mod',
      'capability'            => 'manage_woocommerce',
      'default'               => '',
      'sanitize_callback'     => 'sg_customizer_sanitize_html',
      'transport'             => 'postMessage',
    ) );
    
    $wp_customize->add_control( 'sampleboxmessage', array(
      'settings'        => 'sampleboxmessage',
      'type'            => 'textarea',
      'section'         => 'woocommerce_checkout',
      'label'           => esc_html__( 'Sample Message for Businesses', 'supro' ),
      'description'     => esc_html__( 'Enter Text for Samples Messages.', 'supro' ),
			'tooltip'         => wp_kses_post( esc_html__( 'HTML Allowed', 'supro' ) ),
      'priority'        => 70,
    ) );
  }
}
add_action( 'customize_register', 'sg_child_customizer' );

if ( ! function_exists('sg_child_customizer_preview') ) {
  function sg_child_customizer_preview() {
    if ( class_exists( 'Kirki' ) ) {
			return;
		}
    
    wp_enqueue_script( 
      'sg-child-customizer', 
      get_stylesheet_directory_uri() . '/child-customizer.js', 
      array( 'jquery','customize-preview' ), 
      time(), 
      true 
    );
  }
}
add_action( 'customize_preview_init', 'sg_child_customizer_preview' );


// Custom title for sg_type terms to use it in shortcode nav menu
if ( ! function_exists('sg_add_type_custom_title_field') ) {
  function sg_add_type_custom_title_field( $taxonomy ) {
    ?><div class="form-field term-type_custom_title">
      <label for="type_custom_title"><?php echo esc_html_x( 'Custom Title', 'Type terms custom field', 'SuperiorGlove' ); ?></label>
      <input id="type_custom_title" class="postform" type="text" name="type_custom_title" value="" />
    </div><?php
  }
}
add_action( 'sg_type_add_form_fields', 'sg_add_type_custom_title_field', 10, 2 );

if ( ! function_exists('sg_save_type_custom_title_meta') ) {
  function sg_save_type_custom_title_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_custom_title']) && ('' !== $_POST['type_custom_title']) ) {
      $custom_title = sanitize_text_field( $_POST['type_custom_title'] );
      add_term_meta( $term_id, 'type_custom_title', $custom_title, false );
    } else {
      add_term_meta( $term_id, 'type_custom_title', '', false );
    }
  }
}
add_action( 'created_sg_type', 'sg_save_type_custom_title_meta', 10, 2 );

if ( ! function_exists('sg_edit_type_custom_title_field') ) {
  function sg_edit_type_custom_title_field( $term, $taxonomy ){
    $custom_title = get_term_meta( $term->term_id, 'type_custom_title', true );
    ?><tr class="form-field term-type_custom_title-wrap">
        <th scope="row"><label for="type_custom_title"><?php echo esc_html_x( 'Custom Title', 'Type terms custom field', 'SuperiorGlove' ); ?></label></th>
        <td><input id="type_custom_title" class="postform" type="text" name="type_custom_title" value="<?php echo esc_attr( $custom_title ); ?>"/></td>
    </tr><?php
  }
}
add_action( 'sg_type_edit_form_fields', 'sg_edit_type_custom_title_field', 10, 2 );

if ( ! function_exists('sg_update_type_custom_title_meta') ) {
  function sg_update_type_custom_title_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_custom_title']) && ('' !== $_POST['type_custom_title']) ) {
      $custom_title = sanitize_text_field( $_POST['type_custom_title'] );
      update_term_meta( $term_id, 'type_custom_title', $custom_title );
    } else {
      update_term_meta( $term_id, 'type_custom_title', '' );
    }
  }
}
add_action( 'edited_sg_type', 'sg_update_type_custom_title_meta', 10, 2 );


// Featured image for sg_type terms
if ( ! function_exists('sg_add_type_image_url_field') ) {
  function sg_add_type_image_url_field( $taxonomy ) {
    ?><div class="form-field term-type_featured_image_url">
      <label for="type_featured_image_url"><?php _e('Featured Image URL', 'SuperiorGlove'); ?></label>
      <input id="type_featured_image_url" class="postform" type="url" name="type_featured_image_url" pattern="https://.*" value="" />
    </div><?php
  }
}
add_action( 'sg_type_add_form_fields', 'sg_add_type_image_url_field', 10, 2 );

if ( ! function_exists('sg_save_type_image_url_meta') ) {
  function sg_save_type_image_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_featured_image_url']) && ('' !== $_POST['type_featured_image_url']) ) {
      $image_url = sanitize_url( $_POST['type_featured_image_url'] );
      add_term_meta( $term_id, 'type_featured_image_url', $image_url, false );
    } else {
      add_term_meta( $term_id, 'type_featured_image_url', '', false );
    }
  }
}
add_action( 'created_sg_type', 'sg_save_type_image_url_meta', 10, 2 );

if ( ! function_exists('sg_edit_type_image_url_field') ) {
  function sg_edit_type_image_url_field( $term, $taxonomy ){
    $image_url = get_term_meta( $term->term_id, 'type_featured_image_url', true );
    ?><tr class="form-field term-type_featured_image_url-wrap">
        <th scope="row"><label for="type_featured_image_url"><?php _e('Featured Image URL', 'SuperiorGlove'); ?></label></th>
        <td><input 
            id="type_featured_image_url" 
            class="postform" 
            type="url" 
            name="type_featured_image_url" 
            pattern="https://.*" 
            value="<?php echo esc_attr( $image_url ); ?>" 
        /></td>
    </tr><?php
  }
}
add_action( 'sg_type_edit_form_fields', 'sg_edit_type_image_url_field', 10, 2 );

if ( ! function_exists('sg_update_type_image_url_meta') ) {
  function sg_update_type_image_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_featured_image_url']) && ('' !== $_POST['type_featured_image_url']) ) {
      $image_url = sanitize_url( $_POST['type_featured_image_url'] );
      update_term_meta( $term_id, 'type_featured_image_url', $image_url );
    } else {
      update_term_meta( $term_id, 'type_featured_image_url', '' );
    }
  }
}
add_action( 'edited_sg_type', 'sg_update_type_image_url_meta', 10, 2 );

// Add featured image URL field for French language on new term form
if ( ! function_exists('sg_add_type_image_url_field_fr') ) {
    function sg_add_type_image_url_field_fr( $taxonomy ) {
        ?><div class="form-field term-type_featured_image_url_fr">
        <label for="type_featured_image_url_fr"><?php _e('Featured Image URL (French)', 'SuperiorGlove'); ?></label>
        <input id="type_featured_image_url_fr" class="postform" type="url" name="type_featured_image_url_fr" pattern="https://.*" value="" />
        </div><?php
    }
}
add_action( 'sg_type_add_form_fields', 'sg_add_type_image_url_field_fr', 10, 2 );

// Save featured image URL meta for French language when a new term is created
if ( ! function_exists('sg_save_type_image_url_meta_fr') ) {
    function sg_save_type_image_url_meta_fr( $term_id, $tt_id ){
        if ( isset($_POST['type_featured_image_url_fr']) && ('' !== $_POST['type_featured_image_url_fr']) ) {
            $image_url = sanitize_url( $_POST['type_featured_image_url_fr'] );
            add_term_meta( $term_id, 'type_featured_image_url_fr', $image_url, false );
        } else {
            add_term_meta( $term_id, 'type_featured_image_url_fr', '', false );
        }
    }
}
add_action( 'created_sg_type', 'sg_save_type_image_url_meta_fr', 10, 2 );

// Add featured image URL field for French language on edit term form
if ( ! function_exists('sg_edit_type_image_url_field_fr') ) {
    function sg_edit_type_image_url_field_fr( $term, $taxonomy ){
        $image_url = get_term_meta( $term->term_id, 'type_featured_image_url_fr', true );
        ?><tr class="form-field term-type_featured_image_url_fr-wrap">
        <th scope="row"><label for="type_featured_image_url_fr"><?php _e('Featured Image URL (French)', 'SuperiorGlove'); ?></label></th>
        <td><input
                    id="type_featured_image_url_fr"
                    class="postform"
                    type="url"
                    name="type_featured_image_url_fr"
                    pattern="https://.*"
                    value="<?php echo esc_attr( $image_url ); ?>"
            /></td>
        </tr><?php
    }
}
add_action( 'sg_type_edit_form_fields', 'sg_edit_type_image_url_field_fr', 10, 2 );

// Update featured image URL meta for French language when a term is edited
if ( ! function_exists('sg_update_type_image_url_meta_fr') ) {
    function sg_update_type_image_url_meta_fr( $term_id, $tt_id ){
        if ( isset($_POST['type_featured_image_url_fr']) && ('' !== $_POST['type_featured_image_url_fr']) ) {
            $image_url = sanitize_url( $_POST['type_featured_image_url_fr'] );
            update_term_meta( $term_id, 'type_featured_image_url_fr', $image_url );
        } else {
            update_term_meta( $term_id, 'type_featured_image_url_fr', '' );
        }
    }
}
add_action( 'edited_sg_type', 'sg_update_type_image_url_meta_fr', 10, 2 );

// Add featured image URL field for Portuguese language on new term form
if ( ! function_exists('sg_add_type_image_url_field_pt') ) {
    function sg_add_type_image_url_field_pt( $taxonomy ) {
        ?><div class="form-field term-type_featured_image_url_pt">
        <label for="type_featured_image_url_pt"><?php _e('Featured Image URL (Portuguese)', 'SuperiorGlove'); ?></label>
        <input id="type_featured_image_url_pt" class="postform" type="url" name="type_featured_image_url_pt" pattern="https://.*" value="" />
        </div><?php
    }
}
add_action( 'sg_type_add_form_fields', 'sg_add_type_image_url_field_pt', 10, 2 );

// Save featured image URL meta for Portuguese language when a new term is created
if ( ! function_exists('sg_save_type_image_url_meta_pt') ) {
    function sg_save_type_image_url_meta_pt( $term_id, $tt_id ){
        if ( isset($_POST['type_featured_image_url_pt']) && ('' !== $_POST['type_featured_image_url_pt']) ) {
            $image_url = sanitize_url( $_POST['type_featured_image_url_pt'] );
            add_term_meta( $term_id, 'type_featured_image_url_pt', $image_url, false );
        } else {
            add_term_meta( $term_id, 'type_featured_image_url_pt', '', false );
        }
    }
}
add_action( 'created_sg_type', 'sg_save_type_image_url_meta_pt', 10, 2 );

// Add featured image URL field for Portuguese language on edit term form
if ( ! function_exists('sg_edit_type_image_url_field_pt') ) {
    function sg_edit_type_image_url_field_pt( $term, $taxonomy ){
        $image_url = get_term_meta( $term->term_id, 'type_featured_image_url_pt', true );
        ?><tr class="form-field term-type_featured_image_url_pt-wrap">
        <th scope="row"><label for="type_featured_image_url_pt"><?php _e('Featured Image URL (Portuguese)', 'SuperiorGlove'); ?></label></th>
        <td><input
                    id="type_featured_image_url_pt"
                    class="postform"
                    type="url"
                    name="type_featured_image_url_pt"
                    pattern="https://.*"
                    value="<?php echo esc_attr( $image_url ); ?>"
            /></td>
        </tr><?php
    }
}
add_action( 'sg_type_edit_form_fields', 'sg_edit_type_image_url_field_pt', 10, 2 );

// Update featured image URL meta for Portuguese language when a term is edited
if ( ! function_exists('sg_update_type_image_url_meta_pt') ) {
    function sg_update_type_image_url_meta_pt( $term_id, $tt_id ){
        if ( isset($_POST['type_featured_image_url_pt']) && ('' !== $_POST['type_featured_image_url_pt']) ) {
            $image_url = sanitize_url( $_POST['type_featured_image_url_pt'] );
            update_term_meta( $term_id, 'type_featured_image_url_pt', $image_url );
        } else {
            update_term_meta( $term_id, 'type_featured_image_url_pt', '' );
        }
    }
}
add_action( 'edited_sg_type', 'sg_update_type_image_url_meta_pt', 10, 2 );

// Add featured image URL field for Spanish language on new term form
if ( ! function_exists('sg_add_type_image_url_field_es') ) {
    function sg_add_type_image_url_field_es( $taxonomy ) {
        ?><div class="form-field term-type_featured_image_url_es">
        <label for="type_featured_image_url_es"><?php _e('Featured Image URL (Spanish)', 'SuperiorGlove'); ?></label>
        <input id="type_featured_image_url_es" class="postform" type="url" name="type_featured_image_url_es" pattern="https://.*" value="" />
        </div><?php
    }
}
add_action( 'sg_type_add_form_fields', 'sg_add_type_image_url_field_es', 10, 2 );

// Save featured image URL meta for Spanish language when a new term is created
if ( ! function_exists('sg_save_type_image_url_meta_es') ) {
    function sg_save_type_image_url_meta_es( $term_id, $tt_id ){
        if ( isset($_POST['type_featured_image_url_es']) && ('' !== $_POST['type_featured_image_url_es']) ) {
            $image_url = sanitize_url( $_POST['type_featured_image_url_es'] );
            add_term_meta( $term_id, 'type_featured_image_url_es', $image_url, false );
        } else {
            add_term_meta( $term_id, 'type_featured_image_url_es', '', false );
        }
    }
}
add_action( 'created_sg_type', 'sg_save_type_image_url_meta_es', 10, 2 );

// Add featured image URL field for Spanish language on edit term form
if ( ! function_exists('sg_edit_type_image_url_field_es') ) {
    function sg_edit_type_image_url_field_es( $term, $taxonomy ){
        $image_url = get_term_meta( $term->term_id, 'type_featured_image_url_es', true );
        ?><tr class="form-field term-type_featured_image_url_es-wrap">
        <th scope="row"><label for="type_featured_image_url_es"><?php _e('Featured Image URL (Spanish)', 'SuperiorGlove'); ?></label></th>
        <td><input
                    id="type_featured_image_url_es"
                    class="postform"
                    type="url"
                    name="type_featured_image_url_es"
                    pattern="https://.*"
                    value="<?php echo esc_attr( $image_url ); ?>"
            /></td>
        </tr><?php
    }
}
add_action( 'sg_type_edit_form_fields', 'sg_edit_type_image_url_field_es', 10, 2 );

// Update featured image URL meta for Spanish language when a term is edited
if ( ! function_exists('sg_update_type_image_url_meta_es') ) {
    function sg_update_type_image_url_meta_es( $term_id, $tt_id ){
        if ( isset($_POST['type_featured_image_url_es']) && ('' !== $_POST['type_featured_image_url_es']) ) {
            $image_url = sanitize_url( $_POST['type_featured_image_url_es'] );
            update_term_meta( $term_id, 'type_featured_image_url_es', $image_url );
        } else {
            update_term_meta( $term_id, 'type_featured_image_url_es', '' );
        }
    }
}
add_action( 'edited_sg_type', 'sg_update_type_image_url_meta_es', 10, 2 );


// Custom archive link for sg_type terms
if ( ! function_exists('sg_add_type_archive_url_field') ) {
  function sg_add_type_archive_url_field( $taxonomy ) {
    ?><div class="form-field term-type_archive_url">
      <label for="type_archive_url"><?php _e('Custom Archive URL', 'SuperiorGlove'); ?></label>
      <input id="type_archive_url" class="postform" type="url" name="type_archive_url" pattern="https://.*" value="" />
    </div><?php
  }
}
add_action( 'sg_type_add_form_fields', 'sg_add_type_archive_url_field', 10, 2 );

if ( ! function_exists('sg_save_type_archive_url_meta') ) {
  function sg_save_type_archive_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_archive_url']) && ('' !== $_POST['type_archive_url']) ) {
      $archive_url = sanitize_url( $_POST['type_archive_url'] );
      add_term_meta( $term_id, 'type_archive_url', $archive_url, false );
    } else {
      add_term_meta( $term_id, 'type_archive_url', '', false );
    }
  }
}
add_action( 'created_sg_type', 'sg_save_type_archive_url_meta', 10, 2 );

if ( ! function_exists('sg_edit_type_archive_url_field') ) {
  function sg_edit_type_archive_url_field( $term, $taxonomy ){
    $archive_url = get_term_meta( $term->term_id, 'type_archive_url', true );
    ?><tr class="form-field term-type_archive_url-wrap">
        <th scope="row"><label for="type_archive_url"><?php _e('Custom Archive URL', 'SuperiorGlove'); ?></label></th>
        <td><input 
            id="type_archive_url" 
            class="postform" 
            type="url" 
            name="type_archive_url" 
            pattern="https://.*" 
            value="<?php echo esc_attr( $archive_url ); ?>" 
        /></td>
    </tr><?php
  }
}
add_action( 'sg_type_edit_form_fields', 'sg_edit_type_archive_url_field', 10, 2 );

if ( ! function_exists('sg_update_type_archive_url_meta') ) {
  function sg_update_type_archive_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_archive_url']) && ('' !== $_POST['type_archive_url']) ) {
      $archive_url = sanitize_url( $_POST['type_archive_url'] );
      update_term_meta( $term_id, 'type_archive_url', $archive_url );
    } else {
      update_term_meta( $term_id, 'type_archive_url', '' );
    }
  }
}
add_action( 'edited_sg_type', 'sg_update_type_archive_url_meta', 10, 2 );


// Custom title for sg_language terms
if ( ! function_exists('sg_add_language_custom_title_field') ) {
  function sg_add_language_custom_title_field( $taxonomy ) {
    ?><div class="form-field term-language_custom_title">
      <label for="language_custom_title"><?php echo esc_html_x( 'Custom Title', 'Language terms custom field', 'SuperiorGlove' ); ?></label>
      <input id="language_custom_title" class="postform" type="text" name="language_custom_title" value="" />
    </div><?php
  }
}
add_action( 'sg_language_add_form_fields', 'sg_add_language_custom_title_field', 10, 2 );

if ( ! function_exists('sg_save_language_custom_title_meta') ) {
  function sg_save_language_custom_title_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_custom_title']) && ('' !== $_POST['language_custom_title']) ) {
      $custom_title = sanitize_text_field( $_POST['language_custom_title'] );
      add_term_meta( $term_id, 'language_custom_title', $custom_title, false );
    } else {
      add_term_meta( $term_id, 'language_custom_title', '', false );
    }
  }
}
add_action( 'created_sg_language', 'sg_save_language_custom_title_meta', 10, 2 );

if ( ! function_exists('sg_edit_language_custom_title_field') ) {
  function sg_edit_language_custom_title_field( $term, $taxonomy ){
    $custom_title = get_term_meta( $term->term_id, 'language_custom_title', true );
    ?><tr class="form-field term-language_custom_title-wrap">
        <th scope="row"><label for="language_custom_title"><?php echo esc_html_x( 'Custom Title', 'Language terms custom field', 'SuperiorGlove' ); ?></label></th>
        <td><input id="language_custom_title" class="postform" type="text" name="language_custom_title" value="<?php echo esc_attr( $custom_title ); ?>"/></td>
    </tr><?php
  }
}
add_action( 'sg_language_edit_form_fields', 'sg_edit_language_custom_title_field', 10, 2 );

if ( ! function_exists('sg_update_language_custom_title_meta') ) {
  function sg_update_language_custom_title_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_custom_title']) && ('' !== $_POST['language_custom_title']) ) {
      $custom_title = sanitize_text_field( $_POST['language_custom_title'] );
      update_term_meta( $term_id, 'language_custom_title', $custom_title );
    } else {
      update_term_meta( $term_id, 'language_custom_title', '' );
    }
  }
}
add_action( 'edited_sg_language', 'sg_update_language_custom_title_meta', 10, 2 );


// Short title for sg_language terms
if ( ! function_exists('sg_add_language_short_title_field') ) {
  function sg_add_language_short_title_field( $taxonomy ) {
    ?><div class="form-field term-language_short_title">
      <label for="language_short_title"><?php echo esc_html_x( 'Short Title', 'Language terms short title field', 'SuperiorGlove' ); ?></label>
      <input id="language_short_title" class="postform" type="text" name="language_short_title" value="" />
    </div><?php
  }
}
add_action( 'sg_language_add_form_fields', 'sg_add_language_short_title_field', 10, 2 );

if ( ! function_exists('sg_save_language_short_title_meta') ) {
  function sg_save_language_short_title_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_short_title']) && ('' !== $_POST['language_short_title']) ) {
      $short_title = sanitize_text_field( $_POST['language_short_title'] );
      add_term_meta( $term_id, 'language_short_title', $short_title, false );
    } else {
      add_term_meta( $term_id, 'language_short_title', '', false );
    }
  }
}
add_action( 'created_sg_language', 'sg_save_language_short_title_meta', 10, 2 );

if ( ! function_exists('sg_edit_language_short_title_field') ) {
  function sg_edit_language_short_title_field( $term, $taxonomy ){
    $short_title = get_term_meta( $term->term_id, 'language_short_title', true );
    ?><tr class="form-field term-language_short_title-wrap">
        <th scope="row"><label for="language_short_title"><?php echo esc_html_x( 'Short Title', 'Language terms short title field', 'SuperiorGlove' ); ?></label></th>
        <td><input id="language_short_title" class="postform" type="text" name="language_short_title" value="<?php echo esc_attr( $short_title ); ?>"/></td>
    </tr><?php
  }
}
add_action( 'sg_language_edit_form_fields', 'sg_edit_language_short_title_field', 10, 2 );

if ( ! function_exists('sg_update_language_short_title_meta') ) {
  function sg_update_language_short_title_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_short_title']) && ('' !== $_POST['language_short_title']) ) {
      $short_title = sanitize_text_field( $_POST['language_short_title'] );
      update_term_meta( $term_id, 'language_short_title', $short_title );
    } else {
      update_term_meta( $term_id, 'language_short_title', '' );
    }
  }
}
add_action( 'edited_sg_language', 'sg_update_language_short_title_meta', 10, 2 );


// Code for sg_language terms
if ( ! function_exists('sg_add_language_code_field') ) {
  function sg_add_language_code_field( $taxonomy ) {
    ?><div class="form-field term-language_code">
      <label for="language_code"><?php echo esc_html_x( 'Language Code', 'Language terms code field', 'SuperiorGlove' ); ?></label>
      <input id="language_code" class="postform" type="text" name="language_code" value="" />
    </div><?php
  }
}
add_action( 'sg_language_add_form_fields', 'sg_add_language_code_field', 10, 2 );

if ( ! function_exists('sg_save_language_code_meta') ) {
  function sg_save_language_code_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_code']) && ('' !== $_POST['language_code']) ) {
      $code = sanitize_text_field( $_POST['language_code'] );
      add_term_meta( $term_id, 'language_code', $code, false );
    } else {
      add_term_meta( $term_id, 'language_code', '', false );
    }
  }
}
add_action( 'created_sg_language', 'sg_save_language_code_meta', 10, 2 );

if ( ! function_exists('sg_edit_language_code_field') ) {
  function sg_edit_language_code_field( $term, $taxonomy ){
    $code = get_term_meta( $term->term_id, 'language_code', true );
    ?><tr class="form-field term-language_code-wrap">
        <th scope="row"><label for="language_code"><?php echo esc_html_x( 'Language Code', 'Language terms short field', 'SuperiorGlove' ); ?></label></th>
        <td><input id="language_code" class="postform" type="text" name="language_code" value="<?php echo esc_attr( $code ); ?>"/></td>
    </tr><?php
  }
}
add_action( 'sg_language_edit_form_fields', 'sg_edit_language_code_field', 10, 2 );

if ( ! function_exists('sg_update_language_code_meta') ) {
  function sg_update_language_code_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_code']) && ('' !== $_POST['language_code']) ) {
      $code = sanitize_text_field( $_POST['language_code'] );
      update_term_meta( $term_id, 'language_code', $code );
    } else {
      update_term_meta( $term_id, 'language_code', '' );
    }
  }
}
add_action( 'edited_sg_language', 'sg_update_language_code_meta', 10, 2 );

// Custom archive link for sg_language terms
if ( ! function_exists('sg_add_language_archive_url_field') ) {
  function sg_add_language_archive_url_field( $taxonomy ) {
    ?><div class="form-field term-language_archive_url">
      <label for="language_archive_url"><?php _e('Custom Archive URL', 'SuperiorGlove'); ?></label>
      <input id="language_archive_url" class="postform" type="url" name="language_archive_url" pattern="https://.*" value="" />
    </div><?php
  }
}
add_action( 'sg_language_add_form_fields', 'sg_add_language_archive_url_field', 10, 2 );

if ( ! function_exists('sg_save_language_archive_url_meta') ) {
  function sg_save_language_archive_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_archive_url']) && ('' !== $_POST['language_archive_url']) ) {
      $archive_url = sanitize_url( $_POST['language_archive_url'] );
      add_term_meta( $term_id, 'language_archive_url', $archive_url, false );
    } else {
      add_term_meta( $term_id, 'language_archive_url', '', false );
    }
  }
}
add_action( 'created_sg_language', 'sg_save_language_archive_url_meta', 10, 2 );

if ( ! function_exists('sg_edit_language_archive_url_field') ) {
  function sg_edit_language_archive_url_field( $term, $taxonomy ){
    $archive_url = get_term_meta( $term->term_id, 'language_archive_url', true );
    ?><tr class="form-field term-language_archive_url-wrap">
        <th scope="row"><label for="language_archive_url"><?php _e('Custom Archive URL', 'SuperiorGlove'); ?></label></th>
        <td><input 
            id="language_archive_url" 
            class="postform" 
            type="url" 
            name="language_archive_url" 
            pattern="https://.*" 
            value="<?php echo esc_attr( $archive_url ); ?>" 
        /></td>
    </tr><?php
  }
}
add_action( 'sg_language_edit_form_fields', 'sg_edit_language_archive_url_field', 10, 2 );

if ( ! function_exists('sg_update_language_archive_url_meta') ) {
  function sg_update_language_archive_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['language_archive_url']) && ('' !== $_POST['language_archive_url']) ) {
      $archive_url = sanitize_url( $_POST['language_archive_url'] );
      update_term_meta( $term_id, 'language_archive_url', $archive_url );
    } else {
      update_term_meta( $term_id, 'language_archive_url', '' );
    }
  }
}
add_action( 'edited_sg_language', 'sg_update_language_archive_url_meta', 10, 2 );


// Language settings for posts and pages
if ( ! function_exists('sg_language_meta_boxes') ) {
  function sg_language_meta_boxes( $meta_boxes ) {
    $prefix = 'sg_';

    $meta_boxes[] = [
      'title'      => esc_html__( 'Language settings', 'SuperiorGlove' ),
      'id'         => 'sg_language_settings',
      'post_types' => ['post', 'page'],
      'context'    => 'normal',
      'priority'   => 'low',
      'fields'     => [
        [
          'type' => 'url',
          'name' => esc_html__( 'English post URL', 'SuperiorGlove' ),
          'id'   => $prefix . 'english_post_url',
        ],
        [
          'type' => 'url',
          'name' => esc_html__( 'French post URL', 'SuperiorGlove' ),
          'id'   => $prefix . 'french_post_url',
        ],
        [
          'type' => 'url',
          'name' => esc_html__( 'Portuguese post URL', 'SuperiorGlove' ),
          'id'   => $prefix . 'portuguese_post_url',
        ],
        [
          'type' => 'url',
          'name' => esc_html__( 'Spanish post URL', 'SuperiorGlove' ),
          'id'   => $prefix . 'spanish_post_url',
        ],
      ],
    ];

    return $meta_boxes;
  }
}
add_filter( 'rwmb_meta_boxes', 'sg_language_meta_boxes' );


// Fields for custom post and page titles
if ( ! function_exists('sg_post_page_custom_titles_subtitles') ) {
    function sg_post_page_custom_titles_subtitles( $meta_boxes ) {
        $prefix = 'sg_';

        $meta_boxes[] = [
            'title'      => esc_html__( 'Custom Titles', 'SuperiorGlove' ),
            'id'         => 'sg_titles_settings',
            'post_types' => ['post', 'page'],
            'context'    => 'normal',
            'priority'   => 'high',
            'fields'     => [
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Title (English)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_title',
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Subtitle (English)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_subtitle',
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Title (French)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_title_fr',
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Subtitle (French)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_subtitle_fr',
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Title (Portuguese)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_title_pt',
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Subtitle (Portuguese)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_subtitle_pt',
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Title (Spanish)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_title_es',
                ],
                [
                    'type' => 'text',
                    'name' => esc_html__( 'Subtitle (Spanish)', 'SuperiorGlove' ),
                    'id'   => $prefix . 'post_custom_subtitle_es',
                ],
            ],
        ];

        return $meta_boxes;
    }
}
add_filter( 'rwmb_meta_boxes', 'sg_post_page_custom_titles_subtitles' );


// Custom walker for filter shortcode menu
// can be used anywhere
class SG_Sidebar_Menu_Walker extends Walker_Nav_Menu {
  /**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The 'nav_menu_item_args' filter was added.
	 * @since 5.9.0 Renamed `$item` to `$data_object` and `$id` to `$current_object_id`
	 *              to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output            Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object       Menu item data object.
	 * @param int      $depth             Depth of menu item. Used for padding.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		// Restores the more descriptive, specific name for use within this method.
		$menu_item = $data_object;

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param WP_Post  $menu_item Menu item data object.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );

		/**
		 * Filters the ID attribute applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_item_id The ID attribute applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item    The current menu item.
		 * @param stdClass $args         An object of wp_nav_menu() arguments.
		 * @param int      $depth        Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

		$li_atts          = array();
		$li_atts['id']    = ! empty( $id ) ? $id : '';
		$li_atts['class'] = ! empty( $class_names ) ? $class_names : '';

		/**
		 * Filters the HTML attributes applied to a menu's list item element.
		 *
		 * @since 6.3.0
		 *
		 * @param array $li_atts {
		 *     The HTML attributes applied to the menu item's `<li>` element, empty strings are ignored.
		 *
		 *     @type string $class        HTML CSS class attribute.
		 *     @type string $id           HTML id attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$li_atts       = apply_filters( 'nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth );
		$li_attributes = $this->build_atts( $li_atts );
    
    $output .= $indent . '<li' . $li_attributes . '>';
    
    $tag = 'a';
    
    if ( $depth == 0 && $this->has_children ) {
      $tag = 'summary';
      $output .= '<details>';
    }
		
		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if ( ! empty( $menu_item->url ) ) {
			if ( get_privacy_policy_url() === $menu_item->url ) {
				$atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}
    
    if ( $tag == 'summary' ) {
      unset( $atts['href'] );
    }

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
		$attributes = $this->build_atts( $atts );

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title     The menu item's title.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );
    
    $item_output  = $args->before;
    $item_output .= '<' . $tag . $attributes . '>';
    $item_output .= $args->link_before . $title . $args->link_after;
    $item_output .= '</' . $tag . '>';
    $item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $menu_item   Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
	}
  
  /**
	 * Ends the element output, if needed.
	 *
	 * @since 3.0.0
	 * @since 5.9.0 Renamed `$item` to `$data_object` to match parent class for PHP 8 named parameter support.
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output      Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object Menu item data object. Not used.
	 * @param int      $depth       Depth of page. Not Used.
	 * @param stdClass $args        An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
    
    if ( $depth == 0 && $this->has_children ) {
      $output .= "</details>";
    }
		
    $output .= "</li>{$n}";
	}
}



/* Product Admin Notes Start */
add_action( 'add_meta_boxes', 'sg_register_post_meta_boxes' );
function sg_register_post_meta_boxes() {
  add_meta_box( 
    '_sg_product_admin_notes', 
    __( 'Product Notes', 'SuperiorGlove' ), 
    'sg_render_product_admin_notes', 
    'product', 
    'advanced', 
    'default' 
  );
}

function sg_render_product_admin_notes( $post ) {
  wp_nonce_field( 'sg_product_admin_notes_save', 'sg_product_admin_notes_nonce' );

  $value = get_post_meta( $post->ID, '_sg_product_admin_notes', true );
  
  wp_editor( 
    htmlspecialchars($value), 
    'sg_product_admin_notes', 
    $settings = array('textarea_name' => 'sg_product_admin_notes') 
  );
  
  /*echo 
    '<textarea id="sg_product_admin_notes_field" name="sg_product_admin_notes" rows="4" style="width: 1000%;" />' . 
      esc_attr( $value ) . 
    '</textarea>';*/
}

add_action( 'save_post', 'sg_save_product_admin_notes' );
function sg_save_product_admin_notes( $post_id ) {
  if ( 
    ! current_user_can( 'edit_post', $post_id ) || 
    ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || 
    ! isset( $_POST['sg_product_admin_notes_nonce'] ) || 
    ! wp_verify_nonce( $_POST['sg_product_admin_notes_nonce'], 'sg_product_admin_notes_save' )
  ) {
    return $post_id;
  }
  
  $new_value = ( isset( $_POST['sg_product_admin_notes'] ) ? sanitize_text_field( $_POST['sg_product_admin_notes'] ) : '' );
  
  update_post_meta( $post_id, '_sg_product_admin_notes', $new_value );
}
/* Product Admin Notes End */


add_filter( 'wpcf7_spam', 'sg_control_wpcf7_spam', 20, 2 );
function sg_control_wpcf7_spam( $spam, $submit ) {
  if ( $submit->get_contact_form()->__get('id') == 1137562 ) {
    return false;
  }
}

/*
if ( !function_exists('sg_write_log') ) {
  function sg_write_log( $log ) {
    if ( true === WP_DEBUG ) {
      if ( is_array($log) || is_object($log) ) {
        error_log( print_r($log, true) );
      } else {
        error_log( $log );
      }
    }
  }
}


add_action( 'template_redirect', 'sg_redirect_page_by_language_meta_info' );
function sg_redirect_page_by_language_meta_info() {
  if ( is_singular('page') || is_singular('post') ) {
    $weglot_site_language = null;
    $weglot_site_language_obj = null;
    $weglot_language_services = null;
    $weglot_request_url_services = null;
    
    if ( function_exists('weglot_get_current_language') ) {
      $weglot_site_language = weglot_get_current_language();
    }
    
    if ( function_exists('weglot_get_service') ) {
      $weglot_language_services = weglot_get_service( 'Language_Service_Weglot' );
      $weglot_request_url_services = weglot_get_service( 'Request_Url_Service_Weglot' );
      
      if ( $weglot_site_language ) {
        $weglot_site_language_obj = $weglot_language_services->get_language_from_internal( $weglot_site_language );
      }
    }
    
    if ( !$weglot_site_language || !$weglot_site_language_obj || !$weglot_request_url_services ) return;
    
    $post_language = '';
    $post_language_code = '';
    $post_languages = wp_get_post_terms( get_the_ID(), 'sg_language', array( 'hide_empty' => true ) );
    
    if ( !is_wp_error($post_languages) && !empty($post_languages) && is_array($post_languages) ) {
      foreach ( $post_languages as $term ) {
        $post_language = $term->slug;
      }
      
      switch ( $post_language ) {
        case 'english':
          $post_language_code = 'en';
          break;
        case 'french':
          $post_language_code = 'fr';
          break;
        case 'spanish':
          $post_language_code = 'es';
          break;
        case 'portuguese-br':
          $post_language_code = 'br';
          break;
      }
    } else {
      return;
    }
    
    if ( !$post_language_code || $post_language_code == $weglot_site_language ) return;
    
    $redirection_url = '';
    
    switch ( $post_language_code ) {
      case 'en':
        $redirection_url = rwmb_meta( 'sg_english_post_url', array(), get_the_ID() );
        break;
      case 'fr':
        $redirection_url = rwmb_meta( 'sg_french_post_url', array(), get_the_ID() );
        break;
      case 'es':
        $redirection_url = rwmb_meta( 'sg_portuguese_post_url', array(), get_the_ID() );
        break;
      case 'br':
        $redirection_url = rwmb_meta( 'sg_spanish_post_url', array(), get_the_ID() );
        break;
    }
    
    if ( !$redirection_url ) return;
    
    $weglot_redirection_url_obj = $weglot_request_url_services->create_url_object( $redirection_url );
    $weglot_redirection_url = $weglot_redirection_url_obj->getForLanguage( $weglot_site_language_obj );
    
    if ( $weglot_redirection_url ) {
      sg_write_log( '$weglot_redirection_url: ' . $weglot_redirection_url . "\r\n" );

      wp_safe_redirect( $weglot_redirection_url );
    }
  }
}
*/





/* ----------- Sample Box Custom Fields START ----------- */
add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
  $meta_boxes[] = array( 
    'title'      => 'Sample Box',
    'post_types' => 'product',
    'fields'     =>  array( 
      array( 
        'id'        => 'sg_sample_box_marker',
        'name'      => __('This is Sample Box product', 'SuperiorGlove'),
        'type'      => 'switch',
        'style'     => 'rounded',
        'on_label'  => __('Yes', 'SuperiorGlove'),
        'off_label' => __('No', 'SuperiorGlove'),
      ),
    ),
  );
  
  // Post content data
  /*$meta_boxes[] = array( 
    'title'      => 'Sample Box Additional Content',
    'post_types' => 'sample_box',
    'fields'     =>  array( 
      array( 
        'name'        => __('Post Subtitle', 'SuperiorGlove'),
        'id'          => 'sg_sample_box_subtitle',
        'type'        => 'textarea',
        'std'         => __("", "SuperiorGlove"),
        'rows'        => 2,
      ),
      array( 
        'name'        => __('Post Short Description', 'SuperiorGlove'),
        'id'          => 'sg_sample_box_short_description',
        'type'        => 'textarea',
        'std'         => __("", "SuperiorGlove"),
        'rows'        => 3,
      ),
    ),
  );*/
  
  // What's in the Box section
  $meta_boxes[] = array( 
    'title'      => 'Sample Box Products',
    'post_types' => 'product',
    'fields'     =>  array( 
      array( 
        'name'        => __('Section Title', 'SuperiorGlove'),
        'id'          => 'sg_sample_box_products_section_title',
        'type'        => 'textarea',
        'std'         => __("What's in the Box", "SuperiorGlove"),
        'rows'        => 2,
      ),
      array( 
        'name'        => 'Products',
        'id'          => 'sg_sample_box_products',
        'type'        => 'post',
        'post_type'   => 'product',
        'field_type'  => 'select_advanced',
        'multiple'    => true,
        'ajax'        => true,
        'query_args'  => array( 
          'post_status'    => 'publish',
          'posts_per_page' => - 1,
        ),
      ),
    ),
  );

  // Call to Action section
  $meta_boxes[] = array( 
    'title'       => 'Call to Action',
    'post_types'  => 'product',
    'fields'      =>  array( 
      array( 
        'id'        => 'sg_sample_box_cta_section_hide',
        'name'      => __('Hide Section', 'SuperiorGlove'),
        'type'      => 'switch',
        'style'     => 'rounded',
        'on_label'  => __('Yes', 'SuperiorGlove'),
        'off_label' => __('No', 'SuperiorGlove'),
      ),
      array( 
        'name'      => __('Section Title', 'SuperiorGlove'),
        'id'        => 'sg_sample_box_cta_section_title',
        'type'      => 'textarea',
        'std'       => __('Request Now', 'SuperiorGlove'),
        'rows'      => 2,
      ),
      array( 
        'name'      => __('Section Text', 'SuperiorGlove'),
        'id'        => 'sg_sample_box_cta_section_text',
        'type'      => 'textarea',
        'rows'      => 3,
      ),
      /*array( 
        'name'      => __('Button Text', 'SuperiorGlove'),
        'id'        => 'sg_sample_box_cta_section_button_text',
        'type'      => 'text',
        'desc'      => __('This text will also be used in the top content section', 'SuperiorGlove'),
        'std'       => __('Add to Sample Box', 'SuperiorGlove'),
      ),*/
    ),
  );
  
  // You May Also Like section
  /*$meta_boxes[] = array( 
    'title'       => 'Featured Products',
    'post_types'  => 'sample_box',
    'fields'      =>  array( 
      array( 
        'id'        => 'sg_sample_box_fetured_products_section_hide',
        'name'      => __('Hide Section', 'SuperiorGlove'),
        'type'      => 'switch',
        'style'     => 'rounded',
        'on_label'  => __('Yes', 'SuperiorGlove'),
        'off_label' => __('No', 'SuperiorGlove'),
      ),
      array( 
        'name'      => __('Section Title', 'SuperiorGlove'),
        'id'        => 'sg_sample_box_fetured_products_section_title',
        'type'      => 'textarea',
        'std'       => __('You may also like', 'SuperiorGlove'),
        'rows'      => 2,
      ),
      array( 
        'name'        => 'Products',
        'id'          => 'sg_sample_box_fetured_products',
        'type'        => 'post',
        'post_type'   => 'product',
        'field_type'  => 'select_advanced',
        'multiple'    => true,
        'query_args'  => array( 
          'post_status'    => 'publish',
          'posts_per_page' => - 1,
        ),
      ),
      array( 
        'name'      => __('Call to Action', 'SuperiorGlove'),
        'type'      => 'heading',
      ),
      array( 
        'id'        => 'sg_sample_box_fetured_products_section_cta_hide',
        'name'      => __('Hide CTA', 'SuperiorGlove'),
        'type'      => 'switch',
        'style'     => 'rounded',
        'on_label'  => __('Yes', 'SuperiorGlove'),
        'off_label' => __('No', 'SuperiorGlove'),
      ),
      array( 
        'name'      => __('CTA Text', 'SuperiorGlove'),
        'id'        => 'sg_sample_box_fetured_products_section_cta_text',
        'type'      => 'textarea',
        'std'       => __("Can't find What You're Looking For?", "SuperiorGlove"),
        'rows'      => 2,
      ),
      array( 
        'name'      => __('CTA Button Text', 'SuperiorGlove'),
        'id'        => 'sg_sample_box_fetured_products_section_cta_button_text',
        'type'      => 'text',
        'std'       => __('Browse Products Online', 'SuperiorGlove'),
      ),
      array( 
        'name'      => __('CTA Button Link', 'SuperiorGlove'),
        'id'        => 'sg_sample_box_fetured_products_section_cta_button_link',
        'type'      => 'text',
        'std'       => '/products/',
      ),
      array( 
        'name'             => __('CTA Background Image', 'SuperiorGlove'),
        'id'               => 'sg_sample_box_fetured_products_section_cta_bg_image',
        'type'             => 'image_advanced',
        'force_delete'     => false,
        'max_file_uploads' => 1,
        'max_status'       => false,
        'image_size'       => 'thumbnail',
      ),
    ),
  );*/

  return $meta_boxes;
} );
/* ----------- Sample Box Custom Fields END ----------- */

/* ----------- Limit Sample Boxes ----------- */
add_action('woocommerce_add_to_cart_validation', 'max_1_item_for_samples', 20, 3 );
function max_1_item_for_samples( $passed, $product_id, $quantity ) {
    $category = 'sample-boxes';
    $limit = 1; 
    $count = 0;

    foreach ( WC()->cart->get_cart() as $cat_item ) {
        if( has_term( $category, 'product_cat', $cat_item['product_id'] ) )
            $count++;
    }
    if( has_term( $category, 'product_cat', $product_id ) && $count == $limit )
        $count++;

    if( $count > $limit ){
        $notice = __('Sorry, you can not add to cart more than one sample box.', 'woocommerce');
        wc_add_notice( $notice, 'error' );
        $passed = false;
    }

    return $passed;
}
function register_custom_sidebars() {
    register_sidebar( array(
        'name'          => __( 'No Sample Box Category', 'supglove' ),
        'id'            => 'no-sample-box-category',
        'description'   => __( 'Sidebar for the No Sample Box Products template.', 'supglove' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'register_custom_sidebars' );
function hide_top_bar_when_print() {
    if (isset($_GET['action']) && $_GET['action'] === 'print') {
        echo '<style>
            div#wpfront-notification-bar, div#wpfront-notification-bar.hidden {
                display: none !important;
            }
        </style>';
    }
}
add_action('wp_head', 'hide_top_bar_when_print');


/*
function change_all_add_to_cart_buttons_dynamic() {
    ?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            function updateButtons() {
                document.querySelectorAll(
                    '.woocommerce div.product form.cart .button, .woocommerce .sample-box-cta-add-to-cart-form button.button.alt, .sg-featured-product__add-to-cart-button'
                ).forEach(function(button) {
                    if (!button.classList.contains("updated-text")) {
                        button.innerHTML = "ADD TO SAMPLE BOX <span style='font-weight:bold;'>+</span>";
                        button.classList.add("updated-text"); // Prevents duplicate updates
                    }
                });
            }

            // Run once on page load
            updateButtons();

            // Observe changes in the document for dynamically added buttons (AJAX support)
            let observer = new MutationObserver(updateButtons);
            observer.observe(document.body, { childList: true, subtree: true });
        });
    </script>
    <?php
}
*/
// add_action('wp_footer', 'change_all_add_to_cart_buttons_dynamic');

function shortcode_sample_box_products($atts) {
  $atts = shortcode_atts([
    'ids' => '', // comma-separated product IDs
    'title' => "What's in the Box",
    'hide_add_to_cart' => false
  ], $atts);

  $hide_add_to_cart = filter_var($atts['hide_add_to_cart'], FILTER_VALIDATE_BOOLEAN);

  $product_ids = array_filter(array_map('intval', explode(',', $atts['ids'])));
  if (empty($product_ids)) return '';

  ob_start();
  ?>
  <div class="product-box sample-box">
    <div class="container">
      <h2 class="sample-box__products-title"><?= esc_html($atts['title']) ?></h2>
      <div class="sg-new-products sg-new-products--layout-columns-2 sg-new-products--columns-3 sg-new-products--sample-box">
        <?php
          foreach ($product_ids as $product_id) {
            $product = wc_get_product($product_id);
            if (!$product) continue;

            get_template_part('inc/shortcodes/sg/sg-featured-product', null, [
              'featured_product'     => $product,
              'title'                => '',
              'subtitle'             => '',
              'layout'               => 'columns-2',
              'hide_add_to_cart'     => $hide_add_to_cart,
              'show_product_id'      => true,
              'add_to_cart_link'     => $product->get_permalink(),
              'add_to_cart_text'     => false,
              'add_to_cart_target'   => '_blank',
            ]);
          }
        ?>
      </div>
    </div>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode('sample_box_products', 'shortcode_sample_box_products');

add_filter('woocommerce_add_to_cart_redirect', function($url) {
    if (isset($_GET['redirect_to'])) {
        $url = esc_url_raw($_GET['redirect_to']);
    }
    return $url;
});
add_action('template_redirect', function() {
    if (is_checkout() && !is_user_logged_in()) {
        wp_redirect(site_url('/my-account/'));
        exit;
    }
});
// 1. Add the custom link below the "Remember me" checkbox
add_action('woocommerce_login_form', 'custom_registration_link_after_remember_me');
function custom_registration_link_after_remember_me() {
    echo '<p class="register-switch-link" style="margin-top:10px;">To register for a new account, <a href="#" id="open-register-tab">click here</a>.</p>';
}
// 2. JavaScript to click the actual "Register" tab link
add_action('wp_footer', 'custom_switch_to_register_tab_script');
function custom_switch_to_register_tab_script() {
    if (is_account_page()) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const switchLink = document.getElementById('open-register-tab');
            if (!switchLink) return;
            switchLink.addEventListener('click', function (e) {
                e.preventDefault();
                const tabLinks = document.querySelectorAll('.tabs-nav li a');
                const registerLink = Array.from(tabLinks).find(link =>
                    link.textContent.trim().toLowerCase() === 'register'
                );
                if (registerLink) {
                    const mouseClickEvents = ['mouseover', 'mousedown', 'mouseup', 'click'];
                    mouseClickEvents.forEach(type => {
                        registerLink.dispatchEvent(new MouseEvent(type, {
                            view: window,
                            bubbles: true,
                            cancelable: true
                        }));
                    });
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });
        </script>
        <?php
    }
}
function add_custom_user_roles() {
    // Add Distributor role
    add_role(
        'distributor',
        'Distributor',
        [
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
        ]
    );

    // Add Safety Professional role
    add_role(
        'safety_professional',
        'Safety Professional',
        [
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
        ]
    );

    // Add Other role
    add_role(
        'other',
        'Other',
        [
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
        ]
    );
}

add_action('init', 'add_custom_user_roles');


add_action('add_meta_boxes', function() {
    add_meta_box('restrict_roles_meta_box', 'Restrict Page by Role', 'restrict_roles_meta_box_callback', 'page', 'side');
});

function restrict_roles_meta_box_callback($post) {
    $custom_roles = [
        'distributor' => 'Distributor',
        'safety_professional' => 'Safety Professional',
    ];
    $saved_roles = get_post_meta($post->ID, '_restricted_roles', true) ?: [];

    foreach ($custom_roles as $role => $label) {
        $checked = in_array($role, $saved_roles) ? 'checked' : '';
        echo "<p><label><input type='checkbox' name='restricted_roles[]' value='$role' $checked> $label</label></p>";
    }
}
add_action('save_post', function($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['restricted_roles'])) {
        update_post_meta($post_id, '_restricted_roles', array_map('sanitize_text_field', $_POST['restricted_roles']));
    } else {
        delete_post_meta($post_id, '_restricted_roles');
    }
});
add_action('template_redirect', function() {
    if (is_page()) {
        global $post;
        $restricted_roles = get_post_meta($post->ID, '_restricted_roles', true);

        if (!empty($restricted_roles)) {
            // Always allow admins and editors
            if (current_user_can('administrator') || current_user_can('editor')) {
                return;
            }

            // Allow if the user's role matches any of the checked roles
            foreach ($restricted_roles as $role) {
                if (current_user_can($role)) {
                    return;
                }
            }

            // If no roles match, redirect
            wp_redirect(home_url());
            exit;
        }
    }
});
/*
add_filter('wpcf7_form_elements', 'disable_cf7_form_for_guests');
function disable_cf7_form_for_guests($form) {
    if (!is_user_logged_in()) {
        // Disable all input/textarea/select fields
        $form = preg_replace_callback('/<(input|textarea|select)(.*?)>/i', function($matches) {
            return '<' . $matches[1] . $matches[2] . ' disabled>';
        }, $form);

        // Replace the submit button with a message
        $form = preg_replace('/<input[^>]+type=[\'"]submit[\'"][^>]*>/i', '<p style="color:#888; font-style:italic;">Please login to submit a form request.</p>', $form);
    }

    return $form;
}
*/
add_filter('wp_nav_menu_objects', 'replace_login_menu_item', 10, 2);
function replace_login_menu_item($items, $args) {
    foreach ($items as &$item) {
        if ($item->url == '/my-account') {
            if (is_user_logged_in()) {
                $item->title = 'Account';
                $item->url = wc_get_page_permalink('myaccount');
            } else {
                $item->title = 'Login';
                $item->url = wc_get_page_permalink('myaccount');
            }
        }
    }
    return $items;
}

//Add Logged-Out State UI for All Contact Forms (Staging Only)

function strip_cf7_form_tag($html) {
    // Remove the outer <form ...>...</form> while keeping inner content
    return preg_replace('/<form[^>]*>(.*?)<\/form>/is', '$1', $html);
}

add_filter('do_shortcode_tag', 'handle_all_cf7_shortcodes', 10, 4);
function handle_all_cf7_shortcodes($output, $tag, $atts, $m) {
    $force_show = isset($atts['force_show']) && $atts['force_show'] === 'true';

    if ($tag !== 'contact-form-7' || (is_user_logged_in() || $force_show)) {
        return $output;
    }

    // Get current page URL with #form anchor for redirect
    $current_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $redirect_url = $current_url . '#form';

    $login_url = add_query_arg('redirect_to', urlencode($redirect_url), '/my-account/');
    $register_url = add_query_arg(array(
        'redirect_to' => urlencode($redirect_url),
        'supro_tab' => 'register'
    ), '/my-account/');

    $html = '
<div class="protected-form-wrp" id="form">
    <div class="protected-form"><div class="wpcf7-form">'. strip_cf7_form_tag($output) .'</div></div>
    <div class="protected-form-message">
        <h2 style="padding-top: 100px; margin-bottom: 0; font-size: 32px;">CREATE A FREE ACCOUNT</h2>
        <h3 style="margin: 0;font-size: 28px; text-transform: none">Sign up once—no more forms</h3>
        <p><span style="font-size: 1.1em;">Your info is saved so you can get what you need fast</span></p>
        <ul style="color: #1A1817!important;font-weight: 600;">
            <li style="margin-bottom: 2px;">Free Samples</li>
            <li style="margin-bottom: 2px;">Onsite services</li>
            <li style="margin-bottom: 2px;">Expert advice</li>
            <li style="margin-bottom: 2px;">Email updates</li>
            <li style="margin-bottom: 2px;">And more!</li>
        </ul>
        <div style="margin: 20px 0;">
            <a href="'.esc_url($register_url).'" class="buttonogs btn_large btn_theme_color">SIGN UP</a>
        </div>
        <p style="font-size: 14px; padding-bottom: 100px;">Already have an account? <a href="'.esc_url($login_url).'" style="color:#fd8541; text-decoration: underline;">Sign In</a></p>
    </div>
</div>';

    $html .= '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        function adjustFormHeight() {
            const form = document.querySelector(".protected-form");
            const message = document.querySelector(".protected-form-message");
            
            if (form && message) {
                const messageHeight = message.offsetHeight;
                const formHeight = form.offsetHeight;
                
                if (formHeight < messageHeight) {
                    form.style.minHeight = messageHeight + "px";
                } else {
                    form.style.minHeight = "";
                }
            }
        }
        
        adjustFormHeight();
        window.addEventListener("resize", adjustFormHeight);
    });
    </script>';

    $html .= '
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const formWrapper = document.querySelector(".protected-form-wrp");
        if (formWrapper) {
            const forms = formWrapper.querySelectorAll("form");
            
            forms.forEach(form => {
                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = "'.esc_url($login_url).'";
                    return false;
                });
                
                const inputs = form.querySelectorAll("input, textarea, select, button");
                inputs.forEach(input => {
                    input.style.pointerEvents = "none";
                    input.style.opacity = "1";
                    input.style.filter = "none";
                    input.readOnly = true;
                    if (input.tagName === "BUTTON" || input.type === "submit") {
                        input.disabled = true;
                    }
                });
            });
        }
    });
    </script>';
    return $html;
}

add_action('wp_footer', 'supro_handle_account_tab_switch');
function supro_handle_account_tab_switch() {
    if (is_account_page()) {
        ?>
        <script>
            jQuery(document).ready(function($) {
                const urlParams = new URLSearchParams(window.location.search);
                const activeTab = urlParams.get('supro_tab');

                if (activeTab === 'register') {
                    const $tabs = $('.supro-tabs');
                    const $registerTab = $('.tabs-nav a[href="#register"]');
                    const $loginTab = $('.tabs-nav a[href="#login"]');
                    const $panels = $('.tabs-panel');

                    if ($registerTab.length) {
                        setTimeout(function() {
                            $loginTab.removeClass('active').parent().removeClass('active');
                            $registerTab.addClass('active').parent().addClass('active');
                            $panels.removeClass('active');
                            $panels.eq(1).addClass('active');
                            $registerTab.trigger('click');
                        }, 100);
                    }
                }
                if (typeof supro.loginTab === 'function') {
                    supro.loginTab();
                }
            });
        </script>
        <?php
    }
}

// Backend validation for "other" only
add_action('woocommerce_register_post', 'block_other_custom_user_role', 10, 3);
function block_other_custom_user_role($username, $email, $validation_errors) {
    if (isset($_POST['afreg_select_user_role']) && sanitize_text_field($_POST['afreg_select_user_role']) === 'other') {
        $validation_errors->add('registration-error', __('Sorry, you do not qualify for an account.', 'woocommerce'));
    }
}

// Frontend JS: block only if "other" is selected
//add_action('wp_footer', 'inline_js_block_other_role', 21);
/*
function inline_js_block_other_role() {
    if (!is_account_page()) return;
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const waitForElements = setInterval(() => {
            const form = document.querySelector("form.register");
            const roleDropdown = document.querySelector('#afreg_select_user_role');
            const formInputs = document.querySelector('.form-inputs');
            const registerButton = form ? form.querySelector('button[type="submit"], input[type="submit"]') : null;

            if (form && roleDropdown && registerButton) {
                clearInterval(waitForElements);

                // Hide button initially if nothing selected
                if (!roleDropdown.value || roleDropdown.value === "") {
                    registerButton.style.display = "none";
                    formInputs.style.display = "none";
                }

                // Create error + help elements
                const errorContainer = document.createElement("ul");
                errorContainer.className = "woocommerce-error";
                errorContainer.style.display = "none";
                errorContainer.style.marginBottom = "15px";
                roleDropdown.parentElement.insertAdjacentElement("afterend", errorContainer);

                const helpMessage = document.createElement("p");
                helpMessage.innerHTML = 'If you do not qualify, please <a href="/contact">contact us</a>.';
                helpMessage.style.display = "none";
                helpMessage.style.margin = "5px 0 15px";
                roleDropdown.parentElement.insertAdjacentElement("afterend", helpMessage);

                function checkRoleStatus() {
                    const selected = roleDropdown.value.trim();

                    if (!selected || selected === "") {
                        registerButton.style.display = "none";
                        errorContainer.style.display = "none";
                        helpMessage.style.display = "none";
                        formInputs.style.display = "none";
                        return;
                    }

                    if (selected === "other") {
                        errorContainer.innerHTML = "<li>Sorry, you do not qualify for an account.</li>";
                        errorContainer.style.display = "block";
                        helpMessage.style.display = "block";
                        registerButton.style.display = "none";
                        formInputs.style.display = "none";
                    } else {
                        errorContainer.innerHTML = "";
                        errorContainer.style.display = "none";
                        helpMessage.style.display = "none";
                        registerButton.style.display = "block";
                        formInputs.style.display = "block";
                    }
                }

                // Check on change
                roleDropdown.addEventListener("change", checkRoleStatus);

                // Check on submit
                form.addEventListener("submit", function (e) {
                    const selected = roleDropdown.value.trim();
                    if (!selected || selected === "" || selected === "other") {
                        e.preventDefault();
                        if (selected === "other") {
                            errorContainer.innerHTML = "<li>Sorry, you do not qualify for an account.</li>";
                            helpMessage.style.display = "block";
                        } else {
                            errorContainer.innerHTML = "<li>Please select your professional affiliation before registering.</li>";
                            helpMessage.style.display = "none";
                        }
                        errorContainer.style.display = "block";
                        registerButton.style.display = "none";
                        roleDropdown.focus();
                    }
                });

                // Final fallback check on load
                setTimeout(checkRoleStatus, 100);
            }
        }, 100);
    });
    </script>
    <?php
}
*/
add_filter('afreg_custom_fields_args', 'reorder_afreg_field_message_above_input', 10, 1);
function reorder_afreg_field_message_above_input($fields) {
    foreach ($fields as $key => &$field) {
        // Only proceed if description/message exists
        if (!empty($field['message'])) {
            // Store the message text
            $message = '<span class="afreg_field_message">' . esc_html($field['message']) . '</span>';

            // Append message to label, instead of below input
            if (!empty($field['label'])) {
                $field['label'] .= $message;
            } else {
                $field['label'] = $message;
            }

            // Remove it from the bottom
            $field['message'] = '';
        }
    }

    return $fields;
}
add_action('wp_footer', function () {
    if (!is_account_page()) return;
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const roleField = document.querySelector('select[name="afreg_select_user_role"]');

        if (roleField) {
            const label = roleField.closest("p").querySelector("label");
            const helpMessage = document.createElement("p");

            helpMessage.className = "afreg_field_message";
            helpMessage.innerText = "Accounts are only available to safety professionals who manage safety at their company and to current Superior Glove distributors. Professional titles are verified."


;

            if (label) {
                label.insertAdjacentElement("afterend", helpMessage);
            }
        }
    });
    </script>
    <?php
});
add_action('wp_footer', function () {
    if (!is_account_page()) return;
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const roleSelect = document.getElementById("afreg_select_user_role");
        const registerForm = document.querySelector("form.register");
        if (!roleSelect || !registerForm) return;

        const registerButton = registerForm.querySelector('button[type="submit"], input[type="submit"]');
        if (!registerButton) return;

        // Hide the button initially
        registerButton.style.display = "none";

        // Toggle visibility
        function toggleRegisterButton() {
            const selected = roleSelect.options[roleSelect.selectedIndex].value;
            if (selected && selected !== "" && selected.toLowerCase().includes("select") === false) {
                registerButton.style.display = "block";
            } else {
                registerButton.style.display = "none";
            }
        }

        roleSelect.addEventListener("change", toggleRegisterButton);
        toggleRegisterButton(); // Run once in case browser auto-fills
    });
    </script>
    <?php
});
/*
 *
add_action('wp_footer', 'validate_custom_email_domain', 21);
function validate_custom_email_domain() {
    if (!is_account_page()) return;
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const waitForEmail = setInterval(() => {
            const form = document.querySelector("form.register");
            const emailField = document.querySelector('input[name="afreg_additional_46062"]');
            const registerButton = form ? form.querySelector('button[type="submit"], input[type="submit"]') : null;
            const fieldWrapper = emailField ? emailField.closest("p") : null;
            const label = fieldWrapper ? fieldWrapper.querySelector("label") : null;

            if (form && emailField && registerButton && label) {
                clearInterval(waitForEmail);

                // Error message
                const errorContainer = document.createElement("ul");
                errorContainer.className = "woocommerce-error";
                errorContainer.style.display = "none";
                errorContainer.style.margin = "8px 0";
                label.insertAdjacentElement("afterend", errorContainer);

                // Contact us helper
                const helpMessage = document.createElement("p");
                helpMessage.innerHTML = 'If you do not have a business email, please <a href="/contact">contact us</a>.';
                helpMessage.style.display = "none";
                helpMessage.style.margin = "0 0 15px";
                helpMessage.style.fontSize = "14px";
                helpMessage.style.color = "#555";
                label.insertAdjacentElement("afterend", helpMessage);

                const blockedDomains = [
                    "gmail.com", "yahoo.com", "hotmail.com",
                    "aol.com", "icloud.com", "outlook.com",
                    "live.com", "msn.com"
                ];

                function validateEmail() {
                    const email = emailField.value.trim().toLowerCase();
                    const emailDomain = email.split("@")[1] || "";

                    if (email && blockedDomains.includes(emailDomain)) {
                        errorContainer.innerHTML = "<li>Please enter a valid business email address.</li>";
                        errorContainer.style.display = "block";
                        helpMessage.style.display = "block";
                        registerButton.style.display = "none";
                    } else {
                        errorContainer.innerHTML = "";
                        errorContainer.style.display = "none";
                        helpMessage.style.display = "none";
                        registerButton.style.display = "";
                    }
                }

                emailField.addEventListener("input", validateEmail);
                emailField.addEventListener("blur", validateEmail);

                form.addEventListener("submit", function (e) {
                    const email = emailField.value.trim().toLowerCase();
                    const emailDomain = email.split("@")[1] || "";

                    if (email && blockedDomains.includes(emailDomain)) {
                        e.preventDefault();
                        errorContainer.innerHTML = "<li>Please enter a valid business email address.</li>";
                        errorContainer.style.display = "block";
                        helpMessage.style.display = "block";
                        registerButton.style.display = "none";
                        emailField.focus();
                    }
                });

                setTimeout(validateEmail, 500);
            }
        }, 200);
    });
    </script>
    <?php
}
*/

function get_email_whitelist_from_sheet() {
    $sheet_url = 'https://docs.google.com/spreadsheets/d/1XBIo95osKErLMs5geGhgjh3mGAel-sa2/export?format=csv';
    $exception_sheet_url = 'https://docs.google.com/spreadsheets/d/1LjZVixRaJFlPAZRmJW9ZsRgOFm3iWG22/export?format=csv';

    $allowed_domains = [];
    $exception_emails = [];

    // Load allowed domains from main sheet
    $response = wp_remote_get($sheet_url);
    if (!is_wp_error($response)) {
        $csv = wp_remote_retrieve_body($response);
        $lines = explode(PHP_EOL, $csv);
        foreach ($lines as $line) {
            $domain = trim(str_getcsv($line)[0]);
            if (!empty($domain)) {
                $allowed_domains[] = strtolower($domain);
            }
        }
    }

    // Load exception full emails
    $exception_response = wp_remote_get($exception_sheet_url);
    if (!is_wp_error($exception_response)) {
        $csv = wp_remote_retrieve_body($exception_response);
        $lines = explode(PHP_EOL, $csv);
        foreach ($lines as $line) {
            $email = trim(str_getcsv($line)[0]);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $exception_emails[] = strtolower($email);
            }
        }
    }

    return [
        'domains' => $allowed_domains,
        'exceptions' => $exception_emails,
    ];
}


add_action('wp_footer', 'custom_registration_form_behavior');
function custom_registration_form_behavior() {
    if (!is_account_page()) return;

    $email_lists = get_email_whitelist_from_sheet();
    $allowed_domains_json = json_encode($email_lists['domains']);
    $exceptions_json = json_encode($email_lists['exceptions']);
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const roleDropdown = document.querySelector('#afreg_select_user_role');
            if (roleDropdown && roleDropdown.options.length > 0) {
                roleDropdown.options[0].text = "Choose Professional Affiliation";
            }

            const businessEmailField = document.getElementById('afreg_additional_46362');
            const mainEmailField = document.getElementById('reg_email');
            const additionalEmailField = document.getElementById('afreg_additional_46390');

            const blockedDomains = [
                "gmail.com", "yahoo.com", "hotmail.com",
                "aol.com", "icloud.com", "outlook.com",
                "live.com", "msn.com", "superiorglove.com"
            ];

            const allowedDomains = <?php echo $allowed_domains_json; ?>;
            const exceptionEmails = <?php echo $exceptions_json; ?>;

            let isSyncing = false;

            if (businessEmailField && mainEmailField && additionalEmailField) {
                if (businessEmailField.value) {
                    isSyncing = true;
                    mainEmailField.value = businessEmailField.value;
                    additionalEmailField.value = businessEmailField.value;
                    isSyncing = false;
                }

                businessEmailField.addEventListener('input', function () {
                    if (isSyncing) return;
                    isSyncing = true;
                    mainEmailField.value = this.value;
                    additionalEmailField.value = this.value;
                    isSyncing = false;
                });

                additionalEmailField.addEventListener('input', function () {
                    if (isSyncing) return;
                    isSyncing = true;
                    mainEmailField.value = this.value;
                    businessEmailField.value = this.value;
                    isSyncing = false;

                });
            }

            function validateEmailDomain() {
                const email = businessEmailField.value.trim().toLowerCase();
                const emailDomain = email.split("@")[1] || "";
                const selectedRole = roleDropdown?.value.trim();
                const fieldWrapper = businessEmailField.closest("p");
                const label = fieldWrapper ? fieldWrapper.querySelector("label") : null;

                if (!label) return false;

                let errorContainer = label.nextElementSibling?.classList.contains('woocommerce-error')
                    ? label.nextElementSibling
                    : null;

                if (!errorContainer) {
                    errorContainer = document.createElement("ul");
                    errorContainer.className = "woocommerce-error email-domain-error";
                    errorContainer.style.display = "none";
                    errorContainer.style.margin = "8px 0";
                    label.insertAdjacentElement("afterend", errorContainer);
                }

                // Reset any previous error
                errorContainer.innerHTML = "";
                errorContainer.style.display = "none";

                // Basic email format validation regex
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                // Check if email is empty or invalid
                if (!email) {
                    return false;
                }

                if (!emailRegex.test(email)) {
                    errorContainer.innerHTML = "<li>Please enter a valid email address.</li>";
                    errorContainer.style.display = "block";
                    return false;
                }

                const isDomainAllowed = allowedDomains.includes(emailDomain);
                const isException = exceptionEmails.includes(email);

                // If email is in exceptions list, always allow
                if (isException) {
                    return true;
                }

                if (selectedRole === "distributor") {
                    if (!isDomainAllowed) {
                        errorContainer.innerHTML = "<li>We cannot locate your email address in our distributor database. If this is an error, or if you would like to become a Superior Glove distributor, please call 800-265-7617 or 519-853-1920.</li>";
                        errorContainer.style.display = "block";
                        return false;
                    }
                } else if (selectedRole === "safety_professional") {
                    if (blockedDomains.includes(emailDomain)) {
                        errorContainer.innerHTML = "<li>Please enter a valid business email address (no personal email domains).</li>";
                        errorContainer.style.display = "block";
                        return false;
                    }
                }

                return true;
            }

            let emailInputTimeout;

            function setupEmailValidationListener(emailField) {
                if (!emailField) return;

                emailField.addEventListener("input", function () {
                    clearTimeout(emailInputTimeout);

                    emailInputTimeout = setTimeout(function () {
                        validateEmailDomain();
                    }, 500);
                });

                emailField.addEventListener("blur", function () {
                    clearTimeout(emailInputTimeout);
                    validateEmailDomain();
                });
            }

            setupEmailValidationListener(businessEmailField);
            setupEmailValidationListener(additionalEmailField);

            // Update the submit button state based on email validation
            function updateSubmitButtonState() {
                const submitButton = document.querySelector('.woocommerce-form-register__submit');
                if (!submitButton) return;

                const emailValid = validateEmailDomain();
                submitButton.disabled = !emailValid;
            }

            if (businessEmailField) {
                let emailInputTimeout;

                businessEmailField.addEventListener("input", function () {
                    clearTimeout(emailInputTimeout);

                    emailInputTimeout = setTimeout(function () {
                        validateEmailDomain();
                        updateSubmitButtonState();
                    }, 500);
                });

                businessEmailField.addEventListener("blur", function () {
                    clearTimeout(emailInputTimeout);
                    validateEmailDomain();
                    updateSubmitButtonState();
                });
            }

            function disableEmptySelectOptions() {
                document.querySelectorAll('.input-select option').forEach(option => {
                    if (option.value === "") {
                        option.disabled = true;
                        option.selected = true;
                    }
                });
            }

            disableEmptySelectOptions();

            const waitForElements = setInterval(() => {
                const form = document.querySelector("form.register");
                const roleDropdown = document.querySelector('#afreg_select_user_role');
                const companySizeDropdown = document.querySelector('#afreg_additional_46359');
                const registerButton = form ? form.querySelector('button[type="submit"], input[type="submit"]') : null;
                const dependableFields = document.querySelectorAll('.af-dependable-field');

                if (form && roleDropdown && registerButton && companySizeDropdown) {
                    clearInterval(waitForElements);

                    disableEmptySelectOptions();

                    const errorContainer = document.createElement("ul");
                    errorContainer.className = "woocommerce-error";
                    errorContainer.style.display = "none";
                    errorContainer.style.marginBottom = "15px";
                    roleDropdown.parentElement.insertAdjacentElement("afterend", errorContainer);

                    const sizeErrorContainer = document.createElement("ul");
                    sizeErrorContainer.id = "company-size-error-container";
                    sizeErrorContainer.className = "woocommerce-error";
                    sizeErrorContainer.style.display = "none";
                    sizeErrorContainer.style.marginBottom = "15px";
                    companySizeDropdown.parentNode.insertBefore(sizeErrorContainer, companySizeDropdown.nextSibling);

                    const helpMessage = document.createElement("p");
                    helpMessage.innerHTML = 'If you do not qualify, please <a href="/contact">contact us</a>.';
                    helpMessage.style.display = "none";
                    helpMessage.style.margin = "5px 0 15px";
                    roleDropdown.parentElement.insertAdjacentElement("afterend", helpMessage);

                    function checkRegistrationStatus() {
                        const selectedRole = roleDropdown.value.trim();
                        const selectedSize = companySizeDropdown ? companySizeDropdown.value.trim() : "";

                        errorContainer.style.display = "none";
                        sizeErrorContainer.style.display = "none";
                        helpMessage.style.display = "none";

                        if (!selectedRole || selectedRole === "") {
                            registerButton.style.display = "none";
                            return;
                        }

                        if (selectedRole === "other") {
                            errorContainer.innerHTML = "<li>Sorry, you do not qualify for an account.</li>";
                            errorContainer.style.display = "block";
                            helpMessage.style.display = "block";
                            registerButton.style.display = "none";

                            dependableFields.forEach(field => {
                                field.classList.add('hidden');
                            });
                        }
                        else if (selectedRole === "safety_professional" && selectedSize === "Less than 100 Employees") {
                            sizeErrorContainer.innerHTML = "<li>Sorry, samples are only available for companies with 100+ employees.</li>";
                            sizeErrorContainer.style.display = "block";
                            helpMessage.style.display = "block";
                            registerButton.style.display = "none";

                            dependableFields.forEach(field => {
                                if (field.id !== 'afreg_additionalshowhide_46359') {
                                    field.classList.add('hidden');
                                } else {
                                    field.classList.remove('hidden');
                                }
                            });
                        }
                        else {
                            registerButton.style.display = "block";

                            dependableFields.forEach(field => {
                                const rules = field.querySelector('.afreg-dependable-on-rules');
                                if (rules) {
                                    const allowedRoles = rules.value.split(',');
                                    if (allowedRoles.includes(selectedRole)) {
                                        field.classList.remove('hidden');
                                    } else {
                                        field.classList.add('hidden');
                                    }
                                }
                            });
                        }
                    }

                    roleDropdown.addEventListener("change", checkRegistrationStatus);
                    if (companySizeDropdown) {
                        companySizeDropdown.addEventListener("change", checkRegistrationStatus);
                    }

                    form.addEventListener("submit", function(e) {
                        const selectedRole = roleDropdown.value.trim();
                        const selectedSize = companySizeDropdown ? companySizeDropdown.value.trim() : "";
                        const emailValid = validateEmailDomain();

                        if (!selectedRole || selectedRole === "" || selectedRole === "other" ||
                            (selectedRole === "safety_professional" && selectedSize === "Less than 100 Employees") || !emailValid) {
                            e.preventDefault();

                            if (!emailValid) {
                                businessEmailField.focus();
                                return;
                            }

                            if (selectedRole === "other") {
                                errorContainer.innerHTML = "<li>Sorry, you do not qualify for an account.</li>";
                                helpMessage.style.display = "block";
                            }
                            else if (selectedRole === "safety_professional" && selectedSize === "Less than 100 Employees") {
                                sizeErrorContainer.innerHTML = "<li>Sorry, samples are only available for companies with 100+ employees.</li>";
                                helpMessage.style.display = "block";
                            }
                            else {
                                errorContainer.innerHTML = "<li>Please select your professional affiliation before registering.</li>";
                            }

                            errorContainer.style.display = "block";
                            registerButton.style.display = "none";
                            roleDropdown.focus();
                        }
                    });

                    setTimeout(checkRegistrationStatus, 100);
                }
            }, 100);

            const preferredContactField = document.getElementById('afreg_additionalshowhide_46364');
            const secondaryEmailField = document.getElementById('afreg_additionalshowhide_46363');
            const businessEmailRadio = preferredContactField?.querySelector('input[value="Business Email"]');
            const secondaryEmailRadio = preferredContactField?.querySelector('input[value="Secondary Email"]');

            if (preferredContactField && secondaryEmailField && businessEmailRadio && secondaryEmailRadio) {
                businessEmailRadio.checked = true;
                secondaryEmailField.classList.add('hidden-email');

                preferredContactField.addEventListener('change', function(e) {
                    if (e.target.name === 'afreg_additional_46364') {
                        if (e.target.value === 'Secondary Email') {
                            secondaryEmailField.classList.remove('hidden-email');
                        } else {
                            secondaryEmailField.classList.add('hidden-email');
                        }
                    }
                });
            }

            function validateRequiredFields() {
                const role = document.querySelector('#afreg_select_user_role').value;
                const submitButton = document.querySelector('.woocommerce-form-register__submit');
                let isValid = true;

                document.querySelectorAll('.required-field-error').forEach(el => {
                    el.classList.remove('required-field-error');
                });

                const emailValid = validateEmailDomain();
                if (!emailValid) {
                    isValid = false;
                }

                const requiredFields = [
                    '#afreg_additional_46385', // First Name
                    '#afreg_additional_46387', // Last Name
                    '#afreg_additional_46389', // Phone Number
                    '#afreg_additional_46391', // Company Name
                    '#afreg_additional_46392', // Street Address
                    '#afreg_additional_46394', // City
                    '#afreg_additional_46396', // Post Code
                    '#afreg_additional_46397', // Country
                    '#afreg_additional_46426'  // Preferred Language
                ];

                if (role === 'distributor') {
                    requiredFields.push(
                        '#afreg_additional_46361', // Distributor Company Size
                        '#afreg_additional_46388'  // Job Title (Distributor)
                    );
                } else if (role === 'safety_professional') {
                    requiredFields.push(
                        '#afreg_additional_46359', // Company Size
                        '#afreg_additional_46435'  // Job Title (Safety Professional)
                    );
                }

                requiredFields.forEach(selector => {
                    const field = document.querySelector(selector);
                    if (field) {
                        const isSelect = field.tagName === 'SELECT';
                        const isEmpty = isSelect ? field.value === '' || field.value === 'Choose Your Country' : field.value.trim() === '';

                        if (isEmpty) {
                            field.classList.add('required-field-error');
                            isValid = false;
                        }
                    }
                });

                const companyLocation = document.querySelector('#afreg_additional_46360');
                if (companyLocation && (companyLocation.value === '' || companyLocation.value === 'Choose Your Country')) {
                    companyLocation.classList.add('required-field-error');
                    isValid = false;
                }

                const businessEmail = document.querySelector('#afreg_additional_46362');
                if (businessEmail && !businessEmail.value.trim()) {
                    businessEmail.classList.add('required-field-error');
                    isValid = false;
                }

                if (submitButton) {
                    submitButton.disabled = !isValid;
                }

                return isValid;
            }

            const submitButton = document.querySelector('.woocommerce-form-register__submit');
            if (submitButton) {
                submitButton.disabled = true;

                submitButton.addEventListener('mouseover', function() {
                    if (this.disabled) {
                        validateRequiredFields();
                        document.querySelectorAll('.required-field-error').forEach(el => {
                            el.classList.add('show-required-fields');
                            setTimeout(() => {
                                el.classList.remove('show-required-fields');
                            }, 1000);
                        });
                    }
                });

                submitButton.addEventListener('click', function(e) {
                    if (!validateRequiredFields() || !validateEmailDomain()) {
                        e.preventDefault();
                    }
                });
            }

            const formFields = [
                '#afreg_additional_46359', // Company Size (Safety Professional)
                '#afreg_additional_46360', // Company Location
                '#afreg_additional_46361', // Distributor Company Size
                '#afreg_additional_46362', // Business Email
                '#afreg_additional_46385', // First Name
                '#afreg_additional_46387', // Last Name
                '#afreg_additional_46388', // Job Title (Distributor)
                '#afreg_additional_46389', // Phone Number
                '#afreg_additional_46391', // Company Name
                '#afreg_additional_46392', // Street Address
                '#afreg_additional_46394', // City
                '#afreg_additional_46396', // Post Code
                '#afreg_additional_46397', // Country
                '#afreg_additional_46426', // Preferred Language
                '#afreg_additional_46435'  // Job Title (Safety Professional)
            ];

            formFields.forEach(selector => {
                const field = document.querySelector(selector);
                if (field) {
                    field.addEventListener('change', validateRequiredFields);
                    field.addEventListener('input', function() {
                        if (this.tagName !== 'SELECT') {
                            validateRequiredFields();
                        }
                    });
                }
            });

            function moveFieldMessages() {
                document.querySelectorAll('.af-dependable-field').forEach(field => {
                    const label = field.querySelector('label');
                    const message = field.querySelector('.afreg_field_message, .afreg_field_message_radio');
                    const input = field.querySelector('input:not([type="hidden"]), select, textarea');

                    if (label && message && input) {
                        if (message.previousElementSibling !== label) {
                            label.insertAdjacentElement('afterend', message);
                        }
                    }
                });
            }

            moveFieldMessages();

            function radioLabelsFix() {
                document.querySelectorAll('.afreg_radio').forEach(radioLabel => {
                    const radioInput = radioLabel.previousElementSibling;

                    if (radioInput && radioInput.type === 'radio') {
                        radioLabel.addEventListener('click', () => {
                            radioInput.checked = true;
                            const event = new Event('change', { bubbles: true });
                            radioInput.dispatchEvent(event);
                        });
                        radioLabel.style.cursor = 'pointer';
                    }
                });
            }

            radioLabelsFix();

            // Utility to wait until an element is present in the DOM
            const waitForElement = (selector, callback) => {
                const el = document.querySelector(selector);
                if (el) return callback(el);
                const observer = new MutationObserver(() => {
                    const el = document.querySelector(selector);
                    if (el) {
                        observer.disconnect();
                        callback(el);
                    }
                });
                observer.observe(document.body, { childList: true, subtree: true });
            };

            // Main logic once elements are ready
            waitForElement('#afreg_additional_46360', () => {

                const companyLocation = document.getElementById('afreg_additional_46360');
                const country = document.getElementById('afreg_additional_46397');

                const stateField = document.getElementById('afreg_additionalshowhide_46395');
                const provinceField = document.getElementById('afreg_additionalshowhide_46423');
                const mexicanField = document.getElementById('afreg_additionalshowhide_46424');

                const stateSelect = document.getElementById('afreg_additional_46395');
                const provinceSelect = document.getElementById('afreg_additional_46423');
                const mexicanSelect = document.getElementById('afreg_additional_46424');

                const mexicanLabel = mexicanField?.querySelector('label');

                // New generic State* field
                const otherStateField = document.getElementById('afreg_additionalshowhide_46525');
                const otherStateInput = document.getElementById('afreg_additional_46525');

                // Show or hide an element by toggling the 'hidden-state' class
                function setVisibility(el, visible) {
                    if (!el) return;
                    if (visible) {
                        el.classList.remove('hidden-state');
                    } else {
                        el.classList.add('hidden-state');
                    }
                }

                // Make a field required or not
                function toggleRequired(el, required) {
                    if (el) {
                        if (required) {
                            el.setAttribute('required', 'required');
                        } else {
                            el.removeAttribute('required');
                        }
                    }
                }

                // Synchronize values of both select fields
                function syncSelects(value) {
                    companyLocation.value = value;
                    country.value = value;
                }

                // Update visibility and required state based on selected country
                function updateFields(value) {
                    setVisibility(stateField, false);
                    setVisibility(provinceField, false);
                    setVisibility(mexicanField, false);
                    setVisibility(otherStateField, false);

                    toggleRequired(stateSelect, false);
                    toggleRequired(provinceSelect, false);
                    toggleRequired(mexicanSelect, false);
                    toggleRequired(otherStateInput, false);

                    if (value === 'United States') {
                        setVisibility(stateField, true);
                        toggleRequired(stateSelect, true);
                    } else if (value === 'Canada') {
                        setVisibility(provinceField, true);
                        toggleRequired(provinceSelect, true);
                    } else if (value === 'Mexico') {
                        setVisibility(mexicanField, true);
                        toggleRequired(mexicanSelect, true);
                        if (mexicanLabel) {
                            mexicanLabel.textContent = 'States';
                        }
                    } else {
                        setVisibility(otherStateField, true);
                        toggleRequired(otherStateInput, true);
                    }
                }

                function handleChange(e) {
                    const value = e.target.value;
                    syncSelects(value);
                    updateFields(value);
                }

                companyLocation.addEventListener('change', handleChange);
                country.addEventListener('change', handleChange);

                // Hide all on load
                [stateField, provinceField, mexicanField, otherStateField].forEach(el => {
                    if (el) el.classList.add('hidden-state');
                });

                // Initial sync and update if value exists
                const initialValue = companyLocation.value || country.value;
                if (initialValue) {
                    syncSelects(initialValue);
                    updateFields(initialValue);
                }
            });


        });
    </script>
    <?php
}

add_filter('wpcf7_form_tag', 'auto_fill_cf7_fields_for_logged_user', 10, 2);

function auto_fill_cf7_fields_for_logged_user($tag, $unused) {
    if (!is_user_logged_in()) {
        return $tag;
    }

    $current_user = wp_get_current_user();

    // Pull email from AFREG custom meta field
    $afreg_email = get_user_meta($current_user->ID, 'afreg_additional_46390', true);
    $email_to_use = !empty($afreg_email) ? $afreg_email : $current_user->user_email;

    // Auto-fill hidden email field
    if ($tag['name'] === 'your-email') {
        if (empty($tag['values'])) {
            $tag['values'][] = $email_to_use;
            $tag['raw_values'][] = $email_to_use;
        }
    }

    // Auto-fill hidden user role field
    if ($tag['name'] === 'user_role') {
        $user_role = get_user_meta($current_user->ID, 'afreg_select_user_role', true);

        if (!empty($user_role)) {
            $tag['values'][] = $user_role;
            $tag['raw_values'][] = $user_role;
        }
    }

    return $tag;
}




/**
 * Check cart items on the cart/checkout pages.
 * If the cart has more than 3 items, keep only the first 3 and remove the rest.
 */
add_action('template_redirect', 'check_cart_items_on_cart_page');

function check_cart_items_on_cart_page() {
    // Only run on cart or checkout pages
    if (is_cart() || is_checkout()) {
        $cart_items = WC()->cart->get_cart();
        $cart_items_count = count($cart_items);

        // If cart has more than 3 items, remove extras
        if ($cart_items_count > 3) {
            $items_kept = 0; // Counter for kept items

            foreach ($cart_items as $cart_item_key => $cart_item) {
                $items_kept++;

                // Remove items after the first 3
                if ($items_kept > 3) {
                    WC()->cart->remove_cart_item($cart_item_key);
                }
            }

            // Show a notice to the user
            wc_add_notice(__('Maximum 3 items allowed in cart. Extra items were removed.', 'supglove'), 'notice');
        }
    }
}
add_action( 'user_register', function( $user_id ) {
	if ( isset( $_POST['afreg_select_user_role'] ) ) {
		$role = sanitize_text_field( $_POST['afreg_select_user_role'] );

		if ( in_array( $role, [ 'distributor', 'safety_professional', 'other' ], true ) ) {
			$user = new WP_User( $user_id );
			$user->set_role( $role );
		}
	}
}, 100 );

add_filter( 'afreg_override_user_role', function( $role ) {
	if ( is_account_page() && is_user_logged_in() ) {
		$custom = get_user_meta( get_current_user_id(), 'afreg_select_user_role', true );
		if ( in_array( $custom, [ 'distributor', 'safety_professional', 'other' ], true ) ) {
			return $custom;
		}
	}
	return $role;
});
add_action( 'init', function () {
	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();
		$afreg_meta = get_user_meta( $user->ID, 'afreg_select_user_role', true );

		if ( empty( $afreg_meta ) && in_array( $user->roles[0], [ 'distributor', 'safety_professional', 'other' ], true ) ) {
			update_user_meta( $user->ID, 'afreg_select_user_role', $user->roles[0] );
		}
	}
} );
add_action( 'template_redirect', function () {
	if ( is_account_page() && is_user_logged_in() ) {
		$user     = wp_get_current_user();
		$meta_val = get_user_meta( $user->ID, 'afreg_select_user_role', true );

		// If meta is empty but user has a valid role, backfill it
		if ( empty( $meta_val ) && in_array( $user->roles[0], [ 'distributor', 'safety_professional', 'other' ], true ) ) {
			update_user_meta( $user->ID, 'afreg_select_user_role', $user->roles[0] );
		}
	}
} );
add_action( 'woocommerce_before_account_navigation', function() {
	if ( is_user_logged_in() && is_account_page() ) {
		echo '<div class="woocommerce-account-title" style="text-align:center; margin: 30px 0 15px;">';
		echo '<h1>Your Account</h1>';
		echo '</div>';
	}
});


add_filter( 'woocommerce_checkout_fields', function( $fields ) {
    foreach ( [ 'billing', 'shipping', 'order' ] as $fieldset ) {
        if ( isset( $fields[ $fieldset ] ) ) {
            foreach ( $fields[ $fieldset ] as $key => $field ) {
                $fields[ $fieldset ][ $key ]['required'] = false;
                $fields[ $fieldset ][ $key ]['validate'] = []; // Remove all validation rules
            }
        }
    }
    return $fields;
});




// 1. Rename the endpoint from 'orders' to 'samples'
add_filter( 'woocommerce_get_query_vars', 'rename_orders_endpoint' );
function rename_orders_endpoint( $vars ) {
    $vars['samples'] = $vars['orders']; // Reassign endpoint
    unset( $vars['orders'] ); // Remove old
    return $vars;
}

// 2. Rename menu label to "Samples" AND preserve menu order
add_filter( 'woocommerce_account_menu_items', 'rename_orders_menu_item_with_position', 99 );
function rename_orders_menu_item_with_position( $items ) {
    $logout = $items['customer-logout'];
    unset( $items['customer-logout'] ); // Temporarily remove logout

    if ( isset( $items['orders'] ) ) {
        $new_items = [];
        foreach ( $items as $key => $value ) {
            if ( $key === 'orders' ) {
                $new_items['samples'] = __( 'Samples', 'woocommerce' );
            } else {
                $new_items[$key] = $value;
            }
        }
        $items = $new_items;
    }

    $items['customer-logout'] = $logout; // Add logout back to the end
    return $items;
}

// 3. Hook the same content to the new endpoint
add_action( 'woocommerce_account_samples_endpoint', 'woocommerce_account_orders' );


add_filter('woocommerce_registration_redirect', 'custom_redirect_after_registration');
function custom_redirect_after_registration( $redirect ) {
    return site_url('/thank-you-registration/'); // <-- Change to your actual page slug or URL
}


add_action('wp_footer', 'force_wc_rememberme_checkbox_checked');
function force_wc_rememberme_checkbox_checked() {
    if (is_account_page()) {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var rememberMe = document.querySelector('input[name="rememberme"]');
                if (rememberMe) {
                    rememberMe.checked = true;
                }
            });
        </script>
        <?php
    }
}
function thank_you_button_shortcode() {
    if (!class_exists('WooCommerce')) {
        return '';
    }

    if (WC()->cart->is_empty()) {
        return '<a href="https://supglovstaging.wpenginepowered.com/whats-new/" class="buttonogs btn_small btn_theme_color" target="_self"><span>Discover More</span></a>';
    } else {
        $checkout_url = wc_get_checkout_url();
        return '<a href="' . esc_url($checkout_url) . '" class="buttonogs btn_small btn_theme_color" target="_self"><span>Get Samples</span></a>';
    }
}
add_shortcode('thank_you_btn', 'thank_you_button_shortcode');

// Brad's Webhook code

add_filter('woocommerce_webhook_payload', 'add_custom_user_meta_to_webhook', 10, 4);

function add_custom_user_meta_to_webhook($payload, $resource, $resource_id, $webhook) {
    // Only apply to order or customer webhooks
    if ($resource !== 'order' && $resource !== 'customer') return $payload;

    $user_id = null;

    if ($resource === 'order') {
        $order = wc_get_order($resource_id);
        if (!$order) return $payload;
        $user_id = $order->get_user_id();
    }

    if ($resource === 'customer') {
        $user = get_user_by('id', $resource_id);
        if (!$user) return $payload;
        $user_id = $user->ID;
    }

    if (!$user_id) return $payload;

    // Resolve job title (Safety Pro takes priority, fallback to Distributor)
    $job_title = get_user_meta($user_id, 'afreg_additional_46435', true); // Safety Professional
    if (empty($job_title)) {
        $job_title = get_user_meta($user_id, 'afreg_additional_46388', true); // Distributor fallback
    }

    // Collect relevant user meta fields 
    // PLEASE DON'T CHANGE FIELD NAMES LINKED TO ZAPIER MAPPING THANK YOU - Brad
    $user_meta = [
    'user_role'     => get_user_meta($user_id, 'afreg_select_user_role', true),
    'afreg_additional_46385' => get_user_meta($user_id, 'afreg_additional_46385', true),
    'afreg_additional_46387' => get_user_meta($user_id, 'afreg_additional_46387', true),
    'user_job_title'         => $job_title,
    'afreg_additional_46391' => get_user_meta($user_id, 'afreg_additional_46391', true),
    'afreg_additional_46360' => get_user_meta($user_id, 'afreg_additional_46360', true),
    'afreg_additional_46359' => get_user_meta($user_id, 'afreg_additional_46359', true),
    'afreg_additional_46426' => get_user_meta($user_id, 'afreg_additional_46426', true), // Language 
    'afreg_additional_46383' => get_user_meta($user_id, 'afreg_additional_46383', true), // Email opt-in 
    'product_sku_1' => get_post_meta($resource_id, 'product_sku_1', true),
    'product_sku_2' => get_post_meta($resource_id, 'product_sku_2', true),
    'product_sku_3' => get_post_meta($resource_id, 'product_sku_3', true),
    '_billing_business_size' => get_post_meta($resource_id, '_billing_business_size', true),
    'Billing-Country' => get_post_meta($resource_id, '_billing_country', true),
    'Email-Opt-in' => get_post_meta($resource_id, '_billing_email_opt_in', true),
    '_billing_language' => get_post_meta($resource_id, '_billing_language', true),
    '_bhww_prosubtitle' => get_post_meta($resource_id, '_bhww_prosubtitle', true),
];

    // Add user data to payload
    $payload['custom_user_data'] = $user_meta;

    return $payload;
}

// Registration Sync: Map AFREG Fields to WooCommerce Billing Meta
add_action('user_register', function($user_id) {

    // Core AFREG → WooCommerce field mappings
    $afreg_to_wc = [
        'afreg_additional_46385' => 'billing_first_name',
        'afreg_additional_46387' => 'billing_last_name',
        'afreg_additional_46391' => 'billing_company',
        'afreg_additional_46392' => 'billing_address_1',
        'afreg_additional_46393' => 'billing_address_2',
        'afreg_additional_46394' => 'billing_city',
        'afreg_additional_46396' => 'billing_postcode',
        'afreg_additional_46389' => 'billing_phone',
        'afreg_additional_46390' => 'billing_email',
    ];

    foreach ($afreg_to_wc as $afreg_key => $wc_key) {
        $value = get_user_meta($user_id, $afreg_key, true);
        if (!empty($value)) {
            update_user_meta($user_id, $wc_key, sanitize_text_field($value));
        }
    }

    // Country Mapping (46360 is our master)
    $country = get_user_meta($user_id, 'afreg_additional_46360', true);
    $country_map = [
        'United States' => 'US',
        'Canada' => 'CA',
        'Mexico' => 'MX',
        'US' => 'US',
        'CA' => 'CA',
        'MX' => 'MX',
    ];
    $country = isset($country_map[$country]) ? $country_map[$country] : $country;
    update_user_meta($user_id, 'billing_country', sanitize_text_field($country));

    // State Fields Mapping — fully corrected based on your actual AFREG form:
    $state_fields = [
        'US' => 'afreg_additional_46395',  // US select dropdown
        'CA' => 'afreg_additional_46423',  // CA select dropdown
        'MX' => 'afreg_additional_46424',  // MX select dropdown
        'Other' => 'afreg_additional_46525' // Other text input
    ];

    $field_key = isset($state_fields[$country]) ? $state_fields[$country] : $state_fields['Other'];
    $state_value = trim(get_user_meta($user_id, $field_key, true));

    // Handle dropdowns and text field separately
    if ($country === 'Other') {
        if (!empty($state_value)) {
            update_user_meta($user_id, 'billing_state', sanitize_text_field($state_value));
        } else {
            update_user_meta($user_id, 'billing_state', '');
        }
    } else {
        if (!empty($state_value) && strtolower($state_value) !== 'please choose...') {
            update_user_meta($user_id, 'billing_state', sanitize_text_field($state_value));
        } else {
            update_user_meta($user_id, 'billing_state', '');
        }
    }

    // Job Title Mapping (Safety Professional Logic)
    $job_title = get_user_meta($user_id, 'afreg_additional_46435', true);
    if (empty($job_title)) {
        $job_title = get_user_meta($user_id, 'afreg_additional_46388', true);
    }
    if (!empty($job_title)) {
        update_user_meta($user_id, 'billing_job_title', sanitize_text_field($job_title));
    }
});

// Autofill Billing Fields into Checkout from WooCommerce Billing Meta
add_action('wp_enqueue_scripts', function () {
    if (!is_checkout() || !is_user_logged_in()) return;

    $current_user = wp_get_current_user();

    $user_meta = [
        'billing_first_name' => get_user_meta($current_user->ID, 'billing_first_name', true),
        'billing_last_name' => get_user_meta($current_user->ID, 'billing_last_name', true),
        'billing_company' => get_user_meta($current_user->ID, 'billing_company', true),
        'billing_address_1' => get_user_meta($current_user->ID, 'billing_address_1', true),
        'billing_address_2' => get_user_meta($current_user->ID, 'billing_address_2', true),
        'billing_city' => get_user_meta($current_user->ID, 'billing_city', true),
        'billing_state' => get_user_meta($current_user->ID, 'billing_state', true),
        'billing_postcode' => get_user_meta($current_user->ID, 'billing_postcode', true),
        'billing_country' => get_user_meta($current_user->ID, 'billing_country', true),
        'billing_phone' => get_user_meta($current_user->ID, 'billing_phone', true),
        'billing_email' => get_user_meta($current_user->ID, 'billing_email', true),
        'billing_job_title' => get_user_meta($current_user->ID, 'billing_job_title', true),
    ];

    $js_data = wp_json_encode($user_meta);

    wp_add_inline_script('jquery', "
        document.addEventListener('DOMContentLoaded', function () {
            try {
                const userData = $js_data;
                const fieldMap = {
                    'billing_first_name': 'billing_first_name',
                    'billing_last_name': 'billing_last_name',
                    'billing_company': 'billing_company',
                    'billing_address_1': 'billing_address_1',
                    'billing_address_2': 'billing_address_2',
                    'billing_city': 'billing_city',
                    'billing_state': 'billing_state',
                    'billing_postcode': 'billing_postcode',
                    'billing_country': 'billing_country',
                    'billing_phone': 'billing_phone',
                    'billing_email': 'billing_email',
                    'billing_job_title': 'billing_job_title'
                };

                Object.entries(userData).forEach(([key, val]) => {
                    if (!val) return;
                    const fieldName = fieldMap[key];
                    const el = document.querySelector(`[name='\${fieldName}']`);
                    if (el && el.value === '') {
                        el.value = val;
                        el.dispatchEvent(new Event('input', { bubbles: true }));
                        el.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });
            } catch (e) {
                console.error('Autofill error:', e);
            }
        });
    ");
});




add_filter('request', function($request){
    if (isset($_POST['save_account_details'])) {

        if (empty($_POST['account_first_name'])) {
            $_POST['account_first_name'] = ' ';
        }

        if (empty($_POST['account_last_name'])) {
            $_POST['account_last_name'] = ' ';
        }
    }

    return $request;
});


// Allow saving account details without requiring password
add_filter('woocommerce_customer_save_account_details_errors', function($errors, $user) {
    if (empty($_POST['password_1']) && empty($_POST['password_current']) && empty($_POST['password_2'])) {
        $errors->remove('current_password');
        $errors->remove('new_password');
        $errors->remove('confirm_password');
    }
    return $errors;
}, 10, 2);

// Save User Role to Order Meta (for WooCommerce & Zapier)
add_action('woocommerce_checkout_update_order_meta', function($order_id) {
    $order = wc_get_order($order_id);
    $user_id = $order->get_user_id();

    if (!$user_id) return;

    // User Role
    $user_role = get_user_meta($user_id, 'afreg_select_user_role', true);
    if (!empty($user_role)) {
        update_post_meta($order_id, '_billing_user_role', $user_role);
    }
});

// Display User Role inside WooCommerce Admin
add_action('woocommerce_admin_order_data_after_billing_address', function($order){
    $user_role = get_post_meta($order->get_id(), '_billing_user_role', true);
    if ($user_role) {
        echo '<p><strong>User Role:</strong> ' . esc_html($user_role) . '</p>';
    }
});

add_action('wp_footer', 'enqueue_update_sizing_inputs_script');
function enqueue_update_sizing_inputs_script() {
    if (!is_checkout()) return;
    ?>
    <script>
        function updateSizingInputsVisibility() {
            const firstInput = document.querySelector('.thwmsc-tab-panel.info_contact #product_1_sizing_value_field');
            const secondInput = document.querySelector('.thwmsc-tab-panel.info_contact #product_2_sizing_value_field');
            const thirdInput = document.querySelector('.thwmsc-tab-panel.info_contact #product_3_sizing_value_field');

            const cartItems = document.querySelectorAll('.thwmsc-tab-panel.info_contact .woocommerce-checkout-review-order-table .cart_item');

            // Abort if any required element is missing
            if (!firstInput || !secondInput || !thirdInput || cartItems.length === 0) {
                return;
            }

            secondInput.classList.remove('hidden');
            thirdInput.classList.remove('hidden');

            // Hide inputs based on number of cart items
            if (cartItems.length < 2) {
                secondInput.classList.add('hidden');
            }

            if (cartItems.length < 3) {
                thirdInput.classList.add('hidden');
            }

        }

        document.addEventListener("DOMContentLoaded", function () {
            updateSizingInputsVisibility();

            // Re-run on WooCommerce AJAX checkout updates
            document.body.addEventListener('updated_checkout', function () {
                updateSizingInputsVisibility();
            });
        });
    </script>
    <?php
}

add_filter('woocommerce_add_cart_item_data', 'add_enquired_flag_to_cart_item', 10, 3);
function add_enquired_flag_to_cart_item($cart_item_data, $product_id, $variation_id) {
    $is_enquired = get_post_meta($product_id, '_enquired_product', true);
    if ($is_enquired === 'yes') {
        $cart_item_data['_enquired_product'] = 'yes';
    }
    return $cart_item_data;
}

add_action('woocommerce_checkout_create_order_line_item', 'save_enquired_meta_to_order', 10, 4);
function save_enquired_meta_to_order($item, $cart_item_key, $values, $order) {
    if (!empty($values['_enquired_product']) && $values['_enquired_product'] === 'yes') {
        $item->add_meta_data('_enquired_product', 'yes', true);
    }
}

add_action('woocommerce_checkout_update_order_meta', 'save_enquired_flag_to_order_meta');
function save_enquired_flag_to_order_meta($order_id) {
    $order = wc_get_order($order_id);
    $has_enquired = false;

    foreach ($order->get_items() as $item) {
        if ($item->get_meta('_enquired_product') === 'yes') {
            $has_enquired = true;
            break;
        }
    }

    update_post_meta($order_id, '_has_enquired_product', $has_enquired ? 'yes' : 'no');
}

add_action('woocommerce_admin_order_data_after_order_details', 'display_enquired_product_flag_in_order_admin');
function display_enquired_product_flag_in_order_admin($order) {
    $flag = get_post_meta($order->get_id(), '_has_enquired_product', true);
    ?>
    <p style="padding-top: 15px!important;clear: both;">
        <strong>Enquired Product in Order:</strong>
        <span><?php echo $flag === 'yes' ? 'Yes' : 'No'; ?></span>
    </p>
    <?php
}

function enqueue_salesforce_chat() {
    if (is_user_logged_in()) {
        ?>
        <script type='text/javascript'>
            function initEmbeddedMessaging() {
                try {
                    embeddedservice_bootstrap.settings.language = 'en_US'; // For example, enter 'en' or 'en-US'
                    embeddedservice_bootstrap.init(
                        '00Di0000000dad5',
                        'Website_Live_Chat',
                        'https://superiorglove.my.site.com/ESWWebsiteLiveChat1756400992389',
                        {
                            scrt2URL: 'https://superiorglove.my.salesforce-scrt.com'
                        }
                    );
                } catch (err) {
                    console.error('Error loading Embedded Messaging: ', err);
                }
            }
        </script>
        <script type='text/javascript' src='https://superiorglove.my.site.com/ESWWebsiteLiveChat1756400992389/assets/js/bootstrap.min.js' onload='initEmbeddedMessaging()'></script>
        <?php
    }
}
add_action('wp_footer', 'enqueue_salesforce_chat');