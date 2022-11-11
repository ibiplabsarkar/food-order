<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h2>update Admin</h2>
        <br><br>
         <?php
         //get the id of selected admin
         //create sql query to get the details
         $id = $_GET['id'];
         $sql ="SELECT *FROM tbl_admin WHERE id=$id";
         $res = mysqli_query($conn,$sql);
         //check whether the query is executed or not
         if($res==true)
         {
            $count = mysqli_num_rows($res);
            if($count==1)
            {
                //get details
                $row=mysqli_fetch_assoc($res);
                $full_name = $row['full_name'];
                $username = $row['username'];
            }
            else{
                 //redirect to manage admin page
                 header('location:'.SITEURL.'admin/manage-admin.php');
            }
         }
         ?>
        <form method="POST">
        <table class="tbl-30">
            <tr>
                <td>Full Name:</td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </td>
            </tr>

            <tr>
                <td>Username:</td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </td>
            </tr>

            <tr>
                 <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <input type="submit" name="submit" values="update Admin" class="btn-secondary">
                 </td>
            </tr>
        </table>
        </form>
    </div>
</div>
<?php
//check whether the submit is clicked or not
if(isset($_POST['submit']))
{
    // echo "button clicked";
    //get all the values from form to update
     $id = $_POST['id'];
     $full_name = $_POST['full_name'];
     $username = $_POST['username'];

     //create a sql query t update admin
     $sql ="UPDATE tbl_admin SET
     full_name = '$full_name',
     username = '$username'
     WHERE  id='$id'
     ";
     //execute the query
     $res = mysqli_query($conn, $sql);

     //check whether the query executed successfully or not 
     if($res==true)
     {
        $_SESSION['update']="<div class='success'admin updated successfully</div>";
        header('location:'.SITEURL.'admin/manage-admin.php'); 
     }
     else
     {
        $_SESSION['update']="<div class='error'jfailed to update admin</div>";
        header('location:'.SITEURL.'admin/manage-admin.php'); 
     }
}

?>

<?php include('partials/footer.php'); ?>