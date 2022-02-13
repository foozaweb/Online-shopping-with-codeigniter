<!-- Cart Body -->
<div class="cart-body">
    <div class="close-btn">
        <button class="close-cart"><img src="<?php echo base_url()  ?>images/close.png" alt="">Close</button>
        <a class="a" href="<?php echo base_url() ?>shopping-cart"><i class="fa fa-expand"></i> Expand</a>
    </div>
    <div class="crt-bd-box">
        <div class="cart-heading text-center">
            <h5>Shopping Cart</h5>
        </div>

        <?php if ($cartList) { ?>
            <div class="cart-content">
                <?php foreach ($cartList as $cart) { ?>
                    <div class="content-item d-flex justify-content-between">
                        <div class="cart-img t-img">
                            <a href="<?php echo base_url() . 'product/' . $cart['productId'] ?>"><img src="<?php echo $admin_url ?>/assets/images/<?php echo $cart['main_photo'] ?>" alt=""></a>
                        </div>
                        <div class="cart-disc">
                            <p><a href="<?php echo base_url() . 'product/' . $cart['productId'] ?>"><?php echo $cart['product_name'] ?></a></p>
                            <span><?php echo $cart['cart_quantity'] ?> x <?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cart[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</span>
                        </div>
                        <div class="delete-btn">
                            <a href="javascript:void(0)" class="clearCart" data-url="<?php echo base_url() ?>cart/trashCart/<?php echo $cart['productId'] ?>"><i class=" fa fa-trash-o"></i></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="cart-btm">
                <p class="text-right">Sub Total: <span><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cartSum['cart_amount']/$this->session->userdata('ex_rate')); ?>.00</span></p>
                <a href="<?php echo base_url() ?>shopping-cart">Expand</a>
            </div>
        <?php } else { ?>
            <center class="mb-5 mt-5">
                <h5 class="card">
                    <div class="card-body">
                        <small>You have No Item on your Cart.</small> <br><u><a href="<?php echo base_url() ?>shop"><i class="fa fa-hand-o-right"></i> click to Start Shopping</u></a>
                    </div>
                </h5>
            </center>
        <?php } ?>

    </div>
    <hr>
    <div class="text-center">
        <a href="<?php echo base_url() ?>shopping-cart" class="cartExpand">
            <h4><i class="fa fa-expand"></i> Expand</h4>
        </a>
    </div>
</div>
<div class="cart-overlay"></div>
<!-- End Cart Body -->