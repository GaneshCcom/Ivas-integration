<?php $this->load->view('include/header-front'); ?>
<div class="homebannersec">
 	<div id="carouselExampleIndicators" class="carousel slide carousel-fade">
	  <div class="carousel-inner">
	    <?php if( count($slideLists) > 0 ) {
			$i = 0; 
			foreach($slideLists as $key => $slide):  
		?>
		<div class="carousel-item <?php if($i == 0){ echo "active"; } ?>">
	      <img src="<?php echo base_url(); ?>assets/slider/<?php echo $slide->slide_back_img; ?>" class="w-100 d-none d-sm-block" alt="Slide <?php  echo $i; ?>">
	      <img src="<?php echo base_url(); ?>assets/slider/<?php echo $slide->slide_mobile_back_img; ?>" class="w-100 d-block d-sm-none" alt="Slide <?php  echo $i; ?>">
	    </div>
		<?php 
			$i++;
			endforeach; } ?>
	  </div>
	  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Previous</span>
	  </button>
	  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Next</span>
	  </button>
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

											}?>	
									</div>
									<p class="privacytxt">By submitting this form, you agree to the <a href="../privacy-policy.php" target="_blank">privacy policy</a> &amp; <a href="../terms-and-conditions.php" target="_blank">terms and conditions</a></p>
								</div>
	  </div>
	</div>
 </div>
<div class="homebreadcrumbsec">
	<div class="container">
	    <nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Appliances</li>
		  </ol>
		</nav>
		<!-- <div class="row heading-h1">
		    <center><h1>Quality Home Appliances for Every Need</h1></center>
        </div> -->
	</div>
</div>	
<div class="homecategorysec">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-5 me-auto ms-auto text-center">
				<h2 class="sec-title text-center"><span>Our Category</span></h2>
			</div>		
		</div>
		<div class="row">
			<div class="col-xl-10 col-xl-11 col-lg-12 col-md-12 me-auto ms-auto">
				<div class="homecatlist">
					<?php if( count($cateLists) > 0 ) {
						$i = 1; 
						foreach($cateLists as $key => $cate): 
									if($cate->cat_name == "Faucets")
									{	
										$catslug = "faucets";
									}elseif ($cate->cat_name == "Showers") {
										$catslug = "showers";
									}elseif ($cate->cat_name == "Accessories and Mirrors") {
										$catslug = "accessories-and-mirrors";
									}else{
										$catslug = "#";
									}
						if($i % 2 == 0){			 
					?>
				<div class="row catblkrow catblkrgt align-items-center">	
					<div class="col-xl-6 col-lg-6 col-md-12">					
						<div class="catcntblk">
							<h3 class="title"><span><?php echo $cate->cat_name; ?></span></h3>
							<p><?php echo $cate->cat_desc; ?></p>
							<?php 
							if(!empty($cate->subs)) { 
							?>
							<div class="row">
								<?php foreach ($cate->subs as $sub)  { ?>
								<div class="col-xl-4 col-lg-4 col-md-4 col-6">
									<div class="subcatblk">
										<a href="<?php echo base_url(); ?>bath-fittings/<?php echo $catslug; ?>/category/<?php echo $sub->sub_cat_slug; ?>">
											<figure><img src="<?php echo base_url(); ?>assets/sub-category-thumb-img/<?php echo $sub->sub_cat_thumb_img; ?>" alt="<?php echo $sub->sub_cat_name; ?>"></figure>
											<h4 class="title"><?php echo $sub->sub_cat_name; ?></h4>
										</a>	
									</div>
								</div>
								<?php } ?>	
							</div>	
							<?php } ?>
							<hr/>
							<p class="link"><a href="<?php echo base_url(); ?>bath-fittings/<?php echo $catslug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-12">
						<div class="catimgblk">
							<figure><img src="<?php echo base_url(); ?>assets/category-list-img/<?php echo $cate->cat_list_img; ?>" alt="<?php echo $cate->cat_name; ?>"></figure>
						</div>
					</div>	
				</div>	
					<?php          
                        } 
                        else{ 
                    ?> 
				<div class="row catblkrow catblklft align-items-center">
					<div class="col-xl-6 col-lg-6 col-md-12">
						<div class="catimgblk">
							<figure><img src="<?php echo base_url(); ?>assets/category-list-img/<?php echo $cate->cat_list_img; ?>" alt="<?php echo $cate->cat_name; ?>"></figure>
						</div>
					</div>	
					<div class="col-xl-6 col-lg-6 col-md-12">					
						<div class="catcntblk">
							<h3 class="title"><span><?php echo $cate->cat_name; ?></span></h3>
							<p><?php echo $cate->cat_desc; ?></p>
							<?php 
							if(!empty($cate->subs)) { 
							?>
							<div class="row">
								<?php foreach ($cate->subs as $sub)  { ?>
								<div class="col-xl-4 col-lg-4 col-md-4 col-6">
									<div class="subcatblk">
										<a href="<?php echo base_url(); ?>bath-fittings/<?php echo $catslug; ?>/category/<?php echo $sub->sub_cat_slug; ?>">
											<figure><img src="<?php echo base_url(); ?>assets/sub-category-thumb-img/<?php echo $sub->sub_cat_thumb_img; ?>" alt="<?php echo $sub->sub_cat_name; ?>"></figure>
											<h4 class="title"><?php echo $sub->sub_cat_name; ?></h4>
										</a>	
									</div>
								</div>
								<?php } ?>	
							</div>
							<?php } ?>
							<hr/>
							<p class="link"><a href="<?php echo base_url(); ?>bath-fittings/<?php echo $catslug; ?>/">view more <i class="fa fa-angle-right"></i></a></p>
						</div>
					</div>	
				</div>	
					<?php 
					}
					$i++;
					endforeach; 
					} 
					?>
				</div>
			</div>	
		</div>		
	</div>	
</div>

<div class="whyussec">
	<div class="container">
		<div class="row">
			<div class="col-xl-6 col-lg-6 col-md-5 me-auto ms-auto text-center">
				<h2 class="sec-title text-center"><span>why choose us?</span></h2>
			</div>		
		</div>
				<div class="row justify-content-center">
					<?php if( count($reasonLists) > 0 ) {
						foreach($reasonLists as $key => $reason): 
					?>
					<div class="col-xl-4 col-lg-4 col-md-6">
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
</div> */ ?>
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
							<h4 class="title"><a href="https://staging.ivas.homes/blog/<?php echo $blog->blog_slug; ?>"><?php echo $blog->blog_title; ?></a></h4>
						</div>
						<p><?php echo $blog->blog_short_content; ?></p>	
						<p class="catlink">
						
						<!--<a href="<?php //echo base_url(); ?>blogs/detail/<?php //echo $blog->blog_slug; ?>">view more <i class="fa fa-angle-right"></i></a>-->
						<a href="https://staging.ivas.homes/blog/<?php echo $blog->blog_slug; ?>">view more <i class="fa fa-angle-right"></i></a>
						</p>
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
											<input type="tel" name="inq_phone" pattern="[6-9][0-9]{9}" placeholder="Phone  no.">
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
									foreach($faqLists as $key => $faq): 
									 
									if($faq->cat_name == "Cooking Appliances")
									{	
										$faqclass = "cooking";
									}elseif ($faq->cat_name == "Kitchen Appliances") {
										$faqclass = "kitchen";
									}elseif ($faq->cat_name == "Fabric Care Appliances") {
										$faqclass = "fabric";
									}else{
										$faqclass = "cooking";
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