<?php
include('partials/menu.php');
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php
              if(isset($_session['add']))
              {
                echo $_session['add'];//displaying session message
                unset($_session['add']);//removing session message
              }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td><input type="text" name="full_name" placeholder="Enter your Name"></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" placeholder="your username">
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter password">
                    </td>
                </tr>
                <tr>
                    <td colspan=""2>
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
include('partials/footer.php');
?>
<?php
// process the value form adn save it in Database
if(isset($_POST['submit']))
{
    //button clicked
    // 
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); //password Encrypted with MDS

    $sql = "INSERT INTO tbl_admin SET
    full_name='$full_name',
    username='$username',
    password='$password'
    ";
    //Executing query and saving data into database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4.chech whether the qurey is executed 
    if($res==TRUE)
    {
       $_session['add']="admin added successfully";
       header("location:".SITEURL.'admin/manage-admin.php'); 
    }
    else
    {
        $_session['add']="failed to add admin";
       header("location:".SITEURL.'admin/add-admin.php');
    }
}

?>