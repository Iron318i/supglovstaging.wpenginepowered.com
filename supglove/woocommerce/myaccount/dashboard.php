<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$meta_sections = [
	'contact_info' => [
		'title'  => 'Contact Information',
		'fields' => [
			'afreg_additional_46389' => 'Phone Number',
			'afreg_additional_46390' => 'Email',
			'afreg_additional_46388' => 'Job Title',
			'afreg_additional_46435' => 'Job Title (Safety Professional)', // conditional
		],
	],
	'affiliation_info' => [
		'title'  => 'Affiliation & Preferences',
		'fields' => [
			'afreg_select_user_role'        => 'Professional Affiliation',
			'afreg_additional_46361'        => 'Company Size (Distributor)',        // conditional
			'afreg_additional_46359'        => 'Company Size (Safety Professional)',// conditional
			'afreg_additional_46360'        => 'Company Location',
			'afreg_additional_46364'        => 'Preferred Contact Method',
			'afreg_additional_46362'        => 'Business Email',
			'afreg_additional_46363'        => 'Secondary Email',
		],
	],
	'personal_info' => [
		'title'  => 'Personal Information',
		'fields' => [
			'afreg_additional_46385' => 'First Name',
			'afreg_additional_46387' => 'Last Name',
			'afreg_additional_46391' => 'Company Name',
		],
	],
	'address_info' => [
		'title'  => 'Address Information',
		'fields' => [
			'afreg_additional_46392' => 'Street Address',
			'afreg_additional_46393' => 'Additional Address',
			'afreg_additional_46394' => 'City',
			'afreg_additional_46395' => 'State',
			'afreg_additional_46423' => 'Province',
			'afreg_additional_46424' => 'Mexican States',
			'afreg_additional_46525' => 'Other Country Field', // NEW conditional field
			'afreg_additional_46396' => 'Post Code / Zip Code',
			'afreg_additional_46397' => 'Country',
			'afreg_additional_46426' => 'Preferred Language',
			'afreg_additional_46383' => 'Weekly Email Opt-in',
		],
	],
];
?>

<div class="row">
	<div class="myaccount-sidebar col-lg-3 col-md-4 col-sm-12 col-xs-12">
		<?php $user = get_user_by('ID', get_current_user_id()); ?>
		<?php if ( $user ): ?>
			<ul>
				<li><?php echo get_avatar(get_current_user_id(), 125); ?></li>
				<li><span class="m-title"><?php echo esc_html($user->display_name); ?></span></li>
				<li><span><?php esc_html_e('Email', 'supro'); ?>:</span><?php echo esc_html(get_user_meta(get_current_user_id(), 'afreg_additional_46390', true)); ?></li>
				<li><span><?php esc_html_e('Phone', 'supro'); ?>:</span><?php echo esc_html(get_user_meta(get_current_user_id(), 'afreg_additional_46389', true)); ?></li>
				<li><span><?php esc_html_e('Job Title', 'supro'); ?>:</span><?php echo esc_html(get_user_meta(get_current_user_id(), 'afreg_additional_46388', true)); ?></li>
				<li>
					<a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="m-button">
						<?php esc_html_e('Edit Profile', 'supro'); ?>
					</a>
				</li>
			</ul>
		<?php endif; ?>
	</div>

	<div class="myaccount-content col-lg-9 col-md-8 col-sm-12 col-xs-12">
		<?php do_action('woocommerce_before_my_account'); ?>

		<?php 
		$current_user_id = get_current_user_id();
		$user_role = get_user_meta($current_user_id, 'afreg_select_user_role', true);
		$country = get_user_meta( $current_user_id, 'afreg_additional_46397', true );
		?>

		<?php foreach ( $meta_sections as $section ): ?>
			<h3 style="margin-top: 30px;"><?php echo esc_html( $section['title'] ); ?></h3>
			<table class="woocommerce-table woocommerce-table--profile-fields shop_table account-fields" style="width:100%; margin-bottom: 20px;">
				<tbody>
					<?php foreach ( $section['fields'] as $key => $label ) {

						// Conditional company size fields
						if ( $key === 'afreg_additional_46361' && $user_role !== 'distributor' ) continue;
						if ( $key === 'afreg_additional_46359' && $user_role !== 'safety_professional' ) continue;

						// Conditional job title
						if ( $key === 'afreg_additional_46435' && $user_role !== 'safety_professional' ) continue;

						// Country-specific conditional fields
						if ( $key === 'afreg_additional_46423' && $country !== 'Canada' ) continue;
						if ( $key === 'afreg_additional_46424' && $country !== 'Mexico' ) continue;

						// Only show "Other Country Field" if NOT US, MX, CA
						if ( $key === 'afreg_additional_46525' && in_array($country, ['United States', 'Canada', 'Mexico']) ) continue;

						$val = get_user_meta( $current_user_id, $key, true );

						if ( ! empty( $val ) ) : ?>
							<tr>
								<th style="width: 300px;"><?php echo esc_html( $label ); ?></th>
								<td><?php echo esc_html( $val ); ?></td>
							</tr>
						<?php endif;
					} ?>
				</tbody>
			</table>
		<?php endforeach; ?>

		<p>
			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="button">
				<?php esc_html_e( 'Edit Profile Information', 'supro' ); ?>
			</a>
		</p>

		<?php do_action( 'woocommerce_after_my_account' ); ?>
	</div>
</div>















