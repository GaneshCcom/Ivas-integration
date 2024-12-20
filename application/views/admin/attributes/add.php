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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Attribute</span></h4>

					</div>
				</div>
				<!--End Page header-->
				
				<!-- Profile Page-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<!-- <div class="flash-message">
							 <?php /*

								if($this->session->flashdata('message') != '')
								{ 

									echo $this->session->flashdata('message');

								} */ ?>	
						</div>	 -->
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title">Create Attribute</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/attributes" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="add-attribute" method="post" action="<?php //echo $action; ?>" >
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Attribute Name <span class="text-red">*</span></label>
												<input type="text" class="form-control" name="attr_name" id="attr_name" value="<?php echo set_value('attr_name', $this->form_data->attr_name); ?>">  <br/>
                          						<?php echo form_error('attr_name'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Attribute Desc</label>
												<textarea class="form-control" name="attr_desc" id="attr_desc"></textarea> <br/>
                          						<?php //echo form_error('attr_desc'); ?>
											</div>
										</div>
										<!-- <div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Category <span class="text-red">*</span></label>
												<select class="form-control" name="cat_id[]" id="cat_id" multiple>
													<option value="">Please Select</option>
													<?php  //if( count($catLists) > 0 ) { foreach($catLists as $key => $cat): ?>
												  	<option value="<?php// echo $cat->cat_id; ?>"><?php// echo $cat->cat_name; ?></option>
												 	<?php// endforeach; } ?>
												</select>
												<br/>
						  						<?php //echo form_error('cat_id'); ?> 
											</div>
										</div> -->
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Category <span class="text-red">*</span></label>
												<select class="form-control" name="sub_cat_id[]" id="sub_cat_id" multiple>
													<option value="">Please Select</option>
													<?php  if( count($subcatLists) > 0 ) { foreach($subcatLists as $key => $subcat): ?>
												  	<option value="<?php echo $subcat->sub_cat_id; ?>"><?php echo $subcat->sub_cat_name; ?></option>
												 	<?php endforeach; } ?>
												</select>
												<br/>
						  						<?php echo form_error('sub_cat_id'); ?> 
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<select class="form-control" name="attr_status" id="attr_status">
												  	<option value="">Please Select</option>
												  	<option value="0">Inactive</option>
												 	<option value="1">Active</option>
												</select>
												<br/>
						  						<?php echo form_error('attr_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="addattribute"  class="btn btn-primary" value="Add Attribute">
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