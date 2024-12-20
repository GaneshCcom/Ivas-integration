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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Innovation Videos</span></h4>

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
								<h4 class="card-title">Edit Innovation Video</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/videos" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="edit-video" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Innovation Video Embed Code <span class="text-red">*</span></label>
												<textarea class="form-control" name="innov_video" id="innov_video" value="<?php echo set_value('innov_video', $this->form_data->innov_video); ?>"><?php echo set_value('innov_video', $this->form_data->innov_video); ?></textarea> <br/>
                          						<?php echo form_error('innov_video'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Upload Video Thumb</label>
												<img class="mb-3" src="<?php echo base_url(); ?>assets/innov-video-thumbs/<?php echo $this->form_data->innov_video_thumb; ?>" height="100px">
												<div class="input-group file-browser">
													<input class="form-control" name="innov_video_thumb" type="file">
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('innov_video_thumb'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Parent Category <span class="text-red">*</span></label>
												<?php $parId = $this->form_data->par_id; ?>
												<select class="form-control" name="par_id" id="par_id">
													<option value="">Please Select</option>
													<?php  if( count($parCatLists) > 0 ) { foreach($parCatLists as $key => $cat): ?>
												  	<option value="<?php echo $cat->par_id; ?>" <?php if($cat->par_id == $parId ) { echo "selected"; } ?>><?php echo $cat->par_cat_name; ?></option>
												 	<?php endforeach; } ?>
												</select>
												<br/>
						  						<?php echo form_error('par_id'); ?> 
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<?php $status = $this->form_data->innov_status; ?>
												<select class="form-control" name="innov_status" id="innov_status">
												  	<option value="">Please Select</option>
												  	<option value="0" <?php if($status == 0){ echo "selected"; } ?>>Inactive</option>
												 	<option value="1" <?php if($status == 1){ echo "selected"; } ?>>Active</option>
												</select>
												<br/>
						  						<?php echo form_error('innov_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="editvideo"  class="btn btn-primary" value="Save Changes">
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