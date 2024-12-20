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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Testimonials</span></h4>

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
								<h4 class="card-title">Edit Testimonial</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/testimonials" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="edit-testi" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Testimonial <span class="text-red">*</span></label>
												<textarea class="form-control" name="testimonial" id="testimonial" value="<?php echo set_value('testimonial', $this->form_data->testimonial); ?>"><?php echo set_value('testimonial', $this->form_data->testimonial); ?></textarea> <br/>
                          						<?php echo form_error('testimonial'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Client Name <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="testi_client" id="testi_client" value="<?php echo set_value('testi_client', $this->form_data->testi_client); ?>">  <br/>
                          						<?php echo form_error('testi_client'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Update Client Image</label>
												<img class="mb-3" src="<?php echo base_url(); ?>assets/testi-clients/<?php echo $this->form_data->testi_client_img; ?>" height="70px">
												<div class="input-group file-browser">
													<input class="form-control" name="testi_client_img" type="file">
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('testi_client_img'); ?>
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
												<label class="form-label">Status <span class="text-red">*</span></label>
												<?php $status = $this->form_data->testi_status; ?>
												<select class="form-control" name="testi_status" id="testi_status">
												  	<option value="">Please Select</option>
												  	<option value="0" <?php if($status == 0){ echo "selected"; } ?>>Inactive</option>
												 	<option value="1" <?php if($status == 1){ echo "selected"; } ?>>Active</option>
												</select>
												<br/>
						  						<?php echo form_error('testi_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="edittesti"  class="btn btn-primary" value="Save Changes">
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