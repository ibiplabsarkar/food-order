<?php include('partials/menu.php');?>
<?php
       //check whether id is set or not
       if(isset($_GET['id']))
       {
        //get all the details
        $id = $_GET['id'];
        //sql query to get the selected food
        $sql2 = "SELECT *FROM tbl_food WHERE id=$id";
        //executing the query
        $res2 = mysqli_query($conn,$sql2);
        //get the value based on query executed
        $row = mysqli_fetch_assoc($res2);
        //get all the values individually on selected food
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $current_category = $row['category_id'];
        $featured = $row['featured'];
        $active = $row['active'];
       }
       else
       {
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
       }
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                 </tr>
                    <tr>
                        <td>Description</td>
                        <td>
                            <textarea name="description" cols="30" rows="5"><?php echo $description;?></textarea>
                        </td>
                    </tr>
                <tr>
                    <td>Price</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image</td>
                    <td>
                       <?php
                       if($current_image=="")
                       {
                          //image avaliable
                          echo "<div class='error'>Image not Avaliable</div>";
                       }
                       else
                       {
                        //image avaliable
                        ?>
                         <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" width="150px">
                        <?php
                       }
                       ?>
                    </td>
                 </tr>
                 <tr>
                        <td>Select new Image</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                </tr>
                <td>Category</td>
                <td>
                    <select name="category">
                     <?php
                          $sql = "SELECT *FROM tbl_category WHERE active='Yes'";
                          //executing the query
                          $res = mysqli_query($conn, $sql);
                          //count rows
                          $count = mysqli_num_rows($res);
                          //check whether category avaliable or not
                          if($count>0)
                          {
                            //category avalible
                            while($row = mysqli_fetch_assoc($res))
                            {
                                $category_title = $row['title'];
                                $category_id = $row['id'];
                            //    echo "<option value='$category_id'>$category_title</option>";
                            ?>
                              <option <?php if($current_category==$category_id){echo "selected";}?> value="<?php echo $category_id;?>"><?php echo $category_title; ?></option>
                            <?php
                            }
                          }
                          else
                          {
                            //category not avaliable
                            echo "<option value='0'> category not Avaliable.</option>";
                          }
                          
                     ?>

                        </select>
                </td>
                <tr>
                    <td>Featured</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image;?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
                   if(isset($_POST['submit']))
                   {
                    //get all the details from the form
                      $id = $_POST['id'];
                      $title = $_POST['title'];
                      $description = $_POST['description'];
                      $price = $_POST['price'];
                      $current_image = $_POST['current_image'];
                      $category = $_POST['category'];
                      $featured = $_POST['featured'];
                      $active = $_POST['active'];
                    //upload the image if selected
                    //check whether upload button is clicked or not
                    if(isset($_FILES['image']['name']))
                    {
                        $image_name = $_FILES['image']['name'];//new image name
                        //check whether the file is avaliable or not
                        if($image_name!="")
                        {
                            //image is avaliable
                            //uploading ne image
                            //rename the image
                            $ext = end(explode('.',$image_name));
                            $image_name = "Food-Name".rand(0000,9999).'.'.$ext;//this will rename the image
                            //get the source path and destination path
                            $src_path = $_FILES['image']['tmp_name'];//source path
                            $dest_path = "../images/food/".$image_name;//destination path
                            //upload the image
                            $upload = move_uploaded_file($src_path,$dest_path);
                            //check whether the image is uploaded or not
                            if(upload==false)
                            {
                                //failed to upload
                                $_SESSION['upload']="<div class='error'>Failed to upload new Image</div>";
                                //redirect to manage food
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //stop the process
                                die();
                            }
                             //remove the image if new imagee is uploaded and current image exist
                            //remove current imaage if avaliable
                            if($current_image!="")
                            {
                                //remove the image
                                $remove_path ="../images/food".$current_image;
                                $remove = unlink($remove);
                                //check whether the image is removed or not
                                if($remove==false)
                                {
                                    //failed to remove current image
                                    $_SESSION['remove-failed'] = "div class='error'>failed to remove the Current Image</div>";
                                    //redirect to manage food
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    die();//stop the process
                                }
                            }
                        }
                    }
                    else
                    {
                        $current_image = $current_image;
                    }

                   

                    //update the food in database
                    $sql3 = "UPDATE tbl_food SET
                    title ='$title',
                    description = '$description',
                    price =$price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                    ";
                    //execute the query
                    $res3 = mysqli_query($conn,$sql3);
                    //check whether the query is executed o not
                    if($res3==true)
                    {
                        $_SESSION['update']="<div class='success'>food updated successfully</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        //failed to update food
                         //redirect to manage food with session message
                        $_SESSION['update']="<div class='error'>failed to updated food </div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }

                   

                   }
                   if(isset($_SESSION['update']))
                   {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                   }
        ?>
    </div>
</div>
<?php include('partials/footer.php');?> 