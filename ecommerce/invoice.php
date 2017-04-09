<?php
include 'includes/header.php';
$orderClass = new Orders();
$invoice = $orderClass->getOrdersByTransactionId($_GET['id']);
$items = $orderClass->getOrderItemsByInvoiceId($invoice['invoice_id']);
?>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="cart"><img src="themes/images/ico-cart.png" alt="cart"><span id="bodyItemCount"><?php echo $itemCount; ?> </span><small>Items in your cart</small> <span class="badge badge-warning pull-right">Php<span id="bodyCartTotalPartial"><?php echo $partialTotal; ?></span></span></a></div>
                    <ul id="sideManu" class="nav nav-tabs nav-stacked">
                        <?php
                        echo $view->getDisplayListCategories();
                        ?>
                    </ul>

                </div>
                <!-- Sidebar end=============================================== -->
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active">  INVOICE </li>
                    </ul>
                    <hr class="soft"/>
                    <?php
                        if($invoice['status'] == 'PENDING'){
                            echo '<h3 class="btn btn-warning">' . $invoice['status'] . '</h3>';
                        }else if($invoice['status'] == 'APPROVED'){
                            echo '<h3 class="btn btn-primary">' . $invoice['status'] . '</h3>';
                        }else if($invoice['status'] == 'DECLINED'){
                            echo '<h3 class="btn btn-danger>' . $invoice['status'] . '</h3>';
                        }else if($invoice['status'] == 'COMPLETE'){
                            echo '<h3 class="btn btn-success">' . $invoice['status'] . '</h3>';
                        }
                    ?>

                    <div id="printablediv">
                    <h3><?php echo $_GET['id']; ?></h3>
                    <h4>Mode of payment: <u><?php echo $invoice['mode_of_payment']; ?></u> | Delivery/Pickup Date: <u><?php echo date('m/d/Y', strtotime($invoice['date_of_delivery'])); ?></u></h4>
                    <h4>Delivery Address: <u><?php echo $invoice['delivery_address']; ?></u></h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $view->getDisplayOrdersItemsTable($items); ?>
                        <tr>
                        <td colspan="4" style="text-align:right"><strong>SUB TOTAL</strong></td>
                        <td class="label label-important" style="display:block"> <strong> Php <?php echo number_format($invoice['total_price'], 2); ?> </span></strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right"><strong>DELIVERY CHARGE</strong></td>
                            <td class="label label-important" style="display:block"> <strong> Php <?php echo number_format($invoice['delivery_charge'], 2); ?> </span></strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right"><strong>GRAND TOTAL</strong></td>
                            <td class="label label-important" style="display:block"> <strong> Php <?php echo number_format($invoice['total_price'] + $invoice['delivery_charge'], 2); ?> </span></strong></td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <button class="btn btn-default" onclick="printDiv('printablediv')"><i class="fa fa-print"></i> Print</button>

                </div>
            </div></div>


    </div>

    <script>

        $(document).ready(function(){
            makeid('invoiceId');
            $('#modeOfPayment').change(function(){
                if($(this).val() == 'delivery'){
                    $('#deliverDisplay').css('display', 'inline');
                }else{
                    $('#deliverDisplay').css('display', 'none');
                }
            })

            $('#checkOut').click(function(){
                if($('#dateOfDelivery').val() == ''){
                    alert('Please Input Date of Delivery');
                    $('#dateOfDelivery').focus();
                }
                else{
                    $data = {
                        info: {
                            customerId: <?php echo (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : 0); ?>,
                            invoiceId: $('#invoiceId').val(),
                            dateOfDelivery: $('#dateOfDelivery').val(),
                            modeOfPayment: $('#modeOfPayment').val(),
                            deliveryAddress: $('#deliveryAddress').val(),
                            sumTotal: $('#inputSumTotal').val()
                        },
                        items:[]}
                    $sumTotal = 0;
                    $('.rowItems').each(function(){
                        $index = this.getAttribute('data-index');
                        $productId = this.getAttribute('data-product-id');
                        $originalPrice = this.getAttribute('data-original-price');
                        $sellingPrice = this.getAttribute('data-selling-price');
                        $profit = this.getAttribute('data-profit');
                        $totalInput = $('#total_input_'+$index).val();
                        $quantity = $('#qty_'+$index).val();

                        $sumTotal += (parseFloat($('#total_input_'+$index).val()));

                        $data.items.push({
                            productId: $productId,
                            originalPrice: $originalPrice,
                            sellingPrice: $sellingPrice,
                            profit: $profit,
                            quantity: $quantity,
                            totalInput: $totalInput
                        });

                    });

                    $data.total = $sumTotal;


                    checkOut($data);
                }

            });
        });

        function updateQuantity(elem){

            $action = elem.getAttribute('data-action');
            $productId = elem.getAttribute('data-product-id');
            $index = elem.getAttribute('data-index');
            $sellingPrice = parseInt(elem.getAttribute('data-selling-price'));
            $inputQuantity = parseInt($('#qty_'+$index).val());

            if($action == 'plus'){
                $qty = $inputQuantity + 1;
                $('#qty_'+$index).val($qty);
                $inputTotal = $qty * $sellingPrice;

                $('#total_input_'+$index).val($inputTotal);
                $('#total_price_'+$index).html(number_format($inputTotal, 2, '.', ','));


            }else if($action == 'minus'){
                if($inputQuantity != 1){
                    $qty = $inputQuantity - 1;
                    $('#qty_'+$index).val($qty);
                    $inputTotal = $qty * $sellingPrice;

                    $('#total_input_'+$index).val($inputTotal);
                    $('#total_price_'+$index).html(number_format($inputTotal, 2, '.', ','));

                }

            }else if($action == 'remove'){
                $('#index_'+$index).remove();

                $data = {
                    productId: $productId,
                    remove: true
                }
                addToCart($data);

            }else{
                $qty = $('#qty_'+$index).val();
                $inputTotal = $qty * $sellingPrice;

                $('#total_input_'+$index).val($inputTotal);
                $('#total_price_'+$index).html(number_format($inputTotal, 2, '.', ','));

            }

            if($('#qty_'+$index).val() == ''){
                $('#qty_'+$index).val(1);
            }




            $sumTotal = 0;
            $('.rowItems').each(function(){
                $index = this.getAttribute('data-index');
                $sumTotal += (parseFloat($('#total_input_'+$index).val()));

            });

            $('#sumTotal').html(number_format($sumTotal, 2, '.', ','));
            $('#inputSumTotal').val($sumTotal);


            /*
             $quantity = 1;
             $productId = elem.getAttribute('data-product-id');
             $price = elem.getAttribute('data-selling-price');


             $data = {
             productId: $productId,
             price: $price,
             quantity: $quantity

             }
             addToCart($data);
             */
        }

    </script>
<?php
include 'includes/footer.php';
?>