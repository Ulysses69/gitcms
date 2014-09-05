<?php
class PageOptionsController extends PluginController {
	public function __construct(){
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/page_options/views/sidebar'));
	}
	public function index() {
		//$this->documentation();
		//$this->display('page_options/views/settings', $settings);
		$this->display('page_options/views/settings');
	}
	public function settings(){
		$settings = Plugin::getAllSettings('page_options');
			if (!$settings) {
				Flash::set('error', 'Page Options - '.__('unable to retrieve plugin settings.'));
				return;
			}
			$this->display('page_options/views/settings', $settings);
	}
	public function save_settings(){
		$tablename = TABLE_PREFIX.'page_options';
		$report_enabled = $_POST['report_enabled'];
		$updated_enabled = $_POST['updated_enabled'];
		$print_enabled = $_POST['print_enabled'];
		$mobile_enabled = $_POST['mobile_enabled'];
		$pdf_enabled = $_POST['pdf_enabled'];
		$top_of_page_enabled = $_POST['top_of_page_enabled'];
		$print_mobile_enabled = $_POST['print_mobile_enabled'];
		$mobile_desktop_enabled = $_POST['mobile_desktop_enabled'];
		$pdf_mobile_enabled = $_POST['pdf_mobile_enabled'];
		$top_of_page_mobile_enabled = $_POST['top_of_page_mobile_enabled'];
		$print_title = $_POST['print_title'];
		$mobile_title = $_POST['mobile_title'];
		$pdf_title = $_POST['pdf_title'];
		$top_of_page_title = $_POST['top_of_page_title'];
		$print_icon = $_POST['print_icon'];
		$mobile_icon = $_POST['mobile_icon'];
		$pdf_icon = $_POST['pdf_icon'];
		$top_of_page_icon = $_POST['top_of_page_icon'];
		$pdf_bg_color = $_POST['pdf_bg_color'];
		$pdf_text_color = $_POST['pdf_text_color'];
		$pdf_link_color = $_POST['pdf_link_color'];
		$print_logo_enabled = $_POST['print_logo_enabled'];
		$print_logo_url = $_POST['print_logo_url'];
		$print_logo_width = $_POST['print_logo_width'];
		$print_logo_height = $_POST['print_logo_height'];
		$pdf_logo_enabled = $_POST['pdf_logo_enabled'];
		$pdf_logo_url = $_POST['pdf_logo_url'];
		$pdf_logo_width = $_POST['pdf_logo_width'];
		$pdf_logo_height = $_POST['pdf_logo_height'];
		$pdf_download = $_POST['pdf_download'];
		$pdf_qrcode_enabled = $_POST['pdf_qrcode_enabled'];
		$pdf_qrcode_width = $_POST['pdf_qrcode_width'];
		$pdf_qrcode_height = $_POST['pdf_qrcode_height'];
		$pdf_size = $_POST['pdf_size'];
		$pdf_orientation = $_POST['pdf_orientation'];
		$pdf_h1_color = $_POST['pdf_h1_color'];
		$pdf_hx_color = $_POST['pdf_hx_color'];
		$settings = array(	'report_enabled' => $report_enabled,
				  			'updated_enabled' => $updated_enabled,
				  			'print_enabled' => $print_enabled,
				  			'mobile_enabled' => $mobile_enabled,
				  			'pdf_enabled' => $pdf_enabled,
				  			'top_of_page_enabled' => $top_of_page_enabled,
							'print_mobile_enabled' => $print_mobile_enabled,
							'mobile_desktop_enabled' => $mobile_desktop_enabled,
				  			'print_mobile_enabled' => $print_mobile_enabled,
				  			'top_of_page_mobile_enabled' => $top_of_page_mobile_enabled,
							'print_title' => $print_title,
							'mobile_title' => $mobile_title,
				  			'pdf_title' => $pdf_title,
				  			'top_of_page_title' => $top_of_page_title,
							'print_icon' => $print_icon,
							'mobile_icon' => $mobile_icon,
				  			'pdf_icon' => $pdf_icon,
				  			'top_of_page_icon' => $top_of_page_icon,
				  			'pdf_bg_color' => $pdf_bg_color,
				  			'pdf_text_color' => $pdf_text_color,
				  			'pdf_link_color' => $pdf_link_color,
				  			'print_logo_enabled' => $print_logo_enabled,
				  			'print_logo_url' => $print_logo_url,
				  			'print_logo_width' => $print_logo_width,
				  			'print_logo_height' => $print_logo_height,
				  			'pdf_logo_enabled' => $pdf_logo_enabled,
				  			'pdf_logo_url' => $pdf_logo_url,
				  			'pdf_logo_width' => $pdf_logo_width,
				  			'pdf_logo_height' => $pdf_logo_height,
				  			'pdf_download' => $pdf_download,
				  			'pdf_qrcode_enabled' => $pdf_qrcode_enabled,
				  			'pdf_qrcode_width' => $pdf_qrcode_width,
				  			'pdf_qrcode_height' => $pdf_qrcode_height,
				  			'pdf_size' => $pdf_size,
				  			'pdf_orientation' => $pdf_orientation,
				  			'pdf_h1_color' => $pdf_h1_color,
				  			'pdf_hx_color' => $pdf_hx_color);
		if (Plugin::setAllSettings($settings, 'page_options')) {
			Flash::set('success', 'Page Options - '.__('plugin settings saved.'));
			redirect(get_url('plugin/page_options/settings'));
		} else {
			Flash::set('error', 'Page Options - '.__('plugin settings not saved!'));
			redirect(get_url('plugin/page_options/settings'));
		}

	}
}