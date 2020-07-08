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

    $sql = "SELECT ID,FNAME,LNAME,USEMAIL,USEPASS,SALUTE,VERIF,TYPE, AES_DECRYPT(MAINKEY,:pass) as MAINKEY, NOTES, PHONE, ADRES, REGISTRATION, VERIFICATION,TERMS, DOB, ZIP, CITY, INSURANCE
                     FROM `medicuser` WHERE USEMAIL = :user AND USEPASS = :pass";
    
    $stmt2 = $db->prepare($sql);
    $stmt2->bindParam(":user", $ime);
    $stmt2->bindParam(":pass", $loz);
    $stmt2->execute();
    $num2 = $stmt2->rowCount();

    if($num2>0){
    
        $row2 = $stmt2->fetch(PDO::FETCH_BOTH);
        $log_item["loginData"]=array(
            "status" => html_entity_decode("success"),
            "id" => html_entity_decode($row2['ID']),
            "fname" => html_entity_decode($row2['FNAME']),
            "lname" => html_entity_decode($row2['LNAME']),
            "usemail" => html_entity_decode($row2['USEMAIL']),
            "salute" => html_entity_decode($row2['SALUTE']),
            "mainkey" => html_entity_decode($row2['MAINKEY']),
            "verif" => html_entity_decode($row2['VERIF']),
            "usertype" => html_entity_decode($row2['TYPE']),
            "notes" => html_entity_decode($row2['NOTES']),
            "phone" => html_entity_decode($row2['PHONE']),
            "adres" => html_entity_decode($row2['ADRES']),
            "registration" => html_entity_decode($row2['REGISTRATION']),
            "verification" => html_entity_decode($row2['VERIFICATION']),
            "terms" => html_entity_decode($row2['TERMS']),
            "dob" => html_entity_decode($row2['DOB']),
            "zip" => html_entity_decode($row2['ZIP']),
            "city" => html_entity_decode($row2['CITY']),
            "insurance" => html_entity_decode($row2['INSURANCE'])
        );
    } else {
        $log_item["loginData"]=array(
            "status" => html_entity_decode("unsuccess")
        );
    }
    
    echo json_encode($log_item["loginData"]);
?>