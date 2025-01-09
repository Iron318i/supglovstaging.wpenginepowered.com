<?php



/**

	TimeLine

**/



// Register Shortcode

if( ! function_exists( 'shortcode_boc_timeline' ) ) {

	function shortcode_boc_timeline( $atts, $content = null ) {

		 global $myscript;

		$atts = vc_map_get_attributes('boc_timeline', $atts );

		extract( $atts );			
		

		
		$yearitems =  (array) vc_param_group_parse_atts( $timelineitems );;

		$str = '<div class="timeline"><div class="timeline-nav">';
     			
		foreach($yearitems as $theyear){					
					$str .= '<div class="timeline-nav__item">'.$theyear["theyear"].'</div>';	        
    }
    
    $str .= '</div><div class="timeline-wrapper">
            <div class="timeline-slider">';	   
    
    
		
		foreach($yearitems as $theyear){	
			
			
			$img = '';
			if($theyear["picture_url"] !== ''){
				$vc_image = wp_get_attachment_image_src($theyear["picture_url"],'full');
	      $img = $vc_image;
			}
				
			$str .= '<div class="timeline-slide"  data-year="'.$theyear["theyear"].'"> 
                    <div class="timeline-slide__content text-center">';
                    
      if( $img !== ''){            
      	$str .= '<img src="'.$img[0].'" alt="">';
      }
      
      
                      
      $str .= ' <p class="lead">'.$theyear["listtext"].'</p>
                        <h4 class="timeline-title">'.$theyear["theyear"].'</h4>
                    </div>
                </div>';
			        
    }
    
    			
						
						
		$str .= '</div></div>';
		
		
						
		return $str;

	}

	

	add_shortcode('boc_timeline', 'shortcode_boc_timeline');

}



// Map Shortcode in Visual Composer

vc_map( array(

   "name" => __("Timeline Slider", 'SuperiorGlove'),
   "description" => __("TimeLine", 'SuperiorGlove'),
   "base" 	=> "boc_timeline",
   "category" => "SuperiorGlove Shortcodes",
   "icon" 	=> "boc_timeline",
   "weight"	=> 64,
   "params" => array(

	
		

  // params group
  array(
	  'type' => 'param_group',
	  'value' => '',
	  'param_name' => 'timelineitems',
	  // Note params is mapped inside param-group:
	  'params' => array(
	
		array(
			"type" => "textfield",
			"heading" => __("Year", 'SuperiorGlove'),
			"param_name" => "theyear",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Year for Timeline", 'SuperiorGlove'),
		),
	
		array(
			"type" => "textarea",
			"heading" => __("Content for Time Line", 'SuperiorGlove'),
			"param_name" => "listtext",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Enter text for this point", 'SuperiorGlove'),
		),	
		
		array(
			"type" => "attach_image",
			"heading" => __("Picture Optional", 'SuperiorGlove'),
			"param_name" => "picture_url",
		),
	
				  
	  )
  ),	





		array(
			"type" => "textfield",
			"heading" => __("Extra class name", 'SuperiorGlove'),
			"param_name" => "css_classes",
			"value" => "",
			"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),

   )

));