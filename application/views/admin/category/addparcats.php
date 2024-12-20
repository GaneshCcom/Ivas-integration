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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Parent Category</span></h4>

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
								<h4 class="card-title">Create Parent Category</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/category/parcats" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="add-parcats" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Parent Category Name <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="par_cat_name" id="par_cat_name" value="<?php echo set_value('par_cat_name', $this->form_data->par_cat_name); ?>">  <br/>
                          						<?php echo form_error('par_cat_name'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Parent Category Description <span class="text-red">*</span></label>
												<textarea class="form-control" name="par_cat_desc" id="par_cat_desc" value="<?php echo set_value('par_cat_desc', $this->form_data->par_cat_desc); ?>"></textarea> <br/>
                          						<?php echo form_error('par_cat_desc'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Upload Category Banner Img</label>
												<div class="input-group file-browser">
													<input class="form-control" name="par_cat_back_img" type="file" required>
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('par_cat_back_img'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Upload Category List Img</label>
												<div class="input-group file-browser">
													<input class="form-control" name="par_cat_list_img" type="file" required>
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('par_cat_list_img'); ?>
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
												<textarea class="form-control" name="meta_desc" id="meta_desc" value="<?php echo set_value('meta_desc', $this->form_data->meta_desc); ?>"></textarea> <br/>
                          						<?php echo form_error('meta_desc'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Meta Keywords <span class="text-red">*</span></label>
												<textarea class="form-control" name="meta_keyword" id="meta_keyword" value="<?php echo set_value('meta_keyword', $this->form_data->meta_keyword); ?>"></textarea> <br/>
                          						<?php echo form_error('meta_keyword'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<select class="form-control" name="par_cat_status" id="par_cat_status">
												  	<option value="">Please Select</option>
												  	<option value="0">Inactive</option>
												 	<option value="1">Active</option>
												</select>
												<br/>
						  						<?php echo form_error('par_cat_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="addparcats"  class="btn btn-primary" value="Add Parent Category">
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