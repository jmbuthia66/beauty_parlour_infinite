<?php
   include_once '../../config/database.php';
   $database = new Database();
   $db = $database->getConnection();

   // Read POST data
   $request = 0;

   if(isset($_REQUEST['reportType'])){
      $request = $_REQUEST['reportType'];
   // Get item
      if($request == 1)
      {
         $stmt = $db->prepare("SELECT * from employees ORDER BY name");
         //$stmt->bindValue(':category', (int)$categoryid, PDO::PARAM_INT);

         $stmt->execute();
         $empList = $stmt->fetchAll();
      
         $response = array();
         foreach($empList as $emp){
            $response[] = array(
            "id" => $emp['id'],
            "name" => $emp['name']
            );
         }
      
         echo json_encode($response);
         //
         // echo json_encode(array("message"=>"unknown request"));
         exit;

      }
      else if($request == 3)
      {
         $stmt = $db->prepare("SELECT * from products where category_id=2 ORDER BY name");
         //$stmt->bindValue(':category', (int)$categoryid, PDO::PARAM_INT);

         $stmt->execute();
         $prodList = $stmt->fetchAll();
      
         $response = array();
         foreach($prodList as $prd){
            $response[] = array(
            "id" => $prd['id'],
            "name" => $prd['name']
            );
         }
      
         echo json_encode($response);
         //
         // echo json_encode(array("message"=>"unknown request"));
         exit;

      }
      else if($request == 4)
      {
         $stmt = $db->prepare("SELECT * from categories ORDER BY name");
         //$stmt->bindValue(':category', (int)$categoryid, PDO::PARAM_INT);

         $stmt->execute();
         $catList = $stmt->fetchAll();
      
         $response = array();
         foreach($catList as $cat){
            $response[] = array(
            "id" => $cat['id'],
            "name" => $cat['name']
            );
         }
      
         echo json_encode($response);
         //
         // echo json_encode(array("message"=>"unknown request"));
         exit;
      }
      else if($request == 5)
      {
         $stmt = $db->prepare("SELECT * from employees ORDER BY name");
         //$stmt->bindValue(':category', (int)$categoryid, PDO::PARAM_INT);

         $stmt->execute();
         $empList = $stmt->fetchAll();
      
         $response = array();
         foreach($empList as $emp){
            $response[] = array(
            "id" => $emp['id'],
            "name" => $emp['name']
            );
         }
      
         echo json_encode($response);
         //
         // echo json_encode(array("message"=>"unknown request"));
         exit;

      }
      else if($request == 7)
      {
         $stmt = $db->prepare("SELECT * from categories ORDER BY name");
         //$stmt->bindValue(':category', (int)$categoryid, PDO::PARAM_INT);

         $stmt->execute();
         $catList = $stmt->fetchAll();
      
         $response = array();
         foreach($catList as $cat){
            $response[] = array(
            "id" => $cat['id'],
            "name" => $cat['name']
            );
         }
      
         echo json_encode($response);
         //
         // echo json_encode(array("message"=>"unknown request"));
         exit;

      }
      else{
      echo json_encode(array("message"=>"unknown request"));
      }
   }else{
      echo json_encode(array("message"=>"unknown request"));
   }

?>