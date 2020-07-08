<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json; charset=UTF-8");
    // insert link to load login
    header("Location: http://localhost:8000/login");

    include_once '../settings/database.php';
    $database = new Database();
    $db = $database->getConnection();
    $ver = $_GET['ver'];
    $mail = $_GET['mail'];
    $vDatum = date("d.m.Y");
    $sql = "UPDATE `medicuser` SET `VERIF` = '',`VERIFICATION` = :dt WHERE `medicuser`.`USEMAIL` = :mail AND `medicuser`.`VERIF` = :ver";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":ver", $ver);
    $stmt->bindParam(":mail", $mail);   
    $stmt->bindParam(":dt", $vDatum);   

    if($stmt->execute()){
        echo json_encode(array(
            'status' => 'success'
        ));
    } else {
        echo json_encode(array(
            'status' => 'unsuccess'
        ));
    }
?>