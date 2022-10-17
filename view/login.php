<?php
require_once dirname(__DIR__)."./app/Services/UserServices.php";

session_start();
$user = new UserServices();

if (isset($_POST['login'])) {
    $user->login();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?=BASE_PATH?>./public/css/style.css"/>
    <link rel="stylesheet/less" type="text/css" href="<?=BASE_PATH?>./public/css/sources/styles.less"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Roboto&display=swap" rel="stylesheet">
    <script rel="preload" as="script" crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.min.js"></script>
    <title>Student Management</title>
</head>
<body>
<div class="wrap wrap-fluid">
    <?php include "header.php"?>
<style>
.login-form {
    width: 340px;
    margin: 50px auto;
    font-size: 15px;
}
.login-form form {
    margin-bottom: 15px;
    background: #f7f7f7;
    box-shadow: 0px 2px 2px rgb(0 0 0 / 30%);
    padding: 30px;
}
.login-form h2 {
    margin: 0 0 15px;
}
.text-center {
    text-align: center!important;
}
.h2, h2 {
    font-size: 2rem;
}
.form-group {
    margin-bottom: 1rem;
}
.form-control, .btn {
    min-height: 38px;
    border-radius: 2px;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.text-center {
    text-align: center!important;
}
p {
    margin-top: 0;
    margin-bottom: 1rem;
}
</style>
    <div class="login-form">
    <form action="" method="POST">
    <?php if(isset($message)){
            echo "<label class = 'text-danger'>".$message."</label>";
        }
    ?>
        <h2 class="text-center">Sign in</h2>       
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="login" class="btn btn-primary btn-block">Sign in</button>
        </div>        
    </form>
    <p class="text-center"><a href="register.php">Create an Account</a></p>
</div>

</div>
    <?php include "footer.php"?>
</body>
</html>