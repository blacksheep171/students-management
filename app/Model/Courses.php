<?php 
require_once dirname(__DIR__)."./Config.php";
require_once dirname(__DIR__)."./Helper/Log.php";

class Courses {
    protected $table = 'courses';
    
    public $id;
    public $name;
    public $createdBy;
    public $status;
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
    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }
    public function getCreatedBy() {
        return $this->createdBy;
    }
    public function setStatus($status) {
        $this->status = $status;
    }
    public function getStatus() {
        return $this->status;
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
