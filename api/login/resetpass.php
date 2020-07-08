<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json; charset=UTF-8");
    // insert link to load login
    include_once '../settings/database.php';
    $database = new Database();
    $db = $database->getConnection();
    $mail = $_GET['mail'];

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = '';
    for ($i = 0; $i < 8; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
    $newPass = $randomString;

    $sql = "UPDATE `medicuser` SET `USEPASS` = :pass WHERE `medicuser`.`USEMAIL` = :mail";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":pass", $newPass);   
    $stmt->bindParam(":mail", $mail);   

    if($stmt->execute()){
        echo json_encode(array(
            'status' => 'success',
            'newPass' => $newPass
        ));
    } else {
        echo json_encode(array(
            'status' => 'unsuccess'
        ));
    }
?>