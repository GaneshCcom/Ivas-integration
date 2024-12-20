<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finish extends CI_Controller {
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
			$data['title'] = 'Finish';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$finishLists = $this->admin_model->get_all_finishs()->result();
			$data['finishLists'] = $finishLists;


			$this->load->view('admin/attributes/finish/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Finish';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/finish/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_finish_rules();
			$this->_set_finish_fields();

			if(isset($_REQUEST['addfinish']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$finishinfo = array( 
									'finish' => $this->input->post('finish'),
									'fin_status' => $this->input->post('fin_status'),
									'fin_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addfinish = $this->admin_model->add_finish($finishinfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Finish Added successfully.</p>');
						redirect('admin/attributes/finish');
				}	
			}
			$this->load->view('admin/attributes/finish/add', $data);
		}
		public function edit()
		{
			$finishId = $_GET['finish'];
			$hexaId = hex2bin($finishId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Finish';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/finish/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$finishInfo = $this->admin_model->get_finish_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->finish = $finishInfo->finish;
			$this->form_data->fin_status = $finishInfo->fin_status;

			$this->_set_finish_rules();
			if(isset($_REQUEST['editfinish']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$finishinfo = array( 
											'finish' => $this->input->post('finish'),
											'fin_status' => $this->input->post('fin_status'),
											'fin_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editfinish = $this->admin_model->edit_finish($finishinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Finish updated successfully.</p>');
						redirect('admin/attributes/finish');
				}
			}	

			$this->load->view('admin/attributes/finish/edit', $data);
		}
		public function deletefinish($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Finish';
			$finishinfo = array( 
									'fin_deleted' => '1',
								);
			$id = $this->admin_model->delete_finish($finishinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Finish Deleted Successfully.</div>');
			redirect('admin/attributes/finish');
		}

		function _set_finish_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->finish = '';

			$this->form_data->fin_status = '';

		}	

	
		function _set_finish_rules(){

			$this->form_validation->set_rules('finish', 'Finish', 'trim|required');
			$this->form_validation->set_rules('fin_status', 'Finish Satus',  'trim|required');

		}
}