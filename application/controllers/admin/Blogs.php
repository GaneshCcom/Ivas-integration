<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blogs extends CI_Controller {
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
			$data['title'] = 'Blogs';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$blogLists = $this->admin_model->get_blogs()->result();
			$data['blogLists'] = $blogLists;


			$this->load->view('admin/blogs/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Blog';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/blogs/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$this->_set_blog_rules();
			$this->_set_blog_fields();

			if(isset($_REQUEST['addblog']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						$blog_img = $_FILES['blog_img']['name'];
						if($blog_img != '')
						{
							$config['upload_path'] = './assets/blogs/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 850;
							$this->load->library('upload', $config);
							$blog_img = "blog_img";
							if (!$this->upload->do_upload($blog_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$blogslug = str_replace(' ', '-', strtolower($this->input->post('blog_title')));
								$blog_img_data = array('upload_data' => $this->upload->data());
								$bloginfo = array( 
											'blog_title' => $this->input->post('blog_title'),
											'blog_slug' => $blogslug,
											'blog_img' => $blog_img_data['upload_data']['file_name'],
											'blog_short_content' => $this->input->post('blog_short_content'),
											'blog_content' => $this->input->post('blog_content'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_id' => $this->input->post('cat_id'),
											'blog_status' => $this->input->post('blog_status'),
											'blog_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addblog = $this->admin_model->add_blog($bloginfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Blog Added successfully.</p>');
								redirect('admin/blogs');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$blogslug = str_replace(' ', '-', strtolower($this->input->post('blog_title')));
							$bloginfo = array( 
											'blog_title' => $this->input->post('blog_title'),
											'blog_slug' => $blogslug,
											'blog_short_content' => $this->input->post('blog_short_content'),
											'blog_content' => $this->input->post('blog_content'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_id' => $this->input->post('cat_id'),
											'blog_status' => $this->input->post('blog_status'),
											'blog_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
							$addblog = $this->admin_model->add_blog($bloginfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Blog Added successfully.</p>');
							redirect('admin/blogs');
						}	
				}
			}	

			$this->load->view('admin/blogs/add', $data);
		}

		public function edit()
		{
			$blogId = $_GET['blog'];
			$hexaId = hex2bin($blogId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Blog';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/blogs/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$blogInfo = $this->admin_model->get_blog_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->blog_title = $blogInfo->blog_title;
			$this->form_data->blog_img = $blogInfo->blog_img;
			$this->form_data->blog_short_content = $blogInfo->blog_short_content;
			$this->form_data->blog_content = $blogInfo->blog_content;
			$this->form_data->meta_title = $blogInfo->meta_title;
			$this->form_data->meta_desc = $blogInfo->meta_desc;
			$this->form_data->meta_keyword = $blogInfo->meta_keyword;
			$this->form_data->cat_id = $blogInfo->cat_id;
			$this->form_data->blog_status = $blogInfo->blog_status;

			$this->_set_blog_rules();

			if(isset($_REQUEST['editblog']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					$blog_img	 = $_FILES['blog_img']['name'];
					if($blog_img != '')
					{
							$config['upload_path'] = './assets/blogs/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 850;
							$this->load->library('upload', $config);
							$blog_img = "blog_img";
							if (!$this->upload->do_upload($blog_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$blog_img_data = array('upload_data' => $this->upload->data());
								$bloginfo = array( 
											'blog_title' => $this->input->post('blog_title'),
											'blog_img' => $blog_img_data['upload_data']['file_name'],
											'blog_short_content' => $this->input->post('blog_short_content'),
											'blog_content' => $this->input->post('blog_content'),
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'cat_id' => $this->input->post('cat_id'),
											'blog_status' => $this->input->post('blog_status'),
											'blog_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editblog = $this->admin_model->edit_blog($bloginfo, $id);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Blog updated successfully.</p>');
								redirect('admin/blogs');
							}	
					}
					else
					{	
						// save data	
						$current = date('Y-m-d H:i:s');
						$bloginfo = array( 
									'blog_title' => $this->input->post('blog_title'),
									'blog_short_content' => $this->input->post('blog_short_content'),
									'blog_content' => $this->input->post('blog_content'),
									'meta_title' => $this->input->post('meta_title'),
									'meta_desc' => $this->input->post('meta_desc'),
									'meta_keyword' => $this->input->post('meta_keyword'),
									'cat_id' => $this->input->post('cat_id'),
									'blog_status' => $this->input->post('blog_status'),
									'blog_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						$editblog = $this->admin_model->edit_blog($bloginfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Blog updated successfully.</p>');
						redirect('admin/blogs');
					}	
				}
			}
				

			$this->load->view('admin/blogs/edit', $data);
		}

		public function deleteblog($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Blog';
			$bloginfo = array( 
									'blog_deleted' => '1',
								);
			$id = $this->admin_model->delete_blog($bloginfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Blog Deleted Successfully.</div>');
			redirect('admin/blogs');
		}

		function _set_blog_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->blog_title = '';

			$this->form_data->blog_slug = '';

			$this->form_data->blog_img = '';

			$this->form_data->blog_short_content = '';

			$this->form_data->blog_content = '';

			$this->form_data->meta_title = '';

			$this->form_data->meta_desc = '';

			$this->form_data->meta_keyword = '';

			$this->form_data->cat_id = '';

			$this->form_data->blog_status = '';

		}	

	

		function _set_blog_rules(){

			$this->form_validation->set_rules('blog_title', 'Blog Title', 'trim|required');
			$this->form_validation->set_rules('blog_short_content', 'Blog Short Desc', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Catalog Category', 'trim|required');
			$this->form_validation->set_rules('blog_status', 'Blog Satus',  'trim|required');

		}
}
?>	