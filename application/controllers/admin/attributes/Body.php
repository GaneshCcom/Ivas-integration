<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Body extends CI_Controller {
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
			$data['title'] = 'Body';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$bodyLists = $this->admin_model->get_all_bodys()->result();
			$data['bodyLists'] = $bodyLists;


			$this->load->view('admin/attributes/body/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Body';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/body/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_body_rules();
			$this->_set_body_fields();

			if(isset($_REQUEST['addbody']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$bodyinfo = array( 
									'body_name' => $this->input->post('body_name'),
									'body_status' => $this->input->post('body_status'),
									'body_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addbody = $this->admin_model->add_body($bodyinfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Body Added successfully.</p>');
						redirect('admin/attributes/body');
				}	
			}
			$this->load->view('admin/attributes/body/add', $data);
		}
		public function edit()
		{
			$bodyId = $_GET['body'];
			$hexaId = hex2bin($bodyId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Body';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/body/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$bodyInfo = $this->admin_model->get_body_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->body_name = $bodyInfo->body_name;
			$this->form_data->body_status = $bodyInfo->body_status;

			$this->_set_body_rules();
			if(isset($_REQUEST['editbody']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$bodyinfo = array( 
											'body_name' => $this->input->post('body_name'),
											'body_status' => $this->input->post('body_status'),
											'body_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editbody = $this->admin_model->edit_body($bodyinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Body updated successfully.</p>');
						redirect('admin/attributes/body');
				}
			}	

			$this->load->view('admin/attributes/body/edit', $data);
		}
		public function deletebody($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Body';
			$bodyinfo = array( 
									'body_deleted' => '1',
								);
			$id = $this->admin_model->delete_body($bodyinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Body Deleted Successfully.</div>');
			redirect('admin/attributes/body');
		}

		function _set_body_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->body_name = '';

			$this->form_data->body_status = '';

		}	

	
		function _set_body_rules(){

			$this->form_validation->set_rules('body_name', 'Body', 'trim|required');
			$this->form_validation->set_rules('body_status', 'Body Satus',  'trim|required');

		}
}