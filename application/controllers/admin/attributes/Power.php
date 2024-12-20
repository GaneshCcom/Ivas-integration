<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Power extends CI_Controller {
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
			$data['title'] = 'Power Input';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$powerLists = $this->admin_model->get_all_powers()->result();
			$data['powerLists'] = $powerLists;


			$this->load->view('admin/attributes/power/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Power Input';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/power/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_power_rules();
			$this->_set_power_fields();

			if(isset($_REQUEST['addpower']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$powerinfo = array( 
									'pi_power_input' => $this->input->post('pi_power_input'),
									'pi_status' => $this->input->post('pi_status'),
									'pi_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addpower = $this->admin_model->add_power($powerinfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Power Input Added successfully.</p>');
						redirect('admin/attributes/power');
				}	
			}
			$this->load->view('admin/attributes/power/add', $data);
		}
		public function edit()
		{
			$powerId = $_GET['power'];
			$hexaId = hex2bin($powerId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Power Input';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/power/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$powerInfo = $this->admin_model->get_power_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->pi_power_input = $powerInfo->pi_power_input;
			$this->form_data->pi_status = $powerInfo->pi_status;

			$this->_set_power_rules();
			if(isset($_REQUEST['editpower']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$powerinfo = array( 
											'pi_power_input' => $this->input->post('pi_power_input'),
											'pi_status' => $this->input->post('pi_status'),
											'pi_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editpower = $this->admin_model->edit_power($powerinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Power Input updated successfully.</p>');
						redirect('admin/attributes/power');
				}
			}	

			$this->load->view('admin/attributes/power/edit', $data);
		}
		public function deletepower($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Power Input';
			$powerinfo = array( 
									'pi_deleted' => '1',
								);
			$id = $this->admin_model->delete_power($powerinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Power Input Deleted Successfully.</div>');
			redirect('admin/attributes/power');
		}

		function _set_power_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->pi_power_input = '';

			$this->form_data->pi_status = '';

		}	

	
		function _set_power_rules(){

			$this->form_validation->set_rules('pi_power_input', 'Power Input', 'trim|required');
			$this->form_validation->set_rules('pi_status', 'Power Input Satus',  'trim|required');

		}
}