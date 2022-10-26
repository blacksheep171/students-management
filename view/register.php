<?php
require_once dirname(__DIR__)."./app/Services/Services.php";

$user = new Services();

if(isset($_POST['save'])){
    $data =  $user->register();
        if($data) {
            $message = 'Register successfully!';
        } else {
            $error = 'Register failed!';
        }
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
      <title>Register</title>
  </head>
<body>
<div class="wrap wrap-fluid">
    <?php include "header.php"?>

<div class="signup-form">
    <?php if(isset($message)){
        echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
    } else if(isset($error)){
        echo '<div class="alert alert-success" role="alert">'.$error.'</div>';
    }
    ?>
    <form action="" method="POST">
		<h2>Register</h2>
		<p class="hint-text">Create your account. It's free and only takes a minute.</p>
        <div class="form-group">
			<div class="row">
				<div class="col"><input type="text" class="form-control" name="name" placeholder="User Name" required="required"></div>
			</div>
        </div>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required" aria-autocomplete="list">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
        </div>
        <div class="form-group register__select">
            <select class="form-select" name="role" aria-label="select" required="required">
                <option disabled selected>Choose your role</option>
                <option id="role1" value="president">President</option>
                <option id="role2" value="teacher">Teacher</option>
                <option id="role3" value="student">Student</option>
            </select>
        </div>        
		<div class="form-group">
            <input type="submit" name="save" class="btn btn-success btn-lg btn-block" value="Register Now">
        </div>
    </form>
	<div class="text-center">Already have an account? <a href="login.php">Sign in</a></div>
</div>
</div>
    <?php include "footer.php"?>
</body>
</html>