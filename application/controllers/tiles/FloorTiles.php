<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FloorTiles extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		
		// load helper
		$this->load->library(array('table','form_validation', 'email'));
		$this->load->helper('url');
		$this->load->helper('sendgrid');
		$this->load->library('session');
		// load model
		$this->load->model('admin_model','',TRUE);
		
	}
	public function index()
	{
		//$this->admin_model->isset_common_user();
		$catid = 14;
		$cateInfo = $this->admin_model->get_category_byId($catid)->row();
		if (!$cateInfo) {
			// Subcategory not found, show 404 error
			show_404();
		}
		$data['cateInfo'] = $cateInfo;

		$data['title'] = $cateInfo->meta_title;
		$data['desc'] = $cateInfo->meta_desc;
		$data['keyword'] = $cateInfo->meta_keyword;
		$data['loggedin'] = '';
		
		$subcat_tpw = 19;
		$subcat_bldc = 19;
		$subcat_celling = 19;
		$subcat_ventilation = 19;
		$subcat_decorative = 19;
		$subcat_tpwInfo = $this->admin_model->get_sub_category_byId($subcat_tpw)->row();
		$data['subcat_tpwInfo'] = $subcat_tpwInfo;
		$subcat_bldcInfo = $this->admin_model->get_sub_category_byId($subcat_bldc)->row();
		$data['subcat_bldcInfo'] = $subcat_bldcInfo;
		$subcat_cellingInfo = $this->admin_model->get_sub_category_byId($subcat_celling)->row();
		$data['subcat_cellingInfo'] = $subcat_cellingInfo;
		$subcat_ventilationInfo = $this->admin_model->get_sub_category_byId($subcat_ventilation)->row();
		$data['subcat_ventilationInfo'] = $subcat_ventilationInfo;
		$subcat_decorativeInfo = $this->admin_model->get_sub_category_byId($subcat_decorative)->row();
		$data['subcat_decorativeInfo'] = $subcat_decorativeInfo;

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
								'inq_city' =>  $this->input->post('inq_city'),
								'inq_category' =>  $this->input->post('inq_category'),
								'inq_message'  =>  $this->input->post('inq_message'),
								'inq_created' => date('Y-m-d H:i:s', strtotime($current)),
							);

				$this->admin_model->add_inquiry($inquiryInfo);

				// Get the current timestamp in UTC timezone
     			$current_timestamp = new DateTime('now', new DateTimeZone('UTC'));
     			// Format the timestamp in the required format
    			 $formatted_timestamp = $current_timestamp->format('Y-m-d\TH:i:s\Z');
				$apidata = array(
						            'unique_id'      => uniqid(),
						            'name'      => $this->input->post('inq_name'),
						            'message' => $this->input->post('inq_message'),
						            'contact_info' => array(
						            	'email_id'      => $this->input->post('inq_email'),
						            	'mobile_no'      => $this->input->post('inq_phone')
						            ),
						            'product_infos' => [array(
						            	'category'      => $this->input->post('inq_category')
						            )],
						            'address_info' => array(
						            	'city'      => $this->input->post('inq_city')
						            ),
						            'created_timestamp'    => $formatted_timestamp
						    );
				
				$apidata_string = json_encode($apidata);
				$apienquirydata = array('enquiry' => $apidata_string);
				//print_r($apienquirydata);

				$curl = curl_init();

			    curl_setopt($curl, CURLOPT_URL,"https://api.inframarket.cloud/lead/enquiry/integrations/v1");
				curl_setopt($curl, CURLOPT_POST, 1);

			    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			    'Content-Type: multipart/form-data',
			    'x-api-key: MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCOYhK8UR5IyTqjSXj5dqEhdGVytn8rv7JMHhxXVcehX943lvF1Q+xZOAYlZ/ucMHTZa0EZpJ37JNm71nezsdYvtg2U3SId1uS6Wq+BSCzV03vPp3w2h78zL9kBSFA7XdYF+AaW+sYMX2YR2X0KK16BekqRDQtx/43fOE2wxLqRvQIDAQAB',
			    'x-api-secret-key: JF+U+ETXm38uK0VzAaksFNz1uyp9Yu52ZW8ORKAolYZIy7FS1WWHqpgAT7bs3APs1jtM8zWFc6UWEz96JUaJ/BCUB2EMQGafEd3/ayoQdB1495U0FsJy8IkCJpHTN9T4onuES95dEIzS1YrUkSKhcsRPPrp5atu7bSD8q4vy2Gs=')
			    );

			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
			    curl_setopt($curl, CURLOPT_POSTFIELDS, $apienquirydata);  // Insert the data

			    // Send the request
			    $result = curl_exec($curl);

			    // Free up the resources $curl is using
			    curl_close($curl);
			    //echo $result;
			    $dataresult = json_decode($result);
			    //print_r($dataresult);
			    if($dataresult->success)
				{	            

				$category = strip_tags(addslashes($_POST['inq_category']));
			    $name = strip_tags(addslashes($_POST['inq_name']));
			    $phone = strip_tags(addslashes($_POST['inq_phone']));
			    // $emails = strip_tags(addslashes($email));
			    $emails = strip_tags(addslashes($_POST['inq_email']));
			    $city = strip_tags(addslashes($_POST['inq_city']));
			    $msg = strip_tags(addslashes($_POST['inq_message']));

				$to = $emails;
       			$subject = "Thank You for contacting us | $name ";
        		$message = "<div style=' width:94%; max-width:800px; margin:0 auto; border:1px solid #EFEFEF;'><div style=' width:90%; padding:10px 5%; background:#fff; text-align:left;'><img src='https://staging.ivas.homes/images/logo.png' style='width: '></div><div style='font-size:13px; color:#000; text-align:left; line-height:20px; background:#fff; width: 90%; padding:5%; font-family:Arial, Helvetica, sans-serif;'><p>Dear $name ,</p><p>Thank you for taking the time to fill out the form. We value your interest in our products. Our team will get in touch with you shortly to understand your requirements.</p><br /><p>Regards,<br />IVAS</p></div></div>";
        		$inquiry_mail_sent = send_email($to, $subject, $message);

				

				if(!$inquiry_mail_sent)
				{
					$this->session->set_flashdata('frmmessage','<div id="alert" class="alert alert-danger">There was an error, please try again!</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$this->session->set_flashdata('frmmessage','<div id="alert" class="alert alert-success text-center">Thank You. Mail Sent Successfully.</div>');
					//redirect($_SERVER['HTTP_REFERER']);
					if(isset($_SERVER['HTTPS'])){
        			$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
				    }
				    else{
				        $protocol = 'http';
				    }
				    $rsurl = $protocol . "://" . $_SERVER['HTTP_HOST'] ."/thank-you";
				    redirect($rsurl);
				}
				}else{

					$this->session->set_flashdata('frmmessage','<div id="alert" class="alert alert-danger">There was an error, please try again!</div>');
					redirect($_SERVER['HTTP_REFERER']);
				}	
			}	
		}

		// log_message('debug', 'Loading view file: tiles/floortiles/index.php');

		$this->load->view('tiles/floorTiles/index', $data);
	}
	public function category($slug)
	{
		$subcatslug = $slug;
		$subcateInfo = $this->admin_model->get_sub_category_byslug($slug)->row();
		// Check if subcategory exists
		if (!$subcateInfo) {
			// Subcategory not found, show 404 error
			show_404();
		}
		$data['subcateInfo'] = $subcateInfo;
		$subcatID = $subcateInfo->sub_cat_id;
		$par_id = 6;
		$catID = 14; 
		$floortilesslug = "floor-tiles";
		$data['floortilesslug'] = $floortilesslug;

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

		$this->load->view('tiles/floorTiles/category', $data);
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
	function _set_inquiry_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->inq_name = '';

			$this->form_data->inq_email = '';

			$this->form_data->inq_phone = '';

			$this->form_data->inq_city = '';

			$this->form_data->inq_category = '';
	}	

	function _set_inquiry_rules(){

			$this->form_validation->set_rules('inq_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('inq_email', 'Email', 'trim|required');
			$this->form_validation->set_rules('inq_phone', 'Phone No', 'trim|required');
			$this->form_validation->set_rules('inq_city', 'City', 'trim|required');
			$this->form_validation->set_rules('inq_category', 'Category', 'trim|required');

	}

}
