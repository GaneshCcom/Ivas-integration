<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
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

	public function index()
	{
		$this->admin_model->isset_admin_user();
		$data['title'] = 'Admin Profile';
		$data['desc'] = '';
		$data['loggedin'] = '';
		$data['action'] = site_url('admin/profile');
		$data['typeback'] = '';
		$adminData = $this->session->userdata('adminSession');
		$adminId = $adminData['admin_id'];
		$adminInfo = $this->admin_model->get_adminInfo($adminId)->row();
		$data['adminInfo'] = $adminInfo;
		
		$this->_set_fields();
		// set validation properties
		$this->_set_rules();
		
		if(isset($_REQUEST['btnSubmit']))
		{
			if ($this->form_validation->run() == FALSE)
			{

				  	$data['message'] = '';
			
			}else
			{
				$new_pwd= md5($this->input->post('new_password'));
				$old_pass = md5($this->input->post('current_password'));			
				
				if ($this->admin_model->chk_admin_pwd($adminId, $old_pass))
				{
						
						if ($this->admin_model->change_admin_pwd($adminId, $new_pwd))
						{
							
							$this->session->sess_destroy();
							$adminSession = array('admin_id' => '', 'admin_name' => '', 'admin_email' => '',  'admin_lastlogin' => '', 'loggedin' => false);
							$this->session->set_userdata('adminSession', $adminSession);
							$this->session->set_flashdata('message','<p class="alert alert-primary text-center"> You are Successfully Change Password!  </p>');
							redirect('admin/login');
						}
						else
						{
							// error
							$this->session->set_flashdata('message','<p class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</p>');
						}
				}
				else
				{
					// error
					$this->session->set_flashdata('message','<p class="alert alert-danger text-center">Oops! Error.  Please Enter Valid Old Password!!!</p>');

				}
				
			}	
			
		
		}

		$this->load->view('admin/profile/index', $data);
	}

	public function edit()
	{
		$this->admin_model->isset_admin_user();
		$data['title'] = 'Edit Admin Profile';
		$data['desc'] = '';
		$data['loggedin'] = '';
		$data['action'] = site_url('admin/profile/edit');
		$data['typeback'] = '';
		$adminData = $this->session->userdata('adminSession');
		$adminId = $adminData['admin_id'];
		$adminInfo = $this->admin_model->get_adminInfo($adminId)->row();
		$data['adminInfo'] = $adminInfo;

		$this->form_data = new stdClass;
		$this->form_data->admin_first_name = $adminInfo->admin_first_name;
		$this->form_data->admin_last_name = $adminInfo->admin_last_name;
		$this->form_data->admin_email = $adminInfo->admin_email;
		//$this->form_data->admin_gender = $adminInfo->admin_gender;
		$this->form_data->admin_phone = $adminInfo->admin_phone;
		$this->form_data->admin_alt_phone = $adminInfo->admin_alt_phone;
		$this->form_data->admin_photo = $adminInfo->admin_photo;

		$this->_set_admin_rules();

		if(isset($_REQUEST['editprofile']))
		{
			if ($this->form_validation->run() == FALSE)
			{
				  	$data['message'] = '';
			}
			else
			{
				$profileImage = $_FILES['admin_photo']['name'];
				if($profileImage != '')
				{
					$config['upload_path'] = './assets/admin-profile/';
					$config['allowed_types'] = 'jpg|png';
					$config['max_size']	= 110;
					$this->load->library('upload', $config);
			
					$profileImage = "admin_photo";
					if (!$this->upload->do_upload($profileImage))
					{
						$error = array('error' => $this->upload->display_errors());
						//$this->load->view('upload_form', $error);
						//print_r($error);
						$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
					}
					else
					{
						$current = date('Y-m-d H:i:s');
						$admin_image_data = array('upload_data' => $this->upload->data());
						$adminInfo =  array( 
									'admin_first_name' =>  $this->input->post('admin_first_name'),
									'admin_photo' => $admin_image_data['upload_data']['file_name'],
									'admin_last_name' =>  $this->input->post('admin_last_name'),
									//'admin_gender'  =>  $this->input->post('admin_gender'),
									'admin_phone'  =>  $this->input->post('admin_phone'),
									'admin_alt_phone'  =>  $this->input->post('admin_alt_phone'),
									'admin_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
						$this->admin_model->edit_adminInfo($adminInfo, $adminId);
						$this->session->set_flashdata('message','<div id="alert" class="alert alert-primary text-center">Profile updated Successfully.</div>');
						redirect('admin/profile');
					}
				}
				else
				{	
					$current = date('Y-m-d H:i:s');
					$adminInfo =  array( 
								'admin_first_name' =>  $this->input->post('admin_first_name'),
								'admin_last_name' =>  $this->input->post('admin_last_name'),
								//'admin_gender'  =>  $this->input->post('admin_gender'),
								'admin_phone'  =>  $this->input->post('admin_phone'),
								'admin_alt_phone'  =>  $this->input->post('admin_alt_phone'),
								'admin_updated' => date('Y-m-d H:i:s', strtotime($current)),
							);
					$this->admin_model->edit_adminInfo($adminInfo, $adminId);
					$this->session->set_flashdata('message','<div id="alert" class="alert alert-primary text-center">Profile updated Successfully.</div>');
					redirect('admin/profile');
				}		
			}
		}
		
		$this->load->view('admin/profile/edit', $data);
	}
	

	function _set_fields()
	{
		$this->form_data = new stdClass;
		$this->form_data->current_password = '';
		$this->form_data->new_password = '';
		$this->form_data->password_confirmation = '';
	}
	
	// validation rules
	function _set_rules()
	{
		$this->form_validation->set_rules('current_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[18]');
		$this->form_validation->set_rules('password_confirmation', 'Confirm New Password', 'required|matches[new_password]');
		//$this->form_validation->set_rules('documentpicture', 'Document Image', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
	}

	// validation rules
	function _set_admin_rules()
	{
		$this->form_validation->set_rules('admin_first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('admin_last_name', 'Last Name', 'trim|required');
		//$this->form_validation->set_rules('admin_gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('admin_phone', 'Phone', 'trim|required|numeric|min_length[10]|max_length[10]');
		$this->form_validation->set_rules('admin_alt_phone', 'Alternate Phone', 'trim|required|numeric|min_length[10]|max_length[10]');
		//$this->form_validation->set_rules('admin_photo', 'Photo', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="alert alert-danger">', '</p>');
	}
}
?>