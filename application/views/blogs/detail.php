<?php $this->load->view('include/header-front'); ?>
<div class="blogpagebannersec" style="background-image: url('<?php echo base_url(); ?>res/images/blog_bg.jpg');">
	<div class="container">	
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12">
				<div class="blgtitlecnt">
					<h1 class="blogtitle"><?php echo $blogInfo->blog_title; ?></h1>
				</div>
			</div>	
		</div>
	</div>
</div>
<div class="blogdetailsec">
	<div class="container">	
		<div class="row">
			<div class="col-xl-9 col-lg-9 col-md-12">
				<div class="blogdetailblk">
					<div class="blgimg">
						<img src="<?php echo base_url(); ?>assets/blogs/<?php echo $blogInfo->blog_img; ?>" alt="<?php echo $blogInfo->blog_title; ?>">
					</div>
					<div class="blgcnt">
						<?php echo $blogInfo->blog_content; ?>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-12">
				<div class="blogsidebarblk">
					<div class="sidebarblk">
						<h4 class="blkttl">Recently Posted</h4>
						<ul class="recentpost">
							<?php if( count($recentposts) > 0 ) { 
							foreach($recentposts as $key => $post):
							?>
							<li><a href="<?php echo base_url(); ?>blogs/detail/<?php echo $post->blog_slug; ?>/"><i class="fa fa-angle-right"></i> <span><?php echo $post->blog_title; ?></span></a></li>
							<?php endforeach; } ?>	
						</ul>
					</div>
				</div>
			</div>	
		</div>	
	</div>	
</div>
<?php $this->load->view('include/footer-front'); ?>