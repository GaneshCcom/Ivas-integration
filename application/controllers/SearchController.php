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
        $query = $this->input->get('query');
        $data['results'] = $this->admin_model->search($query);
        print_r($data['results']);
        $data['query'] = $query; // Preserve the search query in the view
        $this->load->view('include/header-front', $data);
    }
}
