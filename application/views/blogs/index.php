<?php $this->load->view('include/header-front'); ?>
<div class="blogpagebannersec" style="background-image: url('<?php echo base_url(); ?>res/images/blog_bg.jpg');">
	<div class="container">	
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="blgtitlecnt">
					<h1 class="blogtitle">Blog</h1>
				</div>
			</div>	
		</div>
	</div>
</div>
<div class="homeblogsec">
	<div class="container">
		<div class="row blogdiv">
			<?php if( count($blogLists) > 0 ) { 
					foreach($blogLists as $key => $blog):
					if($blog->cat_name == "Fans")
							{	
								$caticon = "fan-cat-icon.png";
							}elseif ($blog->cat_name == "Lighting") {
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
<?php $this->load->view('include/footer-front'); ?>