<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModularKitchen extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		
		// load helper
		$this->load->library(array('table','form_validation', 'email'));
		$this->load->helper('url');
		$this->load->library('session');
		// load model
		$this->load->model('admin_model','',TRUE);
		
	}
	public function index()
	{
		//$this->admin_model->isset_common_user();
		$catid = 20;
		$cateInfo = $this->admin_model->get_category_byId($catid)->row();
		$data['cateInfo'] = $cateInfo;

		$data['title'] = $cateInfo->meta_title;
		$data['desc'] = $cateInfo->meta_desc;
		$data['keyword'] = $cateInfo->meta_keyword;
		$data['loggedin'] = '';
		
		$subcat_esn = 24;
		$subcat_car = 24;
		$subcat_cal = 24;
		$subcat_mul = 24;
		$subcat_sol = 24;
		$subcat_esnInfo = $this->admin_model->get_sub_category_byId($subcat_esn)->row();
		$data['subcat_esnInfo'] = $subcat_esnInfo;
		$subcat_carInfo = $this->admin_model->get_sub_category_byId($subcat_car)->row();
		$data['subcat_carInfo'] = $subcat_carInfo;
		$subcat_calInfo = $this->admin_model->get_sub_category_byId($subcat_cal)->row();
		$data['subcat_calInfo'] = $subcat_calInfo;
		$subcat_mulInfo = $this->admin_model->get_sub_category_byId($subcat_mul)->row();
		$data['subcat_mulInfo'] = $subcat_mulInfo;
		$subcat_solInfo = $this->admin_model->get_sub_category_byId($subcat_sol)->row();
		$data['subcat_solInfo'] = $subcat_solInfo;

		$trendLists = $this->admin_model->get_trends()->result();
		$data['trendLists'] = $trendLists;

		$catalogLists = $this->admin_model->get_catalogs()->result();
		$data['catalogLists'] = $catalogLists;

		$reasonLists = $this->admin_model->get_all_reasons()->result();
		$data['reasonLists'] = $reasonLists;

		$testimonialLists = $this->admin_model->get_testis()->result();
		$data['testimonialLists'] = $testimonialLists;

		$blogLists = $this->admin_model->get_recent_blog_list()->result();
		$data['blogLists'] = $blogLists;

		$faqLists = $this->admin_model->get_faq_bycat($catid)->result();
		$data['faqLists'] = $faqLists;

		$this->_set_inquiry_fields();
		$this->_set_inquiry_rules();

		if(isset($_REQUEST['sendinquiry']))
		{
			if ($this->form_validation->run() == FALSE)
			{
				  	$data['message'] = '';
			}
			else
			{
				$current = date('Y-m-d H:i:s');
				$inquiryInfo =  array( 
								'inq_name' =>  $this->input->post('inq_name'),
								'inq_email' =>  $this->input->post('inq_email'),
								'inq_phone'  =>  $this->input->post('inq_phone'),
								'inq_message'  =>  $this->input->post('inq_message'),
								'inq_created' => date('Y-m-d H:i:s', strtotime($current)),
							);

				$this->admin_model->add_inquiry($inquiryInfo);

				$config = array();

				$config['protocol'] = 'smtp';
				$config['smtp_host'] = 'smtp.gmail.com';
				$config['smtp_user'] = 'e3.aoneseo@gmail.com';
				$config['smtp_pass'] = 'Aone@303#6593';
				$config['smtp_port'] = 25;
				$config['mailtype'] = 'html';
				$config['smtp_crypto'] = 'ssl';
				$config['charset'] = "utf-8";
				$config['newline'] = "\r\n";

				$this->email->initialize($config);

				$this->email->from('e3.aoneseo@gmail.com', 'Genral Inquiry - IVAS');

				$this->email->to('e3.aoneseo@gmail.com');

				$this->email->subject('Genral Inquiry - IVAS');
				$this->email->message('<p>Genral Inquiry</p>');

				$inquiry_mail_sent = $this->email->send();

				if(!$inquiry_mail_sent)
				{
					$this->session->set_flashdata('frmmessage','<div id="alert" class="alert alert-danger">There was an error, please try again!</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('frmmessage','<div id="alert" class="alert alert-success text-center">Thank You. Mail Sent Successfully.</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}	
			}	
		}

		$this->load->view('modularKitchen/index', $data);
	}
	
	function _set_inquiry_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->inq_name = '';

			$this->form_data->inq_email = '';

			$this->form_data->inq_phone = '';
	}	

	function _set_inquiry_rules(){

			$this->form_validation->set_rules('inq_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('inq_email', 'Email', 'trim|required');
			$this->form_validation->set_rules('inq_phone', 'Phone No', 'trim|required');

	}

	public function category($slug)
	{
		$subcatslug = $slug;
		$subcateInfo = $this->admin_model->get_sub_category_byslug($slug)->row();
		$data['subcateInfo'] = $subcateInfo;
		$subcatID = $subcateInfo->sub_cat_id;
		$par_id = 8;
		$catID = 20;
		$modularkitchencatslug = "modularkitchen";
		$data['modularkitchencatslug'] = $modularkitchencatslug; 

		$data['title'] = $subcateInfo->meta_title;
		$data['desc'] = $subcateInfo->meta_desc;
		$data['keyword'] = $subcateInfo->meta_keyword;
		$data['loggedin'] = '';

		// $cateLists = $this->admin_model->get_categories()->result();
		// $data['cateLists'] = $cateLists;

		//Change for getting only categories which belongs to particular parent category
		$cateLists = $this->admin_model->get_categories_by_parId($par_id)->result();
		$data['cateLists'] = $cateLists;

		$subcateLists = $this->admin_model->get_sub_category_bycatId($catID)->result();
		$data['subcateLists'] = $subcateLists;

		$attributeLists = $this->admin_model->get_attribute_bysubcat($subcatID)->result();
		$data['attributeLists'] = $attributeLists;

		$attributevalueLists = $this->admin_model->get_attributes_values_bysubcat($subcatID)->result();
		$data['attributevalueLists'] = $attributevalueLists;

		$attributevaluecount = $this->admin_model->get_attributes_values_count_bysubcat($subcatID)->result();
		//echo "<pre>";
		//print_r($attributevaluecount);
		//echo "</pre>";
		$data['attributevaluecount'] = $attributevaluecount;

		$productlist = $this->admin_model->get_products_by_subcat($subcatID)->result();
		$data['productlist'] = $productlist;

		$trendLists = $this->admin_model->get_trends()->result();
		$data['trendLists'] = $trendLists;

		$catalogLists = $this->admin_model->get_catalogs()->result();
		$data['catalogLists'] = $catalogLists;

		$testimonialLists = $this->admin_model->get_testis()->result();
		$data['testimonialLists'] = $testimonialLists;

		$blogLists = $this->admin_model->get_recent_blog_list()->result();
		$data['blogLists'] = $blogLists;

		$faqLists = $this->admin_model->get_faq_bycat($catID)->result();
		$data['faqLists'] = $faqLists;

		$this->_set_inquiry_fields();
		$this->_set_inquiry_rules();

		if(isset($_REQUEST['sendinquiry']))
		{
			if ($this->form_validation->run() == FALSE)
			{
				  	$data['message'] = '';
			}
			else
			{
				$current = date('Y-m-d H:i:s');
				$inquiryInfo =  array( 
								'inq_name' =>  $this->input->post('inq_name'),
								'inq_email' =>  $this->input->post('inq_email'),
								'inq_phone'  =>  $this->input->post('inq_phone'),
								'inq_message'  =>  $this->input->post('inq_message'),
								'inq_created' => date('Y-m-d H:i:s', strtotime($current)),
							);

				$this->admin_model->add_inquiry($inquiryInfo);

				$config = array();

				$config['protocol'] = 'smtp';
				$config['smtp_host'] = 'smtp.gmail.com';
				$config['smtp_user'] = 'e3.aoneseo@gmail.com';
				$config['smtp_pass'] = 'Aone@303#6593';
				$config['smtp_port'] = 25;
				$config['mailtype'] = 'html';
				$config['smtp_crypto'] = 'ssl';
				$config['charset'] = "utf-8";
				$config['newline'] = "\r\n";

				$this->email->initialize($config);

				$this->email->from('e3.aoneseo@gmail.com', 'Genral Inquiry - IVAS');

				$this->email->to('e3.aoneseo@gmail.com');

				$this->email->subject('Genral Inquiry - IVAS');
				$this->email->message('<p>Genral Inquiry</p>');

				$inquiry_mail_sent = $this->email->send();

				if(!$inquiry_mail_sent)
				{
					$this->session->set_flashdata('frmmessage','<div id="alert" class="alert alert-danger">There was an error, please try again!</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('frmmessage','<div id="alert" class="alert alert-success text-center">Thank You. Mail Sent Successfully.</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}	
			}	
		}

		$this->load->view('modularKitchen/category', $data);
	}

	public function filterproducts()
	{
		$subcat = $this->input->post("subcat");
		$attributes = $this->input->post("attributes[]");
		$productlist = $this->admin_model->get_products_by_filter($subcat, $attributes)->result();
		//print_r($this->db->last_query());
		$prodata ="";
		if( count($productlist) > 0 ) { 
			foreach($productlist as $key => $product)
			{
				$prodata .="<div class='col-xl-3 col-lg-3 col-md-3'>";
				$prodata .="<div class='productblk'>";
				$prodata .="<div class='productblkimg'>";
				$prodata .="<a href='".base_url()."product/".$product->pro_slug."'><img src='".base_url()."assets/product-img/".$product->pro_img."' alt='".$product->pro_name."'></a>";
				$prodata .="</div>";
				$prodata .="<div class='productblkcnt'>";
				$prodata .="<h3 class='title'>".$product->pro_name."</h3>";
				$prodata .="</div>";
				$prodata .="<div class='productblklink'>";
				$prodata .="<a href='".base_url()."product/".$product->pro_slug."'>View</a>";
				$prodata .="</div>";
				$prodata .="</div>";
				$prodata .="</div>";
			}
		echo $prodata;	
		}else {
		
		echo $prodata ="<div class='col-xl-12 col-lg-12 col-md-12'><p>No Products found.</p></div>";
		}

	}	

}
