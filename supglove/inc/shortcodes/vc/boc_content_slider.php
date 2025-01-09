<?php
/**
	Content Slider
**/

// Register Shortcodes

// Content Slider



if( ! function_exists( 'shortcode_boc_content_slider' ) ) {
	function shortcode_boc_content_slider($atts, $content = null) {
    global $myscript;
		$atts = vc_map_get_attributes('boc_content_slider', $atts );
		extract( $atts );

		if(!$content) return;
		


		// Arrows
		$nav = ($navigation == "Dots") || ($navigation == "Both") || ($navigation == "Arrows") ;
    $navarrows =  ($navigation == "Arrows") || ($navigation == "Both") ;
    $navdots =  ($navigation == "Dots") || ($navigation == "Both") ;


		// Dots
		$dots = (($navigation == "Dots") || ($navigation == "Both"));
		

		
		$css_classes = '';
		if($dots){
			$css_classes .= ' has_dots'; 
		}			

		// generate rand ID
		$slider_id = rand(1,10000);






		$str = '<div id="content_slides_'.$slider_id.'" class="swiper-container carousel-sliderslick ">';
		$str .= do_shortcode($content);

		$str .= '</div>';
		
  if($auto_height) {  $auto_height = 'true'; } else {  $auto_height = 'false';  }

  $prevArrow   = '<span class="icon-leftarrow  slick-prev-arrow"></span>';
  $nextArrow   = '<span class="icon-rightarrow  slick-next-arrow"></span>';


		$myscript .= '
					<!-- content Slider -->
					<script type="text/javascript">

						jQuery(document).ready(function($) {								
						
		
$("#content_slides_'.$slider_id.'").slick({
  adaptiveHeight: '.$auto_height.',';
  
  
  
    if($loop >  0) {  
  	
  	$myscript .= '  
		   infinite: true,';
	}
	

  
  if($centermode >  0) {  
  	
  	$myscript .= '  
		  centerMode: true,
		  centerPadding: \''. $centermode . 'px\',		  
		  ';
	}


$myscript .= '
  
  speed: '.$speed.',
  slidesToShow: '.(int)$items_visible.',
  slidesToScroll: '.(int)$items_visible.',
  prevArrow     : \' '.$prevArrow.' \'  ,
	nextArrow     : \' '.$nextArrow.' \' ,';

 			
 			if($autoplay) {  
			   $myscript .= '
			    autoplay: true,
			    autoplaySpeed: 4000,';
			  }
		    




 			if($nav ){
 			
 			if($navdots) {  
			   $myscript .= '
			    // If we need pagination
			    dots: true,';
			  }
		    
		    
		    if($navarrows) { 
			    $myscript .= '
			     arrows: true,'; 		    
		  	}		    
		  }	  
		  
  
 $myscript .= ' 

  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: '.(int)$items_visible.',
        slidesToScroll: '.(int)$items_visible.',';
        
        if($lap_centermode) {  
			   $myscript .= '
			    centerMode: true,
			    centerPadding: \''. $lap_centermode . 'px\',';
			  }else{
			  	 $myscript .='centerMode: false,';
			  }
			  $myscript .=' 
			  
			  
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: '.(int)$items_laptop.',
        slidesToScroll: '.(int)$items_laptop.',';
        
        if($ipad_centermode) {  
			   $myscript .= '
			    centerMode: true,
			    centerPadding: \''. $ipad_centermode . 'px\',';
			  }else{
			  	 $myscript .='centerMode: false,';
			  }
			  $myscript .=' 
      }
    },
    {
      breakpoint: 640,
      settings: {
        slidesToShow: '.(int)$items_ipad.',
        slidesToScroll: '.(int)$items_ipad.',';
        
        if($mobile_centermode) {  
			   $myscript .= '
			    centerMode: true,
			    centerPadding: \''. $mobile_centermode . 'px\',';
			  }else{
			  	 $myscript .='centerMode: false,';
			  }



			  		  
			  if($navigationmobarrows == 'Yes') {			  				  
				  $myscript .=' 
	        arrows: true';
			  }  else{
			  	
				  $myscript .=' 
	        arrows: false'; 
	      }
			  	
			$myscript .='  
			
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: '.(int)$items_phone.',
        slidesToScroll: '.(int)$items_phone.',';
        
        if($mobile_centermode) {  
			   $myscript .= '
			    centerMode: true,
			    centerPadding: \''. $mobile_centermode . 'px\',';
			  }else{
			  	 $myscript .='centerMode: false,';
			  }
			  
			  		  
			  if($navigationmobarrows == 'Yes') {			  				  
				  $myscript .=' 
	        arrows: true';
			  }  else{
			  	
				  $myscript .=' 
	        arrows: true';
	      }
			  	
			$myscript .='  

		  

      }
    }
    
   ]
   
   });
   
});

</script>';
	
	
					
					
		add_action( 'wp_footer', 'print_my_inline_script', 9999 );
		
		return $str;		
	}
	
	add_shortcode('boc_content_slider', 'shortcode_boc_content_slider');
}	



		
// Content Slide Item
if( ! function_exists( 'shortcode_boc_content_slider_item' ) ) {
	function shortcode_boc_content_slider_item($atts, $content = null) {
		
		$atts = vc_map_get_attributes('boc_content_slider_item', $atts );
		extract( $atts );	

		$str = '<div class="content_slide_item swiper-slide'.esc_attr($css_classes).'">';
		$str .= do_shortcode($content);
		$str .= '</div>';

		return $str;
	}
	
	add_shortcode('boc_content_slider_item', 'shortcode_boc_content_slider_item');
}	
	
// Map Shortcodes in Visual Composer
vc_map( array(
	"name" 		=> __("Content Slider", 'SuperiorGlove'),
	"base" 		=> "boc_content_slider",
	"as_parent" => array('only' => 'boc_content_slider_item'), //limit child shortcodes
	"content_element" => true,
	"icon" 		=> "boc_content_slider",
	"category" 	=> "SuperiorGlove Shortcodes",
	"show_settings_on_create" => true,
	"js_view" 	=> 'VcColumnView',
	"weight"  	=> 26,
	"params" => array(
			array(
			"type"			=> 'dropdown',
			"heading" 		=> __("Slider Navigation", 'SuperiorGlove'),
			"param_name" 		=> "navigation",
			"value"			=> Array( "Dots", "Arrows", "Both", "None"),
			"description" 	=> __("Select a Navigation Type", 'SuperiorGlove'),
		),	
		
	array(
			"type"			=> 'dropdown',
			"heading" 		=> __("Enable Mobile Arrows", 'SuperiorGlove'),
			"param_name" 		=> "navigationmobarrows",
			"value"			=> Array( "No", "Yes"),
			"description" 	=> __("Force Arrows on Mobile", 'SuperiorGlove'),
		),	
		
		
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("AutoPlay the slider?", 'SuperiorGlove'),
			"param_name" 	=> "autoplay",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'true' ),
			"description" 	=> __("Set to Yes if you want your Testimonial Slider to autoplay", 'SuperiorGlove'),
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __("AutoPlay Interval", 'SuperiorGlove'),
			"param_name" 	=> "autoplay_interval",
			"value" 		=> array('4000','6000','8000','10000','12000','14000'),
			"std"			=> "6000",
			"description" 	=> __("Set the Autoplay Interval (miliseconds).", 'SuperiorGlove'),
			"dependency"	=> Array(
					'element'	=> "autoplay",
					'not_empty'	=> true,
			),
		),
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __("Animation Speed", 'SuperiorGlove'),
			"param_name" 	=> "speed",
			"value" 		=> array('250','500','750','1000'),
			"std"			=> "250",
			"description" 	=> __("Set the length of the Slider Animation (miliseconds)", 'SuperiorGlove'),
		),			
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("Loop the slider", 'SuperiorGlove'),
			"param_name" 	=> "loop",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'true' ),
			"description" 	=> __("Set to Yes if you want your Slider to be Infinite", 'SuperiorGlove'),
		),
		array(
			"type"			=> 'checkbox',
			"heading" 		=> __("Enable AutoHeight", 'SuperiorGlove'),
			"param_name" 	=> "auto_height",
			"value"			=> Array(__("Yes", "SuperiorGlove") => 'true' ),
			"description" 	=> __("Set to Yes for an AutoHeight slider - it will resize according to the item heights in sight", 'SuperiorGlove'),
		),
		
			
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Extra class name", 'SuperiorGlove'),
			"param_name" 	=> "css_classes1",
			"description" 	=> __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),
		
		
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __("Total Visible Items", 'SuperiorGlove'),
			"param_name" 	=> "items_visible",
			"value" 		=> Array(1,2,3,4,5,6),
			"std"			=> "3",
			"description" 	=> __("How many items you want the viewport to be consisted of.", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
		
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Desktop Center Mode Pixels", 'SuperiorGlove'),
			"param_name" 	=> "centermode",
			"std"			=> "0",
			"description" 	=> __("If greater than zero center mode will be enabled", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
		
		
		array(
			"type" 			=> "dropdown",
			"heading" 		=> __("Items Laptop", 'SuperiorGlove'),
			"param_name" 	=> "items_laptop",
			"value" 		=> Array(1,2,3,4,5,6),
			"std"			=> "1",
			"description" 	=> __("How many to show on laptop.", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
		
				
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Laptop Center Mode Pixels", 'SuperiorGlove'),
			"param_name" 	=> "lap_centermode",
			"std"			=> "0",
			"description" 	=> __("If greater than zero center mode will be enabled", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
				array(
			"type" 			=> "dropdown",
			"heading" 		=> __("Items iPad", 'SuperiorGlove'),
			"param_name" 	=> "items_ipad",
			"value" 		=> Array(1,2,3,4,5,6),
			"std"			=> "1",
			"description" 	=> __("How many to show on ipads.", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
		
				
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("iPad Center Mode Pixels", 'SuperiorGlove'),
			"param_name" 	=> "ipad_centermode",
			"std"			=> "0",
			"description" 	=> __("If greater than zero center mode will be enabled", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
				array(
			"type" 			=> "dropdown",
			"heading" 		=> __("Items Phone", 'SuperiorGlove'),
			"param_name" 	=> "items_phone",
			"value" 		=> Array(1,2,3,4,5,6),
			"std"			=> "1",
			"description" 	=> __("How many to show on phone", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
				
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Mobile Center Mode Pixels", 'SuperiorGlove'),
			"param_name" 	=> "mobile_centermode",
			"std"			=> "0",
			"description" 	=> __("If greater than zero center mode will be enabled", 'SuperiorGlove'),
			"group"			=> "Slider Settings",
		),
		
		
	)
));

vc_map( array(
	"name" => __("Content Slider Item", 'SuperiorGlove'),
	"base" => "boc_content_slider_item",
	"icon" 		=> "boc_content_slider",
	"as_child" => array('only' => 'boc_content_slider'),
	"as_parent" => array('except' => 'boc_custom_slider,boc_custom_slider_item,boc_content_slider,boc_content_slider_item,boc_img_carousel,boc_img_slider,boc_portfolio_carousel,boc_posts_carousel,boc_testimonials'),
	"js_view" => 'VcColumnView',
	"params" => array(
		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Extra class name", 'SuperiorGlove'),
			"param_name" 	=> "css_classes",
			"description" 	=> __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),		
	)
));

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_boc_content_slider extends WPBakeryShortCodesContainer {
	}
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_boc_content_slider_item extends WPBakeryShortCodesContainer {
	}
}
