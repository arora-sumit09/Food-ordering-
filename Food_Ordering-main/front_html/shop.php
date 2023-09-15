<?php
include("header.php");
$type3="";
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="shop.php">Shop</a></li>
            </ul>
        </div>
    </div>
</div>
<?php

if(isset($_GET['cat_id']) && isset($_GET['type']))
{
  $catid=$_GET['cat_id'];
  $type3=$_GET['type'];
  if($type3!="both"){
  $sql2=mysqli_query($conn,"select * from dish where status=1 and category_id='$catid' and type='$type3' order by dish desc"); 
  $num=mysqli_num_rows($sql2);}
  else
  {
   $sql2=mysqli_query($conn,"select * from dish where status=1 and category_id='$catid' order by dish desc"); 
  $num=mysqli_num_rows($sql2);   
  }
}
else if(isset($_GET['cat_id']))
{
   $catid=$_GET['cat_id']; 
   $sql2=mysqli_query($conn,"select * from dish where status=1 and category_id='$catid' order by dish desc"); 
   $num=mysqli_num_rows($sql2);
}
else
{
if(isset($_GET['type']))
 {
    $type3=$_GET['type'];
    if($type3!="both")
    {
    $sql2=mysqli_query($conn,"select * from dish where type='$type3' order by dish desc");
    $num=mysqli_num_rows($sql2);
    }
    else{
      $sql2=mysqli_query($conn,"select * from dish where status=1 order by dish desc");
    $num=mysqli_num_rows($sql2);  
    }
 }
 else{
    $sql2=mysqli_query($conn,"select * from dish where status=1 order by dish desc");
    $num=mysqli_num_rows($sql2);
 }
}
?>
<div class="shop-page-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="shop-topbar-wrapper">
                    <div class="product-sorting-wrapper">
                        <div class="product-show shorting-style">
                            Veg <input name="type1" type="radio" value="veg"
                                style="width:16px;height: 12px; margin-right:5px;" onclick="setfoodtype('veg')"
                                <?php if($type3=="veg") echo"checked";?> />
                            Non-Veg <input name="type1" type="radio" value="nonveg"
                                style="width:16px;height: 12px; margin-right:5px;" onclick="setfoodtype('nonveg')"
                                <?php if($type3=="nonveg") echo"checked";?> />
                            Both <input name="type1" class="veg" type="radio" value="both"
                                style="width:16px;height: 12px; margin-right:5px;" onclick="setfoodtype('both')"
                                <?php if($type3=="both") echo"checked";?> />
                        </div>
                    </div>
                </div>

                <div class="banner-area pb-30">
                    <a href="product-details.html"><img alt="" src="assets/img/banner/banner-49.jpg"></a>
                </div>
                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <div class="row">
                            <?php
                            if($num>0)
                        {
                            while($row2=mysqli_fetch_assoc($sql2))
                            {
                            echo'
                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                <div class="product-wrapper">
                                    <div class="product-img"><a href="product-details.html">
                                            <img src="'.SITE_DISH_IMAGE.$row2['image'].'"alt="">
                                        </a>
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            '.$row2['dish'];
                                            //  if($row2['type']=='veg')
                                            //  {
                                            //     echo'<img src="../assets/images/veg.png" style="width: 0px;>';
                                            //  }
                                            //  else if($row2['type']=='nonveg')
                                            //  {
                                            //     echo'<img src="../assets/images/nonveg.png" style="width: 0px;>';
                                            //  }   
                                        echo'</h4>
                                        <div class="product-price-wrapper">';
                               $dishid=$row2['id'];         
                               $sql3=mysqli_query($conn,"select * from dish_details where status='1' and dish_id='$dishid' order by price asc");
                                    while($row3=mysqli_fetch_assoc($sql3))
                                    {
                                        echo'<input type="radio" id="attr'.$row2['id'].'" name="radio_'.$row2['id'].'" value="'.$row3['id'].'"style="width: 16px;height: 13px; margin-right:5px;">';
                                        echo'<span>'.$row3['attribute'].'&nbsp;</span>';
                                        echo '<span>'.$row3['price'].'&nbsp;&nbsp;</span>';
                                    }
                                        echo'</div>';
                                        echo'<div class="product-price-wrapper">
                                        <select id="qty'.$dishid.'" style="height:24px;width:50%;border:1px solid;margin-top:7px;">
                                        <option value="0">Qty</option>';
                                        for($i=1;$i<=10;$i++)
                                        {
                                          echo'<option>'.$i.'</option>';
                                        }
                                       
                                        echo'
                                        </select>
                                        <i class="fas fa-cart-plus" style="font-size: 25px;margin-left:5px;cursor:pointer;" onclick="addtocart('.$dishid.')"></i>
                                        </div>';

                                 echo'
                                    </div>
                                </div>
                            </div>';
                            }
                        }
                        else
                        {
                            echo ("No Results Found");
                        }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $sql=mysqli_query($conn,"select * from category where status=1 order by order_number desc");
            ?>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Shop By Categories</h4>
                        <div class="shop-catigory">
                            <ul id="faq">
                                <?php
                                 while($row=mysqli_fetch_assoc($sql))
                                 {
                                    echo '<li> <a href="shop.php?cat_id='.$row['id'].'">'.$row['category'].'</a> </li>';
                                 }
                                ?>
                            </ul>
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
<script>
function setfoodtype(value) {
    let url = window.location.href;
    let result = url.includes("cat_id");
    let result2 = url.includes("type");
    if (result && !result2) {
        window.location = url + "&type=" + value;
    } else if (result && result2) {
        var remove_after = url.indexOf('&');
        var result3 = url.substring(0, remove_after);
        window.location = result3 + "&type=" + value;
    } else {
        window.location = "shop.php?type=" + value;
    }
}

function addtocart(id) {
    var dish_id = id;
    var qty = document.getElementById("qty" + id).value;

    var dish_attr_id = document.querySelector('input[name="radio_' + id + '"]:checked').value;
    if (qty == 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please select a specific Quantity',
        })
    }
    if (qty > 0) {
        $.ajax({
            type: "POST",
            url: 'manage_cart.php',
            data: {
                dish_id: dish_id,
                qty: qty,
                dish_attr_id: dish_attr_id
            },
            success: function(result) {
                var data = JSON.parse(result);
                console.log(data);
                Swal.fire(
                    'Hurray!',
                    'You Dish is added successfully!',
                    'success'
                )
                if (data.totalCartDish == 1) {
                    var html = `<ul id="list"><li class="single-shopping-cart">
                                                <div class="shopping-cart-img">
                                                    <a href="#"><img alt="" style="width:100%;"src="` +
                        SITE_DISH_IMAGE + data.image + `"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="#">` + data.dishname + `( ` + data.attrname + ` )</a></h4>
                                                    <h6>Qty: ` + qty + `</h6>
                                                    <span>Rs. ` + data.priceqty + `</span>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="ion ion-close"></i></a>
                                                </div>
                                                </li></ul>
                                        <div class="shopping-cart-total">
                                            <h4>Shipping : <span>$20.00</span></h4>
                                            <h4>Total : <span class="shop-total" id="newprice">Rs. ` + data.price + `</span>
                                            </h4>
                                        </div>
                                        <div class="shopping-cart-btn">
                                            <a href="cart.php">view cart</a>
                                            <a href="checkout.php">checkout</a>
                                        </div>`;
                    document.getElementById("cartmenu").innerHTML = html;
                } else if (data.totalCartDish > 1) {
                    var html = `<li class="single-shopping-cart">
                                                <div class="shopping-cart-img">
                                                    <a href="#"><img alt="" style="width:100%;"src="` +
                        SITE_DISH_IMAGE + data.image + `"></a>
                                                </div>
                                                <div class="shopping-cart-title">
                                                    <h4><a href="#">` + data.dishname + `( ` + data.attrname + ` )</a></h4>
                                                    <h6>Qty: ` + qty + `</h6>
                                                    <span>Rs. ` + data.priceqty + `</span>
                                                </div>
                                                <div class="shopping-cart-delete">
                                                    <a href="#"><i class="ion ion-close"></i></a>
                                                </div>
                                                </li>`;
                    document.getElementById("list").innerHTML += html;
                    document.getElementById("newprice").innerHTML = "Rs. " + data.price;
                }
                document.getElementById("price2").innerHTML = "Rs. " + data.price;
                document.getElementById("cart_num").innerHTML = data.totalCartDish;
            }
        });
    }
}
</script>