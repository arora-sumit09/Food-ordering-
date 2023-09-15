<?php
ob_start();
include("top.php");
$msg="";
$name="";
$mobile="";
$password="";
$id="";
if(isset($_GET['id']))
{
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc(mysqli_query($conn,"Select * from delivery_boy where id='$id'"));
  $name=$row['name'];
  $mobile=$row['mobile'];
  $password=$row['password'];
}
if(isset($_POST['submit']))
{
  $name=$_POST['name'];
  $mobile=$_POST['mobile'];
  $password=$_POST['password'];
  if($id=='')
  {
  $result=mysqli_query($conn,"Select * from delivery_boy where mobile='$mobile'");
  $num=mysqli_num_rows($result);
      if($num!=1)
      {
      $added_on=date('Y-m-d');
      mysqli_query($conn,"insert into delivery_boy(name,mobile,status,added_on,password) values('$name','$mobile',1,'$added_on','$password')");
      header("Location:delivery_boy.php");
      }
      else
      {
        $msg="Mobile Number already Exists";
      }  
  }
  else
  {
  $result=mysqli_query($conn,"Select * from delivery_boy where mobile='$mobile' and id!='$id'");
  $num=mysqli_num_rows($result);
    if($num!=1)
    {
      mysqli_query($conn,"Update delivery_boy set name='$name',password='$password',mobile='$mobile' where id='$id'"); 
      header("Location:delivery_boy.php");
    }
    else
    {
      $msg="Mobile Number already Exists";
    }    
  }
}
?>
<div class="row">
    <h1 class="card-title ml10">Manage Delivery Boy</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="exampleInputName1">Delivery Boy Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name"
                            value="<?php echo $name; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Mobile Number</label>
                        <input type="number" class="form-control" id="exampleInputNumber3" placeholder="Number"
                            name="mobile" value="<?php echo $mobile; ?>" required>
                        <?php
                        echo '<p class="my-2" style="color: red;">'.$msg.'</p>';
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Password</label>
                        <input type="text" class="form-control" id="exampleInputNumber3" placeholder="Number"
                            name="password" value="<?php echo $password; ?>" required>
                    </div>
                    <input type="submit" class="btn btn-primary mr-2" name="submit">
                </form>
            </div>
        </div>
    </div>
    <?php
include("bottom.php");
?>