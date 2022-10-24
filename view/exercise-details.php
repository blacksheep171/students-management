
<?php
session_start();

include_once dirname(__DIR__)."./app/Services/Services.php";

$user = new Services();

if($user->loggedIn()) {
    $permission = $user->permission();
    $data = [];
    if(!empty($user->getExercises())){
        $data = $user->getExercises();
    }
} else {
    header("Location:index.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alkalami&family=Roboto&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script rel="preload" as="script" crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/less.js/4.1.3/less.min.js"></script>
    <title>Exercise Details</title>
</head>
<body>

<div class="wrap wrap-fluid exercise">
    <?php include __DIR__."/header.php" ?>
    <div class="wrap__inner exercise__details">
        <div class="wrap__title">
            <h1>Exercise Details</h1>
        </div>
        <div class="wrap__content">
            <div class="subject__list">
            <div class="col-12 d-flex justify-content-end"><button id="back_btn" class="btn btn-outline-dark"  name="action">Back</button></div>
                <form class="exercise__details" action="" method="GET">
                <div class="col-12">
                    <input type="hidden" id="id" name="course_id" value="<?= $_SESSION['course_id']?>" class="form-control" placeholder="Id">
                    <table class="table table-bordered table-striped" style="margin-top:20px;">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Summary</th>
                            <th class="col-4">Content</th>
                            <th class="col-3">File Name</th>
                            <th class="col-3">Status</th>
                            <th class="col-2">Note</th>
                        </thead>
                        <tbody>
                        <?php
                            if (!empty($data)) {
                                foreach ($data as $row) {
                            ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['summary'] ?></td>
                                    <td><?= $row['content'] ?></td>
                                    <td><?= $row['file_name'] ?></td>
                                    <td>
                                        <i id="like"
                                        <?php
                                        if (($user->userLike($row['id']))) {
                                        ?>
                                            class="fa fa-thumbs-up like-btn"
                                        <?php 
                                        } else {
                                        ?>
                                            class="fa fa-thumbs-o-up like-btn"
                                        <?php
                                        }
                                        ?>
                                         data-id="<?= $row['id'] ?>"></i>
                                         <span class="likes"><?php echo $user->getLikes($row['id']); ?></span>
                                         &nbsp;&nbsp;&nbsp;&nbsp;
                                        <i id="dislike"
                                        <?php if ($user->userDisLike($row['id'])) {
                                            ?>
                                            class="fa fa-thumbs-down dislike-btn"
                                        <?php } else { ?>
                                            class="fa fa-thumbs-o-down dislike-btn"
                                        <?php }?>
                                        data-id="<?= $row['id'] ?>"></i>
                                        <span class="dislikes"><?php echo $user->getDisLikes($row['id']); ?></span>
                                    </td>
                                    <td>
                                        <a id="comment_id" href='comment-exercises.php?exercise_id=<?=$row['id']?>' class='btn btn-outline-success btn-sm'>Comment</a>
                                    <?php if($user->role('teacher')){
                                    ?>
                                        <a href='teacher/download-exercises.php?path=<?= $row['file_name'] ?>' class='btn btn-outline-primary btn-sm'>Download</a>
                                    <?php 
                                        } 
                                    ?>
                                    </td>
                                </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
    <?php include __DIR__."/footer.php"?>
</body>
</html>
<script>

$(document).ready(function(){
  var courseStatus = <?= $permission?>;

  $('.like-btn').on('click', function(e){
    var exercise_id = $(this).data('id');
    var data = [];
    $clicked_btn = $(this);
    if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
      action = 'like';
    } else if($clicked_btn.hasClass('fa-thumbs-up')){
    action = 'unLike';
    }
    if (courseStatus == 1) {
      $.ajax({
      url: '<?=BASE_PATH?>view/votes.php',
      type: 'POST',
      data: {
        'action': action,
        'exercise_id': exercise_id
      },
      success: function(data){
          res = JSON.parse(data);
        if (action == 'like') {
          $clicked_btn.removeClass('fa-thumbs-o-up');
          $clicked_btn.addClass('fa-thumbs-up');
        } else if(action == 'unLike') {
          $clicked_btn.removeClass('fa-thumbs-up');
          $clicked_btn.addClass('fa-thumbs-o-up');
        }

        // display the number of likes and dislikes
        $clicked_btn.siblings('span.likes').text(res.likes);
        $clicked_btn.siblings('span.dislikes').text(res.dislikes);

        // change button styling of the other button if user is reacting the second time to post
        $clicked_btn.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
      }
    });		
    } else {
      e.preventDefault();
      alert("You don't have permission to like this exercise!");
    }

  });

  $('.dislike-btn').on('click', function(e){
    var exercise_id = $(this).data('id');
    $clicked_btn = $(this);
    if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
      action = 'disLike';
    } else if($clicked_btn.hasClass('fa-thumbs-down')){
      action = 'unDisLike';
    }
    if (courseStatus == 1) {
      $.ajax({
        url: '<?=BASE_PATH?>view/votes.php',
        type: 'POST',
        data: {
          'action': action,
          'exercise_id': exercise_id
        },
        success: function(data){
          res = JSON.parse(data);
          if (action == 'disLike') {
            $clicked_btn.removeClass('fa-thumbs-o-down');
            $clicked_btn.addClass('fa-thumbs-down');
          } else if(action == 'unDisLike') {
            $clicked_btn.removeClass('fa-thumbs-down');
            $clicked_btn.addClass('fa-thumbs-o-down');
          }
          console.log(res);
          // display the number of likes and dislikes
          $clicked_btn.siblings('span.likes').text(res.likes);
          $clicked_btn.siblings('span.dislikes').text(res.dislikes);
          
          // change button styling of the other button if user is reacting the second time to post
          $clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
        }
      });	
    } else {
      e.preventDefault();
      alert("You don't have permission to like this exercise!");
    }
  });


  $("#back_btn").click(function (){
    window.history.back();
  });

});
</script>