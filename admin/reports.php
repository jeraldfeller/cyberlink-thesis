<?php
require 'Model/Init.php';
?>

<?php include('includes/header.php'); ?>
    <!-- page content -->
    <style>
        div.dt-buttons {
            float: right;
        }
    </style>
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                <h4>From</h4>
                                <input type="text" class="form-control has-feedback-right" id="dateFrom" value="<?php echo date('m/d/Y'); ?>" placeholder="Select Date" aria-describedby="inputSuccess2Status4">
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                            </div>
                            <div class="col-md-3 xdisplay_inputx form-group has-feedback">
                                <h4>To</h4>
                                <input type="text" class="form-control has-feedback-right" id="dateTo" value="<?php echo date('m/d/Y'); ?>" placeholder="Select Date" aria-describedby="inputSuccess2Status4">
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                            </div>
                            <div class="col-md-3">
                                <h4>&nbsp;</h4>
                                <button class="btn btn-primary btn-md" id="searchReport"><i class="fa fa-search"></i> Search</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="datatable-responsive" class="table table-striped jambo_table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr class="headings">
                                            <th>ID</th>
                                            <th>Invoice</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Amount Paid</th>
                                            <th>Total Profit</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tfoot class="bg-primary">
                                            <th colspan="4">TOTALS:</th>
                                            <th id="totalPaid">Php0.00</th>
                                            <th colspan="2" id="totalProfit">Php0.00</th>
                                        </tfoot>
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

                $('#dateFrom').daterangepicker({
                    singleDatePicker: true,
                    calender_style: "picker_4"
                }, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });
                $('#dateTo').daterangepicker({
                    singleDatePicker: true,
                    calender_style: "picker_4"
                }, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });

                $table = $('#datatable-responsive').DataTable({
                        fixedHeader: true,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "ajax/reports/function?action=getReports",
                        "fnServerData": function ( sSource, aoData, fnCallback ) {
                            /* Add some extra data to the sender */
                            aoData.push( { "name": "from", "value": $('#dateFrom').val() } );
                            aoData.push( { "name": "to", "value": $('#dateTo').val() } );
                            $.getJSON( sSource, aoData, function (json) {
                                /* Do whatever additional processing you want on the callback, then tell DataTables */
                                fnCallback(json)
                                console.log(json);
                                $('#totalPaid').html('<b>' + json['totalPaid'] + '</b>');
                                $('#totalProfit').html('<b>' + json['totalProfit'] + '</b>');
                            } );
                        },
                        responsive: true,
                        "iDisplayLength": 20,
                        "lengthMenu": [20, 50, 100],
                        "order": [[ 0, "desc" ]],
                        "columnDefs": [
                            {
                                "targets": [ 0 ],
                                "visible": false,
                                "searchable": false
                            }
                        ],
                        dom: '<"top"B">lfrt<"bottom"ip><"clear">',
                        buttons: [
                            {
                                extend: 'print',
                                className: 'btn blue btn-outline',
                                text: '<i class="fa fa-print"></i> Print',
                                title: 'Reports_'+$('#dateFrom').val()+'-'+$('#dateTo').val(),
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5]
                                }
                            },
                            {

                                extend: 'pdf',
                                className: 'btn green btn-outline',
                                text: '<i class="fa fa-file-pdf-o"></i> Save as PDF',
                                title: 'Reports_'+$('#dateFrom').val()+'-'+$('#dateTo').val(),
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5]
                                }
                            }
                        ]
                    }
                );

                $('#statusPending').click(function(){
                    $('#status').val('PENDING');
                    $table.ajax.reload();
                });

                $('#searchReport').click(function(){
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
        <script type="text/javascript" src="ajax/reports/ajax-reports.js"></script>

<?php include('includes/footer.php'); ?>