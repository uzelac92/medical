<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../settings/database.php';
$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'];

// GET USER DATA
if($id >= 0){
    $query = "SELECT * FROM `medicuser` WHERE ID = :userid";
} else {
    $query = "SELECT * FROM `medicuser`";
}
$stmt = $db->prepare($query);
$stmt->bindParam(":userid", $id);
$stmt->execute();
$num = $stmt->rowCount();
if($num>0){
    $posts_arr=array("status" => "success","contacts"=>[]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $reg = explode(' ',html_entity_decode($row['REGISTRATION']))[0];

        // GET USER CONSULTATIONS
        $query2 = "SELECT * FROM `consultations` WHERE USERID = :userid ORDER BY CONSDATE DESC";
        $stmt2 = $db->prepare($query2);
        $stmt2->bindParam(":userid", $row['ID']);
        $stmt2->execute();
        $cons_arr=array("status" => "success","consultations"=>[]);
        if($stmt2->rowCount()>0) {
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){

                // GET USER CONSULTATION TASKS
                $query3 = "SELECT * FROM `tasks` WHERE USERID = :userid AND CONSID = :consid ORDER BY CREATED DESC";
                $stmt3 = $db->prepare($query3);
                $stmt3->bindParam(":userid", $row['ID']);
                $stmt3->bindParam(":consid", $row2['CONSID']);
                $stmt3->execute();
                $task_arr=array("status" => "success","CONSTASKS"=>[]);
                if($stmt3->rowCount()>0) {
                    while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                        
                        $task_item = array(
                            "TASKID" => html_entity_decode($row3['TASKID']),
                            "CREATED" => html_entity_decode($row3['CREATED']),
                            "DUE" => html_entity_decode($row3['DUE']),
                            "DUEFILENAME" => html_entity_decode($row3['DUEFILENAME']),
                            "SOLVEDATE" => html_entity_decode($row3['SOLVEDATE']),
                            "SOLVEFILENAME" => html_entity_decode($row3['SOLVEFILENAME'])
                        );
                        array_push($task_arr["CONSTASKS"], $task_item);
                    }
                } else {
                    $task_arr=array("status" => "unsuccess");
                }

                $cons_item = array(
                    "CONSID" => html_entity_decode($row2['CONSID']),
                    "CONSDATE" => html_entity_decode($row2['CONSDATE']),
                    "CONSTASKS" => $task_arr
                );
                array_push($cons_arr["consultations"], $cons_item);
            }
        } else {
            $cons_arr=array("status" => "unsuccess");
        }

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
            "CONSULTATIONS" => $cons_arr
        );
        array_push($posts_arr["contacts"], $post_item);
    }
    echo json_encode($posts_arr);
} else{
    echo json_encode(
        array("status" => "unsuccess")
    );
}