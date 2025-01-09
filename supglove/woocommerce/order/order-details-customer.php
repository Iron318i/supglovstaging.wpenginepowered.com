<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">
  
	<?php if ( $show_shipping ) : ?>
  
	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

	<?php endif; ?>
  
  <h5 class="woocommerce-column__title"><?php esc_html_e( 'Delivery Details', 'woocommerce' ); ?></h5>
  
  <div class="col-sm-12 col-md-6">
    <h6 class="shipto"><?php esc_html_e( 'Business Info', 'woocommerce' ); ?></h6>
    <?php
      $order_data = $order->get_data();
      
      $phone = $order->get_billing_phone();
      $company = $order->get_meta('billing_company');
      $position = $order->get_meta('billing_job_title');
      $company_size = $order->get_meta('company_size_safety_pro_value');
      
      echo $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'] . '<br/>';  
      echo ( !empty($company) ? __('Company: ', 'SuperiorGlove') . $company . '<br/>' : '' );
      echo ( !empty($position) ? __('Job Title: ', 'SuperiorGlove') . $position . '<br/>' : '' );
      echo ( !empty($phone) ? __('Phone: ', 'SuperiorGlove') . $phone . '<br/>' : '' );
      echo ( !empty($company_size) ? __('Number of PPE: ', 'SuperiorGlove') . $company_size . '<br/>' : '' );
    ?>
  </div>
  
  <div class="col-sm-12 col-md-6">
    <h6 class="shipto"><?php esc_html_e( 'Shipping Address', 'woocommerce' ); ?></h6>
    <address>
      <?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>
      <?php /*if ( $order->get_billing_email() ) : ?>
        <p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
      <?php endif; */ ?>
      
      <?php
        /**
         * Action hook fired after an address in the order customer details.
         *
         * @since 8.7.0
         * @param string $address_type Type of address (billing or shipping).
         * @param WC_Order $order Order object.
         */
        do_action( 'woocommerce_order_details_after_customer_address', 'billing', $order );
      ?>
    </address>
  </div>
  
  <div class="clear"></div>
  
	<?php if ( $show_shipping ) : ?>
    
		</div><!-- /.col-1 -->
    
		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
			<h2 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>
			<address>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'woocommerce' ) ) ); ?>

				<?php if ( $order->get_shipping_phone() ) : ?>
					<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_shipping_phone() ); ?></p>
				<?php endif; ?>
        
        <?php
					/**
					 * Action hook fired after an address in the order customer details.
					 *
					 * @since 8.7.0
					 * @param string $address_type Type of address (billing or shipping).
					 * @param WC_Order $order Order object.
					 */
					do_action( 'woocommerce_order_details_after_customer_address', 'shipping', $order );
				?>
			</address>
		</div><!-- /.col-2 -->
    
	</section><!-- /.col2-set -->
  
	<?php endif; ?>
  
  <?php if ( $order->get_customer_note() || $order->get_meta('add_info') ) : ?>
    <div class="col-sm-12 col-md-12">
      <h6 class="shipto"><?php esc_html_e( 'Usage, Needs, Questions, Comments', 'woocommerce' ); ?></h6>
      <?php if ( $order->get_customer_note() ) : ?>
        <div><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></div>
      <?php endif; ?>
      <?php if ( $order->get_meta('add_info') ) : ?>
        <div><?php echo wp_kses_post( nl2br( wptexturize( $order->get_meta('add_info') ) ) ); ?></div>
      <?php endif; ?>
    </div>
    
    <div class="clear"></div>
  <?php endif; ?>
  
	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
  
</section>
