<!-- Logo Area -->
<section class="logo-area">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo">
                    <a href="<?php echo base_url() ?>"><img class="max_h50" src="<?php echo $this->db->get('chb_settings')->row_array()['logo']; ?>" alt=""><strong><?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?></strong></a>
                </div>
            </div>
            <div class="col-md-5 padding-fix">
                <form action="<?php echo base_url() ?>cart/find" method="POST" class="search-bar">
                    <input type="search" required autocomplete="off" name="search_bar" placeholder="I'm looking for...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="col-md-4">
                <div class="carts-area d-flex">
                    <div class="call-box d-flex">
                        <div class="call-ico">
                            <img src="<?php echo base_url() ?>images/call.svg" alt="">
                        </div>
                        <div class="call-content pt-2">
                            <span>Call Us</span>
                            <p><?php echo $this->db->get('chb_settings')->row_array()['phone']; ?></p>
                        </div>
                    </div>
                    <div class="cart-box ml-auto text-center">
                        <a href="#" class="cart-btn">
                            <img src="<?php echo base_url() ?>images/cart.png" alt="cart">
                            <span class="ViewUserCartList">0</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-body showResult no-display">

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Logo Area -->