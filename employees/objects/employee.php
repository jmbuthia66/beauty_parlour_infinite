<?php
class Employee{
  
    // database connection and table name
    private $conn;
    private $table_name = "employees";
  
    // object properties
    public $id;
    public $name;
    public $mobile_no;
    public $idno;
    public $timestamp;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // create employee
    function create(){
  
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, mobile_no=:mobile_no, idno=:idno, created=:created";
  
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->mobile_no=htmlspecialchars(strip_tags($this->mobile_no));
        $this->idno=htmlspecialchars(strip_tags($this->idno));
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":mobile_no", $this->mobile_no);
        $stmt->bindParam(":idno", $this->idno);
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
                    id, name
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";  
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        return $stmt;
    } 

    // used by select drop-down list
    function readActive(){
        //select all data
        $query = "SELECT
                    id, name
                FROM
                    " . $this->table_name . "
                where active=1
                ORDER BY
                    name";  
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        return $stmt;
    }

    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, name, mobile_no, idno,active
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }

    // used for paging employees
    public function countAll(){
    
        $query = "SELECT id FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }

    function readOne(){
  
        $query = "SELECT
                    name, mobile_no, idno,active
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
      
        $this->name = $row['name'];
        $this->mobile_no = $row['mobile_no'];
        $this->idno = $row['idno'];
        $this->active = $row['active'];
    }

    // used to read employee name by its ID
    function readName(){
    
        $query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->name = $row['name'];
    }

    function update(){
  
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    mobile_no = :mobile_no,
                    idno = :idno,
                    active = :active
                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->mobile_no=htmlspecialchars(strip_tags($this->mobile_no));
        $this->idno=htmlspecialchars(strip_tags($this->idno));
        $this->active=htmlspecialchars(strip_tags($this->active));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':mobile_no', $this->mobile_no);
        $stmt->bindParam(':idno', $this->idno);
        $stmt->bindParam(':active', $this->active);
        $stmt->bindParam(':id', $this->id);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
          
    }

    // delete the employee
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