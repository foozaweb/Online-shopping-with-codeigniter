<!-- Cart Body -->
<div class="categoryViewer">
    <div class="close-btn">
        <button class="close-cat"><img src="<?php echo base_url()  ?>images/close.png" alt="">Close</button>
    </div>
    <div class="crt-bd-box">

        <section class="category">
            <div class="container">
                <?php $this->load->view('template/category'); ?>

                <form method="POST" action="<?php echo base_url() ?>cart/shop">
                    <div class="cat-brand">
                        <div class="sec-title">
                            <h6>Brands</h6>
                        </div>

                        <div class="brand-box">
                            <ul class="list-unstyled">
                                <?php foreach ($brands as $brand) {
                                    echo '<li><label><input value="' . $brand['p_brand_slug'] . '" type="checkbox" id="' . $brand['p_brand_slug'] . '" name="brand[][brand]">' . $brand['p_brand_name'] . '</label></li>';
                                } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="price-range">
                        <div class="sec-title">
                            <h6>Price</h6>
                        </div>
                        <div class="price-filter">
                            <div id="slider-range"></div>
                            <input type="text" id="amount" name="filterShopAmount" readonly>
                            <button type="submit" name="button" class="filterShopResult">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="color">
                    <div class="sec-title">
                        <h6>Color</h6>
                    </div>
                    <div class="inline-block-display">
                        <?php
                        $this->db->limit(rand(4, 10));
                        $this->db->where('display', '1');
                        $this->db->order_by('id', 'random');
                        $result = $this->db->get('chb_products')->result_array();
                        foreach ($result as $res) {
                            echo '<span class="child"><label class="wColorWrapper2"  style="background: ' . explode(',', $res['color'])[rand(0, count(explode(',', $res['color'])) - 1)] . ';"><input class="regular-checkbox" type="checkbox" name="color[][colorFilter]"></label></span>';
                        }
                        ?>
                    </div>
                </div>
                <div class="pro-tag">
                    <div class="sec-title">
                        <h6>Product Tag</h6>
                    </div>
                    <div class="tag-box">
                        <?php
                        $this->db->limit(rand(7, 12));
                        $this->db->where('display', '1');
                        $this->db->order_by('id', 'random');
                        $result = $this->db->get('chb_products')->result_array();
                        foreach ($result as $res) {
                            echo '<a href="' . base_url() . 'product/' . $res['productId'] . '">' . explode(',', $res['meta_keyword'])[0] . '</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="add-box">
                    <?php
                    $this->db->limit('1');
                    $this->db->order_by('id', 'random');
                    $this->db->where('display', '1');
                    $product = $this->db->get('chb_products')->row_array();
                    ?>
                    <a href="<?php echo base_url() ?>product/<?php echo $product['productId'] ?>">
                        <img class="img-fluid" src="<?php echo $admin_url ?>assets/images/<?php echo $product['main_photo'] ?>" alt="">
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="cart-overlay"></div>
<!-- End Cart Body -->