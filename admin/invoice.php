<?php
require 'Model/Init.php';
require 'View/FormElements.php';
$view = new FormElements();

$customerClass = new Customer();
$ordersClass = new Orders();
$customer = $customerClass->getCustomerById($_GET['customer-id']);
$transaction = $ordersClass->getOrdersByTransactionId($_GET['transaction-id']);
$items = $ordersClass->getOrderItemsByInvoiceId($transaction['invoice_id']);

?>

<?php include('includes/header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">

        <div class="">
            <div class="page-title">
                <div class="title_left">

                </div>

                <div class="title_right">

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Invoice</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <section class="content invoice">
                                <div id="printablediv">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-xs-12 invoice-header">
                                        <h1>
                                            Invoice#: <?php echo $transaction['transaction_id']; ?>
                                            <small class="pull-right">Date: <?php echo date('m/d/Y', strtotime($transaction['date_ordered'])); ?></small>
                                        </h1>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        <address>
                                            <strong><?php echo $customer['first_name'] . ' ' . $customer['last_name']; ?></strong>
                                            <br><?php echo $customer['address']; ?>
                                            <br>Home Phone#: <?php echo $customer['home_number']; ?>
                                            <br>Mobile Phone#: <?php echo $customer['mobile_number']; ?>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">

                                        <address>
                                            <strong>Mode of Payment: </strong><?php echo $transaction['mode_of_payment']; ?>
                                            <br><strong>Delivery/Pickup Date: </strong><?php echo date('m/d/Y', strtotime($transaction['date_of_delivery'])); ?>
                                            <br><strong>Delivery Address: </strong><?php echo $transaction['delivery_address']; ?>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="col-xs-12 table">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php echo $view->getDisplayOrdersItemsTable($items); ?>
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
                                                <td><strong><?php echo 'Php' . number_format($transaction['total_price']); ?></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Delivery Charge:</strong></td>
                                                <td>
                                                    <?php
                                                        if($transaction['status'] != 'PENDING') {
                                                            echo '<strong>Php'.number_format($transaction['delivery_charge'],2).'</strong>';
                                                        }else{
                                                            echo '<input value="0" style="width: 60px;" type="text" id="deliveryCharge" onkeypress="return isNumberKey(event)">';
                                                        }
                                                    ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                                                <td id="grandTotal">
                                                    <?php
                                                    if($transaction['status'] != 'PENDING') {
                                                        echo '<strong>Php'.number_format($transaction['delivery_charge'] + $transaction['total_price'],2).'</strong>';
                                                    }else{
                                                        echo ' <input type="hidden" id="inputGrandTotal">';
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>No of days to cancel the order:</strong></td>
                                                <td>
                                                    <?php
                                                    if($transaction['status'] != 'PENDING') {
                                                        echo '<strong>' . $transaction['no_of_days_expire'] . ' day/s</strong>';
                                                    }else{
                                                        echo '<input value="0" style="width: 60px;" type="number" id="daysExpire">';
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div class="col-xs-12">
                                        <button class="btn btn-default" onclick="printDiv('printablediv')"><i class="fa fa-print"></i> Print</button>
                                        <?php
                                        if($transaction['status'] == 'PENDING') {
                                            echo '<button id="approve" class="btn btn-success pull-right"><i class="fa fa-thumbs-up"></i> Approve</button>';
                                            echo '<button id="decline" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-thumbs-down"></i> Decline</button>';
                                        }else if($transaction['status'] == 'APPROVED'){
                                            echo '<button id="complete" class="btn btn-success pull-right"><i class="fa fa-thumbs-up"></i> Complete</button>';
                                            echo '<button id="cancel" class="btn btn-danger pull-right" style="margin-right: 5px;"><i class="fa fa-thumbs-down"></i> Cancel</button>';
                                        }
                                        ?>

                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            $(document).on('ready', function() {

                $('#approve').click(function(){
                    $data = {
                        action: 'approved',
                        page: '<?php echo $_GET['page']; ?>',
                        invoiceId: <?php echo $transaction['invoice_id']; ?>,
                        deliveryCharge: $('#deliveryCharge').val(),
                        daysExpire: $('#daysExpire').val()
                    };

                    updateOrder($data);
                });

                $('#decline').click(function(){
                    $data = {
                        action: 'declined',
                        page: '<?php echo $_GET['page']; ?>',
                        invoiceId: <?php echo $transaction['invoice_id']; ?>
                    };

                    updateOrder($data);
                });

                $('#cancel').click(function(){
                    $data = {
                        action: 'canceled',
                        page: '<?php echo $_GET['page']; ?>',
                        invoiceId: <?php echo $transaction['invoice_id']; ?>
                    };

                    updateOrder($data);
                });
                $('#complete').click(function(){
                    $data = {
                        action: 'complete',
                        page: '<?php echo $_GET['page']; ?>',
                        invoiceId: <?php echo $transaction['invoice_id']; ?>,
                        transactionId: "<?php echo $transaction['transaction_id']; ?>"
                    };

                    updateOrder($data);
                });

            });



        </script>


        <!-- PNotify -->

        <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>
        <script type="text/javascript" src="js/notify/pnotify-actions.js"></script>



        <!-- Ajax request -->
        <script type="text/javascript" src="ajax/invoice/ajax-invoice.js"></script>

<?php include('includes/footer.php'); ?>