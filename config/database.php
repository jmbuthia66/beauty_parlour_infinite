<?php
session_start();//start session
//define lifetime
if(session_status()==PHP_SESSION_NONE)
{   
    session_start_(['cookie_lifetime'=>3600]);//60sec*60min*1hrs
}
class Database{
   
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "beauty_parlour_3";
    private $username = "root";
    private $password = "";
    public $conn;
   
    // get the database connection
    public function getConnection(){   
        $this->conn = null;
   
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
   
        return $this->conn;
    }
}
?>