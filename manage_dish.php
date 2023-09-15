<?php
ob_start();
include("top.php");
$msg="";
$category_id="";
$dish="";
$dish_detail="";
$image="";
$type2="";
$image_status=1;
$image_error="";
$id="";

if(isset($_GET['id']))
{
  $image_status=0;
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc(mysqli_query($conn,"Select * from dish where id='$id'"));
  $category_id=$row['category_id'];
  $dish=$row['dish'];
  $type2=$row['type'];
  $dish_detail=$row['dish_detail'];
  $image=$row['image'];
}
if(isset($_GET['dishid']))
{
  echo $id;
  $dn=$_GET['dishid'];
  mysqli_query($conn,"Delete from dish_details where id='$dn'");
  header('Location:manage_dish.php?id='.$id);  
} 
if(isset($_POST['submit']))
{
  $category_id=$_POST['category_id'];
  $dish=$_POST['dish'];
  $type2=$_POST['type'];
  $dish_detail=$_POST['dish_detail'];
  $type=$_FILES['image']['type'];
  if($id=='')
  {
  $result=mysqli_query($conn,"Select * from dish where dish='$dish'");
  $num=mysqli_num_rows($result);
      if($num!=1)
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
          mysqli_query($conn,"insert into dish(category_id,dish,dish_detail,image,added_on,status,type) values('$category_id','$dish','$dish_detail','$image','$added_on','1','$type2')");
          $did=mysqli_insert_id($conn);
          $attributeArr=$_POST['attribute'];
          $priceArr=$_POST['price'];
          foreach($attributeArr as $key=>$val)
          {
            $attribute=$val;
            $price=$priceArr[$key];
            mysqli_query($conn,"insert into dish_details(dish_id,attribute,price,status,added_on) values ('$did','$attribute','$price','1','$added_on')");
          }
          header("Location:dish.php");
        }
      }
      else
      {
        $msg="Dish already Exists";
      }  
  }
  else
  {
  $result=mysqli_query($conn,"Select * from dish where dish='$dish' and id!='$id'");
  $num=mysqli_num_rows($result);
    if($num!=1)
    {
      $image_condition='';
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

        $oldimage=mysqli_fetch_assoc(mysqli_query($conn,"select image from dish where id='$id'"));
        $oldimage2=$oldimage['image'];
        unlink(SERVER_DISH_IMAGE.$oldimage2);
        }
      }
      if($image_error=="")
      {
        mysqli_query($conn,"Update dish set type='$type2',category_id='$category_id',dish='$dish',dish_detail='$dish_detail'".$image_condition." where id='$id'"); 
        $row4=mysqli_fetch_assoc(mysqli_query($conn,"Select * from dish where dish='$dish'"));
        $did=$row4['id'];
        $added_on=date('Y-m-d');
        $attributeArr=$_POST['attribute'];
        $priceArr=$_POST['price'];
        $attributeArr2=$_POST['attribute2'];
        $priceArr2=$_POST['price2'];
          foreach($attributeArr as $key=>$val)
          {
            $attribute=$val;
            $price=$priceArr[$key];
            mysqli_query($conn,"insert into dish_details(dish_id,attribute,price,status,added_on) values ('$did','$attribute','$price','1','$added_on')");
          }
          // foreach($attributeArr2 as $key=>$val)
          // {
          //   $attribute=$val;
          //   $price=$priceArr2[$key];
          //   mysqli_query($conn,"update dish_details set attribute='$attribute',price='$price' where id");
          // }
        header("Location:dish.php");
      }
    }
    else
    {
      $msg="Dish already Exists";
    }    
  }
}
$res3=mysqli_query($conn,"Select * from category where status='1' order by category asc");
$arrtype=array("veg","nonveg");
?>
<div class="row">
    <h1 class="card-title ml10">Manage Dish</h1>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName1">Dish</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Dish Name"
                            name="dish" value="<?php echo $dish; ?>" required>
                    </div>
                    <?php
                        echo '<p class="my-2" style="color: red;">'.$msg.'</p>';
                        ?>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Category</label>
                        <select class="form-control" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php
                            while($row2=mysqli_fetch_assoc($res3))
                            {
                              if($row2['id']==$category_id)
                              {
                               echo '<option value="'.$row2["id"].'"selected>'.$row2["category"].'</option>';
                              }
                              else
                              {
                               echo '<option value="'.$row2["id"].'">'.$row2["category"].'</option>';
                              }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Type</label>
                        <select class="form-control" name="type" required>
                            <option value="">Select Type</option>
                            <?php
                            foreach($arrtype as $list)
                            {
                              if($list == $type2)
                              {
                               echo '<option value="'.$list.'"selected>'.$list.'</option>'; 
                              }
                              else
                              {
                               echo '<option value="'.$list.'">'.$list.'</option>';  
                              }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName1">Dish Detail</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Dish Detail"
                            name="dish_detail" value="<?php echo $dish_detail; ?>" required>
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
                    <div id="add" class="form-group">
                        <label for="exampleInputName1">Dish Detail</label>
                        <?php
                        if($id=='')
                        {
                         echo'<div class="row">
                            <div class="col-5">
                                <input type="text" class="form-control" id="exampleInputName1"
                                    placeholder="Attribute Name" name="attribute[]" required>
                            </div>
                            <div class="col-5">
                                <input type="number" class="form-control" id="exampleInputName1"
                                    placeholder="Price of the Attribute" name="price[]" required>
                            </div>
                        </div>';
                        }
                        else
                        {
                          $result=mysqli_query($conn,"Select * from dish_details where dish_id='$id'");
                          $i=0;
                          while($row3=mysqli_fetch_assoc($result))
                          {
                            $i++;
                          echo'<div class="row my-4">
                            <div class="col-5">
                                <input type="text" class="form-control" id="exampleInputName1"
                                    placeholder="Attribute Name" name="attribute2[]" value="'.$row3['attribute'].'" required>
                            </div>
                            <div class="col-5">
                                <input type="number" class="form-control" id="exampleInputName1"
                                    placeholder="Price of the Attribute" name="price2[]" value="'.$row3['price'].'" required>
                            </div>';
                             if($i!=1)
                             {
                               echo'<div class="col-2">
                        <button type="reset" class="btn btn-danger" onclick="deletemorenew('.$row3['id'].')">Delete</button>
                        </div></div>';
                             }
                             else
                             {
                               echo '</div>';
                             }
                          }
                        }
                        ?>
                    </div>
                    <button type="button" class="btn btn-primary mr-2" onclick="addmore()">Add More</button>
                    <input type="submit" class="btn btn-primary mr-2" name="submit">
                </form>
            </div>
        </div>
    </div>
    <script>
    var number = 0;

    function addmore() {
        number++;
        let addi = document.getElementById("add").innerHTML;
        if (number == 1) {
            addi += `<div class="row my-3" id=${number}>
                        <div class="form-group col-5">
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Attribute Name" name="attribute[]">
                        </div>
                        <div class="form-group col-5">
                            <input type="number" class="form-control" id="exampleInputName1"
                                placeholder="Price of the Attribute" name="price[]">
                        </div>
                        <div class="col-2">
                        <button type="button" class="btn btn-danger" onclick="deletemore(${number})">Delete</button>
                        </div>
                    </div>`;
        } else {
            addi += `<div class="row" id=${number}>
                        <div class="form-group col-5">
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Attribute Name" name="attribute[]">
                        </div>
                        <div class="form-group col-5">
                            <input type="number" class="form-control" id="exampleInputName1"
                                placeholder="Price of the Attribute" name="price[]">
                        </div>
                        <div class="col-2">
                        <button type="button" class="btn btn-danger" onclick="deletemore(${number})">Delete</button>
                        </div>
                    </div>`;
        }
        let addi2 = document.getElementById("add");
        addi2.innerHTML = addi;
    }

    function deletemore(index) {
        let delete2 = document.getElementById(index);
        delete2.remove();
    }

    function deletemorenew(index) {
        var result = confirm("Are you sure about deleting this?");
        if (result == true) {
            var cur = window.location.href;
            cur = cur + "&dishid=" + index;
            window.location = cur;
        }
    }
    </script>
    <?php
include("bottom.php");
?>