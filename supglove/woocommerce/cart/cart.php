<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
		<tr>
      <?php /* ?>
      <th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
      <th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail image', 'woocommerce' ); ?></span></th>
      <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
      <?php */ ?>
      <th class="product-name"><?php esc_html_e( 'Product', 'supro' ); ?></th>
      <?php /* ?>
      <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
      <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
      <th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
      <?php */ ?>
			<?php /* ?>
			<th class="product-price hidden-xs"><?php esc_html_e( 'Price', 'supro' ); ?></th>
			<th class="product-quantity"><?php esc_html_e( 'Quantity', 'supro' ); ?></th>
			<th class="product-subtotal hidden-xs"><?php esc_html_e( 'Total', 'supro' ); ?></th>
			<?php */ ?>
			<th class="product-remove hidden-xs">&nbsp;</th>
		</tr>
		</thead>
		<tbody>
      <?php do_action( 'woocommerce_before_cart_contents' ); ?>

      <?php
      $i = 1; // count items

      foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        global $supro_woocommerce;

        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        /**
         * Filter the product name.
         *
         * @since 2.1.0
         * @param string $product_name Name of the product in the cart.
         * @param array $cart_item The product in the cart.
         * @param string $cart_item_key Key for the product in the cart.
         */
        // $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
          $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
          ?>
          <tr class="woocommerce-cart-form__cart-item cart-item-<?php echo esc_attr( $i ); ?> <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

            <?php /* ?>
            <td class="product-remove">
              <?php
                echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                  'woocommerce_cart_item_remove_link',
                  sprintf(
                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                    // translators: %s is the product name
                    esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                    esc_attr( $product_id ),
                    esc_attr( $_product->get_sku() )
                  ),
                  $cart_item_key
                );
              ?>
            </td>
            <?php */ ?>
            
            <?php /* ?>
            <td class="product-thumbnail">
            <?php
            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

            if ( ! $product_permalink ) {
              echo $thumbnail; // PHPCS: XSS ok.
            } else {
              printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
            }
            ?>
            </td>
            <?php */ ?>
            
            <?php /* ?>
            <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
            <?php
            if ( ! $product_permalink ) {
              echo wp_kses_post( $product_name . '&nbsp;' );
            } else {
              //
              // This filter is documented above.
              //
              // @since 2.1.0
              //
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
            }

            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

            // Meta data.
            echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

            // Backorder notification.
            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
            }
            ?>
            </td>
            <?php */ ?>
            
            <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'supro' ); ?>">
            <?php
              $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
              $mylinktext = _x( 'View Items Details', 'WooCommerce cart', 'SuperiorGlove');
                
              if ( ! $product_permalink ) {
                echo wp_kses_post( $thumbnail );
                echo '<h6>' . wp_kses_post( apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;' ) . '</h6>';
              } else {
                printf( '<a href="%s" class="product-url">%s</a>', esc_url($product_permalink), wp_kses_post($thumbnail) );
                echo '<div class="cartitmedet"><div class="cartitmedetinner">' . wp_kses_post( apply_filters(
                      'woocommerce_cart_item_name', 
                      sprintf(
                        '<a href="%s" class="product-url"><h6>%s</h6><br/><h6 class="sku">Product ID: ' . $_product->get_sku() . '</h6></a>', 
                        esc_url( $product_permalink ), 
                        $_product->get_name()
                      ), 
                      $cart_item, 
                      $cart_item_key
                    ) );
                printf( '<br/><a href="%s" class="product-url-quick">%s</a>', esc_url( $product_permalink ),  $mylinktext ).'</div></div>';
              }

              // Meta data.
              echo wp_kses_post( $supro_woocommerce->supro_get_item_data( $cart_item ) ); // PHPCS: XSS ok.
              // echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

              // Price on mobile
              echo '<p class="price hidden-lg hidden-md hidden-sm">' . apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . '</p>';

              // Remove product on mobile
              echo apply_filters( 
                'woocommerce_cart_item_remove_link', 
                sprintf(
                  '<a href="%s" class="remove hidden-lg hidden-md hidden-sm" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
                  esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                  esc_html__( 'Remove this item', 'supro' ),
                  esc_attr( $product_id ),
                  esc_attr( $_product->get_sku() ),
                  esc_html__( 'Delete', 'supro' )
                ), 
                $cart_item_key 
              );

              // Backorder notification.
              if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                echo wp_kses_post( apply_filters( 
                  'woocommerce_cart_item_backorder_notification', 
                  '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'supro' ) . '</p>', 
                  $product_id 
                ) );
              }
            ?>
            </td>
            
            <?php /* ?>
            <?php // <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">  ?>
            <td class="product-price hidden-xs" data-title="<?php esc_attr_e( 'Price', 'supro' ); ?>">
              <?php
                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
              ?>
            </td>
            <?php */ ?>

            <?php /* ?>
            <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
              <?php
              if ( $_product->is_sold_individually() ) {
                $min_quantity = 1;
                $max_quantity = 1;
              } else {
                $min_quantity = 0;
                $max_quantity = $_product->get_max_purchase_quantity();
              }

              $product_quantity = woocommerce_quantity_input(
                array(
                  'input_name'   => "cart[{$cart_item_key}][qty]",
                  'input_value'  => $cart_item['quantity'],
                  'max_value'    => $max_quantity,
                  'min_value'    => $min_quantity,
                  'product_name' => $product_name,
                ),
                $_product,
                false
              );

              echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
              ?>
              </td>
            <?php */ ?>

            <?php /* ?>
            <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'supro' ); ?>"><?php 
              if ( $_product->is_sold_individually() ) {
                $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
              } else {
                $product_quantity = woocommerce_quantity_input(
                  array(
                    'input_name'   => "cart[{$cart_item_key}][qty]",
                    'input_value'  => $cart_item['quantity'],
                    'max_value'    => $_product->get_max_purchase_quantity(),
                    'min_value'    => '0',
                    'product_name' => $_product->get_name(),
                  ), 
                  $_product, 
                  false
                );
              }

              echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); 
            ?></td>
            <?php */ ?>

            <?php /* ?>
            <?php // <td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"> ?>
            <td class="product-subtotal hidden-xs" data-title="<?php esc_attr_e( 'Total', 'supro' ); ?>">
              <?php
              echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
              ?>
            </td>
            <?php */ ?>

            <td class="product-remove hidden-xs">
              <?php
              // @codingStandardsIgnoreLine
              echo apply_filters(
                'woocommerce_cart_item_remove_link', 
                sprintf(
                  '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="icon icon-cross"></i></a>',
                  esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                  esc_html__( 'Remove this item', 'supro' ),
                  esc_attr( $product_id ),
                  esc_attr( $_product->get_sku() )
                ), 
                $cart_item_key
              );
              ?>
            </td>
          </tr>
          <?php
        }

        $i ++;
      }
      ?>

      <?php do_action( 'woocommerce_cart_contents' ); ?>

      <tr>
        <?php /* ?>
        <td colspan="6" class="actions">

          <?php if ( wc_coupons_enabled() ) { ?>
            <div class="coupon">
              <label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
              <?php do_action( 'woocommerce_cart_coupon' ); ?>
            </div>
          <?php } ?>

          <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

          <?php do_action( 'woocommerce_cart_actions' ); ?>

          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
        </td>
        <?php */ ?>
        
        <td class="actions">
          <div class="cart-actions">
            
            <?php if ( WC()->cart->get_cart_contents_count() < 3 ) { ?>
              <a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ); ?>" class="buttonogs btn_small btn_dark2"
              ><?php 
                esc_html_e( 'Back to Products', 'supro' ); 
              ?></a>
            <?php } ?>

            <?php if ( wc_coupons_enabled() ) { ?>
              <div class="coupon">
                <label for="coupon_code"><?php esc_html_e( 'Discount Code', 'supro' ); ?></label>

                <div class="coupon-field">
                  <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter your code', 'supro' ); ?>" />
                  <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'supro' ); ?>" />
                </div>
                <?php do_action( 'woocommerce_cart_coupon' ); ?>
              </div>
            <?php } ?>
          </div>

          <?php do_action( 'woocommerce_cart_actions' ); ?>

          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
        </td>
        
        <td class="actions">
            <?php
            if ( is_user_logged_in() ) {
                $checkout_url = wc_get_checkout_url();
            } else {
                $redirect_to = urlencode( wc_get_checkout_url() );
                $checkout_url = wc_get_page_permalink( 'myaccount' ) . '?redirect_to=' . $redirect_to;
            }
            ?>

            <a href="<?php echo esc_url( $checkout_url ); ?>" class="checkout-button wc-forward buttonogs btn_small btn_theme_color">
                <?php esc_html_e( 'Request My Samples', 'woocommerce' ); ?>
            </a>
        </div>
      </tr>

      <?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    
    // Superior Glove +
    remove_action( 'woocommerce_cart_collaterals','woocommerce_cart_totals', 10 );
    // Superior Glove -
     
    do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
