(function ($) {
    'use strict';

    $(".tracking_btn").click(function(){
        window.lintrk('track', { conversion_id: 12482553 });
		window.lintrk('track', { conversion_id: 4312449 });
        console.log("linkedin tracking");
    })
})(jQuery);