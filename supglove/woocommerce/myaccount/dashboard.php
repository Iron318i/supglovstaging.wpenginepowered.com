<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$meta_fields = [
    'afreg_select_user_role'        => 'Professional Affiliation',
    'afreg_additional_46361'        => 'Company Size (Distributor)',
    'afreg_additional_46359'        => 'Company Size (Safety Professional)',
    'afreg_additional_46360'        => 'Company Location',
    'afreg_additional_46364'        => 'Preferred Contact Method',
    'afreg_additional_46362'        => 'Business Email',
    'afreg_additional_46363'        => 'Secondary Email',
    'afreg_additional_46385'        => 'First Name',
    'afreg_additional_46387'        => 'Last Name',
    'afreg_additional_46388'        => 'Job Title',
    'afreg_additional_46389'        => 'Phone Number',
    'afreg_additional_46390'        => 'Email',
    'afreg_additional_46391'        => 'Company Name',
    'afreg_additional_46392'        => 'Street Address',
    'afreg_additional_46393'        => 'Additional Address',
    'afreg_additional_46394'        => 'City',
    'afreg_additional_46395'        => 'State',
    'afreg_additional_46423'        => 'Province',
    'afreg_additional_46424'        => 'Mexican States',
    'afreg_additional_46396'        => 'Post Code / Zip Code',
    'afreg_additional_46397'        => 'Country',
    'afreg_additional_46426'        => 'Preferred Language',
    'afreg_additional_46383'        => 'Weekly Email Opt-in',
];
?>

<div class="row">
	<div class="myaccount-sidebar col-lg-3 col-md-4 col-sm-12 col-xs-12">
		<?php $user = get_user_by('ID', get_current_user_id()); ?>
		<?php if ( $user ): ?>
			<ul>
				<li><?php echo get_avatar(get_current_user_id(), 125); ?></li>
				<li><span class="m-title"><?php esc_html_e('Hello!', 'supro'); ?> <?php echo esc_html($user->display_name); ?></span></li>
				<li><span><?php esc_html_e('Email', 'supro'); ?>:</span><?php echo esc_html($user->user_email); ?></li>
				<li><span><?php esc_html_e('Phone', 'supro'); ?>:</span><?php echo esc_html(get_user_meta(get_current_user_id(), 'billing_phone', true)); ?></li>
				<li><span><?php esc_html_e('Country', 'supro'); ?>:</span>
					<?php
						$country = get_user_meta(get_current_user_id(), 'billing_country', true);
						if ($country && function_exists('WC')) {
							$country = WC()->countries->countries[$country] ?? $country;
						}
						echo esc_html($country);
					?>
				</li>
				<li><span><?php esc_html_e('Postcode', 'supro'); ?>:</span><?php echo esc_html(get_user_meta(get_current_user_id(), 'billing_postcode', true)); ?></li>

				<?php foreach ($meta_fields as $key => $label): ?>
					<?php $val = get_user_meta(get_current_user_id(), $key, true); ?>
					<?php if (!empty($val)): ?>
						<li><span><?php echo esc_html($label); ?>:</span><?php echo esc_html($val); ?></li>
					<?php endif; ?>
				<?php endforeach; ?>

				<li>
					<a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="m-button">
						<?php esc_html_e('Edit Profile', 'supro'); ?>
					</a>
				</li>
			</ul>
		<?php endif; ?>
	</div>

	<div class="myaccount-content col-lg-9 col-md-8 col-sm-12 col-xs-12">
		<?php
			do_action('woocommerce_account_dashboard');
			do_action('woocommerce_before_my_account');
			do_action('woocommerce_after_my_account');
		?>
	</div>
</div>



