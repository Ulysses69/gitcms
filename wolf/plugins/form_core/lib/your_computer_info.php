
			<?php
			$os = '';
			$os_starter = '<b>Operating System:</b>';
			$os_finish = "\n\n";
			$full = '';
			$handheld = '';

			// change this to match your include path/and file name you give the script
			include('browser_detection.php');
			$browser_info = browser_detection('full');
			
			// $mobile_device, $mobile_browser, $mobile_browser_number, $mobile_os, $mobile_os_number, $mobile_server, $mobile_server_number
			if ( $browser_info[8] == "\n\n" ){
				$handheld = '<b>Handheld Device:</b>';
				if ( $browser_info[13][0] )	{
					$handheld .= ucwords( $browser_info[13][0] );
					if ( $browser_info[13][7] )	{
						//$handheld = $handheld  . ' v: ' . $browser_info[13][7];
						$handheld = $handheld  . ' ' . $browser_info[13][7];
					}
					$handheld = $handheld  . "\n\n";
				}
				if ( $browser_info[13][3] )	{
					// detection is actually for cpu os here, so need to make it show what is expected
					if ( $browser_info[13][3] == 'cpu os' ) {
						$browser_info[13][3] = 'ipad os' . "\n\n";
					}
					$handheld .= 'OS: ' . ucwords( $browser_info[13][3] ) . ' ' .  $browser_info[13][4] . "\n\n";
					// don't write out the OS part for regular detection if it's null
					if ( !$browser_info[5] ){
						$os_starter = '';
						$os_finish = '';
					}
				}
				// let people know OS couldn't be figured out
				if ( !$browser_info[5] && $os_starter )	{
					$os_starter .= 'OS: Unknown';
				}
				if ( $browser_info[13][1] )	{
					$handheld .= 'Browser: ' . ucwords( $browser_info[13][1] ) . ' ' .  $browser_info[13][2] . "\n\n";
				}
				if ( $browser_info[13][5] )	{
					$handheld .= 'Server: ' . ucwords( $browser_info[13][5] . ' ' .  $browser_info[13][6] ) . "\n\n";
				}
				$handheld .= "\n\n";
			}
			
			/* Tidy abbreviation/brand syntax */
			$handheld = str_replace('Ip','iP',$handheld);
			$handheld = str_replace('Os','OS',$handheld);
			$handheld = str_replace('OS','Operating System',$handheld);

			switch ($browser_info[5]){
				case 'win':
					//$os .= 'Windows ';
					break;
				case 'nt':
					//$os .= 'Windows NT ';
					break;
				case 'lin':
					$os .= 'Linux ';
					break;
				case 'mac':
					$os .= 'Mac ';
					break;
				case 'iphone':
					$os .= 'iOS ';
					break;
				case 'unix':
					$os .= 'Unix ';
					break;
				default:
					$os .= $browser_info[5];
			}

			if ( $browser_info[5] == 'nt' ) {
				if ( $browser_info[5] == 'nt' ) {
					switch ( $browser_info[6] ) {
						case '5.0':
							//$os .= '5.0 (Windows 2000)';
							$os .= 'Windows 2000';
							break;
						case '5.1':
							//$os .= '5.1 (Windows XP)';
							$os .= 'Windows XP';
							break;
						case '5.2':
							//$os .= '5.2 (Windows XP x64 Edition or Windows Server 2003)';
							$os .= 'Windows XP x64 Edition or Windows Server 2003';
							break;
						case '6.0':
							//$os .= '6.0 (Windows Vista)';
							$os .= 'Windows Vista';
							break;
						case '6.1':
							//$os .= '6.1 (Windows 7)';
							$os .= 'Windows 7';
							break;
						case '6.2':
							//$os .= '6.2 (Windows 8)';
							$os .= 'Windows 8';
							break;
						case '6.3':
							//$os .= '6.3 (Windows 8.1)';
							$os .= 'Windows 8.1';
							break;
						case 'ce':
							$os .= 'CE';
							break;
						# note: browser detection 5.4.5 and later return always
						# the nt number in <number>.<number> format, so can use it
						# safely.
						default:
							if ( $browser_info[6] != '' ) {
								$os .= $browser_info[6];
							}
							else {
								$os .= '(Unknown Version)';
							}
							break;
					}
				}
			}
			elseif ( $browser_info[5] == 'iphone' ) {
				$os .=  'iOS (iPhone)';
			}
			// note: browser detection now returns os x version number if available, 10 or 10.4.3 style
			elseif ( ( $browser_info[5] == 'mac' ) && ( strstr( $browser_info[6], '10' ) ) ) {
				$os .=  'OS X ' . $browser_info[6];
			}
			elseif ( $browser_info[5] == 'lin' ) {
				$os .= ( $browser_info[6] != '' ) ? 'Distro ' . ucwords($browser_info[6] ) : 'Smart Move!!!';
			}
			// default case for cases where version number exists
			elseif ( $browser_info[5] && $browser_info[6] ) {
				$os .=  " " . ucwords( $browser_info[6] );
			}
			elseif ( $browser_info[5] && $browser_info[6] == '' ) {
				$os .=  ' (Unknown Version)';
			}
			elseif ( $browser_info[5] ) {
				$os .=  ucwords( $browser_info[5] );
			}
			$os = $os_starter . $os . $os_finish;
			//$full .= $handheld . $os . '<h4 class="right-bar">Current Browser / UA:</h4><p class="right-bar">';
			$full .= $handheld . $os . "\n\n";
			
			switch ( $browser_info[0] ) {
				case 'moz':
					$a_temp = $browser_info[10];// use the moz array
					$full .= ($a_temp[0] != 'mozilla') ? 'Mozilla ' . ucwords($a_temp[0]) . ' ' : ucwords($a_temp[0]) . ' ';
					$full .= $a_temp[1] . "\n\n";
					//$full .= 'ProductSub: ';
					$full .= ( $a_temp[4] != '' ) ? $a_temp[4] : 'Not Available';
					break;
				case 'ns':
					$full .= "Browser: Netscape";
					//$full .= 'Full Version Info: ' . $browser_info[1];
					$full .= ' ' . $browser_info[1] . "\n\n";
					break;
				case 'webkit':
					$a_temp = $browser_info[11];// use the webkit array
					$full .= 'User Agent: ';
					$full .= ucwords($a_temp[0]) . ' ' . $a_temp[1] . "\n\n";
					break;
				case 'ie':
					//$full .= 'User Agent: ';
					//$full .= strtoupper($browser_info[7]);
					$iename = strtoupper($browser_info[7]);
					if($iename == 'MSIE'){ $iename = 'Microsoft Internet Explorer'; }
					$full .= $iename;
					// $browser_info[14] will only be set if $browser_info[1] is also set
					if ( $browser_info[14] ) {
						if ( $browser_info[14] != $browser_info[1] ) {
							//$full .= '<br />(compatibility mode)';
							//$full .= '<br />Actual Version: ' . number_format( $browser_info[14], '1', '.', '' );
							$full .= number_format( $browser_info[14], '1', '.', '' );
							$full .= ' Compatibility Version ' . $browser_info[1];
						}
						else {
							if ( is_numeric($browser_info[1]) && $browser_info[1] < 11 ) {
								$full .= ' (Standard Mode)';
							}
							//$full .= '<br />Full Version Info: ' . $browser_info[1];
							$full .= ' ' . $browser_info[1];
						}
						$full .= "\n\n";
					}
					else {
						//$full .= '<br />Full Version Info: ';
						$full .= ( $browser_info[1] ) ? $browser_info[1] : 'Not Available';
					}
					break;
				default:
					$full .= 'User Agent: ';
					$full .= ucwords($browser_info[7]);
					//$full .= "\n\nFull Version Info: ";
					$full .= ( $browser_info[1] ) ? $browser_info[1] : 'Not Available';
					break;
			}
			
			/*
			if ( $browser_info[1] != $browser_info[9] ) {
				$full .= '<br />Main Version Number: ' . $browser_info[9];
			}
			if ( $browser_info[17][0] ) {
				$full .= '<br />Layout Engine: ' . ucfirst( ( $browser_info[17][0] ) );
				if ( $browser_info[17][1] ) {
					$full .= '<br />Engine Version: ' . ( $browser_info[17][1] );
				}
			}
			*/
			
			$full .= "\n\n";
			?>

