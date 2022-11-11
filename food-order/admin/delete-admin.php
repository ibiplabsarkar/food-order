<?php
//include constants.php file here
include('../config/constants.php');
//1. get the Id of Admin to be deleted
$id = $_GET['id'];
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//execute the query
$res = mysqli_query($conn,$sql);
//check wether the query execute successfully or not
if($res==true)
{
      //create session  variable to display message
      $_SESSION['delete']="<div class='success'>Admin Deleted successfully</div>";
      header('location:'.SITEURL.'admin/manage-admin.php');
}
else
{
       $_SESSION['delete'] = "<div class='error' falied to delete admin. Try again later</div>";
       header('location:'.SITEURL.'admin/manage-admin.php');
}
?>