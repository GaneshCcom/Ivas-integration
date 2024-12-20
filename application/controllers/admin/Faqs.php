<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faqs extends CI_Controller {
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
			$data['title'] = 'Faqs';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/dashboard');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');
			
			$faqLists = $this->admin_model->get_faqs()->result();
			$data['faqLists'] = $faqLists;


			$this->load->view('admin/faqs/index', $data);
		}

		public function add()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Add Faqs';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/faqs/add');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			$this->_set_faq_rules();
			$this->_set_faq_fields();

			if(isset($_REQUEST['addfaq']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					
						// save data	

						// $sub_cat_id = $this->input->post('sub_cat_id');
						// print_r($sub_cat_id);	
						// die;

								// for($i=0;$i<count($sub_cat_id);$i++){

								// 	$productsubcategoryinfo = array( 
								// 			// 'pro_id' => $id,
								// 			'sub_cat_id' => $sub_cat_id[$i],
								// 		);

								// 	// $addproductsubcategory = $this->admin_model->add_product_sub_category($productsubcategoryinfo);

								// };
						$current = date('Y-m-d H:i:s');
						$faqinfo = array( 
									'faq_ques' => $this->input->post('faq_ques'),
									'faq_ans' => $this->input->post('faq_ans'),
									'cat_id' => $this->input->post('cat_id'),
									'sub_cat_id' => $this->input->post('sub_cat_id'),
									'faq_status' => $this->input->post('faq_status'),
									'faq_created' => date('Y-m-d H:i:s', strtotime($current)),
								);
						// print_r($faqinfo);	
						// die;
									
						
						$addfaq = $this->admin_model->add_faqs($faqinfo);

						

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Faq Added successfully.</p>');
						redirect('admin/faqs');
				}
			}	

			$this->load->view('admin/faqs/add', $data);
		}

		public function edit()
		{
			$faqId = $_GET['faq'];
			$hexaId = hex2bin($faqId);
			$id = base64_decode($hexaId);	
			$this->admin_model->isset_admin_user();
			$data['title'] = 'Edit Faq';
			$data['desc'] = '';
			$data['loggedin'] = '';
			$data['action'] = site_url('admin/faqs/edit');
			$data['typeback'] = '';
			$adminSession = $this->session->userdata('adminSession');

			$catLists = $this->admin_model->get_categories()->result();
			$data['catLists'] = $catLists;

			// $prosubcatLists = $this->admin_model->get_all_faqs_sub_categories_array($id);
			// $data['prosubcatLists'] = $prosubcatLists;
			// print_r($prosubcatLists);
			// die;

			$faqInfo = $this->admin_model->get_faq_byId($id)->row();
			
			$subcateLists = $this->admin_model->get_sub_category_bycatId($faqInfo->cat_id)->result();
			$data['subcateLists'] = $subcateLists;
			
			//print_r($buyerInfo);
			$this->form_data = new stdClass;
			$this->form_data->faq_ques = $faqInfo->faq_ques;
			$this->form_data->faq_ans = $faqInfo->faq_ans;
			$this->form_data->cat_id = $faqInfo->cat_id;
			$this->form_data->sub_cat_id = $faqInfo->sub_cat_id;
			$this->form_data->faq_status = $faqInfo->faq_status;

			$this->_set_faq_rules();
			//$this->_set_dept_fields();

			if(isset($_REQUEST['editfaq']))
			{
				if ($this->form_validation->run() == FALSE)
				{
					$data['message'] = '';
				}
				else
				{
					
						// save data	
						$current = date('Y-m-d H:i:s');
						$faqinfo = array( 
									'faq_ques' => $this->input->post('faq_ques'),
									'faq_ans' => $this->input->post('faq_ans'),
									'cat_id' => $this->input->post('cat_id'),
									'sub_cat_id' => $this->input->post('sub_cat_id'),
									'faq_status' => $this->input->post('faq_status'),
									'faq_updated' => date('Y-m-d H:i:s', strtotime($current)),
								);
									
						$editfaq = $this->admin_model->edit_faq($faqinfo, $id);

						// set user message
						$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">Faq updated successfully.</p>');
						redirect('admin/faqs');
				}
			}
				

			$this->load->view('admin/faqs/edit', $data);
		}

		public function deletefaq($id = '')
		{
			$hexaId = hex2bin($id);
			$id = base64_decode($hexaId);
			$data['title'] = 'Delete Faq';
			$faqinfo = array( 
									'faq_deleted' => '1',
								);
			$id = $this->admin_model->delete_faq($faqinfo, $id);
			$this->session->set_flashdata('message', '<div class="alert-danger alert text-center">Faq Deleted Successfully.</div>');
			redirect('admin/faqs');
		}

		public function import()
		{
			$this->admin_model->isset_admin_user();
			$data['title'] = `Import Faq's`;
			$data['action'] = site_url('admin/faqs/import_process');

			$this->load->view('admin/faqs/import', $data);
		}
		
		public function import_process()
		{
			$this->admin_model->isset_admin_user();

			if (isset($_FILES['faqs_file']) && !empty($_FILES['faqs_file']['name'])) {
				$file = $_FILES['faqs_file']['tmp_name'];
				$spreadsheet = IOFactory::load($file);
				$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

				$isFirstRow = TRUE;
				foreach ($sheetData as $row) {
					if($isFirstRow){
						$isFirstRow = FALSE;
						continue; // Skip header row and continue to the next iteration
					}
					if (!empty($row['A']) && !empty($row['B']) && !empty($row['C'])) {
						$faqinfo = array(
							'faq_ques' => $row['A'],
							'faq_ans' => $row['B'],
							'cat_id' => $row['C'],
							'faq_status' => isset($row['D']) ? $row['D'] : '1', // Default status if not provided
							'faq_created' => date('Y-m-d H:i:s')
						);

						$this->admin_model->add_faqs($faqinfo);
					}
				}

				$this->session->set_flashdata('message', '<p class="alert alert-primary text-center">FAQs imported successfully.</p>');
				redirect('admin/faqs');
			} else {
				$this->session->set_flashdata('message', '<p class="alert alert-danger text-center">Please upload a valid file.</p>');
				redirect('admin/faqs/import');
			}
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

		function _set_faq_fields(){

			$this->form_data = new stdClass;

			$this->form_data->id = '';

			$this->form_data->faq_ques = '';

			$this->form_data->faq_ans = '';

			$this->form_data->cat_id = '';

			$this->form_data->sub_cat_id = '';

			$this->form_data->faq_status = '';

		}	

	

		function _set_faq_rules(){

			$this->form_validation->set_rules('faq_ques', 'Faq Question', 'trim|required');
			$this->form_validation->set_rules('faq_ans', 'Faq Answer', 'trim|required');
			$this->form_validation->set_rules('cat_id', 'Faq Category', 'trim|required');
			// $this->form_validation->set_rules('sub_cat_id', 'Faq Sub Category', 'trim|required');
			$this->form_validation->set_rules('faq_status', 'Faq Satus',  'trim|required');

		}	
}
?>
