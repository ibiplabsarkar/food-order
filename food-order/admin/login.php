<?php
include('../config/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login- Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br>
        <!-- login form starts here -->
        <?php
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br><br>
        <form method="POST" class="text-center">
            username:
            <input type="text" name="username" placeholder="Enter username"><br><br>
            password:
            <input type="password" name="password" placeholder="Enter password"><br><br>
            <input type="submit" name="submit" value="login" class="btn-primary">
        </form>
        <!-- login form ends here -->

        <p class="text-center">created by - <a href="www.instafood.com">Biplab sarkar</a></p>
    </div>
</body>
</html>
<?php
// check whether the submit button is clicked or not
if(isset($_POST['submit']))
{
    //get the data from login form
     $username = $_POST['username'];
     $password = md5($_POST['password']);

     //sql to check whether the user with username and password exit or not
     $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

     //execute the query
     $res = mysqli_query($conn, $sql);

    //  count rows to check whether the user exists or not
     $count = mysqli_num_rows($res);
     if($count==1)
     {
             //user avaliable and login success
             $_SESSION['login']="<div class='success'>login successful</div>";
            //  $_SESSION['user'] = $username;//to check whether the user is logged in or not
             //redirect ot home page
             header('location:'.SITEURL.'admin/');
     }
     else{
        //user not avaliable
        $_SESSION['login']="<div class='error text-center'>username or password does not match</div>";
             //redirect ot home page
             header('location:'.SITEURL.'admin/login.php');
     }
}

?>