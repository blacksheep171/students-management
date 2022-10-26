<?php 

interface UserInterface {

    public function getSubjects();

    public function getMostSubmittedSubject();

    public function getMostRatingSubject();

    public function getMostCommentsSubject();
}