<?php

require __DIR__.'./Config/db.php';

/**
 * @return PDO
 */
class Config {
    
    public static function connect() {
        
        $host = DB_HOST;
        $username = DB_USER;
        $password = DB_PASSWORD;
        $dbname = DB_NAME;
       
        try {
            $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
        }
            return $con;
    }

}
?>