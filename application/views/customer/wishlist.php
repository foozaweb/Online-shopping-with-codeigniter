<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Wishlist -->
<section class="shopping-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-table wsh-list table-responsive myOrderSettings">
                    <?php if ($wishlist) { ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="t-pro">Product</th>
                                    <th class="t-price">Price</th>
                                    <th class="t-qty">Stock</th>
                                    <th class="t-total">Add To Cart</th>
                                    <th class="t-rem"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($wishlist as $wl) { ?>
                                    <tr>
                                        <td class="t-pro d-flex">
                                            <div class="t-img">
                                                <a href="<?php echo base_url() . 'product/' . $wl['productId'] ?>"><img src="<?php echo $admin_url ?>/assets/images/<?php echo $wl['main_photo'] ?>" alt=""></a>
                                            </div>
                                            <div class="t-content">
                                                <p class="t-heading"><a href="<?php echo base_url() . 'product/' . $wl['productId'] ?>"><?php echo $wl['product_name'] ?></a></p>
                                                <ul class="list-unstyled list-inline rate">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                                <ul class="list-unstyled col-sz">
                                                    <li>
                                                        <p>Color : <span class="wColorWrapper">
                                                                <?php
                                                                $tags = explode(',', $wl['color']);
                                                                for ($i = 0; $i < count($tags); $i++) {
                                                                ?> <span class="colorCircle" style="background-color: <?php echo str_replace(' ', '', $tags[$i]); ?>;"></span>
                                                                <?php } ?>
                                                            </span>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p>Size:
                                                            <?php
                                                            $tags = explode(',', $wl['product_size']);
                                                            for ($i = 0; $i < count($tags); $i++) {
                                                            ?>
                                                                <span><?php echo str_replace(' ', '', $tags[$i]); ?></span>
                                                            <?php } ?>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="t-price"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($wl[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</td>
                                        <?php if ($wl['quantity'] < 1) { ?>
                                            <td class="text-danger"><?php echo $wl['quantity'] ?> Pieces In Stock</td>
                                        <?php } ?>
                                        <?php if ($wl['quantity'] > 0 && $wl['quantity'] <= 20) { ?>
                                            <td class="text-warning"><?php echo $wl['quantity'] ?> Pieces In Stock</td>
                                        <?php } ?>
                                        <?php if ($wl['quantity'] > 20 && $wl['quantity'] <= 100 || $wl['quantity'] > 100) { ?>
                                            <td class="t-stk"><?php echo $wl['quantity'] ?> Pieces In Stock</td>
                                        <?php } ?>

                                        <?php if ($wl['quantity'] < 1) { ?>
                                            <td class="t-add"><button class="" title="This Product is out of stock." data-placement="top" data-toggle="tooltip" type="button" name="button">Out of Stock</button></td>
                                        <?php } else { ?>
                                            <td class="t-add"><button class="addToCart" data-id="<?php echo $wl['productId'] ?>" type="button" name="button">Add to Cart</button></td>
                                        <?php } ?>
                                        <td class="t-rem">
                                            <a href="javascript:void(0)" class="clearWish" data-url="<?php echo base_url() ?>cart/trashWish/<?php echo $wl['productId'] ?>"><i class=" fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <center class="mb-5 mt-5">
                            <h1 class="card">
                                <div class="card-body">
                                    <small>You have No Item on your List.</small> <br><u><a href="<?php echo base_url() ?>cats"><i class="fa fa-hand-o-right"></i> click to Start Shopping <i class="fa fa-hand-o-left"></i></u></a>
                                </div>
                            </h1>
                        </center>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Wishlist -->


<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>