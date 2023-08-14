<?php
class Commission{
  
    // database connection and table name
    private $conn;
    private $table_name = "commissions";
  
    public function __construct($db){
        $this->conn = $db;
    }

    //All commissions
    function readAll($from,$todate){
  
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " where tran_date between '$from' and '$todate'
                ORDER BY
                    employee_name ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }

    //All commissions (summary)
    function readAllCommSumm(){
  
        $query = "SELECT * FROM commission_overall_summary order by employee ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }
    
    //employee commissions
    function readOne($empid,$from,$todate){
  
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . " where emp_id='$empid' and tran_date between '$from' and '$todate'";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    } 

    //All (cash and mpesa) payments
    function readAllPay($from,$todate){  
        $query = "SELECT * FROM all_sales where tran_date between '$from' and '$todate'";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }
    
    //cash or mpesa payemnt
    function readOnePay($paymode,$from,$todate){  
        $query = "SELECT * FROM all_sales where $paymode>0 and tran_date between '$from' and '$todate'";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    } 

    //All product sales
    function readProdAll($from,$todate){
  
        $query = "SELECT * FROM product_sales where tran_date between '$from' and '$todate' ORDER BY item ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }      
    
    //per product sales
    function readProdOne($prod,$from,$todate){
  
        $query = "SELECT * FROM product_sales where product_id='$prod' and tran_date between '$from' and '$todate' ORDER BY item ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }  

    //All income
    function readIncAll($from,$todate){
  
        $query = "SELECT * FROM income where tran_date between '$from' and '$todate' ORDER BY item ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }      
    
    //income per category 
    function readIncOne($cat,$from,$todate){
  
        $query = "SELECT * FROM income where category='$cat' and tran_date between '$from' and '$todate' ORDER BY item ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    } 

    //All commission payment
    function readCommPayAll($from,$todate){
  
        $query = "SELECT * FROM commission_payment_rpt where payment_date between '$from' and '$todate' ORDER BY name ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }
    
    //commissions payment per employee
    function readCommPayOne($empid,$from,$todate){
  
        $query = "SELECT * FROM commission_payment_rpt where employee_id='$empid' and payment_date between '$from' and '$todate'";
                          
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }    

    //All sales
    function readSaleAll($from,$todate){
  
        $query = "SELECT * FROM sales where tran_date between '$from' and '$todate' ORDER BY tran_date,item ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }      
    
    //per category sales
    function readSaleOne($cat,$from,$todate){
  
        $query = "SELECT * FROM sales where cat_id='$cat' and tran_date between '$from' and '$todate' ORDER BY tran_date,item ASC";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }       
}
?>