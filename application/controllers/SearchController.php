<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SearchController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->model('SearchModel');

        // load helper
		$this->load->library(array('table','form_validation', 'email'));
		$this->load->helper('url');
		$this->load->library('session');
		// load model
		$this->load->model('admin_model','',TRUE);
    }


    public function index() {
       
        $this->load->view('include/header-front');
    }

    // Show products based on selected category
    // public function category($cat_id) {
    //     $cateLists = $this->admin_model->get_all_categories();
	// 	$data['cateLists'] = $cateLists;
    //     // $keyword = $this->input->post($keyword);
    //     // $data['category'] = $this->admin_model->get_Category_by_keyword($keyword); // Get category details
    //     // print_r($data['category']);
    //     // die;
    //     $this->load->view('include/header-front', $data);
    // }
    public function category() {
        $cateLists = $this->admin_model->get_all_categories(); // Fetch categories
        echo json_encode($cateLists); // Return JSON data for AJAX
    }
    
}
