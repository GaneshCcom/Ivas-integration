<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rating extends CI_Controller {
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
			$data['title'] = 'Star Rating';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$ratingLists = $this->admin_model->get_all_ratings()->result();
			$data['ratingLists'] = $ratingLists;


			$this->load->view('admin/attributes/rating/index', $data);
		}
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Star Rating';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/rating/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_rating_rules();
			$this->_set_rating_fields();

			if(isset($_REQUEST['addrating']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$ratinginfo = array( 
									'rating' => $this->input->post('rating'),
									'sr_status' => $this->input->post('sr_status'),
									'sr_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addrating = $this->admin_model->add_rating($ratinginfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Star Rating Added successfully.</p>');
						redirect('admin/attributes/rating');
				}	
			}
			$this->load->view('admin/attributes/rating/add', $data);
		}
		public function edit()
		{
			$ratingId = $_GET['rating'];
			$hexaId = hex2bin($ratingId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Star Rating';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/rating/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$ratingInfo = $this->admin_model->get_rating_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->rating = $ratingInfo->rating;
			$this->form_data->sr_status = $ratingInfo->sr_status;

			$this->_set_rating_rules();
			if(isset($_REQUEST['editrating']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						// save data	
						$current = date('Y-m-d H:i:s');
						$ratinginfo = array( 
											'rating' => $this->input->post('rating'),
											'sr_status' => $this->input->post('sr_status'),
											'sr_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
									
						$editrating = $this->admin_model->edit_rating($ratinginfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Star Rating updated successfully.</p>');
						redirect('admin/attributes/rating');
				}
			}	

			$this->load->view('admin/attributes/rating/edit', $data);
		}
		public function deleterating($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Star Rating';
			$ratinginfo = array( 
									'sr_deleted' => '1',
								);
			$id = $this->admin_model->delete_rating($ratinginfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Star Rating Deleted Successfully.</div>');
			redirect('admin/attributes/rating');
		}

		function _set_rating_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->rating = '';

			$this->form_data->sr_status = '';

		}	

	
		function _set_rating_rules(){

			$this->form_validation->set_rules('rating', 'Star Rating', 'trim|required');
			$this->form_validation->set_rules('sr_status', 'Star Rating Satus',  'trim|required');

		}
}