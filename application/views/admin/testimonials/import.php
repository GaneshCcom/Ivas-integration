<?php $this->load->view('include/header'); ?>
<div class="page">
    <div class="page-main">
        <?php $this->load->view('include/admin-sidebar'); ?>
        <div class="app-content main-content">
            <div class="side-app">
                <?php $this->load->view('include/app-header'); ?>
                <div class="page-header d-xl-flex d-block">
                    <div class="page-leftheader">
                        <h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Import Testimonials</span></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="flash-message mb-5">
                            <?php if($this->session->flashdata('message') != '') { 
                                echo $this->session->flashdata('message');
                            }?>
                        </div>
                        <div class="card">
                            <div class="card-header border-0">
                                <h4 class="card-title">Import Testimonials from Excel</h4>
                                <div class="card-options mt-sm-max-2">
                                    <a href="<?php echo base_url() ?>admin/testimonials" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
                                </div>
                            </div>
                            <form method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Upload Excel File <span class="text-red">*</span></label>
                                                <input type="file" class="form-control" name="testimonials_file" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 card-footer">
                                    <div class="form-group float-end">
                                        <input type="submit" class="btn btn-primary" value="Import Testimonials">
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
