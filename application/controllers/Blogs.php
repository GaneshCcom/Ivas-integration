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
		
	}
	public function index()
	{
		$data['title'] = "Blogs";
		$data['desc'] = "Blogs";
		$data['keyword'] = "Blogs";
		$data['loggedin'] = '';

		$blogLists = $this->admin_model->get_blogs()->result();
		$data['blogLists'] = $blogLists;

		$this->load->view('blogs/index', $data);
	}
	public function detail($slug)
	{

		$blogslug = $slug;
		$blogInfo = $this->admin_model->get_blog_byslug($slug)->row();
        // Check if subcategory exists
		if (!$blogInfo) {
			// Subcategory not found, show 404 error
			show_404();
		}
		$data['blogInfo'] = $blogInfo;

		$data['title'] = $blogInfo->meta_title;
		$data['desc'] = $blogInfo->meta_desc;
		$data['keyword'] = $blogInfo->meta_keyword;
		$data['loggedin'] = '';

		$recentposts = $this->admin_model->get_recenet_blogs()->result();
		$data['recentposts'] = $recentposts;

		$this->load->view('blogs/detail', $data);
	}
}