<?php $this->load->view('include/header-front'); ?>
<div class="innerpagebannersec" style="background-image: url('<?php echo base_url(); ?>assets/category-back-img/<?php echo $cateInfo->cat_back_img; ?>');">
	<div class="container">	
	</div>
	<div class="hminqfrm d-lg-block d-none">
		<div class="ctafrm">
			<h3 class="title"><span>Enquiry Form</span></h3>
			<form method="post" id="inquiryfrm">
				<div class="row">
	  				<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
						<div class="formgroup">
							<input type="text" name="inq_name" placeholder="Name">
							<br/>
					  		<?php echo form_error('inq_name'); ?>
						</div>
					</div>
					<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
						<div class="formgroup">
							<input type="email" name="inq_email" placeholder="Email">
							<br/>
					  		<?php echo form_error('inq_email'); ?>
						</div>
					</div>
					<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
						<div class="formgroup">
							<input type="tel" name="inq_phone" placeholder="Phone  no.">
							<br/>
					  		<?php echo form_error('inq_phone'); ?>
						</div>
					</div>
					<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
						<div class="formgroup">
							<input type="text" name="inq_city" placeholder="City">
							<br/>
					  		<?php echo form_error('inq_city'); ?>
						</div>
					</div>
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
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
					</div>
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
						<div class="formgroup">
							<textarea name="inq_message" placeholder="Message"></textarea>
						</div>
					</div>
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
					<div class="formgroup">
						                  <div class="g-recaptcha" data-sitekey="6LcRyZ4pAAAAADOncJBDMrCaELeQFlOPx7ihWAo_"></div>
						                  <div id="captcha-error" style="color: red;"></div>
						    </div>
						</div>
					<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
						<div class="formgroup">
							<input type="submit" class="sendbtn" name="sendinquiry" value="Call Me Back">
						</div>	
					</div>
				</div>
			</form>
			<div class="flash-message mb-2">
				<?php 
					if($this->session->flashdata('frmmessage') != '')
					{ 
						echo $this->session->flashdata('frmmessage');
					}
				?>	
			</div>
			<p class="privacytxt">By submitting this form, you agree to the <a href="../privacy-policy/" target="_blank">privacy policy</a> &amp; <a href="../terms-and-conditions/" target="_blank">terms and conditions</a></p>
		</div>
	</div>
</div>
<div class="homebreadcrumbsec">
	<div class="container">
	    <nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
		    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Electricals</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Fans</li>
		  </ol>
		</nav>
	</div>
</div>	
<div class="fancatsec">
	<div class="container">
		<div class="row">
			<div class="col-xl-7 col-lg-7 col-md-12 me-auto ms-auto text-center">
				<h2 class="sec-title text-center"><span>Efficiency & Convenience in a Breeze</span></h2>
				<p>IVAS Electricals offers fans for every purpose from ventilation to luxurious decoration. Find all kinds of ceiling fans, pedestal fans, ventilation fans and more.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-11 col-lg-11 col-md-12 me-auto ms-auto text-center">
				<div class="fancatdiv">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-12">
							<div class="fancatblk fanblk1">
								<a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_tpwInfo->sub_cat_slug; ?>/"><img src="<?php echo base_url(); ?>assets/sub-category-list-img/<?php echo $subcat_tpwInfo->sub_cat_list_img; ?>" alt="<?php echo $subcat_tpwInfo->sub_cat_name; ?>"></a>
								<div class="fancatblkcnt">
									<h2 class="title"><?php echo $subcat_tpwInfo->sub_cat_name; ?></h2>
									<p><?php echo $subcat_tpwInfo->sub_cat_desc; ?></p>
									<p class="fnlink"><a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_tpwInfo->sub_cat_slug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-12">
							<div class="fancatblk fanblk2">
								<a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_bldcInfo->sub_cat_slug; ?>/"><img src="<?php echo base_url(); ?>assets/sub-category-list-img/<?php echo $subcat_bldcInfo->sub_cat_list_img; ?>" alt="<?php echo $subcat_bldcInfo->sub_cat_name; ?>"></a>
								<div class="fancatblkcnt">
									<h2 class="title"><?php echo $subcat_bldcInfo->sub_cat_name; ?></h2>
									<p><?php echo $subcat_bldcInfo->sub_cat_desc; ?></p>
									<p class="fnlink"><a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_bldcInfo->sub_cat_slug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
								</div>
							</div>
						</div>	
					</div>	
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-6">
							<div class="fancatblks2">
								<a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_cellingInfo->sub_cat_slug; ?>/"><img src="<?php echo base_url(); ?>assets/sub-category-list-img/<?php echo $subcat_cellingInfo->sub_cat_list_img; ?>" alt="<?php echo $subcat_cellingInfo->sub_cat_name; ?>"></a>
								<div class="fancatblkcnt">
									<h2 class="title"><?php echo $subcat_cellingInfo->sub_cat_name; ?></h2>
									<p><?php echo $subcat_cellingInfo->sub_cat_desc; ?></p>
									<p class="fnlink"><a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_cellingInfo->sub_cat_slug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-6">
							<div class="fancatblks2">
								<a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_ventilationInfo->sub_cat_slug; ?>/"><img src="<?php echo base_url(); ?>assets/sub-category-list-img/<?php echo $subcat_ventilationInfo->sub_cat_list_img; ?>" alt="<?php echo $subcat_ventilationInfo->sub_cat_name; ?>/"></a>
								<div class="fancatblkcnt">
									<h2 class="title"><?php echo $subcat_ventilationInfo->sub_cat_name; ?></h2>
									<p><?php echo $subcat_ventilationInfo->sub_cat_desc; ?></p>
									<p class="fnlink"><a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_ventilationInfo->sub_cat_slug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-6">
							<div class="fancatblks2">
								<a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_decorativeInfo->sub_cat_slug; ?>/"><img src="<?php echo base_url(); ?>assets/sub-category-list-img/<?php echo $subcat_decorativeInfo->sub_cat_list_img; ?>" alt="<?php echo $subcat_decorativeInfo->sub_cat_name; ?>"></a>
								<div class="fancatblkcnt">
									<h2 class="title"><?php echo $subcat_decorativeInfo->sub_cat_name; ?></h2>
									<p><?php echo $subcat_decorativeInfo->sub_cat_desc; ?></p>
									<p class="fnlink"><a href="<?php echo base_url(); ?>sanitaryware/wash-basins/category/<?php echo $subcat_decorativeInfo->sub_cat_slug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
								</div>
							</div>
						</div>	
					</div>	
				</div>
			</div>
		</div>			
	</div>
</div>
<div class="whyussec">
	<div class="container">
		<div class="row">
			<div class="col-xl-8 col-lg-8 col-md-12">
				<h2 class="sec-title"><span>why choose us?</span></h2>
				<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy.</p>-->
				<div class="row">
					<?php if( count($reasonLists) > 0 ) {
						foreach($reasonLists as $key => $reason): 
					?>
					<div class="col-xl-4 col-lg-4 col-md-4">
						<div class="whyblk">
							<img src="<?php echo base_url(); ?>assets/reason-icons/<?php echo $reason->reas_icon; ?>" alt="<?php echo $reason->reas_title; ?>">
							<h5 class="title"><?php echo $reason->reas_title; ?></h5>
							<p><?php echo $reason->reas_desc; ?></p>
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