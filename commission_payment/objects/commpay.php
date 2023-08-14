<?php
class Commpay{
  
    // database connection and table name
    private $conn;
    private $table_name = "commission_payment";
  
    // object properties
    public $id;
    public $employee_id;
    public $payment_date;
    public $amount_paid;
    public $timestamp;
  
    public function __construct($db){
        $this->conn = $db;
    }


  
    // create product
    function create(){
  
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                employee_id=:employee_id, payment_date=:payment_date, amount_paid=:amount_paid, created=:created";
  
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
        $this->payment_date=htmlspecialchars(strip_tags($this->payment_date));
        $this->amount_paid=htmlspecialchars(strip_tags($this->amount_paid));
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":employee_id", $this->employee_id);
        $stmt->bindParam(":payment_date", $this->payment_date);
        $stmt->bindParam(":amount_paid", $this->amount_paid);
        $stmt->bindParam(":created", $this->timestamp);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }

    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id, payment_date
                FROM
                    " . $this->table_name . "
                ORDER BY
                    payment_date desc";  
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        return $stmt;
    }

    function readAll(){
  
        $query = "SELECT
                    id, employee_id,payment_date,amount_paid
                FROM
                    " . $this->table_name . "
                ORDER BY
                    ID DESC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }

    // used for paging products
    public function countAll(){
    
        $query = "SELECT id FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }

    function readOne(){
  
        $query = "SELECT
                    id, employee_id,payment_date,amount_paid
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
      
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        $this->employee_id = $row['employee_id'];
        $this->payment_date = $row['payment_date'];
        $this->amount_paid = $row['amount_paid'];
    }

    // used to read product name by its ID
    function readName(){
    
        $query = "SELECT employee_id FROM " . $this->table_name . " WHERE id = ? limit 0,1";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->employee_id = $row['employee_id'];
    }

    function update(){
  
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    employee_id = :employee_id,
                    payment_date = :payment_date,
                    amount_paid = :amount_paid
                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
        $this->payment_date=htmlspecialchars(strip_tags($this->payment_date));
        $this->amount_paid=htmlspecialchars(strip_tags($this->amount_paid));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        // bind parameters
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->bindParam(':payment_date', $this->payment_date);
        $stmt->bindParam(':amount_paid', $this->amount_paid);
        $stmt->bindParam(':id', $this->id);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
          
    }

    // delete the product
    function delete(){
    
        // $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        // $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1, $this->id);
    
        // if($result = $stmt->execute()){
        //     return true;
        // }else{
        //     return false;
        // }
    }

    // function readUnpaidComm(){
  
    //     $query = "SELECT * FROM commission_unpaid WHERE emp_id=? LIMIT 0,1";
      
    //     $stmt = $this->conn->prepare( $query );
    //     $stmt->bindParam(1, $this->employee_id);
    //     $stmt->execute();
      
    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
    //     $this->employee_id = $row['employee_id'];
    // }  
    
    function readUnpaidComm(){
        //select all data
        $query = "SELECT * FROM commission_unpaid";  
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        return $stmt;
    }
    
}
?>