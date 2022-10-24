<?php
require_once dirname(__DIR__)."./app/Services/Services.php";

$user = new Services();

?>

<div id="top-navbar" class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand clearfix" href="<?=BASE_PATH?>view/index.php"><img class="pull-left" width="123" height="40" alt="Nicepage.com" src="//csite.nicepage.com/Images/logo-w.png"></a>   
        </div>
        <div class="navbar-collapse collapse">
           <?php include dirname(__DIR__)."./view/header/navigation.php" ?> 

            <ul class="logon-block nav navbar-nav nav-list navbar-right u-unstyled">
                <?php
                if($user->loggedIn()) {
                    ?>
                    <li><a id="my-account" href='index.php'>Welcome <?=$_SESSION['user']['name']?></a></li><li class='divider-vertical'></li>
                    <li><a href='<?=BASE_PATH?>view/logout.php'>Logout</a></li><li class='divider-vertical'></li> 
                <?php
                } else {
                ?>
                    <li><a href="login.php">Sign In</a></li><li class="divider-vertical"></li>
                    <li><a href="register.php">Register</a></li><li class="divider-vertical"></li>
                <?php 
                }
                ?>
            </ul>
        </div>
    </div>
</div>