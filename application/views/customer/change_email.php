<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Log In -->
<section class="login">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="n-customer">

                </div>
            </div>
            <div class="col-md-6">
                <?php if ($this->session->flashdata('alert_success')) :
                    echo '<p class="alert alert-success" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_success') . '</p>'; ?>
                <?php endif; ?>

                <?php if ($this->session->flashdata('alert_danger')) :
                    echo '<p class="alert alert-danger" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_danger') . '</p>'; ?>
                <?php endif; ?>
                <div class="r-customer">
                    <h5>Update Email Address</h5>
                    <p>please fill form</p>
                    <form action="<?php echo base_url() ?>auth/updateEmail" method="POST">
                        <div class="pass">
                            <label>Enter Token</label>
                            <input type="password" required name="token" placeholder="Enter Token">
                        </div>
                        <div class="emal">
                            <label>New Email</label>
                            <input type="text" required name="email" placeholder="New Email">
                        </div>
                        <b class="pull-right">
                            <a href="<?php echo base_url() ?>cart/requestToken">Request New Token</a>
                        </b>
                        <button type="submit" name="button">Submit Form</button>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <div class="n-customer">

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Log In -->

<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>