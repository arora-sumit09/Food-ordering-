<?php
ob_start();
include("top.php");
$msg="";
$coupon_code="";
$coupon_type="";
$coupon_value="";
$cart_min_value="";
$expired_on="";
$added_on="";
$id="";
if(isset($_GET['id']))
{
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc(mysqli_query($conn,"Select * from coupon_code where id='$id'"));
  $coupon_code=$row['coupon_code'];
  $coupon_type=$row['coupon_type'];
  $coupon_value=$row['coupon_value'];
  $cart_min_value=$row['cart_min_value'];
  $expired_on=$row['expired_on'];
  $added_on=$row['added_on'];
}
if(isset($_POST['submit']))
{
  $coupon_code=$_POST['coupon_code'];
  $coupon_type=$_POST['coupon_type'];
  $coupon_value=$_POST['coupon_value'];
  $cart_min_value=$_POST['cart_min_value'];
  $expired_on=$_POST['expired_on'];
  if($id=='')
  {
  $result=mysqli_query($conn,"Select * from coupon_code where coupon_code='$coupon_code'");
  $num=mysqli_num_rows($result);
      if($num!=1)
      {
      $added_on=date('Y-m-d');
      mysqli_query($conn,"insert into coupon_code(coupon_code,coupon_type,coupon_value,cart_min_value,status,added_on,expired_on) values('$coupon_code','$coupon_type','$coupon_value','$cart_min_value',1,'$added_on','$expired_on')");
      header("Location:coupon_code.php");
      }
      else
      {
        $msg="Coupon Code already Exists";
      }  
  }
  else
  {
  $result=mysqli_query($conn,"Select * from coupon_code where coupon_code='$coupon_code' and id!='$id'");
  $num=mysqli_num_rows($result);
    if($num!=1)
    {
      mysqli_query($conn,"Update coupon_code set coupon_code='$coupon_code',coupon_type='$coupon_type',coupon_value='$coupon_value',cart_min_value='$cart_min_value',expired_on='$expired_on' where id='$id'"); 
      header("Location:coupon_code.php");
    }
    else
    {
      $msg="Coupon Code already Exists";
    }    
  }
}
?>
<div class="row">
    <h1 class="card-title ml10">Manage Coupon Code</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="exampleInputName1">Coupon Code</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Code"
                            name="coupon_code" value="<?php echo $coupon_code; ?>" required>
                        <?php
                        echo '<p class="my-2" style="color: red;">'.$msg.'</p>';
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Coupon Type</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Type"
                            name="coupon_type" value="<?php echo $coupon_type; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Coupon Value</label>
                        <input type="number" class="form-control" id="exampleInputName1" placeholder="Value"
                            name="coupon_value" value="<?php echo $coupon_value; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Cart Min Value</label>
                        <input type="number" class="form-control" id="exampleInputName1" placeholder=" Min Value"
                            name="cart_min_value" value="<?php echo $cart_min_value; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Expiry Date</label>
                        <input type="date" class="form-control" id="exampleInputName1" placeholder="Date"
                            name="expired_on" value="<?php echo $expired_on; ?>" required>
                    </div>
                    <input type="submit" class="btn btn-primary mr-2" name="submit">
                </form>
            </div>
        </div>
    </div>
    <?php
include("bottom.php");
?>