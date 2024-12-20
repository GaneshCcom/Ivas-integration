<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trending extends CI_Controller {
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
			$data['title'] = 'Trending Blocks';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$trendLists = $this->admin_model->get_trends()->result();
			$data['trendLists'] = $trendLists;


			$this->load->view('admin/trending/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Trending Block';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/trending/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$this->_set_trend_rules();
			$this->_set_trend_fields();

			if(isset($_REQUEST['addtrend']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$trend_img	 = $_FILES['trend_img']['name'];
						if($trend_img != '')
						{
							$config['upload_path'] = './assets/trending-block-images/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 250;
							$this->load->library('upload', $config);
							$trend_img = "trend_img";
							if (!$this->upload->do_upload($trend_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$trend_img_data = array('upload_data' => $this->upload->data());
								$trendinfo = array( 
											'trend_title' => $this->input->post('trend_title'),
											'trend_desc' => $this->input->post('trend_desc'),
											'trend_img' => $trend_img_data['upload_data']['file_name'],
											'trend_link' => $this->input->post('trend_link'),
											'cat_id' => $this->input->post('cat_id'),
											'trend_status' => $this->input->post('trend_status'),
											'trend_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addtrend = $this->admin_model->add_trend($trendinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Trending Block Added successfully.</p>');
								redirect('admin/trending');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$trendinfo = array( 
										'trend_title' => $this->input->post('trend_title'),
										'trend_desc' => $this->input->post('trend_desc'),
										'trend_link' => $this->input->post('trend_link'),
										'cat_id' => $this->input->post('cat_id'),
										'trend_status' => $this->input->post('trend_status'),
										'trend_created' => date('Y-m-d H:i:s', strtotime($current)),
									);
										
							
							$addtrend = $this->admin_model->add_trend($trendinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Trending Block Added successfully.</p>');
							redirect('admin/trending');
						}	
				}
			}	

			$this->load->view('admin/trending/add', $data);
		}

		public function edit()
		{
			$trendId = $_GET['trend'];
			$hexaId = hex2bin($trendId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Trending Block';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/trending/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$trendInfo = $this->admin_model->get_trend_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->trend_title = $trendInfo->trend_title;
			$this->form_data->trend_desc = $trendInfo->trend_desc;
			$this->form_data->trend_img = $trendInfo->trend_img;
			$this->form_data->trend_link = $trendInfo->trend_link;
			$this->form_data->cat_id = $trendInfo->cat_id;
			$this->form_data->trend_status = $trendInfo->trend_status;

			$this->_set_trend_rules();

			if(isset($_REQUEST['edittrend']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$trend_img	 = $_FILES['trend_img']['name'];
					if($trend_img != '')
					{
							$config['upload_path'] = './assets/trending-block-images/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 110;
							$this->load->library('upload', $config);
							$trend_img = "trend_img";
							if (!$this->upload->do_upload($trend_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$trend_img_data = array('upload_data' => $this->upload->data());
								$trendinfo = array( 
											'trend_title' => $this->input->post('trend_title'),
											'trend_desc' => $this->input->post('trend_desc'),
											'trend_img' => $trend_img_data['upload_data']['file_name'],
											'trend_link' => $this->input->post('trend_link'),
											'cat_id' => $this->input->post('cat_id'),
											'trend_status' => $this->input->post('trend_status'),
											'trend_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$edittrend = $this->admin_model->edit_trend($trendinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Trending Block updated successfully.</p>');
								redirect('admin/trending');
							}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$testiinfo = array( 
									'trend_title' => $this->input->post('trend_title'),
									'trend_desc' => $this->input->post('trend_desc'),
									'trend_link' => $this->input->post('trend_link'),
									'cat_id' => $this->input->post('cat_id'),
									'trend_status' => $this->input->post('trend_status'),
									'trend_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						$edittrend = $this->admin_model->edit_trend($testiinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Trending Block updated successfully.</p>');
						redirect('admin/trending');
					}	
				}
			}
				

			$this->load->view('admin/trending/edit', $data);
		}

		public function deletetrend($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Trending Block';
			$trendinfo = array( 
									'trend_deleted' => '1',
								);
			$id = $this->admin_model->delete_trend($trendinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Trending Block Deleted Successfully.</div>');
			redirect('admin/trending');
		}

		function _set_trend_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->trend_title = '';

			$this->form_data->trend_desc = '';

			$this->form_data->trend_img = '';

			$this->form_data->trend_link = '';

			$this->form_data->cat_id = '';

			$this->form_data->trend_status = '';

		}	

		function _set_trend_rules(){

			$this->form_validation->set_rules('trend_title', 'Trending Block Title', 'trim|required');
			$this->form_validation->set_rules('trend_desc', 'Trending Block Description', 'trim|required');
			$this->form_validation->set_rules('trend_link', 'Trending Block Link', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Trending Block Category', 'trim|required');
			$this->form_validation->set_rules('trend_status', 'Trending Block Satus',  'trim|required');

		}
}
?>	