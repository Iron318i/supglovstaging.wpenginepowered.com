<?php
/**
 * Edit address form (Custom AFREG fields with Country-Based Logic)
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'woocommerce' ) : esc_html__( 'Shipping address', 'woocommerce' );

$customer_id = get_current_user_id();

$custom_fields = [
	'afreg_additional_46385' => 'First Name',
	'afreg_additional_46387' => 'Last Name',
	'afreg_additional_46391' => 'Company Name',
	'afreg_additional_46392' => 'Street Address',
	'afreg_additional_46393' => 'Additional Address',
	'afreg_additional_46394' => 'City',
	'afreg_additional_46395' => 'State',
	'afreg_additional_46423' => 'Province',
	'afreg_additional_46424' => 'Mexican States',
	'afreg_additional_46396' => 'Post Code',
	'afreg_additional_46397' => 'Country',
	'afreg_additional_46389' => 'Phone',
	'afreg_additional_46390' => 'Email',
];

$current_country = get_user_meta( $customer_id, 'afreg_additional_46397', true );

?>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>
	<?php
		$current_user = wp_get_current_user();
		echo '<p class="woocommerce-username">' . esc_html( $current_user->display_name ) . '</p>';
	?>
	<form method="post">
		<h3><?php echo esc_html( $page_title ); ?></h3>
		<div class="woocommerce-address-fields">
			<div class="woocommerce-address-fields__field-wrapper">
				<?php foreach ( $custom_fields as $key => $label ) : ?>
					<?php if ($key === 'afreg_additional_46423' && $current_country !== 'Canada') continue; ?>
					<?php if ($key === 'afreg_additional_46424' && $current_country !== 'Mexico') continue; ?>
					<p class="form-row form-row-wide">
						<label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label>
						<input type="text" class="input-text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( get_user_meta( $customer_id, $key, true ) ); ?>">
					</p>
				<?php endforeach; ?>
			</div>

			<p>
				<button type="submit" class="button" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>"><?php esc_html_e( 'Save address', 'woocommerce' ); ?></button>
				<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
				<input type="hidden" name="action" value="edit_address" />
			</p>
		</div>
	</form>
<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>

