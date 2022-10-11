<?php
require_once "./app/Services/UserServices.php";

$user = new UserServices();

?>

<div id="top-navbar" class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand clearfix" href="index.php"><img class="pull-left" width="123" height="40" alt="Nicepage.com" src="//csite.nicepage.com/Images/logo-w.png"></a>
            
        </div>
        <div class="navbar-collapse collapse">
            <ul class="logon-block nav navbar-nav nav-list navbar-left u-unstyled">
            <?php
            if(isset($_SESSION['role'])) {
                if($_SESSION['role'] == 'president'){
            ?>
                <li class="dropdown">
                    <a href="/download">Created Subject</a>
                </li>
                
                <li class="dropdown">
                    <a href="/blog">Add Teacher</a>
                </li>
                <li class="dropdown">
                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">More<span class="caret"></span></a>
                </li>
            <?php
            } else if($_SESSION['role'] == 'teacher'){
            ?>
                <li class="dropdown">
                    <a href="/download">Add Student</a>
                </li>
                
                <li class="dropdown">
                    <a href="/blog">Download Exercise</a>
                </li>
                <li class="dropdown">
                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">More<span class="caret"></span></a>
                </li>
            <?php
            } else if($_SESSION['role'] == 'student'){
            ?>
                <li class="dropdown">
                    <a href="/download">My Exercise</a>
                </li>

                <li class="dropdown">
                    <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">More<span class="caret"></span></a>
                </li>
            <?php
                }
            }
            ?>
            </ul>

            <ul class="logon-block nav navbar-nav nav-list navbar-right u-unstyled">
                <?php
                if($user->isSession()) {
                    echo "<li><a href='index.php'>Welcome ".$_SESSION['user_name']."</a></li><li class='divider-vertical'></li>
                    <li><a href='logout.php'>Logout</a></li><li class='divider-vertical'></li> 
                    ";
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