<section class="logo-area2">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo">
                    <a href="<?php echo base_url() ?>"><img class="max_h50" src="<?php echo $this->db->get('chb_settings')->row_array()['logo']; ?>" alt=""><strong><?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?></strong></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 padding-fix">
                <form action="<?php echo base_url() ?>cart/find" method="POST" class="search-bar d-flex">
                    <input type="search" required autocomplete="off" name="search_bar" placeholder="I'm looking for...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
            <div class="col-lg-3 col-md-2">
                <div class="carts-area d-flex">
                    <div class="wsh-box ml-auto">
                        <a href="<?php echo base_url() ?>wishlist" data-toggle="tooltip" data-placement="top" title="Wishlist">
                            <img src="<?php echo base_url() ?>images/heart.png" alt="favorite">
                            <span class="ViewUserWishlist">0</span>
                        </a>
                    </div>
                    <div class="cart-box ml-4">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Shopping Cart" class="cart-btn">
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