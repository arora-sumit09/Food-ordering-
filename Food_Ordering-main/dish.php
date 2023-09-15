<?php
ob_start();
include("top.php");
if(isset($_GET['type']) && $_GET['type']=='deactive' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=1;
    $id=$_GET['id'];
    $sql2="Update dish set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: dish.php");
}
if(isset($_GET['type']) && $_GET['type']=='active' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=0;
    $id=$_GET['id'];
    $sql2="Update dish set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: dish.php");
}

$sql="Select dish.*,category.category from dish,category where dish.category_id=category.id order by dish.id desc";
$res=mysqli_query($conn,$sql);
?>
<div class="card">
    <div class="card-body">
        <h1>Dish Master</h1>
        <div style="margin-bottom:10px;"><a href="manage_dish.php">Add Dish</a></div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th width="10%">S.No #</th>
                                <th width="15%">Category</th>
                                <th width="20%">Dish</th>
                                <th width="15%">Image</th>
                                <th width="15%">Added On</th>
                                <th width="20%">Actions</th>
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
                                    <td>'.$row['category'].'</td>
                                    <td>'.$row['dish'].'&nbsp;('.$row['type'].')</td>
                                    <td><img src="'.SITE_DISH_IMAGE.$row['image'].'"</td>
                                    <td>'.$row['added_on'].'</td>
                                    <td>';
                                if($row['status']==1)
                                {
                                  echo'<a href="dish.php?id='.$id.'&type=active"><label class="badge badge-info handcursor">Active</label></a>';
                                }
                                else{
                                  echo'<a href="dish.php?id='.$id.'&type=deactive"><label class="badge badge-danger handcursor">Deactive</label></a>';
                                }
                                       echo'
                                       <a href="manage_dish.php?id='.$id.'"> <label class="badge badge-primary handcursor">Edit</label> </a>
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