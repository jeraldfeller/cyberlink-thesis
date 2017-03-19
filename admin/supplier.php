<?php
require 'Model/Init.php';
?>

<?php include('includes/header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Supplier</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2></h2>
                            <ul class="nav navbar-right panel_toolbox_btn panel_toolbox_btn_primary">
                                <li><a class="btn btn-primary" data-toggle="modal" data-target="#modalAddSupplier"><i class="fa fa-plus"></i> Add Supplier</a>
                                </li>
                            </ul>
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
                                            <th>Contact Person</th>
                                            <th>Contact No.</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            <!-- MODAL FOR ADD -->

                            <div class="modal fade" id="modalAddSupplier" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="myModalLabel">Add Supplier</h2>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <h4>Supplier Name</h4>
                                                    <input type="text" id="addName" name="addName" class="form-control">
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Address</h4>
                                                    <textarea rows="3" class="form-control" id="addAddress"></textarea>
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Contact Person</h4>
                                                    <input type="text" class="form-control" id="addContactPerson">
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Contact No.</h4>
                                                    <input type="text" class="form-control" maxlength="11" id="addContactNo" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                            <br/>
                                            <div style="text-align:center"><span id="addSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                        </div>

                                        <div class="modal-footer">

                                            <input class="btn btn-primary" type="button" value="Save" id="add"/>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- /MODAL END FOR ADD -->


                            <!-- MODAL FOR EDIT -->

                            <div class="modal fade" id="modalEditSupplier" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="modalEditSupplierName">Edit Supplier</h2>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <h4>Supplier Name</h4>
                                                    <input type="text" id="editName"  class="form-control">
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Address</h4>
                                                    <textarea rows="3" class="form-control" id="editAddress"></textarea>
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Contact Person</h4>
                                                    <input type="text" class="form-control" id="editContactPerson">
                                                </div>
                                                <div class="col-lg-12">
                                                    <h4>Contact No.</h4>
                                                    <input type="text" class="form-control" maxlength="11" id="editContactNo" onkeypress="return isNumberKey(event)">
                                                </div>
                                            </div>
                                            <br/>
                                            <div style="text-align:center"><span id="editSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                        </div>

                                        <div class="modal-footer">
                                            <input type="hidden" id="editSupId"  class="form-control">
                                            <input class="btn btn-primary" type="button" value="Save" id="edit"/>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- /MODAL END FOR EDIT -->



                            <!-- MODAL FOR DELETE -->
                            <div class="modal fade" id="modalDeleteSupplier" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                            </button>
                                            <h2 class="modal-title" id="modalDeleteSupplierName"><i class="fa fa-warning"></i> Warning</h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p id="delmsg"></p>
                                                    <input type="hidden" id="deleteSupId" class="form-control col-lg-12 col-md-12 col-sm-12">
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
        <script type="text/javascript">

            $(document).on('ready', function() {

                $('#datatable-responsive').DataTable({
                        fixedHeader: true,
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": "ajax/supplier/function?action=getSuppliers",
                        responsive: true,
                        "iDisplayLength": 20,
                        "lengthMenu": [20, 50, 100],
                        "order": [[ 0, "asc" ]]
                    }
                );


                $('#add').on('click', function(){
                    $btn = $(this)[0];
                    $spinner = '#addSpinner';
                    $name = $('#addName').val();
                    $address = $('#addAddress').val();
                    $contactPerson = $('#addContactPerson').val();
                    $contactNo = $('#addContactNo').val();

                    $data = {
                        name: $name,
                        address: $address,
                        contactPerson: $contactPerson,
                        contactNo: $contactNo
                    }


                    addSupplier($data, $btn, $spinner);

                });

                $('#edit').on('click', function(){
                    $btn = $(this)[0];
                    $spinner = '#editSpinner';
                    $name = $('#editName').val();
                    $address = $('#editAddress').val();
                    $contactPerson = $('#editContactPerson').val();
                    $contactNo = $('#editContactNo').val();
                    $supId = $('#editSupId').val();

                    $data = {
                        name: $name,
                        address: $address,
                        contactPerson: $contactPerson,
                        contactNo: $contactNo,
                        supId: $supId
                    }


                    editSupplier($data, $btn, $spinner);
                });


                $('#delete').on('click', function(){
                    $btn = $(this)[0];
                    $spinner = '#deleteSpinner';
                    $catId = $('#deleteSupId').val();

                    deleteSupplier($catId, $btn, $spinner);

                });


                setTimeout(function(){
                    $('.editTooltip').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                    $('.deleteTooltip').tooltip({title: "Remove", placement: "top", trigger: "hover"});
                }, 2000);

            });

            function pushData(elem){
                $action = elem.getAttribute('data-action');
                $name = elem.getAttribute('data-supplier');
                $supId = elem.getAttribute('data-id');
                $address = elem.getAttribute('data-address');
                $contactPerson = elem.getAttribute('data-contact');
                $contactNo = elem.getAttribute('data-contact-no');
                if($action == 'edit'){
                    $('#editName').val($name);
                    $('#editSupId').val($supId);
                    $('#editAddress').val($address);
                    $('#editContactPerson').val($contactPerson);
                    $('#editContactNo').val($contactNo);
                }else if($action == 'delete'){
                    $('#deleteSupId').val($supId);
                    $('#delmsg').html("Do you really want to remove <b><u>" + $name + "</b></u>?");
                }
            }



        </script>


        <!-- PNotify -->

        <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
        <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>
        <script type="text/javascript" src="js/notify/pnotify-actions.js"></script>



        <!-- Ajax request -->
        <script type="text/javascript" src="ajax/supplier/ajax-supplier.js"></script>

<?php include('includes/footer.php'); ?>