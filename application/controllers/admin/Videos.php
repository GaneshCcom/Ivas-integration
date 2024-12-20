<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos extends CI_Controller {
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
			$data['title'] = 'Innovation Videos';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$videoLists = $this->admin_model->get_all_innov_videos()->result();
			$data['videoLists'] = $videoLists;


			$this->load->view('admin/videos/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Innovation Video';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/videos/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_par_categories()->result();
			$data['parCatLists'] = $parCatLists;

			$this->_set_video_rules();
			$this->_set_video_fields();

			if(isset($_REQUEST['addvideo']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$innov_video_thumb	 = $_FILES['innov_video_thumb']['name'];
						if($innov_video_thumb != '')
						{
							$config['upload_path'] = './assets/innov-video-thumbs/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 250;
							$this->load->library('upload', $config);
							$innov_video_thumb = "innov_video_thumb";
							if (!$this->upload->do_upload($innov_video_thumb))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$video_thumb_data = array('upload_data' => $this->upload->data());
								$videoinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'innov_video' => $this->input->post('innov_video'),
											'innov_video_thumb' => $video_thumb_data['upload_data']['file_name'],
											'innov_status' => $this->input->post('innov_status'),
											'innov_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addvideo = $this->admin_model->add_innov_video($videoinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Innovation Video Added successfully.</p>');
								redirect('admin/videos');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$videoinfo = array( 
										'par_id' => $this->input->post('par_id'),
										'innov_video' => $this->input->post('innov_video'),
										'innov_status' => $this->input->post('innov_status'),
										'innov_created' => date('Y-m-d H:i:s', strtotime($current)),
									);
										
							
							$addvideo = $this->admin_model->add_innov_video($videoinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Innovation Video Added successfully.</p>');
							redirect('admin/videos');
						}	
				}
			}	

			$this->load->view('admin/videos/add', $data);
		}

		public function edit()
		{
			$videoId = $_GET['video'];
			$hexaId = hex2bin($videoId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Innovation Video';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/videos/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_par_categories()->result();
			$data['parCatLists'] = $parCatLists;

			$videoInfo = $this->admin_model->get_innov_video_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->par_id = $videoInfo->par_id;
			$this->form_data->innov_video = $videoInfo->innov_video;
			$this->form_data->innov_video_thumb = $videoInfo->innov_video_thumb;
			$this->form_data->innov_status = $videoInfo->innov_status;

			$this->_set_video_rules();

			if(isset($_REQUEST['editvideo']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$innov_video_thumb	 = $_FILES['innov_video_thumb']['name'];
					if($innov_video_thumb != '')
					{
							$config['upload_path'] = './assets/innov-video-thumbs/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 250;
							$this->load->library('upload', $config);
							$innov_video_thumb = "innov_video_thumb";
							if (!$this->upload->do_upload($innov_video_thumb))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$video_thumb_data = array('upload_data' => $this->upload->data());
								$videoinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'innov_video' => $this->input->post('innov_video'),
											'innov_video_thumb' => $video_thumb_data['upload_data']['file_name'],
											'innov_status' => $this->input->post('innov_status'),
											'innov_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editvideo = $this->admin_model->edit_innov_video($videoinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Innovation Video updated successfully.</p>');
								redirect('admin/videos');
							}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$videoinfo = array( 
									'par_id' => $this->input->post('par_id'),
									'innov_video' => $this->input->post('innov_video'),
									'innov_status' => $this->input->post('innov_status'),
									'innov_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						$editvideo = $this->admin_model->edit_innov_video($videoinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Innovation Video updated successfully.</p>');
						redirect('admin/videos');
					}	
				}
			}
				

			$this->load->view('admin/videos/edit', $data);
		}

		public function deletevideo($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Innovation Video';
			$videoinfo = array( 
									'innov_deleted' => '1',
								);
			$id = $this->admin_model->delete_innov_video($videoinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Innovation Video Deleted Successfully.</div>');
			redirect('admin/videos');
		}

		function _set_video_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->par_id = '';

			$this->form_data->innov_video = '';

			$this->form_data->innov_video_thumb = '';

			$this->form_data->innov_status = '';

		}	

	
		function _set_video_rules(){

			$this->form_validation->set_rules('innov_video', 'Innovation Video', 'trim|required');
			$this->form_validation->set_rules('innov_status', 'Innovation Video Satus',  'trim|required');

		}
}	
?>	