<ul class="logon-block nav navbar-nav nav-list navbar-left u-unstyled">
    <?php
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] == 'president') { ?>
            <li class="dropdown">
                <a href="add-course.php">New Course</a>
            </li>
            <li class="dropdown">
                <a href="create-subject.php">New Subject</a>
            </li>
            <li class="dropdown">
                <a href="my-subjects.php">My Subjects</a>
            </li>
        <?php
        } else if ($_SESSION['role'] == 'teacher') {
        ?>
            <li class="dropdown">
                <a href="/download">New Student</a>
            </li>

            <li class="dropdown">
                <a href="/blog">Download Exercise</a>
            </li>
            <li class="dropdown">
                <a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#">More<span class="caret"></span></a>
            </li>
        <?php
        } else if ($_SESSION['role'] == 'student') {
        ?>  
        <li class="dropdown">
                <a href="#">My Subjects</a>
            </li>
            <li class="dropdown">
                <a href="#">My Exercise</a>
            </li>
            <li class="dropdown">
                <a href="add-exercise.php">New Exercise</a>
            </li>
    <?php
        }
    }
    ?>
</ul>