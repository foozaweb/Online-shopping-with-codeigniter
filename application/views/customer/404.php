<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav'); ?>

<!-- Error -->
<section class="error-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-box text-center">
                    <h1>4<span>0</span>4</h1>
                    <h3>Page Not Found</h3>
                    <p>Ooops! The page you are looking for, couldn't be found.</p>
                    <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i>Back To Homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Error -->

<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>