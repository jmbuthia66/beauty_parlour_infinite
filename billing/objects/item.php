<?php
   include_once '../../config/database.php';
   $database = new Database();
   $db = $database->getConnection();

   // Read POST data
   $request = 0;

   if(isset($_POST['request'])){
      $request = $_POST['request'];
   }

   // Get item
   if($request == 1){
      $categoryid = $_POST['categoryid'];

      $stmt = $db->prepare("SELECT * from products where category_id=:category ORDER BY name");
      $stmt->bindValue(':category', (int)$categoryid, PDO::PARAM_INT);

      $stmt->execute();
      $productList = $stmt->fetchAll();
   
      $response = array();
      foreach($productList as $product){
         $response[] = array(
           "id" => $product['id'],
           "name" => $product['name']
         );
      }
   
      echo json_encode($response);
      exit;

   }

   // Get Prices
   if($request == 2){
      $productid = $_POST['productid'];

      $stmt = $db->prepare("SELECT * from products WHERE id=:product ORDER BY name");
      $stmt->bindValue(':product', (int)$productid, PDO::PARAM_INT);

      $stmt->execute();
      $priceList = $stmt->fetchAll();
   
      $response = array();
      foreach($priceList as $price){
         $response[] = array(
            "id" => $price['id'],
            "price" => $price['price']
         );
      }
   
      echo json_encode($response);
      exit;
   }

?>