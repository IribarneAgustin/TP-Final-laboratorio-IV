<?php
include_once('header.php');
include_once('nav-bar.php');
?>

<div class="container py-5">

    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="mb-4" style="color:white">Pay Ticket</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card bg-dark">
                <div class="card-header">
                    <div class="shadow-sm pt-4 pl-2 pr-2 pb-2">
                        <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                            <img class="img-fluid cc-img"
                                src="http://www.prepbootstrap.com/Content/images/shared/misc/creditcardicons.png">
                        </ul>
                    </div>
                    <!-- Credit card form content -->
                    <div class="tab-content">
                        <!-- credit card info-->
                        <div id="credit-card" class="tab-pane fade show active pt-3">
                            <form action="<?php echo FRONT_ROOT ?>Ticket/validationCard" method="post">

                                <div class="form-group"> <label for="total">
                                        <h6 style="color:white">TOTAL</h6>
                                    </label>
                                    <input type="number" name="total" value="<?php echo $total ?>"
                                        class="form-control text-center">
                                </div>
                                <div class="form-group"> <label for="cardOwner">
                                        <h6 style="color:white">Card Owner</h6>
                                    </label> <input type="text" name="cardOwner" placeholder="Card Owner Name" required
                                        class="form-control text-center"> </div>
                                <div class="form-group"> <label for="cardNumber">
                                        <h6 style="color:white">Card number</h6>
                                    </label>
                                    <div class="input-group"> <input type="text" name="cardNumber"
                                            placeholder="Valid card number" class="form-control text-center" required>
                                        <div class="input-group-append"> <span class="input-group-text text-muted">
                                                <i class="fa fa-credit-card mx-1"></i> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group"> <label><span class="hidden-xs">
                                                    <h6 style="color:white">Expiration Date</h6>
                                                </span></label>
                                            <div class="input-group"> <input type="number" placeholder="MM"
                                                    name="expirationMM" class="form-control text-center" required>
                                                <input type="number" placeholder="YYYY" name="expirationYY"
                                                    class="form-control text-center" required> </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group mb-4"> <label data-toggle="tooltip" for="cvv"
                                                title="Three digit CV code on the back of your card">
                                                <h6 style="color:white">CVV <i
                                                        class="fa fa-question-circle d-inline"></i></h6>
                                            </label> <input type="text" name="cvv" required class="form-control text-center">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"> <button type="submit"
                                        class="subscribe btn btn-warning btn-block shadow-sm"> Confirm Payment
                                    </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>