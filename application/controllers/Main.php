<?php
class Main extends CI_Controller{

	public function index(){
		$this->load->library('excel');
		//$objPHPExcel = PHPExcel_IOFactory::load('assets/sample.xls');
		//$this->load->view('admin/sidebar_view');
		//$this->load->view('admin/member_view');

		//$this->load->view('template/main');
		$this->load->view('main/content_landing');
		// $this->load->view('admin/navbar_view');
		//$this->load->view('admin/sidebar_view');
		//$this->load->view('admin/home_view');
		//$this->load->view('template/footer');
	}
}