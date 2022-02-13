<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">




<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Wishlist -->
<section class="shopping-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive data_tb">
                    <?php $this->db->where('customer_id', $this->session->userdata('chbCusId'));
                    $this->db->where('order_type', $this->session->userdata('user_state'));
                    $this->db->order_by('id', 'desc');
                    $history = $this->db->get('chb_orders')->result_array();



                    if ($history) { ?>
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Payment Status</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Order Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = '';
                                foreach ($history as $history) {
                                    $i++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><a href="<?php echo base_url() . 'invoice/' . $history['reference'] ?>">#<?php echo $history['reference'] ?></a> </td>
                                        <td> <?php echo $history['order_date'] ?> </td>

                                        <td>
                                            <?php if ($history['payment_status'] == "0") {
                                                echo '<span class="small-alert alert-warning"><i class="fa fa-hand-grab-o"></i> Pending</span>';
                                            } elseif ($history['payment_status'] == "1") {
                                                echo '<span class="small-alert alert-success"><i class="fa fa-money"></i> Paid</span>';
                                            } elseif ($history['payment_status'] == "2") {
                                                echo '<span class="small-alert alert-danger"><i class="fa fa-times-circle"></i> Refunded</span>';
                                            } else {
                                                echo '<span class="small-alert alert-danger"><i class="fa fa-times-circle-o"></i> Not Found</span>';
                                            }  ?>
                                        </td>


                                        <td><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($history['grandTotal']/$this->session->userdata('ex_rate')); ?>.00</td>
                                        <td> <?php echo $history['payment_method'] ?> </td>
                                        <td> <?php if ($history['order_status'] == "0") {
                                                    echo '<span class="small-alert alert-warning"><i class="fa fa-hand-grab-o"></i> Pending</span>';
                                                } elseif ($history['order_status'] == "1") {
                                                    echo '<span class="small-alert alert-success"><i class="fa fa-check"></i> Completed</span>';
                                                } elseif ($history['order_status'] == "2") {
                                                    echo '<span class="small-alert alert-info"><i class="fa fa-exclamation"></i> Processing</span>';
                                                } elseif ($history['order_status'] == "3") {
                                                    echo '<span class="small-alert alert-danger"><i class="fa fa-times-circle"></i> Cancelled</span>';
                                                } else {
                                                    echo '<span class="small-alert alert-danger"><i class="fa fa-times-circle-o"></i> Unknown</span>';
                                                }  ?>
                                        </td>

                                        <td>
                                            <?php if ($history['payment_status'] == "0") {
                                                echo '<a title="View Invoice" class="small-alert pinkBg text-white" href="' . base_url() . 'cart/invoice/' . $history['reference'] . '"><i class="fa fa-newspaper-o"></i> </a>  <a title="Cancel Order" class="small-alert alert-danger TrashOrder" href="javascript:void(0);" data-url="' . base_url() . 'cart/TrashOrder/' . $history['reference'] . '"><i class="fa fa-trash"></i> </a>';
                                            } elseif ($history['payment_status'] == "1") {
                                                echo '<a title="View Invoice" class="small-alert alert-danger" href="' . base_url() . 'cart/invoice/' . $history['reference'] . '"><i class="fa fa-newspaper-o"></i> Invoice</a>';
                                            } elseif ($history['payment_status'] == "2") {
                                                echo '<a class="small-alert pinkBg text-white" href="' . base_url() . 'cart/invoice/' . $history['reference'] . '"><i class="fa fa-newspaper-o"></i> Cancelled</a>';
                                            }  ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <center class="mb-5 mt-5">
                            <h1 class="card">
                                <div class="card-body">
                                    <small>You have Not ordered any Item yet.</small> <br><u><a href="<?php echo base_url() ?>shop"><i class="fa fa-hand-o-right"></i> click to Start Shopping <i class="fa fa-hand-o-left"></i></u></a>
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
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>


<script>
    setDatatable();

    function setDatatable() {
        $('#datatable').dataTable({
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
            buttons: {
                dom: {
                    button: {
                        className: 'dtBtn'
                    }
                },
            },
            // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            columnDefs: [{
                targets: [0, 1, 2],
                className: 'mdl-data-table__cell--non-numeric'
            }],
            "lengthMenu": [
                [10, 20, 30, 50, 100, -1],
                [10, 20, 30, 50, 100, "All"]
            ],
        });
    }

    $('.table').on('click', '.TrashOrder', function() {
        if (confirm("Are you sure?")) {
            location.href = $(this).data('url');
        }
    });
</script>