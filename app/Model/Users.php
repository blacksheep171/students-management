<?php

require_once dirname(__DIR__)."./Config.php";
require_once dirname(__DIR__)."./Helper/Log.php";

class Users {

    protected $table = "users";

    /**
     * connection to database
     * @param string
     * @return PDO
     */
    private $connection;

    private $id;
    private $name;
    private $email;
    private $password;
    private $passwordConfirm;
    private $role;
    private $exerciseId;
    private $status;
    private $createdAt;
    private $updatedAt;

    public function __construct() {
        $this->connection = Config::connect();
    }

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

    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function getPassword() {
        return $this->password;
    }
    public function setPasswordConfirm($passwordConfirm) {
        $this->passwordConfirm = $passwordConfirm;
    }
    public function getPasswordConfirm() {
        return $this->passwordConfirm;
    }
    public function setRole($role) {
        $this->role = $role;
    }
    public function getRole() {
        return $this->role;
    }
    public function setExerciseId($exerciseId) {
        $this->exerciseId = $exerciseId;
    }
    public function getExerciseId() {
        return $this->exerciseId;
    }
    public function setVoteStatus($status) {
        $this->status = $status;
    }
    public function getVoteStatus() {
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
