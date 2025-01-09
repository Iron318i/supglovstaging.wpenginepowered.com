<?php



/**

	Side Img Featured Text

**/



// Register Shortcode

if( ! function_exists( 'shortcode_boc_list_block' ) ) {

	function shortcode_boc_list_block( $atts, $content = null ) {

		 global $myscript;

		$atts = vc_map_get_attributes('boc_list_block', $atts );

		extract( $atts );	

		$thepoints =  (array) vc_param_group_parse_atts( $listitems );;
		$totalpoints = count ($thepoints); 
    $startpoint = 0;


		$str = '	
		
<div class="paddtitles">
<div class="boc_heading h6-look  al_left  " style="margin-bottom: 15px;margin-top: 0px;"><span>'.do_shortcode(wp_kses_post($smalltitle)).'</span></div>
<div class="boc_heading h3-look thick al_left  " style="margin-bottom: 40px;margin-top: 0px;"><span>'.do_shortcode(wp_kses_post($largetitle)).'</span></div>
</div>
<div class="list-wrapper">
    <div class="red-line"></div>';
    		
			
					
		foreach($thepoints as $alistpoint){	
			
     		   	$startpoint++;
				
		$str .= '<div class="list-item-wrapper">
			        <div class="list-bullet">0'.$startpoint.'</div>
			        <div class="list-item">
			            <div class="list-title">'.$alistpoint["listtitle"].'</div>
			            <div class="list-text">'.$alistpoint["listtext"].'</div>
			        </div>';
			        
			    if($startpoint == $totalpoints){
			    	$str .='<div class="white-line"></div>'; 
			    }    
			        
			        
			        
			   	$str .= '</div>';
			   	
	
      
    }
    
    			
						
						
		$str .= '</div>';
		
		
						
		return $str;

	}

	

	add_shortcode('boc_list_block', 'shortcode_boc_list_block');

}



// Map Shortcode in Visual Composer

vc_map( array(

   "name" => __("Ordered List Block", 'SuperiorGlove'),

   "description" => __("Ordered List Block", 'SuperiorGlove'),

   "base" 	=> "boc_list_block",

   "category" => "SuperiorGlove Shortcodes",

   "icon" 	=> "boc_list_block",

   "weight"	=> 64,

   "params" => array(


		array(

			"type" => "textfield",

			"heading" => __("Small Title", 'SuperiorGlove'),

			"param_name" => "smalltitle",

			"admin_label"=> true,

			"std" => "",

			"description" => __("Small subtitle", 'SuperiorGlove'),

		),
		
		

		array(

			"type" => "textfield",

			"heading" => __("Large Title", 'SuperiorGlove'),

			"param_name" => "largetitle",

			"admin_label"=> true,

			"std" => "",

			"description" => __("Large Main Subtitle subtitle", 'SuperiorGlove'),

		),
		
		
		



  // params group
  array(
	  'type' => 'param_group',
	  'value' => '',
	  'param_name' => 'listitems',
	  // Note params is mapped inside param-group:
	  'params' => array(
	
		array(
			"type" => "textfield",
			"heading" => __("List Item Title", 'SuperiorGlove'),
			"param_name" => "listtitle",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Enter title for this point", 'SuperiorGlove'),
		),
	
		array(
			"type" => "textfield",
			"heading" => __("List Item Text", 'SuperiorGlove'),
			"param_name" => "listtext",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Enter text for this point", 'SuperiorGlove'),
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