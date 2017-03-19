<?php
include 'includes/header.php';
?>
<style>
    .validate {
        margin-top: 10px;
    }
    .invalid-form-error-message {
        margin-top: 10px;
        padding: 5px;
    }
    .invalid-form-error-message.filled {
        border-left: 2px solid #E74C3C;
    }
    p.parsley-success {
        color: #468847;
        background-color: #DFF0D8;
        border: 1px solid #D6E9C6;
    }
    p.parsley-error {
        color: #B94A48;
        background-color: #F2DEDE;
        border: 1px solid #EED3D7;
    }
    ul.parsley-errors-list {
        list-style: none;
        color: #E74C3C;
        padding-left: 0;
    }
    input.parsley-error, textarea.parsley-error, select.parsley-error {
        background: #FAEDEC;
        border: 1px solid #E85445;
    }

</style>

    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <div class="well well-small"><a id="myCart" href="product_summary.html"><img src="themes/images/ico-cart.png" alt="cart">3 Items in your cart  <span class="badge badge-warning pull-right">$155.00</span></a></div>
                    <ul id="sideManu" class="nav nav-tabs nav-stacked">
                        <?php
                        echo $view->getDisplayListCategories();
                        ?>
                    </ul>
                    <br/>
                </div>
                <!-- Sidebar end=============================================== -->
                <div class="span9">
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
                        <li class="active">Registration</li>
                    </ul>
                    <h3> Registration</h3>
                    <div class="well">
                        <form id="registerForm" class="form-horizontal" data-parsley-validate>
                            <h4>Your personal information</h4>
                            <div class="control-group">
                                <label class="control-label" for="firstName">First name <sup>*</sup></label>
                                <div class="controls">
                                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="lastName">Last name <sup>*</sup></label>
                                <div class="controls">
                                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="input_email">Email <sup>*</sup></label>
                                <div class="controls">
                                    <input type="email" value="<?php (isset($_POST['email']) ? $_POST['email'] : ''); ?>" id="email" name="email"  placeholder="Email" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Password <sup>*</sup></label>
                                <div class="controls">
                                    <input type="password" id="password" name="password" placeholder="password" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Date of Birth <sup>*</sup></label>
                                <div class="controls">
                                    <input type="date" id="dateOfBirth" name="dateOfBirth" placeholder="password" required>
                                </div>
                            </div>

                            <h4>Your address</h4>
                            <div class="control-group">
                                <label class="control-label" for="address">Address<sup>*</sup></label>
                                <div class="controls">
                                    <input type="text" id="address" name="address" placeholder="Adress"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="city">City<sup>*</sup></label>
                                <div class="controls">
                                    <input type="text" id="city" name="city" placeholder="city"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="homeNumber">Home phone <sup>*</sup></label>
                                <div class="controls">
                                    <input type="text"  name="homeNumber" id="homeNumber" placeholder="phone"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="mobileNumber">Mobile Phone </label>
                                <div class="controls">
                                    <input type="text"  name="mobileNumber" id="mobileNumber" placeholder="Mobile Phone"/>
                                </div>
                            </div>

                            <p><sup>*</sup>Required field	</p>

                            <div class="control-group">
                                <div class="controls">
                                    <input class="btn btn-large btn-success" type="submit" value="Register" id="register" />
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- MainBody End ============================= -->


<script>
    $(document).on('ready', function(){
        $("form#registerForm").submit(function(event){

            //disable the default form submission
            event.preventDefault();
            event.stopPropagation();
            $('#registerForm').parsley().validate();
            $validateResponse = validateRegisterForm();

            console.log($validateResponse);

            if($validateResponse == true){
                //grab all form data
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: 'ajax/registration/function.php?action=register',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(returnedData){
                        if(returnedData == true){
                            window.location.href = 'index';
                        }else if(returnedData == false){
                            alert('Email already exist');
                            $('#email').focus();
                        }

                    },
                    error: function(error){

                    }
                });
            }



            return false;

        });
    })

    var validateRegisterForm = function() {
        if (true === $('#registerForm').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
            return true;
        } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
            return false;
        }
    };
</script>

<?php
include 'includes/footer.php';
?>