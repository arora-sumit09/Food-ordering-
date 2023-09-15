<?php
ob_start();
include("top.php");
$msg="";
$category="";
$ordernumber="";
$id="";
if(isset($_GET['id']))
{
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc(mysqli_query($conn,"Select * from category where id='$id'"));
  $category=$row['category'];
  $ordernumber=$row['order_number'];
}
if(isset($_POST['submit']))
{
  $category=$_POST['category'];
  $ordernumber=$_POST['order_number'];
  if($id=='')
  {
  $result=mysqli_query($conn,"Select * from category where category='$category'");
  $num=mysqli_num_rows($result);
      if($num!=1)
      {
      $added_on=date('Y-m-d');
      mysqli_query($conn,"insert into category(category,order_number,status,added_on) values('$category','$ordernumber',1,'$added_on')");
      header("Location:category.php");
      }
      else
      {
        $msg="Category already Exist";
      }  
  }
  else
  {
  $result=mysqli_query($conn,"Select * from category where category='$category' and id!='$id'");
  $num=mysqli_num_rows($result);
    if($num!=1)
    {
      mysqli_query($conn,"Update category set category='$category',order_number='$ordernumber' where id='$id'"); 
      header("Location:category.php");
    }
    else
    {
      $msg="Category already Exist";
    }    
  }


}

?>
<div class="row">
    <h1 class="card-title ml10">Manage Category</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post">
                    <div class="form-group">
                        <label for="exampleInputName1">Category Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name"
                            name="category" value="<?php echo $category; ?>" required>
                        <?php
                        echo '<p class="my-2" style="color: red;">'.$msg.'</p>';
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Order Number</label>
                        <input type="text" class="form-control" id="exampleInputNumber3" placeholder="Number"
                            name="order_number" value="<?php echo $ordernumber; ?>" required>
                    </div>

                    <input type="submit" class="btn btn-primary mr-2" name="submit">

                </form>
            </div>
        </div>
    </div>
    <?php
include("bottom.php");
?>