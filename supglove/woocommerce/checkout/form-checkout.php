<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'supro' ) ) );
	return;
}

$checkoutheading = supro_get_option( 'checkoutheading' ); // esc_html__( 'Request Your Samples', 'supro' )
$sampleboxheading = supro_get_option( 'sampleboxheading' ); // esc_html__( 'Please read before ordering:', 'supro' )
$sampleboxmessage = supro_get_option( 'sampleboxmessage' );
?>

<?php if ( !empty($checkoutheading) ) : ?>
  <h3 id="sg-checkoutheading" class="checkhead1"><?php echo esc_html( $checkoutheading ); ?></h3>
<?php endif; ?>

<?php if ( !empty($sampleboxheading) || !empty($sampleboxmessage) ) : ?>
  <div id="sg-checkoutsampleboxinfo" class="checkoutppemessage">
    <div id="sg-checkoutsampleboxinfoclosebtn" class="closebuta"><i class="icon icon-ion-android-close"></i></div>
    <?php if ( !empty($sampleboxheading) ) : ?>
      <h5 id="sg-checkoutsampleboxheading"><?php echo esc_html( $sampleboxheading ); ?></h5>
    <?php endif; ?>
    <?php if ( !empty($sampleboxmessage) ) : ?>
      <div id="sg-checkoutsampleboxmessage"><?php echo $sampleboxmessage; ?></div>
    <?php endif; ?>
  </div>
<?php endif; ?>
	
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="row">


		<div class="col-md-6 col-xs-12 col-sm-12">
			<p id="order_review_heading"  class="checkoutheader"><?php esc_html_e( 'Your Products', 'supro' ); ?></p>

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			
		</div>
		
		
		
		<div class="col-md-6 col-xs-12 col-sm-12">
			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div class="col2-set" id="customer_details">
					<div class="col-1">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>

					<div class="col-2">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>
		</div>
		
		
	</div>
	
	

	
	

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
