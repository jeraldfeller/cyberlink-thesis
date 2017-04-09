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
                <h3>Point Of Sale</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                            <select id="product" name="addSupplier" class="form-control" tabindex="-1" style="width: 100%;">
                                <option></option>
                                <?php echo $viewClass->getDisplaySelectPos(); ?>
                            </select>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <section class="content invoice">
                            <div id="printablediv">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-xs-12 invoice-header">
                                        <h1>
                                            <span id="invoiceIdDisplay"></span>
                                            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
                                        </h1>
                                        <input type="hidden" id="invoiceId">
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        <address>
                                            <strong>Walkin Customer</strong>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">

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
                                            <tbody id="appendProduct">

                                            </tbody>
                                            <tbody>

                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
                                                <td><strong id="subTotal"></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Delivery Charge:</strong></td>
                                                <td> Php0.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align: right;"><strong>Grand Total:</strong></td>
                                                <td>
                                                    <strong id="grandTotal"></strong>
                                                    <input type="hidden" id="inputGrandTotal">
                                                    <input type="hidden" id="inputBaseGrandTotal">
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

                            <button class="btn btn-large pull-right" id="checkOut">Check Out <i class="icon-arrow-right"></i></button>

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-xs-12">
                                    <button class="btn btn-default" onclick="printDiv('printablediv')"><i class="fa fa-print"></i> Print</button>
                                </div>
                            </div>
                        </section>

                </div>
            </div>
        </div>
    </div>
    <script src="//wzrd.in/standalone/blob-util@latest"></script>
    <script type="text/javascript">

        $(document).on('ready', function() {
            makeid('invoiceId');

            $("#product").select2({
                placeholder: "Search Product",
                allowClear: true
            });

            var i = 0;
            var data = {items:[]};
            $("#product").change(function () {
                $productVal = $(this).val();
                $product = $productVal.split('|');
                $('#appendProduct').append(
                    '<tr class="rowItems" id="index_' +i+ '" data-index="'+i+'" data-product-id="' + $product[0] + '" data-original-price="' +$product[3]+ '" data-selling-price="' +$product[4]+ '" data-profit="'  +$product[5]+ '" >' +
                    '<td><img width="60" src="http://admin.cyberlink.com/images/products/' + $product[1] + '" alt=""/></td>' +
                    '<td>' + $product[2] + '</td>' +
                    '<td><input data-index="'+i+'" data-product-name="'+$product[2]+'" data-max-qty="'+$product[6]+'" data-product-id="'+ $product[0] +'" data-base-price="'+$product[3]+'" data-selling-price="'+$product[4]+'" type="number" value="1" onchange="updateQuantity(this)" style="width: 40px;" class="from-control" id="qty_'+i+'"></td>' +
                    '<td>Php' + number_format($product[4], 2, '.', ',') + '</td>' +
                    '<td><input type="hidden" id="totalInputProduct_'+i+'" class="totalProduct" data-index="'+i+'" data-product-id="'+ $product[0] +'" data-base-price="'+$product[3]+'" data-selling-price="'+$product[4]+'" value="'+$product[4]+'"><span id="totalProduct_'+i+'">Php' + number_format($product[4], 2, '.', ',') + '</span></td>' +
                    '</tr>'
                );

                i++;

                calculateTotal();

            });


            $('#checkOut').click(function(){

                $data = {
                    info: {
                        customerId: 1,
                        invoiceId: $('#invoiceId').val(),
                        modeOfPayment: 'Walkin',
                        dateOfDelivery: '<?php echo date('Y-m-d'); ?>',
                        deliveryAddress: '',
                        sumTotal: $('#inputGrandTotal').val(),
                        baseSumTotal: $('#inputBaseGrandTotal').val()
                    },
                    items:[]}
                $sumTotal = 0;
                $baseSumTotal = 0;
                $('.rowItems').each(function(){
                    $index = this.getAttribute('data-index');
                    $productId = this.getAttribute('data-product-id');
                    $originalPrice = this.getAttribute('data-original-price');
                    $sellingPrice = this.getAttribute('data-selling-price');
                    $profit = this.getAttribute('data-profit');
                    $totalInput = $('#totalInputProduct_'+$index).val();
                    $totalBaseInput = $('#totalBaseInputProduct_'+$index).val();
                    $quantity = $('#qty_'+$index).val();
                    $data.items.push({
                        productId: $productId,
                        originalPrice: $originalPrice,
                        sellingPrice: $sellingPrice,
                        profit: $profit,
                        quantity: $quantity,
                        totalPrice: $totalInput
                    });

                });
                checkOut($data);

            });

        });



        function updateQuantity(elem) {
            $productId = elem.getAttribute('data-product-id');
            $index = elem.getAttribute('data-index');
            $sellingPrice = parseInt(elem.getAttribute('data-selling-price'));
            $basePrice = parseInt(elem.getAttribute('data-base-price'));
            $maxQty = parseInt(elem.getAttribute('data-max-qty'));
            $productName = elem.getAttribute('data-product-name');
            $inputQuantity = $('#qty_'+$index).val();
            $totalPrice = $sellingPrice * $inputQuantity;
            $('#totalInputProduct_'+$index).val($totalPrice);
            $('#totalBaseInputProduct_'+$index).val($totalPrice);
            $('#totalProduct_'+$index).html(number_format($totalPrice, 2, '.', ','));

            if($inputQuantity > $maxQty){
                alert($maxQty +' available stocks for '+$productName);
                $('#qty_'+$index).val($maxQty);
            }else{
                calculateTotal();
            }



        }

        function calculateTotal(){
            $sumTotal = 0;
            $baseSumTotal = 0;
            $('.totalProduct').each(function(){
                $productId = this.getAttribute('data-product-id');
                $index = this.getAttribute('data-index');
                $sellingPrice = parseInt(this.getAttribute('data-selling-price'));
                $basePrice = parseInt(this.getAttribute('data-base-price'));
                $inputQuantity = parseInt($('#qty_'+$index).val());
                $index = this.getAttribute('data-index');
                $sumTotal += parseFloat($('#totalInputProduct_'+$index).val());
                $baseSumTotal += $basePrice * $inputQuantity;
            });
            console.log($sumTotal);
            console.log($inputQuantity);
            $('#subTotal').html(number_format($sumTotal, '2', '.', ','));
            $('#grandTotal').html(number_format($sumTotal, '2', '.', ','));
            $('#inputGrandTotal').val($sumTotal);
            $('#inputBaseGrandTotal').val($baseSumTotal);
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