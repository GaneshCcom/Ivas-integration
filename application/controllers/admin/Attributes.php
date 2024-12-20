<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attributes extends CI_Controller {
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
			$data['title'] = 'Attribute';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$attributeLists = $this->admin_model->get_attributes()->result();
			$data['attributeLists'] = $attributeLists;


			$this->load->view('admin/attributes/index', $data);
		}
		// public function add()
		// {
		// 	$this->admin_model->isset_admin_user();
		// 	$data['title'] = 'Add Attribute';
		// 	$data['desc'] = '';
		// 	$data['loggedin'] = '';
		// 	$data['action'] = site_url('admin/attributes/add');
		// 	$data['typeback'] = '';
		// 	$adminSession = $this->session->userdata('adminSession');

		// 	$catLists = $this->admin_model->get_categories()->result();
		// 	$data['catLists'] = $catLists;

		// 	$this->_set_attribute_rules();
		// 	$this->_set_attribute_fields();

		// 	if(isset($_REQUEST['addattribute']))
		// 	{
		// 		if ($this->form_validation->run() == FALSE)
		// 		{
		// 			$data['message'] = '';
		// 		}
		// 		else
		// 		{
					
		// 				// save data	
		// 				$current = date('Y-m-d H:i:s');
		// 				$attributeinfo = array( 
		// 							'attr_name' => $this->input->post('attr_name'),
		// 							'attr_desc' => $this->input->post('attr_desc'),
		// 							'attr_status' => $this->input->post('attr_status'),
		// 							'attr_created' => date('Y-m-d H:i:s', strtotime($current)),
		// 						);
									
						
		// 				$addattribute = $this->admin_model->add_attribute($attributeinfo);

		// 				$cat_id = $this->input->post('cat_id');

		// 						for($i=0;$i<count($cat_id);$i++){

		// 							$catattrinfo = array( 
		// 									'attr_id' => $addattribute,
		// 									'cat_id' => $cat_id[$i],
		// 								);

		// 							$addproductcatattribute = $this->admin_model->add_pro_cat_attribute($catattrinfo);

		// 						}

		// 				// set user message
		// 				$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Attribute Added successfully.</p>');
		// 				redirect('admin/attributes');
		// 		}
		// 	}	

		// 	$this->load->view('admin/attributes/add', $data);
		// }
		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Attribute';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			/*$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;*/

			$subcatLists = $this->admin_model->get_allsub_categories()->result();
			$data['subcatLists'] = $subcatLists;

			$this->_set_attribute_rules();
			$this->_set_attribute_fields();

			if(isset($_REQUEST['addattribute']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					
						// save data	
						$current = date('Y-m-d H:i:s');
						$attributeinfo = array( 
									'attr_name' => $this->input->post('attr_name'),
									'attr_desc' => $this->input->post('attr_desc'),
									'attr_status' => $this->input->post('attr_status'),
									'attr_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						
						$addattribute = $this->admin_model->add_attribute($attributeinfo);

						$sub_cat_id = $this->input->post('sub_cat_id');

								for($i=0;$i<count($sub_cat_id);$i++){

									$catattrinfo = array( 
											'attr_id' => $addattribute,
											'sub_cat_id' => $sub_cat_id[$i],
										);

									$addproductcatattribute = $this->admin_model->add_pro_cat_attribute($catattrinfo);

								}

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Attribute Added successfully.</p>');
						redirect('admin/attributes');
				}
			}	

			$this->load->view('admin/attributes/add', $data);
		}

		public function edit()
		{
			$attributeId = $_GET['attribute'];
			$hexaId = hex2bin($attributeId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Attribute';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			// $catLists = $this->admin_model->get_categories()->result();
			// $data['catLists'] = $catLists;

			$subcatLists = $this->admin_model->get_allsub_categories()->result();
			$data['subcatLists'] = $subcatLists;

			$procateattrLists = $this->admin_model->get_pro_subcat_attribute_byattrId($id);
			$data['procateattrLists'] = $procateattrLists;

			$attributeInfo = $this->admin_model->get_attribute_byId($id)->row();
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->attr_name = $attributeInfo->attr_name;
			$this->form_data->attr_desc = $attributeInfo->attr_desc;
			$this->form_data->attr_status = $attributeInfo->attr_status;

			$this->_set_attribute_rules();
			//$this->_set_dept_fields();

			if(isset($_REQUEST['editattribute']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					
						// save data	
						$current = date('Y-m-d H:i:s');
						$attributeinfo = array( 
									'attr_name' => $this->input->post('attr_name'),
									'attr_desc' => $this->input->post('attr_desc'),
									'attr_status' => $this->input->post('attr_status'),
									'attr_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						$editattribute = $this->admin_model->edit_attribute($attributeinfo, $id);
						$this->admin_model->delete_pro_cat_attribute($id);

						$sub_cat_id = $this->input->post('sub_cat_id');

								for($i=0;$i<count($sub_cat_id);$i++){

									$catattrinfo = array( 
											'attr_id' => $id,
											'sub_cat_id' => $sub_cat_id[$i],
										);

									$addproductcatattribute = $this->admin_model->add_pro_cat_attribute($catattrinfo);

								}

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Attribute updated successfully.</p>');
						redirect('admin/attributes');
				}
			}
				

			$this->load->view('admin/attributes/edit', $data);
		}

		public function deleteattribute($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Attribute';
			$attributeinfo = array( 
									'attr_deleted' => '1',
								);
			$attributeid = $this->admin_model->delete_attribute($attributeinfo, $id);
			$procatattributeid = $this->admin_model->delete_pro_cat_attribute($id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Attribute Deleted Successfully.</div>');
			redirect('admin/attributes');
		}

		function _set_attribute_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->attr_name = '';

			$this->form_data->cat_id = '';

			$this->form_data->sub_cat_id = '';

			$this->form_data->attr_status = '';

		}	

	

		function _set_attribute_rules(){

			$this->form_validation->set_rules('attr_name', 'Attribute Name', 'trim|required');
			// $this->form_validation->set_rules('cat_id[]', 'Attribute Category', 'trim|required');
			$this->form_validation->set_rules('sub_cat_id[]', 'Attribute Category', 'trim|required');
			$this->form_validation->set_rules('attr_status', 'Attribute Satus',  'trim|required');

		}

		function attrvalueslist(){

			$attributeId = $_GET['attribute'];
			$hexaId = hex2bin($attributeId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Attribute Value List';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/attrvalueslist');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			$data['attr_id'] = $id;

			$proattrname = $this->admin_model->get_attribute_byId($id)->row();
			$data['proattrname'] = $proattrname;

			$attrvalLists = $this->admin_model->get_all_attr_values($id)->result();
			$data['attrvalLists'] = $attrvalLists;

			$this->load->view('admin/attributes/attrvalueslist', $data);

		}
		function addattrvalue(){

			$attributeId = $_GET['attribute'];
			$hexaId = hex2bin($attributeId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Attribute Value';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/attributes/addattrvalue');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			$data['attr_id'] = $id;

			$this->_set_attrval_rules();
			$this->_set_attrval_fields();

			if(isset($_REQUEST['addattrval']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					// save data	
						$current = date('Y-m-d H:i:s');
						$attrvalinfo = array( 
									'attr_val_name' => $this->input->post('attr_val_name'),
									'attr_val_desc' => $this->input->post('attr_val_desc'),
									'attr_id' => $this->input->post('attr_id'),
									'attr_val_status' => $this->input->post('attr_val_status'),
									'attr_val_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
										
							
						$addattrval = $this->admin_model->add_attr_value($attrvalinfo);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Attribute Value Added successfully.</p>');

						$encodeId = base64_encode($this->input->post('attr_id'));
						$hexaId = bin2hex($encodeId);

						//redirect('admin/attributes/attrvalueslist?attribute');
						redirect(base_url()."admin/attributes/attrvalueslist?attribute=".$hexaId);
				}	
			}

			$this->load->view('admin/attributes/addattrvalue', $data);

		}

		public function deleteattrvalue($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Attribute Value';
			$attrvalinfo = array( 
									'attr_val_deleted' => '1',
								);
			$id = $this->admin_model->delete_attr_value($attrvalinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Attribute Value Deleted Successfully.</div>');
			redirect($_SERVER['HTTP_REFERER']);
		}

		function _set_attrval_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->attr_val_name = '';

			$this->form_data->attr_id = '';

			$this->form_data->attr_val_status = '';

		}	

	
		function _set_attrval_rules(){

			$this->form_validation->set_rules('attr_val_name', 'Attribute Value Name', 'trim|required');
			$this->form_validation->set_rules('attr_id', 'Attribute', 'trim|required');
			$this->form_validation->set_rules('attr_val_status', 'Attribute Value Satus',  'trim|required');

		}		
}
?>

