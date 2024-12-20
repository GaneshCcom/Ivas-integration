<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testimonials extends CI_Controller {
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
			$data['title'] = 'Testimonials';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$testimonialLists = $this->admin_model->get_testis()->result();
			$data['testimonialLists'] = $testimonialLists;


			$this->load->view('admin/testimonials/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Testimonials';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/testimonials/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$this->_set_testi_rules();
			$this->_set_testi_fields();

			if(isset($_REQUEST['addtesti']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$testi_client_img	 = $_FILES['testi_client_img']['name'];
						if($testi_client_img != '')
						{
							$config['upload_path'] = './assets/testi-clients/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 110;
							$this->load->library('upload', $config);
							$testi_client_img = "testi_client_img";
							if (!$this->upload->do_upload($testi_client_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$client_img_data = array('upload_data' => $this->upload->data());
								$testiinfo = array( 
											'testimonial' => $this->input->post('testimonial'),
											'testi_client' => $this->input->post('testi_client'),
											'testi_client_img' => $client_img_data['upload_data']['file_name'],
											'cat_id' => $this->input->post('cat_id'),
											'testi_status' => $this->input->post('testi_status'),
											'testi_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addtesti = $this->admin_model->add_testi($testiinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Testimonial Added successfully.</p>');
								redirect('admin/testimonials');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$testiinfo = array( 
										'testimonial' => $this->input->post('testimonial'),
										'testi_client' => $this->input->post('testi_client'),
										'cat_id' => $this->input->post('cat_id'),
										'testi_status' => $this->input->post('testi_status'),
										'testi_created' => date('Y-m-d H:i:s', strtotime($current)),
									);
										
							
							$addtesti = $this->admin_model->add_testi($testiinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Testimonial Added successfully.</p>');
							redirect('admin/testimonials');
						}	
				}
			}	

			$this->load->view('admin/testimonials/add', $data);
		}

		public function edit()
		{
			$testiId = $_GET['testi'];
			$hexaId = hex2bin($testiId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Testimonial';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/testimonials/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$testiInfo = $this->admin_model->get_testi_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->testimonial = $testiInfo->testimonial;
			$this->form_data->testi_client = $testiInfo->testi_client;
			$this->form_data->testi_client_img = $testiInfo->testi_client_img;
			$this->form_data->cat_id = $testiInfo->cat_id;
			$this->form_data->testi_status = $testiInfo->testi_status;

			$this->_set_testi_rules();

			if(isset($_REQUEST['edittesti']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$testi_client_img	 = $_FILES['testi_client_img']['name'];
					if($testi_client_img != '')
					{
							$config['upload_path'] = './assets/testi-clients/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 110;
							$this->load->library('upload', $config);
							$testi_client_img = "testi_client_img";
							if (!$this->upload->do_upload($testi_client_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$client_img_data = array('upload_data' => $this->upload->data());
								$testiinfo = array( 
											'testimonial' => $this->input->post('testimonial'),
											'testi_client' => $this->input->post('testi_client'),
											'testi_client_img' => $client_img_data['upload_data']['file_name'],
											'cat_id' => $this->input->post('cat_id'),
											'testi_status' => $this->input->post('testi_status'),
											'testi_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$edittesti = $this->admin_model->edit_testi($testiinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Testimonial updated successfully.</p>');
								redirect('admin/testimonials');
							}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$testiinfo = array( 
									'testimonial' => $this->input->post('testimonial'),
									'testi_client' => $this->input->post('testi_client'),
									'cat_id' => $this->input->post('cat_id'),
									'testi_status' => $this->input->post('testi_status'),
									'testi_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						$edittesti = $this->admin_model->edit_testi($testiinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Testimonial updated successfully.</p>');
						redirect('admin/testimonials');
					}	
				}
			}
				

			$this->load->view('admin/testimonials/edit', $data);
		}

		public function deletetesti($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Testimonial';
			$testiinfo = array( 
									'testi_deleted' => '1',
								);
			$id = $this->admin_model->delete_testi($testiinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Testimonial Deleted Successfully.</div>');
			redirect('admin/testimonials');
		}

		public function import()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Import Testimonials';
			$data['action'] = site_url('admin/testimonials/import_process');

			$this->load->view('admin/testimonials/import', $data);
		}

		public function import_process()
		{
			$this->admin_model->isset_admin_user();

			if(isset($_FILES['testimonials_file']) && !empty($_FILES['testimonials_file']['name'])) {

				$file = $_FILES['testimonials_file']['tmp_name'];
				$spreadsheet = IOFactory::load($file);
				$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

				foreach ($sheetData as $row) {
					if (!empty($row['A']) && !empty($row['B']) && !empty($row['C']) && !empty($row['D'])) {
						$testiinfo = array(
							'testimonial' => $row['A'],
							'testi_client' => $row['B'],
							'testi_client_img' => $row['C'],
							'cat_id' => $row['D'],
							'testi_status' => $row['E'],
							'testi_created' => date('Y-m-d H:i:s')
						);

						$this->admin_model->add_testi($testiinfo);
					}
				}

				$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Testimonials imported successfully.</p>');
				redirect('admin/testimonials');
			} else {
				$this->session->set_flashdata('message', '<p class="alert alert-danger text-center">Please upload a valid file.</p>');
				redirect('admin/testimonials/import');
			}
		}

		function _set_testi_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->testimonial = '';

			$this->form_data->testi_client = '';

			$this->form_data->testi_client_img = '';

			$this->form_data->cat_id = '';

			$this->form_data->testi_status = '';

		}	

	

		function _set_testi_rules(){

			$this->form_validation->set_rules('testimonial', 'Testimonial', 'trim|required');
			$this->form_validation->set_rules('testi_client', 'Testimonial Client', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Testimonial Category', 'trim|required');
			$this->form_validation->set_rules('testi_status', 'Testimonial Satus',  'trim|required');

		}
}	
?>