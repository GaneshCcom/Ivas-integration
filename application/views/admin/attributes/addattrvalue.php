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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Attribute Value</span></h4>

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
								<h4 class="card-title">add Value</h4>
								<div class="card-options mt-sm-max-2">
									<?php 
												$encodeId = base64_encode($attr_id);
													$hexaId = bin2hex($encodeId);
									?>
									<a href="<?php echo base_url() ?>admin/attributes/attrvalueslist?attribute=<?php echo $hexaId; ?>" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="add-attrval" method="post" action="<?php //echo $action; ?>">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Value Name<span class="text-red">*</span></label>
												<input type="text" class="form-control" name="attr_val_name" id="attr_val_name" value="<?php echo set_value('attr_val_name', $this->form_data->attr_val_name); ?>">  <br/>
                          						<?php echo form_error('attr_val_name'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Description </label>
												<input type="text" class="form-control" name="attr_val_desc" id="attr_val_desc">  <br/>
                          						<?php //echo form_error('attr_val_desc'); ?>
											</div>
										</div>
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<label class="form-label">Status <span class="text-red">*</span></label>
												<select class="form-control" name="attr_val_status" id="attr_val_status">
												  	<option value="">Please Select</option>
												  	<option value="0">Inactive</option>
												 	<option value="1">Active</option>
												</select>
												<br/>
						  						<?php echo form_error('attr_val_status'); ?> 
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="hidden" class="form-control" name="attr_id" id="attr_id" value="<?php echo $attr_id; ?>">
										<input type="submit"  name="addattrval"  class="btn btn-primary" value="Add Value">
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