<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Clean country to match normalized WooCommerce codes
$current_user_id = get_current_user_id();
$raw_country = get_user_meta( $current_user_id, 'afreg_additional_46397', true );

$country_map = [
    'United States' => 'US',
    'Canada' => 'CA',
    'Mexico' => 'MX',
    'US' => 'US',
    'CA' => 'CA',
    'MX' => 'MX',
];
$country = isset($country_map[$raw_country]) ? $country_map[$raw_country] : $raw_country;
$user_role = get_user_meta( $current_user_id, 'afreg_select_user_role', true );

$meta_sections = [
    'contact_info' => [
        'title'  => 'Contact Information',
        'fields' => [
            'afreg_additional_46389' => 'Phone Number',
            'afreg_additional_46390' => 'Email',
            // Job Title logic handled separately
        ],
    ],
    'affiliation_info' => [
        'title'  => 'Affiliation & Preferences',
        'fields' => [
            'afreg_select_user_role' => 'Professional Affiliation',
            'business_size' => 'Company Size',
            'afreg_additional_46360' => 'Company Location',
            'afreg_additional_46364' => 'Preferred Contact Method',
            'afreg_additional_46362' => 'Business Email',
            'afreg_additional_46363' => 'Secondary Email',
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
            'state_field' => 'State',
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
        <?php $user = get_user_by('ID', $current_user_id); ?>
        <?php if ( $user ): ?>
            <ul>
                <li><?php echo get_avatar($current_user_id, 125); ?></li>
                <li><span class="m-title"><?php echo esc_html($user->display_name); ?></span></li>
                <li><span><?php esc_html_e('Email', 'supro'); ?>:</span><?php echo esc_html(get_user_meta($current_user_id, 'afreg_additional_46390', true)); ?></li>
                <li><span><?php esc_html_e('Phone', 'supro'); ?>:</span><?php echo esc_html(get_user_meta($current_user_id, 'afreg_additional_46389', true)); ?></li>
                <li><span><?php esc_html_e('Job Title', 'supro'); ?>:</span><?php 
                    // Sidebar job title conditional
                    if ($user_role === 'safety_professional') {
                        echo esc_html(get_user_meta($current_user_id, 'afreg_additional_46435', true));
                    } else {
                        echo esc_html(get_user_meta($current_user_id, 'afreg_additional_46388', true));
                    }
                ?></li>
                <li><a href="<?php echo esc_url(wc_get_endpoint_url('edit-account')); ?>" class="m-button"><?php esc_html_e('Edit Profile', 'supro'); ?></a></li>
            </ul>
        <?php endif; ?>
    </div>

    <div class="myaccount-content col-lg-9 col-md-8 col-sm-12 col-xs-12">
        <?php do_action('woocommerce_before_my_account'); ?>

        <?php foreach ( $meta_sections as $section ): ?>
            <h3 style="margin-top: 30px;"><?php echo esc_html( $section['title'] ); ?></h3>
            <table class="woocommerce-table woocommerce-table--profile-fields shop_table account-fields" style="width:100%; margin-bottom: 20px;">
                <tbody>
                <?php foreach ( $section['fields'] as $key => $label ) :

                    // Handle job title conditional properly
                    if ($key === 'afreg_additional_46388' || $key === 'afreg_additional_46435') continue;
                    if ($key === 'job_title') {
                        $val = ($user_role === 'safety_professional') 
                            ? get_user_meta($current_user_id, 'afreg_additional_46435', true) 
                            : get_user_meta($current_user_id, 'afreg_additional_46388', true);
                        if (!empty($val)) {
                            echo "<tr><th>{$label}</th><td>{$val}</td></tr>";
                        }
                        continue;
                    }

                    // Handle business size conditional logic
                    if ($key === 'business_size') {
                        $val = ($user_role === 'distributor') 
                            ? get_user_meta($current_user_id, 'afreg_additional_46361', true) 
                            : get_user_meta($current_user_id, 'afreg_additional_46359', true);
                        if (!empty($val)) {
                            echo "<tr><th>{$label}</th><td>{$val}</td></tr>";
                        }
                        continue;
                    }

                    // Handle state conditional logic:
                    if ($key === 'state_field') {
                        $state = '';
                        if ($country === 'US') {
                            $state = get_user_meta($current_user_id, 'afreg_additional_46395', true);
                        } elseif ($country === 'CA') {
                            $state = get_user_meta($current_user_id, 'afreg_additional_46423', true);
                        } elseif ($country === 'MX') {
                            $state = get_user_meta($current_user_id, 'afreg_additional_46424', true);
                        } else {
                            $state = get_user_meta($current_user_id, 'afreg_additional_46525', true);
                        }
                        if (!empty($state) && $state !== 'Please Choose') {
                            echo "<tr><th>{$label}</th><td>{$state}</td></tr>";
                        }
                        continue;
                    }

                    $val = get_user_meta( $current_user_id, $key, true );
                    if (!empty($val) && $val !== 'Please Choose') :
                        echo "<tr><th>{$label}</th><td>{$val}</td></tr>";
                    endif;
                endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

        <p><a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="button"><?php esc_html_e( 'Edit Profile Information', 'supro' ); ?></a></p>
        <?php do_action('woocommerce_after_my_account'); ?>
    </div>
</div>
















