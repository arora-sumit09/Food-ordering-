<?php
ob_start();
include("top.php");
$msg="";
$image="";
$heading="";
$sub_heading="";
$link="";
$link_txt="";
$ordernumber="";
$image_status=1;
$image_error="";
$id="";
if(isset($_GET['id']))
{
  $image_status=0;
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc(mysqli_query($conn,"Select * from banner where id='$id'"));
  $image=$row['image'];
  $heading=$row['heading'];
  $sub_heading=$row['sub_heading'];
  $link=$row['link'];
  $link_txt=$row['link_txt'];
  $ordernumber=$row['order_number'];
}
if(isset($_POST['submit']))
{
  $type=$_FILES['image']['type'];
  $heading=$_POST['heading'];
  $sub_heading=$_POST['sub_heading'];
  $link=$_POST['link'];
  $link_txt=$_POST['link_txt'];
  $ordernumber=$_POST['order_number'];
  $image_status=1;
  $image_error="";
  if($id=='')
  {
      if($type!='image/jpeg' && $type!='image/png')
        {
          $image_error="The image format is not jpeg/png";
        }
        else
        {
          $image=rand(111111,999999).'_'.$_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'],SERVER_DISH_IMAGE.$image);
          $added_on=date('Y-m-d');
          mysqli_query($conn,"insert into banner(image,heading,sub_heading,link,link_txt,added_on,status,order_number) values('$image','$heading','$sub_heading','$link','$link_txt','$added_on','1','$ordernumber')");
          header("Location:banner.php");
        }
  }
  else
  {
    if($_FILES['image']['name']!='')
      {
        if($type!='image/jpeg' && $type!='image/png')
        {
          $image_error="The image format is not jpeg/png";
        }
        else
        {
        $image=rand(111111,999999).'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],SERVER_DISH_IMAGE.$image);
        $image_condition=",image='$image'";
        $oldimage=mysqli_fetch_assoc(mysqli_query($conn,"select image from banner where id='$id'"));
        $oldimage2=$oldimage['image'];
        unlink(SERVER_DISH_IMAGE.$oldimage2);
        }
      }
       if($image_error=="")
       {
      mysqli_query($conn,"Update banner set heading='$heading',sub_heading='$sub_heading',link='$link',link_txt='$link_txt'".$image_condition." where id='$id'"); 
      header("Location:banner.php"); 
       }
  }
}
?>
<div class="row">
    <h1 class="card-title ml10">Manage Banner</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName1">Heading</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Heading Name"
                            name="heading" value="<?php echo $heading; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Sub Heading</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Sub Heading Name"
                            name="sub_heading" value="<?php echo $sub_heading; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Link</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Link" name="link"
                            value="<?php echo $link; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Link Text</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Link Text"
                            name="link_txt" value="<?php echo $link_txt; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Order Number</label>
                        <input type="number" class="form-control" id="exampleInputName1" placeholder="Order Number"
                            name="order_number" value="<?php echo $ordernumber; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Image</label>
                        <?php
                        if($image_status==1)
                        {
                        echo '<input type="file" class="form-control" id="exampleInputName1" placeholder="Upload Image"
                            name="image" required>';
                        }
                        else
                        {
                         echo '<input type="file" class="form-control" id="exampleInputName1" placeholder="Upload Image"
                            name="image">'; 
                        }
                        ?>
                        <?php
                        echo '<p class="my-2" style="color: red;">'.$image_error.'</p>';
                        ?>
                    </div>

                    <input type="submit" class="btn btn-primary mr-2" name="submit">

                </form>
            </div>
        </div>
    </div>
    <?php
include("bottom.php");
?>