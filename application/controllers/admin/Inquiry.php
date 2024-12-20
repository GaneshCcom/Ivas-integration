<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquiry extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			// load helper
			$this->load->library(array('table','form_validation', 'email'));
			$this->load->helper('url'); 
			$this->load->library('session');
			// load model
			 $this->load->model('admin_model','',TRUE);
			 $adminSession = $this->session->userdata('adminSession');
		}
		public function genral()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Genral Inquiry';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$inquiryLists = $this->admin_model->get_all_genral_inquiry()->result();
			$data['inquiryLists'] = $inquiryLists;


			$this->load->view('admin/inquiry/genral', $data);
		}
		public function product()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Product Inquiry';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$inquiryLists = $this->admin_model->get_all_product_inquiry()->result();
			$data['inquiryLists'] = $inquiryLists;


			$this->load->view('admin/inquiry/product', $data);
		}
}
?>	