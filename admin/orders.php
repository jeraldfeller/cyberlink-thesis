<?php
require 'Model/Init.php';
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
                            <button class="btn btn-warning" id="statusPending">PENDING</button>
                            <button class="btn btn-primary" id="statusApprove">APPROVED</button>
                            <button class="btn btn-danger" id="statusDecline">DECLINED</button>
                            <button class="btn btn-success" id="statusComplete">COMPLETE</button>
                            <button class="btn btn-default" id="statusAll">All</button>
                            <input type="hidden" id="status" value="PENDING">
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="datatable-responsive" class="table table-striped jambo_table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr class="headings">
                                            <th>Invoice</th>
                                            <th>Name</th>
                                            <th>Mode Of Payment</th>
                                            <th>Delivery Address</th>
                                            <th>Date Of Delivery/Pickup</th>
                                            <th>Total</th>
                                            <th>Date Ordered</th>
                                            <th>Status</th>
                                            <th>Action </th>
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
                        "sAjaxSource": "ajax/invoice/function?action=getOrders",
                        "fnServerData": function ( sSource, aoData, fnCallback ) {
                            /* Add some extra data to the sender */
                            aoData.push( { "name": "status", "value": $('#status').val() } );
                            $.getJSON( sSource, aoData, function (json) {
                                /* Do whatever additional processing you want on the callback, then tell DataTables */
                                fnCallback(json)
                            } );
                        },
                        responsive: true,
                        "iDisplayLength": 20,
                        "lengthMenu": [20, 50, 100],
                        "order": [[ 0, "asc" ]],
                        "columnDefs": [
                            {"width": "30%", "targets": 4}
                        ]
                    }
                );

                $('#statusPending').click(function(){
                    $('#status').val('PENDING');
                    $table.ajax.reload();
                });

                $('#statusApprove').click(function(){
                    $('#status').val('APPROVED');
                    $table.ajax.reload();
                });

                $('#statusDecline').click(function(){
                    $('#status').val('DECLINED');
                    $table.ajax.reload();
                });

                $('#statusAll').click(function(){
                    $('#status').val('ALL');
                    $table.ajax.reload();
                });

                $('#statusComplete').click(function(){
                    $('#status').val('COMPLETE');
                    $table.ajax.reload();
                });
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