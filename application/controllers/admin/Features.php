<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Features extends CI_Controller {
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
			$data['title'] = 'Product Features';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$featureLists = $this->admin_model->get_all_features()->result();
			$data['featureLists'] = $featureLists;


			$this->load->view('admin/features/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Feature';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/features/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_feature_rules();
			$this->_set_feature_fields();

			if(isset($_REQUEST['addfeature']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$feat_img	 = $_FILES['feat_img']['name'];
						if($feat_img != '')
						{
							$config['upload_path'] = './assets/feature-icons/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 150;
							$this->load->library('upload', $config);
							$feat_img = "feat_img";
							if (!$this->upload->do_upload($feat_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$feat_img_data = array('upload_data' => $this->upload->data());
								$featureinfo = array( 
											'feat_name' => $this->input->post('feat_name'),
											'feat_img' => $feat_img_data['upload_data']['file_name'],
											'feat_status' => $this->input->post('feat_status'),
											'feat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addfeature = $this->admin_model->add_feature($featureinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Feature Added successfully.</p>');
								redirect('admin/features');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$featureinfo = array( 
											'feat_name' => $this->input->post('feat_name'),
											'feat_status' => $this->input->post('feat_status'),
											'feat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
							$addfeature = $this->admin_model->add_feature($featureinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Feature Added successfully.</p>');
							redirect('admin/features');
						}	
				}
			}	

			$this->load->view('admin/features/add', $data);
		}

		public function edit()
		{
			$featureId = $_GET['feature'];
			$hexaId = hex2bin($featureId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Feature';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/features/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$featureInfo = $this->admin_model->get_feature_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->feat_name = $featureInfo->feat_name;
			$this->form_data->feat_img = $featureInfo->feat_img;
			$this->form_data->feat_status = $featureInfo->feat_status;

			$this->_set_feature_rules();

			if(isset($_REQUEST['editfeature']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$feat_img	 = $_FILES['feat_img']['name'];
					if($feat_img != '')
					{
							$config['upload_path'] = './assets/feature-icons/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 150;
							$this->load->library('upload', $config);
							$feat_img = "feat_img";
							if (!$this->upload->do_upload($feat_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$feat_img_data = array('upload_data' => $this->upload->data());
								$featureinfo = array( 
											'feat_name' => $this->input->post('feat_name'),
											'feat_img' => $feat_img_data['upload_data']['file_name'],
											'feat_status' => $this->input->post('feat_status'),
											'feat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editfeature = $this->admin_model->edit_feature($featureinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Feature updated successfully.</p>');
								redirect('admin/features');
							}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$featureinfo = array( 
											'feat_name' => $this->input->post('feat_name'),
											'feat_status' => $this->input->post('feat_status'),
											'feat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
						$editfeature = $this->admin_model->edit_feature($featureinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Feature updated successfully.</p>');
						redirect('admin/features');
					}	
				}
			}
				

			$this->load->view('admin/features/edit', $data);
		}

		public function deletefeature($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Feature';
			$featureinfo = array( 
									'feat_deleted' => '1',
								);
			$id = $this->admin_model->delete_feature($featureinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Feature Deleted Successfully.</div>');
			redirect('admin/features');
		}

		function _set_feature_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->feat_name = '';

			$this->form_data->feat_img = '';

			$this->form_data->feat_status = '';

		}	

	
		function _set_feature_rules(){

			$this->form_validation->set_rules('feat_name', 'Feature Name', 'trim|required');
			$this->form_validation->set_rules('feat_status', 'Feature Satus',  'trim|required');

		}
}	
?>		