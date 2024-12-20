<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		// load helper
		$this->load->library(array('table','form_validation', 'email'));
		$this->load->helper('url');
		$this->load->library('session');
		//$this->load->library('cookie');

		// load model
		$this->load->model('admin_login_model','',TRUE);
	}
	
	
	function index()
	{
		$this->admin_login_model->isset_common_user();
		$data['title'] = 'Login';
		$data['action'] = site_url('login');
		$data['actionForgot'] = site_url('admin/login/forgotpassword');
		$this->_set_fields();
		$this->_set_rules();
				
	
		if(isset($_REQUEST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
			{
				$data['message'] = '';
				//"check validation";
			}
			else
			{
				// save data
				$username = $this->input->post('admin_email');
				$password = md5($this->input->post('admin_password'));
				//$remember = $this->input->post('remember');
				
				/*if($remember){
					$this->session->set_userdata('remember', 1);
					$this->load->helper('cookie');
					$cookie = $this->input->cookie('remember'); // we get the cookie
					$this->input->set_cookie('remember', $cookie, '604800'); // and add one week to it's expiration
				}*/
			
					$user = $this->admin_login_model->authenticate($username, $password);
					if(!empty($user)){	
					$current = date('Y-m-d H:i:s');
					$adminSession = array('admin_id' => $user->admin_id, 'admin_name' => $user->admin_first_name.' '.$user->admin_last_name, 'admin_email' => $user->admin_email, 'admin_photo' => $user->admin_photo, 'admin_lastlogin' => date('Y-m-d H:i:s', strtotime($user->admin_lastlogin)), 'loggedin' => true);
					//$cmp = array('id' => $user->id, 'username' => $user->username, 'loggedin' => true, 'lastlogin' => date('Y-m-d H:i:s', strtotime($user->lastlogin)));
					
					$this->session->set_userdata('adminSession', $adminSession);
					
					$id = $adminSession['admin_id'];
					$this->admin_login_model->lastlogin($id);
					@redirect('admin/dashboard');
					}else {
						$this->session->set_flashdata('message', '<div id="message alert">Invalid Login</div>');
						redirect('admin/login');
					}
					
				
			}
		}
		$this->load->view('admin/login/index', $data);
	}
	
	function logout()
	{
	    $this->session->sess_destroy();
		$adminSession = $this->session->userdata('adminSession');
		$adminSession = array('admin_id' => '', 'admin_name' => '', 'admin_email' => '',  'admin_lastlogin' => '', 'loggedin' => false);
		$this->session->set_userdata('adminSession', $adminSession);
		$this->session->set_flashdata('message', '<div id="message alert">Logout successfully.</div>');
	    redirect('admin/login');
	}
	
  	public function forgotpassword()
   	{
	   $this->admin_login_model->isset_common_user();
		$data['title'] = 'Forgot Password';
		$data['action'] = site_url('admin/login/forgotpassword');	
		$this->_set_forgotpwd_fields();
		$this->_set_forgotpwd_rules();
		if(isset($_REQUEST['submit']))
		{
			if ($this->form_validation->run() == FALSE)
			{
				$data['message'] = '';
				//"check validation";
			}
			else
			{
         		$admin_email = $this->input->post('admin_email');      
				$findadmin_email = $this->admin_login_model->ForgotPassword($admin_email);  
				if(isset($findadmin_email)){

		          $this->admin_login_model->sendpassword($findadmin_email);        
		           }else{
		          $this->session->set_flashdata('forgotmessage','<div id="alert" class="alert alert-danger">Email not found!</div>');
		          redirect('admin/login/forgotpassword');
			 	}
			}
  		}
	  $this->load->view('admin/login/forgotpassword', $data);
   	}
   
	
	// set empty default form field values
	function _set_fields()
	{
		$this->form_data = new stdClass;
		$this->form_data->admin_email = '';
		$this->form_data->admin_password = '';
	}
	
	// validation rules
	function _set_rules()
	{
		$this->form_validation->set_rules('admin_email', 'Username', 'trim|valid_email|required');
		$this->form_validation->set_rules('admin_password', 'Password', 'trim|required');
		
		$this->form_validation->set_message('required', '* required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}


	function _set_forgotpwd_fields()
	{
		$this->form_data = new stdClass;
		$this->form_data->admin_email = '';
	}
	
	// validation rules
	function _set_forgotpwd_rules()
	{
		$this->form_validation->set_rules('admin_email', 'Username', 'trim|valid_email|required');
		
		$this->form_validation->set_message('required', '* required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
}
