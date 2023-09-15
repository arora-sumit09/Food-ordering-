<?php
ob_start();
include("top.php");
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0)
{
    $id=$_GET['id'];
    $sql2="Delete from coupon_code where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: coupon_code.php");
}
if(isset($_GET['type']) && $_GET['type']=='deactive' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=1;
    $id=$_GET['id'];
    $sql2="Update coupon_code set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: coupon_code.php");
}
if(isset($_GET['type']) && $_GET['type']=='active' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=0;
    $id=$_GET['id'];
    $sql2="Update coupon_code set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: coupon_code.php");
}

$sql="Select * from coupon_code order by id desc";
$res=mysqli_query($conn,$sql);
?>
<div class="card">
    <div class="card-body">
        <h1>Coupon Code Master</h1>
        <div style="margin-bottom:10px;"><a href="manage_coupon_code.php">Add Coupon Code</a></div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th width="10%">S.No #</th>
                                <th width="5%">Code</th>
                                <th width="5%">Type</th>
                                <th width="5%">Value</th>
                                <th width="15%">Cart Min</th>
                                <th width="15%">Expired On</th>
                                <th width="15%">Added On</th>
                                <th width="30%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(mysqli_num_rows($res))
                            {
                              $i=1;
                              while($row=mysqli_fetch_assoc($res))
                              {
                                $id=$row['id'];
                              echo'
                                <tr>
                                    <td>'.$i.'</td>
                                    <td>'.$row['coupon_code'].'</td>
                                    <td>'.$row['coupon_type'].'</td>
                                    <td>'.$row['coupon_value'].'</td>
                                    <td>'.$row['cart_min_value'].'</td>
                                    <td>'.$row['expired_on'].'</td>
                                    <td>'.$row['added_on'].'</td>
                                    <td>';
                                if($row['status']==1)
                                {
                                  echo'<a href="coupon_code.php?id='.$id.'&type=active"><label class="badge badge-info handcursor">Active</label></a>';
                                }
                                else{
                                  echo'<a href="coupon_code.php?id='.$id.'&type=deactive"><label class="badge badge-danger handcursor">Deactive</label></a>';
                                }
                                       echo'
                                       <a href="manage_coupon_code.php?id='.$id.'"> <label class="badge badge-primary handcursor">Edit</label> </a>
                                        <a href="category.php?id='.$id.'&type=delete"> <label class="badge badge-danger handcursor">Delete</label> </a>
                                    </td>
                                </tr>';
                                $i++;
                              }
                            }
                            else
                            {
                              echo'<tr>
                              <td colspan="5">No Data Found</td>
                              </tr>';
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("bottom.php");
?>