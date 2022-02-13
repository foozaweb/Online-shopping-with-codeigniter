<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Log In -->
<section class="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="n-customer">
                    <h5>New Customer</h5>
                    <p>No account? We got you covered. Create a free account with us in just few steps, your account will be ready for use.</p>
                    <a href="<?php echo base_url() ?>register">Create an Account</a>
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
                    <h5>Registered Customer</h5>
                    <p>If you have an account with us, please log in.</p>
                    <form action="<?php echo base_url() ?>auth/access" method="POST">
                        <div class="emal">
                            <label>Email Address or Phone Number</label>
                            <input type="text" name="loginId" placeholder="Email Address or Phone Number">
                        </div>
                        <div class="pass">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                        <div class="d-flex justify-content-between nam-btm">
                            <div>
                                <input type="checkbox" name="rememberme" id="rmme">
                                <label for="rmme">Remember Me</label>
                            </div>
                            <div>
                                <a href="<?php echo base_url() ?>forgot_password">I don't have my password</a>
                            </div>
                        </div>
                        <button type="submit" name="button">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Log In -->

<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>