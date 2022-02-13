<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area">

</section>
<!-- End Breadcrumb Area -->

<!-- About Area -->
<section class="col-md-12">
    <div class="container mt-5 text-center">
        <h5>Start Typing. We've got what you need</h5><br>
        <form action="<?php echo base_url() ?>cart/find" method="POST" class=" pr-5">
            <input type="search" class="form-control" required autocomplete="off" name="search_bar" placeholder="I'm looking for...">
        </form>
        <div class="col-md-12">
            <div class="card-body showResult no-display">

            </div>
        </div>
    </div>
</section>
<!-- End About Area -->


<?php $this->load->view('template/footer') ?>