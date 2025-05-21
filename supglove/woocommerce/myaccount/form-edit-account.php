<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * @package WooCommerce\Templates
 * @version 9.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );

$user_id = get_current_user_id();
$user    = wp_get_current_user();
?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
		       placeholder="<?php esc_attr_e( 'First name', 'supro' ); ?>"
		       name="account_first_name" id="account_first_name"
		       autocomplete="given-name"
		       value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
		       placeholder="<?php esc_attr_e( 'Last name', 'supro' ); ?>"
		       name="account_last_name" id="account_last_name"
		       autocomplete="family-name"
		       value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>

	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
		       placeholder="<?php esc_attr_e( 'Display Name', 'supro' ); ?>"
		       name="account_display_name" id="account_display_name"
		       value="<?php echo esc_attr( $user->display_name ); ?>" />
		<span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'supro' ); ?></em></span>
	</p>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text"
		       placeholder="<?php esc_attr_e( 'Email address', 'supro' ); ?>"
		       name="account_email" id="account_email"
		       autocomplete="email"
		       value="<?php echo esc_attr( $user->user_email ); ?>" />
	</p>

	<?php
		// This hook injects plugin-managed fields (AFREG, etc.)
		do_action( 'woocommerce_edit_account_form_fields' );
	?>

	<fieldset>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
			       placeholder="<?php esc_attr_e( 'Current Password', 'supro' ); ?>"
			       name="password_current" id="password_current" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
			       placeholder="<?php esc_attr_e( 'New Password', 'supro' ); ?>"
			       name="password_1" id="password_1" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text"
			       placeholder="<?php esc_attr_e( 'Confirm New Password', 'supro' ); ?>"
			       name="password_2" id="password_2" autocomplete="off" />
		</p>
	</fieldset>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p class="edit-btn">
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
		        name="save_account_details"
		        value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>">
			<?php esc_html_e( 'Save changes', 'woocommerce' ); ?>
		</button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>


