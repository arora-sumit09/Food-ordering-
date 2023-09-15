<?php
ob_start();
include("top.php");
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id']) && $_GET['id']>0)
{
    $id=$_GET['id'];
    $sql2="Delete from banner where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: banner.php");
}
if(isset($_GET['type']) && $_GET['type']=='deactive' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=1;
    $id=$_GET['id'];
    $sql2="Update banner set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: banner.php");
}
if(isset($_GET['type']) && $_GET['type']=='active' && isset($_GET['id']) && $_GET['id']>0)
{
    $status=0;
    $id=$_GET['id'];
    $sql2="Update banner set status='$status' where id='$id'";
    mysqli_query($conn,$sql2);
    header("Location: banner.php");
}

$sql="Select * from banner order by order_number";
$res=mysqli_query($conn,$sql);
?>
<div class="card">
    <div class="card-body">
        <h1>Banner Master</h1>
        <div style="margin-bottom:10px;"><a href="manage_banner.php">Add Banner</a></div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="order-listing" class="table">
                        <thead>
                            <tr>
                                <th width="15%">S.No #</th>
                                <th width="15%">Image</th>
                                <th width="20%">Heading</th>
                                <th width="20%">Sub Heading</th>
                                <th width="40%">Actions</th>
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
                                    <td><img src="'.SITE_DISH_IMAGE.$row['image'].'"</td>
                                    <td>'.$row['heading'].'</td>
                                    <td>'.$row['sub_heading'].'</td>
                                    <td>';
                                if($row['status']==1)
                                {
                                  echo'<a href="banner.php?id='.$id.'&type=active"><label class="badge badge-info handcursor">Active</label></a>';
                                }
                                else{
                                  echo'<a href="banner.php?id='.$id.'&type=deactive"><label class="badge badge-danger handcursor">Deactive</label></a>';
                                }
                                       echo'
                                       <a href="manage_banner.php?id='.$id.'"> <label class="badge badge-primary handcursor">Edit</label> </a>
                                       <a href="banner.php?id='.$id.'&type=delete"> <label class="badge badge-danger handcursor">Delete</label> </a>
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