<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warranty extends CI_Controller {
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
			$data['title'] = 'Warranty';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$wrtyLists = $this->admin_model->get_all_wrtys()->result();
			$data['wrtyLists'] = $wrtyLists;


			$this->load->view('admin/attributes/warranty/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Warranty';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/warranty/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_wrty_rules();
			$this->_set_wrty_fields();

			if(isset($_REQUEST['addwrty']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$wrtyinfo = array( 
									'wrty_name' => $this->input->post('wrty_name'),
									'wrty_status' => $this->input->post('wrty_status'),
									'wrty_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addwrty = $this->admin_model->add_wrty($wrtyinfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Warranty Added successfully.</p>');
						redirect('admin/attributes/warranty');
				}	
			}
			$this->load->view('admin/attributes/warranty/add', $data);
		}
		public function edit()
		{
			$wrtyId = $_GET['wrty'];
			$hexaId = hex2bin($wrtyId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Warranty';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/warranty/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$wrtyInfo = $this->admin_model->get_wrty_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->wrty_name = $wrtyInfo->wrty_name;
			$this->form_data->wrty_status = $wrtyInfo->wrty_status;

			$this->_set_wrty_rules();
			if(isset($_REQUEST['editwrty']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$wrtyinfo = array( 
											'wrty_name' => $this->input->post('wrty_name'),
											'wrty_status' => $this->input->post('wrty_status'),
											'wrty_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editwrty = $this->admin_model->edit_wrty($wrtyinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Warranty updated successfully.</p>');
						redirect('admin/attributes/warranty');
				}
			}	

			$this->load->view('admin/attributes/warranty/edit', $data);
		}
		public function deletewrty($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Warranty';
			$wrtyinfo = array( 
									'wrty_deleted' => '1',
								);
			$id = $this->admin_model->delete_wrty($wrtyinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Warranty Deleted Successfully.</div>');
			redirect('admin/attributes/warranty');
		}

		function _set_wrty_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->wrty_name = '';

			$this->form_data->wrty_status = '';

		}	

	
		function _set_wrty_rules(){

			$this->form_validation->set_rules('wrty_name', 'Warranty', 'trim|required');
			$this->form_validation->set_rules('wrty_status', 'Warranty Satus',  'trim|required');

		}
}