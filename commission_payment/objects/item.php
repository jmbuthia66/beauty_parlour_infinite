<?php
   include_once '../../config/database.php';
   $database = new Database();
   $db = $database->getConnection();

   // Read POST data
   $request = 0;

   if(isset($_POST['request'])){
      $request = $_POST['request'];
   }

   // Get unpaidcomm
   if($request == 1){
      $unpaidcomm = $_POST['unpaidcomm'];

      $stmt = $db->prepare("SELECT * FROM commission_unpaid WHERE emp_id=:emp");
      $stmt->bindValue(':emp', (int)$unpaidcomm, PDO::PARAM_INT);

      $stmt->execute();
      $unpaidcommList = $stmt->fetchAll();
   
      $response = array();
      foreach($unpaidcommList as $unpaidcomm){
         $response[] = array(
            "emp_id" => $unpaidcomm['emp_id'],
            "unpaidcomm" => $unpaidcomm['unpaidcomm']
         );
      }
   
      echo json_encode($response);
      exit;
   }

?>