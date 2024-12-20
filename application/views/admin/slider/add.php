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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Slider</span></h4>

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
								<h4 class="card-title">Create Slide</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/slider" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="add-slide" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Sub Title <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="slide_sub_title" id="slide_sub_title" value="<?php echo set_value('slide_sub_title', $this->form_data->slide_sub_title); ?>">  <br/>
                          						<?php echo form_error('slide_sub_title'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Title <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="slide_title" id="slide_title" value="<?php echo set_value('slide_title', $this->form_data->slide_title); ?>">  <br/>
                          						<?php echo form_error('slide_title'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Description <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="slide_desc" id="slide_desc" value="<?php echo set_value('slide_desc', $this->form_data->slide_desc); ?>">  <br/>
                          						<?php echo form_error('slide_desc'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Upload Slide Background</label>
												<div class="input-group file-browser">
													<input class="form-control" name="slide_back_img" type="file" required>
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('slide_back_img'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Upload Slide Mobile Background</label>
												<div class="input-group file-browser">
													<input class="form-control" name="slide_mobile_back_img" type="file" required>
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('slide_mobile_back_img'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Slide Link <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="slide_link" id="slide_link" value="<?php echo set_value('slide_link', $this->form_data->slide_link); ?>">  <br/>
                          						<?php echo form_error('slide_link'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Slide Alignment Class <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="slide_class" id="slide_class" value="<?php echo set_value('slide_class', $this->form_data->slide_class); ?>">  <br/>
                          						<?php echo form_error('slide_class'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<select class="form-control" name="slide_status" id="slide_status">
												  	<option value="">Please Select</option>
												  	<option value="0">Inactive</option>
												 	<option value="1">Active</option>
												</select>
												<br/>
						  						<?php echo form_error('slide_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="addslide"  class="btn btn-primary" value="Add Slide">
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