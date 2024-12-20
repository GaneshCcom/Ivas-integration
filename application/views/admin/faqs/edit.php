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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Faq</span></h4>
					</div>
				</div>
				<!--End Page header-->
				
				<!-- Profile Page-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title">Edit Faq</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/faqs" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="edit-dept" name="edit-faq" method="post" action="<?php //echo $action; ?>" >
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-6 col-md-6">
											<div class="form-group">
												<label class="form-label">Question <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="faq_ques" id="faq_ques" value="<?php echo set_value('faq_ques', $this->form_data->faq_ques); ?>">  <br/>
                          						<?php echo form_error('faq_ques'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Answer <span class="text-red">*</span></label>
												<textarea class="form-control" name="faq_ans" id="faq_ans" value="<?php echo set_value('faq_ans', $this->form_data->faq_ans); ?>"><?php echo set_value('faq_ans', $this->form_data->faq_ans); ?></textarea> <br/>
                          						<?php echo form_error('faq_ans'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Category <span class="text-red">*</span></label>
												<?php $catId = $this->form_data->cat_id; ?>
												<select class="form-control" name="cat_id" id="cat_id">
													<option value="">Please Select</option>
													<?php  if( count($catLists) > 0 ) { foreach($catLists as $key => $cat): ?>
												  	<option value="<?php echo $cat->cat_id; ?>" <?php if($cat->cat_id == $catId ) { echo "selected"; } ?>><?php echo $cat->cat_name; ?></option>
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
												 $subCatId = $this->form_data->sub_cat_id;
												// $prosubcatLists = explode(',', $prosubcatLists->subcate_list);
												?>
												<select class="form-control" name="sub_cat_id" id="sub_cat_id" multiple>
													<?php  if( count($subcateLists) > 0 ) { foreach($subcateLists as $key => $subcat): ?>
														<option value="<?php echo $subcat->sub_cat_id; ?>" <?php  if($subcat->sub_cat_id == $subCatId) { echo "selected"; }  ?>><?php echo $subcat->sub_cat_name; ?></option>
													<?php endforeach; } ?>
												</select>
												<br/>
						  						<?php echo form_error('sub_cat_id'); ?> 
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<?php $status = $this->form_data->faq_status; ?>
												<select class="form-control" name="faq_status" id="faq_status">
												  	<option value="">Please Select</option>
												  	<option value="0" <?php if($status == 0){ echo "selected"; } ?>>Inactive</option>
												 	<option value="1" <?php if($status == 1){ echo "selected"; } ?>>Active</option>
												</select>
												<br/>
						  						<?php echo form_error('faq_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="editfaq"  class="btn btn-primary" value="Save Changes">
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
             url : "<?php echo base_url('admin/faqs/get_sub_category') ?>",
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