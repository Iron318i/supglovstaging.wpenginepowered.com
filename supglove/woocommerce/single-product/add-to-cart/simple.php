<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;
$enquired_product = get_post_meta($product->get_id(), '_enquired_product', true) == 'yes';
$is_sample_box = get_post_meta( $product->get_id(), 'sg_sample_box_marker', true );

if ( ! $product->is_purchasable() ) {
	return;
}

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		) );

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<?php if(!$enquired_product) : ?>
            <button
                    type="submit"
                    name="add-to-cart"
                    data-link="<?= $product->get_permalink() ?>"
                    value="<?php echo esc_attr( $product->get_id() ); ?>"
                    class="single_add_to_cart_button button alt"
            >
                <?php echo esc_html( $product->single_add_to_cart_text() ); ?> <i class="t-icon icon-ion-android-add"></i>
            </button>
	    <?php else : ?>
            <button
                    type="submit"
                    name="add-to-cart"
                    data-link="<?= $product->get_permalink() ?>"
                    value="<?php echo esc_attr( $product->get_id() ); ?>"
                    class="single_add_to_cart_button button alt updated-text"
            ><?php _e( 'REQUEST SAMPLE', 'supro' ) ?> <span style='font-weight:bold;'>+</span</button>
        <?php /* ?>
	      <button
          type="button"
          data-id="<?= $product->get_sku() ?>"
          data-link="<?= $product->get_permalink() ?>"
          data-title="<?= esc_html($product->get_title()) ?>"
          class="enquire-button-full open-enquire-modal"
        >
	        <span>Contact Us</span>
	        <span class="icon-enquire inside-button"></span>
	      </button>
        <?php */ ?>
	    <?php endif ?>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

    <?php if ( !$is_sample_box ) : ?>
      <div class="print_page"><a href="javascript:print();">Download or Print Page here</a></div>
    <?php endif; ?>

	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>