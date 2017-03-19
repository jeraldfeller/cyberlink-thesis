<?php
require 'Model/Init.php';
?>

<?php include('includes/header.php'); ?>
    <!-- page content -->
    <div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Categories</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2></h2>
                        <ul class="nav navbar-right panel_toolbox_btn panel_toolbox_btn_primary">
                            <li><a class="btn btn-primary" data-toggle="modal" data-target="#modalAddCategory"><i class="fa fa-plus"></i> Add Category</a>
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
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>




                        <!-- MODAL FOR ADD -->

                        <div class="modal fade" id="modalAddCategory" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                        </button>
                                        <h2 class="modal-title" id="myModalLabel">Add Category</h2>
                                    </div>
                                    <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4>Title</h4>
                                                    <input type="text" id="addTitle" name="addTitle" class="form-control col-lg-12 col-md-12 col-sm-12" style="width: 100%; !important;">
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

                        <div class="modal fade" id="modalEditCategory" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                                        </button>
                                        <h2 class="modal-title" id="modalEditCategoryTitle">Edit Category</h2>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4>Title</h4>
                                                <input type="text" id="editTitle" name="editTitle" class="form-control col-lg-12 col-md-12 col-sm-12" style="width: 100%; !important;">
                                                <input type="hidden" id="editCatId" name="editCatId" class="form-control col-lg-12 col-md-12 col-sm-12">
                                            </div>
                                        </div>
                                        <br/>
                                        <div style="text-align:center"><span id="editSpinner" style="opacity:0;"><i class="fa fa-spinner fa-spin"></i> Processing....</span></div>
                                    </div>

                                    <div class="modal-footer">
                                        <input class="btn btn-primary" type="button" value="Save" id="edit"/>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- /MODAL END FOR EDIT -->



                        <!-- MODAL FOR DELETE -->
                        <div class="modal fade" id="modalDeleteCategory" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <input type="hidden" id="deleteCatId" name="del_hdid"  class="form-control col-lg-12 col-md-12 col-sm-12">
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
                "sAjaxSource": "ajax/category/function?action=getCategories",
                responsive: true,
                "iDisplayLength": 20,
                "lengthMenu": [20, 50, 100],
                "order": [[ 0, "asc" ]]
            }
            );


            $('#add').on('click', function(){
                $btn = $(this)[0];
                $spinner = '#addSpinner';
                $title = $('#addTitle').val();

                addCategory($title, $btn, $spinner);

            });

            $('#edit').on('click', function(){
                $btn = $(this)[0];
                $spinner = '#editSpinner';
                $title = $('#editTitle').val();
                $catId = $('#editCatId').val();
                var data = {items:[]};
                $data = {
                    title: $title,
                    catId: $catId
                }


                editCategory($data, $btn, $spinner);
            });


            $('#delete').on('click', function(){
                $btn = $(this)[0];
                $spinner = '#deleteSpinner';
                $catId = $('#deleteCatId').val();

                deleteCategory($catId, $btn, $spinner);

            });


            setTimeout(function(){
                $('.editTooltip').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                $('.deleteTooltip').tooltip({title: "Remove", placement: "top", trigger: "hover"});
            }, 2000);

        });

        function pushData(elem){
            $action = elem.getAttribute('data-action');
            $title = elem.getAttribute('data-title');
            $catId = elem.getAttribute('data-id');

            if($action == 'edit'){
                $('#editTitle').val($title);
                $('#editCatId').val($catId);
            }else if($action == 'delete'){
                $('#deleteTitle').val($title);
                $('#deleteCatId').val($catId);
                $('#delmsg').html("Do you really want to remove <b><u>" + $title + "</b></u>?");
            }
        }



    </script>


    <!-- PNotify -->

    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>
    <script type="text/javascript" src="js/notify/pnotify-actions.js"></script>



       <!-- Ajax request -->
<script type="text/javascript" src="ajax/category/ajax-category.js"></script>

<?php include('includes/footer.php'); ?>