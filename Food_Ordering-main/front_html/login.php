<?php
ob_start();
include("header.php");
$msg=""
?>
<?php
if(isset($_POST['submit']))
{
    $email=$_POST['user-email'];
    $password=$_POST['user-password'];
    $result=mysqli_query($conn,"select * from user where email='$email' and password='$password'");
    $check=mysqli_num_rows($result);
    if($check!=1)
    {
      $msg="Email Id and password does not match";
    }
    else{
        $row=mysqli_fetch_assoc($result);
        $_SESSION['id']=$row['id'];
        $_SESSION['name']=$row['name'];
        header("Location:shop.php");
    }
}
if(isset($_SESSION['id']) && isset($_SESSION['cart']))
    {
      foreach($_SESSION['cart'] as $key => $val)
      {
        $user_id=$_SESSION['id'];
        $added_on=date('Y-m-d');
        $dish_id=$key;
        $qty=$val['dish_attr']['qty'];
        $dish_attr_id=$val['dish_attr']['dish_attr_id'];
        $num=mysqli_num_rows(mysqli_query($conn,"Select * from dish_cart where user_id='$user_id' and dish_id='$dish_id'"));
        if($num==0)
        {
        $sql=mysqli_query($conn,"Insert into dish_cart(user_id,dish_id,dish_attr_id,qty,added_on) values('$user_id','$dish_id','$dish_attr_id','$qty','$added_on')");
        }
        else
        {
         mysqli_query($conn,"Update dish_cart set qty='$qty',dish_attr_id='$dish_attr_id' where user_id='$user_id' and dish_id='$dish_id'");
        }
      }
      unset($_SESSION['cart']);
    }
?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a data-toggle="tab" href="#lg1">
                            <h4> login </h4>
                        </a>
                    </div>
                    <p style="color:red;text-align:center;">
                        <?php echo $msg;?></p>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="login.php" method="post">
                                        <input type="email" name="user-email" placeholder="Email">
                                        <input type="password" name="user-password" placeholder="Password">
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox">
                                                <label>Remember me</label>
                                                <a href="#">Forgot Password?</a>
                                            </div>
                                            <button type="submit" name="submit"><span>Login</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php")
 ?>