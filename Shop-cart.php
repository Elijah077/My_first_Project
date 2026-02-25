<?php include "header.php";?>
 

<div class="inner-banner has-base-color-overlay text-center" style="background: url(images/background/4.jpg);">
    <div class="container">
        <div class="box">
            <h1>Shopping cart</h1>
        </div>
    </div>
</div>
<div class="breadcumb-wrapper">
    <div class="container">
        <div class="pull-left">
            <ul class="list-inline link-list">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="shop-single.php">shop-single</a>
                </li>

                <li>
                    shopping cart
                </li>
            </ul>
        </div>
        <div class="pull-right">
            <a href="#" class="get-qoute"><i class="fa fa-arrow-circle-right"></i>Become a Volunteer</a>
        </div>
    </div>
</div>

<section class="cart-section sec-padd-top">
<div class="container">
    
    <!-- Cart Outer -->
    <div class="cart-outer">

        <!-- Cart Table -->
        <div class="table-outer">
            <table class="cart-table">
                <thead class="cart-header">
                    <tr>
                        <th class="prod-column">Product</th>
                        <th>&nbsp;</th>
                        <th>Quantity</th>
                        <th>Availability</th>
                        <th class="price">Price</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td colspan="2" class="prod-column">
                            <div class="column-box">
                                <figure class="prod-thumb"><a href="#"><img src="images/mlo-wa-watoto/School_Supplies .png" alt="School Supplies Kit"></a></figure>
                                <h3 class="prod-title padd-top-20">School Supplies Kit</h3>
                            </div>
                        </td>
                        <td class="qty">
                            <input class="quantity-spinner" type="number" value="1" min="1" name="quantity">
                        </td>
                        <td class="unit-price">
                            <div class="available-info">
                                <span class="icon fa fa-check"></span> Available for Donation
                            </div>
                        </td>
                        <td class="price">$44.99</td>
                        <td class="sub-total">$44.99</td>
                        <td class="remove">
                            <a href="#" class="remove-btn"><span class="icon-multiply"></span></a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" class="prod-column">
                            <div class="column-box">
                                <figure class="prod-thumb"><a href="#"><img src="images/mlo-wa-watoto/Story_Book.png" alt="Children’s Story Book"></a></figure>
                                <h3 class="prod-title padd-top-20">Children’s Story Book</h3>
                            </div>
                        </td>
                        <td class="qty">
                            <input class="quantity-spinner" type="number" value="2" min="1" name="quantity">
                        </td>
                        <td class="unit-price">
                            <div class="available-info">
                                <span class="icon fa fa-check"></span> Available for Donation
                            </div>
                        </td>
                        <td class="price">$24.00</td>
                        <td class="sub-total">$48.00</td>
                        <td class="remove">
                            <a href="#" class="remove-btn"><span class="icon-multiply"></span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>            

        <!-- Coupon & Update Cart -->
        <div class="update-cart-box clearfix">
            <div class="pull-left">
                <div class="apply-coupon clearfix">
                    <div class="form-group clearfix">
                        <input type="text" name="coupon-code" placeholder="Enter Donation Code...">
                    </div>
                    <div class="form-group clearfix">
                        <button type="button" class="thm-btn">Apply Code</button>
                    </div>
                </div>
            </div>
            
            <div class="pull-right">
                <button type="button" class="thm-btn update-cart">Update Cart</button>
            </div>
        </div>

        <!-- Shipping & Cart Totals -->
        <div class="row clearfix sec-pad">

            <!-- Shipping Calculator -->
            <div class="column col-md-6 col-sm-12 col-xs-12">
                <div class="estimate-form">
                    <div class="section-title2">        
                        <h3>Check Delivery to Your Area</h3>
                    </div>
                    <form method="post" action="#" class="default-form">
                        <div class="row clearfix">

                            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                <div class="select-box">
                                    <select class="text-capitalize selectpicker form-control required" name="country" data-style="g-select" data-width="100%">
                                        <option value="uganda" selected>Uganda</option>
                                        <option value="kenya">Kenya</option>
                                        <option value="tanzania">Tanzania</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <div class="select-box">
                                    <select class="text-capitalize selectpicker form-control required" name="state" data-style="g-select" data-width="100%">
                                        <option value="" selected>Select Region</option>
                                        <option>Kampala</option>
                                        <option>Jinja</option>
                                        <option>Mbarara</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="zip" placeholder="Enter Pincode">
                            </div>

                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <button type="submit" class="thm-btn">Check Delivery</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Cart Totals -->
            <div class="column cart-total col-md-6 col-sm-12 col-xs-12">
                <div class="section-title2">        
                    <h3>Donation Summary</h3>
                </div>                    
                <ul class="totals-table">
                    <li class="clearfix"><span class="col col-title">Subtotal of Donations</span><span class="col">$92.99</span></li>
                    <li class="clearfix"><span class="col col-title">Shipping / Delivery</span><span class="col">Free Delivery</span></li>
                    <li class="clearfix"><span class="col col-title">Total Contribution</span><span class="col">$92.99</span></li>
                </ul>
                
                <div class="margin-top-30 text-right">
                    <a href="checkout-2.html" class="thm-btn inverse">Proceed to Contribute</a>
                </div>
            </div>

        </div>

    </div>
</div>
</section>

<?php include "footer.php";?>