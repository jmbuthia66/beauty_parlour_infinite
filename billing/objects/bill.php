<?php
class Bill{
  
    // database connection and table name
    private $conn;
    private $table_name = "billing";
  
    // object properties
    public $id;
    public $employee_id;
    public $tran_type;
    public $item_id;
    public $qty;
    public $price;
    public $discount;
    public $total_price;
    public $mobile_no;
    public $timestamp;
  
    public function __construct($db){
        $this->conn = $db;
    }
    

    // create billing
    function create(){
  
        //write query //user_id:user_id,
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                employee_id=:employee_id, tran_type=:tran_type, item_id=:item_id, qty=:qty, price=:price, discount=:discount, total_price=:total_price, mobile_no=:mobile_no,  created=:created";
  
        $stmt = $this->conn->prepare($query);
  
        // posted values
        $this->employee_id=htmlspecialchars(strip_tags($this->employee_id));
        $this->tran_type=htmlspecialchars(strip_tags($this->tran_type));
        $this->item_id=htmlspecialchars(strip_tags($this->item_id));
        $this->qty=htmlspecialchars(strip_tags($this->qty));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->discount=htmlspecialchars(strip_tags($this->discount));
        $this->total_price=htmlspecialchars(strip_tags($this->total_price));
        $this->mobile_no=htmlspecialchars(strip_tags($this->mobile_no));
  
        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
  
        // bind values 
        $stmt->bindParam(":employee_id", $this->employee_id);
        $stmt->bindParam(":tran_type", $this->tran_type);
        $stmt->bindParam(":item_id", $this->item_id);
        $stmt->bindParam(":qty", $this->qty);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":discount", $this->discount);
        $stmt->bindParam(":total_price", $this->total_price);
        $stmt->bindParam(":mobile_no", $this->mobile_no);
        $stmt->bindParam(":created", $this->timestamp);
       // $stmt->bindParam(":user_id", $_SESSION['user_id']);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }

    function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, name, mobile_no
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

    // used for paging billing
    public function countAll(){
    
        $query = "SELECT id FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        $num = $stmt->rowCount();
    
        return $num;
    }

    function readOne(){
  
        $query = "SELECT
                    name, mobile_no
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
    }

    function update(){
  
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    mobile_no = :mobile_no
                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->mobile_no=htmlspecialchars(strip_tags($this->mobile_no));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':mobile_no', $this->mobile_no);
        $stmt->bindParam(':id', $this->id);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
      
        return false;
          
    }

    // delete the customer
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