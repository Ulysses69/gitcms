<?php
class ClientdetailsController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/clientdetails/views/sidebar'));
	}
	public function index(){
		$this->generate();
	}
	public function generate(){
		$this->display('clientdetails/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('clientdetails');
			if (!$settings) {
				Flash::set('error', 'Client Details - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('clientdetails/views/settings', $settings);
	}
	public function save_settings(){
		
		// Store current clientname
		$temp_clientname = Plugin::getSetting('clientname', 'clientdetails');

		$tablename = TABLE_PREFIX.'clientdetails';
		$clientname = $_POST['clientname'];
		$clientslogan = $_POST['clientslogan'];
		//$clientaddress = $_POST['clientaddress'];
		$clientaddress_building = $_POST['clientaddress_building'];
		$clientaddress_thoroughfare = $_POST['clientaddress_thoroughfare'];
		$clientaddress_street = $_POST['clientaddress_street'];
		$clientaddress_locality = $_POST['clientaddress_locality'];
		$clientaddress_town = $_POST['clientaddress_town'];
		$clientaddress_county = $_POST['clientaddress_county'];
		$clientaddress_postcode = $_POST['clientaddress_postcode'];
		$clientphone = $_POST['clientphone'];
		$clientemail = $_POST['clientemail'];
		$schema = $_POST['schema'];
		//$clientlocation = $_POST['clientlocation'];
		//$clientanalytics = $_POST['clientanalytics'];
		$mondayopen = str_replace('.',':',$_POST['mondayopen']);
		$mondayclose = str_replace('.',':',$_POST['mondayclose']);
		$tuesdayopen = str_replace('.',':',$_POST['tuesdayopen']);
		$tuesdayclose = str_replace('.',':',$_POST['tuesdayclose']);
		$wednesdayopen = str_replace('.',':',$_POST['wednesdayopen']);
		$wednesdayclose = str_replace('.',':',$_POST['wednesdayclose']);
		$thursdayopen = str_replace('.',':',$_POST['thursdayopen']);
		$thursdayclose = str_replace('.',':',$_POST['thursdayclose']);
		$fridayopen = str_replace('.',':',$_POST['fridayopen']);
		$fridayclose = str_replace('.',':',$_POST['fridayclose']);
		$saturdayopen = str_replace('.',':',$_POST['saturdayopen']);
		$saturdayclose = str_replace('.',':',$_POST['saturdayclose']);
		$sundayopen = str_replace('.',':',$_POST['sundayopen']);
		$sundayclose = str_replace('.',':',$_POST['sundayclose']);
		$mondaylunchstart = str_replace('.',':',$_POST['mondaylunchstart']);
		$mondaylunchend = str_replace('.',':',$_POST['mondaylunchend']);
		$tuesdaylunchstart = str_replace('.',':',$_POST['tuesdaylunchstart']);
		$tuesdaylunchend = str_replace('.',':',$_POST['tuesdaylunchend']);
		$wednesdaylunchstart = str_replace('.',':',$_POST['wednesdaylunchstart']);
		$wednesdaylunchend = str_replace('.',':',$_POST['wednesdaylunchend']);
		$thursdaylunchstart = str_replace('.',':',$_POST['thursdaylunchstart']);
		$thursdaylunchend = str_replace('.',':',$_POST['thursdaylunchend']);
		$fridaylunchstart = str_replace('.',':',$_POST['fridaylunchstart']);
		$fridaylunchend = str_replace('.',':',$_POST['fridaylunchend']);
		$saturdaylunchstart = str_replace('.',':',$_POST['saturdaylunchstart']);
		$saturdaylunchend = str_replace('.',':',$_POST['saturdaylunchend']);
		$sundaylunchstart = str_replace('.',':',$_POST['sundaylunchstart']);
		$sundaylunchend = str_replace('.',':',$_POST['sundaylunchend']);
		$mondayappt = (isset($_POST['mondayappt'])) ? $_POST['mondayappt'] : '';
		$tuesdayappt = (isset($_POST['tuesdayappt'])) ? $_POST['tuesdayappt'] : '';
		$wednesdayappt = (isset($_POST['wednesdayappt'])) ? $_POST['wednesdayappt'] : '';
		$thursdayappt = (isset($_POST['thursdayappt'])) ? $_POST['thursdayappt'] : '';
		$fridayappt = (isset($_POST['fridayappt'])) ? $_POST['fridayappt'] : '';
		$saturdayappt = (isset($_POST['saturdayappt'])) ? $_POST['saturdayappt'] : '';
		$sundayappt = (isset($_POST['sundayappt'])) ? $_POST['sundayappt'] : '';
		$showcurrentday = $_POST['showcurrentday'];
		$hournotation = $_POST['hournotation'];
		$mergelunch = $_POST['mergelunch'];
		$daytag = $_POST['daytag'];
		$settings = array('clientname' => $clientname,
							'clientslogan' => $clientslogan,
							'clientaddress_building' => $clientaddress_building,
							'clientaddress_thoroughfare' => $clientaddress_thoroughfare,
							'clientaddress_street' => $clientaddress_street,
							'clientaddress_locality' => $clientaddress_locality,
							'clientaddress_town' => $clientaddress_town,
							'clientaddress_county' => $clientaddress_county,
							'clientaddress_postcode' => $clientaddress_postcode,
							'clientphone' => $clientphone,
							'clientemail' => $clientemail,
							'schema' => $schema,
							'mondayopen' => $mondayopen,
							'mondayclose' => $mondayclose,
							'tuesdayopen' => $tuesdayopen,
							'tuesdayclose' => $tuesdayclose,
							'wednesdayopen' => $wednesdayopen,
							'wednesdayclose' => $wednesdayclose,
							'thursdayopen' => $thursdayopen,
							'thursdayclose' => $thursdayclose,
							'fridayopen' => $fridayopen,
							'fridayclose' => $fridayclose,
							'saturdayopen' => $saturdayopen,
							'saturdayclose' => $saturdayclose,
							'sundayopen' => $sundayopen,
							'sundayclose' => $sundayclose,
							'mondaylunchstart' => $mondaylunchstart,
							'mondaylunchend' => $mondaylunchend,
							'tuesdaylunchstart' => $tuesdaylunchstart,
							'tuesdaylunchend' => $tuesdaylunchend,
							'wednesdaylunchstart' => $wednesdaylunchstart,
							'wednesdaylunchend' => $wednesdaylunchend,
							'thursdaylunchstart' => $thursdaylunchstart,
							'thursdaylunchend' => $thursdaylunchend,
							'fridaylunchstart' => $fridaylunchstart,
							'fridaylunchend' => $fridaylunchend,
							'saturdaylunchstart' => $saturdaylunchstart,
							'saturdaylunchend' => $saturdaylunchend,
							'sundaylunchstart' => $sundaylunchstart,
							'sundaylunchend' => $sundaylunchend,
							'mondayappt' => $mondayappt,
							'tuesdayappt' => $tuesdayappt,
							'wednesdayappt' => $wednesdayappt,
							'thursdayappt' => $thursdayappt,
							'fridayappt' => $fridayappt,
							'saturdayappt' => $saturdayappt,
							'sundayappt' => $sundayappt,
							'showcurrentday' => $showcurrentday,
							'hournotation' => $hournotation,
							'mergelunch' => $mergelunch,
							'daytag' => $daytag
		);

		if (Plugin::setAllSettings($settings, 'clientdetails')) {
			
			global $__FROG_CONN__;
			
			/* Update admin title */
			if($clientname != ''){
				$sql = "UPDATE ".TABLE_PREFIX."setting SET value='".$clientname."' WHERE name='admin_title'";
				$stmt = $__FROG_CONN__->prepare($sql);
				$stmt->execute();
			}

			/* Update googlemap latitude and longitude - assumes clientname has just been updated, and that googlemap latitude and longitude have not been updated first */
			if($clientname != '' && ($temp_clientname != $clientname) && Plugin::isEnabled('googlemap')){

				//if($latitude == null || $longitude == null){

					$clientaddress = str_replace('<br />', ', ', clientdetails_address(true,true));
					$clientaddress = str_replace('Blue Horizons Client, ', '', $clientaddress);
					$clientaddress = str_replace(' , ', ', ', $clientaddress);
					$clientaddress = str_replace('(Blue Horizons)','',$clientaddress);

					//$clientaddress = str_replace('(Blue Horizons)','',Plugin::getSetting('clientaddress', 'clientdetails'));
					$encoded_clientaddress = str_replace(' ','+',$clientaddress);
					$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$encoded_clientaddress.'&sensor=false');
					$output = json_decode($geocode);

					$lat_lon = '';
					if(is_object($output)){
						$latitude = $output->results[0]->geometry->location->lat;
						$longitude = $output->results[0]->geometry->location->lng;
						
						//echo $latitude . ' x ' . $longitude;
						//exit;
		
						$sql = "UPDATE ".TABLE_PREFIX."plugin_settings SET value='".$latitude."' WHERE plugin_id='googlemap' AND name='latitude'";
						$stmt = $__FROG_CONN__->prepare($sql);
						$stmt->execute();
		
						$sql = "UPDATE ".TABLE_PREFIX."plugin_settings SET value='".$longitude."' WHERE plugin_id='googlemap' AND name='longitude'";
						$stmt = $__FROG_CONN__->prepare($sql);
						$stmt->execute();
						
						$lat_lon = ' Googlemap latitude and longitude updated.';


					}
				//}

			}

			Flash::set('success', 'Client Details - '.__('plugin settings saved.'.$lat_lon));
			redirect(get_url('plugin/clientdetails'));
		} else {
			Flash::set('error', 'Client Details - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/clientdetails/settings'));
		}

	}
}