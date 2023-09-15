<?php
include("header.php");
$msg="";
$msg2="";
?>
<?php
if(isset($_POST['submitregister']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $mobile=$_POST['mobile'];
    $check=mysqli_num_rows(mysqli_query($conn,"select * from user where email='$email'"));
    $check2=mysqli_num_rows(mysqli_query($conn,"select * from user where mobile='$mobile'"));
    if($check>0)
    {
      $msg="Email id already exists!";
    }
    if($check2>0)
    {
      $msg="Mobile Number already exists!";
    }
    else
    {
        $added_on=date('Y-m-d');
        mysqli_query($conn,"Insert into user (name,email,mobile,password,added_on,status) values ('$name','$email','$mobile','$password','$added_on',1)");
        $msg2="Your account has been created. You can login now!";
    }
}
?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a data-toggle="tab" href="#lg2">
                            <h4> Register </h4>
                        </a>
                    </div>
                    <p style="color:red;text-align:center;">
                        <?php
                             echo $msg;
                            ?></p>
                    <p style="color:green;text-align:center;">
                        <?php
                             echo $msg2;
                            ?></p <div class="tab-content">
                    <div id="lg2" class="tab-pane active">
                        <div class="login-form-container">
                            <div class="login-register-form">
                                <form action="register.php" method="post">
                                    <input type="text" name="name" placeholder="Name">
                                    <input name="email" placeholder="Email" type="email">
                                    <input type="password" name="password" placeholder="Password">
                                    <input name="mobile" placeholder="Mobile Number" type="number">
                                    <div class="button-box">
                                        <button type="submit" name="submitregister"><span>Register</span></button>
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