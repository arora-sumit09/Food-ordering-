<?php
session_start();
include("../dbconnect.php");
include("../constant.php");
  $dish_id=$_POST['dish_id'];
  $qty=$_POST['qty'];
  $dish_attr_id=$_POST['dish_attr_id'];
  $added_on=date('Y-m-d');
  $totalprice=0;
    if(isset($_SESSION['id']) && !isset($_SESSION['cart']))
    { 
        $user_id=$_SESSION['id'];
        $num=mysqli_num_rows(mysqli_query($conn,"Select * from dish_cart where user_id='$user_id' and dish_id='$dish_id'"));
        if($num==0)
        {
        $sql=mysqli_query($conn,"Insert into dish_cart(user_id,dish_id,dish_attr_id,qty,added_on) values('$user_id','$dish_id','$dish_attr_id','$qty','$added_on')");
        }
        else
        {
         mysqli_query($conn,"Update dish_cart set qty='$qty',dish_attr_id='$dish_attr_id' where user_id='$user_id' and dish_id='$dish_id'");
        }
        $res=mysqli_query($conn,"select * from dish_cart where user_id='$user_id'");
        $num2=mysqli_num_rows($res);
        while($row=mysqli_fetch_assoc($res))
        {
            $dishattrid=$row['dish_attr_id'];
            $qty=$row['qty'];
            $price=mysqli_fetch_assoc(mysqli_query($conn,"select price from dish_details where id='$dishattrid'"));
            $totalprice+=($qty*$price['price']);
        }
        $res2=mysqli_query($conn,"select * from dish where id='$dish_id'");
        $row2=mysqli_fetch_assoc($res2);
        $res3=mysqli_query($conn,"select * from dish_details where id='$dish_attr_id'");
        $row3=mysqli_fetch_assoc($res3);
        $image=$row2['image'];
        $dishname=$row2['dish'];
        $priceqty=$qty*$row3['price'];
        $attrname=$row3['attribute'];
        $arr2=array('totalCartDish'=>$num2,'price'=>$totalprice,'image'=>$image,'priceqty'=>$priceqty,'attrname'=>$attrname,'dishname'=>$dishname);
        echo json_encode($arr2);
    }
    else
    {
      $arr=array("qty"=>$qty,"dish_attr_id"=>$dish_attr_id);
      $_SESSION['cart'][$dish_id]['dish_attr']=$arr;
      foreach($_SESSION['cart'] as $key => $val)
      {
        $qty=$val['dish_attr']['qty'];
        $dishattrid=$val['dish_attr']['dish_attr_id']; 
        $price=mysqli_fetch_assoc(mysqli_query($conn,"select price from dish_details where id='$dishattrid'"));
        $totalprice+=($qty*$price['price']); 
      }
        $res2=mysqli_query($conn,"select * from dish where id='$dish_id'");
        $row2=mysqli_fetch_assoc($res2);
        $res3=mysqli_query($conn,"select * from dish_details where id='$dish_attr_id'");
        $row3=mysqli_fetch_assoc($res3);
        $image=$row2['image'];
        $dishname=$row2['dish'];
        $priceqty=$qty*$row3['price'];
        $attrname=$row3['attribute'];
        $arr2=array('totalCartDish'=>count($_SESSION['cart']),'price'=>$totalprice,'image'=>$image,'priceqty'=>$priceqty,'attrname'=>$attrname,'dishname'=>$dishname);
        echo json_encode($arr2);
    }
?>