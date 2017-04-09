<?php
require 'Model/Init.php';
require 'Model/Orders.php';
require 'Model/Customer.php';
$customerClass = new Customer();
$customer = $customerClass->getCustomerById($_GET['customer-id']);
?>

<?php include('includes/header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Orders</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="datatable-responsive" class="table table-striped jambo_table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr class="headings">
                                            <th>Invoice ID</th>
                                            <th>Mode of Payment</th>
                                            <th>Delivery Address</th>
                                            <th>Date Of Delivery/Pickup</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            $(document).on('ready', function() {

                $table = $('#datatable-responsive').DataTable({
                        fixedHeader: true,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "ajax/customer/function?action=getCustomerOrdersById&customer-id=<?php echo $_GET['customer-id']; ?>&status=<?php echo $_GET['status']; ?>",
                        responsive: true,
                        "iDisplayLength": 20,
                        "lengthMenu": [20, 50, 100],
                        "order": [[ 0, "asc" ]],
                        "columnDefs": [
                            {"width": "20%", "targets": 4}
                        ]
                    }
                );


                setInterval(function(){
                    $table.ajax.reload();
                }, 60000)


            });



        </script>


        <!-- PNotify -->

        <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>
        <script type="text/javascript" src="js/notify/pnotify-actions.js"></script>



        <!-- Ajax request -->
        <script type="text/javascript" src="ajax/customer/ajax-customer.js"></script>

<?php include('includes/footer.php'); ?>