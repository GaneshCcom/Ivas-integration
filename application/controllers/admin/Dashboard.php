<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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
		$data['title'] = 'Admin Dashboard';
		$data['desc'] = '';
		$data['loggedin'] = '';
		$data['action'] = site_url('admin/dashboard');
		$data['typeback'] = '';
		$adminSession = $this->session->userdata('adminSession');
		
		$allProducts_count = $this->admin_model->get_allProducts_count()->row();
		$data['allProducts_count'] = $allProducts_count;

		$allCategory_count = $this->admin_model->get_allCategory_count()->row();
		$data['allCategory_count'] = $allCategory_count;

		$allSubategory_count = $this->admin_model->get_allSubategory_count()->row();
		$data['allSubategory_count'] = $allSubategory_count;

		$allFaq_count = $this->admin_model->get_allFaq_count()->row();
		$data['allFaq_count'] = $allFaq_count;

		$allTestimonials_count = $this->admin_model->get_allTestimonials_count()->row();
		$data['allTestimonials_count'] = $allTestimonials_count;

		$allBlogs_count = $this->admin_model->get_allBlogs_count()->row();
		$data['allBlogs_count'] = $allBlogs_count;

		$allProducts_inq_count = $this->admin_model->get_allProducts_inq_count()->row();
		$data['allProducts_inq_count'] = $allProducts_inq_count;

		$allGenral_inq_count = $this->admin_model->get_allGenral_inq_count()->row();
		$data['allGenral_inq_count'] = $allGenral_inq_count;

		$inquiryLists = $this->admin_model->get_all_product_inquiry()->result();
		$data['inquiryLists'] = $inquiryLists;


		$this->load->view('admin/dashboard/index', $data);
	}
	
	
		public function email()
	{
		$this->admin_model->isset_admin_user();
		$data['title'] = 'Admin Dashboard';
		$data['desc'] = '';
		$data['loggedin'] = '';
		$data['action'] = site_url('admin/dashboard');
		$data['typeback'] = '';
		$adminSession = $this->session->userdata('adminSession');
		
		$allTickets = $this->admin_model->get_allTickets()->result();
		$data['allTickets'] = $allTickets;

		$allTickets_count = $this->admin_model->get_allTickets_count()->row();
		$data['allTickets_count'] = $allTickets_count;

		$activeTickets_count = $this->admin_model->get_activeTickets_count()->row();
		$data['activeTickets_count'] = $activeTickets_count;

		$closeTickets_count = $this->admin_model->get_closeTickets_count()->row();
		$data['closeTickets_count'] = $closeTickets_count;

		$pendingTickets_count = $this->admin_model->get_pendingTickets_count()->row();
		$data['pendingTickets_count'] = $pendingTickets_count;
		
		
		$mail_message='Dear Admin <br>';

        $mail_message.='This is testig mail with SMTP configuration <br>';


        $mail_message.='<br>Thanks & Regards';

        $mail_message.='<br>Tea Post';        

       
		$config = array();
	   
	    //$config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
	    $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.hostinger.com';
        $config['smtp_user'] = 'noreply@crm.teapost.in';
        $config['smtp_pass'] = '@Tr0E&qP!yg1$M';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';
        $config['smtp_crypto'] = 'ssl';
        $config['charset'] = "utf-8";
        $config['newline'] = "\r\n";

					$this->email->initialize($config);

					

					$this->email->from('noreply@crm.teapost.in', 'TEA POST');

                    $this->email->to('prashant.brahmane@teapost.in, compliance@teapost.in');

					$this->email->cc('e14.aoneseo@gmail.com');

					$this->email->bcc('e3.aoneseo@gmail.com');

					

					$this->email->subject('SMTP TESTING MAIL');

					$this->email->message($mail_message);

					

					//$this->email->send();

if (!$this->email->send()) {

     $this->session->set_flashdata('message','Failed to send password, please try again!');
       $errors = $this->email->print_debugger();
    print_r($errors);

} else {

   $this->session->set_flashdata('message','Mail sent to your email!');

}


		$this->load->view('admin/dashboard/index', $data);
	}
}
?>