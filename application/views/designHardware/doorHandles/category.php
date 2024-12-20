<?php $this->load->view('include/header-front'); ?>
<div class="innerpagebannersec subcatbanner" style="background-image: url('<?php echo base_url(); ?>assets/sub-category-back-img/<?php echo $subcateInfo->sub_cat_back_img; ?>');">
	<div class="container">	
	</div>
</div>
<div class="homebreadcrumbsec">
	<div class="container">
	    <nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
		    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Appliances</a></li>
		    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>cooking">Cooking Appliances</li></a></li>
		    <li class="breadcrumb-item active" aria-current="page"><?php echo $subcateInfo->sub_cat_name; ?></li>
		  </ol>
		</nav>
		<!-- <div class="row heading-h1">
		    <h1><?php// echo $subcateInfo->h1_tag; ?></h1>	
        </div> -->
	</div>
</div>	
<div class="catlistingsec">
	<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-3 col-md-12">
				<div class="catsidebar">
					<div class="catfiltblk">
						<h4 class="title">
							<a class="cattoggle" data-bs-toggle="collapse" href="#filtercat" role="button" aria-expanded="true" aria-controls="filtercat">categories</a>
						</h4>
						<div class="collapse show" id="filtercat">
						  <div class="card card-body">
						  	<?php if( count($cateLists) > 0 ) {
								$i = 0; 
								foreach($cateLists as $key => $cate): 
								$i++;
											if($cate->cat_id == "8")
											{	
												$catslug = "door-handles";
											}elseif ($cate->cat_id == "9") {
												$catslug = "door-locks-and-accessories";
											}elseif ($cate->cat_id == "10") {
												$catslug = "furniture-fittings";
											}else{
												$catslug = "#";
											} 
							?>
							<div class="form-check">			
							  <a href="<?php echo base_url(); ?>design-hardware/<?php echo $catslug; ?>/"><input class="form-check-input" type="checkbox" value="<?php echo $cate->cat_id; ?>" name="<?php echo $catslug; ?>" id="cat-<?php echo $catslug; ?>" <?php if($cate->cat_id == "8"){ echo "checked"; } else { echo "unchecked"; } ?> onclick='window.location.assign("<?php echo base_url(); ?><?php echo $catslug; ?>")'>
							  <label class="form-check-label" for="cat-<?php echo $catslug; ?>">
							    <?php echo $cate->cat_name; ?>
							  </label></a>
							</div>
							<?php endforeach; } ?>
						  </div>
						</div>
					</div>
					<div class="catfiltblk">
						<h4 class="title">
							<a class="cattoggle" data-bs-toggle="collapse" href="#filtertypes" role="button" aria-expanded="true" aria-controls="filtertypes">types</a>
						</h4>
						<div class="collapse show" id="filtertypes">
						  <div class="card card-body">
						  	<?php if( count($subcateLists) > 0 ) {
								foreach($subcateLists as $key => $subcate):
							?>	
							<div class="form-check">
							  <a href="<?php echo base_url(); ?>design-hardware/<?php echo $doorhandleslug; ?>/category/<?php echo $subcate->sub_cat_slug; ?>"><input class="form-check-input" type="checkbox" value="<?php echo $subcate->sub_cat_id; ?>" name="<?php echo $subcate->sub_cat_slug; ?>" id="type-<?php echo $subcate->sub_cat_slug; ?>" <?php if($subcate->sub_cat_id == $subcateInfo->sub_cat_id){ echo "checked"; } else { echo "unchecked"; } ?> onclick='window.location.assign("<?php echo base_url(); ?><?php echo $doorhandleslug; ?>/category/<?php echo $subcate->sub_cat_slug; ?>")'>
							  <label class="form-check-label" for="type-<?php echo $subcate->sub_cat_slug; ?>">
							    <?php echo $subcate->sub_cat_name; ?>
							  </label></a>
							</div>
							<?php endforeach; } ?>					
						  </div>
						</div>
					</div>
					<?php foreach($attributeLists as $key => $attribute){ 
						$filtercolaps = preg_replace('/\s+/', '', strtolower($attribute->attr_name));
					?>	
					<div class="catfiltblk <?php echo "catflt".$filtercolaps; ?>">
						<h4 class="title">
							<a class="cattoggle" data-bs-toggle="collapse" href="#<?php echo $filtercolaps; ?>" role="button" aria-expanded="true" aria-controls="<?php echo $filtercolaps; ?>"><?php echo $attribute->attr_name; ?></a>
						</h4>
						<div class="collapse show" id="<?php echo $filtercolaps; ?>">
						  <div class="card card-body">
						  	<?php foreach($attributevalueLists as $key => $attributevalue){ 
								if($attribute->attr_id == $attributevalue->attr_id){	
							?>
						    <?php foreach($attributevaluecount as $key => $attributecount){
								if($attributevalue->attr_val_id == $attributecount->attr_val_id){
									//echo $attributecount->atrname."(".$attributecount->Attcount.")";
							
								?>
						    <div class="form-check d-block">
							  <input class="form-check-input filterchbox" type="checkbox" value="<?php echo $attributevalue->attr_val_id; ?>" name="attributes[]" id="<?php echo $filtercolaps; ?><?php echo $attributevalue->attr_val_id; ?>">
							  <label class="form-check-label" for="<?php echo $filtercolaps; ?><?php echo $attributevalue->attr_val_id; ?>">
							    <?php echo $attributevalue->attr_val_name; ?><?php //echo $value_parameter; ?>
							  </label>
							</div>
						<?php } else{ ?>
							<div class="form-check d-none">
							  <input class="form-check-input filterchbox" type="checkbox" value="<?php echo $attributevalue->attr_val_id; ?>" name="attributes[]" id="<?php echo $filtercolaps; ?><?php echo $attributevalue->attr_val_id; ?>">
							  <label class="form-check-label" for="<?php echo $filtercolaps; ?><?php echo $attributevalue->attr_val_id; ?>">
							    <?php echo $attributevalue->attr_val_name; ?><?php //echo $value_parameter; ?>
							  </label>
							</div>
						<?php } ?>
							<?php } } }?>
						  </div>
						</div>
					</div>	
					<?php	} ?>						
				</div>
			</div>
			<div class="col-xl-9 col-lg-9 col-md-12">
				<div class="catlisting">
					<div class="catlistingblk">
						<div id="prolist" class="row">
							<?php 
								if( count($productlist) > 0 ) { 
									foreach($productlist as $key => $product):
							?>
							<div class="col-xl-3 col-lg-3 col-md-4">
								<div class="productblk">
									<div class="productblkimg">
										<a href="<?php echo base_url(); ?>product/<?php echo $product->pro_slug; ?>"><img src="<?php echo base_url(); ?>assets/product-img/<?php echo $product->pro_img; ?>" alt="<?php echo $product->pro_name; ?>"></a>
									</div>
									<div class="productblkcnt">
										<h3 class="title"><?php echo $product->pro_name; ?></h3>
									</div>
									<div class="productblklink">
										<a href="<?php echo base_url(); ?>product/<?php echo $product->pro_slug; ?>">View</a>
									</div>	
								</div>
							</div>
							<?php endforeach; } else { ?>
								<div class="col-xl-12 col-lg-12 col-md-12">
									<p>No Products found.</p>
								</div>	
							<?php }  ?>		
						</div>	
					</div>	
				</div>
			</div>	
		</div>
	</div>	
</div>
<div class="catalogsec">
	<div class="container">
		<div class="row">
			<div class="catalogdiv">
				<div class="row align-items-center">
					<div class="col-xl-6 col-lg-6 col-md-12">
						<div class="catlogcntblk">
							<p class="supttl">Here is your</p>
							<div class="ttlblk">
								<img src="<?php echo base_url(); ?>res/images/nivas-logo.png" alt="Nivas">
								<span>Catalogue</span>
							</div>
							<p>Flip through our latest catalogue to find the in-trend designs and models of IVAS Appliances. </p>
							<p class="downloadbtn"><span>Download Now</span><a href="<?php echo base_url(); ?>assets/catalog/ivas-home-appliances.pdf" download><i class="fa fa-download" aria-hidden="true"></i></a></p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12">
						<img src="<?php echo base_url(); ?>res/images/catalog.png" alt="catalog">
					</div>
				</div>		
			</div>	
		</div>	
	</div>
</div>
<div class="videoslidersec">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-5 me-auto ms-auto text-center">
				<h2 class="sec-title text-center"><span>our innovation</span></h2>
			</div>		
		</div>
		<div class="row align-items-center">
			<div class="col-xl-9 col-lg-9 col-md-10 me-auto ms-auto">
				<div class="slider-for">
				  	<?php if( count($videoLists) > 0 ) {
						foreach($videoLists as $key => $video): 
					?>
					<div>
					  	<div class="vidodiv">
					  		<?php echo $video->innov_video; ?>
					  	</div>
				  	</div>
					<?php endforeach; } ?>
				</div>
			</div>	
		</div>
		<div class="row">
			<div class="col-xl-8 col-lg-8 col-md-9 me-auto ms-auto">
				<div class="slider-nav">
				  <?php if( count($videoLists) > 0 ) {
						foreach($videoLists as $key => $video): 
					?>
					<div><div class="vidothumb"><img src="<?php echo base_url(); ?>assets/innov-video-thumbs/<?php echo $video->innov_video_thumb; ?>" alt="videothumb"></div></div>
					<?php endforeach; } ?>
				</div>
			</div>	
		</div>	
	</div>
</div>
<?php /*
<div class="testisec">
	<div class="container">
		<div class="row">
			<div class="col-xxl-11 col-xl-11 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="testiblk">
					<div class="testittl"><img src="<?php echo base_url(); ?>res/images/curve-text.png" alt="testimonial"></div>
					<div id="testimonial-slider" class="owl-carousel">
		                <?php if( count($testimonialLists) > 0 ) {
							$i = 0; 
							foreach($testimonialLists as $key => $testi): 
							 						
						?>
						<div class="testimonial">
		                    <p class="description">
		                        <?php echo $testi->testimonial; ?>
		                    </p>
		                    <h3 class="testimonial-title">
		                        <span><?php echo $testi->testi_client; ?></span>
		                    </h3>
		                </div>
						<?php 
						$i++;
						endforeach; } ?>
		            </div>
				</div>
			</div>	
		</div>
		<div class="row">			
				<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-12 col-sm-12 me-auto ms-auto">
					<div class="ctatitlblk">
						<p>for any inquiry direct contact us here :</p>
						<ul>
							<li><a href="tel:+919900080007"><i class="fa fa-phone" aria-hidden="true"></i> +91-99000 80007</a></li>
							<li><a href="mailto:contact@ivas.homes"><i class="fa fa-envelope" aria-hidden="true"></i> contact@ivas.homes</a></li>
						</ul>
					</div>
				</div>
		</div>			
	</div>
</div>
*/ ?>
<div class="homeblogsec">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<h2 class="sec-title text-center"><span>did you know?</span></h2>
			</div>
		</div>
		<div class="row blogdiv">
			<?php if( count($blogLists) > 0 ) { 
					foreach($blogLists as $key => $blog):
					if($blog->cat_name == "Cooking Appliances")
							{	
								$caticon = "cooking-icon.png";
							}elseif ($blog->cat_name == "Kitchen Appliances") {
								$caticon = "kitchen-icon.png";
							}elseif ($blog->cat_name == "Fabric Care Appliances") {
								$caticon = "fabric-icon.png";
							}else{
								$caticon = "ivas-icon.png";
							} 
			?>
			<div class="col-xl-4 col-lg-4 col-md-6">
				<div class="blogblock">
					<div class="blogimg">
						<img src="<?php echo base_url(); ?>assets/blogs/<?php echo $blog->blog_img; ?>" alt="<?php echo $blog->blog_title; ?>">
					</div>
					<div class="blogcnt">
						<div class="blogtitlblk">
							<div class="caticn">
								<img src="<?php echo base_url(); ?>res/images/<?php echo $caticon; ?>" alt="<?php echo $blog->cat_name; ?>">
							</div>
							<h4 class="title"><a href="<?php echo base_url(); ?>blogs/detail/<?php echo $blog->blog_slug; ?>"><?php echo $blog->blog_title; ?></a></h4>
						</div>
						<p><?php echo $blog->blog_short_content; ?></p>	
						<p class="catlink"><a href="<?php echo base_url(); ?>blogs/detail/<?php echo $blog->blog_slug; ?>">view more <i class="fa fa-angle-right"></i></a></p>
					</div>
				</div>
			</div>
			<?php endforeach; } ?>
		</div>
	</div>
</div>
<div class="ctasec">
	<div class="container">
		<div class="row">			
				<div class="col-xxl-11 col-xl-11 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
					<div class="ctablock">
						<div class="row align-items-center">
							<div class="col-xl-7 col-lg-7 col-md-12">
								<div class="row align-items-center">
									<div class="col-xl-5 col-lg-5 col-md-12">
										<div class="ctacntblk">
											<div class="title">
												<span>Transform</span>
												Your Home Today
											</div>
											<p class="subttl">With</p>
											<a href="<?php echo base_url(); ?>cooking" class="catlink">
												<p>cooking<span>appliances</span></p>
												<p class="icn"><i class="fa fa-angle-right" aria-hidden="true"></i></p>
											</a>
											<a href="<?php echo base_url(); ?>kitchen" class="catlink">
												<p>kitchen<span>appliances</span></p>
												<p class="icn"><i class="fa fa-angle-right" aria-hidden="true"></i></p>
											</a>
											<a href="<?php echo base_url(); ?>fabric" class="catlink">
												<p>fabric care<span>appliances</span></p>
												<p class="icn"><i class="fa fa-angle-right" aria-hidden="true"></i></p>
											</a>
										</div>
									</div>	
									<div class="col-xl-7 col-lg-7 col-md-12">
										<div class="ctafrmimg text-center">
										<img src="<?php echo base_url(); ?>res/images/ctaimg.png" alt="cta image">
										</div>
									</div>
								</div>		
							</div>
							<div class="col-xl-5 col-lg-5 col-md-12 ctafrmback">
								<div class="ctafrm">
									<h3 class="title"><span>get in touch</span></h3>
									<p>Got questions? We've got answers for all your home appliance needs!</p>
									<form method="post" id="inquiryfrm">
										<div class="formgroup">
											<input type="text" name="inq_name" placeholder="Name">
											<br/>
					  						<?php echo form_error('inq_name'); ?>
										</div>
										<div class="formgroup">
											<input type="email" name="inq_email" placeholder="Email">
											<br/>
					  						<?php echo form_error('inq_email'); ?>
										</div>
										<div class="formgroup">
											<input type="tel" name="inq_phone" placeholder="Phone  no.">
											<br/>
					  						<?php echo form_error('inq_phone'); ?>
										</div>
										<div class="formgroup">
											<input type="text" name="inq_city" placeholder="City">
											<br/>
					  						<?php echo form_error('inq_city'); ?>
										</div>
										<div class="formgroup">
											<select name="inq_category" class="form-control">
											  <option value="" disabled="" selected="">Select Category</option>
											    <option value="modular-kitchen">Modular Kitchen</option>
											    <option value="designer-hardware">Designer Hardware</option>
											    <option value="sanitaryware">Sanitaryware</option>
											    <option value="tiles">Tiles</option>
											    <option value="bath-fittings">Bath Fittings</option>
											    <option value="fans">Fans</option>
											    <option value="lightings">Lightings</option>
											    <option value="appliances">Appliances</option>
											 </select>
											 <?php echo form_error('inq_category'); ?>
										</div>
										<div class="formgroup">
											<textarea name="inq_message" placeholder="Message"></textarea>
										</div>
										<div class="formgroup">
						                  <div class="g-recaptcha" data-sitekey="6LcRyZ4pAAAAADOncJBDMrCaELeQFlOPx7ihWAo_"></div>
						                  <div id="captcha-error" style="color: red;"></div>
						                </div>
										<div class="formgroup">
											<input type="submit" class="sendbtn" name="sendinquiry" value="Send Us">
										</div>	
									</form>
									<div class="flash-message">
										 <?php 

											if($this->session->flashdata('frmmessage') != '')
											{ 

												echo $this->session->flashdata('frmmessage');

											}?>	
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
		</div>			
	</div>
</div>
<div class="faqsec">
	<div class="container">
			<div class="row">			
				<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-10 col-sm-12 me-auto ms-auto">				<h2 class="sec-title text-center"><span>frequently asked questions</span></h2>
					<div class="accordionCvr">
						<div class="accordion accordion-flush" id="accordionFaq">
							
							  <?php if( count($faqLists) > 0 ) {
									$i = 0; 
									foreach ($faqLists as $key => $faq): 
										// Determine the FAQ class based on category and subcategory
										if ($faq->cat_name == "Cooking Appliances") {
											if ($faq->sub_cat_name == "Chimney") {
												$faqclass = "chimney"; // Specific class for Cooking Appliances - Chimney
											} elseif ($faq->sub_cat_name == "Hob") {
												$faqclass = "hob"; // Specific class for Cooking Appliances - Hob
											} else {
												$faqclass = "cooking"; // Default class for Cooking Appliances
											}
										} elseif ($faq->cat_name == "Kitchen Appliances") {
											$faqclass = "kitchen"; // Class for Kitchen Appliances
										} elseif ($faq->cat_name == "Fabric Care Appliances") {
											$faqclass = "fabric"; // Class for Fabric Care Appliances
										} else {
											$faqclass = "cooking"; // Default fallback class
										}
							  ?>
							  <div class="accordion-item">
								<div class="accordion-header <?php echo $faqclass; ?>" id="flush-headingFour">
								  <button class="accordion-button <?php if($i == 0){}else{ echo "collapsed"; }?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?php echo $i; ?>" aria-expanded="false" aria-controls="faq<?php echo $i; ?>">
									<h3 class="faq-ques"><?php echo $faq->faq_ques; ?> </h3>
								  </button>
								</div>
								<div id="faq<?php echo $i; ?>" class="accordion-collapse collapse <?php if($i == 0){ echo "show"; }else{ }?>" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFaq">
								  <div class="accordion-body"><?php echo $faq->faq_ans; ?></div>
								</div>
							  </div>
							  <?php 
							    $i++;
								endforeach; } ?>				
						</div>
					</div>
				</div>
			</div>
		</div>
</div>

<?php $this->load->view('include/footer-front'); ?>

<script>
    jQuery(document).ready(function() {
        jQuery(".filterchbox").on("change",function(){
        //var cat_id = $(this).val();
		var attributes = [];
		var subcat = "<?php echo $subcateInfo->sub_cat_id; ?>";
		jQuery("input[name='attributes[]']:checked").each(function ()
		{
		    attributes.push(parseInt($(this).val()));
		});	
        jQuery.ajax({
             url : "<?php echo base_url('cooking/filterproducts') ?>",
             type: "post",
             data: {"attributes":attributes, "subcat":subcat},
             success : function(data){
                console.log(data);
        jQuery("#prolist").html(data);
             }
        });
    });
    });
    </script>