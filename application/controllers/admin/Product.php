<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
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
			$data['title'] = 'Products';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$productLists = $this->admin_model->get_all_products();
			$data['productLists'] = $productLists;

			$this->load->view('admin/product/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Product';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/product/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_parent_categories()->result();
			$data['parCatLists'] = $parCatLists;
			// // print_r($parCatLists);
			// // die;

			// $catLists = $this->admin_model->get_categories()->result();
			// $data['catLists'] = $catLists;
			// print_r($catLists);
			// die;

			$this->_set_product_rules_add();
			$this->_set_product_fields();

			if(isset($_REQUEST['addproduct']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						
						$pro_img	 = $_FILES['pro_img']['name'];
						if($pro_img != '')
						{
							$config['upload_path'] = './assets/product-img/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 550;
							$this->load->library('upload', $config);
							$pro_img = "pro_img";
							if (!$this->upload->do_upload($pro_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$pro_slug = $this->slug($this->input->post('pro_name'));
								$cat_id = $this->input->post('cat_id');
								$pro_img_data = array('upload_data' => $this->upload->data());
								$productinfo = array( 
											'pro_name' => $this->input->post('pro_name'),
											'pro_slug' => $pro_slug,
											'pro_img' => $pro_img_data['upload_data']['file_name'],
											'par_id' => $this->input->post('par_id'),
											'cat_id' => $cat_id,
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'amazon_link' => $this->input->post('amazon_link'),
											'pro_status' => $this->input->post('pro_status'),
											'vorder' => $this->input->post('vorder'),
											'pro_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
								$addproduct = $this->admin_model->add_product($productinfo);

								$sub_cat_id = $this->input->post('sub_cat_id');

								for($i=0;$i<count($sub_cat_id);$i++){

									$productsubcategoryinfo = array( 
											'pro_id' => $addproduct,
											'sub_cat_id' => $sub_cat_id[$i],
										);

									$addproductsubcategory = $this->admin_model->add_product_sub_category($productsubcategoryinfo);

								}

								$productCategoryInfo = array( 
									'pro_id' => $addproduct,
									'cat_id' => $cat_id,
								);

								$addProductCategoryInfo = $this->admin_model->add_product_category($productCategoryInfo);


								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product Added successfully.</p>');
								redirect('admin/product');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$cat_id = $this->input->post('cat_id');
							$pro_slug = $this->slug($this->input->post('pro_name'));
							$productinfo = array( 
											'pro_name' => $this->input->post('pro_name'),
											'pro_slug' => $pro_slug,
											'par_id' => $this->input->post('par_id'),
											'cat_id' => $cat_id,
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'amazon_link' => $this->input->post('amazon_link'),
											'pro_status' => $this->input->post('pro_status'),
											'vorder' => $this->input->post('vorder'),
											'pro_created' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
							$addproduct = $this->admin_model->add_product($productinfo);

							$sub_cat_id = $this->input->post('sub_cat_id');

							for($i=0;$i<count($sub_cat_id);$i++){

								$productsubcategoryinfo = array( 
										'pro_id' => $addproduct,
										'sub_cat_id' => $sub_cat_id[$i],
									);

								$addproductsubcategory = $this->admin_model->add_product_sub_category($productsubcategoryinfo);

							}

							$productCategoryInfo = array( 
								'pro_id' => $addproduct,
								'cat_id' => $cat_id,
							);

							$addProductCategoryInfo = $this->admin_model->add_product_category($productCategoryInfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product Added successfully.</p>');
							redirect('admin/product');
						}	
				}
			}	

			$this->load->view('admin/product/add', $data);
		}

		public function edit()
		{
			$productId = $_GET['product'];
			$hexaId = hex2bin($productId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Product';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/product/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$parCatLists = $this->admin_model->get_parent_categories()->result();
			$data['parCatLists'] = $parCatLists;

			$prosubcatLists = $this->admin_model->get_all_pro_sub_categories_array($id);
			$data['prosubcatLists'] = $prosubcatLists;

			$proCatLists = $this->admin_model->get_all_pro_categories_array($id);
			$data['proCatLists'] = $proCatLists;

			$productInfo = $this->admin_model->get_product_byId($id)->row();

			$catLists = $this->admin_model->get_categories_by_parId($productInfo->par_id)->result();
			$data['catLists'] = $catLists;

			$subcateLists = $this->admin_model->get_sub_category_bycatId($productInfo->cat_id)->result();
			$data['subcateLists'] = $subcateLists;

			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->pro_name = $productInfo->pro_name;
			$this->form_data->pro_img = $productInfo->pro_img;
			$this->form_data->meta_title = $productInfo->meta_title;
			$this->form_data->meta_desc = $productInfo->meta_desc;
			$this->form_data->meta_keyword = $productInfo->meta_keyword;
			$this->form_data->amazon_link = $productInfo->amazon_link;
			$this->form_data->pro_status = $productInfo->pro_status;
			$this->form_data->vorder = $productInfo->vorder;
			$this->form_data->cat_id = $productInfo->cat_id;
			$this->form_data->par_id = $productInfo->par_id;

			$this->_set_product_rules();

			if(isset($_REQUEST['editproduct']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
						
						$pro_img	 = $_FILES['pro_img']['name'];
						if($pro_img != '')
						{
							$config['upload_path'] = './assets/product-img/';
							$config['allowed_types'] = 'jpg|png';
							$config['max_size']	= 550;
							$this->load->library('upload', $config);
							$pro_img = "pro_img";
							if (!$this->upload->do_upload($pro_img))
							{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata('message', '<div id="alert" class="alert alert-danger">'.$error['error'].'</div>');
							}
							else
							{
								// save data	
								$current = date('Y-m-d H:i:s');
								$cat_id = $this->input->post('cat_id');
								$pro_img_data = array('upload_data' => $this->upload->data());
								$productinfo = array( 
											'pro_name' => $this->input->post('pro_name'),
											'pro_img' => $pro_img_data['upload_data']['file_name'],
											'par_id' => $this->input->post('par_id'),
											'cat_id' => $cat_id,
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'amazon_link' => $this->input->post('amazon_link'),
											'pro_status' => $this->input->post('pro_status'),
											'vorder' => $this->input->post('vorder'),
											'pro_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								$editproduct = $this->admin_model->edit_product($productinfo, $id);

								$this->admin_model->delete_product_sub_categories($id);

								$sub_cat_id = $this->input->post('sub_cat_id');

								for($i=0;$i<count($sub_cat_id);$i++){

									$productsubcategoryinfo = array( 
											'pro_id' => $id,
											'sub_cat_id' => $sub_cat_id[$i],
										);

									$addproductsubcategory = $this->admin_model->add_product_sub_category($productsubcategoryinfo);

								}

								$productCategoryInfo = array( 
									'pro_id' => $id,
									'cat_id' => $cat_id,
								);
	
								$addProductCategoryInfo = $this->admin_model->add_product_category($productCategoryInfo);

								// set user message
								$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product updated successfully.</p>');
								redirect('admin/product');
							}	
						}
						else
						{
							// save data	
							$current = date('Y-m-d H:i:s');
							$cat_id = $this->input->post('cat_id');
							$productinfo = array( 
											'pro_name' => $this->input->post('pro_name'),
											'par_id' => $this->input->post('par_id'),
											'cat_id' => $cat_id,
											'meta_title' => $this->input->post('meta_title'),
											'meta_desc' => $this->input->post('meta_desc'),
											'meta_keyword' => $this->input->post('meta_keyword'),
											'amazon_link' => $this->input->post('amazon_link'),
											'pro_status' => $this->input->post('pro_status'),
											'vorder' => $this->input->post('vorder'),
											'pro_updated' => date('Y-m-d H:i:s', strtotime($current)),
										);
											
								
							$editproduct = $this->admin_model->edit_product($productinfo, $id);

							$this->admin_model->delete_product_sub_categories($id);

							$sub_cat_id = $this->input->post('sub_cat_id');

								for($i=0;$i<count($sub_cat_id);$i++){

									$productsubcategoryinfo = array( 
											'pro_id' => $id,
											'sub_cat_id' => $sub_cat_id[$i],
										);

									$addproductsubcategory = $this->admin_model->add_product_sub_category($productsubcategoryinfo);

								}

								$productCategoryInfo = array( 
									'pro_id' => $id,
									'cat_id' => $cat_id,
								);
	
								$addProductCategoryInfo = $this->admin_model->add_product_category($productCategoryInfo);

							// set user message
							$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product updated successfully.</p>');
							redirect('admin/product');
						}	
				}
			}

			$this->load->view('admin/product/edit', $data);
		}	

		public function deleteproduct($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Product';
			$productinfo = array( 
									'pro_deleted' => '1',
								);
			$id = $this->admin_model->delete_product($productinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Product Deleted Successfully.</div>');
			redirect('admin/product');
		}

		function _set_product_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->pro_name = '';

			$this->form_data->par_id = '';

			$this->form_data->cat_id = '';

			$this->form_data->sub_cat_id = '';

			$this->form_data->pro_img = '';

			$this->form_data->meta_title = '';

			$this->form_data->meta_desc = '';

			$this->form_data->meta_keyword = '';

			$this->form_data->amazon_link = '';

			$this->form_data->pro_status = '';
			
			$this->form_data->vorder = '';

		}

		function _set_product_rules_add(){

			$this->form_validation->set_rules('pro_name', 'Product Name', 'trim|required|is_unique[product.pro_name]');
			$this->form_validation->set_rules('par_id', 'Product Parent Category', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Product Category', 'trim|required');
			$this->form_validation->set_rules('sub_cat_id[]', 'Product Sub Category', 'trim|required');
			$this->form_validation->set_rules('pro_status', 'Product Satus',  'trim|required');

		}
	
		function _set_product_rules(){

			$this->form_validation->set_rules('pro_name', 'Product Name', 'trim|required');
			$this->form_validation->set_rules('par_id', 'Product Parent Category', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Product Category', 'trim|required');
			$this->form_validation->set_rules('sub_cat_id[]', 'Product Sub Category', 'trim|required');
			$this->form_validation->set_rules('pro_status', 'Product Satus',  'trim|required');

		}

		public function get_categories_by_parent() {
			$par_id = $this->input->post("par_id");
			$categories = $this->admin_model->get_categories_by_parId($par_id)->result_array();
			$options = "<option selected disabled value=''>Select Category</option>";
			foreach ($categories as $category) {
				$options .= "<option value='" . $category['cat_id'] . "'>" . $category['cat_name'] . "</option>";
			}
			echo $options;
		}		

		function get_sub_category(){

			$cat_id = $this->input->post("cat_id");
			$subcateInfo = $this->admin_model->get_sub_category_bycatId($cat_id)->result_array();
            $option ="<option selected disabled value=''>Select Sub Category</option>";
              foreach($subcateInfo as $row)
              {
                 $option.="<option value='".$row['sub_cat_id']."'>".$row['sub_cat_name']."</option>";
              }
               echo $option;
		}

		function gallery(){

			$productId = $_GET['product'];
			$hexaId = hex2bin($productId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Product Gallery';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/product/gallery');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$imagesLists = $this->admin_model->get_product_gallery_byproduct($id)->result();
			$data['imagesLists'] = $imagesLists;

			if(isset($_REQUEST['updategallery']))
			{
				$fileAttachments = $this->input->post('ticket[]');
				if(isset($fileAttachments)){
			  	$filesCount = count($fileAttachments);
			 	//print_r($fileAttachments);
					foreach ($fileAttachments as $key => $value) {
					 	$fileAttachments = array( 
										'pro_id' => $id,
										'pro_glry_img' =>$value
								);
					 	$this->admin_model->add_product_gallery($fileAttachments);
					 }

					 $this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product Gallery updated successfully.</p>');
							redirect('admin/product');
				 }
			}

			$this->load->view('admin/product/gallery', $data);
		}

		public function deleteproductgalleryimg($id = '')
		{
			$hexaId = hex2bin($id);
			$imgid = base64_decode($hexaId);
			$data['title'] = 'Delete Product Gallery';
			$this->admin_model->delete_product_gallery($imgid);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Product Image Deleted Successfully.</div>');
			redirect($_SERVER['HTTP_REFERER']);
		}

		// File upload
  	public function fileUpload(){
	   if(!empty($_FILES['file']['name'])){
	     // Set preference
	     $config['upload_path'] = './assets/product-img/';
	     $config['allowed_types'] = 'jpg|jpeg|png';
	     $config['max_size'] = '1024'; // max_size in kb
	     $config['file_name'] = $_FILES['file']['name'];

	     //Load upload library
	     $this->load->library('upload',$config); 


		//$this->load->library('upload', $config);
        $this->upload->initialize($config);
        if($this->upload->do_upload('file')){

            //echo $this->upload->data("file_name");
            $file_name = $this->upload->data("file_name");

            //echo $name = uniqid() . '_' . trim($file_name);
            echo $name = trim($file_name);

       		//$file->move($path, $name);
           
        }
       
	     
	   }

	 }
	 function feature(){

			$productId = $_GET['product'];
			$hexaId = hex2bin($productId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Product Feature';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/product/feature');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$profeatureLists = $this->admin_model->get_all_pro_features_array($id);
			$data['profeatureLists'] = $profeatureLists;

			$featureLists = $this->admin_model->get_all_features()->result();
			$data['featureLists'] = $featureLists;

			if(isset($_REQUEST['updatefeature']))
			{
					$features = $this->input->post('features[]');
					if(isset($features)){
						$this->admin_model->delete_product_feature($id);
						foreach ($features as $key => $value) {
					 	$productfeatures = array( 
										'pro_id' => $id,
										'feat_id' =>$value
								);
					 	$this->admin_model->add_product_feature($productfeatures);
					 }

					 $this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product Feature updated successfully.</p>');
							redirect($_SERVER['HTTP_REFERER']);
					}	
			}


			$this->load->view('admin/product/feature', $data);
	}
	function attribute(){

			$productId = $_GET['product'];
			$hexaId = hex2bin($productId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Product Attributes';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/product/feature');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$proattributeLists = $this->admin_model->get_all_pro_attributes_array($id);
			$data['proattributeLists'] = $proattributeLists;
			// print_r($proattributeLists);
			// die;

			$attributeLists = $this->admin_model->get_pro_attribute_backend($id)->result();
			$data['attributeLists'] = $attributeLists;

			$attributevalueLists = $this->admin_model->get_attributes_values($id)->result();
			$data['attributevalueLists'] = $attributevalueLists;
			// print_r($attributevalueLists);
			// die;

			if(isset($_REQUEST['updateattribute']))
			{
					$attributes = $this->input->post('attributes[]');
					if(isset($attributes)){
						$this->admin_model->delete_pro_attr_values_byproid($id);
						foreach ($attributes as $key => $value) {
					 	$productattributes = array( 
										'pro_id' => $id,
										'attr_val_id' =>$value
								);
								// print_r($productattributes);
								// die;
					 	$this->admin_model->add_pro_attr_values($productattributes);
					 }

					 $this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product Attributes updated successfully.</p>');
							redirect($_SERVER['HTTP_REFERER']);
					}	
			}


			$this->load->view('admin/product/attribute', $data);
	}	
	function specification(){

			$productId = $_GET['product'];
			$hexaId = hex2bin($productId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Product Technical Specification';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/product/specification');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$speciInfo = $this->admin_model->get_product_specification_byId($id)->row();
			$data['speciInfo'] = $speciInfo;

			if(isset($_REQUEST['updatespecification']))
			{
					$specification = $this->input->post('specification');
					if(isset($specification)){
						$this->admin_model->delete_product_specification($id);
						
					 	$productspecification = array( 
										'pro_id' => $id,
										'specification' =>$this->input->post('specification')
								);
					 	$this->admin_model->add_product_specification($productspecification);


					 $this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product Technical Specification updated successfully.</p>');
							redirect($_SERVER['HTTP_REFERER']);
					}	
			}


			$this->load->view('admin/product/specification', $data);
	}

	public function import()
	{
		$this->admin_model->isset_admin_user();
		$data['title'] = 'Import Products';
		$data['desc'] = '';
		$data['loggedin'] = '';
		$data['action'] = site_url('admin/product/import');
		$data['typeback'] = '';
		$adminSession = $this->session->userdata('adminSession');

		if(isset($_FILES['import_file']) && $_FILES['import_file']['error'] == 0)
		{
			// Load PhpSpreadsheet
			$file = $_FILES['import_file']['tmp_name'];

			$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
			$worksheet = $spreadsheet->getActiveSheet();
			$data = $worksheet->toArray();
			// print_r($data);
			// die;

			foreach ($data as $key => $row) {
				if ($key == 0) continue; // Skip header row

				// Assuming pro_slug is in the 7th column and pro_img is in the 8th column
				$pro_slug = $row[8];
				$pro_img = $row[7];

				$productData = array(
					'pro_name' => $row[0],
					'cat_id' => $row[1],
					'meta_title' => $row[2],
					'meta_desc' => $row[3],
					'meta_keyword' => $row[4],
					'pro_status' => $row[5],
					'vorder' => $row[6],
					'pro_slug' => $pro_slug,
					'pro_img' => $pro_img,
					'pro_created' => date('Y-m-d H:i:s'),
				);

				// Add product
				$pro_id = $this->admin_model->add_product($productData);
			
				// Handle subcategories
				$subcategories = explode(',', $row[9]);
				foreach ($subcategories as $sub_cat_id) {
					$productSubCategoryData = array(
						'pro_id' => $pro_id,
						'sub_cat_id' => trim($sub_cat_id),
					);
					$this->admin_model->add_product_sub_category($productSubCategoryData);
				}

				// Handle features
				$features = explode(',', $row[10]);
				foreach ($features as $feature_id) {
					$productFeatureData = array(
						'pro_id' => $pro_id,
						'feat_id' => trim($feature_id),
					);
					$this->admin_model->add_product_feature($productFeatureData);
				}

				// Handle attributes
				$attributes = explode(',', $row[11]);
				foreach ($attributes as $attr_val_id) {
					$productAttributeData = array(
						'pro_id' => $pro_id,
						'attr_val_id' => trim($attr_val_id),
					);
					$this->admin_model->add_pro_attr_values($productAttributeData);
				}

				// Handle specifications
				$specifications = $row[12];
				if (!empty($specifications)) {
					$productSpecificationData = array(
						'pro_id' => $pro_id,
						'specification' => $specifications,
					);
					$this->admin_model->add_product_specification($productSpecificationData);
				}

				// Handle gallery
				$galleryImages = explode(',', $row[13]);
				foreach ($galleryImages as $image) {
					$galleryData = array(
						'pro_id' => $pro_id,
						'pro_glry_img' => trim($image),
					);
					$this->admin_model->add_product_gallery($galleryData);
				}
				// Handle Product Description
				// $productDescription = explode(',', $row[14]);
				// if (!empty($productDescription)) {
				// 	$productDescriptionData = array(
				// 		'pro_id' => $pro_id,
				// 		'description' => $productDescription,
				// 	);
				// 	$this->admin_model->add_product_description($productDescriptionData);
				// }
				$productDescription = explode(',', $row[14]);
					if (!empty($productDescription)) {
						// Convert the array to a string
						$productDescriptionString = implode(', ', $productDescription);
						
						$productDescriptionData = array(
							'pro_id' => $pro_id,
							'description' => $productDescriptionString,
						);
						$this->admin_model->add_product_description($productDescriptionData);
                }

			}

			$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Products imported successfully.</p>');
			redirect('admin/product');
		}

		$this->load->view('admin/product/import', $data);
	}

	function description(){

		$productId = $_GET['product'];
		$hexaId = hex2bin($productId);
		$id = base64_decode($hexaId);	
		$this->admin_model->isset_admin_user();
		$data['title'] = 'Product Description';
		$data['desc'] = '';
		$data['loggedin'] = '';
		$data['action'] = site_url('admin/product/description');
		$data['typeback'] = '';
		$adminSession = $this->session->userdata('adminSession');

		$descInfo = $this->admin_model->get_product_description_byId($id)->row();
		$data['descInfo'] = $descInfo;

		if(isset($_REQUEST['updatedescription']))
		{
				$description = $this->input->post('description');
				if(isset($description)){
					$this->admin_model->delete_product_description($id);
					
					 $productdescription = array( 
									'pro_id' => $id,
									'description' =>$this->input->post('description')
							);
					 $this->admin_model->add_product_description($productdescription);


				 $this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Product Description updated successfully.</p>');
						redirect($_SERVER['HTTP_REFERER']);
				}	
		}

		$this->load->view('admin/product/description', $data);
    }

	public function slug($string, $spaceRepl = "-")
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