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
		    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Electricals</a></li>
		    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>leds/">Lightings</a></li>
		    <li class="breadcrumb-item active" aria-current="page"><?php echo $subcateInfo->sub_cat_name; ?></li>
		  </ol>
		</nav>
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
											if($cate->cat_id == "3")
											{	
												$catslug = "fans";
											}elseif ($cate->cat_id == "2") {
												$catslug = "leds";
											}elseif ($cate->cat_id == "4") {
												$catslug = "heaters";
											}else{
												$catslug = "#";
											} 
							?>
							<div class="form-check">			
							  <a href="<?php echo base_url(); ?>electricals/<?php echo $catslug; ?>/"><input class="form-check-input" type="checkbox" value="<?php echo $cate->cat_id; ?>" name="<?php echo $catslug; ?>" id="cat-<?php echo $catslug; ?>" <?php if($cate->cat_id == "2"){ echo "checked"; } else { echo "unchecked"; } ?> onclick='window.location.assign("<?php echo base_url(); ?><?php echo $catslug; ?>")'>
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
							  <a href="<?php echo base_url(); ?><?php echo $ledcatslug; ?>/category/<?php echo $subcate->sub_cat_slug; ?>/"><input class="form-check-input" type="checkbox" value="<?php echo $subcate->sub_cat_id; ?>" name="<?php echo $subcate->sub_cat_slug; ?>" id="type-<?php echo $subcate->sub_cat_slug; ?>" <?php if($subcate->sub_cat_id == $subcateInfo->sub_cat_id){ echo "checked"; } else { echo "unchecked"; } ?> onclick='window.location.assign("<?php echo base_url(); ?><?php echo $ledcatslug; ?>/category/<?php echo $subcate->sub_cat_slug; ?>")'>
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
									/*if($attribute->attr_name == "Star Ratings")
									{
										$value_parameter = " Star";
									}elseif($attribute->attr_name == "Capacity")
									{
										$value_parameter = " Litre";
									}elseif($attribute->attr_name == "Warranty")
									{
										$value_parameter = " Year";
									}else
									{
										$value_parameter = "";
									}*/
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
					<!--<div class="catsoringdiv">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6">
								<p class="sorting-result-count">showing all 10 results</p>
							</div>	
							<div class="col-xl-6 col-lg-6 col-md-6">
								<form class="orderingfrm">
									<select name="orderby" class="orderby" >
											<option value="menu_order" selected="selected">Default sorting</option>
											<option value="popularity">Sort by popularity</option>
											<option value="rating">Sort by average rating</option>
											<option value="date">Sort by latest</option>
											<option value="price">Sort by price: low to high</option>
											<option value="price-desc">Sort by price: high to low</option>
									</select>
								</form>
							</div>	
						</div>
					</div>-->
					<div class="catlistingblk">
						<div id="prolist" class="row">
							<?php 
								if( count($productlist) > 0 ) { 
									foreach($productlist as $key => $product):
							?>
							<div class="col-xl-3 col-lg-3 col-md-4">
								<div class="productblk">
									<div class="productblkimg">
										<a href="<?php echo base_url(); ?>product/<?php echo $product->pro_slug; ?>/"><img src="<?php echo base_url(); ?>assets/product-img/<?php echo $product->pro_img; ?>" alt="<?php echo $product->pro_name; ?>"></a>
									</div>
									<div class="productblkcnt">
										<h3 class="title"><?php echo $product->pro_name; ?></h3>
										<!--<ul class="productfeatlist">
											<li><img src="<?php echo base_url(); ?>res/images/feature-1-year.png" alt="1 Year"></li>
											<li><img src="<?php echo base_url(); ?>res/images/feature-5-star.png" alt="5 Star"></li>
										</ul>-->
									</div>
									<div class="productblklink">
										<a href="<?php echo base_url(); ?>product/<?php echo $product->pro_slug; ?>/">Explore</a>
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
<div class="whatsnewsec">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<h2 class="sec-title text-center"><span>What's new</span></h2>
			</div>
		</div>
		<div class="row whatsnwdiv">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div id="whatsnew-carousel" class="owl-carousel owl-theme ">
			        <?php if( count($trendLists) > 0 ) {
						foreach($trendLists as $key => $trend): 
					?>
					<div class="item">
			          <div class="whatnwblk">
			          	<div class="imgdiv"><img src="<?php echo base_url(); ?>assets/trending-block-images/<?php echo $trend->trend_img; ?>" alt="<?php echo $trend->trend_title; ?>"></div>
			          	<div class="cntdiv">
			          		<p class="supline"><?php echo $trend->cat_name; ?></p>
			          		<h4 class="title"><?php echo $trend->trend_title; ?></h4>
			          		<p><?php echo $trend->trend_desc; ?></p>
			          		<p class="wnlink"><a href="<?php echo $trend->trend_link; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
			          	</div>
			          </div>
			        </div>
					<?php endforeach; } ?>
				</div>	
			</div>	
		</div>	
	</div>
</div>	
<div class="catalogsec">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xl-6 col-lg-6 col-md-12 text-center">
				<div class="catalogimg">
					<img src="<?php echo base_url(); ?>res/images/broucher-image.png" alt="broucher-image">
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12">
				<div class="catalogcnt">
					<h2 class="sec-title"><span>download catalogue</span></h2>
					<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>-->
					
					<?php if( count($catalogLists) > 0 ) {
						foreach($catalogLists as $key => $catalog):
						if($catalog->cat_name == "Fans")
							{	
								$caticon = "fan-cat-icon.png";
							}elseif ($catalog->cat_name == "Lightings") {
								$caticon = "led-cat-icon.png";
							}elseif ($catalog->cat_name == "Water Heaters") {
								$caticon = "heater-cat-icon.png";
							}else{
								$caticon = "fan-cat-icon.png";
							} 
					?>
					<div class="catalogblk">
						<div class="ctalogttlblk">
							<img src="<?php echo base_url(); ?>res/images/<?php echo $caticon; ?>" alt="<?php echo $catalog->catalog_title; ?>">
							<div class="ttlblk">
								<h4 class="title"><?php echo $catalog->catalog_title; ?></h4>
								<p><?php echo $catalog->catalog_sub_title; ?></p>
							</div>
						</div>
						<div class="downloadbtn">
							<a href="<?php echo base_url(); ?>assets/catalog/<?php echo $catalog->catalog_pdf_file; ?>" download><i class="fa fa-download" aria-hidden="true"></i></a>
						</div>
					</div>
					<?php endforeach; } ?>
				</div>
			</div>	
		</div>
	</div>
</div>
<div class="testisec">
	<div class="container">
		<div class="row">
			<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-12 col-sm-12 me-auto ms-auto">
				<div class="testiblk">
					<h2 class="sec-title text-center"><span>testimonials</span></h2>
					<div id="testimonial-slider" class="owl-carousel">
		                <?php if( count($testimonialLists) > 0 ) {
							$i = 0; 
							foreach($testimonialLists as $key => $testi): 
							 						
						?>
						<div class="testimonial">
		                    <p class="description">
		                        <?php echo $testi->testimonial; ?>
		                    </p>
		                    <div class="pic">
		                    	<?php 
		                    		if ($testi->testi_client_img) {
		                    		?>
		                    		<img src="<?php echo base_url(); ?>assets/testi-clients/<?php echo $testi->testi_client_img; ?>" alt="<?php echo $testi->testi_client; ?>">
		                    		<?php	
		                    		}else{
		                    			?>
		                    		<img src="<?php echo base_url(); ?>res/images/client-testi.png" alt="<?php echo $testi->testi_client; ?>">
		                    	<?php		
		                    		}
		                    	?>
		                    </div>
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
	</div>
</div>
<!--<div class="ctasec">
	<div class="container">
		<div class="row">			
				<div class="col-xxl-10 col-xl-10 col-lg-10 col-md-12 col-sm-12 me-auto ms-auto">
					<div class="ctatitlblk">
						<p>for any inquiry direct contact us here :</p>
						<ul>
							<li><a href="tel:+919900080007"><i class="fa fa-phone" aria-hidden="true"></i> +91-99000 80007</a></li>
							<li><a href="mailto:contact@ivas.homes"><i class="fa fa-envelope" aria-hidden="true"></i> contact@ivas.homes</a></li>
						</ul>
					</div>
					<div class="ctablock">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-12">
								<div class="ctafrmimg text-center">
								<img src="<?php echo base_url(); ?>res/images/shilpa.png" alt="cta image">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 ctafrmback">
								<div class="ctafrm">
									<h3 class="title"><span>get in touch</span></h3>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum.</p>
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
											<textarea name="inq_message" placeholder="Message"></textarea>
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
</div>-->
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
					if($blog->cat_name == "Fans")
							{	
								$caticon = "fan-cat-icon.png";
							}elseif ($blog->cat_name == "Lightings") {
								$caticon = "led-cat-icon.png";
							}elseif ($blog->cat_name == "Water Heaters") {
								$caticon = "heater-cat-icon.png";
							}else{
								$caticon = "fan-cat-icon.png";
							} 
			?>
			<div class="col-xl-4 col-lg-4 col-md-6">
				<div class="blogblock">
					<div class="blogimg">
						<img src="<?php echo base_url(); ?>assets/blogs/<?php echo $blog->blog_img; ?>" alt="<?php echo $blog->blog_title; ?>">
					</div>
					<div class="blogcnt">
						<div class="blogtitlblk">
							<img src="<?php echo base_url(); ?>res/images/<?php echo $caticon; ?>" alt="<?php echo $blog->cat_name; ?>">
							<h4 class="title"><a href="<?php echo base_url(); ?>blogs/detail/<?php echo $blog->blog_slug; ?>/"><?php echo $blog->blog_title; ?></a></h4>
						</div>
						<p><?php echo $blog->blog_short_content; ?></p>	
						<p class="catlink"><a href="<?php echo base_url(); ?>blogs/detail/<?php echo $blog->blog_slug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
					</div>
				</div>
			</div>
			<?php endforeach; } ?>
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
									foreach($faqLists as $key => $faq): 
									 
									if($faq->cat_name == "Fans")
									{	
										$faqclass = "fan";
									}elseif ($faq->cat_name == "Lightings") {
										$faqclass = "led";
									}elseif ($faq->cat_name == "Water Heaters") {
										$faqclass = "heater";
									}else{
										$faqclass = "fan";
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
             url : "<?php echo base_url('leds/filterproducts') ?>",
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