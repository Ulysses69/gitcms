
			<?php
			$os = '';
			$os_starter = '<b>Operating System:</b><p class="right">';
			$os_finish = '</p>';
			$full = '';
			$handheld = '';

			// change this to match your include path/and file name you give the script
			include('browser_detection.php');
			$browser_info = browser_detection('full');
			
			// $mobile_device, $mobile_browser, $mobile_browser_number, $mobile_os, $mobile_os_number, $mobile_server, $mobile_server_number
			if ( $browser_info[8] == 'mobile' )
			{
				$handheld = '<b>Handheld Device:</b><p class="right">';
				if ( $browser_info[13][0] )
				{
					$handheld .= ucwords( $browser_info[13][0] );
					if ( $browser_info[13][7] )
					{
						$handheld = $handheld  . ' v: ' . $browser_info[13][7];
					}
					$handheld = $handheld  . '<br />';
				}
				if ( $browser_info[13][3] )
				{
					$handheld .= ' OS: ' . ucwords( $browser_info[13][3] ) . ' ' .  $browser_info[13][4] . '<br />';
					// don't write out the OS part for regular detection if it's null
					if ( !$browser_info[5] )
					{
						$os_starter = '';
						$os_finish = '';
					}
				}
				// let people know OS couldn't be figured out
				if ( !$browser_info[5] && $os_starter )
				{
					$os_starter .= 'OS: Unknown';
				}
				if ( $browser_info[13][1] )
				{
					$handheld .= 'Browser: ' . ucwords( $browser_info[13][1] ) . ' ' .  $browser_info[13][2] . '<br />';
				}
				if ( $browser_info[13][5] )
				{
					$handheld .= 'Server: ' . ucwords( $browser_info[13][5] . ' ' .  $browser_info[13][6] ) . '<br />';
				}
				$handheld .= '</p>';
			}
			
			/* Tidy abbreviation/brand syntax */
			$handheld = str_replace('Ip','iP',$handheld);
			$handheld = str_replace('Os','OS',$handheld);

			switch ($browser_info[5])
			{
				case 'win':
					//$os .= 'Windows ';
					break;
				case 'nt':
					//$os .= 'Windows NT ';
					break;
				case 'lin':
					$os .= 'Linux<br /> ';
					break;
				case 'mac':
					$os .= 'Mac ';
					break;
				case 'iphone':
					$os .= 'Mac ';
					break;
				case 'unix':
					$os .= 'Unix Version: ';
					break;
				default:
					$os .= $browser_info[5];
			}

			if ( $browser_info[5] == 'nt' )
			{
				if ($browser_info[6] == 5)
				{
					//$os .= '5.0 (Windows 2000)';
					$os .= 'Windows 2000';
				}
				elseif ($browser_info[6] == 5.1)
				{
					//$os .= '5.1 (Windows XP)';
					$os .= 'Windows XP';
				}
				elseif ($browser_info[6] == 5.2)
				{
					//$os .= '5.2 (Windows XP x64 Edition or Windows Server 2003)';
					$os .= 'Windows XP x64 Edition or Windows Server 2003';
				}
				elseif ($browser_info[6] == 6.0)
				{
					//$os .= '6.0 (Windows Vista)';
					$os .= 'Windows Vista';
				}
				elseif ($browser_info[6] == 6.1)
            {
               //$os .= '6.1 (Windows 7)';
               $os .= 'Windows 7';
            }
            elseif ($browser_info[6] == 'ce')
            {
               $os .= 'CE';
            }
			}
			elseif ( $browser_info[5] == 'iphone' )
			{
				$os .=  'OS X (iPhone)';
			}
			// note: browser detection now returns os x version number if available, 10 or 10.4.3 style
			elseif ( ( $browser_info[5] == 'mac' ) && ( strstr( $browser_info[6], '10' ) ) )
			{
				$os .=  'OS X v: ' . $browser_info[6];
			}
			elseif ( $browser_info[5] == 'lin' )
			{
				$os .= ( $browser_info[6] != '' ) ? 'Distro: ' . ucwords($browser_info[6] ) : 'Smart Move!!!';
			}
			// default case for cases where version number exists
			elseif ( $browser_info[5] && $browser_info[6] )
			{
				$os .=  " " . ucwords( $browser_info[6] );
			}
			elseif ( $browser_info[5] && $browser_info[6] == '' )
			{
				$os .=  ' (version unknown)';
			}
			elseif ( $browser_info[5] )
			{
				$os .=  ucwords( $browser_info[5] );
			}
			$os = $os_starter . $os . $os_finish;
			$full .= $handheld . $os . '<b>Browser:</b><p class="right">';
			if ($browser_info[0] == 'moz' )
			{
				$a_temp = $browser_info[10];// use the moz array
				//$full .= ($a_temp[0] != 'mozilla') ? 'Mozilla/ ' . ucwords($a_temp[0]) . ' ' : ucwords($a_temp[0]) . ' ';
				$full .= ($a_temp[0] != 'mozilla') ? 'Mozilla ' . ucwords($a_temp[0]) . ' ' : ucwords($a_temp[0]) . ' ';
				//$full .= $a_temp[1];
				//$full .= ( $a_temp[4] != '' ) ? '.'.$a_temp[4] . '<br />' : 'Not Available<br />';
			}
			elseif ($browser_info[0] == 'ns' )
			{
				$full .= 'Browser: Netscape<br />';
				$full .= 'Full Version Info: ' . $browser_info[1];
			}
			elseif ( $browser_info[0] == 'webkit' )
			{
				$a_temp = $browser_info[11];// use the webkit array
				$full .= 'User Agent: ';
				$full .= ucwords($a_temp[0]) . ' ' . $a_temp[1];
			}
			elseif ( $browser_info[0] == 'ie' )
			{
				$full .= '';
				$iename = strtoupper($browser_info[7]);
				if($iename == 'MSIE'){ $iename = 'Microsoft Internet Explorer'; }
				$full .= $iename;
				// $browser_info[14] will only be set if $browser_info[1] is also set
				if ( array_key_exists( '14', $browser_info ) && $browser_info[14] )
				{
					$full .= '<br />(compatibility mode)';
					$full .= '<br />Actual Version: ' . number_format( $browser_info[14], '1', '.', '' );
					$full .= '<br />Compatibility Version: ' . $browser_info[1];
				}
				else
				{
					$full .= ' ';
					$full .= ( $browser_info[1] ) ? $browser_info[1] : 'Not Available';
				}
			}
			else
			{
				$full .= 'User Agent: ';
				$full .= ucwords($browser_info[7]);
				$full .= '<br />Full Version Info: ';
				$full .= ( $browser_info[1] ) ? $browser_info[1] : 'Not Available';
			}
			$full .= '</p>';
			?>

