<?php
ob_start();
include("top.php");
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0)
{
    $id=$_GET['id'];
    $sql2="Delete from category where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: category.php");
}
if(isset($_GET['type']) && $_GET['type']=='deactive' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=1;
    $id=$_GET['id'];
    $sql2="Update category set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: category.php");
}
if(isset($_GET['type']) && $_GET['type']=='active' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=0;
    $id=$_GET['id'];
    $sql2="Update category set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: category.php");
}

$sql="Select * from category order by order_number";
$res=mysqli_query($conn,$sql);
?>
<div class="card">
    <div class="card-body">
        <h1>Category Master</h1>
        <div style="margin-bottom:10px;"><a href="manage_category.php">Add a Category</a></div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th width="10%">S.No #</th>
                                <th width="50%">Category</th>
                                <th width="15%">Order Number</th>
                                <th width="25%">Actions</th>
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
                                    <td>'.$row['order_number'].'</td>
                                    <td>';
                                if($row['status']==1)
                                {
                                  echo'<a href="category.php?id='.$id.'&type=active"><label class="badge badge-info handcursor">Active</label></a>';
                                }
                                else{
                                  echo'<a href="category.php?id='.$id.'&type=deactive"><label class="badge badge-danger handcursor">Deactive</label></a>';
                                }
                                       echo'
                                       <a href="manage_category.php?id='.$id.'"> <label class="badge badge-primary handcursor">Edit</label> </a>
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