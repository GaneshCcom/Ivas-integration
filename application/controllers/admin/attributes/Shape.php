<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shape extends CI_Controller {
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
			$data['title'] = 'Shape';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$shapeLists = $this->admin_model->get_all_shapes()->result();
			$data['shapeLists'] = $shapeLists;


			$this->load->view('admin/attributes/shape/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Shape';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/shape/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_shape_rules();
			$this->_set_shape_fields();

			if(isset($_REQUEST['addshape']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$shapeinfo = array( 
									'shape_name' => $this->input->post('shape_name'),
									'shape_status' => $this->input->post('shape_status'),
									'shape_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addshape = $this->admin_model->add_shape($shapeinfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Shape Added successfully.</p>');
						redirect('admin/attributes/shape');
				}	
			}
			$this->load->view('admin/attributes/shape/add', $data);
		}
		public function edit()
		{
			$shapeId = $_GET['shape'];
			$hexaId = hex2bin($shapeId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Shape';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/shape/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$shapeInfo = $this->admin_model->get_shape_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->shape_name = $shapeInfo->shape_name;
			$this->form_data->shape_status = $shapeInfo->shape_status;

			$this->_set_shape_rules();
			if(isset($_REQUEST['editshape']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$shapeinfo = array( 
											'shape_name' => $this->input->post('shape_name'),
											'shape_status' => $this->input->post('shape_status'),
											'shape_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editshape = $this->admin_model->edit_shape($shapeinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Shape updated successfully.</p>');
						redirect('admin/attributes/shape');
				}
			}	

			$this->load->view('admin/attributes/shape/edit', $data);
		}
		public function deleteshape($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Shape';
			$shapeinfo = array( 
									'shape_deleted' => '1',
								);
			$id = $this->admin_model->delete_shape($shapeinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Shape Deleted Successfully.</div>');
			redirect('admin/attributes/shape');
		}

		function _set_shape_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->shape_name = '';

			$this->form_data->shape_status = '';

		}	

	
		function _set_shape_rules(){

			$this->form_validation->set_rules('shape_name', 'Shape', 'trim|required');
			$this->form_validation->set_rules('shape_status', 'Shape Satus',  'trim|required');

		}
}