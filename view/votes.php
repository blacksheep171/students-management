<?php
session_start();
include_once dirname(__DIR__)."./app/Services/Services.php";

$user = new Services();

if($user->loggedIn()) {
            $exerciseId = $_POST['exercise_id'] ?? 0;
            $status = $_POST['status'] ?? false;
            $action = $_POST['action'] ?? false;
            $userId = $_SESSION['user']['id'];
            switch($action) {
                case 'like':
                    $user->vote('like',$exerciseId);
                    break;
                case 'unLike':
                    $user->unVote($exerciseId);
                    break;
                case 'disLike':
                    $user->vote('disLike',$exerciseId);
                    break;
                case 'unDisLike':
                    $user->unVote($exerciseId);
                    break;
                default:
                    break;
        }
        
        $likes = $user->getLikes($exerciseId);
        $disLikes = $user->getDisLikes($exerciseId);
        $rating = [
            'likes' => $likes,
            'dislikes' => $disLikes
        ];
        $data = json_encode($rating);
        echo $data;
}   

?>