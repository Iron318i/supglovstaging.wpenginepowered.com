<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

  <?php /* ?>
	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
    <?php
    do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				//
				// This filter is documented in woocommerce/templates/cart/cart.php.
				//
				// @since 2.1.0
				//
        $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
        <li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php
					echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            'woocommerce_cart_item_remove_link', 
            sprintf(
              '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
              esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
              // translators: %s is the product name
              // esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
              esc_html__( 'Remove this item', 'supro' ),
              esc_attr( $product_id ),
              esc_attr( $cart_item_key ),
              esc_attr( $_product->get_sku() )
            ), 
            $cart_item_key 
          );
          ?>
          <div class="un-mini-cart-thumbnail">
						<?php if ( empty( $product_permalink ) ) : ?>
              <?php // echo $thumbnail . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php echo str_replace( array('http:', 'https:'), '', $thumbnail ); ?>
						<?php else : ?>
              <a href="<?php echo esc_url( $product_permalink ); ?>">
                <?php // echo $thumbnail . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo str_replace( array('http:', 'https:'), '', $thumbnail ); ?>
              </a>
						<?php endif; ?>
          </div>
          <div class="un-mini-cart-content">
						<?php if ( empty( $product_permalink ) ) : ?>
							<?php echo wp_kses_post( $product_name ); ?>
						<?php else : ?>
              <a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo wp_kses_post( $product_name ); ?>
              </a>
						<?php endif; ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php // echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s: %s %s', esc_html__( 'Qty', 'supro' ), $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
          </div>
        </li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
  </ul>
  <?php */ ?>

  <div class="un-cart-panel-footer">
    <?php /* ?>
    <p class="woocommerce-mini-cart__total total">
      <?php
      //
      // Hook: woocommerce_widget_shopping_cart_total.
      //
      // @hooked woocommerce_widget_shopping_cart_subtotal - 10
      //
      do_action( 'woocommerce_widget_shopping_cart_total' );
      ?>
    </p>
    <?php */ ?>
    
    <?php 
      $cart_contents_count = WC()->cart->get_cart_contents_count();
      $sampleboxheading = supro_get_option( 'sampleboxheading' ); // esc_html__( 'Please read before ordering:', 'supro' )
      $sampleboxmessage = supro_get_option( 'sampleboxmessage' );
    ?>
    <h3 id="sg-minicartheading"><?php 
      esc_html_e('You have', 'supro' ); 
      ?> <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" style="color: #fd8541;"><?php
        if ( $cart_contents_count > 1 ) {
          // echo WC()->cart->get_cart_contents_count() . ' Items ';
          printf( _x('%s Items ', 'WooCommerce mini cart', 'SuperiorGlove'), $cart_contents_count );
        } else {
          // echo WC()->cart->get_cart_contents_count() . ' Item ';
          printf( _x('%s Item ', 'WooCommerce mini cart', 'SuperiorGlove'), $cart_contents_count );
        }
      ?></a> <?php 
      esc_html_e( 'in Your Sample Box', 'supro' ); 
    ?></h3>
    <?php if ( !empty($sampleboxheading) ) : ?>
      <h6 id="sg-minicartsampleboxheading"><?php echo esc_html( $sampleboxheading ); ?></h6>
    <?php endif; ?>
    <?php if ( !empty($sampleboxmessage) ) : ?>
      <div id="sg-minicartsampleboxmessage"><?php echo $sampleboxmessage; ?></div>
    <?php endif; ?>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

      <p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

    <?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	</div>
<?php else : ?>

  <?php /* ?>
  <p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>
  <?php */ ?>

  <h5><?php esc_html_e( 'No products in your box.', 'supro' ); ?></h5>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
