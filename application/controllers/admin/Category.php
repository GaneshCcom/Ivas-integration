<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {
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
			$data['title'] = 'Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$cateLists = $this->admin_model->get_categories()->result();
			$data['cateLists'] = $cateLists;

			// print_r($cateLists);
			// die;


			$this->load->view('admin/category/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/category/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_par_categories()->result();
			$data['parCatLists'] = $parCatLists;

			$this->_set_cate_rules();
			$this->_set_cate_fields();

			if(isset($_REQUEST['addcate']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$cat_back_img = $_FILES['cat_back_img']['name'];
						$cat_list_img = $_FILES['cat_list_img']['name'];
						if($cat_back_img != '' && $cat_list_img != '')
						{
							$config['upload_path'] = './assets/category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$cat_back_img = "cat_back_img";
							if (!$this->upload->do_upload($cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/category-list-img/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$cat_list_img = "cat_list_img";
							if (!$this->upload->do_upload($cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$list_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$cat_slug = $this->slug($this->input->post('cat_name'));
								$cateinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'cat_name' => $this->input->post('cat_name'),
											'cat_slug' => $cat_slug,
											'cat_back_img' => $back_img_data['upload_data']['file_name'],
											'cat_list_img' => $list_img_data['upload_data']['file_name'],
											'cat_desc' => $this->input->post('cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_status' => $this->input->post('cat_status'),
											'cat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addcate = $this->admin_model->add_category($cateinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category Added successfully.</p>');
								redirect('admin/category');
								
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$cat_slug = $this->slug($this->input->post('cat_name'));
							$cateinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'cat_name' => $this->input->post('cat_name'),
											'cat_slug' => $cat_slug,
											'cat_desc' => $this->input->post('cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_status' => $this->input->post('cat_status'),
											'cat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
										
							
							$addcate = $this->admin_model->add_category($cateinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category Added successfully.</p>');
							redirect('admin/category');
						}	
				}
			}	

			$this->load->view('admin/category/add', $data);
		}

		public function edit()
		{
			$cateId = $_GET['cate'];
			$hexaId = hex2bin($cateId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/category/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_par_categories()->result();
			$data['parCatLists'] = $parCatLists;
			// print_r($parCatLists);
			// die;

			$cateInfo = $this->admin_model->get_category_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->par_id = $cateInfo->par_id;
			$this->form_data->cat_name = $cateInfo->cat_name;
			$this->form_data->cat_back_img = $cateInfo->cat_back_img;
			$this->form_data->cat_list_img = $cateInfo->cat_list_img;
			$this->form_data->cat_desc = $cateInfo->cat_desc;
			$this->form_data->meta_title = $cateInfo->meta_title;
			$this->form_data->meta_desc = $cateInfo->meta_desc;
			$this->form_data->meta_keyword = $cateInfo->meta_keyword;
			$this->form_data->cat_status = $cateInfo->cat_status;

			$this->_set_cate_rules();

			if(isset($_REQUEST['editcate']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$cat_back_img = $_FILES['cat_back_img']['name'];
					$cat_list_img = $_FILES['cat_list_img']['name'];
					if($cat_back_img != '' && $cat_list_img != '')
					{
							$config['upload_path'] = './assets/category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$cat_back_img = "cat_back_img";
							if (!$this->upload->do_upload($cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/category-list-img/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$cat_list_img = "cat_list_img";
							if (!$this->upload->do_upload($cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$list_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$cateinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'cat_name' => $this->input->post('cat_name'),
											'cat_back_img' => $back_img_data['upload_data']['file_name'],
											'cat_list_img' => $list_img_data['upload_data']['file_name'],
											'cat_desc' => $this->input->post('cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_status' => $this->input->post('cat_status'),
											'cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editcate = $this->admin_model->edit_category($cateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
								redirect('admin/category');


					}elseif ($cat_back_img != '' || $cat_list_img != '') {
						if($cat_back_img != '')
						{
							$config['upload_path'] = './assets/category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$cat_back_img = "cat_back_img";
							if (!$this->upload->do_upload($cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$back_img_data = array('upload_data' => $this->upload->data());

							// save data	
								$current = date('Y-m-d H:i:s');
								$cateinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'cat_name' => $this->input->post('cat_name'),
											'cat_back_img' => $back_img_data['upload_data']['file_name'],
											'cat_desc' => $this->input->post('cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_status' => $this->input->post('cat_status'),
											'cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editcate = $this->admin_model->edit_category($cateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
								redirect('admin/category');
						}
						if($cat_list_img != '')
						{
							$config['upload_path'] = './assets/category-list-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$cat_list_img = "cat_list_img";
							if (!$this->upload->do_upload($cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$list_img_data = array('upload_data' => $this->upload->data());

							// save data	
								$current = date('Y-m-d H:i:s');
								$cateinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'cat_name' => $this->input->post('cat_name'),
											'cat_list_img' => $list_img_data['upload_data']['file_name'],
											'cat_desc' => $this->input->post('cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_status' => $this->input->post('cat_status'),
											'cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editcate = $this->admin_model->edit_category($cateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
								redirect('admin/category');
						}	
					}
					else
					{
							// save data	
							$current = date('Y-m-d H:i:s');
							$cateinfo = array( 
											'par_id' => $this->input->post('par_id'),
											'cat_name' => $this->input->post('cat_name'),
											'cat_desc' => $this->input->post('cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_status' => $this->input->post('cat_status'),
											'cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);

							$editcate = $this->admin_model->edit_category($cateinfo, $id);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
							redirect('admin/category');
					}	
				}
			}	

			$this->load->view('admin/category/edit', $data);
		}

		public function deletecate($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Category';
			$cateinfo = array( 
									'cat_deleted' => '1',
								);
			$id = $this->admin_model->delete_category($cateinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Category Deleted Successfully.</div>');
			redirect('admin/category');
		}

		function _set_cate_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->par_id = '';

			$this->form_data->cat_name = '';

			$this->form_data->cat_slug = '';

			$this->form_data->cat_desc = '';

			$this->form_data->cat_back_img = '';

			$this->form_data->cat_list_img = '';

			$this->form_data->meta_title = '';

			$this->form_data->meta_desc = '';

			$this->form_data->meta_keyword = '';

			$this->form_data->cat_status = '';

		}	

	
		function _set_cate_rules(){

			$this->form_validation->set_rules('cat_name', 'Category Name', 'trim|required');
			$this->form_validation->set_rules('cat_desc', 'Category Description', 'trim|required');
			$this->form_validation->set_rules('par_id', 'Parent Category', 'trim|required');
			$this->form_validation->set_rules('cat_status', 'Category Satus',  'trim|required');

		}

		/* Parent Category */
		public function parcats()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Parent Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$parCateLists = $this->admin_model->get_par_categories()->result();
			$data['parCateLists'] = $parCateLists;


			$this->load->view('admin/category/parcats', $data);
		}

		public function addparcats()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Parent Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/category/addparcats');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$this->_set_parcate_fields();
			$this->_set_parcate_rules();

			if(isset($_REQUEST['addparcats']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$par_cat_back_img = $_FILES['par_cat_back_img']['name'];
						$par_cat_list_img = $_FILES['par_cat_list_img']['name'];
						if($par_cat_back_img != '' && $par_cat_list_img != '')
						{
							$config['upload_path'] = './assets/category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$par_cat_back_img = "par_cat_back_img";
							if (!$this->upload->do_upload($par_cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$par_back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/category-list-img/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$par_cat_list_img = "par_cat_list_img";
							if (!$this->upload->do_upload($par_cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$par_list_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$parcateinfo = array( 
											'par_cat_name' => $this->input->post('par_cat_name'),
											'par_cat_back_img' => $par_back_img_data['upload_data']['file_name'],
											'par_cat_list_img' => $par_list_img_data['upload_data']['file_name'],
											'par_cat_desc' => $this->input->post('par_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'par_cat_status' => $this->input->post('par_cat_status'),
											'par_cat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addcate = $this->admin_model->add_par_category($parcateinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category Added successfully.</p>');
								redirect('admin/category/parcats');
								
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$parcateinfo = array( 
											'par_cat_name' => $this->input->post('par_cat_name'),
											'par_cat_desc' => $this->input->post('par_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'par_cat_status' => $this->input->post('par_cat_status'),
											'par_cat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
										
							
							$addcate = $this->admin_model->add_par_category($parcateinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category Added successfully.</p>');
							redirect('admin/category/parcats');
						}	
				}
			}	

			$this->load->view('admin/category/addparcats', $data);
		}

		public function editparcats()
		{
			$cateId = $_GET['cate'];
			$hexaId = hex2bin($cateId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Parent Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/category/editparcats');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parcateInfo = $this->admin_model->get_par_category_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->par_cat_name = $parcateInfo->par_cat_name;
			$this->form_data->par_cat_back_img = $parcateInfo->par_cat_back_img;
			$this->form_data->par_cat_list_img = $parcateInfo->par_cat_list_img;
			$this->form_data->par_cat_desc = $parcateInfo->par_cat_desc;
			$this->form_data->meta_title = $parcateInfo->meta_title;
			$this->form_data->meta_desc = $parcateInfo->meta_desc;
			$this->form_data->meta_keyword = $parcateInfo->meta_keyword;
			$this->form_data->par_cat_status = $parcateInfo->par_cat_status;

			$this->_set_parcate_rules();

			if(isset($_REQUEST['editparcats']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$par_cat_back_img = $_FILES['par_cat_back_img']['name'];
					$par_cat_list_img = $_FILES['par_cat_list_img']['name'];
					if($par_cat_back_img != '' && $par_cat_list_img != '')
					{
							$config['upload_path'] = './assets/category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$par_cat_back_img = "par_cat_back_img";
							if (!$this->upload->do_upload($par_cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$par_back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/category-list-img/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$par_cat_list_img = "par_cat_list_img";
							if (!$this->upload->do_upload($par_cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$par_list_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$parcateinfo = array( 
											'par_cat_name' => $this->input->post('par_cat_name'),
											'par_cat_back_img' => $par_back_img_data['upload_data']['file_name'],
											'par_cat_list_img' => $par_list_img_data['upload_data']['file_name'],
											'par_cat_desc' => $this->input->post('par_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'par_cat_status' => $this->input->post('par_cat_status'),
											'par_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editparcats = $this->admin_model->edit_par_category($parcateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
								redirect('admin/category/parcats');


					}elseif ($par_cat_back_img != '' || $par_cat_list_img != '') {
						if($par_cat_back_img != '')
						{
							$config['upload_path'] = './assets/category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$par_cat_back_img = "par_cat_back_img";
							if (!$this->upload->do_upload($par_cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$par_back_img_data = array('upload_data' => $this->upload->data());

							// save data	
								$current = date('Y-m-d H:i:s');
								$parcateinfo = array( 
											'par_cat_name' => $this->input->post('par_cat_name'),
											'par_cat_back_img' => $par_back_img_data['upload_data']['file_name'],
											'par_cat_desc' => $this->input->post('par_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'par_cat_status' => $this->input->post('par_cat_status'),
											'par_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editparcats = $this->admin_model->edit_par_category($parcateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
								redirect('admin/category/parcats');
						}
						if($par_cat_list_img != '')
						{
							$config['upload_path'] = './assets/category-list-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$par_cat_list_img = "par_cat_list_img";
							if (!$this->upload->do_upload($par_cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$par_list_img_data = array('upload_data' => $this->upload->data());

							// save data	
								$current = date('Y-m-d H:i:s');
								$parcateinfo = array( 
											'par_cat_name' => $this->input->post('par_cat_name'),
											'par_cat_list_img' => $par_list_img_data['upload_data']['file_name'],
											'par_cat_desc' => $this->input->post('par_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'par_cat_status' => $this->input->post('par_cat_status'),
											'par_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editparcats = $this->admin_model->edit_par_category($parcateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
								redirect('admin/category/parcats');
						}	
					}
					else
					{
							// save data	
							$current = date('Y-m-d H:i:s');
							$parcateinfo = array( 
											'par_cat_name' => $this->input->post('par_cat_name'),
											'par_cat_desc' => $this->input->post('par_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'par_cat_status' => $this->input->post('par_cat_status'),
											'par_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);

							$editparcats = $this->admin_model->edit_par_category($parcateinfo, $id);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Category updated successfully.</p>');
							redirect('admin/category/parcats');
					}	
				}
			}	

			$this->load->view('admin/category/editparcats', $data);
		}

		public function deleteparcat($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Parent Category';
			$parcateinfo = array( 
									'par_cat_deleted' => '1',
								);
			$id = $this->admin_model->delete_par_category($parcateinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Parent Category Deleted Successfully.</div>');
			redirect('admin/category/parcats');
		}

		function _set_parcate_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->par_cat_name = '';

			$this->form_data->par_cat_desc = '';

			$this->form_data->par_cat_back_img = '';

			$this->form_data->par_cat_list_img = '';

			$this->form_data->meta_title = '';

			$this->form_data->meta_desc = '';

			$this->form_data->meta_keyword = '';

			$this->form_data->par_cat_status = '';

		}

		function _set_parcate_rules(){

			$this->form_validation->set_rules('par_cat_name', 'Parent Category Name', 'trim|required');
			$this->form_validation->set_rules('par_cat_desc', 'Parent Category Description', 'trim|required');
			$this->form_validation->set_rules('par_cat_status', 'Parent Category Satus',  'trim|required');

		}

		/* Sub Category */
		public function subcates()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Sub Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$subcateLists = $this->admin_model->get_sub_categories()->result();
			$data['subcateLists'] = $subcateLists;


			$this->load->view('admin/category/subcates', $data);
		}

		public function addsubcate()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Sub Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/category/addsubcate');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$this->_set_subcate_rules_add();
			$this->_set_subcate_fields();

			if(isset($_REQUEST['addsubcate']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$sub_cat_back_img = $_FILES['sub_cat_back_img']['name'];
						$sub_cat_list_img = $_FILES['sub_cat_list_img']['name'];
						$sub_cat_thumb_img = $_FILES['sub_cat_thumb_img']['name'];
						if($sub_cat_back_img != '' && $sub_cat_list_img != '' && $sub_cat_thumb_img != '')
						{
							$config['upload_path'] = './assets/sub-category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$sub_cat_back_img = "sub_cat_back_img";
							if (!$this->upload->do_upload($sub_cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/sub-category-list-img/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$sub_cat_list_img = "sub_cat_list_img";
							if (!$this->upload->do_upload($sub_cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_list_img_data = array('upload_data' => $this->upload->data());

							// new changes for sub_thumb_img_data
							$config2['upload_path'] = './assets/sub-category-thumb-img/';
							$config2['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config2);
							$sub_cat_thumb_img = "sub_cat_thumb_img";
							if (!$this->upload->do_upload($sub_cat_thumb_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_thumb_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$sub_cat_slug = $this->slug($this->input->post('sub_cat_name'));
								$subcateinfo = array( 
											'cat_id' => $this->input->post('cat_id'),
											'sub_cat_name' => $this->input->post('sub_cat_name'),
											'sub_cat_slug' => $sub_cat_slug,
											'sub_cat_back_img' => $sub_back_img_data['upload_data']['file_name'],
											'sub_cat_list_img' => $sub_list_img_data['upload_data']['file_name'],
											'sub_cat_thumb_img' => $sub_thumb_img_data['upload_data']['file_name'],
											'sub_cat_desc' => $this->input->post('sub_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'sub_cat_status' => $this->input->post('sub_cat_status'),
											'sub_cat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addsubcate = $this->admin_model->add_sub_category($subcateinfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Sub Category Added successfully.</p>');
								redirect('admin/category/subcates');
								
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$sub_cat_slug = $this->slug($this->input->post('sub_cat_name'));
							$subcateinfo = array( 
											'cat_id' => $this->input->post('cat_id'),
											'sub_cat_name' => $this->input->post('sub_cat_name'),
											'sub_cat_slug' => $sub_cat_slug,
											'sub_cat_desc' => $this->input->post('sub_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'sub_cat_status' => $this->input->post('sub_cat_status'),
											'sub_cat_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
										
							
							$addsubcate = $this->admin_model->add_sub_category($subcateinfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Sub Category Added successfully.</p>');
							redirect('admin/category/subcates');
						}	
				}
			}	

			$this->load->view('admin/category/addsubcate', $data);
		}

		public function editsubcate()
		{
			$subcateId = $_GET['subcate'];
			$hexaId = hex2bin($subcateId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Sub Category';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/category/editsubcate');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$subcateInfo = $this->admin_model->get_sub_category_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->cat_id = $subcateInfo->cat_id;
			$this->form_data->sub_cat_name = $subcateInfo->sub_cat_name;
			$this->form_data->sub_cat_back_img = $subcateInfo->sub_cat_back_img;
			$this->form_data->sub_cat_list_img = $subcateInfo->sub_cat_list_img;
			$this->form_data->sub_cat_thumb_img = $subcateInfo->sub_cat_thumb_img;
			$this->form_data->sub_cat_desc = $subcateInfo->sub_cat_desc;
			$this->form_data->meta_title = $subcateInfo->meta_title;
			$this->form_data->meta_desc = $subcateInfo->meta_desc;
			$this->form_data->meta_keyword = $subcateInfo->meta_keyword;
			$this->form_data->sub_cat_status = $subcateInfo->sub_cat_status;

			$this->_set_subcate_rules();

			if(isset($_REQUEST['editsubcate']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$sub_cat_back_img = $_FILES['sub_cat_back_img']['name'];
					$sub_cat_list_img = $_FILES['sub_cat_list_img']['name'];
					$sub_cat_thumb_img = $_FILES['sub_cat_thumb_img']['name'];
					if($sub_cat_back_img != '' && $sub_cat_list_img != '' && $sub_cat_thumb_img != '')
					{
							$config['upload_path'] = './assets/sub-category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$sub_cat_back_img = "sub_cat_back_img";
							if (!$this->upload->do_upload($sub_cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_back_img_data = array('upload_data' => $this->upload->data());

							$config1['upload_path'] = './assets/sub-category-list-img/';
							$config1['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config1);
							$sub_cat_list_img = "sub_cat_list_img";
							if (!$this->upload->do_upload($sub_cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_list_img_data = array('upload_data' => $this->upload->data());

							// new changes for sub_cat_thumb_img
							$config2['upload_path'] = './assets/sub-category-thumb-img/';
							$config2['allowed_types'] = 'jpg|png';
							$this->upload->initialize($config2);
							$sub_cat_thumb_img = "sub_cat_thumb_img";
							if (!$this->upload->do_upload($sub_cat_thumb_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_thumb_img_data = array('upload_data' => $this->upload->data());

								// save data	
								$current = date('Y-m-d H:i:s');
								$subcateinfo = array( 
											'cat_id' => $this->input->post('cat_id'),
											'sub_cat_name' => $this->input->post('sub_cat_name'),
											'sub_cat_back_img' => $sub_back_img_data['upload_data']['file_name'],
											'sub_cat_list_img' => $sub_list_img_data['upload_data']['file_name'],
											'sub_cat_thumb_img' => $sub_thumb_img_data['upload_data']['file_name'],
											'sub_cat_desc' => $this->input->post('sub_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'sub_cat_status' => $this->input->post('sub_cat_status'),
											'sub_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editsubcate = $this->admin_model->edit_sub_category($subcateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Sub Category updated successfully.</p>');
								redirect('admin/category/subcates');


					}elseif ($sub_cat_back_img != '' || $sub_cat_list_img != '' || $sub_cat_thumb_img != '') {
						if($sub_cat_back_img != '')
						{
							$config['upload_path'] = './assets/sub-category-back-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$sub_cat_back_img = "sub_cat_back_img";
							if (!$this->upload->do_upload($sub_cat_back_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_back_img_data = array('upload_data' => $this->upload->data());

							// save data	
								$current = date('Y-m-d H:i:s');
								$subcateinfo = array( 
											'cat_id' => $this->input->post('cat_id'),
											'sub_cat_name' => $this->input->post('sub_cat_name'),
											'sub_cat_back_img' => $sub_back_img_data['upload_data']['file_name'],
											'sub_cat_desc' => $this->input->post('sub_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'sub_cat_status' => $this->input->post('sub_cat_status'),
											'sub_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editsubcate = $this->admin_model->edit_sub_category($subcateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Sub Category updated successfully.</p>');
								redirect('admin/category/subcates');
						}
						if($sub_cat_list_img != '')
						{
							$config['upload_path'] = './assets/sub-category-list-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$sub_cat_list_img = "sub_cat_list_img";
							if (!$this->upload->do_upload($sub_cat_list_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_list_img_data = array('upload_data' => $this->upload->data());

							// save data	
								$current = date('Y-m-d H:i:s');
								$subcateinfo = array( 
											'cat_id' => $this->input->post('cat_id'),
											'sub_cat_name' => $this->input->post('sub_cat_name'),
											'sub_cat_list_img' => $sub_list_img_data['upload_data']['file_name'],
											'sub_cat_desc' => $this->input->post('sub_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'sub_cat_status' => $this->input->post('sub_cat_status'),
											'sub_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editsubcate = $this->admin_model->edit_sub_category($subcateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Sub Category updated successfully.</p>');
								redirect('admin/category/subcates');
						}
						if($sub_cat_thumb_img != '')
						{
							$config['upload_path'] = './assets/sub-category-thumb-img/';
							$config['allowed_types'] = 'jpg|png';
							$this->load->library('upload', $config);
							$sub_cat_thumb_img = "sub_cat_thumb_img";
							if (!$this->upload->do_upload($sub_cat_thumb_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							$sub_thumb_img_data = array('upload_data' => $this->upload->data());

							// save data	
								$current = date('Y-m-d H:i:s');
								$subcateinfo = array( 
											'cat_id' => $this->input->post('cat_id'),
											'sub_cat_name' => $this->input->post('sub_cat_name'),
											'sub_cat_thumb_img' => $sub_thumb_img_data['upload_data']['file_name'],
											'sub_cat_desc' => $this->input->post('sub_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'sub_cat_status' => $this->input->post('sub_cat_status'),
											'sub_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editsubcate = $this->admin_model->edit_sub_category($subcateinfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Sub Category updated successfully.</p>');
								redirect('admin/category/subcates');
						}	
					}
					else
					{
							// save data	
							$current = date('Y-m-d H:i:s');
							$subcateinfo = array( 
											'cat_id' => $this->input->post('cat_id'),
											'sub_cat_name' => $this->input->post('sub_cat_name'),
											'sub_cat_desc' => $this->input->post('sub_cat_desc'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'sub_cat_status' => $this->input->post('sub_cat_status'),
											'sub_cat_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$editsubcate = $this->admin_model->edit_sub_category($subcateinfo, $id);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Sub Category updated successfully.</p>');
							redirect('admin/category/subcates');
					}	
				}
			}	

			$this->load->view('admin/category/editsubcate', $data);
		}

		public function deletesubcate($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Sub Category';
			$subcateinfo = array( 
									'sub_cat_deleted' => '1',
								);
			$id = $this->admin_model->delete_sub_category($subcateinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Sub Category Deleted Successfully.</div>');
			redirect('admin/category/subcates');
		}

		function _set_subcate_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->cat_id = '';

			$this->form_data->sub_cat_name = '';

			$this->form_data->sub_cat_slug = '';

			$this->form_data->sub_cat_desc = '';

			$this->form_data->sub_cat_back_img = '';

			$this->form_data->sub_cat_list_img = '';

			$this->form_data->sub_cat_thumb_img = '';

			$this->form_data->meta_title = '';

			$this->form_data->meta_desc = '';

			$this->form_data->meta_keyword = '';

			$this->form_data->sub_cat_status = '';

		}	

	
		function _set_subcate_rules_add(){

			$this->form_validation->set_rules('sub_cat_name', 'Sub Category Name', 'trim|required|is_unique[sub_category.sub_cat_name]');
			$this->form_validation->set_rules('sub_cat_desc', 'Sub Category Description', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Parent Category', 'trim|required');
			$this->form_validation->set_rules('sub_cat_status', 'Sub Category Satus',  'trim|required');

		}

		function _set_subcate_rules(){

			$this->form_validation->set_rules('sub_cat_name', 'Sub Category Name', 'trim|required');
			$this->form_validation->set_rules('sub_cat_desc', 'Sub Category Description', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Parent Category', 'trim|required');
			$this->form_validation->set_rules('sub_cat_status', 'Sub Category Satus',  'trim|required');

		}

		function slug($string, $spaceRepl = "-")
		{
		    $string = str_replace("&", "and", $string);

		    $string = preg_replace("/[^a-zA-Z0-9 _-]/", "", $string);

		    $string = strtolower($string);

		    $string = preg_replace("/[ ]+/", " ", $string);

		    $string = str_replace(" ", $spaceRepl, $string);

		    return $string;
		}
}
?>	