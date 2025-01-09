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
	add_theme_support(
		'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
		)
	);

    	
    add_post_type_support( 'page', 'excerpt' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors.
 	 */
	add_theme_support( 'customize-selective-refresh-widgets' );


	// Load default block styles.
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'align-wide' );

	add_theme_support( 'align-full' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

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







///////////////////////////////////////////
//START FORTUNA
// --------   Visual Composer  --------- //
///////////////////////////////////////////

// Initialize Visual Composer as part of the theme
if(function_exists('vc_set_as_theme')){

	vc_set_as_theme(true);

	// Disable front end editor
	vc_disable_frontend();

	// Remove Brainstormforce link in Dashboard & Nag message
	define('BSF_UNREG_MENU', true);
	define('BSF_7320433_NAG', false);

	// Set custom VC templates DIR
	$vc_res_dir = get_template_directory().'/vc_templates/';
	vc_set_shortcodes_templates_dir($vc_res_dir);

	// Call custom method that extends VC shortcodes
	load_template( trailingslashit( get_template_directory() ) . 'inc/shortcodes/vc_shortcodes.php' );

	// Extend VC
	boc_extend_VC_shortcodes();

	// Remove VC default modules
	boc_modify_default_VC_modules();

	// Set VC by default for Page & Portfolio post types
	//vc_set_default_editor_post_types(array('page',	'portfolio'));
	vc_set_default_editor_post_types(array('page'));

	// Replace VC waypoints, we'll use our own in libs.js
	function boc_remove_VC_default_waypoints() {
		// Dequeue VC waypoints.js that is dynamically included when an animated element is found
		wp_deregister_script('waypoints');
	}
	add_action( 'vc_base_register_front_js', 'boc_remove_VC_default_waypoints', 100);
}


//this is called from add_action( 'wp_footer', 'print_my_inline_script' ); that was placed in some of the VC shortcodes
//also using global $myscript;
function print_my_inline_script() {
	global $myscript;
  echo $myscript;
}


remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


function remove_block_css(){
wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );


add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );
function my_deregister_javascript() {
   if ( !is_admin() ){
       wp_deregister_script( 'wp-embed' );
   }
}
//	Enqueue BOC Styles
add_action( 'wp_enqueue_scripts', 'boc_styles' );
function boc_styles() {
  wp_dequeue_style( 'wp-block-library' );
}

//	Enqueue additional production Styles
add_action( 'wp_enqueue_scripts', 'custom_prod_styles' );
function custom_prod_styles() {
  wp_enqueue_style( 'additional-prod-style', get_stylesheet_directory_uri() . '/css/fixing_styles.css', array(), time() );
}

//	Enqueue fixing styles
add_action( 'wp_enqueue_scripts', 'fixing_styles' );
function fixing_styles() {
  wp_enqueue_style( 'fixing_styles', get_stylesheet_directory_uri() . '/additional-prod-style.css', array(), '1.2.10.2' );
}

//	Enqueue additional production Scripts
add_action( 'wp_enqueue_scripts', 'custom_prod_scripts', 999);
function custom_prod_scripts() {
  wp_enqueue_script( 'additional-prod-script', get_stylesheet_directory_uri() . '/additional-prod-script.js', array('jquery'), '1.1.9.3', true );
}

add_action( 'wp_enqueue_scripts', 'linkedin_tracking_scripts', 999);
function linkedin_tracking_scripts() {
    wp_enqueue_script( 'linkedin_tracking_scripts', get_stylesheet_directory_uri() . '/linkedin-tracking.js', array('jquery'), '1.1.5', true );
}

function themename_post_formats_setup() {
 add_theme_support( 'post-formats', array( 'link' ) );
}
add_action( 'after_setup_theme', 'themename_post_formats_setup' );

function themename_custom_post_formats_setup() {
 // add post-formats to post_type 'page'
 add_post_type_support( 'post', 'post-formats' );
}
add_action( 'init', 'themename_custom_post_formats_setup' );






// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Add to Sample Box', 'woocommerce' );
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Add to Sample Box', 'woocommerce' );
}



remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

function my_woocommerce_widget_shopping_cart_button_view_cart() {
    echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="buttonogs btn_small btn_dark2">' . esc_html__( 'View Sample Box', 'woocommerce' ) . '</a>';
}
function my_woocommerce_widget_shopping_cart_proceed_to_checkout() {
    echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="  wc-forward buttonogs btn_large btn_theme_color ">' . esc_html__( 'Get Samples', 'woocommerce' ) . '</a>';
}
add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_button_view_cart', 10 );
add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );


add_filter( 'woocommerce_product_description_tab_title', 'bbloomer_rename_description_product_tab_label' );
function bbloomer_rename_description_product_tab_label() {
    return 'Details';
}
















## ---- COMPARE OVERRIDE SELECT 3 ---- ##
## ---- COMPARE OVERRIDE SELECT 3 ---- ##
## ---- COMPARE OVERRIDE SELECT 3 ---- ##
## ---- COMPARE OVERRIDE SELECT 3 ---- ##
## ---- COMPARE OVERRIDE SELECT 3 ---- ##
//help from https://stackoverflow.com/questions/52023865/searchable-multiple-product-select-custom-field-for-woocommerce

function crp_get_product_related_ids2() {
    global $post, $woocommerce;

    $product_ids = get_post_meta( $post->ID, '_related_ids2', true );
    if( empty($product_ids) )
        $product_ids = array();
    ?>
    <div class="options_group">
        <?php if ( $woocommerce->version >= '3.0' ) : ?>
            <p class="form-field">
                <label for="related_ids2"><?php _e( 'Compare Override (Choose 3 at MOST) ', 'woocommerce' ); ?></label>
                <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="related_ids2" name="related_ids2[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations">
                    <?php
                        foreach ( $product_ids as $product_id ) {
                            $product = wc_get_product( $product_id );
                            if ( is_object( $product ) ) {
                                echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                            }
                        }
                    ?>
                </select> <?php echo wc_help_tip( __( 'Select products you want to show in the compare section.', 'woocommerce' ) ); ?>
            </p>
        <?php endif; ?>
    </div>
    <?php
}

add_action( 'woocommerce_product_options_general_product_data', 'add_custom_fied_in_product_general_fields', 20 );
function add_custom_fied_in_product_general_fields() {
    global $post, $woocommerce;
    crp_get_product_related_ids2();
}


add_action( 'woocommerce_process_product_meta', 'process_product_meta_custom_fied', 20, 1 );
function process_product_meta_custom_fied( $product_id ){
    if( isset( $_POST['related_ids2'] ) ){
        update_post_meta( $product_id, '_related_ids2', array_map( 'intval', (array) wp_unslash( $_POST['related_ids2'] ) ) );
    }
}





## ---- SUPER GLOVES EXTRA WOOCOMMERCE FUNCTIONS ---- ##
## ---- SUPER GLOVES EXTRA WOOCOMMERCE FUNCTIONS ---- ##
## ---- SUPER GLOVES EXTRA WOOCOMMERCE FUNCTIONS ---- ##
## ---- SUPER GLOVES EXTRA WOOCOMMERCE FUNCTIONS ---- ##


// Disable all payment gateways on the checkout page and replace the "Pay" button by "Place order"
add_filter( 'woocommerce_cart_needs_payment', '__return_false' );




// Remove the additional information tab
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );




## ---- 1. Backend ---- ##


	//https://stackoverflow.com/questions/23287358/woocommerce-multi-select-for-single-product-field
	function woocommerce_wp_select_multiple( $field ) {
    global $thepostid, $post, $woocommerce;

    $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
    $field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
    $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
    $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['value']         = isset( $field['value'] ) ? $field['value'] : ( get_post_meta( $thepostid, $field['id'], true ) ? get_post_meta( $thepostid, $field['id'], true ) : array() );

    //echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '">'. wp_kses_post( $field['label'] ) . '</p>';



    //$field['value'] =  array_merge(explode(',', get_post_meta($thepostid, 'glovesizes', true)) , explode(',', get_post_meta($thepostid, 'glovelabels', true)));
   $field['value'] =  array_merge( explode('|', get_post_meta($thepostid, 'supglove_icons', true)));


    foreach ( $field['options'] as $key => $value ) {

    	  echo '<p class="form-fieldx" style="float: left;" >';

    	 // echo '<label for="' . esc_attr( $field['name'] ) . '">'. esc_html( $value ) .'</label>';

        echo '<label style="border: 1px solid #ccc; border-radius: 32px;padding: 5px 10px !important;float: left;display: block;margin: 8px; width: auto;"><input  type="checkbox"  name="' . esc_attr( $field['name'] ) . '"  value="' . esc_attr( $key ) . '" ' . ( in_array( $key, $field['value'] ) ? 'checked="checked"' : '' ) . '> ' . esc_attr( $value )  . '</label>';


        echo '</p>';


    }


    if ( ! empty( $field['description'] ) ) {

        if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
            echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
        } else {
            echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
        }

    }
    echo '</p>';
}







// Display Fields
add_action('woocommerce_product_options_general_product_data', 'woocommerce_product_custom_fields');

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












// Save Fields
add_action('woocommerce_process_product_meta', 'woocommerce_product_custom_fields_save');
function woocommerce_product_custom_fields_save($post_id){
    $woocommerce_custom_procut_textarea = $_POST['_bhww_prosubtitle'];
    if (!empty($woocommerce_custom_procut_textarea))
        update_post_meta($post_id, '_bhww_prosubtitle', esc_html($woocommerce_custom_procut_textarea));

    $labels = array();
    if(!empty($_POST['supglove_icons'])) {
	    foreach($_POST['supglove_icons'] as $check) {
	            echo $labels[] =  esc_html($check); //echoes the value set in the HTML form for each checked checkbox.
	                         //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
	                         //in your case, it would echo whatever $row['Report ID'] is equivalent to.
	    }
		}
    if (!empty($labels) || $labels !== ""){
        //$sizes = maybeserialize($sizes);
        update_post_meta($post_id, 'supglove_icons',implode ("|", $labels));
    }


   /* $sizes = array();
    if(!empty($_POST['glovesizes'])) {
	    foreach($_POST['glovesizes'] as $check2) {
	            echo $sizes[] = esc_html($check2); //echoes the value set in the HTML form for each checked checkbox.
	                         //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
	                         //in your case, it would echo whatever $row['Report ID'] is equivalent to.
	    }
		}
    if (!empty($sizes) || $sizes !== ""){
        //$sizes = maybeserialize($sizes);
        update_post_meta($post_id, 'glovesizes', implode (",", $sizes));
    }*/

//    if(!empty($_POST['fittabdetails'])) {
//     update_post_meta($post_id, 'fittabdetails', $_POST['fittabdetails']);
//   }



    //meta:case_dimensions_in
		//meta:ce_en388_certification_code
		//meta:other_ce_certification_codes
		//meta:unspsc_code
		//meta:weight_in_lbs
    //update_post_meta($post_id, 'fittabdetails', $_POST['fittabdetails']);

    update_post_meta($post_id, 'case_dimensions_in', $_POST['case_dimensions_in']);
    update_post_meta($post_id, 'ce_en388_certification_code', $_POST['ce_en388_certification_code']);
    update_post_meta($post_id, 'other_ce_certification_codes', $_POST['other_ce_certification_codes']);
    update_post_meta($post_id, 'unspsc_code', $_POST['unspsc_code']);
    update_post_meta($post_id, 'weight_in_lbs', $_POST['weight_in_lbs']);








}












// ADD DETAILS RIGHT TO BACKEND
// ADD DETAILS RIGHT TO BACKEND
// ADD DETAILS RIGHT TO BACKEND
// ADD DETAILS RIGHT TO BACKEND
// ADD DETAILS RIGHT TO BACKEND
// ADD DETAILS RIGHT TO BACKEND
add_action( 'add_meta_boxes', 'create_custom_meta_boxd' );
if ( ! function_exists( 'create_custom_meta_boxd' ) )
{
    function create_custom_meta_boxd()
    {
        add_meta_box(
            'custom_product_meta_boxd',
            __( 'Details Right Area.  Will add content to the right of main description if used. Content will be 50/50 for the Details tab. <em>(optional)</em>', 'cmb' ),
            'add_custom_content_meta_boxd',
            'product',
            'normal',
            'default'
        );
    }
}

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_boxd' ) ){
    function add_custom_content_meta_boxd( $post ){
        $prefix = '_bhww_'; // global $prefix;

        $specs = get_post_meta($post->ID, $prefix.'specsd_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'specsd_wysiwyg', true) : '';

        $args['textarea_rows'] = 6;

        wp_editor( $specs, 'specsd_wysiwyg', $args );

        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
    }
}










// ADD SPECS A-LEFT TAB TO BACKEND
// ADD SPECS A-LEFT TAB TO BACKEND
// ADD SPECS A-LEFT TAB TO BACKEND
// ADD SPECS A-LEFT TAB TO BACKEND
// ADD SPECS A-LEFT TAB TO BACKEND
add_action( 'add_meta_boxes', 'create_custom_meta_box' );
if ( ! function_exists( 'create_custom_meta_box' ) )
{
    function create_custom_meta_box()
    {
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

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_box' ) ){
    function add_custom_content_meta_box( $post ){
        $prefix = '_bhww_'; // global $prefix;

        $specs = get_post_meta($post->ID, $prefix.'specs_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'specs_wysiwyg', true) : '';

        $args['textarea_rows'] = 6;

        wp_editor( $specs, 'specs_wysiwyg', $args );

        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
    }
}




// ADD SPECS B-RIGHT TAB TO BACKEND
// ADD SPECS B-RIGHT TAB TO BACKEND
// ADD SPECS B-RIGHT TAB TO BACKEND
// ADD SPECS B-RIGHT TAB TO BACKEND
// ADD SPECS B-RIGHT TAB TO BACKEND
add_action( 'add_meta_boxes', 'create_custom_meta_boxb' );
if ( ! function_exists( 'create_custom_meta_boxb' ) )
{
    function create_custom_meta_boxb()
    {
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

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_boxb' ) ){
    function add_custom_content_meta_boxb( $post ){
        $prefix = '_bhww_'; // global $prefix;

        $specs = get_post_meta($post->ID, $prefix.'specsb_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'specsb_wysiwyg', true) : '';

        $args['textarea_rows'] = 6;

        wp_editor( $specs, 'specsb_wysiwyg', $args );

        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
    }
}






// ADD FIT SIZING A-LEFT TAB TO BACKEND
// ADD FIT SIZING A-LEFT TAB TO BACKEND
// ADD FIT SIZING A-LEFT TAB TO BACKEND
// ADD FIT SIZING A-LEFT TAB TO BACKEND
// ADD FIT SIZING A-LEFT TAB TO BACKEND
// Adding a custom Meta container to admin products pages
add_action( 'add_meta_boxes', 'create_custom_meta_box2' );
if ( ! function_exists( 'create_custom_meta_box2' ) )
{
    function create_custom_meta_box2()
    {
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

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_box2' ) ){
    function add_custom_content_meta_box2( $post ){
        $prefix = '_bhww_'; // global $prefix;

        $fitsizing = get_post_meta($post->ID, $prefix.'fitsizing_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'fitsizing_wysiwyg', true) : '';
        $args['textarea_rows'] = 6;

        wp_editor( $fitsizing, 'fitsizing_wysiwyg', $args );

        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
    }
}





// ADD FIT SIZING B-RIGHT TAB TO BACKEND
// ADD FIT SIZING B-RIGHT TAB TO BACKEND
// ADD FIT SIZING B-RIGHT TAB TO BACKEND
// ADD FIT SIZING B-RIGHT TAB TO BACKEND
// ADD FIT SIZING B-RIGHT TAB TO BACKEND
// ADD FIT SIZING B-RIGHT TAB TO BACKEND
// Adding a custom Meta container to admin products pages
add_action( 'add_meta_boxes', 'create_custom_meta_box2b' );
if ( ! function_exists( 'create_custom_meta_box2b' ) )
{
    function create_custom_meta_box2b()
    {
        add_meta_box(
            'custom_product_meta_box2b',
            __( 'Fit and Sizing  (Right Content) <em>(optional)</em>', 'cmb' ),
            'add_custom_content_meta_box2b',
            'product',
            'normal',
            'default'
        );
    }
}

//  Custom metabox content in admin product pages
if ( ! function_exists( 'add_custom_content_meta_box2b' ) ){
    function add_custom_content_meta_box2b( $post ){
        $prefix = '_bhww_'; // global $prefix;

        $fitsizing = get_post_meta($post->ID, $prefix.'fitsizingb_wysiwyg', true) ? get_post_meta($post->ID, $prefix.'fitsizingb_wysiwyg', true) : '';
        $args['textarea_rows'] = 6;

        wp_editor( $fitsizing, 'fitsizingb_wysiwyg', $args );

        echo '<input type="hidden" name="custom_product_field_nonce" value="' . wp_create_nonce() . '">';
    }
}









//Save the data of the Meta field
add_action( 'save_post', 'save_custom_content_meta_box', 10, 1 );
if ( ! function_exists( 'save_custom_content_meta_box' ) )
{

    function save_custom_content_meta_box( $post_id ) {
        $prefix = '_bhww_'; // global $prefix;

        // We need to verify this with the proper authorization (security stuff).

        // Check if our nonce is set.
        if ( ! isset( $_POST[ 'custom_product_field_nonce' ] ) ) {
            return $post_id;
        }
        $nonce = $_REQUEST[ 'custom_product_field_nonce' ];

        //Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce ) ) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'product' == $_POST[ 'post_type' ] ){
            if ( ! current_user_can( 'edit_product', $post_id ) )
                return $post_id;
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        // Sanitize user input and update the meta field in the database.
        update_post_meta( $post_id, $prefix.'specsd_wysiwyg', wp_kses_post($_POST[ 'specsd_wysiwyg' ]) );
        update_post_meta( $post_id, $prefix.'specs_wysiwyg', wp_kses_post($_POST[ 'specs_wysiwyg' ]) );
        update_post_meta( $post_id, $prefix.'specsb_wysiwyg', wp_kses_post($_POST[ 'specsb_wysiwyg' ]) );
        update_post_meta( $post_id, $prefix.'fitsizing_wysiwyg', wp_kses_post($_POST[ 'fitsizing_wysiwyg' ]) );
        update_post_meta( $post_id, $prefix.'fitsizingb_wysiwyg', wp_kses_post($_POST[ 'fitsizingb_wysiwyg' ]) );
    }
}



## ---- 2. Front-end ---- ##

// Create custom tabs in product single pages
add_filter( 'woocommerce_product_tabs', 'custom_product_tabs' );
function custom_product_tabs( $tabs ) {
    global $post;
    $product_specs = get_post_meta( $post->ID, '_bhww_specs_wysiwyg', true );
    $product_fitsizing    = get_post_meta( $post->ID, '_bhww_fitsizing_wysiwyg', true );
   //if ( ! empty( $product_specs ) )
        $tabs['specs_tab'] = array(
            'title'    => __( 'Specs', 'woocommerce' ),
            'priority' => 45,
            'callback' => 'specs_product_tab_content'
        );

    $selectedfitset = get_post_meta( $post->ID, 'fittabdetails', true);
    if ( $selectedfitset !== '' ){
        $tabs['fitsizing_tab'] = array(
            'title'    => __(  'Fit & Sizing', 'woocommerce' ),
            'priority' => 50,
            'callback' => 'fitsizing_product_tab_content'
       );
     }
    return $tabs;
}

// Add content to custom tab in product single pages (1)
function specs_product_tab_content() {
    global $post, $product;

    $product_specs = get_post_meta( $post->ID, '_bhww_specs_wysiwyg', true );
    $product_specsb = get_post_meta( $post->ID, '_bhww_specsb_wysiwyg', true );

    if ( ! empty( $product_specs ) && ! empty( $product_specsb ) ) {
        // Updated to apply the_content filter to WYSIWYG content
        echo '<div class="col col-sm-12 col-md-6">';
        echo apply_filters( 'the_content', $product_specs );
        echo '</div>';
        echo '<div class="col col-sm-12 col-md-6">';
        echo apply_filters( 'the_content', $product_specsb );
        echo '</div>';
    }else if(  ! empty( $product_specs )  ){
        echo '<div class="col col-sm-12 col-md-12">';
        echo apply_filters( 'the_content', $product_specs );
        echo '</div>';
    }else{

    	//let's load attributes and meta here
      //echo '<div class="col-xs-12"><h6>'  .   __( 'Product Specs', 'woocommerce' )  . '</h6></div><div class="clear"></div>' ;
    	wc_display_product_attributes( $product );

    }



}

// Add content to custom tab in product single pages (2)
function fitsizing_product_tab_content() {
    global $post;
    $product_fitsizing = get_post_meta( $post->ID, '_bhww_fitsizing_wysiwyg', true );
    $product_fitsizingb = get_post_meta( $post->ID, '_bhww_fitsizingb_wysiwyg', true );


    $selectedfit = get_post_meta( $post->ID, 'fittabdetails', true);


    if ( ! empty( $product_fitsizing ) && ! empty( $product_fitsizingb ) ) {
        // Updated to apply the_content filter to WYSIWYG content
        echo '<div class="col col-sm-12 col-md-6">';
        echo apply_filters( 'the_content', $product_fitsizing );
        echo '</div>';
        echo '<div class="col col-sm-12 col-md-6">';
        echo apply_filters( 'the_content', $product_fitsizingb );
        echo '</div>';
    }else if(  ! empty( $product_fitsizing )  ){
        echo '<div class="col col-sm-12 col-md-12">';
         echo apply_filters( 'the_content', $product_fitsizing );
        echo '</div>';
    }else{
    	//load global fit sizing details from customizer options


        if(   $selectedfit == 'Gloves' ||  $selectedfit == 'gloves' ||  $selectedfit == 'glove' ||  $selectedfit == 'Glove' ){

    	 	$fitleft = wp_kses_post( supro_get_option( 'fittabdetailsgloveinfo' ) );
    	 	$fitright = wp_kses_post( supro_get_option( 'fittabdetailsinfoglovediagram' ) );

    	 		$fitheader = wp_kses_post( supro_get_option( 'fittabdetailsgloveheader' ) );

    	 	if($fitheader !== ''){
        echo '<div class="col col-sm-12 col-md-12">';
       	 echo $fitheader;
        echo '</div>';
            	 	echo '<div class="clear"></div>';
      }


        echo '<div class="col col-sm-6 col-md-6">';
       	 echo $fitleft;
        echo '</div>';
        echo '<div class="col col-sm-6 col-md-6">';
        	echo $fitright;
        echo '</div>';
       }elseif(   $selectedfit == 'Sleeves' ||  $selectedfit == 'sleeves' ){


    	 	$fitleft = wp_kses_post( supro_get_option( 'fittabdetailssleeveinfo' ) );
    	 	$fitright = wp_kses_post( supro_get_option( 'fittabdetailsinfosleevediagram' ) );

    	 	$fitheader = wp_kses_post( supro_get_option( 'fittabdetailssleeveheader' ) );


    	 	if($fitheader !== ''){
        echo '<div class="col col-sm-12 col-md-12">';
       	 echo $fitheader;
        echo '</div>';
            	 echo '<div class="clear"></div>';
      }


        echo '<div class="col col-sm-6 col-md-6">';
       	 echo $fitleft;
        echo '</div>';
        echo '<div class="col col-sm-6 col-md-6">';
        	echo $fitright;
        echo '</div>';


    }elseif(   $selectedfit == 'Other' ||  $selectedfit == 'other' ){


    $fitleft = wp_kses_post(supro_get_option('fittabdetailsotherinfo'));
    $fitright = wp_kses_post(supro_get_option('fittabdetailsinfootherdiagram'));

    $fitheader = wp_kses_post(supro_get_option('fittabdetailsotherheader'));


    if ($fitheader !== '') {
        echo '<div class="col col-sm-12 col-md-12">';
        echo $fitheader;
        echo '</div>';
        echo '<div class="clear"></div>';
    }


    echo '<div class="col col-sm-6 col-md-6">';
    echo $fitleft;
    echo '</div>';
    echo '<div class="col col-sm-6 col-md-6">';
    echo $fitright;
    echo '</div>';

    }else{  //NONE Selected

      	echo '';

      }

    }




}








/**
* @snippet       Display FREE if Price Zero or Empty - WooCommerce Single Product
* @how-to        Get CustomizeWoo.com FREE
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 3.8
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/

add_filter( 'woocommerce_get_price_html', 'bbloomer_price_free_zero_empty', 9999, 2 );

function bbloomer_price_free_zero_empty( $price, $product ){
    if ( '' === $product->get_price() || 0 == $product->get_price() ) {
        $price = '';
    }
    return $price;
}


add_filter( 'woocommerce_account_menu_items', 'custom_remove_downloads_my_account', 999 );
function custom_remove_downloads_my_account( $items ) {
unset($items['downloads']);
return $items;
}



add_filter( 'woocommerce_my_account_my_orders_columns','your_function_name');
function your_function_name($columns){
    // to remove just use unset
    unset($columns['order-total']); // remove Total column
    //unset($columns['order_date']); // remove Date column
    // now it is time to add a custom one
    //$columns['custom_column'] = "Column title";
    return $columns;
}











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
	if( is_checkout() && ! (  is_wc_endpoint_url( 'order-received' ) ) )  {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$thumbnail = $_product->get_image();


    $is_visible        = $_product && $_product->is_visible();
		$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $_product->get_permalink( $cart_item ) : '', $cart_item, $order );


    /* Add wrapper to image and add some css */
    $image = '<div class="ts-product-image"><div class="innexercheck"><a href="'.	$product_permalink.'" class="product-url">'
                . $thumbnail .
              '</a></div></div>';




     $quickdetails =   '<a href="'.$product_permalink .'" class="product-url-quick">View Items Details</a>';





		/*$remove_link = apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
			'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon icon-uni4D"></i></a>',
			esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
			__( 'Remove this item', 'woocommerce' ),
			esc_attr( $product_id ),
			esc_attr( $_product->get_sku() )
        ), $cart_item_key );*/

		return $image  .'<div class="cartitmedet"><div class="cartitmedetinner">' . $product_name . '<br/><h6 class="sku">PRODUCT ID: '. $_product->get_sku()  .'</h6>'.$quickdetails.'</div></div>';
	}

	return $product_name;
}
add_filter( 'woocommerce_cart_item_name', 'lionplugins_woocommerce_checkout_remove_item', 10, 3 );



function lionplugins_woocommerce_checkout_remove_item2( $product_name, $cart_item, $cart_item_key ) {
	if( is_checkout() && ! (  is_wc_endpoint_url( 'order-received' ) ) )  {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		$thumbnail = $_product->get_image();
    /* Add wrapper to image and add some css */
    $image = '<div class="ts-product-image" style="width: 52px; height: 45px; display: inline-block; padding-right: 7px; vertical-align: middle;">'
                . $thumbnail .
              '</div>';
		$remove_link = apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
			'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon icon-uni4D"></i></a>',
			esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
			__( 'Remove this item', 'woocommerce' ),
			esc_attr( $product_id ),
			esc_attr( $_product->get_sku() )
        ), $cart_item_key );

		return '<span>' . $remove_link . '</span>';
	}

	return $product_name;
}
add_filter( 'woocommerce_cart_item_name2', 'lionplugins_woocommerce_checkout_remove_item2', 10, 3 );








// make sure the priority value is correct, running after the default priority.
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 20 );




add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' );
function woo_custom_order_button_text() {
    return __( 'Request Samples', 'woocommerce' );
}




remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'custom_empty_cart_message', 10 );

function custom_empty_cart_message() {
    $html  = '<div class="col-12"><p class="woocommerce-error">';
    $html .= wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your box  is currently empty.', 'woocommerce' ) ) );
    echo $html . '</p></div>';
}









/*add_action( 'woocommerce_after_single_product_summary','custom_tab_template', 30 );
function custom_tab_template(){
		$tabs = apply_filters( 'woocommerce_product_tabs', array() );

		if ( ! empty( $tabs ) ) : ?>

			<div class="woocommerce-tabs wc-tabs-wrapper">
				<ul class="tabs wc-tabs resp-tabs-list" role="tablist">
					<?php foreach ( $tabs as $key => $tab ) : ?>
						<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
							<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="resp-tabs-container">
					<?php foreach ( $tabs as $key => $tab ) : ?>
						<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
							<?php call_user_func( $tab['callback'], $key, $tab ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>


		<?php endif;
	}*/





function so_33134668_product_validation( $valid, $product_id, $quantity ){

    // Set the max number of products before checking out
    $max_num_products = 3;
    // Get the Cart's total number of products
    $cart_num_products = WC()->cart->cart_contents_count;

    $future_quantity_in_cart = $cart_num_products + $quantity;

    // More than 5 products in the cart is not allowed
    if( $future_quantity_in_cart > $max_num_products ) {
        // Display our error message
        wc_add_notice('<a href="'. wc_get_cart_url(). '" class="button wc-forward">View Sample Box</a> <strong>Sorry! Right now we only allow a maximum of 3 products to be added to your sample box. If you\'d like to add this product please go to your sample box and remove a product.</strong>',  'error' );
        $valid = false; // don't add the new product to the cart
    }
    return $valid;
}
add_filter( 'woocommerce_add_to_cart_validation', 'so_33134668_product_validation', 10, 3 );










function add_wooclass_tosearch_templates($classes) {
    if (is_page_template('searchpage.php')) {
        $classes[] = 'woocommerce';
    }
     return $classes;
}
add_filter('body_class', 'add_wooclass_tosearch_templates');





//disable undo message when removing items
add_filter('woocommerce_cart_item_removed_notice_type', '__return_null');



function smallenvelop_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Header Sidebar', 'smallenvelop' ),
        'id' => 'header-sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );

}
add_action( 'widgets_init', 'smallenvelop_widgets_init' );


add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
    global $woocommerce;

    $cart_items = $woocommerce->cart->get_cart();
    $count = 1;
    if($cart_items) {
        foreach($cart_items as $values) {
            $_product =  wc_get_product( $values['data']->get_id());
            $sku_array[] = $_product->get_sku();
            $fields['billing']['product_sku_' . $count]['default'] = $_product->get_sku();
            $fields['billing']['product_sku_' . $count]['label'] = 'ProductSKU '. $count;
            $fields['billing']['product_sku_' . $count]['class'] = ['hidden_field'];
            $count++;
        }
    };

    return $fields;
}

add_action( 'woocommerce_checkout_update_order_meta', 'glove_custom_checkout_field_update_order_meta' );

function glove_custom_checkout_field_update_order_meta( $order_id ) {
    global $woocommerce;

    $cart_items = $woocommerce->cart->get_cart();
    if($cart_items) {
        $count = 1;
        foreach($cart_items as $values) {
            if ( ! empty( $_POST['product_sku_' . $count] ) ) {
                update_post_meta( $order_id, 'product_sku_' . $count, sanitize_text_field( $_POST['product_sku_' . $count] ) );
            }
            $count++;
        }
    }
}

add_filter( 'woocommerce_email_order_meta_fields', 'glove_custom_woocommerce_email_order_meta_fields', 10, 3 );

function glove_custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {
    global $woocommerce;
    $cart_items = $woocommerce->cart->get_cart();
    if($cart_items) {
        $count = 1;
        foreach($cart_items as $values) {
            $fields['product_sku_' . $count] = array(
                'label' => __('ProductSKU '. $count),
                'value' => get_post_meta($order->id, 'product_sku_' . $count, true),
            );
            $count++;
        }
    }
    return $fields;
}

function glove_get_attachment_by_post_name( $post_name ) {
    $args           = array(
        'posts_per_page' => -1,
		'numberposts' => -1,
        'post_type'      => 'attachment',
        'name'           => trim( $post_name ),
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

    if ($posts) {
        foreach ($posts as $post) {
            $thumbn_id = get_post_thumbnail_id($post->ID);
            $image_data = wp_get_attachment_image_src($thumbn_id, 'full');
            if ($image_data[2] === 0) {
                $sku = get_post_meta($post->ID, '_sku', true);

                $attachment = glove_get_attachment_by_post_name( strtolower($sku) . '-top' );
                if ( $attachment ) {
                    $attachment_id = $attachment->ID;
                    set_post_thumbnail( $post->ID, $attachment_id );
                }
            }
        }
    }
}
//glove_replace_image();

function glove_replace_gallery_image () {
    $args = [
        'post_type' => 'product',
        'numberposts' => -1,
        'post_per_page' => -1,
    ];

    $posts = get_posts($args);

    if ($posts) {
        foreach ($posts as $post) {
            $product = new WC_product($post->ID);
            $attachment_ids = $product->get_gallery_image_ids();
            foreach ($attachment_ids as $attachment_id) {
                $image_data = wp_get_attachment_image_src($attachment_id, 'full');
                if ($image_data[2] === 0) {
                    $sku = get_post_meta($post->ID, '_sku', true);

                    $attachment = glove_get_attachment_by_post_name(strtolower($sku) . '-palm');
                    if ($attachment) {
                        $attachment_id = $attachment->ID;
                        update_post_meta($post->ID, '_product_image_gallery', $attachment_id);
                    }
                }
            }
        }
    }
}
//glove_replace_gallery_image();

add_filter('woocommerce_taxonomy_args_pa_hazards','glove_hierarchical_hazards');
function glove_hierarchical_hazards($data) {
    $data['hierarchical'] = true;
    return $data;
}

add_filter('woocommerce_taxonomy_args_pa_palm_coating','glove_hierarchical_palm_coating');
function glove_hierarchical_palm_coating($data) {
    $data['hierarchical'] = true;
    return $data;
}

add_filter('woocommerce_taxonomy_args_pa_material','glove_hierarchical_material');
function glove_hierarchical_material($data) {
    $data['hierarchical'] = true;
    return $data;
}

function glove_register_tax() {
    if ( ! taxonomy_exists('pa_hazards') ) {
        register_taxonomy('pa_hazards', 'product', ['label' => 'Hazards'] );
    }
}
add_action('init', 'glove_register_tax');

function glove_hierarchical_automatic() {
    global $wpdb;
    $attr_taxonomy_label_array = ['Abrasion', 'Arch flash', 'Cold', 'Cut', 'Heat', 'Impact', 'Puncture probe', 'Hypodermic edle'];
    $attr_taxonomy_array = ['abrasion', 'arch_flash', 'hazards_cold', 'cut', 'hazards_heat', 'impact', 'puncture_probe', 'hypodermic_edle'];

    if ( is_array ( $attr_taxonomy_array ) ) {
        foreach ( $attr_taxonomy_array as $key => $taxonomy ) {
            $result = $wpdb->get_results( $wpdb->prepare("SELECT term_id FROM " . $wpdb->prefix . "term_taxonomy WHERE taxonomy = %s", 'pa_' . $taxonomy));

            if(term_exists($taxonomy, 'pa_hazards')) {
                $term_data = get_term_by('slug', $taxonomy, 'pa_hazards');
            } else {
                $term_data = wp_insert_term( $attr_taxonomy_label_array[$key], 'pa_hazards', [
                    'description' => '',
                    'parent'      => 0,
                    'slug'        => $taxonomy ] );
            }

            $term_parent_id = $term_data->term_id;

            if ( ! empty($result) ) {
                foreach ( $result as $child_term_id ) {
                    if ( ! empty( $term_parent_id ) ) {
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
//add_action('init', 'glove_hierarchical_automatic');

function glove_override_country_fields( $countries ) {
    $countries['UM'] = 'United States Minor Outlying Islands';
    $countries['US'] = 'United States';
    $countries['GB'] = 'United Kingdom';
    return $countries;
}

add_filter('woocommerce_countries','glove_override_country_fields');















add_action( 'woocommerce_thankyou', 'bbloomer_alter_checkout_fields_after_order' );

function bbloomer_alter_checkout_fields_after_order( $order_id ) {
   $order = wc_get_order( $order_id );
   $calling_code = WC()->countries->countries[ $order->get_billing_country() ];
      update_post_meta( $order_id, '_billing_country', $calling_code );
	  update_post_meta( $order_id, 'billing_country', $calling_code );

}


function glove_override_states_fields( $states ) {
    $new_states = [];
    if($states['MX']) {
        foreach($states['MX'] as $state) {
            $new_states['MX'][$state] = ucfirst(strtolower($state));
        }
    }
    return $new_states;
}

add_filter('woocommerce_states','glove_override_states_fields');

add_action( 'woocommerce_checkout_create_order', 'before_checkout_create_order' , 20, 2);
function before_checkout_create_order( $order, $data ) {
    if(!empty($data['billing_state'])) {
        $str = ucfirst(strtolower($data['billing_state']));
        $data['billing_state'] = $str;
    }
    $order->set_address(array(
        'state'  => $str,
    ));
}


// add_filter( 'trp_before_translate_content', 'glove_before_translate_content', 30, 1 );
function glove_before_translate_content( $output ) {
  /*
  ® - &reg;
  ™ - &trade;
  ℠ - &#8480; - SM
  © - &copy;
  ' - &apos; - &#039;
  " - &quot; - &#34;
  ° - &deg; - &#176;
  */
  $output = str_replace( array('®', '™', '℠', '©', '°' ), array( '&#174;', '&#8482;', '&#8480;', '&#169;', '&#176;' ), $output );

  /*if ( ! apply_filters( 'trp_try_fixing_invalid_html', false ) ) {
    if ( defined( 'TRP_PLUGIN_DIR' ) ) {
      require_once TRP_PLUGIN_DIR . 'assets/lib/simplehtmldom/simple_html_dom.php';
    } else {
      require_once WP_PLUGIN_DIR . '/translatepress-multilingual/assets/lib/simplehtmldom/simple_html_dom.php';
    }

    if ( class_exists('DOMDocument') ) {
      $dom = new DOMDocument();
      $dom->encoding = 'utf-8';

      libxml_use_internal_errors(true);//so no warnings will show up for invalid html
      $dom->loadHTML($output, LIBXML_NOWARNING | LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
    }
  }*/

  return $output;
}

// add_action('init', 'register_my_terms');
// function register_my_terms() {

//   $data = array();

//   $data = [
//     'coating_style' => [
//       'No', 'Dotted', 'Double Dip', 'Finger tip', 'Full', 'Palm', 'Patches', 'Strip', 'Three Quarter'
//     ]
//   ];

//   if (empty($data)) return;

//   foreach ($data as $taxonomy => $terms_arr) {
//     $taxonomy = wc_attribute_taxonomy_name($taxonomy);
//     if (empty($taxonomy) || empty($terms_arr)) return;


//     $order = 0;
//     foreach ($terms_arr as $term_to_add) {
//       $termName = trim($term_to_add);
//       $termSlug = str_replace(' ', '_', strtolower($termName));

//       $term = get_term_by('slug', $termSlug, $taxonomy);

//       if (!$term) {
//         $term = wp_insert_term($termName, $taxonomy, array(
//           'slug' => $termSlug,
//         ));

//         $term = get_term_by('id', $term['term_id'], $taxonomy);
//         if ($term) {
//             update_term_meta($term->term_id, 'order', $order);
//         }
//       }
//       $order++;
//     }
//   }
// }

$helpers_dir = get_template_directory() . '/helpers';
require_once($helpers_dir . '/product_helper.php');

$helpers_dir = get_template_directory() . '/helpers';
require_once($helpers_dir . '/info_tables.php');

function exclude_uncategorized( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-1' );
    }
}
add_action('pre_get_posts', 'exclude_uncategorized');

add_filter( 'action_scheduler_retention_period', 'wc_action_scheduler_purge' );
/**
 * Change Action Scheduler default purge to 1 week
 */
function wc_action_scheduler_purge() {
 return WEEK_IN_SECONDS;
}



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
  
  add_action( 'customize_register', 'sg_child_customizer' );
}


if ( ! function_exists('sg_child_customizer_preview') ) {
  function sg_child_customizer_preview() {
    if ( class_exists( 'Kirki' ) ) {
			return;
		}
    
    wp_enqueue_script( 'sg-child-customizer', get_stylesheet_directory_uri() . '/child-customizer.js', array( 'jquery','customize-preview' ), time(), true );
  }
  
  add_action( 'customize_preview_init', 'sg_child_customizer_preview' );
}



// Featured image for sg_type terms

if ( ! function_exists('sg_add_type_image_url_field') ) {
  function sg_add_type_image_url_field( $taxonomy ) {
    ?><div class="form-field term-type_featured_image_url">
      <label for="type_featured_image_url"><?php _e('Featured Image URL', 'SuperiorGlove'); ?></label>
      <input id="type_featured_image_url" class="postform" type="url" name="type_featured_image_url" pattern="https://.*" value="" />
    </div><?php
  }
  
  add_action( 'sg_type_add_form_fields', 'sg_add_type_image_url_field', 10, 2 );
}


if ( ! function_exists('sg_save_type_image_url_meta') ) {
  function sg_save_type_image_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_featured_image_url']) && ('' !== $_POST['type_featured_image_url']) ) {
      $image_url = sanitize_url( $_POST['type_featured_image_url'] );
      add_term_meta( $term_id, 'type_featured_image_url', $image_url, false );
    } else {
      add_term_meta( $term_id, 'type_featured_image_url', '', false );
    }
  }
  
  add_action( 'created_sg_type', 'sg_save_type_image_url_meta', 10, 2 );
}


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

  add_action( 'sg_type_edit_form_fields', 'sg_edit_type_image_url_field', 10, 2 );
}


if ( ! function_exists('sg_update_type_image_url_meta') ) {
  function sg_update_type_image_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_featured_image_url']) && ('' !== $_POST['type_featured_image_url']) ) {
      $image_url = sanitize_url( $_POST['type_featured_image_url'] );
      update_term_meta( $term_id, 'type_featured_image_url', $image_url );
    } else {
      update_term_meta( $term_id, 'type_featured_image_url', '' );
    }
  }

  add_action( 'edited_sg_type', 'sg_update_type_image_url_meta', 10, 2 );
}


// Custom archive link for sg_type terms

if ( ! function_exists('sg_add_type_archive_url_field') ) {
  function sg_add_type_archive_url_field( $taxonomy ) {
    ?><div class="form-field term-type_archive_url">
      <label for="type_archive_url"><?php _e('Custom Archive URL', 'SuperiorGlove'); ?></label>
      <input id="type_archive_url" class="postform" type="url" name="type_archive_url" pattern="https://.*" value="" />
    </div><?php
  }
  
  add_action( 'sg_type_add_form_fields', 'sg_add_type_archive_url_field', 10, 2 );
}


if ( ! function_exists('sg_save_type_archive_url_meta') ) {
  function sg_save_type_archive_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_archive_url']) && ('' !== $_POST['type_archive_url']) ) {
      $archive_url = sanitize_url( $_POST['type_archive_url'] );
      add_term_meta( $term_id, 'type_archive_url', $archive_url, false );
    } else {
      add_term_meta( $term_id, 'type_archive_url', '', false );
    }
  }
  
  add_action( 'created_sg_type', 'sg_save_type_archive_url_meta', 10, 2 );
}


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

  add_action( 'sg_type_edit_form_fields', 'sg_edit_type_archive_url_field', 10, 2 );
}


if ( ! function_exists('sg_update_type_archive_url_meta') ) {
  function sg_update_type_archive_url_meta( $term_id, $tt_id ){
    if ( isset($_POST['type_archive_url']) && ('' !== $_POST['type_archive_url']) ) {
      $archive_url = sanitize_url( $_POST['type_archive_url'] );
      update_term_meta( $term_id, 'type_archive_url', $archive_url );
    } else {
      update_term_meta( $term_id, 'type_archive_url', '' );
    }
  }

  add_action( 'edited_sg_type', 'sg_update_type_archive_url_meta', 10, 2 );
}


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
  
  add_filter( 'rwmb_meta_boxes', 'sg_language_meta_boxes' );
}
