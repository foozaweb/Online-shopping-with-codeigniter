<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Compare -->
<section class="compare-box">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="comp-table table-responsive">

                    <?php
                    $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                    $this->db->where('category', $product['category']);
                    $this->db->where('product_name', $product['product_name']);
                    $this->db->limit('1');
                    $pds = $this->db->get('chb_products')->row_array();


                    $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                    $this->db->where('category', $product['category']);
                    $this->db->where('product_name !=', $product['product_name']);
                    $this->db->limit('1');
                    $product1 = $this->db->get('chb_products')->row_array();


                    $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                    $this->db->where('category', $product1['category']);
                    $this->db->where('product_name !=', $product['product_name']);
                    $this->db->where('product_name !=', $product1['product_name']);
                    $this->db->limit('1');
                    $product2 = $this->db->get('chb_products')->row_array();
                    ?>



                    <table class="table myOrderSettings">
                        <tbody>
                            <tr class="heading">
                                <td class="col-name text-center">Product</td>
                                <td class="text-center">
                                    <!--<i class="fa fa-trash-o"></i>-->
                                    <a href="<?php echo base_url() ?>product/<?php echo $product['productId'] ?>">
                                        <img src="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" alt="">
                                        <div class="tag-title text-left">
                                            <span><?php echo $product['product_name']; ?></span>
                                            <h6><?php echo $product['category']; ?></h6>
                                        </div>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <!--<i class="fa fa-trash-o"></i>-->
                                    <a href="<?php echo base_url() ?>product/<?php echo $product1['productId'] ?>">
                                        <img src="<?php echo $admin_url ?>/assets/images/<?php echo $product1['main_photo'] ?>" alt="">
                                        <div class="tag-title text-left">
                                            <span><?php echo $product1['product_name']; ?></span>
                                            <h6><?php echo $product1['category']; ?></h6>
                                        </div>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <!--<i class="fa fa-trash-o"></i>-->
                                    <a href="<?php echo base_url() ?>product/<?php echo $product2['productId'] ?>">
                                        <img src="<?php echo $admin_url ?>/assets/images/<?php echo $product2['main_photo'] ?>" alt="">
                                        <div class="tag-title text-left">
                                            <span><?php echo $product2['product_name']; ?></span>
                                            <h6><?php echo $product2['category']; ?></h6>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr class="desc">
                                <td class="col-name text-center">Description</td>
                                <td>
                                    <p><?php echo word_limiter($product['productDesc'], 60); ?></p>
                                </td>
                                <td>
                                    <p><?php echo word_limiter($product1['productDesc'], 60); ?></p>
                                </td>
                                <td>
                                    <p><?php echo word_limiter($product2['productDesc'], 60); ?></p>
                                </td>
                            </tr>
                            <tr class="rating text-center">
                                <td class="col-name">Rating</td>
                                <td class="text-center">
                                    <ul class="list-unstyled list-inline rate">
                                        <?php viewRating($pds['rating']); ?>
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <ul class="list-unstyled list-inline rate">
                                        <?php viewRating($product1['rating']); ?>
                                    </ul>
                                </td>
                                <td class="text-center">
                                    <ul class="list-unstyled list-inline rate">
                                        <?php viewRating($product2['rating']); ?>
                                    </ul>
                                </td>
                            </tr>
                            <tr class="price text-center">
                                <td class="col-name">Price</td>
                                <td>
                                    <p><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($product[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</p>
                                </td>
                                <td>
                                    <p><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($product1[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</p>
                                </td>
                                <td>
                                    <p><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($product2[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</p>
                                </td>
                            </tr>
                            <tr class="stock text-center">
                                <td class="col-name">Availability</td>
                                <td>
                                    <p>
                                        <?php if ($product['quantity'] > 0) { ?>
                                            In stock
                                        <?php } else { ?>
                                            <b class="text-danger">Out of Stock</b>
                                        <?php } ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php if ($product1['quantity'] > 0) { ?>
                                            In stock
                                        <?php } else { ?>
                                            <b class="text-danger">Out of Stock</b>
                                        <?php } ?>
                                    </p>
                                </td>
                                <td>
                                    <p>
                                        <?php if ($product2['quantity'] > 0) { ?>
                                            In stock
                                        <?php } else { ?>
                                            <b class="text-danger">Out of Stock</b>
                                        <?php } ?>
                                    </p>
                                </td>
                            </tr>
                            <tr class="color text-center">
                                <td class="col-name">Color</td>
                                <td>
                                    <div class="color">
                                        <ul class="list-unstyled list-inline">
                                            <span class="colorWrapper">
                                                <?php
                                                $tags = explode(',', $product['color']);
                                                for ($i = 0; $i < count($tags); $i++) {
                                                ?>
                                                    <li class="list-inline-item">
                                                        <label for="color-<?php echo $i; ?>"><span style="background-color: <?php echo str_replace(' ', '', $tags[$i]); ?>;"></span></label>
                                                    </li>
                                                <?php } ?>
                                            </span>

                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="color">
                                        <ul class="list-unstyled list-inline">
                                            <span class="colorWrapper">
                                                <?php
                                                $tags = explode(',', $product1['color']);
                                                for ($i = 0; $i < count($tags); $i++) {
                                                ?>
                                                    <li class="list-inline-item">
                                                        <label for="color-<?php echo $i; ?>"><span style="background-color: <?php echo str_replace(' ', '', $tags[$i]); ?>;"></span></label>
                                                    </li>
                                                <?php } ?>
                                            </span>

                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="color">
                                        <ul class="list-unstyled list-inline">
                                            <span class="colorWrapper">
                                                <?php
                                                $tags = explode(',', $product2['color']);
                                                for ($i = 0; $i < count($tags); $i++) {
                                                ?>
                                                    <li class="list-inline-item">
                                                        <label for="color-<?php echo $i; ?>"><span style="background-color: <?php echo str_replace(' ', '', $tags[$i]); ?>;"></span></label>
                                                    </li>
                                                <?php } ?>
                                            </span>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr class="add-cart text-center">
                                <td></td>
                                <td>
                                    <?php if ($product['quantity'] > 0) { ?>
                                        <button data-id="<?php echo $product['productId'] ?>" class="addToCart" data-toggle="tooltip" data-placement="top" title="Add to Cart"> Add To Cart</button>
                                    <?php } else { ?>
                                        <button data-toggle="tooltip" data-placement="top" title="This Item is out of Stock"> Out of Stock</button>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($product1['quantity'] > 0) { ?>
                                        <button data-id="<?php echo $product1['productId'] ?>" class="addToCart" data-toggle="tooltip" data-placement="top" title="Add to Cart"> Add To Cart</button>
                                    <?php } else { ?>
                                        <button data-toggle="tooltip" data-placement="top" title="This Item is out of Stock"> Out of Stock</button>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($product2['quantity'] > 0) { ?>
                                        <button data-id="<?php echo $product2['productId'] ?>" class="addToCart" data-toggle="tooltip" data-placement="top" title="Add to Cart"> Add To Cart</button>
                                    <?php } else { ?>
                                        <button data-toggle="tooltip" data-placement="top" title="This Item is out of Stock"> Out of Stock</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Compare -->


<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>