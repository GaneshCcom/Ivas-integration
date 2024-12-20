<footer class="footer">
			<div class="container">
				<div class="row align-items-center flex-row-reverse">
					<div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
						Copyright © <?php echo date('Y'); ?> IVAS. Developed by <a href="https://www.aoneseoservice.com/" target="_blank">AONE SEO SERVICE</a>
					</div>
				</div>
			</div>
		</footer>

		</div>

    	
		<a href="#top" id="back-to-top"><span class="feather feather-chevrons-up"></span></a>

		<!-- Jquery js-->
		<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>

		<!--Moment js-->
		<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.js"></script>

		<!-- Bootstrap4 js-->
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/popper.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/plugins/sidemenu/sidemenu.js"></script>

		<!-- P-scroll js-->
		<script src="<?php echo base_url(); ?>assets/plugins/p-scrollbar/p-scrollbar.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/p-scrollbar/p-scroll1.js"></script>	
		<!-- Select2 js -->
		<script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>

		<!--INTERNAL Horizontalmenu js -->
		<script src="<?php echo base_url(); ?>assets/plugins/horizontal-menu/horizontal-menu.js"></script>

		<!--INTERNAL Sticky js -->
		<script src="<?php echo base_url(); ?>assets/plugins/sticky/sticky2.js"></script>
		
		<!--INTERNAL Toastr js -->
		<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>

		<!--INTERNAL sweetalert js -->
		<script src="<?php echo base_url(); ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
		  <!-- Custom html js-->
		<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
			
		<!-- INTERNAL Vertical-scroll js-->
		<script src="<?php echo base_url(); ?>assets/plugins/vertical-scroll/jquery.bootstrap.newsbox.js"></script>

		<!-- INTERNAL Data tables -->
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/datatablebutton.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/buttonbootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/jszip.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/buttons.html5.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/datatable/js/buttons.print.min.js"></script>

		<!-- INTERNAL Index js-->
		<script src="<?php echo base_url(); ?>assets/js/support/support-sidemenu.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/select2.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote.js"></script>
		<script src="<?php echo base_url(); ?>assets/plugins/dropzone/dropzone.js"></script>
			
<script>
jQuery(document).ready(function () {
    jQuery('#supportticket-dashe').DataTable();
    jQuery('#support-agentlist').DataTable();
    jQuery('#sts-table').DataTable();
});
jQuery(document).ready(function() {
    var table = jQuery('#admin-supportticket-dashe').DataTable( {
        lengthChange: false,
        buttons: [ 'excel' ]
        //buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#admin-supportticket-dashe_wrapper .col-md-6:eq(0)' );
} );
</script>
<script type="application/javascript">
/** After windod Load */
jQuery(window).bind("load", function() {
  window.setTimeout(function() {
    jQuery(".flash-message").fadeTo(500, 0).slideUp(500, function(){
        jQuery(this).remove();
    });
}, 4000);
});
</script>

	</body>
</html>