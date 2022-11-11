<?php
     //include constants page
     include('../config/constants.php');
     if(isset($_GET['id']) && isset($_GET['image_name']))
     {
        //process to delete
        //get id and image name
        $id = $_GET['id'];
        $image_name=$_GET['image_name'];

        //remove the image if avalable
        //check whether the image is avaliable or not delete if avaliable
        if($image_name !=" ")
        {
            //it has image and need to remove from folder
            //get the image path
            $path = "../images/food/".$image_name;
            //remove image file from folder
            $remove = unlink($path);
            //check whether the image is removed or not
            if($remove==false)
            {
                //failed to remove image
                $_SESSION['upload']="<div class='error'>Failed to Remove Image file</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
                //stop the process of deleting food
                die();
            }
        }
        //delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //execute the query
        $res = mysqli_query($conn, $sql);
        //check whether the query executed or not and set the session message respectively
        //redirect to manage food page
        if($res==true)
        {
            //food deleted
            $_SESSION['delete']="<div class='success'>Food has been deleted successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['delete']="<div class='error'>Failed to delete food</div>";\
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        //redirect to manage food with session message
     }
     else
     {
        
        $_SESSION['unauthorize']="<div class='error'>Unauthorized Access</div>";\
        header('location'.SITEURL.'admin/manage-food.php');
     }
?>