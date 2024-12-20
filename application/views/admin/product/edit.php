<?php $this->load->view('include/header');  ?>
<div class="page">
	<div class="page-main">
		<!--aside open-->
       <?php $this->load->view('include/admin-sidebar');  ?>
        <!--aside closed-->
		<div class="app-content main-content">
			<div class="side-app">
				<!--app header-->
				 <?php $this->load->view('include/app-header');  ?>
				<!--/app header-->	
				<div class="page-header d-xl-flex d-block">
					<div class="page-leftheader">
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Products</span></h4>

					</div>
				</div>
				<!--End Page header-->
				
				<!-- Profile Page-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="flash-message mb-5">
							 <?php 

								if($this->session->flashdata('message') != '')
								{ 

									echo $this->session->flashdata('message');

								}?>	
						</div>
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title">Edit Product</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/product" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="edit-product" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Product Name <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="pro_name" id="pro_name" value="<?php echo set_value('pro_name', $this->form_data->pro_name); ?>">  <br/>
                          						<?php echo form_error('pro_name'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Parent Category <span class="text-red">*</span></label>
												<?php $parId = $this->form_data->par_id; ?>
												<select class="form-control" name="par_id" id="par_id">
													<option value="">Please Select</option>
													<?php  if( count($parCatLists) > 0 ) { foreach($parCatLists as $key => $parentCat): ?>
												  	<option value="<?php echo $parentCat->par_id; ?>" <?php if($parentCat->par_id == $parId ) { echo "selected"; } ?>><?php echo $parentCat->par_cat_name; ?></option>
												 	<?php endforeach; } ?>
												</select>
												<br/>
						  						<?php echo form_error('par_id'); ?> 
											</div>
										</div>
										<!-- <div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Category <span class="text-red">*</span></label>
												<?php //$catId = $this->form_data->cat_id; ?>
												<select class="form-control" name="cat_id" id="cat_id">
													<option value="">Please Select</option>
													<?php  //if( count($catLists) > 0 ) { foreach($catLists as $key => $cat): ?>
												  	<option value="<?php //echo $cat->cat_id; ?>" <?php //if($cat->cat_id == $catId ) { echo "selected"; } ?>><?php //echo $cat->cat_name; ?></option>
												 	<?php //endforeach; } ?>
												</select>
												<br/>
						  						<?php //echo form_error('cat_id'); ?> 
											</div>
										</div> -->
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Category <span class="text-red">*</span></label>
												<?php 
												 
												$proCatLists = explode(',', $proCatLists->cate_list);
												?>
												<select class="form-control" name="cat_id" id="cat_id" multiple>
													<?php  if( count($catLists) > 0 ) { foreach($catLists as $key => $cat): ?>
														<option value="<?php echo $cat->cat_id; ?>" <?php  if(in_array($cat->cat_id,$proCatLists)) { echo "selected"; }  ?>><?php echo $cat->cat_name; ?></option>
													<?php endforeach; } ?>
												</select>
												<br/>
						  						<?php echo form_error('cat_id'); ?> 
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Sub Category <span class="text-red">*</span></label>
												<?php 
												 
												$prosubcatLists = explode(',', $prosubcatLists->subcate_list);
												?>
												<select class="form-control" name="sub_cat_id[]" id="sub_cat_id" multiple>
													<?php  if( count($subcateLists) > 0 ) { foreach($subcateLists as $key => $subcat): ?>
														<option value="<?php echo $subcat->sub_cat_id; ?>" <?php  if(in_array($subcat->sub_cat_id,$prosubcatLists)) { echo "selected"; }  ?>><?php echo $subcat->sub_cat_name; ?></option>
													<?php endforeach; } ?>
												</select>
												<br/>
						  						<?php echo form_error('sub_cat_id'); ?> 
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Upload Product Img</label>
												<img class="mb-3" src="<?php echo base_url(); ?>assets/product-img/<?php echo $this->form_data->pro_img; ?>" height="70px">
												<div class="input-group file-browser">
													<input class="form-control" name="pro_img" type="file">
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('pro_img'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Meta Title <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="meta_title" id="meta_title" value="<?php echo set_value('meta_title', $this->form_data->meta_title); ?>">  <br/>
                          						<?php echo form_error('meta_title'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Meta Description <span class="text-red">*</span></label>
												<textarea class="form-control" name="meta_desc" id="meta_desc" value="<?php echo set_value('meta_desc', $this->form_data->meta_desc); ?>"><?php echo set_value('meta_desc', $this->form_data->meta_desc); ?></textarea> <br/>
                          						<?php echo form_error('meta_desc'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Meta Keywords <span class="text-red">*</span></label>
												<textarea class="form-control" name="meta_keyword" id="meta_keyword" value="<?php echo set_value('meta_keyword', $this->form_data->meta_keyword); ?>"><?php echo set_value('meta_keyword', $this->form_data->meta_keyword); ?></textarea> <br/>
                          						<?php echo form_error('meta_keyword'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Amazon Link<span class="text-red"></span></label>
												<textarea class="form-control" name="amazon_link" id="amazon_link" value="<?php echo set_value('amazon_link', $this->form_data->amazon_link); ?>"><?php echo set_value('amazon_link', $this->form_data->amazon_link); ?></textarea> <br/>
                          						<?php echo form_error('amazon_link'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<?php $status = $this->form_data->pro_status; ?>
												<select class="form-control" name="pro_status" id="pro_status">
												  	<option value="">Please Select</option>
												  	<option value="0" <?php if($status == 0){ echo "selected"; } ?>>Inactive</option>
												 	<option value="1" <?php if($status == 1){ echo "selected"; } ?>>Active</option>
												</select>
												<br/>
						  						<?php echo form_error('pro_status'); ?> 
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Product Order <span class="text-red"></span></label>
												<input type="text" class="form-control" name="vorder" id="vorder" value="<?php echo set_value('vorder', $this->form_data->vorder); ?>">  <br/>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="editproduct"  class="btn btn-primary" value="Save Changes">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>		
<script>
    jQuery(document).ready(function() {
        jQuery("#cat_id").on("change",function(){
        var cat_id = $(this).val();
     
        jQuery.ajax({
             url : "<?php echo base_url('admin/product/get_sub_category') ?>",
             type: "post",
             data: {"cat_id":cat_id},
             success : function(data){
                //alert(data);
        jQuery("#sub_cat_id").html(data);
             }
        });
    });
    });
</script>