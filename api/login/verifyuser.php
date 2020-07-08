<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../settings/database.php';
    $database = new Database();
    $db = $database->getConnection();
    $ime = $_GET['mail'];

    $sql = "SELECT * FROM `medicuser` WHERE `medicuser`.`USEMAIL` = :user";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":user", $ime);
    $stmt->execute();
    $num = $stmt->rowCount();

    if($num>0){
        echo json_encode(array(
            'status' => 'success'
        ));
    } else {
        echo json_encode(array(
            'status' => 'unsuccess'
        ));
    }
?>