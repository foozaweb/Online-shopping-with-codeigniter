<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Track Order -->
<section class="tr-order">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tr-box">
                    <form action="<?php echo base_url() ?>cart/track_order" method="POST">
                        <?php if ($this->session->flashdata('alert_danger')) :
                            echo '<p class="alert alert-danger" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_danger') . '</p>'; ?>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('alert_success')) :
                            echo '<p class="alert alert-success" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_success') . '</p>'; ?>
                        <?php endif; ?>

                        <h5>Track Your Order</h5>
                        <i>Your order status will be sent to your verified email address</i>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Order Id</label>
                                <input type="text" name="order_id" placeholder="Enter your order number">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="button">Track Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Track Order -->

<?php $this->load->view('template/footer') ?>