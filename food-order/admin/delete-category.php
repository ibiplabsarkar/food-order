<?php
include('../config/constants.php');
   //check whether the id and image_name value is set or not
   if(isset($_GET['id']) AND isset($_GET['image_name']))
   {
         //get the value and delete
         $id = $_GET['id'];
         $image_name = $_GET['image_name'];
         //remove the physical file is avaliable 
         if($image_name!="")
         {
            //image is avaliable so remove it
            $path ="../images/category/".$image_name;
            //remove the image
            $remove = unlink($path);
            //if failed to remove image than add an error message 
            //stop the process
            if($remove==false)
            {
                 //set the session message 
                 $_SESSION['remove']="<div class='error'>Failed to Remove category image</div>";
                 //redirect to manage category page
                 header('location:'.SITEURL.'admin/manage-category.php');
                 die();
            }
         }
         //delete data from database
         $sql = "DELETE FROM tbl_category WHERE id = $id";
         //execute the query
         $res = mysqli_query($conn,$sql);

         //check whether the data is deleted from database or not
         if($res==true)
         {
             $_SESSION['delete'] = "<div class='sucess'>Category Deleted successfully</div>";
             header('location:'.SITEURL.'admin/manage-category.php');
         }
         else
         {
            $_SESSION['delete'] = "<div class='error'>falied to delete Category</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
         }
         //redirect to manage category page with message
   }
   else
   {
        //redirect to manage category page
        header('location'.SITEURL.'admin/manage-category.php');
   }
?>