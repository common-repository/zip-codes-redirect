<?php           

			if ( ! defined( 'ABSPATH' ) ) { header( 'HTTP/1.0 403 Forbidden' ); exit;}
			
			if ( strpos( $adminzips , "There" ) === 0) {esc_html_e( "Please Contact The Webmaster"); wp_die();}//if error message in admin data
			
			if ( strpos( $adminzips , "http" )  === 0) {//if url in admin data
					
				$adminzips = explode( " ", $adminzips );// put all zipcodes in an array   	
                  
				$url = array_shift( $adminzips );// get the url and remove from array	
				
				foreach ( $adminzips as $checkzip ) {//routine to check values of array
                
				$checkzip = trim ($checkzip);
				   
				$length = strlen( $checkzip );// get length of admin zip code
				
				$check = strlen( $userzip );// get length of user zip code
				
				switch ( get_option( 'zipcodescheck' ) ) {case "7":// check for uk postcode
				// if admin postcode is 3 digits dont compare with a 7 digit user postcode
				// if admin postcode is 2 digits dont compare with a 6 digit user postcode
				// if admin postcode is 4 digits dont compare with a 6 digit user postcode
				// if any of the above are true return as no match
				if (($length === 3 && $check === 7) || ($length === 2 && $check === 6) || ($length === 4 && $check === 6) ) 
				{return;}}
				
                $userzips = substr( $userzip, 0, $length );// get the zipcode from user input
                    
				if ( $userzips === strtolower( $checkzip )) { //if they match
				
				$zipcodes =  esc_html(get_option( 'zipcodeswon' ));// get all redirected urls and zips
				
				$zipcodes = $zipcodes . "\n"  .  strtoupper($userzip) . " -Redirected To- " . $url ;//latest zip to be saved
				
				$zipcodes = explode( "\n" ,$zipcodes);// put zips in array
				
				$check = count($zipcodes);// limit zips in admin
					
				if ($check > 10) {$zipcodes = array_slice($zipcodes,-10);}// only 10 zipcodes saved
					
				$zipcodes = implode( "\n" ,$zipcodes);// put zips in string
					
				update_option('zipcodeswon', $zipcodes);
				
				checktime();
				
				esc_html_e( $url ); wp_die();}}}
				
			else{	// no url in admin data
				
				$length = strrpos($adminzips ,"-");// find last occurrence of dash
				
				$url = substr($adminzips,0,$length);// get all text before the dash
				
				$length = strpos($url,"user input");// see if user input is in the text	
		
				if ( $length )  {// if it is construct message with user input
				
				$url = substr ($url ,0, strpos($url,"user input")) . strtoupper($userzip) . substr ($url , $length + 10) ;}
				
				$length = strrpos($adminzips,"-");// find last occurrence of dash
				
				$adminzips = substr($adminzips,$length);// remove the message from adminzips
					
				$adminzips= ltrim($adminzips,"-");// remove the - from adminzips
					
				$adminzips= trim($adminzips," ");//remove all whitespace
					
				$adminzips = explode( " ", $adminzips );// put all zipcodes in an array 
				
				foreach ( $adminzips as $value ) {//routine to check values of array
                    
				$length = strlen( $value );// get length of admin zip code
				
				$check = strlen( $userzip );// get length of user zip code
				
				switch ( get_option( 'zipcodescheck' ) ) {case "7":// check for uk postcode
				// if admin postcode is 3 digits dont compare with a 7 digit user postcode
				// if admin postcode is 2 digits dont compare with a 6 digit user postcode
				// if admin postcode is 4 digits dont compare with a 6 digit user postcode
				// if any of the above are true return as no match
				if (($length === 3 && $check === 7) || ($length === 2 && $check === 6) || ($length === 4 && $check === 6) ) 
				{return;}}

                $userzips = substr( $userzip, 0, $length );// get the zipcode from user input
                    
				if ( $userzips === strtolower( $value )) { //if they match
					
				$zipcodes =  esc_html(get_option( 'zipcodeswon' ));// get all redirected urls and zips
				
				$zipcodes = $zipcodes . "\n"  .  strtoupper($userzip) . " -Messaged- " . $url ;//latest zip to be saved
				
				$zipcodes = explode( "\n" ,$zipcodes);// put zips in array
				
				$check = count($zipcodes);// limit zips in admin
					
				if ($check > 10) {$zipcodes = array_slice($zipcodes,-10);}// only 10 zipcodes saved
					
				$zipcodes = implode( "\n" ,$zipcodes);// put zips in string
					
				update_option('zipcodeswon', $zipcodes);
				
				checktime();
				
				esc_html_e( $url ); wp_die();}}}   
				
?>