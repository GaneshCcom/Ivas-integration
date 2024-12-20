<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalog extends CI_Controller {
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
			$data['title'] = 'Catalogs';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$catalogLists = $this->admin_model->get_catalogs()->result();
			$data['catalogLists'] = $catalogLists;


			$this->load->view('admin/catalog/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Catalog';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/catalog/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$this->_set_catalog_rules();
			$this->_set_catalog_fields();

			if(isset($_REQUEST['addcatalog']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$catalog_pdf_file	 = $_FILES['catalog_pdf_file']['name'];
						if($catalog_pdf_file != '')
						{
							$config['upload_path'] = './assets/catalog/';
							$config['allowed_types'] = 'pdf';
							$this->load->library('upload', $config);
							$catalog_pdf_file = "catalog_pdf_file";
							if (!$this->upload->do_upload($catalog_pdf_file))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$pdf_file_data = array('upload_data' => $this->upload->data());
								$cataloginfo = array( 
											'catalog_title' => $this->input->post('catalog_title'),
											'catalog_sub_title' => $this->input->post('catalog_sub_title'),
											'catalog_pdf_file' => $pdf_file_data['upload_data']['file_name'],
											'cat_id' => $this->input->post('cat_id'),
											'catalog_status' => $this->input->post('catalog_status'),
											'catalog_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addcatalog = $this->admin_model->add_catalog($cataloginfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Catalog Added successfully.</p>');
								redirect('admin/catalog');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$cataloginfo = array( 
										'catalog_title' => $this->input->post('catalog_title'),
										'catalog_sub_title' => $this->input->post('catalog_sub_title'),
										'cat_id' => $this->input->post('cat_id'),
										'catalog_status' => $this->input->post('catalog_status'),
										'catalog_created' => date('Y-m-d H:i:s', strtotime($current)),
									);
										
							
							$addcatalog = $this->admin_model->add_catalog($cataloginfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Catalog Added successfully.</p>');
							redirect('admin/catalog');
						}	
				}
			}	

			$this->load->view('admin/catalog/add', $data);
		}

		public function edit()
		{
			$catalogId = $_GET['catalog'];
			$hexaId = hex2bin($catalogId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Catalog';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/catalog/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$catalogInfo = $this->admin_model->get_catalog_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->catalog_title = $catalogInfo->catalog_title;
			$this->form_data->catalog_sub_title = $catalogInfo->catalog_sub_title;
			$this->form_data->catalog_pdf_file = $catalogInfo->catalog_pdf_file;
			$this->form_data->cat_id = $catalogInfo->cat_id;
			$this->form_data->catalog_status = $catalogInfo->catalog_status;

			$this->_set_catalog_rules();

			if(isset($_REQUEST['editcatalog']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$catalog_pdf_file	 = $_FILES['catalog_pdf_file']['name'];
					if($catalog_pdf_file != '')
					{
							$config['upload_path'] = './assets/catalog/';
							$config['allowed_types'] = 'pdf';
							$this->load->library('upload', $config);
							$catalog_pdf_file = "catalog_pdf_file";
							if (!$this->upload->do_upload($catalog_pdf_file))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$pdf_file_data = array('upload_data' => $this->upload->data());
								$cataloginfo = array( 
											'catalog_title' => $this->input->post('catalog_title'),
											'catalog_sub_title' => $this->input->post('catalog_sub_title'),
											'catalog_pdf_file' => $pdf_file_data['upload_data']['file_name'],
											'cat_id' => $this->input->post('cat_id'),
											'catalog_status' => $this->input->post('catalog_status'),
											'catalog_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editcatalog = $this->admin_model->edit_catalog($cataloginfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Catalog updated successfully.</p>');
								redirect('admin/catalog');
							}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$cataloginfo = array( 
									'catalog_title' => $this->input->post('catalog_title'),
									'catalog_sub_title' => $this->input->post('catalog_sub_title'),
									'cat_id' => $this->input->post('cat_id'),
									'catalog_status' => $this->input->post('catalog_status'),
									'catalog_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						$editcatalog = $this->admin_model->edit_catalog($cataloginfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Catalog updated successfully.</p>');
						redirect('admin/catalog');
					}	
				}
			}
				

			$this->load->view('admin/catalog/edit', $data);
		}

		public function deletecatalog($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Catalog';
			$cataloginfo = array( 
									'catalog_deleted' => '1',
								);
			$id = $this->admin_model->delete_catalog($cataloginfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Catalog Deleted Successfully.</div>');
			redirect('admin/catalog');
		}

		function _set_catalog_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->catalog_title = '';

			$this->form_data->catalog_sub_title = '';

			$this->form_data->catalog_pdf_file = '';

			$this->form_data->cat_id = '';

			$this->form_data->catalog_status = '';

		}	

	

		function _set_catalog_rules(){

			$this->form_validation->set_rules('catalog_title', 'Catalog Title', 'trim|required');
			$this->form_validation->set_rules('catalog_sub_title', 'Catalog Sub Title', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Catalog Category', 'trim|required');
			$this->form_validation->set_rules('catalog_status', 'Catalog Satus',  'trim|required');

		}
}
?>	