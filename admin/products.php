<?php
require 'Model/Init.php';
require 'View/FormElements.php';

$viewClass = new FormElements();

?>

<?php include('includes/header.php'); ?>
<style>
    .daterangepicker{z-index:9999 !important}
</style>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Products</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2></h2>
                            <ul class="nav navbar-right panel_toolbox_btn panel_toolbox_btn_primary">
                                <li><button class="btn btn-primary" data-toggle="modal" data-target="#modalAddProduct" onclick="makeid()"><i class="fa fa-plus"></i> Add Products</button>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="datatable-responsive" class="table middle table-striped jambo_table bulk_action dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                        <tr class="headings">
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Stock ID</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Supplier</th>
                                            <th>Date of Arrival</th>
                                            <th>Original Price</th>
                                            <th>Selling Price</th>
                                            <th>Profit</th>
                                            <th>Borrowed Item</th>
                                            <th>Qty.</th>
                                            <th># of item Sold</th>
                                            <th>Total</th>
                                            <th>Featured</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <!-- MODAL FOR ADD -->

                            <div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="myModalLabel">Add Product</h2>
                                        </div>
                                        <form id="addForm" data-parsley-validate>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4>Stock ID</h4>
                                                    <input type="text" id="addStockId" name="addStockId" class="form-control" readonly>
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Product Name</h4>
                                                    <input type="text" id="addProduct" name="addProduct" class="form-control" required="required" >
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Description</h4>
                                                    <textarea id="addDescription" name="addDescription" rows="2" class="form-control"></textarea>
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4>Original Price</h4>
                                                    <input type="text" id="addOriginalPrice" name="addOriginalPrice" onChange="formatCurrency(this)" class="form-control"  required="required">
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4>Selling Price</h4>
                                                    <input type="text" id="addSellingPrice" name="addSellingPrice"  onChange="formatCurrency(this)" class="form-control"  required="required">
                                                </div>
                                                <div class="col-lg-4">
                                                    <h4>Quantity</h4>
                                                    <input type="text" id="addQuantity" name="addQuantity"  onkeypress="return isNumberKey(event)" class="form-control"  required="required">
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4>Brand</h4>
                                                    <input type="text" id="addBrand" name="addBrand" class="form-control" data-provide="typeahead">
                                                </div>

                                                <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                                                    <h4>Date of Arrival</h4>
                                                    <input type="text" class="form-control has-feedback-right" id="addDateArrival" name="addDateArrival" placeholder="Select Date" aria-describedby="inputSuccess2Status4">
                                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                </div>



                                                <div class="col-lg-6">
                                                    <h4>Supplier</h4>
                                                    <select id="addSupplier" name="addSupplier" class="form-control" tabindex="-1" style="width: 100%;">
                                                        <option></option>
                                                        <?php echo $viewClass->getDisplaySelectSuppliers(); ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4>Category</h4>
                                                    <select id="addCategory" name="addCategory" class="form-control" tabindex="-1" style="width: 100%;"  required="required">
                                                        <option></option>
                                                        <?php echo $viewClass->getDisplaySelectCategories(); ?>
                                                    </select>
                                                </div>

                                                <div class="col-lg-6">
                                                    <h4>Image</h4>
                                                    <input type="file" id="addFile" name="addFile" class="filestyle" data-buttonBefore="true" data-buttonText="Choose File">
                                                </div>

                                                <div class="col-lg-6">
                                                    <h4>Featured</h4>
                                                    <input class="switch_btn" id="addFeatured" data-on-color="success" data-size="larges" data-off-color="danger" data-on-text="YES" data-off-text="NO" type="checkbox" value="1" name="addFeatured">
                                                </div>

                                            </div>
                                            <br/>
                                            <div style="text-align:center"><span id="addSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                        </div>

                                        <div class="modal-footer">

                                            <input class="btn btn-primary" type="submit" value="Save" id="add"/>
                                        </div>
                                     </form>
                                    </div>
                                </div>
                            </div>


                            <!-- /MODAL END FOR ADD -->


                            <!-- MODAL FOR EDIT -->

                            <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="myModalLabel">Add Product</h2>
                                        </div>
                                        <form id="editForm" data-parsley-validate>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <input type="hidden" id="editProductId" name="editProductId" class="form-control">
                                                    <div class="col-lg-12">
                                                        <h4>Stock ID</h4>
                                                        <input type="text" id="editStockId" name="editStockId" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <h4>Product Name</h4>
                                                        <input type="text" id="editProduct" name="editProduct" class="form-control" required="required" >
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <h4>Description</h4>
                                                        <textarea id="editDescription" name="editDescription" rows="2" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h4>Original Price</h4>
                                                        <input type="text" id="editOriginalPrice" name="editOriginalPrice" onChange="formatCurrency(this)" class="form-control"  required="required">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h4>Selling Price</h4>
                                                        <input type="text" id="editSellingPrice" name="editSellingPrice"  onChange="formatCurrency(this)" class="form-control"  required="required">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h4>Quantity</h4>
                                                        <input type="text" id="editQuantity" name="editQuantity"  onkeypress="return isNumberKey(event)" class="form-control"  required="required">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h4>Brand</h4>
                                                        <input type="text" id="editBrand" name="editBrand" class="form-control" data-provide="typeahead">
                                                    </div>

                                                    <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                                                        <h4>Date of Arrival</h4>
                                                        <input type="text" class="form-control has-feedback-right" id="editDateArrival" name="editDateArrival" placeholder="Select Date" aria-describedby="inputSuccess2Status4">
                                                        <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                                    </div>



                                                    <div class="col-lg-6">
                                                        <h4>Supplier</h4>
                                                        <select id="editSupplier" name="editSupplier" class="form-control" tabindex="-1" style="width: 100%;">
                                                            <option></option>
                                                            <?php echo $viewClass->getDisplaySelectSuppliers(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h4>Category</h4>
                                                        <select id="editCategory" name="editCategory" class="form-control" tabindex="-1" style="width: 100%;"  required="required">
                                                            <option></option>
                                                            <?php echo $viewClass->getDisplaySelectCategories(); ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <h4>Image</h4>
                                                        <input type="file" id="editFile" name="editFile" class="filestyle" data-buttonBefore="true" data-buttonText="Choose File">
                                                        <input type="hidden" id="editImage" name="editImage" >
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <h4>Featured</h4>
                                                        <input class="switch_btn" id="editFeatured" data-on-color="success" data-size="larges" data-off-color="danger" data-on-text="YES" data-off-text="NO" type="checkbox" value="1" name="editFeatured">
                                                    </div>

                                                </div>
                                                <br/>
                                                <div style="text-align:center"><span id="editSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                            </div>

                                            <div class="modal-footer">

                                                <input class="btn btn-primary" type="submit" value="Save" id="edit"/>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <!-- /MODAL END FOR EDIT -->
                            <!-- MODAL FOR BORROW -->
                            <div class="modal fade" id="modalBorrowProduct" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="modalBorrowTitle"></h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <input type="hidden" id="borrowProductId" class="form-control">
                                                        <h4>Quantity</h4>
                                                        <input type="text" id="borrowQuantity" name="borrowQuantity"  onkeypress="return isNumberKey(event)" class="form-control"  required="required">
                                                </div>
                                                <div class="col-lg-6">
                                                    <h4>Quantity Left.</h4>
                                                    <input type="text" id="borrowQuantityLeft" class="form-control" disabled>
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Notes</h4>
                                                    <textarea rows="2" class="form-control" id="borrowNotes"></textarea>
                                                </div>
                                            </div>
                                            <div style="text-align:center"><span id="borrowSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                        </div>

                                        <div class="modal-footer">

                                            <input class="btn btn-primary" type="button" value="Borrow this Item" id="borrow"/>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /MODAL END FOR BORROW -->
                            <!-- MODAL FOR DELETE -->
                            <div class="modal fade" id="modalDeleteProduct" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="modalDeleteCategoryTitle"><i class="fa fa-warning"></i> Warning</h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p id="delmsg"></p>
                                                    <input type="hidden" id="deleteProductId" class="form-control col-lg-12 col-md-12 col-sm-12">
                                                </div>
                                            </div>
                                            <div style="text-align:center"><span id="deleteSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                        </div>

                                        <div class="modal-footer">

                                            <input class="btn btn-primary" type="button" value="Delete" id="delete"/>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- /MODAL END FOR DELETE -->



                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="//wzrd.in/standalone/blob-util@latest"></script>
        <script type="text/javascript">

            $(document).on('ready', function() {

                // Calendar

                $('#addDateArrival').daterangepicker({
                    singleDatePicker: true,
                    calender_style: "picker_4"
                }, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });


                $('#addBrand').typeahead({
                        source: <?php echo $viewClass->getDisplayBrandDataSet(); ?>
                });

                $("#addCategory").select2({
                    placeholder: "Select Category",
                    allowClear: true
                });

                $("#addSupplier").select2({
                    placeholder: "Select Supplier",
                    allowClear: true
                });

                $('#datatable-responsive').DataTable({
                        fixedHeader: true,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "ajax/products/function?action=getProducts",
                        responsive: true,
                        "iDisplayLength": 20,
                        "lengthMenu": [20, 50, 100],
                        "order": [[ 0, "asc" ]],
                        "fnDrawCallback": function( oSettings ) {
                            $('.editTooltip').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                            $('.deleteTooltip').tooltip({title: "Remove", placement: "top", trigger: "hover"});
                            $('.borrowTooltip').tooltip({title: "Borrow this item", placement: "top", trigger: "hover"});
                            $("input[type=checkbox].switch_btn").bootstrapSwitch();
                        }
                    }
                );

                // Add Product Process


                $("form#addForm").submit(function(event){

                    $btn = $('#add')[0];
                    $spinner = '#addSpinner';
                    loadSpinner($btn, 'show', $spinner);
                    //disable the default form submission
                    event.preventDefault();
                    event.stopPropagation();
                    $('#addForm').parsley().validate();
                    $validateResponse = validateAddForm();
                    if($validateResponse == true){
                        //grab all form data
                        var formData = new FormData($(this)[0]);

                        $.ajax({
                            url: 'ajax/products/function.php?action=add',
                            type: 'POST',
                            data: formData,
                            async: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(returnedData){
                                if(returnedData == true){
                                    $table = $('#datatable-responsive').DataTable();
                                    $('#addStockId').val('');
                                    $('#addProduct').val('');
                                    $('#addDescription').val('');
                                    $('#addOriginalPrice').val('');
                                    $('#addSellingPrice').val('');
                                    $('#addQuantity').val('');
                                    $('#addBrand').val('');
                                    $('#addProduct').focus();

                                    makeid();
                                    $table.ajax.reload();

                                    pNotifyEvent(false, 'success',  'Product Successfully Added');
                                }
                                loadSpinner($btn, 'hide', $spinner);
                            },
                            error: function(error){
                                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
                                loadSpinner($btn, 'hide', $spinner);
                            }
                        });
                    }

                    return false;

                });


                // edit proccess

                $("form#editForm").submit(function(event){

                    $btn = $('#edit')[0];
                    $spinner = '#editSpinner';
                    loadSpinner($btn, 'show', $spinner);
                    //disable the default form submission
                    event.preventDefault();
                    event.stopPropagation();
                    $('#editForm').parsley().validate();
                    $validateResponse = validateEditForm();
                    if($validateResponse == true){
                        //grab all form data
                        var formData = new FormData($(this)[0]);

                        $.ajax({
                            url: 'ajax/products/function.php?action=edit',
                            type: 'POST',
                            data: formData,
                            async: false,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(returnedData){
                                if(returnedData == true){
                                    $table = $('#datatable-responsive').DataTable();
                                    $table.ajax.reload();

                                    $('#modalEditProduct').modal('hide');

                                    pNotifyEvent(false, 'success',  'Product Successfully Updated');
                                }
                                loadSpinner($btn, 'hide', $spinner);
                            },
                            error: function(error){
                                $('#modalEditProduct').modal('hide');
                                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
                                loadSpinner($btn, 'hide', $spinner);
                            }
                        });
                    }

                    return false;

                });


                var validateAddForm = function() {
                    if (true === $('#addForm').parsley().isValid()) {
                        $('.bs-callout-info').removeClass('hidden');
                        $('.bs-callout-warning').addClass('hidden');
                        return true;
                    } else {
                        $('.bs-callout-info').addClass('hidden');
                        $('.bs-callout-warning').removeClass('hidden');
                        return false;
                    }
                };

                var validateEditForm = function() {
                    if (true === $('#editForm').parsley().isValid()) {
                        $('.bs-callout-info').removeClass('hidden');
                        $('.bs-callout-warning').addClass('hidden');
                        return true;
                    } else {
                        $('.bs-callout-info').addClass('hidden');
                        $('.bs-callout-warning').removeClass('hidden');
                        return false;
                    }
                };




                $('#delete').on('click', function(){
                    $btn = $(this)[0];
                    $spinner = '#deleteSpinner';
                    $productId = $('#deleteProductId').val();

                    deleteProduct($productId, $btn, $spinner);

                });

                $('#borrow').on('click', function(){
                    $btn = $(this)[0];
                    $spinner = '#borrowSpinner';
                    $productId = $('#borrowProductId').val();
                    $quantity = $('#borrowQuantity').val();
                    $notes = $('#borrowNotes').val();

                    $data = {
                        productId: $productId,
                        quantity: $quantity,
                        notes: $notes
                    }

                    borrowProduct($data, $btn, $spinner);

                });

                $('#borrowQuantity').on('change', function(){
                    $qty = parseInt($(this).val());
                    $qtyLeft = parseInt($('#borrowQuantityLeft').val());
                    if($qty > $qtyLeft){
                        $(this).val($qtyLeft);

                    }
                });


            });

            function pushData(elem){
                $action = elem.getAttribute('data-action');
                $productId = elem.getAttribute('data-id');
                $stockId = elem.getAttribute('data-stock-id');
                $productName = elem.getAttribute('data-product-name');
                $description = elem.getAttribute('data-description');
                $originalPrice = elem.getAttribute('data-original-price');
                $sellingPrice = elem.getAttribute('data-selling-price');
                $profit = elem.getAttribute('data-profit');
                $dateArrival = elem.getAttribute('data-date-arrival');
                $quantity = elem.getAttribute('data-quantity');
                $supplier = elem.getAttribute('data-supplier');
                $category = elem.getAttribute('data-category');
                $brandName = elem.getAttribute('data-brand-name');
                $fileName = elem.getAttribute('data-file-name');
                $featured = elem.getAttribute('data-featured');

                if($action == 'edit'){
                    $('#editProductId').val($productId);
                    $('#editStockId').val($stockId);
                    $('#editProduct').val($productName);
                    $('#editDescription').val($description);
                    $('#editOriginalPrice').val($originalPrice);
                    $('#editSellingPrice').val($sellingPrice);
                    $('#editQuantity').val($quantity);
                    $('#editBrand').val($brandName);
                    $('#editDateArrival').val($dateArrival);
                    $('#editSupplier').val($supplier);
                    $('#editCategory').val($category);
                    $('#editImage').val($fileName);
                    if($featured == 1){
                        $('input[name="editFeatured"]').bootstrapSwitch('state', true, true);
                    }else{
                        $('input[name="editFeatured"]').bootstrapSwitch('state', true, false);
                    }

                    $('#editProduct').focus();


                }else if($action == 'delete'){
                    $('#deleteProduct').val($productName);
                    $('#deleteProductId').val($productId);
                    $('#delmsg').html("Do you really want to remove <b><u>" + $productName + "</b></u>?");
                }else if($action == 'borrow'){
                    $('#modalBorrowTitle').html($productName);
                    $('#borrowProductId').val($productId);
                    $('#borrowQuantityLeft').val($quantity);

                }
            }



            function makeid()
            {
                var text = "";
                var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
                var timeStamp = Math.floor(Date.now() / 1000);
                for( var i=0; i < 3; i++ )
                    text += possible.charAt(Math.floor(Math.random() * possible.length));

                $('#addStockId').val(text+timeStamp);
            }

        </script>


        <!-- PNotify -->

        <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>
        <script type="text/javascript" src="js/notify/pnotify-actions.js"></script>



        <!-- Ajax request -->
        <script type="text/javascript" src="ajax/products/ajax-products.js"></script>

<?php include('includes/footer.php'); ?>