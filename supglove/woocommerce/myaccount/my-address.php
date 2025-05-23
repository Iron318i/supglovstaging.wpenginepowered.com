<?php
/**
 * My Addresses (Modified to use custom registration fields for billing)
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

$custom_fields = [
	'afreg_additional_46385', // First Name
	'afreg_additional_46387', // Last Name
	'afreg_additional_46391', // Company Name
	'afreg_additional_46392', // Street Address
	'afreg_additional_46393', // Additional Address
	'afreg_additional_46394', // City
	'afreg_additional_46395', // State
	'afreg_additional_46423', // Province (fallback only)
	'afreg_additional_46424', // Mexican States (fallback only)
	'afreg_additional_46396', // Post Code
	'afreg_additional_46397', // Country
	'afreg_additional_46389', // Phone
	'afreg_additional_46390', // Email
];

?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
</p>

<div class="u-columns woocommerce-Addresses col2-set addresses">
	<div class="u-column1 col-1 woocommerce-Address">
		<header class="woocommerce-Address-title title">
			<h3><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h3>
			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', 'billing' ) ); ?>" class="edit">
				<?php esc_html_e( 'Edit', 'woocommerce' ); ?>
			</a>
		</header>
		<address>
			<?php
			$has_content = false;
			foreach ( $custom_fields as $meta_key ) {
				$value = get_user_meta( $customer_id, $meta_key, true );
				if ( $value ) {
					echo esc_html( $value ) . '<br />';
					$has_content = true;
				}
			}
			if ( ! $has_content ) {
				echo esc_html__( 'You have not set up this type of address yet.', 'woocommerce' );
			}
			?>
		</address>
	</div>
</div>
