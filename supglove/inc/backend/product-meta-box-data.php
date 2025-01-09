<?php
/**
 * Functions and Hooks for product meta box data
 *
 * @package Supglove
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * supro_Meta_Box_Product_Data class.
 */
class Supro_Meta_Box_Product_Data {

	/**
	 * Constructor.
	 */
	public function __construct() {

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		// Add form
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_meta_fields' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_meta_fields2' ) );


		add_action( 'woocommerce_product_data_tabs', array( $this, 'product_meta_tab' ) );
		add_action( 'woocommerce_product_data_tabs', array( $this, 'product_meta_tab2' ) );


		add_action( 'woocommerce_process_product_meta', array( $this, 'product_meta_fields_save' ) );

		add_action( 'wp_ajax_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );


		add_action( 'wp_ajax_product_meta_fields', array( $this, 'instance_product_meta_fields2' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( $this, 'instance_product_meta_fields2' ) );

	}

	public function enqueue_scripts( $hook ) {
		$screen = get_current_screen();
		if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) && $screen->post_type == 'product' ) {
			wp_enqueue_style( 'wp-color-picker');
       wp_enqueue_script( 'wp-color-picker');
			wp_enqueue_script( 'supro_wc_settings_js', get_template_directory_uri() . '/js/backend/woocommerce.js', array( 'jquery' ), '20190717', true );
			wp_enqueue_style( 'supro_wc_settings_style', get_template_directory_uri() . "/css/woocommerce-settings.css", array(), '20190717' );
		}
	}

	/**
	 * Get product data fields
	 *
	 */
	public function instance_product_meta_fields() {
		$post_id = $_POST['post_id'];
		ob_start();
		$this->create_product_extra_fields( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}


	/**
	 * Get product data fields
	 *
	 */
	public function instance_product_meta_fields2() {
		$post_id = $_POST['post_id'];
		ob_start();
		$this->create_product_extra_fields2( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}



	/**
	 * Product data tab
	 */
	public function product_meta_tab( $product_data_tabs ) {

		$product_data_tabs['supro_attributes_extra'] = array(
			'label'  => esc_html__( 'Extra', 'supro' ),
			'target' => 'product_attributes_extra',
			'class'  => 'product-attributes-extra'
		);

		return $product_data_tabs;
	}


	/**
	 * Product data tab2
	 */
	public function product_meta_tab2( $product_data_tabs ) {

		$product_data_tabs['supro_attributes_extra2'] = array(
			'label'  => esc_html__( 'Extra Product Details', 'supro' ),
			'target' => 'product_attributes_extra2',
			'class'  => 'product-attributes-extra2'
		);

		return $product_data_tabs;
	}




	/**
	 * Add product data fields
	 *
	 */
	public function product_meta_fields() {
		global $post;
		echo '<div id="product_attributes_extra" class="panel woocommerce_options_panel">';
		$this->create_product_extra_fields( $post->ID );
		echo '</div>';
	}



		/**
	 * Add product data fields
	 *
	 */
	public function product_meta_fields2() {
		global $post;
		echo '<div id="product_attributes_extra2" class="panel woocommerce_options_panel">';
		$this->create_product_extra_fields2( $post->ID );
		echo '</div>';
	}



	/**
	 * product_meta_fields_save function.
	 *
	 * @param mixed $post_id
	 */
	public function product_meta_fields_save( $post_id ) {
		if ( isset( $_POST['product_instagram_hashtag'] ) ) {
			$woo_data = $_POST['product_instagram_hashtag'];
			update_post_meta( $post_id, 'product_instagram_hashtag', $woo_data );
		}

		if ( isset( $_POST['attributes_extra'] ) ) {
			$woo_data = $_POST['attributes_extra'];
			update_post_meta( $post_id, 'attributes_extra', $woo_data );
		}

		if ( isset( $_POST['_supro_custom_badges_text'] ) ) {
			$woo_data = $_POST['_supro_custom_badges_text'];
			update_post_meta( $post_id, '_supro_custom_badges_text', $woo_data );
		}

		if ( isset( $_POST['_supro_custom_badges_bg'] ) ) {
			$woo_data = $_POST['_supro_custom_badges_bg'];
			update_post_meta( $post_id, '_supro_custom_badges_bg', $woo_data );
		}

		if ( isset( $_POST['_supro_custom_badges_color'] ) ) {
			$woo_data = $_POST['_supro_custom_badges_color'];
			update_post_meta( $post_id, '_supro_custom_badges_color', $woo_data );
		}

		if ( isset( $_POST['_is_new'] ) ) {
			$woo_data = $_POST['_is_new'];
			update_post_meta( $post_id, '_is_new', $woo_data );
		} else {
			update_post_meta( $post_id, '_is_new', 0 );
		}
	}






	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_extra_fields2( $post_id ) {
		$post_custom = get_post_custom( $post_id );
		//extra sizing and icon options here
		?>



					<div style="padding: 0px 10px;">
				<h4 style="font-weight: 700;"><?php esc_html_e( 'Extra Product Data', 'supro' ); ?></h4>
			</div>

		<?php






    //update_post_meta($post_id, 'case_dimensions_in', $_POST['case_dimensions_in']);
    //update_post_meta($post_id, 'ce_en388_certification_code', $_POST['ce_en388_certification_code']);
    //update_post_meta($post_id, 'other_ce_certification_codes', $_POST['other_ce_certification_codes']);
    //update_post_meta($post_id, 'unspsc_code', $_POST['unspsc_code']);
    //update_post_meta($post_id, 'weight_in_lbs', $_POST['weight_in_lbs']);


    echo '<div class="product_custom_field">';
    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => 'case_dimensions_in',
            'placeholder' => '',
            'label' => __('Case Dimensions', 'woocommerce')
        )
    );
    echo '</div>';


    echo '<div class="product_custom_field">';
    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => 'ce_en388_certification_code',
            'placeholder' => '',
            'label' => __('en388 Certification Code', 'woocommerce')
        )
    );
    echo '</div>';



    echo '<div class="product_custom_field">';
    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => 'other_ce_certification_codes',
            'placeholder' => '',
            'label' => __('other Ce Certification Codes', 'woocommerce')
        )
    );
    echo '</div>';


    echo '<div class="product_custom_field">';
    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => 'unspsc_code',
            'placeholder' => '',
            'label' => __('unspsc Code', 'woocommerce')
        )
    );
    echo '</div>';


    echo '<div class="product_custom_field">';
    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => 'ukca_code',
            'placeholder' => '',
            'label' => __('ukca Code', 'woocommerce')
        )
    );
    echo '</div>';

    echo '<div class="product_custom_field">';
    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => 'hs_code',
            'placeholder' => '',
            'label' => __('hs Code', 'woocommerce')
        )
    );
    echo '</div>';


    echo '<div class="product_custom_field">';
    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array(
            'id' => 'weight_in_lbs',
            'placeholder' => '',
            'label' => __('Weight (lbs)', 'woocommerce')
        )
    );
    echo '</div>';





		woocommerce_wp_select( array(
		    'id' => 'fittabdetails',
		    'name' => 'fittabdetails',
		    'class' => 'fittabdetails',
		    'label' => __('Choose Sleeve Details or Glove Details - Details are globally the same, and controlled from Appearance > Customize > Woocommerce > Single Product', 'woocommerce'),
		    'options' => array(
		        'none' => 'None',
		        'gloves' => 'Gloves',
		        'sleeves' => 'Sleeves',
		    ))
		);

		?>



			<div style="padding: 0px 10px; display: none;">
				<h4 style="font-weight: 700;"><?php esc_html_e( 'Choose Glove Labels', 'supro' ); ?></h4>
			</div>

		<?php  /*
		$options = [];
		$icons = get_terms(['taxonomy' => 'pa_icons', 'hide_empty' => false]);
		if ($icons) {
            foreach ($icons as $icon) {
	            $icon_name = str_replace(strrchr($icon->name, '.'), '', $icon->name);
			    $options[$icon_name] = $icon_name;
		    }
	    }
		woocommerce_wp_select_multiple( array(
				'id' => 'supglove_icons',
				'name' => 'supglove_icons[]',
				'class' => 'supglove_icons',
				'label' => __('Glove Labels', 'woocommerce'),
				'options' => $options
			)
		); */
		?>

				<?php

				/*

			<div style="padding: 0px 10px;">
				<h4 style="font-weight: 700;"><?php esc_html_e( 'Choose Sizes', 'supro' ); ?></h4>
			</div>


		woocommerce_wp_select_multiple( array(
		    'id' => 'glovesizes',
		    'name' => 'glovesizes[]',
		    'class' => 'glovesizes',
		    'label' => __('Glove Sizes', 'woocommerce'),
		    'options' => array(
		        '6' => 'Size 6',
		        '7' => 'Size 7',
		        '8' => 'Size 8',
		        '9' => 'Size 9',
		        '10' => 'Size 10',
		        '11' => 'Size 11',
		        '12' => 'Size 12',
		    ))
		);*/

		?>





		<?php


	}


	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_extra_fields( $post_id ) {
		$post_custom = get_post_custom( $post_id );
		$attributes = maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );

		if ( ! $attributes ) : ?>
			<div id="message" class="inline notice woocommerce-message">
				<p><?php esc_html_e( 'You need to add attributes on the Attributes tab.', 'supro' ); ?></p>
			</div>

		<?php else :
			$options         = array();
			$options['']     = esc_html__( 'Default', 'supro' );
			$options['none'] = esc_html__( 'None', 'supro' );
			foreach ( $attributes as $attribute ) {
				$options[sanitize_title( $attribute['name'] )] = wc_attribute_label( $attribute['name'] );
			}
			woocommerce_wp_select(
				array(
					'id'       => 'attributes_extra',
					'label'    => esc_html__( 'Product Attribute', 'supro' ),
					'desc_tip' => esc_html__( 'Show product attribute for each item listed under the item name.', 'supro' ),
					'options'  => $options
				)
			);

		endif;

		woocommerce_wp_text_input(
			array(
				'id'       => '_supro_custom_badges_text',
				'label'    => esc_html__( 'Custom Badge Text', 'supro' ),
				'desc_tip' => esc_html__( 'Enter this optional to show your badges.', 'supro' ),
			)
		);

		$bg_color       = ( isset( $post_custom['_supro_custom_badges_bg'][0] ) ) ? $post_custom['_supro_custom_badges_bg'][0] : '';
		woocommerce_wp_text_input(
			array(
				'id'       => '_supro_custom_badges_bg',
				'label'    => esc_html__( 'Custom Badge Background', 'supro' ),
				'desc_tip' => esc_html__( 'Pick background color for your badge', 'supro' ),
				'value'    => $bg_color,
			)
		);

		$color       = ( isset( $post_custom['_supro_custom_badges_color'][0] ) ) ? $post_custom['_supro_custom_badges_color'][0] : '';
		woocommerce_wp_text_input(
			array(
				'id'       => '_supro_custom_badges_color',
				'label'    => esc_html__( 'Custom Badge Color', 'supro' ),
				'desc_tip' => esc_html__( 'Pick color for your badge', 'supro' ),
				'value'    => $color,
			)
		);

		woocommerce_wp_checkbox(
			array(
				'id'          => '_is_new',
				'label'       => esc_html__( 'New product?', 'supro' ),
				'description' => esc_html__( 'Enable to set this product as a new product. A "New" badge will be added to this product.', 'supro' ),
			)
		);

	}
}
