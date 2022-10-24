<?php
require_once dirname(__DIR__)."./Config.php";
require_once dirname(__DIR__)."./Helper/Log.php";

class Comments {
    
    public $table = 'comments';

    public $id;
    public $content;
    public $userId;
    public $exerciseId;
    public $createdAt;
    public $updatedAt;

    /**
     * Set id.
     *
     * @param  string  $id
     * @return boolean
     */
    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function setContent($content) {
        $this->content = $content;
    }
    public function getContent() {
        return $this->content;
    }
    public function setUserId($userId) {
        $this->userId = $userId;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function setExerciseId($exerciseId) {
        $this->exerciseId = $exerciseId;
    }
    public function getExerciseId() {
        return $this->exerciseId;
    }
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }
    public function getCreatedAt() {
        return $this->createdAt;
    }
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
}