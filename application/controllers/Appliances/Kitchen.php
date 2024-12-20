<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kitchen extends CI_Controller {

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
		$catid = 7;
		$cateInfo = $this->admin_model->get_category_byId($catid)->row();
		if (!$cateInfo) {
			show_404(); // Show 404 if no category information is found
			// return; // Ensure the script execution stops after showing 404
		}
		$data['cateInfo'] = $cateInfo;
		
		$data['title'] = $cateInfo->meta_title;
		$data['desc'] = $cateInfo->meta_desc;
		$data['keyword'] = $cateInfo->meta_keyword;
		$data['loggedin'] = '';
		
		
		$subcat_hob = 10;
		$subcat_induction = 10;
		$subcat_chimney = 10;
		$subcat_cooktop = 10;

		$subcat_hobInfo = $this->admin_model->get_sub_category_byId($subcat_hob)->row();
		$data['subcat_hobInfo'] = $subcat_hobInfo;
		$subcat_inductionInfo = $this->admin_model->get_sub_category_byId($subcat_induction)->row();
		$data['subcat_inductionInfo'] = $subcat_inductionInfo;
		$subcat_chimneyInfo = $this->admin_model->get_sub_category_byId($subcat_chimney)->row();
		$data['subcat_chimneyInfo'] = $subcat_chimneyInfo;
		$subcat_cooktopInfo = $this->admin_model->get_sub_category_byId($subcat_cooktop)->row();
		$data['subcat_cooktopInfo'] = $subcat_cooktopInfo;

		

		$catalogLists = $this->admin_model->get_catalogs()->result();
		$data['catalogLists'] = $catalogLists;

		$reasonLists = $this->admin_model->get_all_reasons()->result();
		$data['reasonLists'] = $reasonLists;

		$videoLists = $this->admin_model->get_all_innov_videos()->result();
		$data['videoLists'] = $videoLists;

		$testimonialLists = $this->admin_model->get_testis()->result();
		$data['testimonialLists'] = $testimonialLists;

		$blogLists = $this->admin_model->get_blogs()->result();
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

		$this->load->view('appliances/kitchen/index', $data);
	}	
	public function category($slug)
	{
		$subcatslug = $slug;
		$subcateInfo = $this->admin_model->get_sub_category_byslug($slug)->row();
		$data['subcateInfo'] = $subcateInfo;
		$subcatID = $subcateInfo->sub_cat_id;
		$par_id = 3;
		$catID = 7; 
		$kitchencatslug = "kitchen";
		$data['kitchencatslug'] = $kitchencatslug;

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

		$videoLists = $this->admin_model->get_all_innov_videos()->result();
		$data['videoLists'] = $videoLists;

		$catalogLists = $this->admin_model->get_catalogs()->result();
		$data['catalogLists'] = $catalogLists;

		$testimonialLists = $this->admin_model->get_testis()->result();
		$data['testimonialLists'] = $testimonialLists;

		$blogLists = $this->admin_model->get_blogs()->result();
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

			    curl_setopt($curl, CURLOPT_URL,"https://stag.inframarket.cloud/lead/enquiry/integrations/v1");
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

		$this->load->view('appliances/kitchen/category', $data);
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
