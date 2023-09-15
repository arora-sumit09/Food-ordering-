<?php
include("../dbconnect.php");
include("../constant.php");
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Food Ordering Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <div class="slider-area">
        <div class="slider-active owl-dot-style owl-carousel">
            <?php
              $sql=mysqli_query($conn,"select * from banner where status=1 order by order_number");
              while($row=mysqli_fetch_assoc($sql))
              {
              echo'
                    <div class="single-slider pt-210 pb-220 bg-img"
                        style="background-image:url('.SITE_DISH_IMAGE.$row['image'].');">
                        <div class="container">
                            <div class="slider-content slider-animated-1">
                                <h1 class="animated">'.$row['heading'].'</h1>
                                <h3 class="animated">'.$row['sub_heading'].'</h3>
                                <div class="slider-btn mt-90">
                                    <a class="animated" href="'.$row['link'].'">'.$row['link_txt'].'</a>
                                </div>
                            </div>
                        </div>
                    </div>';
              }
            ?>
        </div>
    </div>
    <script src="assets/js/vendor/jquery-1.12.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>