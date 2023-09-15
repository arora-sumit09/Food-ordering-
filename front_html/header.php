<?php
session_start();
include("../constant.php");
include("../dbconnect.php");
$num=0;
$totalprice=0;
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Billy - Food & Drink eCommerce Bootstrap4 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/chosen.min.css">
    <link rel="stylesheet" href="assets/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- header start -->
    <header class="header-area">
        <div class="header-top black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12 col-sm-4">
                        <div class="welcome-area">
                            <p>Default welcome msg! </p>
                        </div>
                    </div>
                    <?php
                    if(isset($_SESSION['id']) && isset($_SESSION['name'])){
                    echo'
                    <div class="col-lg-8 col-md-8 col-12 col-sm-8">
                        <div class="account-curr-lang-wrap f-right">
                            <ul>
                                <li class="top-hover"><a href="#">Setting <i class="ion-chevron-down"></i></a>
                                    <ul>
                                        <li><a href="wishlist.html">Profile </a></li>
                                        <li><a href="login-register.html">Order History</a></li>
                                        <li><a href="logout.php">Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>';}
                    ?>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                        <div class="logo">
                            <a href="index.html">
                                <img alt="" src="assets/img/logo/logo.png">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                        <div class="header-middle-right f-right">
                            <div class="header-login">
                                <?php
                                if(!isset($_SESSION['id']) && !isset($_SESSION['name']))
                                {echo '
                                <div class="header-icon-style">
                                    <i class="icon-user icons"></i>
                                </div>
                                <div class="login-text-content">
                                    <a href="register.php">
                                        <p>Register
                                    </a><br> or <a href="login.php"><span>Sign in</a></span></p>
                                </div>';}
                                else
                                {
                                  echo '
                                <div class="header-icon-style">
                                    <i class="icon-user icons"></i>
                                </div>
                                <div class="login-text-content">
                                        <p>Welcome'.$_SESSION['name'].'</p>
                                </div>';  
                                }
                                ?>
                            </div>
                            <div class="header-wishlist">
                                &nbsp;
                            </div>
                            <div class="header-cart">
                                <a href="#">
                                    <div class="header-icon-style">
                                        <i class="icon-handbag icons"></i>
                                        <?php
                                        if(isset($_SESSION['id']))
                                        {
                                            $id=$_SESSION['id'];
                                            $res=mysqli_query($conn,"select * from dish_cart where user_id='$id'");
                                            $num=mysqli_num_rows($res);
                                            while($row=mysqli_fetch_assoc($res))
                                            {
                                                $dishattrid=$row['dish_attr_id'];
                                                $qty=$row['qty'];
                                                $price=mysqli_fetch_assoc(mysqli_query($conn,"select price from dish_details where id='$dishattrid'"));
                                                $totalprice+=($qty*$price['price']);
                                            }
                                        }
                                        else if (isset($_SESSION['cart']))
                                        {
                                          $num=count($_SESSION['cart']);
                                          foreach($_SESSION['cart'] as $key => $val)
                                          {
                                            $qty=$val['dish_attr']['qty'];
                                            $dishattrid=$val['dish_attr']['dish_attr_id']; 
                                            $price=mysqli_fetch_assoc(mysqli_query($conn,"select price from dish_details where id='$dishattrid'"));
                                            $totalprice+=($qty*$price['price']); 
                                          }
                                        }
                                        ?>
                                        <span class="count-style" id="cart_num"><?php echo $num; ?></span>
                                    </div>
                                    <div class="cart-text">
                                        <span class="digit">My Cart</span>
                                        <span class="cart-digit-bold" id="price2">Rs. <?php echo $totalprice; ?></span>
                                    </div>
                                    <div class="shopping-cart-content" id="cartmenu">
                                        <?php
                                    if($totalprice!=0){
                                    ?>
                                        <ul>
                                            <?php
                                             if(isset($_SESSION['id'])){
                                              $id=$_SESSION['id'];
                                              $res=mysqli_query($conn,"select * from dish_cart where user_id='$id'");
                                              while($row=mysqli_fetch_assoc($res))
                                              {
                                                $dish_id=$row['dish_id'];
                                                $dish_attr_id=$row['dish_attr_id'];
                                                $res2=mysqli_query($conn,"select * from dish where id='$dish_id'");
                                                $row2=mysqli_fetch_assoc($res2);
                                                $res3=mysqli_query($conn,"select * from dish_details where id='$dish_attr_id'");
                                                $row3=mysqli_fetch_assoc($res3); 
                                                $price=$row['qty']*$row3['price'];  
                                                echo'<li class="single-shopping-cart">
                                                <div class="shopping-cart-img">
                                                    <a href="#"><img alt="" style="width:100%;"src="'.SITE_DISH_IMAGE.$row2['image'].'"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="#">'.$row2['dish'].' ('.$row3['attribute'].')</a></h4>
                                                    <h6>Qty: '.$row['qty'].'</h6>
                                                    <span>Rs. '.$price.'</span>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="ion ion-close"></i></a>
                                                </div>
                                                </li>';}
                                           }
                                           else
                                           {
                                              foreach($_SESSION['cart'] as $key => $val)
                                              {
                                                $dish_id=$key;
                                                $qty=$val['dish_attr']['qty'];
                                                $dish_attr_id=$val['dish_attr']['dish_attr_id']; 
                                                $res2=mysqli_query($conn,"select * from dish where id='$dish_id'");
                                                $row2=mysqli_fetch_assoc($res2);
                                                $res3=mysqli_query($conn,"select * from dish_details where id='$dish_attr_id'");
                                                $row3=mysqli_fetch_assoc($res3); 
                                                $price=$qty*$row3['price'];  
                                                echo'<li class="single-shopping-cart">
                                                <div class="shopping-cart-img">
                                                    <a href="#"><img alt="" style="width:100%;"src="'.SITE_DISH_IMAGE.$row2['image'].'"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="#">'.$row2['dish'].' ('.$row3['attribute'].')</a></h4>
                                                    <h6>Qty: '.$qty.'</h6>
                                                    <span>Rs. '.$price.'</span>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="ion ion-close"></i></a>
                                                </div>
                                                </li>';}  
                                              }  
                                            ?>
                                        </ul>
                                        <div class="shopping-cart-total">
                                            <h4>Shipping : <span>$20.00</span></h4>
                                            <h4>Total : <span class="shop-total">Rs. <?php echo $totalprice; ?></span>
                                            </h4>
                                        </div>
                                        <div class="shopping-cart-btn">
                                            <a href="cart.php">view cart</a>
                                            <a href="checkout.php">checkout</a>
                                        </div>
                                        <?php } ?>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom transparent-bar black-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="main-menu">
                                <nav>
                                    <ul>
                                        <li><a href="shop.php">Shop</a></li>
                                        <li><a href="about-us.php">About Us</a></li>
                                        <li><a href="contact.php">Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area-start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mobile-menu">
                                <nav id="mobile-menu-active">
                                    <ul class="menu-overflow" id="nav">
                                        <li><a href="index.html">Home</a></li>
                                        <li><a href="index.html">Home</a></li>
                                        <li><a href="index.html">Home</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area-end -->
    </header>