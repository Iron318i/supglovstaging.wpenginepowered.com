<?php
/**
 * My Addresses (Modified to use AFREG fields for billing and plugin-defined fields for shipping)
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

// Billing = AFREG custom fields
$billing_fields = [
	'afreg_additional_46385', // First Name
	'afreg_additional_46387', // Last Name
	'afreg_additional_46391', // Company Name
	'afreg_additional_46392', // Street Address
	'afreg_additional_46393', // Additional Address
	'afreg_additional_46394', // City
	'afreg_additional_46395', // State
	'afreg_additional_46423', // Province (Canada only)
	'afreg_additional_46424', // Mexican States (Mexico only)
	'afreg_additional_46525', // Other Country Field (non-US/MX/CA)
	'afreg_additional_46396', // Post Code
	'afreg_additional_46397', // Country
	'afreg_additional_46389', // Phone
	'afreg_additional_46390', // Email
	'afreg_additional_46435', // Job Title (Safety Professional only)
];

// Shipping = plugin-defined user meta fields
$shipping_fields = [
	'shipping_first_name'   => 'Shipping First Name',
	'shipping_last_name'    => 'Shipping Last Name',
	'shipping_job_title'    => 'Shipping Job Title',
	'shipping_phone'        => 'Shipping Phone',
	'shipping_address_1'    => 'Shipping Address',
	'shipping_address_2'    => 'Shipping Alt Address',
	'shipping_city'         => 'Shipping City',
	'shipping_state'        => 'Shipping State',
	'shipping_postcode'     => 'Shipping Post Code',
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
			$has_billing = false;
			$country = get_user_meta( $customer_id, 'afreg_additional_46397', true );
			$user_role = get_user_meta( $customer_id, 'afreg_select_user_role', true );

			foreach ( $billing_fields as $meta_key ) {
				// Province – only for Canada
				if ( $meta_key === 'afreg_additional_46423' && $country !== 'Canada' ) continue;

				// Mexican States – only for Mexico
				if ( $meta_key === 'afreg_additional_46424' && $country !== 'Mexico' ) continue;

				// Other Country Field – only for NOT US/CA/MX
				if ( $meta_key === 'afreg_additional_46525' && in_array( $country, [ 'United States', 'Canada', 'Mexico' ] ) ) continue;

				// Job Title (Safety Professional) – only for safety_professional role
				if ( $meta_key === 'afreg_additional_46435' && $user_role !== 'safety_professional' ) continue;

				$value = get_user_meta( $customer_id, $meta_key, true );
				if ( $value ) {
					echo esc_html( $value ) . '<br />';
					$has_billing = true;
				}
			}
			if ( ! $has_billing ) {
				echo esc_html__( 'You have not set up this type of address yet.', 'woocommerce' );
			}
			?>
		</address>
	</div>

	<div class="u-column2 col-2 woocommerce-Address">
		<header class="woocommerce-Address-title title">
			<h3><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h3>
			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', 'shipping' ) ); ?>" class="edit">
				<?php esc_html_e( 'Edit', 'woocommerce' ); ?>
			</a>
		</header>
		<address>
			<?php
			$has_shipping = false;
			foreach ( $shipping_fields as $meta_key => $label ) {
				$value = get_user_meta( $customer_id, $meta_key, true );
				if ( $value ) {
					echo esc_html( $value ) . '<br />';
					$has_shipping = true;
				}
			}
			if ( ! $has_shipping ) {
				echo esc_html__( 'You have not set up this type of address yet.', 'woocommerce' );
			}
			?>
		</address>
	</div>
</div>



