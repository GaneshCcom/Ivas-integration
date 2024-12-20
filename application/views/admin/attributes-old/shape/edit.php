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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Shapes</span></h4>

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
								<h4 class="card-title">Edit Shape</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/attributes/shape" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="edit-shape" method="post" action="<?php //echo $action; ?>" >
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Shape <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="shape_name" id="shape_name" value="<?php echo set_value('shape_name', $this->form_data->shape_name); ?>">  <br/>
                          						<?php echo form_error('shape_name'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<?php $status = $this->form_data->shape_status; ?>
												<select class="form-control" name="shape_status" id="shape_status">
												  	<option value="">Please Select</option>
												  	<option value="0" <?php if($status == 0){ echo "selected"; } ?>>Inactive</option>
												 	<option value="1" <?php if($status == 1){ echo "selected"; } ?>>Active</option>
												</select>
												<br/>
						  						<?php echo form_error('shape_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="editshape"  class="btn btn-primary" value="Save Changes">
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