<?php $this->load->view('include/header'); ?>
<div class="page">
    <div class="page-main">
        <?php $this->load->view('include/admin-sidebar'); ?>
        <div class="app-content main-content">
            <div class="side-app">
                <?php $this->load->view('include/app-header'); ?>
                <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title">Import Products</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?php echo form_open_multipart('admin/product/import'); ?>
                                    <div class="form-group">
                                        <label for="importFile">Upload Product File</label>
                                        <input type="file" class="form-control" name="import_file" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('include/footer'); ?>
