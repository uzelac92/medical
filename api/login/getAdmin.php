<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../settings/database.php';
    
    $database = new Database();
    $db = $database->getConnection();

    $log_item = array();
    $ime = $_GET['id'];
    $loz = $_GET['pass'];

    $query = "SELECT UID,TYPE,KEYENCR,LOGEDIN FROM `kartotekar` WHERE USERWORD = AES_ENCRYPT(:user,:pass) AND USERPASS = AES_ENCRYPT(:pass,:user) AND  LOGEDIN = 0";

    $stmt = $db->prepare($query);
    $stmt->bindParam(":user", $ime);
    $stmt->bindParam(":pass", $loz);
    $stmt->execute();
    $num = $stmt->rowCount();
    
    $log_item["loginData"]=array(
        "status" => html_entity_decode("unsuccess")
    );
    if($num>0){
    
        $row = $stmt->fetch(PDO::FETCH_BOTH);
        $log_item["loginData"]=array(
            "status" => html_entity_decode("success"),
            "uid" => html_entity_decode($row['UID']),
            "usertype" => html_entity_decode($row['TYPE']),
            "keyencr" => html_entity_decode($row['KEYENCR']),
            "logedin" => html_entity_decode($row['LOGEDIN'])
        );

    } else{
        $log_item["loginData"]=array(
            "status" => html_entity_decode("unsuccess")
        );
    }
    echo json_encode($log_item["loginData"]);
?>