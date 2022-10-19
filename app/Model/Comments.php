<?php
require_once dirname(__DIR__)."./Config.php";

class Comments {
    
    private $table = 'comments';

    /**
     * connection to database
     * @param string
     * @return PDO
     */
    private $connection;

    public $id;
    public $content;
    public $createdAt;
    public $updatedAt;

    public function create($input){
        $sql = "INSERT INTO comments (id, content, createdAt, updatedAt) VALUES (:id, :content, :created_at, :updated_at);";
        
    }
}