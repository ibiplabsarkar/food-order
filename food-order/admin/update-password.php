<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Password change</h1>
        <br><br>
        <?php
               if(isset($_GET['id']))
               {
                $id = $_GET['id'];
               }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password</td>
                    <td>
                        <input type="password" name="current_password" placeholder="currentPassword">
                    </td>
                </tr>

                <tr>
                    <td>New password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="NewPassword">
                    </td>
                </tr>

                <tr>
                    <td>Confirm password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirmPassword">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="change_password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
       //check whether the submit button clicked on or
       if(isset($_POST['submit']))
       { 
              //get the data form
              $id = $_POST['id'];
              $current_password = md5($_POST['current_password']);
              $new_password = md5($_POST['new_password']);
              $confirm_password = md5($_POST['confirm_password']);
              //check whether the user with current ID and current password Exists or not
              $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
              $res = mysqli_query($conn, $sql);
              if($res==true)
              {
                $count = mysqli_num_rows($res);
                if($count==1)
                {
                    //  echo "userfound";
                    //users exists and password can be changed
                    if($new_password==$confirm_password)
                    {
                        //update password
                        // echo "password match";
                        $sql2 = "UPDATE tbl_admin SET
                        password = 'new_password'
                        WHERE id=$id
                        ";
                        //execute the query
                        $res2 = mysqli_query($conn,$sql2);
                        //check whether the query executed or not
                        if($res2==true)
                        {
                            //dispaly success message
                            $_SESSION['change-pwd'] = "<div class='success'>password change successfully.</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                        }
                        else
                        {
                             //display error message
                             $_SESSION['change-pwd'] = "<div class='error'>Failed to change password.</div>";
                            header('location:'.SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else{
                        //redirect to manage admin page with error message
                        $_SESSION['uwd-not-match'] = "<div class='error'>password does not match.</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                }
                    }
        
                else{
                    //user does not exist set message and redirect
                    $_SESSION['user-not-found'] = "<div class='error'>User not found.</div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
         }
       
?>

<?php include('partials/footer.php'); ?>