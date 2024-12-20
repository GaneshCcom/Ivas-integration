<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Color extends CI_Controller {
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
			$data['title'] = 'Color';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$colorLists = $this->admin_model->get_all_colors()->result();
			$data['colorLists'] = $colorLists;


			$this->load->view('admin/attributes/color/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Color';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/color/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_color_rules();
			$this->_set_color_fields();

			if(isset($_REQUEST['addcolor']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$colorinfo = array( 
									'color_name' => $this->input->post('color_name'),
									'color_code' => $this->input->post('color_code'),
									'color_status' => $this->input->post('color_status'),
									'color_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addcolor = $this->admin_model->add_color($colorinfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Color Added successfully.</p>');
						redirect('admin/attributes/color');
				}	
			}
			$this->load->view('admin/attributes/color/add', $data);
		}
		public function edit()
		{
			$colorId = $_GET['color'];
			$hexaId = hex2bin($colorId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Color';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/color/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$colorInfo = $this->admin_model->get_color_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->color_name = $colorInfo->color_name;
			$this->form_data->color_code = $colorInfo->color_code;
			$this->form_data->color_status = $colorInfo->color_status;

			$this->_set_color_rules();
			if(isset($_REQUEST['editcolor']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$colorinfo = array( 
											'color_name' => $this->input->post('color_name'),
											'color_code' => $this->input->post('color_code'),
											'color_status' => $this->input->post('color_status'),
											'color_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editcolor = $this->admin_model->edit_color($colorinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Color updated successfully.</p>');
						redirect('admin/attributes/color');
				}
			}	

			$this->load->view('admin/attributes/color/edit', $data);
		}
		public function deletecolor($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Color';
			$colorinfo = array( 
									'color_deleted' => '1',
								);
			$id = $this->admin_model->delete_color($colorinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Color Deleted Successfully.</divc>');
			redirect('admin/attributes/color');
		}

		function _set_color_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->color_name = '';

			$this->form_data->color_code = '';

			$this->form_data->color_status = '';

		}	

	
		function _set_color_rules(){

			$this->form_validation->set_rules('color_name', 'Color', 'trim|required');
			$this->form_validation->set_rules('color_code', 'Color Code', 'trim|required');
			$this->form_validation->set_rules('color_status', 'Color Satus',  'trim|required');

		}
}