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
                    <h5>Forgot Password?</h5>
                    <p>You can recover your password here in a simple step</p>


                    <form method="post" name="cp_form" action="<?php echo base_url() ?>auth/change_password">
                        <div class="form-group">
                            <div id="messanger"> </div>
                            <?php if ($this->session->flashdata('login_failed')) { ?>
                                <div class="alert alert-danger"><?php echo $this->session->flashdata('login_failed'); ?></div>
                            <?php } ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label sr-only" for="email"></label>
                            <input id="email" type="text" name="email" placeholder="Enter Email Address" class="form-control" required>
                        </div>

                        <button type="button" class="btn_otp btn btn-default btn-lg  btn-block mt20">Get OTP</button>

                        <div class="form-group no-display" id="lbl_otp">
                            <label class="control-label sr-only" for="otp"></label>
                            <input id="otp" type="text" name="otp" placeholder="OTP" class="form-control" required>
                        </div>

                        <div class="form-group no-display" id="lbl_password">
                            <label class="control-label sr-only" for="password"></label>
                            <input id="password" type="password" name="password" placeholder="New Password" class="form-control" required>
                        </div>

                        <button type="submit" name="singlebutton" class="btn btn-default btn-lg btn-block mt20 no-display">Recover Password</button>


                        <div class="d-flex justify-content-between nam-btm mt-3">
                            <a href="javascript:void(0);" class="btn_otp2 no-display">Resend OTP</a>
                            <div>
                                <a href="<?php echo base_url() ?>login">Login Here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Log In -->

<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>

<script>
    $('.btn_otp, .btn_otp2').on('click', function() {
        var email = $('[name="email"]').val();
        if (email) {
            $('.btn_otp').html('Please Wait');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('auth/otp') ?>",
                dataType: "JSON",
                data: {
                    email: email
                },
                success: function(data) {
                    if (data != "email_not_found") {
                        $('#lbl_otp').fadeIn('slow');
                        $('.btn_otp').fadeOut('slow');
                        setCookie("otp", data, 1);
                        $('#messanger').html('<span class="text-success">A one time password has been sent to your email address. OTP will expire in 24 hours</span>');
                        $('.btn_otp2').fadeIn('slow');
                    }
                    if (data == "email_not_found") {
                        $('#lbl_otp').fadeOut('slow');
                        $('#messanger').html('<span class="text-danger">Email not Found</span>');
                        $('.btn_otp').html('get OTP');
                    }
                    // else {
                    //     $('#lbl_otp').fadeOut('slow');
                    //     $('#messanger').html('There was an unknown error with your last command. Please try again');
                    //     $('#btn_otp').html('get OTP');
                    // }
                },
                error: function(data) {
                    $('#messanger').html('<span class="text-danger">There was an unknown error with your last command. Please try again</span>');
                }
            });
        } else {
            $('#messanger').html('<span class="text-danger">Please enter your email address</span>');
        }
    });

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    $('#otp').on('keyup', function() {
        var otp = getCookie("otp");
        var user_otp = $('#otp').val();
        if (otp === user_otp) {
            $('#lbl_password').fadeIn('slow');
            $('[name="singlebutton"]').fadeIn('slow');
            $('#messanger').html('');
        } else {
            $('#lbl_password').fadeOut('slow');
            $('[name="singlebutton"]').fadeOut('slow');
            $('#messanger').html('<span class="text-danger">Incorrect One Time Password</span>');
        }
    });

    $(function() {
        if (getCookie('otp')) {
            $('.btn_otp2').fadeIn('slow');
            $('#lbl_otp').fadeIn('slow');
            $('.btn_otp').fadeOut('slow');
            $('#messanger').html('<span class="text-success">A one time password has been sent to your email address. OTP will expire in 24 hours</span>');
            $('.btnResendOtp').fadeIn();
        }
    });




    $('[name="cp_form"]').on('submit', function() {
        deleteCookie('otp');
    });




    function deleteCookie(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/chbcustomer;";
    }
</script>