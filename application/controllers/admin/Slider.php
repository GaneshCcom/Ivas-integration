<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends CI_Controller {
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
			$data['title'] = 'Slider';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$slideLists = $this->admin_model->get_all_slides()->result();
			$data['slideLists'] = $slideLists;


			$this->load->view('admin/slider/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Slide';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/slider/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_slide_rules();
			$this->_set_slide_fields();

			if(isset($_REQUEST['addslide']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$slide_back_img	 = $_FILES['slide_back_img']['name'];
						$slide_mobile_back_img = $_FILES['slide_mobile_back_img']['name'];
						if($slide_back_img != '' && $slide_mobile_back_img != '')
						{
							$config['upload_path'] = './assets/slider/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$slide_back_img = "slide_back_img";
							if (!$this->upload->do_upload($slide_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/slider/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$slide_mobile_back_img = "slide_mobile_back_img";
							if (!$this->upload->do_upload($slide_mobile_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$mobile_back_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');								
								$slideinfo = array( 
											'slide_sub_title' => $this->input->post('slide_sub_title'),
											'slide_title' => $this->input->post('slide_title'),
											'slide_desc' => $this->input->post('slide_desc'),
											'slide_back_img' => $back_img_data['upload_data']['file_name'],
											'slide_mobile_back_img' => $mobile_back_img_data['upload_data']['file_name'],
											'slide_link' => $this->input->post('slide_link'),
											'slide_class' => $this->input->post('slide_class'),
											'slide_status' => $this->input->post('slide_status'),
											'slide_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addslide = $this->admin_model->add_slide($slideinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Slide Added successfully.</p>');
								redirect('admin/slider');	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$slideinfo = array( 
											'slide_sub_title' => $this->input->post('slide_sub_title'),
											'slide_title' => $this->input->post('slide_title'),
											'slide_desc' => $this->input->post('slide_desc'),
											'slide_link' => $this->input->post('slide_link'),
											'slide_class' => $this->input->post('slide_class'),
											'slide_status' => $this->input->post('slide_status'),
											'slide_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
										
							
							$addslide = $this->admin_model->add_slide($slideinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Slide Added successfully.</p>');
							redirect('admin/slider');
						}	
				}
			}	

			$this->load->view('admin/slider/add', $data);
		}

		public function edit()
		{
			$slideId = $_GET['slide'];
			$hexaId = hex2bin($slideId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Slide';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/slider/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$slideInfo = $this->admin_model->get_slide_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->slide_sub_title = $slideInfo->slide_sub_title;
			$this->form_data->slide_title = $slideInfo->slide_title;
			$this->form_data->slide_desc = $slideInfo->slide_desc;
			$this->form_data->slide_back_img = $slideInfo->slide_back_img;
			$this->form_data->slide_mobile_back_img = $slideInfo->slide_mobile_back_img;
			$this->form_data->slide_link = $slideInfo->slide_link;
			$this->form_data->slide_class = $slideInfo->slide_class;
			$this->form_data->slide_status = $slideInfo->slide_status;

			$this->_set_slide_rules();

			if(isset($_REQUEST['editslide']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$slide_back_img	 = $_FILES['slide_back_img']['name'];
					$slide_mobile_back_img = $_FILES['slide_mobile_back_img']['name'];
					if($slide_back_img != '' && $slide_mobile_back_img != '')
					{
							$config['upload_path'] = './assets/slider/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$slide_back_img = "slide_back_img";
							if (!$this->upload->do_upload($slide_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/slider/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$slide_mobile_back_img = "slide_mobile_back_img";
							if (!$this->upload->do_upload($slide_mobile_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$mobile_back_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$slideinfo = array( 
											'slide_sub_title' => $this->input->post('slide_sub_title'),
											'slide_title' => $this->input->post('slide_title'),
											'slide_desc' => $this->input->post('slide_desc'),
											'slide_back_img' => $back_img_data['upload_data']['file_name'],
											'slide_mobile_back_img' => $mobile_back_img_data['upload_data']['file_name'],
											'slide_link' => $this->input->post('slide_link'),
											'slide_class' => $this->input->post('slide_class'),
											'slide_status' => $this->input->post('slide_status'),
											'slide_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editslide = $this->admin_model->edit_slide($slideinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Slide updated successfully.</p>');
								redirect('admin/slider');

					}elseif ($slide_back_img != '' || $slide_mobile_back_img != '') {
						if($slide_back_img != '')
						{
							$config['upload_path'] = './assets/slider/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$slide_back_img = "slide_back_img";
							if (!$this->upload->do_upload($slide_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$back_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$slideinfo = array( 
											'slide_sub_title' => $this->input->post('slide_sub_title'),
											'slide_title' => $this->input->post('slide_title'),
											'slide_desc' => $this->input->post('slide_desc'),
											'slide_back_img' => $back_img_data['upload_data']['file_name'],
											'slide_link' => $this->input->post('slide_link'),
											'slide_class' => $this->input->post('slide_class'),
											'slide_status' => $this->input->post('slide_status'),
											'slide_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editslide = $this->admin_model->edit_slide($slideinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Slide updated successfully.</p>');
								redirect('admin/slider');
						}
						if($slide_mobile_back_img != '')
						{
							$config['upload_path'] = './assets/slider/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$slide_mobile_back_img = "slide_mobile_back_img";
							if (!$this->upload->do_upload($slide_mobile_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$mobile_back_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$slideinfo = array( 
											'slide_sub_title' => $this->input->post('slide_sub_title'),
											'slide_title' => $this->input->post('slide_title'),
											'slide_desc' => $this->input->post('slide_desc'),
											'slide_mobile_back_img' => $mobile_back_img_data['upload_data']['file_name'],
											'slide_link' => $this->input->post('slide_link'),
											'slide_class' => $this->input->post('slide_class'),
											'slide_status' => $this->input->post('slide_status'),
											'slide_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editslide = $this->admin_model->edit_slide($slideinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Slide updated successfully.</p>');
								redirect('admin/slider');
						}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$slideinfo = array( 
											'slide_sub_title' => $this->input->post('slide_sub_title'),
											'slide_title' => $this->input->post('slide_title'),
											'slide_desc' => $this->input->post('slide_desc'),
											'slide_link' => $this->input->post('slide_link'),
											'slide_class' => $this->input->post('slide_class'),
											'slide_status' => $this->input->post('slide_status'),
											'slide_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editslide = $this->admin_model->edit_slide($slideinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Slide updated successfully.</p>');
						redirect('admin/slider');
					}	
				}
			}
				

			$this->load->view('admin/slider/edit', $data);
		}

		public function deleteslide($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Slide';
			$slideinfo = array( 
									'slide_deleted' => '1',
								);
			$id = $this->admin_model->delete_slide($slideinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Slide Deleted Successfully.</div>');
			redirect('admin/slider');
		}

		function _set_slide_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->slide_sub_title = '';

			$this->form_data->slide_title = '';

			$this->form_data->slide_desc = '';

			$this->form_data->slide_back_img = '';

			$this->form_data->slide_mobile_back_img = '';

			$this->form_data->slide_link = '';

			$this->form_data->slide_class = '';

			$this->form_data->slide_status = '';

		}	

	
		function _set_slide_rules(){

			$this->form_validation->set_rules('slide_sub_title', 'Slide Sub Title', 'trim|required');
			$this->form_validation->set_rules('slide_title', 'Slide Title', 'trim|required');
			$this->form_validation->set_rules('slide_desc', 'Slide Description', 'trim|required');
			$this->form_validation->set_rules('slide_link', 'Slide Link', 'trim|required');
			$this->form_validation->set_rules('slide_class', 'Slide Alignment Class', 'trim|required');
			$this->form_validation->set_rules('slide_status', 'Slide Satus',  'trim|required');

		}
}
?>	