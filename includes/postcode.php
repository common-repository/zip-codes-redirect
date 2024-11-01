<?php  if ( ! defined( 'ABSPATH' ) ) { header( 'HTTP/1.0 403 Forbidden' ); exit;}

	//sanitize the user input
    $userzip = sanitize_text_field( $_POST['userzip'] );
    //lowercase the zip code
    $userzip = strtolower( $userzip );
	//remove spaces from user zip
    $userzip = str_replace( ' ', '', $userzip );
    //get length of zipcode
    $length = strlen( $userzip );
                
	switch ( get_option( 'zipcodescheck' ) ) {
						
		case "4":
                     // if not 4 get time elapsed return 1 and die      
			if ( $length != "4" ) {checktime(); esc_html_e( "1" ); wp_die();}
                    // routine to check 4 digit input is valid
			if( !preg_match( '/[0-9]/', $userzip[0] )|| !preg_match( '/[0-9]/', $userzip[1]) || !preg_match( '/[0-9]/', $userzip[2]) ||  !preg_match( '/[0-9]/', $userzip[3] )) {esc_html_e( "1" );wp_die();}
					
       break;
					
       case "5":
					// if not 5 get time elapsed return 1 and die                
           if ( $length != "5" ) {checktime();esc_html_e( "1" );wp_die();}
                    // routine to check 5 digit input is valid           
           if( !preg_match( '/[0-9]/', $userzip[0] )|| !preg_match( '/[0-9]/', $userzip[1]) || !preg_match( '/[0-9]/', $userzip[2]) ||  !preg_match( '/[0-9]/', $userzip[3] )|| !preg_match( '/[0-9]/', $userzip[4])) {esc_html_e( "1" );wp_die();}       
                                
	   break;
					
       case "6":        
                    // if not 6 get time elapsed return 1 and die           
		   if ( $length != "6" ) {checktime();esc_html_e( "1" );  wp_die();  }           
                    // routine to check Canadian style input is valid        
           if ( !preg_match( '/[a-c e g h j-n p r-t v x y]/', $userzip[0] ) ||  !preg_match( '/[0-9]/', $userzip[1] )|| !preg_match( '/[[a-c e g h j-n p r-t v-z]/', $userzip[2] ) || !preg_match( '/[0-9]/', $userzip[3] ) ||!preg_match( '/[a-c e g h j-n p r-t v-z]/', $userzip[4] ) || !preg_match( '/[0-9]/', $userzip[5] )){esc_html_e( "1" );wp_die();}                                       
       break;
					
       case "7":
					// if not 5, 6 or 7 digit postcode get time elapsed return 1 and die      	
		   if ( $length > "7" || $length < "5" ) {checktime(); esc_html_e( "1" ); wp_die();} 
					// routine to check 5 digit input is valid
	       if ($length == 5) {
	       if( !preg_match( '/[b e g l-n s w]/', $userzip[0] )|| !preg_match( '/[0-9]/', $userzip[1]) || !preg_match( '/[0-9]/', $userzip[2]) ||  !preg_match( '/[a-b d-h j l n p-u w-z ]/', $userzip[3] ) || !preg_match( '/[a-b d-h j l n p-u w-z ]/',$userzip[4] )) {esc_html_e( "1" );wp_die();}}
					// routine to check 6 digit input is valid
	       if ($length == 6) {
	       if ( !preg_match( '/[a-p r-u w y z]/', $userzip[0] ) ||  !preg_match( '/[0-9 a-h k-y]/', $userzip[1] ) || !preg_match( '/[0-9 a-h j k s-u w]/', $userzip[2] ) || !preg_match( '/[0-9]/', $userzip[3] ) || !preg_match( '/[a-b d-h j l n p-u w-z ]/', $userzip[4] ) || !preg_match( '/[a-b d-h j l n p-u w-z ]/', $userzip[5] )){esc_html_e( "1" );wp_die();}}
					// routine to check 7 digit input is valid
	       if ($length == 7){
	       if ( !preg_match( '/[a-p r-u w y z]/', $userzip[0] ) || !preg_match( '/[a-h k-y]/', $userzip[1] ) || !preg_match( '/[0-9]/', $userzip[2] ) || !preg_match( '/[0-9 a-z]/', $userzip[3] ) || !preg_match( '/[0-9]/', $userzip[4] ) || !preg_match( '/[a-b d-h j l n p-u w-z ]/', $userzip[5] ) || !preg_match( '/[a-b d-h j l n p-u w-z ]/', $userzip[6] )){esc_html_e( "1" );wp_die();}}} 
		   
     ?>