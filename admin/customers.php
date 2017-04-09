<?php
require 'Model/Init.php';
?>

<?php include('includes/header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Customers</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Customer Info Table</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="datatable-responsive" class="table table-striped jambo_table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr class="headings">
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Phone Number</th>
                                            <th>Mobile Number</th>
                                            <th>Orders</th>
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
                        "sAjaxSource": "ajax/customer/function?action=getCustomers",
                        responsive: true,
                        "iDisplayLength": 20,
                        "lengthMenu": [20, 50, 100],
                        "order": [[ 0, "asc" ]],
                        "columnDefs": [
                            {"width": "30%", "targets": 4}
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