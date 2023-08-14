<?php

// Include the database connection file
include_once 'config/database.php';
$database=new Database();
$db=$database->getConnection();

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $db->prepare("SELECT user_id, email, concat(first_name,'  ',last_name) as userNames,role_id, password FROM users WHERE email = :email limit 0,1");
    // $stmt->bind_param("s", $email);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $row= $stmt->fetch(PDO::FETCH_ASSOC);

    if(is_array($row))
    {
        //print_r($row);
            //Verify password and set session variables if successful
        if (password_verify($password, $row['password'])) { 
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['userNames'] = $row['userNames'];
            $_SESSION['userRoleId'] = $row['role_id'];
            header("Location: billing/pages/billing.php");
            exit;
        } else {
            header("Location: index.php");
            header("Location: index.php?message=Invalid login details");
            exit;
        }
    } else {
        header("Location: index.php?message=Invalid login detail");
        exit;
    }
}

?>