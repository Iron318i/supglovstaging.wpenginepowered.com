(function($) {
  wp.customize('checkoutheading', function(value) {
    value.bind(function(newval) {
      let $WooCommerceCheckoutHeading = $('#sg-checkoutheading');
      
      if ($WooCommerceCheckoutHeading.length) {
        $WooCommerceCheckoutHeading.html(newval);
      } else {
        let $WooCommerceCheckoutInfo = $('#sg-checkoutsampleboxinfo');
        
        if ($WooCommerceCheckoutInfo.length) {
          $WooCommerceCheckoutInfo.before('<h3 id="sg-checkoutheading" class="checkhead1">' + newval + '</h3>');
        } else {
          let $WooCommerceCheckoutForm = $('.woocommerce-js.woocommerce-page.woocommerce-checkout form.woocommerce-checkout[name="checkout"]');
          
          if ($WooCommerceCheckoutForm.length) {
            $WooCommerceCheckoutForm.before('<h3 id="sg-checkoutheading" class="checkhead1">' + newval + '</h3>');
          }
        }
      }
    });
  });
  
  wp.customize('sampleboxheading', function(value) {
    value.bind(function(newval) {
      let $WooCommerceCheckoutInfoHeading = $('#sg-checkoutsampleboxheading');
      
      if ($WooCommerceCheckoutInfoHeading.length) {
        $WooCommerceCheckoutInfoHeading.html(newval);
      } else {
        let $WooCommerceCheckoutInfoCloseBtn = $('#sg-checkoutsampleboxinfoclosebtn');
        
        if ($WooCommerceCheckoutInfoCloseBtn.length) {
          $WooCommerceCheckoutInfoCloseBtn.after('<h5 id="sg-checkoutsampleboxheading">' + newval + '</h5>');
        } else {
          let $WooCommerceCheckoutInfo = $('#sg-checkoutsampleboxinfo');
          
          if ($WooCommerceCheckoutInfo.length) {
            $WooCommerceCheckoutInfo.prepend('<h5 id="sg-checkoutsampleboxheading">' + newval + '</h5>');
          } else {
            let $WooCommerceCheckoutForm = $('.woocommerce-js.woocommerce-page.woocommerce-checkout form.woocommerce-checkout[name="checkout"]');
            
            if ($WooCommerceCheckoutForm.length) {
              let content = 
                `<div id="sg-checkoutsampleboxinfo" class="checkoutppemessage">
                  <div id="sg-checkoutsampleboxinfoclosebtn" class="closebuta"><i class="icon icon-ion-android-close"></i></div>
                  <h5 id="sg-checkoutsampleboxheading">${newval}</h5>
                </div>`;
              $WooCommerceCheckoutForm.before(content);
            }
          }
        }
      }
      
      let $WooCommerceMiniCartInfoHeading = $('#sg-minicartsampleboxheading');
      
      if ($WooCommerceMiniCartInfoHeading.length) {
        $WooCommerceMiniCartInfoHeading.html(newval);
      } else {
        let $WooCommerceMiniCartHeading = $('#sg-minicartheading');
        
        if ($WooCommerceMiniCartHeading.length) {
          $WooCommerceMiniCartHeading.after('<h6 id="sg-minicartsampleboxheading">' + newval + '</h6>');
        }
      }
    });
  });
  
  wp.customize('sampleboxmessage', function(value) {
    value.bind(function(newval) {
      let $WooCommerceCheckoutInfoMessage = $('#sg-checkoutsampleboxmessage');
      
      if ($WooCommerceCheckoutInfoMessage.length) {
        $WooCommerceCheckoutInfoMessage.html(newval);
      } else {
        let $WooCommerceCheckoutInfo = $('#sg-checkoutsampleboxinfo');
        
        if ($WooCommerceCheckoutInfo.length) {
          $WooCommerceCheckoutInfo.append('<div id="sg-checkoutsampleboxmessage">' + newval + '</div>');
        } else {
          let $WooCommerceCheckoutForm = $('.woocommerce-js.woocommerce-page.woocommerce-checkout form.woocommerce-checkout[name="checkout"]');
          
          if ($WooCommerceCheckoutForm.length) {
            let content = 
              `<div id="sg-checkoutsampleboxinfo" class="checkoutppemessage">
                <div id="sg-checkoutsampleboxinfoclosebtn" class="closebuta"><i class="icon icon-ion-android-close"></i></div>
                <div id="sg-checkoutsampleboxmessage">${newval}</div>
              </div>`;
            $WooCommerceCheckoutForm.before(content);
          }
        }
      }
      
      let $WooCommerceMiniCartInfoMessage = $('#sg-minicartsampleboxmessage');
      
      if ($WooCommerceMiniCartInfoMessage.length) {
        $WooCommerceMiniCartInfoMessage.html(newval);
      } else {
        let $WooCommerceMiniCartInfoHeading = $('#sg-minicartsampleboxheading');
        
        if ($WooCommerceMiniCartInfoHeading.length) {
          $WooCommerceMiniCartInfoHeading.after('<div id="sg-minicartsampleboxmessage">' + newval + '</div>');
        } else {
          let $WooCommerceMiniCartHeading = $('#sg-minicartheading');
        
          if ($WooCommerceMiniCartHeading.length) {
            $WooCommerceMiniCartHeading.after('<div id="sg-minicartsampleboxmessage">' + newval + '</div>');
          }
        }
      }
    });
  });
})(jQuery);