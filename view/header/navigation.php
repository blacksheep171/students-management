<ul class="logon-block nav navbar-nav nav-list navbar-left u-unstyled">
    <?php
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['role'] == 'president') { ?>
            <li class="dropdown">
                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle template-menu-item" href="#">Courses<span class="caret"></span></a>
                <ul role="menu" class="dropdown-menu dropdown-menu-hover u-unstyled">
                    <li><a href="<?=BASE_PATH?>view/president/add-course.php" class="courses-url">New Courses</a></li>
                    <li><a href="<?=BASE_PATH?>view/president/my-courses.php" class="courses-url">My Courses</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle template-menu-item" href="#">Subjects<span class="caret"></span></a>
                <ul role="menu" class="dropdown-menu dropdown-menu-hover u-unstyled">
                    <li><a href="<?=BASE_PATH?>view/president/create-subject.php" class="courses-url">New Subjects</a></li>
                    <li><a href="<?=BASE_PATH?>view/president/my-subjects.php" class="courses-url">My Subjects</a></li>
                </ul>
            </li>
        <?php
            } else if ($_SESSION['user']['role'] == 'teacher') {
        ?>
             <li class="dropdown">
                <a href="<?=BASE_PATH?>view/courses-option.php">Courses</a>
            </li>
        <?php
            } else if ($_SESSION['user']['role'] == 'student') {
        ?>
            <li class="dropdown">
                <a href="<?=BASE_PATH?>view/courses-option.php">Courses</a>
            </li>
    <?php
        }
    }
    ?>
</ul>