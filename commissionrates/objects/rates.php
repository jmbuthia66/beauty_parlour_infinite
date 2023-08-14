<?php
class Rate{
  
    // database connection and table name
    private $conn;
    private $table_name = "commission_rates";
  
    // object properties
    public $id;
    public $employee_id;
    public $product_id;
    public $rate;
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
                employee_id=:employee_id, product_id=:product_id, rate=:rate, created=:created";
  
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->rate=htmlspecialchars(strip_tags($this->rate));
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":employee_id", $this->employee_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":rate", $this->rate);
        $stmt->bindParam(":created", $this->timestamp);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }

    function readAll(){
  
        $query = "SELECT
                    id, employee_id, product_id, rate
                FROM
                    " . $this->table_name . "
                ORDER BY employee_id ASC";
      
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
                    *
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
        $this->product_id = $row['product_id'];
        $this->rate = $row['rate'];
    }
    

    function empRate(){
  
        $query = "SELECT id, employee_id, product_id, rate FROM commission_rates where employee_id=?";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->employee_id);
        $stmt->execute();
      
        return $stmt;
    }

    function update(){
  
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    employee_id = :employee_id,
                    product_id = :product_id,
                    rate = :rate
                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->rate=htmlspecialchars(strip_tags($this->rate));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        // bind parameters
        $stmt->bindParam(':employee_id', $this->employee_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':rate', $this->rate);
        $stmt->bindParam(':id', $this->id);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
          
    }

    // delete the product
    function delete(){
    
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
    
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
}
?>