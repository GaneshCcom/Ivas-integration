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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Product Gallery</span></h4>

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
								<h4 class="card-title">Product Gallery</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/product" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="add-product-gallery" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group mb-5">
												<div class="row">
													<div class="col-md-12">
														<div class="row">
														<?php if( count($imagesLists) > 0 ) {
															$i = 0; 
															foreach($imagesLists as $key => $image): 
															$i++; 
															$encodeId = base64_encode($image->pro_glry_id);
															$hexaId = bin2hex($encodeId);
														?>
														<div class="col-md-2 text-center">
															<div class="p-2" style="border: 2px solid #efefef;">
															<img src="<?php echo base_url(); ?>assets/product-img/<?php echo $image->pro_glry_img; ?>">

															 <?php echo anchor('/admin/product/deleteproductgalleryimg/'.$hexaId,'<i class="feather feather-trash-2 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>',array('class'=>'action-btns1','onclick'=>"return confirm('Are you sure want to delete this Product Image?')"));?>
															</div>
														</div>	
														<?php endforeach; } else { ?>
															<p>No Image Found</p>
														<?php }  ?>	
														</div>
													</div>
												</div>	
											</div>	
											<div class="form-group">
												<div class="row">
													<div class="col-md-3">
														<label class="form-label mb-0 mt-2">Upload Image</label>
													</div>
													<div class="col-md-9">
														<div class="form-group mb-0">
															<div class="needsclick dropzone" id="fileattachment" ></div>
														</div>
														<small class="text-muted"><i>The file size should not be more than 3MB</i></small>
														<div class="tktattchmentImages"></div>
													</div>
												</div>
											</div>

										</div>
										
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="updategallery"  class="btn btn-primary" value="Save">
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
//Disabling autoDiscover
Dropzone.autoDiscover = false;

$(function() {
    //Dropzone class
    //var baseurl = "<?php //echo base_url(); ?>";
    var uploadedDocumentMap = {}
    var myDropzone = new Dropzone("#fileattachment", {
        url: "<?php echo site_url('admin/product/fileUpload'); ?>",
        paramName: "file",
        maxFilesize: 1,
        maxFiles: 3,
        acceptedFiles: "image/*",
        addRemoveLinks: true,
		dictRemoveFile: "Remove",
        autoProcessQueue: true,
		renameFile: function (file) {
		    let newName = new Date().getTime() + '_' + file.name;
		    return newName;
		},
		success: function (file, response) {
			//console.log(response);
			//uploadedDocumentMap[file.name] = response.name
			$('.tktattchmentImages').append('<input type="hidden" name="ticket[]" value="' + response + '">')
			//uploadedDocumentMap[file.name] = response.name
		},
    });

   
   //$('#createticketBtn').click(function(){           
        //myDropzone.processQueue();
    //});
});

</script>