<?php
include 'includes/header.php';
?>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="cart"><img src="themes/images/ico-cart.png" alt="cart"><?php echo $itemCount; ?> <small>Items in your cart</small> <span class="badge badge-warning pull-right">Php<?php echo $partialTotal; ?></span></a></div>
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
                        <li class="active"> SHOPPING CART</li>
                    </ul>
                    <h3>  SHOPPING CART [ <small><?php echo $itemCount; ?> Item(s) </small>]<a href="products" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
                    <hr class="soft"/>
                    <h3 id="invoiceIdDisplay"></h3>
                    <input type="text" style="display: none;" class="form-control" id="invoiceId" readonly>
                    <div class="control-group">
                        <label class="control-label"> Mode of Payment | Date of delivery/pickup</label>
                        <div class="controls">
                            <select id="modeOfPayment">
                                <option value="pick up">Pick up</option>
                                <option value="delivery">Delivery</option>
                            </select>
                            <input type="date" id="dateOfDelivery">
                            <input type="time" id="timeOfDelivery">
                        </div>
                    </div>


                    <div class="control-group" id="deliverDisplay" style="display: none;">
                        <label class="control-label"> Delivery Address</label>
                        <div class="controls">
                           <textarea rows="2" id="deliveryAddress" class="form-control span9"></textarea>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Quantity/Update</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $view->getDisplayCartTable(); ?>
                            <td colspan="4" style="text-align:right"><strong>TOTAL</strong></td>
                            <td style="display: none;"><input type="text" id="inputSumTotal"></td>
                            <td class="label label-important" style="display:block"> <strong> Php<span id="sumTotal"><?php echo (isset($_SESSION['partial_total']) ? number_format($_SESSION['partial_total'], 2) : 0.00); ?> </span></strong></td>
                        </tr>
                        </tbody>
                    </table>



                    <a href="products" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
                    <button class="btn btn-large pull-right" id="checkOut">Check Out <i class="icon-arrow-right"></i></button>

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
            }else{
                $data = {info: <?php echo $_SESSION['customer_id']; ?>, items:[]}
                $sumTotal = 0;
                $('.rowItems').each(function(){
                    $index = this.getAttribute('data-index');
                    $productId = this.getAttribute('data-product-id');
                    $sellingPrice = this.getAttribute('data-selling-price');
                    $totalInput = $('#total_input_'+$index).val();
                    $quantity = $('#qty_'+$index).val();

                    $sumTotal += (parseFloat($('#total_input_'+$index).val()));

                    $data.items.push({
                        productId: $productId,
                        sellingPrice: $sellingPrice,
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