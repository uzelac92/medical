<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../settings/database.php';
$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM `medicuser` ORDER BY LNAME ASC";
$stmt = $db->prepare($query);
$stmt->execute();
$num = $stmt->rowCount();
 
if($num>0){
 
    $posts_arr=array();
    $posts_arr=array("status" => "success","contacts"=>[]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $reg = explode(' ',html_entity_decode($row['REGISTRATION']))[0];

        $post_item=array(
            "ID" => html_entity_decode($row['ID']),
            "FNAME" => html_entity_decode($row['FNAME']),
            "LNAME" => html_entity_decode($row['LNAME']),
            "USEMAIL" => html_entity_decode($row['USEMAIL']),
            "USEPASS" => html_entity_decode($row['USEPASS']),
            "SALUTE" => html_entity_decode($row['SALUTE']),
            "VERIF" => html_entity_decode($row['VERIF']),
            "TYPE" => html_entity_decode($row['TYPE']),
            "NOTES" => html_entity_decode($row['NOTES']),
            "PHONE" => html_entity_decode($row['PHONE']),
            "ADDRESS" => html_entity_decode($row['ADRES']),
            "REG" => $reg,
            "VER" => html_entity_decode($row['VERIFICATION']),
            "TER" => html_entity_decode($row['TERMS']),
            "DOB" => html_entity_decode($row['DOB']),
            "ZIP" => html_entity_decode($row['ZIP']),
            "CITY" => html_entity_decode($row['CITY']),
            "INSURANCE" => html_entity_decode($row['INSURANCE']),
        );
        array_push($posts_arr["contacts"], $post_item);
    }
    echo json_encode($posts_arr);
} else{
    echo json_encode(
        array("status" => "unsuccess")
    );
}