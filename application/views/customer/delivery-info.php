<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area">

</section>
<!-- End Breadcrumb Area -->

<!-- About Area -->
<section class="about-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="wc-box">
                    <?php
                    echo $this->db->get('chb_settings')->row_array()['delivery_info'];
                    ?>
                </div>
            </div>


        </div>
    </div>
</section>
<!-- End About Area -->


<?php $this->load->view('template/footer') ?>