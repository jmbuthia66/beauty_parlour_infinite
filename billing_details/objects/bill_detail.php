<?php
    class BillDetail{
    
        // database connection and table name
        private $conn;
        private $table_name = "billing";
    
        public function __construct($db){
            $this->conn = $db;
        }
        
        //billing per employee
        function readOne($empid,$from,$todate){    
            $query = "SELECT id,employee_id,category_id,item_id,price,qty,discount,total_price,tran_no,created
                    FROM
                        " . $this->table_name . " where employee_id='$empid' and created between '$from' and '$todate' 
                        ORDER BY created Desc,tran_no";
        
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();        
            return $stmt;
        }

        //billing all employees
        function readAll($from,$todate){    
            $query = "SELECT id,employee_id,category_id,item_id,price,qty,discount,total_price,tran_no,created
                    FROM
                        " . $this->table_name . " where created between '$from' and '$todate'
                    ORDER BY created Desc,tran_no";
        
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();        
            return $stmt;
        }

        //Transaction details
        function readTranDetails(){    
            $query = "SELECT id,employee_id,category_id,item_id,price,qty,discount,total_price,tran_no,created
                        FROM " . $this->table_name . "
                        WHERE tran_no = ? ";        
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->tran_no);
            $stmt->execute();
            return $stmt;
        }

        //payment details
        function readPaymentDetails(){    
            $query = "SELECT * FROM payment_details WHERE tran_no = ? ";        
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->tran_no);
            $stmt->execute();
            return $stmt;
        }

        // create log and delete the billing details and payment details
        function delete(){          

            //create log for the billing data being deleted     
            $query = "INSERT INTO billing_log (id, employee_id, category_id, item_id, qty, price, discount, total_price, tran_no, created, modified) SELECT * FROM billing WHERE tran_no = ? ";
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->tran_no);
            $stmt->execute();

            //create log for the payment data being deleted
            $query = "INSERT INTO payment_details_log (id, tran_no, mpesa, cash, total, tran_date, created, modified) SELECT * FROM payment_details WHERE tran_no = ? ";        
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->tran_no);
            $stmt->execute();

            //Delete the billing data        
            $query = "DELETE FROM billing WHERE tran_no = ?";            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->tran_no);
            $stmt->execute();

            //Delete the payment data        
            $query = "DELETE FROM payment_details WHERE tran_no = ?";            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->tran_no);
            $stmt->execute();            

            if($result = $stmt->execute()){
                return true;
            }else{
                return false;
            }
        }         
    }
?>