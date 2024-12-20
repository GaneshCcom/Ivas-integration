<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

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
	public function index($slug = NULL)  // Make $slug optional
    {
        // If no slug is provided, redirect to custom 404 page
        if ($slug === NULL) {
            show_404();
        }
		$productslug = $slug;
		$productInfo = $this->admin_model->get_product_byslug($slug)->row();
		// Check if subcategory exists
		if (!$productInfo) {
			// Subcategory not found, show 404 error
			show_404();
		}
		$data['productInfo'] = $productInfo;
		$productID = $productInfo->pro_id;
		$catID = $productInfo->cat_id;

		$data['title'] = $productInfo->meta_title;
		$data['desc'] = $productInfo->meta_desc;
		$data['keyword'] = $productInfo->meta_keyword;
		$data['loggedin'] = '';


		$cateInfo = $this->admin_model->get_category_byId($catID)->row();
		$data['cateInfo'] = $cateInfo;

		$subcateLists = $this->admin_model->get_sub_categories_byproduct($productID)->result();
		$data['subcateLists'] = $subcateLists;

		$subcatID = count($subcateLists) > 0 ? $subcateLists[0]->sub_cat_id : null;


		$imagesLists = $this->admin_model->get_product_gallery_byproduct($productID)->result();
		$data['imagesLists'] = $imagesLists;

		$proattributeLists = $this->admin_model->get_all_pro_attributes_array($productID);
		$data['proattributeLists'] = $proattributeLists;

		$attributeLists = $this->admin_model->get_pro_attribute($productID)->result();
		$data['attributeLists'] = $attributeLists;

		$attributevalueLists = $this->admin_model->get_attributes_values($productID)->result();
		$data['attributevalueLists'] = $attributevalueLists;

		$speciInfo = $this->admin_model->get_product_specification_byId($productID)->row();
		$data['speciInfo'] = $speciInfo;

		$descInfo = $this->admin_model->get_product_description_byId($productID)->row();
		$data['descInfo'] = $descInfo;

		$profeatureLists = $this->admin_model->get_all_pro_features($productID)->result();
		$data['profeatureLists'] = $profeatureLists;

		// $productlist = $this->admin_model->get_related_products_by_cat($catID, $productID)->result();
		// $data['productlist'] = $productlist;

		$productlist = $this->admin_model->get_related_products_by_subcat($subcatID, $productID)->result();
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

		//$this->_set_inquiry_fields();
		//$this->_set_inquiry_rules();

		if(isset($_REQUEST['sendinquiry']))
		{
			$this->_set_inquiry_fields();
			$this->_set_inquiry_rules();
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


		//$this->_set_pro_inquiry_fields();
		//$this->_set_pro_inquiry_rules();

		if(isset($_REQUEST['prosendinquiry']))
		{
			$this->_set_pro_inquiry_fields();
			$this->_set_pro_inquiry_rules();
			if ($this->form_validation->run() == FALSE)
			{
				  	// $data['message'] = '';
					  $data['form_error'] = true; 
					//   $data['message'] = 'Please fill in all required fields correctly.';
					//   $this->session->set_flashdata('frmmessage', '<div id="alert" class="alert alert-danger">' . validation_errors() . '</div>');
					//   $this->load->view('product/index', $data);
			}
			else
			{
				$current = date('Y-m-d H:i:s');
				$inquiryInfo =  array( 
								'pro_id' =>  $productID,
								'inq_name' =>  $this->input->post('pro_inq_name'),
								'inq_email' =>  $this->input->post('pro_inq_email'),
								'inq_phone'  =>  $this->input->post('pro_inq_phone'),
								'inq_city' =>  $this->input->post('pro_inq_city'),
								'inq_category' =>  $this->input->post('pro_inq_category'),
								'inq_message'  =>  $this->input->post('pro_inq_message'),
								'inq_created' => date('Y-m-d H:i:s', strtotime($current)),
							);

				$this->admin_model->add_inquiry($inquiryInfo);

				// Get the current timestamp in UTC timezone
     			$current_timestamp = new DateTime('now', new DateTimeZone('UTC'));
     			// Format the timestamp in the required format
    			 $formatted_timestamp = $current_timestamp->format('Y-m-d\TH:i:s\Z');
				$apidata = array(
						            'unique_id'      => uniqid(),
						            'name'      => $this->input->post('pro_inq_name'),
						            'message' => $this->input->post('pro_inq_message'),
						            'contact_info' => array(
						            	'email_id'      => $this->input->post('pro_inq_email'),
						            	'mobile_no'      => $this->input->post('pro_inq_phone')
						            ),
						            'product_infos' => [array(
						            	'category'      => $this->input->post('pro_inq_category')
						            )],
						            'address_info' => array(
						            	'city'      => $this->input->post('pro_inq_city')
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

				$category = strip_tags(addslashes($_POST['pro_inq_category']));
			    $name = strip_tags(addslashes($_POST['pro_inq_name']));
			    $phone = strip_tags(addslashes($_POST['pro_inq_phone']));
			    // $emails = strip_tags(addslashes($email));
			    $emails = strip_tags(addslashes($_POST['pro_inq_email']));
			    $city = strip_tags(addslashes($_POST['pro_inq_city']));
			    $msg = strip_tags(addslashes($_POST['pro_inq_message']));

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


		$this->load->view('product/index', $data);
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

	function _set_pro_inquiry_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->pro_inq_name = '';

			$this->form_data->pro_inq_email = '';

			$this->form_data->pro_inq_phone = '';

			$this->form_data->pro_inq_city = '';

			$this->form_data->pro_inq_category = '';
	}	

	function _set_pro_inquiry_rules(){

			$this->form_validation->set_rules('pro_inq_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('pro_inq_email', 'Email', 'trim|required');
			$this->form_validation->set_rules('pro_inq_phone', 'Phone No', 'trim|required');
			$this->form_validation->set_rules('pro_inq_city', 'City', 'trim|required');
			$this->form_validation->set_rules('pro_inq_category', 'Category', 'trim|required');

	}

}