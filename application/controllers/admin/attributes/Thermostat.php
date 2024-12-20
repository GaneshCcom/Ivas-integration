<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thermostat extends CI_Controller {
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
			$data['title'] = 'Thermostat Type';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$thermLists = $this->admin_model->get_all_therms()->result();
			$data['thermLists'] = $thermLists;


			$this->load->view('admin/attributes/thermostat/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Thermostat Type';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/thermostat/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_therm_rules();
			$this->_set_therm_fields();

			if(isset($_REQUEST['addtherm']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$therminfo = array( 
									'ther_type' => $this->input->post('ther_type'),
									'ther_type_status' => $this->input->post('ther_type_status'),
									'ther_type_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addtherm = $this->admin_model->add_therm($therminfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Thermostat Type Added successfully.</p>');
						redirect('admin/attributes/thermostat');
				}	
			}
			$this->load->view('admin/attributes/thermostat/add', $data);
		}
		public function edit()
		{
			$thermId = $_GET['therm'];
			$hexaId = hex2bin($thermId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Thermostat Type';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/thermostat/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$thermInfo = $this->admin_model->get_therm_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->ther_type = $thermInfo->ther_type;
			$this->form_data->ther_type_status = $thermInfo->ther_type_status;

			$this->_set_therm_rules();
			if(isset($_REQUEST['edittherm']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$therminfo = array( 
											'ther_type' => $this->input->post('ther_type'),
											'ther_type_status' => $this->input->post('ther_type_status'),
											'ther_type_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$edittherm = $this->admin_model->edit_therm($therminfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Thermostat Type updated successfully.</p>');
						redirect('admin/attributes/thermostat');
				}
			}	

			$this->load->view('admin/attributes/thermostat/edit', $data);
		}
		public function deletetherm($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Thermostat Type';
			$therminfo = array( 
									'ther_type_deleted' => '1',
								);
			$id = $this->admin_model->delete_therm($therminfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Thermostat Type Deleted Successfully.</div>');
			redirect('admin/attributes/thermostat');
		}

		function _set_therm_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->ther_type = '';

			$this->form_data->ther_type_status = '';

		}	

	
		function _set_therm_rules(){

			$this->form_validation->set_rules('ther_type', 'Thermostat Type', 'trim|required');
			$this->form_validation->set_rules('ther_type_status', 'Thermostat Type Satus',  'trim|required');

		}
}