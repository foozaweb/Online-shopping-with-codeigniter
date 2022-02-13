<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Register -->
<section class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <form name="formRegister" action="<?php echo base_url() ?>auth/cA" method="POST">
                    <?php if ($this->session->flashdata('alert_danger')) :
                        echo '<p class="alert alert-danger" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_danger') . '</p>'; ?>
                    <?php endif; ?>
                    <h5>Create Your Account</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <label>First Name*</label>
                            <input type="text" name="fname" class="regInput" placeholder="Your First name">
                        </div>
                        <div class="col-md-12">
                            <label>Last Name*</label>
                            <input type="text" name="lname" class="regInput" placeholder="Your Last name">
                        </div>
                        <div class="col-md-12">
                            <label>Email Address*</label>
                            <input type="text" name="email" class="regInput" placeholder="Your Email address">
                        </div>
                        <div class="col-md-12">
                            <label>Phone Number*</label>
                            <input type="text" name="phone" class="regInput" placeholder="Your Phone number">
                        </div>
                        <div class="col-md-12">
                            <label>Password*</label>
                            <input type="password" min="6" name="p1" class="regInput" placeholder="Password">
                        </div>
                        <div class="col-md-12">
                            <label>Retype Password*</label>
                            <input type="password" min="6" name="password" class="regInput" placeholder="Retype Password">
                        </div>
                        <div class="col-md-8">
                            <div>
                                By signing up, you hereby agree to our <a target="_blank" href="<?php echo base_url() ?>terms-condition"><i>terms of service</i></a>
                            </div>
                            <div>
                                <input type="checkbox" value="1" name="c-box" id="c-box">
                                <label for="c-box">Subscribe for newsletter</label>
                            </div>
                            <i>Already have an account? <a href="<?php echo base_url() ?>login">Login Now</a></i>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="regBtn" name="button">Submit</button>
                            <div id="regMsg"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Register -->



<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>



<script>
    var err;
    $(".regBtn").on("click", function(e) {
        e.preventDefault();

        $('.regInput').each(function() {
            if (!$(this).val()) {
                var obj = $(this).attr('name');
                $('[name="' + obj + '"]').focus();
                err = $(this).attr('placeholder') + ' field is empty';
                $('#regMsg').html('<b class="text-danger">Null: ' + err + '</b>');
                console.log(err);
                return false;
            } else {
                err = '';
            }
        });

        if (err === "") {
            submitForm();
        }

    });

    function submitForm() {
        var p1 = $('[name="p1"]').val();
        var p2 = $('[name="password"]').val();

        if (p1 == $('[name="email"]').val() || p2 == $('[name="email"]').val()) {
            $('#regMsg').html('<strong class="text-danger">You can\'t use your email for password</strong>');
            return false;
        }

        if ($('[name="p1"]').val().length < 6 || $('[name="password"]').val().length < 6) {
            $('#regMsg').html('<strong class="text-danger">Password is too short. Must be a minimum of 6 characters</strong>');
            return false;
        }
        if (p1 != p2) {
            $('#regMsg').html('<strong class="text-danger">Error: password mismatch</strong>');
            return false;
        } else {
            $('#regMsg').html('');
            $('[name="formRegister"]').submit();
        }
    }
</script>