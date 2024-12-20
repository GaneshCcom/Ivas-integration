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

    // public function index() {
    //     $query = $this->input->get('query');
    //     $data['results'] = $this->admin_model->search($query);
    //     print_r($data['results']);
    //     $data['query'] = $query; // Preserve the search query in the view
    //     $this->load->view('include/header-front', $data);
    // }

    public function index() {
        $query = $this->input->get('query');
        $data['results'] = $this->admin_model->search($query); // Fetch search results
        $data['query'] = $query; // Preserve the query
        $data['view_mode'] = 'search_results'; // Indicate search results view
        $this->load->view('include/header-front', $data);
    }

    // Show products based on selected category
    public function category($cat_id) {
        $data['products'] = $this->admin_model->getProductsByCategory($cat_id); // Fetch products for the category
        // print_r($data['products']);
        // die;
        $data['category'] = $this->admin_model->get_Category_by_Id($cat_id); // Get category details
        // print_r($data['category']);
        // die;
        $data['view_mode'] = 'category_products'; // Indicate category products view
        $this->load->view('include/header-front', $data);
    }
}
