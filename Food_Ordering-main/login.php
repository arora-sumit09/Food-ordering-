<?php
include("dbconnect.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Food Ordering Admin Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<?php
  $msg="";
if(isset($_POST['submit']))
{
  $email=$_POST['email'];
  $password=$_POST['password'];

  $sql="Select * from admin where email='$email' and password='$password'";
  $result=mysqli_query($conn,$sql);
  $num=mysqli_num_rows($result);
  
  if($num===1)
  {
     $row=mysqli_fetch_assoc($result);
    $_SESSION['islogin']='yes';
    $_SESSION['user']=$row['name'];
    header("Location: index.php");
    die();
  }
  else
  {
    $msg="The username and the password does not match.";
  }
}
?>

<body class="sidebar-light">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo text-center">
                                <img src="assets/images/logo.png" alt="logo">
                            </div>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" method="post" action="login.php">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1"
                                        placeholder="Username" name="email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" placeholder="Password" name="password" required>
                                </div>
                                <div class="mt-3">
                                    <input type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        value="Sign In" name="submit">
                                </div>
                                <?php
                                  echo '<p class="my-2" style="color: red;text-align: center;">'.$msg;
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- plugins:js -->
    <script src="assets/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/js/Chart.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page-->
</body>

</html>