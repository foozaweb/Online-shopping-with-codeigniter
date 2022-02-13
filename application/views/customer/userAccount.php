<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">

<!-- Breadcrumb Area -->
<section class="breadcrumb-area">
</section>
<!-- End Breadcrumb Area -->

<!-- Category Area -->
<section class="category">
    <div class="container">
        <div class="row">
            <div class="col-md-3">

                <div class="card">
                    <div class="card-body">
                        <div class="profile-photo-wrapper">

                            <?php if ($user['photo'] != null) {  ?>
                                <img src="<?php echo $user['photo']; ?>" class="img-responsive img-fluid img-circle col-md-offset-10 img-thumbnail">
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>images/testimonial-1.jpg" class="img-responsive img-fluid img-circle col-md-offset-10 img-thumbnail">
                            <?php } ?>
                            <input type="file" name="profile_photo" style="display:none;" id="profile_photo" accept="image/*">

                            <button class="changePhoto" data-toggle="tooltip" data-placement="top" title="click to select picture" onclick="$('#profile_photo').click();"><i class="fa fa-pencil-square-o"></i> Update Photo</button>
                            <hr>
                            <p class="text-center">Wallet Balance</p>
                            <p>
                            <h3 class="text-center"><strong><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($user['wallet_balance']/$this->session->userdata('ex_rate')) ?>.00</strong></h3>
                            </p>
                            <p class="text-center"><a title="Fund wallet" data-placement="top" data-toggle="tooltip" href="javascript:void(0)" class="fundWallet cartExpand"><i class="fa fa-money"></i> Add Fund</p>
                        </div>
                        <hr>
                        <div class="userProfile">
                            <p><a href="javascript:void(0);" class="toggleNav" data-target="profile_details" class="active"><i class="fa fa-user"></i> Profile Details</a></p>
                            <p><a href="<?php echo base_url() ?>order_history"><i class="fa fa-shopping-bag"></i> Recent Orders</a></p>
                            <p><a href="<?php echo base_url() ?>wishlist"><i class="fa fa-heart"></i> Wishlist</a></p>
                            <p><a href="javascript:void(0);" class="toggleNav" data-target="activities"><i class="fa fa-list"></i> Activities</a></p>
                            <p><a href="javascript:void(0);" class="toggleNav" data-target="change_password"><i class="fa fa-lock"></i> Change Password</a></p>
                            <p><a href="<?php echo base_url() ?>auth/clearSession"><i class="fa fa-power-off"></i> Logout</a></p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-9">
                <div class="product-box">


                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="profile_details">
                            <div class="row">

                                <div class="card col-md-12">
                                    <form method="post" action="<?php echo base_url() ?>auth/profile" class="card-body row">
                                        <h4><strong>Personal Details</strong></h4>
                                        <hr>
                                        <div class="col-md-12">
                                            <label>First Name*</label>
                                            <input type="text" class="form-control" name="profile_first_name" value="<?php echo $user['firstname'] ?>" placeholder="Your first name">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Last Name*</label>
                                            <input type="text" class="form-control" name="profile_last_name" value="<?php echo $user['lastname'] ?>" placeholder="Your last name">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Email Address*</label>
                                            <input type="email" readonly class="form-control" name="profile_email" value="<?php echo $user['email'] ?>" placeholder="Your email address">
                                            <a href="<?php echo base_url() ?>cart/changeEmail">
                                                <small>Click here to change email</small>
                                            </a>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Phone*</label>
                                            <input type="text" class="form-control" name="profile_phone" value="<?php echo $user['phone'] ?>" placeholder="Your phone number">
                                        </div>
                                        <h4 class="mt-5"><strong>Business Details</strong></h4>
                                        <hr>

                                        <div class="col-md-12">
                                            <label>Business Name*</label>
                                            <input type="text" class="form-control" name="b_name" value="<?php echo $user['business_name'] ?>" placeholder="Your last name">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Business Email Address*</label>
                                            <input type="emil" class="form-control" name="b_email" value="<?php echo $user['business_email'] ?>" placeholder="Your Business email address">
                                        </div>

                                        <div class="col-md-12">
                                            <label>Business Phone*</label>
                                            <input type="text" class="form-control" name="b_phone" value="<?php echo $user['business_phone'] ?>" placeholder="Your phone number">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Physical Address*</label>
                                            <textarea class="form-control" name="b_address" placeholder="Your Business address"><?php echo $user['business_address'] ?></textarea>
                                        </div>

                                        <button type="submit" name="button" class="ord-btn">Update Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div>





                        <?php
                        $this->db->order_by('id', 'desc');
                        $this->db->limit('100');
                        $acts = $this->db->get_where('chb_c_activity', array('customer_id' => $this->session->userdata('chbCusId')))->result_array();
                        ?>
                        <div class="tab-pane fade show" id="activities">
                            <div class="row">

                                <div class="card col-md-12">
                                    <div class="card-body row table-responsive">
                                        <table class="table datatable" id="activityTable">
                                            <thead>
                                                <tr>
                                                    <th>Activity</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($acts as $act) {
                                                    echo "<tr><td>" . $act['activity'] . "</td><td>" . $act['act_date'] . "</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>
                        </div>











                        <div class="tab-pane show fade" id="change_password">
                            <div class="row">

                                <div class="card col-md-12">
                                    <div class="card-body row">
                                        <h4>Change Password</h4>

                                        <div class="col-md-12 mt-3">
                                            <label>Current Password</label>
                                            <input type="password" class="form-control" name="old_p" id="old_p" placeholder="Current Password">
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label>New Password</label>
                                            <input type="password" name="new_p" class="form-control" id="new_p" placeholder="New Password">
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label>Retype New Password</label>
                                            <input type="password" name="new_p1" class="form-control" id="new_p1" placeholder="Retype Password">
                                        </div>

                                        <div class="col-md-12 mt-5 text-right">
                                            <button type="button" id="change_p" class="dtBtn"> <i class="fa fa-lock"></i> Change Password</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>














                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category Area -->


<!-- Footer Area -->
<?php
$this->load->view('template/footer');
$this->load->view('template/jsfunctions');
?>


<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>


<script>
    $('#profile_photo').on('change', function() {
        var files = $('#profile_photo')[0].files;
        var error = '';
        var form_data = new FormData();
        for (var count = 0; count < files.length; count++) {
            var name = files[count].name;
            var extension = name.split('.').pop().toLowerCase();
            if (jQuery.inArray(extension, ['png', 'gif', 'jpeg', 'jpg']) == -1) {
                error += " " + count + " Invalid  File. Please a valid image file format";
            } else {
                form_data.append("profile_photo[]", files[count]);
            }
        }
        if (files === null) {
            return false;
        }
        if (error == '') {
            $.ajax({
                url: "<?php echo base_url() ?>auth/PhotoUpload",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    alertMe("Uploading Profile Photo...", 10000);
                },
                success: function(data) {
                    alertMe("Successful", 6000);
                    window.location.reload();
                },
                error: function(data) {
                    alertMe("Upload Failed. Try again", 6000);
                }
            });
        } else {
            alertMe(error, 6000);
        }
    });









    $('#change_p').on('click', function() {
        var old_p = $('#old_p').val();
        var new_p = $('#new_p').val();
        var new_p1 = $('#new_p1').val();
        if (old_p == "" || new_p == "" || new_p1 == "") {
            alertMe("Check for an empty field.", 7000);
            return false;
        }
        if (new_p != new_p1) {
            alertMe("Password Mismatch! Please check password.", 7000);
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('auth/new_password') ?>",
            dataType: "JSON",
            data: {
                old_p: old_p,
                new_p: new_p
            },
            beforeSend: function() {
                $("#change_p").html('Updating Password...');
            },
            success: function(data) {
                if (data == "successful") {
                    alertMe('Successful. Please wait...');
                    window.location.reload();
                } else {
                    alertMe(data);
                    $("#change_p").html('change Password');
                    return false;
                }
            },
            error: function(data) {
                alertMe("Fatal Error! Please check your network connection or contact provider for support", 10000);
                $("#change_p").html('change Password');
                return false;
            }
        });
        return false;
    });





    $('.toggleNav').on('click', function() {
        var target = $(this).data('target');
        $('.tab-pane').fadeOut('fast');
        $('#' + target).fadeIn('slow');
    });



    setDatatable();

    function setDatatable() {
        $('#activityTable').dataTable({
            stateSave: true,
            // dom: 'lBfrtip',
            "scrollCollapse": true,
            "paging": true,
            "language": {
                "decimal": ",",
                "thousands": ".",
                "lengthMenu": "_MENU_",
                "zeroRecords": "No Record Found",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": ""
            },
            responsive: true,
            buttons: ['pdf', 'print'],
            columnDefs: [{
                targets: [0, 1],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            "lengthMenu": [
                [10, 20, 30, 50, 100, -1],
                [10, 20, 30, 50, 100, "All"]
            ],
        });
    }
</script>