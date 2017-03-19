<?php
require 'Model/Init.php';
?>

<?php include('includes/header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Borrowed Items</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="datatable-responsive" class="table table-striped jambo_table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr class="headings">
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Notes</th>
                                            <th>Date Borrowed</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <!-- MODAL FOR RETURN -->
                            <div class="modal fade" id="modalReturnProduct" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="modalReturnTitle"></h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="hidden" id="returnBorrowedItemsId">
                                                    <input type="hidden" id="returnProductId">
                                                    <input type="hidden" id="returnBorrowedQuantity">
                                                        <h4>Quantity</h4>
                                                        <input type="text" id="returnQuantity" onkeypress="return isNumberKey(event)" class="form-control"  required="required">
                                                </div>
                                            </div>
                                            <div style="text-align:center"><span id="returnSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                        </div>

                                        <div class="modal-footer">

                                            <input class="btn btn-primary" type="button" value="Return this item" id="return"/>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- /MODAL END FOR RETURN -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            $(document).on('ready', function() {

                $('#datatable-responsive').DataTable({
                        fixedHeader: true,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "ajax/borrowed-items/function?action=getBorrowedItems",
                        responsive: true,
                        "iDisplayLength": 20,
                        "lengthMenu": [20, 50, 100],
                        "order": [[ 0, "asc" ]],
                        "fnDrawCallback": function( oSettings ) {
                            $('.returnTooltip').tooltip({title: "Return this item", placement: "top", trigger: "hover"});
                        }
                    }
                );

                $('#returnQuantity').on('keyup', function(){
                    $quantity = parseInt($(this).val());
                    $borrowedQuantity = parseInt($('#returnBorrowedQuantity').val());

                    if($quantity > $borrowedQuantity){
                        $(this).val($borrowedQuantity);
                    }
                });

                $('#return').on('click', function(){
                    $btn = $(this)[0];
                    $spinner = '#returnSpinner';
                    $borrowedItemsId =  $('#returnBorrowedItemsId').val();
                    $productId = $('#returnProductId').val();
                    $quantity = $('#returnQuantity').val();
                    $borrowedQuantity = $('#returnBorrowedQuantity').val();
                    if($quantity == $borrowedQuantity ){
                        $action = 'delete';
                    }else{
                        $action = 'update';
                    }

                    $data = {
                        borrowedItemsId: $borrowedItemsId,
                        productId: $productId,
                        quantity: $quantity,
                        action: $action
                    }

                   returnItems($data, $btn, $spinner);

                });


            });

            function pushData(elem){
                $borrowedItemsId = elem.getAttribute('data-id');
                $productId = elem.getAttribute('data-product-id');
                $productName = elem.getAttribute('data-product-name');
                $quantity = elem.getAttribute('data-quantity');

                $('#modalReturnTitle').html($productName);
                $('#returnBorrowedItemsId').val($borrowedItemsId);
                $('#returnProductId').val($productId);
                $('#returnBorrowedQuantity').val($quantity);

            }



        </script>


        <!-- PNotify -->

        <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>
        <script type="text/javascript" src="js/notify/pnotify-actions.js"></script>



        <!-- Ajax request -->
        <script type="text/javascript" src="ajax/borrowed-items/ajax-borrowed-items.js"></script>

<?php include('includes/footer.php'); ?>