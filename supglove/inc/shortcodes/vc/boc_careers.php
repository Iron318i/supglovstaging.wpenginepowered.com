<?php
/**
	Careers Block with Rows of Jobs
**/

// Register Shortcodes








if( ! function_exists( 'shortcode_boc_job_block' ) ) {
	function shortcode_boc_job_block($atts, $content = null) {
		$atts = vc_map_get_attributes('boc_job_block', $atts );
		extract( $atts );

		//if(!$content) return;
		

		// generate rand ID
		$slider_id = rand(1,10000);
		
		
		$jobblocks =  (array) vc_param_group_parse_atts( $jobs );;
		
		//var_dump($jobblocks);
	

		$str = '<div id="content_job_block_'.$slider_id.'"  class="wrappercar '.$css_classes1.'"><div class="tablecar">';
		//$str .= do_shortcode($content);
		

		
		foreach($jobblocks as $thejob){
			
		
		$str .= '<div class="rowcar"><div class="cellcar title" data-title="Position">
        '.$thejob["jobposition"].'
      </div>
      <div class="cellcar location center" data-title="Location">
         '.$thejob["joblocation"].'
      </div>
      <div class="cellcar link right" data-title="Link">
        <a href="'.$thejob["joburl"].'" class="buttonogs btn_small btn_white icon_pos_after  " target="_blank"><span>Apply Now </span> <i class="icon-arrow-right"></i> </a>
      </div></div>';
      
    }
      
      
      

		$str .= '</div></div>';
	
		
		return $str;		
	}
	
	add_shortcode('boc_job_block', 'shortcode_boc_job_block');
}	



// Map Shortcodes in Visual Composer
vc_map( array(
	"name" 		=> __("Job Postings", 'SuperiorGlove'),
	"description" => __("Job Application Table", 'SuperiorGlove'),
	"base" 		=> "boc_job_block",
	"icon" 		=> "boc_job_block",
	"category" 	=> "SuperiorGlove Shortcodes",
	"weight"  	=> 26,
	
	
	
	
	
	"params" => array(
	
	
	
  // params group
  array(
	  'type' => 'param_group',
	  'value' => '',
	  'param_name' => 'jobs',
	  // Note params is mapped inside param-group:
	  'params' => array(
	
		array(
			"type" => "textfield",
			"heading" => __("Job Position", 'SuperiorGlove'),
			"param_name" => "jobposition",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Enter Position Available", 'SuperiorGlove'),
		),
	
		array(
			"type" => "textfield",
			"heading" => __("Job Location", 'SuperiorGlove'),
			"param_name" => "joblocation",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Enter Position Location", 'SuperiorGlove'),
		),	
	
		array(
			"type" => "textfield",
			"heading" => __("Job URL", 'SuperiorGlove'),
			"param_name" => "joburl",
			"admin_label"=> true,
			"std" => "",
			"description" => __("Enter URL for Position Details", 'SuperiorGlove'),
		)
					  
	  )
  ),	

		array(
			"type" 			=> "textfield",
			"heading" 		=> __("Extra class name", 'SuperiorGlove'),
			"param_name" 	=> "css_classes1",
			"description" 	=> __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'SuperiorGlove'),
		),
				
	)
));


