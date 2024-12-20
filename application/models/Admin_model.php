<?php

class Admin_model extends CI_Model {



   //private $tbl_content = 'content_blocks';



    function __construct() {



        parent::__construct();

    }



    function isset_admin_user() {

        $adminSession = $this->session->userdata('adminSession');
        if (isset($adminSession['loggedin']) && $adminSession['loggedin'] == true) {

             return true;

        } else {



            redirect('admin/login');

        }

    }

	

    function isset_common_user(){
		$adminSession = $this->session->userdata('adminSession');

		if(isset($adminSession['loggedin']) && $adminSession['loggedin'] == true )
		{
			redirect('admin/dashboard');
		}
		else
		{
			redirect('admin/login');
		}
	}


	/*** Admin Profile  ****/
	
	function get_adminInfo($adminId){
		$query = $this->db->select('t1.*')
		->from('admin as t1') 
		->WHERE ('admin_id', $adminId)
		->get();
		return $query;
	}	

	function chk_admin_pwd($adminId, $old_pass)
	{
				
		$this->db->where('admin_id', $adminId);
		 $this->db->where('admin_password', $old_pass);
		 $this->db->limit(1);
		$result = $this->db->get('admin')->result();
		  
		  if(count($result) > 0)
		  {
			return $result[0];
		  }
			else
		  {
			return false;
		  }
	}
	function change_admin_pwd($adminId, $new_pwd)
	{
		$data = array('admin_password'=> $new_pwd);
		$this->db->where('admin_id', $adminId); 
		return $this->db->update('admin', $data);
	}


	function edit_adminInfo($adminInfo, $adminId){
		  $this->db->where('admin_id', $adminId);
        $this->db->update('admin', $adminInfo);
	}

	/*** Categories ****/

	function add_category($catinfo)
	{
		$this->db->insert('category', $catinfo);
		return $this->db->insert_id();
	}

	function get_category_byId($id){
		$this->db->where('cat_id', $id);
        return $this->db->get('category');
	}

	function edit_category($catinfo, $id){
        $this->db->where('cat_id', $id);
        $this->db->update('category', $catinfo);
	}

	function delete_category($catinfo, $id)
	{
       	$this->db->where('cat_id', $id);
        $this->db->update('category', $catinfo);
    }

	function get_categories() {
		// $query = $this->db->select('t1.*')
		// ->from('category as t1') 
		// ->WHERE ('cat_deleted',  '0')
		// ->get();
		// return $query;
		$query = $this->db->select('t1.*, t2.par_cat_name')
		->from('category as t1') 
		->join('parent_category as t2', 't1.par_id = t2.par_id', 'LEFT')
		->WHERE ('cat_deleted',  '0')
		->get();
		return $query;
	}
	// change
	function get_categories_by_parId($par_id){
		$query = $this->db->select('t1.*')
		->from('category as t1') 
		->WHERE ('par_id',  $par_id)
		->WHERE ('cat_deleted',  '0')
		->get();
		return $query;
	}
	

	public function get_all_categories()
	{
		$this->db->where('cat_deleted', '0');
	    $query = $this->db->get('category');
	    $return = array();

	    foreach ($query->result() as $category)
	    {
	        $return[$category->cat_id] = $category;
	        $return[$category->cat_id]->subs = $this->get_all_sub_categories($category->cat_id); // Get the categories sub categories
	    }

	    return $return;
	}

	public function get_all_categories_byParId($parId)
	{
		$this->db->where('cat_deleted', '0');
		$this->db->where('par_id', $parId);
	    $query = $this->db->get('category');
	    $return = array();

	    foreach ($query->result() as $category)
	    {
	        $return[$category->cat_id] = $category;
	        $return[$category->cat_id]->subs = $this->get_all_sub_categories($category->cat_id); // Get the categories sub categories
	    }

	    return $return;
	}

	public function get_all_sub_categories($category_id)
	{
	    $this->db->where('cat_id', $category_id);
	    $this->db->where('sub_cat_deleted', '0');
	    $query = $this->db->get('sub_category');
	    return $query->result();
	}

	/*** Parent Category ***/

	function add_par_category($parcateinfo)
	{
		$this->db->insert('parent_category', $parcateinfo);
		return $this->db->insert_id();
	}

	function get_par_category_byId($id){
		$this->db->where('par_id', $id);
        return $this->db->get('parent_category');
	}

	function edit_par_category($catinfo, $id){
        $this->db->where('par_id', $id);
        $this->db->update('parent_category', $catinfo);
	}

	function delete_par_category($parcateinfo, $id)
	{
       	$this->db->where('par_id', $id);
        $this->db->update('parent_category', $parcateinfo);
    }

	function get_par_categories() {
		$query = $this->db->select('t1.*')
		->from('parent_category as t1') 
		->WHERE ('par_cat_deleted',  '0')
		->get();
		return $query;
		
	}
	// New change to get par category for product
	public function get_parent_categories() {
		$this->db->select('*');
		$this->db->from('parent_category'); // Assuming 'parent_categories' is the table name
		return $this->db->get();
	}

	public function get_all_par_categories()
	{
		$this->db->where('par_cat_deleted', '0');
	    $query = $this->db->get('parent_category');
	    $return = array();

	    foreach ($query->result() as $parCategory)
	    {
	        $return[$parCategory->par_id] = $parCategory;
			// To Get the Parent categories sub categories
	        $return[$parCategory->par_id]->subs = $this->get_all_child_categories($parCategory->par_id); 
	    }

	    return $return;
	}

	public function get_all_child_categories($category_id)
	{
	    $this->db->where('par_id', $category_id);
	    $this->db->where('cat_deleted', '0');
	    $query = $this->db->get('category');
	    return $query->result();
	}

	/*** Sub Categories ****/

	function add_sub_category($subcatinfo)
	{
		$this->db->insert('sub_category', $subcatinfo);
		return $this->db->insert_id();
	}

	function get_sub_category_byId($id){
		$this->db->where('sub_cat_id', $id);
        return $this->db->get('sub_category');
	}

	function get_sub_category_bycatId($id){
		$this->db->where('cat_id', $id);
        return $this->db->get('sub_category');
	}

	function edit_sub_category($subcatinfo, $id){
        $this->db->where('sub_cat_id', $id);
        $this->db->update('sub_category', $subcatinfo);
	}

	function delete_sub_category($subcatinfo, $id)
	{
       	$this->db->where('sub_cat_id', $id);
        $this->db->update('sub_category', $subcatinfo);
    }

	function get_sub_categories() {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('sub_category as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('sub_cat_deleted',  '0')
		->get();
		return $query;
	}
	function get_sub_categories_byproduct($id) {
		$query = $this->db->select('t1.*, t2.sub_cat_name')
		->from('product_sub_category as t1') 
		->join('sub_category as t2', 't2.sub_cat_id = t1.sub_cat_id', 'LEFT')
		->WHERE ('t1.pro_id', $id)
		->get();
		return $query;
	}
	function get_sub_category_byslug($slug) {
		$query = $this->db->select('*')
		->from('sub_category') 
		->WHERE ('sub_cat_slug', $slug)
		->get();
		return $query;
	}
	function get_allsub_categories() {
		$query = $this->db->select('t1.*')
		->from('sub_category as t1') 
		->WHERE ('sub_cat_deleted',  '0')
		->get();
		return $query;
	}

	/*** Faqs ****/
	
	function add_faqs($faqinfo)
	{
		$this->db->insert('faqs', $faqinfo);
		return $this->db->insert_id();
	}

	function get_faqs() {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('faqs as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('faq_deleted',  '0')
		->get();
		return $query;
	}

	function get_faq_bycat($id) {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('faqs as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('t1.cat_id', $id)
		->WHERE ('faq_deleted',  '0')
		->get();
		return $query;
	}

	function get_faq_byId($id){
		$this->db->where('faq_id', $id);
        return $this->db->get('faqs');
	}

	function edit_faq($faqinfo, $id){
        $this->db->where('faq_id', $id);
        $this->db->update('faqs', $faqinfo);
	}

	function delete_faq($faqinfo, $id)
	{
       	$this->db->where('faq_id', $id);
        $this->db->update('faqs', $faqinfo);
    }

    function get_all_faqs() {
		$query = $this->db->select('t1.*')
		->from('faqs as t1') 
		->WHERE ('faq_deleted',  '0')
		->get();
		return $query;
	}

	// function get_all_faqs_sub_categories_array($id){
	// 	$query = $this->db->select('t1.sub_cat_id ')
	// 	->from('faqs as t1')
	// 	// $this->db->join('sub_category as t2', 't1.sub_cat_id = t2.sub_cat_id', 'LEFT');
	// 	->where('t1.faq_id', $id)
	// 	->WHERE ('faq_deleted',  '0')
	// 	->get();
	//     return $query;

	// }

	/*** Testimonials ****/

	function add_testi($testiinfo)
	{
		$this->db->insert('testimonials', $testiinfo);
		return $this->db->insert_id();
	}

	function get_testis() {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('testimonials as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('testi_deleted',  '0')
		->get();
		return $query;
	}

	function get_testi_byId($id){
		$this->db->where('testi_id', $id);
        return $this->db->get('testimonials');
	}

	function edit_testi($testiinfo, $id){
        $this->db->where('testi_id', $id);
        $this->db->update('testimonials', $testiinfo);
	}

	function delete_testi($testiinfo, $id)
	{
       	$this->db->where('testi_id', $id);
        $this->db->update('testimonials', $testiinfo);
    }

    function get_all_testis() {
		$query = $this->db->select('t1.*')
		->from('testimonials as t1') 
		->WHERE ('testi_deleted',  '0')
		->get();
		return $query;
	}

	/*** Innovation Videos ****/

	function add_innov_video($videoinfo)
	{
		$this->db->insert('innovation_videos', $videoinfo);
		return $this->db->insert_id();
	}

	function get_innov_video_byId($id){
		$this->db->where('innov_video_id', $id);
        return $this->db->get('innovation_videos');
	}

	function edit_innov_video($videoinfo, $id){
        $this->db->where('innov_video_id', $id);
        $this->db->update('innovation_videos', $videoinfo);
	}

	function delete_innov_video($videoinfo, $id)
	{
       	$this->db->where('innov_video_id', $id);
        $this->db->update('innovation_videos', $videoinfo);
    }

    function get_all_innov_videos() {
		$query = $this->db->select('t1.*')
		->from('innovation_videos as t1') 
		->WHERE ('innov_deleted',  '0')
		->get();
		return $query;
	}

	/*** Reasons ****/

	function add_reason($reasoninfo)
	{
		$this->db->insert('reasons', $reasoninfo);
		return $this->db->insert_id();
	}

	function get_reason_byId($id){
		$this->db->where('reas_id', $id);
        return $this->db->get('reasons');
	}

	function edit_reason($reasoninfo, $id){
        $this->db->where('reas_id', $id);
        $this->db->update('reasons', $reasoninfo);
	}

	function delete_reason($reasoninfo, $id)
	{
       	$this->db->where('reas_id', $id);
        $this->db->update('reasons', $reasoninfo);
    }

    function get_all_reasons() {
		$query = $this->db->select('t1.*')
		->from('reasons as t1') 
		->WHERE ('reas_deleted',  '0')
		->order_by('vorder', 'asc')
		->get();
		return $query;
	}
	function get_all_reasons_byParId($par_id) {
		$query = $this->db->select('t1.*')
		->from('reasons as t1') 
		->WHERE ('reas_deleted',  '0')
		->WHERE ('par_id', $par_id)
		->order_by('vorder', 'asc')
		->get();
		return $query;
	}

	/*** Trending Blocks ****/

	function add_trend($trendinfo)
	{
		$this->db->insert('trending_blocks', $trendinfo);
		return $this->db->insert_id();
	}

	function get_trends() {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('trending_blocks as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('trend_deleted',  '0')
		->get();
		return $query;
	}

	function get_trend_byId($id){
		$this->db->where('trend_id', $id);
        return $this->db->get('trending_blocks');
	}

	function edit_trend($trendinfo, $id){
        $this->db->where('trend_id', $id);
        $this->db->update('trending_blocks', $trendinfo);
	}

	function delete_trend($trendinfo, $id)
	{
       	$this->db->where('trend_id', $id);
        $this->db->update('trending_blocks', $trendinfo);
    }

    function get_all_trends() {
		$query = $this->db->select('t1.*')
		->from('trending_blocks as t1') 
		->WHERE ('trend_deleted',  '0')
		->get();
		return $query;
	}

	/*** Slider ****/

	function add_slide($slideinfo)
	{
		$this->db->insert('slider', $slideinfo);
		return $this->db->insert_id();
	}

	function get_slide_byId($id){
		$this->db->where('slide_id', $id);
        return $this->db->get('slider');
	}

	function edit_slide($slideinfo, $id){
        $this->db->where('slide_id', $id);
        $this->db->update('slider', $slideinfo);
	}

	function delete_slide($slideinfo, $id)
	{
       	$this->db->where('slide_id', $id);
        $this->db->update('slider', $slideinfo);
    }

    function get_all_slides() {
		$query = $this->db->select('t1.*')
		->from('slider as t1') 
		->WHERE ('slide_deleted',  '0')
		->get();
		return $query;
	}

	/*** Catalogs ****/

	function add_catalog($cataloginfo)
	{
		$this->db->insert('catalog', $cataloginfo);
		return $this->db->insert_id();
	}

	function get_catalogs() {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('catalog as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('catalog_deleted',  '0')
		->get();
		return $query;
	}

	function get_catalog_byId($id){
		$this->db->where('catalog_id', $id);
        return $this->db->get('catalog');
	}

	function edit_catalog($cataloginfo, $id){
        $this->db->where('catalog_id', $id);
        $this->db->update('catalog', $cataloginfo);
	}

	function delete_catalog($cataloginfo, $id)
	{
       	$this->db->where('catalog_id', $id);
        $this->db->update('catalog', $cataloginfo);
    }

    function get_all_catalogs() {
		$query = $this->db->select('t1.*')
		->from('catalog as t1') 
		->WHERE ('catalog_deleted',  '0')
		->get();
		return $query;
	}

	/*** Blogs ****/

	function add_blog($bloginfo)
	{
		$this->db->insert('blog', $bloginfo);
		return $this->db->insert_id();
	}

	function get_blogs() {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('blog as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('blog_deleted',  '0')
		->get();
		return $query;
	}

	function get_recent_blog_list() {
		$query = $this->db->select('t1.*, t2.cat_name')
		->from('blog as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('blog_deleted',  '0')
		->order_by('t1.blog_title', 'random')
		->limit(3)
		->get();
		return $query;
	}

	function get_blog_byId($id){
		$this->db->where('blog_id', $id);
        return $this->db->get('blog');
	}

	function edit_blog($bloginfo, $id){
        $this->db->where('blog_id', $id);
        $this->db->update('blog', $bloginfo);
	}

	function delete_blog($bloginfo, $id)
	{
       	$this->db->where('blog_id', $id);
        $this->db->update('blog', $bloginfo);
    }

    function get_all_blogs() {
		$query = $this->db->select('t1.*')
		->from('blog as t1') 
		->WHERE ('blog_deleted',  '0')
		->get();
		return $query;
	}

	 function get_recenet_blogs() {
		$query = $this->db->select('t1.*')
		->from('blog as t1') 
		->WHERE ('blog_deleted',  '0')
		->limit(5)
		->get();
		return $query;
	}

	function get_blog_byslug($slug){
		$this->db->where('blog_slug', $slug);
        return $this->db->get('blog');
	}

	/*** Product Attribute Finish ****/

	function add_finish($finishinfo)
	{
		$this->db->insert('pa_finish', $finishinfo);
		return $this->db->insert_id();
	}

	function get_finish_byId($id){
		$this->db->where('fin_id', $id);
        return $this->db->get('pa_finish');
	}

	function edit_finish($finishinfo, $id){
        $this->db->where('fin_id', $id);
        $this->db->update('pa_finish', $finishinfo);
	}

	function delete_finish($finishinfo, $id)
	{
       	$this->db->where('fin_id', $id);
        $this->db->update('pa_finish', $finishinfo);
    }

    function get_all_finishs() {
		$query = $this->db->select('t1.*')
		->from('pa_finish as t1') 
		->WHERE ('fin_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Attribute Shape ****/

	function add_shape($shapeinfo)
	{
		$this->db->insert('pa_shape', $shapeinfo);
		return $this->db->insert_id();
	}

	function get_shape_byId($id){
		$this->db->where('shape_id', $id);
        return $this->db->get('pa_shape');
	}

	function edit_shape($shapeinfo, $id){
        $this->db->where('shape_id', $id);
        $this->db->update('pa_shape', $shapeinfo);
	}

	function delete_shape($shapeinfo, $id)
	{
       	$this->db->where('shape_id', $id);
        $this->db->update('pa_shape', $shapeinfo);
    }

    function get_all_shapes() {
		$query = $this->db->select('t1.*')
		->from('pa_shape as t1') 
		->WHERE ('shape_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Attribute Color ****/

	function add_color($colorinfo)
	{
		$this->db->insert('pa_color', $colorinfo);
		return $this->db->insert_id();
	}

	function get_color_byId($id){
		$this->db->where('color_id', $id);
        return $this->db->get('pa_color');
	}

	function edit_color($colorinfo, $id){
        $this->db->where('color_id', $id);
        $this->db->update('pa_color', $colorinfo);
	}

	function delete_color($colorinfo, $id)
	{
       	$this->db->where('color_id', $id);
        $this->db->update('pa_color', $colorinfo);
    }

    function get_all_colors() {
		$query = $this->db->select('t1.*')
		->from('pa_color as t1') 
		->WHERE ('color_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Attribute Body ****/

	function add_body($bodyinfo)
	{
		$this->db->insert('pa_body', $bodyinfo);
		return $this->db->insert_id();
	}

	function get_body_byId($id){
		$this->db->where('body_id', $id);
        return $this->db->get('pa_body');
	}

	function edit_body($bodyinfo, $id){
        $this->db->where('body_id', $id);
        $this->db->update('pa_body', $bodyinfo);
	}

	function delete_body($bodyinfo, $id)
	{
       	$this->db->where('body_id', $id);
        $this->db->update('pa_body', $bodyinfo);
    }

    function get_all_bodys() {
		$query = $this->db->select('t1.*')
		->from('pa_body as t1') 
		->WHERE ('body_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Attribute Power Input ****/

	function add_power($powerinfo)
	{
		$this->db->insert('pa_power_input', $powerinfo);
		return $this->db->insert_id();
	}

	function get_power_byId($id){
		$this->db->where('pi_id', $id);
        return $this->db->get('pa_power_input');
	}

	function edit_power($powerinfo, $id){
        $this->db->where('pi_id', $id);
        $this->db->update('pa_power_input', $powerinfo);
	}

	function delete_power($powerinfo, $id)
	{
       	$this->db->where('pi_id', $id);
        $this->db->update('pa_power_input', $powerinfo);
    }

    function get_all_powers() {
		$query = $this->db->select('t1.*')
		->from('pa_power_input as t1') 
		->WHERE ('pi_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Attribute Star Rating ****/

	function add_rating($ratinginfo)
	{
		$this->db->insert('pa_star_rating', $ratinginfo);
		return $this->db->insert_id();
	}

	function get_rating_byId($id){
		$this->db->where('sr_id', $id);
        return $this->db->get('pa_star_rating');
	}

	function edit_rating($ratinginfo, $id){
        $this->db->where('sr_id', $id);
        $this->db->update('pa_star_rating', $ratinginfo);
	}

	function delete_rating($ratinginfo, $id)
	{
       	$this->db->where('sr_id', $id);
        $this->db->update('pa_star_rating', $ratinginfo);
    }

    function get_all_ratings() {
		$query = $this->db->select('t1.*')
		->from('pa_star_rating as t1') 
		->WHERE ('sr_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Attribute Thermostat Type ****/

	function add_therm($therminfo)
	{
		$this->db->insert('pa_thermostat_type', $therminfo);
		return $this->db->insert_id();
	}

	function get_therm_byId($id){
		$this->db->where('ther_type_id', $id);
        return $this->db->get('pa_thermostat_type');
	}

	function edit_therm($therminfo, $id){
        $this->db->where('ther_type_id', $id);
        $this->db->update('pa_thermostat_type', $therminfo);
	}

	function delete_therm($therminfo, $id)
	{
       	$this->db->where('ther_type_id', $id);
        $this->db->update('pa_thermostat_type', $therminfo);
    }

    function get_all_therms() {
		$query = $this->db->select('t1.*')
		->from('pa_thermostat_type as t1') 
		->WHERE ('ther_type_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Attribute Warranty ****/

	function add_wrty($wrtyinfo)
	{
		$this->db->insert('pa_warranty', $wrtyinfo);
		return $this->db->insert_id();
	}

	function get_wrty_byId($id){
		$this->db->where('wrty_id', $id);
        return $this->db->get('pa_warranty');
	}

	function edit_wrty($wrtyinfo, $id){
        $this->db->where('wrty_id', $id);
        $this->db->update('pa_warranty', $wrtyinfo);
	}

	function delete_wrty($wrtyinfo, $id)
	{
       	$this->db->where('wrty_id', $id);
        $this->db->update('pa_warranty', $wrtyinfo);
    }

    function get_all_wrtys() {
		$query = $this->db->select('t1.*')
		->from('pa_warranty as t1') 
		->WHERE ('wrty_deleted',  '0')
		->get();
		return $query;
	}

	/*** Products Features ****/

	function add_feature($featureinfo)
	{
		$this->db->insert('product_feature', $featureinfo);
		return $this->db->insert_id();
	}

	function get_feature_byId($id){
		$this->db->where('feat_id', $id);
        return $this->db->get('product_feature');
	}

	function edit_feature($featureinfo, $id){
        $this->db->where('feat_id', $id);
        $this->db->update('product_feature', $featureinfo);
	}

	function delete_feature($featureinfo, $id)
	{
       	$this->db->where('feat_id', $id);
        $this->db->update('product_feature', $featureinfo);
    }

    function get_all_features() {
		$query = $this->db->select('t1.*')
		->from('product_feature as t1') 
		->WHERE ('feat_deleted',  '0')
		->get();
		return $query;
	}

	/*** Products ****/

	function add_product($productinfo)
	{
		$this->db->insert('product', $productinfo);
		return $this->db->insert_id();
	}

	function get_product_byId($id){
		$this->db->where('pro_id', $id);
        return $this->db->get('product');
	}

	function edit_product($productinfo, $id){
        $this->db->where('pro_id', $id);
        $this->db->update('product', $productinfo);
	}

	function delete_product($productinfo, $id)
	{
       	$this->db->where('pro_id', $id);
        $this->db->update('product', $productinfo);
    }

	function get_products() {
		$query = $this->db->select('t1.*, t2.cat_name, t4.sub_cat_name')
		->from('product as t1') 
		->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT')
		->join('product_sub_category as t3', 't3.pro_id = t1.pro_id', 'LEFT')
		->join('sub_category as t4', 't4.sub_cat_id = t3.sub_cat_id', 'LEFT')
		->WHERE ('t1.pro_deleted',  '0')
		->get();
		return $query;
	}

	function add_product_sub_category($productsubcategoryinfo)
	{
		$this->db->insert('product_sub_category', $productsubcategoryinfo);
		return $this->db->insert_id();
	}
	
	function add_product_category($productCategoryInfo)
	{
		$this->db->insert('product_category', $productCategoryInfo);
		return $this->db->insert_id();
	}


	public function get_all_products()
	{
		$this->db->select('t1.*, t2.cat_name, t3.par_cat_name');
		$this->db->from('product as t1');
		$this->db->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT');
		$this->db->join('parent_category as t3', 't1.par_id = t3.par_id', 'LEFT');
		$this->db->where('t1.pro_deleted', '0');
	    $query = $this->db->get();
	    $return = array();

	    foreach ($query->result() as $product)
	    {
	        $return[$product->pro_id] = $product;
	        $return[$product->pro_id]->subs = $this->get_all_pro_sub_categories($product->pro_id); // Get the categories sub categories
			$return[$product->pro_id]->cats = $this->get_all_pro_categories($product->pro_id); 
	    }

	    return $return;
	}

	public function get_all_pro_sub_categories($pro_id)
	{
		$this->db->select('t1.*, t2.sub_cat_name');
		$this->db->from('product_sub_category as t1');
		$this->db->join('sub_category as t2', 't1.sub_cat_id = t2.sub_cat_id', 'LEFT');
	    $this->db->where('t1.pro_id', $pro_id);
	    $query = $this->db->get();
		
	    return $query->result();
	}

	public function get_all_pro_categories($pro_id)
	{
		$this->db->select('t1.*, t2.cat_name');
		$this->db->from('product_category as t1');
		$this->db->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT');
	    $this->db->where('t1.pro_id', $pro_id);
	    $query = $this->db->get();
		
	    return $query->result();
	}

	public function get_all_pro_sub_categories_array($pro_id)
	{
		$this->db->select('group_concat((t1.sub_cat_id) SEPARATOR ",") as subcate_list');
		$this->db->from('product_sub_category as t1');
		$this->db->join('sub_category as t2', 't1.sub_cat_id = t2.sub_cat_id', 'LEFT');
	    $this->db->where('t1.pro_id', $pro_id);
	    $query = $this->db->get();
	    return $query->row();
	}
	
	public function get_all_pro_categories_array($pro_id)
	{
		$this->db->select('group_concat((t1.cat_id) SEPARATOR ",") as cate_list');
		$this->db->from('product_category as t1');
		$this->db->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT');
	    $this->db->where('t1.pro_id', $pro_id);
	    $query = $this->db->get();
	    return $query->row();
	}

	function delete_product_sub_categories($pro_id){
		 $this->db->where('pro_id', $pro_id);
        $this->db->delete('product_sub_category');
	}

	function get_products_by_subcat($id) {
		$query = $this->db->select('t1.*')
		->from('product as t1') 
		->join('product_sub_category as t2', 't2.pro_id = t1.pro_id', 'LEFT')
		->WHERE ('t2.sub_cat_id', $id)
		->WHERE ('t1.pro_deleted', '0')
		->order_by('vorder', 'asc')
		->get();
		return $query;
	}

	function get_product_byslug($slug) {
		$query = $this->db->select('*')
		->from('product') 
		->WHERE ('pro_slug', $slug)
		->get();
		return $query;
	}

	/*** Product Gallery ****/


	function add_product_gallery($galleryinfo)
	{
		$this->db->insert('product_gallery', $galleryinfo);
		return $this->db->insert_id();
	}

	function get_product_gallery_byId($id){
		$this->db->where('pro_id', $id);
        return $this->db->get('product_gallery');
	}

    function delete_product_gallery($id){
		 $this->db->where('pro_glry_id', $id);
        $this->db->delete('product_gallery');
	}

    function get_product_gallery_byproduct($id) {
		$query = $this->db->select('t1.*')
		->from('product_gallery as t1') 
		->WHERE ('pro_id', $id)
		->get();
		return $query;
	}

	/*** Product feature ****/

	function add_product_feature($featureinfo)
	{
		$this->db->insert('products_features', $featureinfo);
		return $this->db->insert_id();
	}

	public function get_all_pro_features_array($pro_id)
	{
		$this->db->select('group_concat((t1.feat_id) SEPARATOR ",") as feature_list');
		$this->db->from('products_features as t1');
		$this->db->join('product_feature as t2', 't1.feat_id = t2.feat_id', 'LEFT');
	    $this->db->where('t1.pro_id', $pro_id);
	    $query = $this->db->get();
	    return $query->row();
	}

	public function get_all_pro_features($pro_id)
	{
		$this->db->select('t1.*, t2.*');
		$this->db->from('products_features as t1');
		$this->db->join('product_feature as t2', 't1.feat_id = t2.feat_id', 'LEFT');
	    $this->db->where('t1.pro_id', $pro_id);
	    $query = $this->db->get();
	    return $query;
	}

	function delete_product_feature($id){
		 $this->db->where('pro_id', $id);
        $this->db->delete('products_features');
	}

	/*** Product Technical Specification ****/

	function add_product_specification($speciinfo)
	{
		$this->db->insert('technical_specification', $speciinfo);
		return $this->db->insert_id();
	}

	function get_product_specification_byId($id){
		$this->db->where('pro_id', $id);
        return $this->db->get('technical_specification');
	}

	function delete_product_specification($id){
		 $this->db->where('pro_id', $id);
        $this->db->delete('technical_specification');
	}

	/*** Product Description ****/

	function add_product_description($descinfo)
	{
		$this->db->insert('product_desc', $descinfo);
		return $this->db->insert_id();
	}

	function get_product_description_byId($id){
		$this->db->where('pro_id', $id);
		return $this->db->get('product_desc');
	}

	function delete_product_description($id){
			$this->db->where('pro_id', $id);
		$this->db->delete('product_desc');
	}

	/***  Inquiry ****/

	function add_inquiry($inquiryinfo)
	{
		$this->db->insert('inquiry', $inquiryinfo);
		return $this->db->insert_id();
	}

	function get_all_genral_inquiry() {
		$query = $this->db->select('t1.*')
		->from('inquiry as t1') 
		->WHERE ('pro_id', '0')
		->get();
		return $query;
	}

	function get_all_product_inquiry() {
		$query = $this->db->select('t1.*, t2.pro_name')
		->from('inquiry as t1') 
		->join('product as t2', 't1.pro_id = t2.pro_id', 'LEFT')
		->WHERE ('t1.pro_id !=', '0')
		->get();
		return $query;
	}

	/*** Attribute ****/
	
	function add_attribute($attrinfo)
	{
		$this->db->insert('attribute', $attrinfo);
		return $this->db->insert_id();
	}

	function get_attributes() {
		$query = $this->db->select('t1.*')
		->from('attribute as t1') 
		->WHERE ('attr_deleted',  '0')
		->get();
		return $query;
	}

	function get_attribute_byId($id){
		$this->db->where('attr_id', $id);
        return $this->db->get('attribute');
	}

	function edit_attribute($attrinfo, $id){
        $this->db->where('attr_id', $id);
        $this->db->update('attribute', $attrinfo);
	}

	function delete_attribute($attrinfo, $id)
	{
       	$this->db->where('attr_id', $id);
        $this->db->update('attribute', $attrinfo);
    }

    function get_all_attributes() {
		$query = $this->db->select('t1.*')
		->from('attribute as t1') 
		->WHERE ('attr_deleted',  '0')
		->get();
		return $query;
	}

	/*** Product Category Attribute ****/

	function add_pro_cat_attribute($catattrinfo)
	{
		$this->db->insert('product_cat_attribute', $catattrinfo);
		return $this->db->insert_id();
	}
	function delete_pro_cat_attribute($id){
		 $this->db->where('attr_id', $id);
        $this->db->delete('product_cat_attribute');
	}


	public function get_pro_cat_attribute_byattrId($id)
	{
		$this->db->select('group_concat((t1.cat_id) SEPARATOR ",") as attrcat_list');
		$this->db->from('product_cat_attribute as t1');
		$this->db->join('category as t2', 't1.cat_id = t2.cat_id', 'LEFT');
	    $this->db->where('t1.attr_id', $id);
	    $query = $this->db->get();
	    return $query->row();
	}

	public function get_pro_subcat_attribute_byattrId($id)
	{
		$this->db->select('group_concat((t1.sub_cat_id) SEPARATOR ",") as attrcat_list');
		$this->db->from('product_cat_attribute as t1');
		$this->db->join('sub_category as t2', 't1.sub_cat_id = t2.sub_cat_id', 'LEFT');
	    $this->db->where('t1.attr_id', $id);
	    $query = $this->db->get();
	    return $query->row();
	}

	/*** Attribute Values ****/

	function add_attr_value($attrvalinfo)
	{
		$this->db->insert('attribute_value', $attrvalinfo);
		return $this->db->insert_id();
	}

	function get_attr_value_byId($id){
		$this->db->where('attr_val_id', $id);
        return $this->db->get('attribute_value');
	}

	function edit_attr_value($attrvalinfo, $id){
        $this->db->where('attr_val_id', $id);
        $this->db->update('attribute_value', $attrvalinfo);
	}

	function delete_attr_value($attrvalinfo, $id)
	{
       	$this->db->where('attr_val_id', $id);
        $this->db->update('attribute_value', $attrvalinfo);
    }

    function get_all_attr_values($attr_id) {
		$query = $this->db->select('t1.*')
		->from('attribute_value as t1') 
		->WHERE ('attr_id', $attr_id)
		->WHERE ('attr_val_deleted',  '0')
		->get();
		return $query;
	}

	public function get_all_pro_attributes_array($pro_id)
	{
		$this->db->select('group_concat((t1.attr_val_id) SEPARATOR ",") as pro_attributes_list');
		$this->db->from('product_attributes_values as t1');
		$this->db->join('attribute_value as t2', 't1.attr_val_id = t2.attr_val_id', 'LEFT');
	    $this->db->where('t1.pro_id', $pro_id);
	    $query = $this->db->get();
	    return $query->row();
	}

	// function get_pro_attribute_backend($pro_id) {
	// 	$query = $this->db->select('t1.*')
	// 	->from('attribute as t1') 
	// 	->join('product_cat_attribute as t2', 't1.attr_id = t2.attr_id', 'LEFT')
	// 	->join('product as t3', 't3.cat_id = t2.cat_id', 'LEFT')
	// 	->WHERE ('t3.pro_id', $pro_id)
	// 	->WHERE ('t1.attr_deleted', '0')
	// 	->get();
	// 	return $query;
	// }

	// change
	function get_pro_attribute_backend($pro_id) {
		$query = $this->db->select('t1.*')
		->from('attribute as t1') 
		->join('product_cat_attribute as t2', 't1.attr_id = t2.attr_id', 'LEFT')
		->join('product_sub_category as t3', 't3.sub_cat_id = t2.sub_cat_id', 'LEFT')
		//->join('product as t3', 't3.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('t3.pro_id', $pro_id)
		->WHERE ('t1.attr_deleted', '0')
		->get();
		return $query;
	}

	function get_pro_attribute($pro_id) {
		$query = $this->db->select('t1.*')
		->from('attribute as t1') 
		->join('attribute_value as t2', 't1.attr_id = t2.attr_id', 'LEFT')
		->join('product_attributes_values as t3', 't3.attr_val_id = t2.attr_val_id', 'LEFT')
		->join('product as t4', 't4.pro_id = t3.pro_id', 'LEFT')
		->WHERE ('t4.pro_id', $pro_id)
		->WHERE ('t1.attr_deleted', '0')
		->group_by('t1.attr_id')
		->get();
		return $query;
	}

	function get_attribute_bycat($id) {
		$query = $this->db->select('t1.*')
		->from('attribute as t1') 
		->join('product_cat_attribute as t2', 't1.attr_id = t2.attr_id', 'LEFT')
		->join('category as t3', 't3.cat_id = t2.cat_id', 'LEFT')
		->WHERE ('t3.cat_id', $id)
		->WHERE ('t1.attr_deleted', '0')
		->get();
		return $query;
	}

	// new chaneges to get product
	function get_attribute_bysubcat($id) {
		$query = $this->db->select('t1.*')
		->from('attribute as t1') 
		->join('product_cat_attribute as t2', 't1.attr_id = t2.attr_id', 'LEFT')
		->join('sub_category as t3', 't3.sub_cat_id = t2.sub_cat_id', 'LEFT')
		->WHERE ('t3.sub_cat_id', $id)
		->WHERE ('t1.attr_deleted', '0')
		->get();
		return $query;
	}

	// chaneges 
	function get_attributes_values($pro_id) {
		$query = $this->db->select('t1.*')
		->from('attribute_value as t1') 
		->join('attribute as t2', 't1.attr_id = t2.attr_id', 'LEFT')
		->join('product_cat_attribute as t3', 't3.attr_id = t2.attr_id', 'LEFT')
		->join('product_sub_category as t4', 't4.sub_cat_id = t3.sub_cat_id', 'LEFT')
		->join('product as t5', 't5.pro_id = t4.pro_id', 'LEFT')
		->WHERE ('t5.pro_id', $pro_id)
		->WHERE ('t1.attr_val_deleted', '0')
		->get();
		return $query;
	}

	function get_attributes_values_bycat($id) {
		$query = $this->db->select('t1.*')
		->from('attribute_value as t1') 
		->join('attribute as t2', 't1.attr_id = t2.attr_id', 'LEFT')
		->join('product_cat_attribute as t3', 't3.attr_id = t2.attr_id', 'LEFT')
		->join('category as t4', 't4.cat_id = t3.cat_id', 'LEFT')
		->WHERE ('t4.cat_id', $id)
		->WHERE ('t1.attr_val_deleted', '0')
		->get();
		return $query;
	}
	// change
	function get_attributes_values_bysubcat($subcatID) {
		$query = $this->db->select('t1.*')
		->from('attribute_value as t1') 
		->join('attribute as t2', 't1.attr_id = t2.attr_id', 'LEFT')
		->join('product_cat_attribute as t3', 't3.attr_id = t2.attr_id', 'LEFT')
		->join('sub_category as t4', 't4.sub_cat_id = t3.sub_cat_id', 'LEFT')
		->WHERE ('t4.sub_cat_id', $subcatID)
		->WHERE ('t1.attr_val_deleted', '0')
		->get();
		return $query;
	}

	function get_attributes_values_count_bysubcat($scid) {
		$query = $this->db->select('t1.attr_val_id, t1.attr_val_name as atrname, COUNT(*) as Attcount')
		->from('attribute_value as t1') 
		->join('product_attributes_values as t2', 't1.attr_val_id = t2.attr_val_id', 'LEFT')
		->join('product_sub_category as t3', 't3.pro_id = t2.pro_id', 'LEFT')
		->WHERE ('t3.sub_cat_id', $scid)
		->WHERE ('t1.attr_val_deleted', '0')
		->group_by('t1.attr_val_name')
		->get();
		return $query;
	}

	/*** Product Attribute Values ****/

	function add_pro_attr_values($proattrvalinfo)
	{
		$this->db->insert('product_attributes_values', $proattrvalinfo);
		return $this->db->insert_id();
	}

	function delete_pro_attr_values_byproid($pro_id){
		 $this->db->where('pro_id', $pro_id);
        $this->db->delete('product_attributes_values');
	}

	function get_products_by_filter($id, $attributes) {
		if(!empty($attributes))
		{
			$attributescount = count($attributes);
			$this->db->select('t1.*');
			$this->db->from('product as t1');
			$this->db->join('product_sub_category as t2', 't2.pro_id = t1.pro_id', 'LEFT');
			$this->db->join('product_attributes_values as t3', 't3.pro_id = t2.pro_id', 'LEFT');
			$this->db->WHERE_IN ('t3.attr_val_id', $attributes);
			/*foreach($attributes as $attribute)
			{
			$this->db->WHERE ('t3.attr_val_id', $attribute);
			}*/
			$this->db->WHERE ('t2.sub_cat_id', $id);
			$this->db->WHERE ('t1.pro_deleted', '0');
			$this->db->group_by('t1.pro_id');
			$this->db->having('COUNT(DISTINCT t3.attr_val_id)='.$attributescount);
			$query = $this->db->get();
			return $query;
		}
		else
		{
			$query = $this->db->select('t1.*')
			->from('product as t1') 
			->join('product_sub_category as t2', 't2.pro_id = t1.pro_id', 'LEFT')
			->WHERE ('t2.sub_cat_id', $id)
			->WHERE ('t1.pro_deleted', '0')
			->get();
			return $query;
		}
		
	}

	function get_allProducts_count(){
		$query = $this->db->select('COUNT(t1.pro_id) AS allproductscount')
		->from('product as t1') 
		->WHERE ('t1.pro_deleted', '0')
		->get();
		return $query;
	}

	function get_allCategory_count(){
		$query = $this->db->select('COUNT(t1.cat_id) AS allcategorycount')
		->from('category as t1') 
		->WHERE ('t1.cat_deleted', '0')
		->get();
		return $query;
	}

	function get_allSubategory_count(){
		$query = $this->db->select('COUNT(t1.sub_cat_id) AS allsubcategorycount')
		->from('sub_category as t1') 
		->WHERE ('t1.sub_cat_deleted', '0')
		->get();
		return $query;
	}

	function get_allFaq_count(){
		$query = $this->db->select('COUNT(t1.faq_id) AS allfaqcount')
		->from('faqs as t1') 
		->WHERE ('t1.faq_deleted', '0')
		->get();
		return $query;
	}

	function get_allTestimonials_count(){
		$query = $this->db->select('COUNT(t1.testi_id) AS alltestimonialscount')
		->from('testimonials as t1') 
		->WHERE ('t1.testi_deleted', '0')
		->get();
		return $query;
	}

	function get_allBlogs_count(){
		$query = $this->db->select('COUNT(t1.blog_id) AS allblogscount')
		->from('blog as t1') 
		->WHERE ('t1.blog_deleted', '0')
		->get();
		return $query;
	}

	function get_allProducts_inq_count(){
		$query = $this->db->select('COUNT(t1.inq_id) AS allproductsinqcount')
		->from('inquiry as t1') 
		->WHERE ('t1.pro_id !=', '0')
		->get();
		return $query;
	}
	function get_allGenral_inq_count(){
		$query = $this->db->select('COUNT(t1.inq_id) AS allgenralinqcount')
		->from('inquiry as t1') 
		->WHERE ('t1.pro_id', '0')
		->get();
		return $query;
	}	

	// function get_related_products_by_cat($id, $productID) {
	// 	$query = $this->db->select('t1.*')
	// 	->from('product as t1') 
	// 	->join('category as t2', 't2.cat_id = t1.cat_id', 'LEFT')
	// 	->WHERE ('t2.cat_id', $id)
	// 	->WHERE ('t1.pro_deleted', '0')
	// 	->WHERE ('t1.pro_id !=', $productID)
	// 	->order_by('t1.pro_name', 'random')
	// 	->limit (4)
	// 	->get();
	// 	return $query;
	// }
	
	// change
	function get_related_products_by_subcat($subcatID, $productID) {
		$query = $this->db->select('t1.*')
		->from('product as t1') 
		->join('product_sub_category as t2', 't2.pro_id = t1.pro_id', 'LEFT')
		->WHERE ('t2.sub_cat_id', $subcatID)
		->WHERE ('t1.pro_deleted', '0')
		->WHERE ('t1.pro_id !=', $productID)
		->order_by('t1.pro_name', 'random')
		->limit (4)
		->get();
		return $query;
	}

	//for Universal search filter
	// public function search($query) {
	// 	if (empty($query)) {
	// 		return [];
	// 	}

	// 	$this->db->like('cat_name', $query); // Replace 'name' with the column you want to search in
	// 	$this->db->or_like('cat_slug', $query); // Add more columns if needed
	// 	$query = $this->db->get('category'); // Replace 'your_table' with your table name

	// 	return $query->result_array();
	// }

	public function search($query) {
		if (empty($query)) {
			return [];
		}
	
		$results = [];
	
		// Search in 'category' table
		$this->db->select('*');
		$this->db->from('category');
		$this->db->like('cat_name', $query);
		$categoryResults = $this->db->get()->result_array();
	
		// Search in 'sub_category' table
		$this->db->select('sub_cat_name as name, "Sub-Category" as type');
		$this->db->from('sub_category');
		$this->db->like('sub_cat_name', $query);
		$subCategoryResults = $this->db->get()->result_array();
	
		// Search in 'product' table
		$this->db->select('pro_name as name, "Product" as type');
		$this->db->from('product');
		$this->db->like('pro_name', $query);
		$productResults = $this->db->get()->result_array();
	
		// Combine all results
		$results = array_merge($categoryResults, $subCategoryResults, $productResults);
	
		return $results;
	}
	
	

}

?>