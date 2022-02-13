<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Contact -->
<section class="contact-area mt-5">
    <!-- <div id="map"></div> -->
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-lg-4 col-md-5 mt-5">
                <div class="contact-box-tp">
                    <h4>Contact Info</h4>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="contact-box d-flex">
                            <div class="contact-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="contact-content">
                                <h6>Our Location</h6>
                                <p><?php echo $this->db->get('chb_settings')->row_array()['address']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="contact-box d-flex">
                            <div class="contact-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="contact-content">
                                <h6>Email Address</h6>
                                <p><?php echo $this->db->get('chb_settings')->row_array()['email']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="contact-box d-flex">
                            <div class="contact-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="contact-content">
                                <h6>Phone Number</h6>
                                <p><?php echo $this->db->get('chb_settings')->row_array()['phone']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-link">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item"><a href="<?php echo $this->db->get('chb_settings')->row_array()['facebook']; ?>"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="<?php echo $this->db->get('chb_settings')->row_array()['twitter']; ?>"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="<?php echo $this->db->get('chb_settings')->row_array()['linkedin']; ?>"><i class="fa fa-linkedin"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-youtube"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="contact-form">
                    <h4>Get In Touch</h4>
                    <form action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <p><input type="text" id="name" name="name" placeholder="Full Name" required=""></p>
                            </div>
                            <div class="col-md-6">
                                <p><input type="text" id="email" name="email" placeholder="Email" required=""></p>
                            </div>
                            <div class="col-md-12">
                                <p><input type="text" id="subject" name="subject" placeholder="Subject"></p>
                            </div>
                            <div class="col-md-12">
                                <p><textarea name="message" id="message" placeholder="Message" required=""></textarea></p>
                            </div>
                            <div class="col-md-12">
                                <button type="submit">Send Message</button>
                            </div>
                        </div>
                        <div id="form-messages"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact -->


<!-- Footer Area -->
<?php $this->load->view('template/footer'); ?>
<!-- Google Map -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATY4Rxc8jNvDpsK8ZetC7JyN4PFVYGCGM"></script> -->
<!-- <script src="<?php //echo base_url()  
                    ?>js/assets/map.js"></script> -->