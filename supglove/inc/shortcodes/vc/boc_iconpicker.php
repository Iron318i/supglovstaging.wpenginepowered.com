<?php

/**
	SuperiorGlove Icons list - VC Iconpicker needs this
**/


add_filter( 'vc_iconpicker-type-ogsicons', 'vc_iconpicker_type_ogsicons' );
function vc_iconpicker_type_ogsicons( $icons ) {
	$ogsicons = array(            
            "ogsicons" => array(
                array( "none" => "" ),      
                
                
                      array( "icon-one" => "icon-one" ),
      								array( "icon-two" => "icon-two" ),
      								array( "icon-three" => "icon-three" ),

      								array( "icon-blogquote" => "icon-blogquote" ),
      								array( "icon-cartboxadd" => "icon-cartboxadd" ),
      								array( "icon-checkcircle" => "icon-checkcircle" ),
      								array( "icon-circledown" => "icon-circledown" ),
      								array( "icon-circleright" => "icon-circleright" ),
      								array( "icon-exportleft" => "icon-exportleft" ),
      								array( "icon-leftarrow" => "icon-leftarrow" ),
      								array( "icon-quoteleft1" => "icon-quoteleft1" ),
      								array( "icon-rightarrow" => "icon-rightarrow" ),
      								array( "icon-shopbox" => "icon-shopbox" ),
      								array( "icon-ion-close-round" => "icon-ion-close-round" ),
      								  

								array( "icon-svg" => "icon-svg" ),
								array( "icon-svg1" => "icon-svg1" ),
								array( "icon-svg2" => "icon-svg2" ),
								array( "icon-svg3" => "icon-svg3" ),
								array( "icon-svg4" => "icon-svg4" ),
								array( "icon-svg5" => "icon-svg5" ),
								array( "icon-svg6" => "icon-svg6" ),
								array( "icon-svg7" => "icon-svg7" ),
								array( "icon-svg8" => "icon-svg8" ),
								array( "icon-user" => "icon-user" ),
								array( "icon-puzzle" => "icon-puzzle" ),
								array( "icon-magnifier" => "icon-magnifier" ),
								array( "icon-loupe" => "icon-loupe" ),
								array( "icon-cross" => "icon-cross" ),
								array( "icon-plus" => "icon-plus" ),
								array( "icon-minus" => "icon-minus" ),
								array( "icon-chevron-up" => "icon-chevron-up" ),
								array( "icon-chevron-down" => "icon-chevron-down" ),
								array( "icon-chevron-left" => "icon-chevron-left" ),
								array( "icon-chevron-right" => "icon-chevron-right" ),
								array( "icon-arrow-left" => "icon-arrow-left" ),
								array( "icon-arrow-right" => "icon-arrow-right" ),
								array( "icon-layers" => "icon-layers" ),
								array( "icon-ion-android-add" => "icon-ion-android-add" ),
								array( "icon-ion-android-arrow-back" => "icon-ion-android-arrow-back" ),
								array( "icon-ion-android-arrow-down" => "icon-ion-android-arrow-down" ),
								array( "icon-ion-android-arrow-dropdown" => "icon-ion-android-arrow-dropdown" ),
								array( "icon-ion-android-arrow-dropleft" => "icon-ion-android-arrow-dropleft" ),
								array( "icon-ion-android-arrow-dropright" => "icon-ion-android-arrow-dropright" ),
								array( "icon-ion-android-arrow-dropup" => "icon-ion-android-arrow-dropup" ),
								array( "icon-ion-android-arrow-forward" => "icon-ion-android-arrow-forward" ),
								array( "icon-ion-android-arrow-up" => "icon-ion-android-arrow-up" ),
								array( "icon-ion-android-close" => "icon-ion-android-close" ),
								array( "icon-ion-android-done" => "icon-ion-android-done" ),
								array( "icon-ion-android-favorite-outline" => "icon-ion-android-favorite-outline" ),
								array( "icon-ion-android-favorite" => "icon-ion-android-favorite" ),
								array( "icon-ion-android-send" => "icon-ion-android-send" ),
								array( "icon-ion-android-textsms" => "icon-ion-android-textsms" ),
								array( "icon-ion-ios-medical" => "icon-ion-ios-medical" ),
								array( "icon-ion-quote" => "icon-ion-quote" ),
								array( "icon-ion-social-facebook-outline" => "icon-ion-social-facebook-outline" ),
								array( "icon-ion-social-facebook" => "icon-ion-social-facebook" ),
								array( "icon-ion-social-instagram-outline" => "icon-ion-social-instagram-outline" ),
								array( "icon-ion-social-instagram" => "icon-ion-social-instagram" ),
								array( "icon-ion-social-linkedin-outline" => "icon-ion-social-linkedin-outline" ),
								array( "icon-ion-social-linkedin" => "icon-ion-social-linkedin" ),
								array( "icon-ion-social-tumblr-outline" => "icon-ion-social-tumblr-outline" ),
								array( "icon-ion-social-tumblr" => "icon-ion-social-tumblr" ),
								array( "icon-uni23" => "icon-uni23" ),
								array( "icon-uni24" => "icon-uni24" ),
								array( "icon-uni3A" => "icon-uni3A" ),
								array( "icon-uni3B" => "icon-uni3B" ),
								array( "icon-uni3C" => "icon-uni3C" ),
								array( "icon-uni3D" => "icon-uni3D" ),
								array( "icon-uni3E" => "icon-uni3E" ),
								array( "icon-uni3F" => "icon-uni3F" ),
								array( "icon-uni40" => "icon-uni40" ),
								array( "icon-uni41" => "icon-uni41" ),
								array( "icon-uni4B" => "icon-uni4B" ),
								array( "icon-uni4C" => "icon-uni4C" ),
								array( "icon-uni4D" => "icon-uni4D" ),
								
								array( "icon-box" => "icon-box" ),
								array( "icon-uniF283" => "icon-uniF283" ),
								array( "icon-uniE014" => "icon-uniE014" ),
								array( "icon-uni77" => "icon-uni77" ),
								array( "icon-uniE015" => "icon-uniE015" ),
								array( "icon-uni5A" => "icon-uni5A" ),
								array( "icon-uni5A" => "icon-ion-social-twitter" ),
								array( "icon-uni5A" => "icon-ion-social-twitter-outline" ),
			
															                
                          
              )
              
              );
            


	return array_merge( $icons, $ogsicons );
}

















