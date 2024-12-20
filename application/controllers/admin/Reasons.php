<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reasons extends CI_Controller {
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
			$data['title'] = 'Reasons';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$reasonLists = $this->admin_model->get_all_reasons()->result();
			$data['reasonLists'] = $reasonLists;


			$this->load->view('admin/reasons/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Reason';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/reasons/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_par_categories()->result();
			$data['parCatLists'] = $parCatLists;

			$this->_set_reason_rules();
			$this->_set_reason_fields();

			if(isset($_REQUEST['addreason']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$reas_icon	 = $_FILES['reas_icon']['name'];
						if($reas_icon != '')
						{
							$config['upload_path'] = './assets/reason-icons/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 150;
							$this->load->library('upload', $config);
							$reas_icon = "reas_icon";
							if (!$this->upload->do_upload($reas_icon))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$reas_icon_data = array('upload_data' => $this->upload->data());
								$reasoninfo = array( 
											'par_id' => $this->input->post('par_id'),
											'reas_title' => $this->input->post('reas_title'),
											'reas_desc' => $this->input->post('reas_desc'),
											'reas_icon' => $reas_icon_data['upload_data']['file_name'],
											'reas_status' => $this->input->post('reas_status'),
											'reas_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addreason = $this->admin_model->add_reason($reasoninfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Reason Added successfully.</p>');
								redirect('admin/reasons');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$reasoninfo = array( 
										'par_id' => $this->input->post('par_id'),
										'reas_title' => $this->input->post('reas_title'),
										'reas_desc' => $this->input->post('reas_desc'),
										'reas_status' => $this->input->post('reas_status'),
										'reas_created' => date('Y-m-d H:i:s', strtotime($current)),
									);
										
							
							$addreason = $this->admin_model->add_reason($reasoninfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Reason Added successfully.</p>');
							redirect('admin/reasons');
						}	
				}
			}	

			$this->load->view('admin/reasons/add', $data);
		}

		public function edit()
		{
			$reasonId = $_GET['reason'];
			$hexaId = hex2bin($reasonId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Reason';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/reasons/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_par_categories()->result();
			$data['parCatLists'] = $parCatLists;

			$reasonInfo = $this->admin_model->get_reason_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->par_id = $reasonInfo->par_id;
			$this->form_data->reas_title = $reasonInfo->reas_title;
			$this->form_data->reas_desc = $reasonInfo->reas_desc;
			$this->form_data->reas_icon = $reasonInfo->reas_icon;
			$this->form_data->reas_status = $reasonInfo->reas_status;

			$this->_set_reason_rules();

			if(isset($_REQUEST['editreason']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$reas_icon	 = $_FILES['reas_icon']['name'];
					if($reas_icon != '')
					{
							$config['upload_path'] = './assets/reason-icons/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 150;
							$this->load->library('upload', $config);
							$reas_icon = "reas_icon";
							if (!$this->upload->do_upload($reas_icon))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$reas_icon_data = array('upload_data' => $this->upload->data());
								$reasoninfo = array( 
											'par_id' => $this->input->post('par_id'),
											'reas_title' => $this->input->post('reas_title'),
											'reas_desc' => $this->input->post('reas_desc'),
											'reas_icon' => $reas_icon_data['upload_data']['file_name'],
											'reas_status' => $this->input->post('reas_status'),
											'reas_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editreason = $this->admin_model->edit_reason($reasoninfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Reason updated successfully.</p>');
								redirect('admin/reasons');
							}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$reasoninfo = array( 
											'par_id' => $this->input->post('par_id'),
											'reas_title' => $this->input->post('reas_title'),
											'reas_desc' => $this->input->post('reas_desc'),
											'reas_status' => $this->input->post('reas_status'),
											'reas_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editreason = $this->admin_model->edit_reason($reasoninfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Reason updated successfully.</p>');
						redirect('admin/reasons');
					}	
				}
			}
				

			$this->load->view('admin/reasons/edit', $data);
		}

		public function deletereason($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Reason';
			$reasoninfo = array( 
									'reas_deleted' => '1',
								);
			$id = $this->admin_model->delete_reason($reasoninfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Reason Deleted Successfully.</div>');
			redirect('admin/reasons');
		}

		function _set_reason_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->par_id = '';

			$this->form_data->reas_title = '';

			$this->form_data->reas_desc = '';

			$this->form_data->reas_icon = '';

			$this->form_data->reas_status = '';

		}	

	
		function _set_reason_rules(){

			$this->form_validation->set_rules('reas_title', 'Reason Title', 'trim|required');
			$this->form_validation->set_rules('reas_desc', 'Reason Description', 'trim|required');
			$this->form_validation->set_rules('reas_status', 'Reason Satus',  'trim|required');

		}
}	
?>		