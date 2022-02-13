<!-- Mobile Menu -->
<section class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <a href="<?php echo base_url() ?>" class="text-left"><img class="max_h50 ml-3 pull-left" src="<?php echo $this->db->get('chb_settings')->row_array()['logo']; ?>" alt=""></a>
                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <a href="<?php echo base_url() ?>auth/clearSession"><span>Sign Out</span></a>
                        <?php } else { ?>
                            <a href="<?php echo base_url() ?>login"><span>Sign In</span></a>
                        <?php } ?>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Mobile Menu -->

