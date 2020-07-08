<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once '../settings/database.php';

    $database = new Database();
    $db = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));
    $vUID = $_GET['id'];
    $dateTime = new DateTime("now", new DateTimeZone('Europe/Berlin'));
    $cDate = $dateTime->format('d.m.Y');

    $sql = "INSERT INTO `consultations` (`CONSID`, `USERID`, `CONSDATE`) VALUES (NULL, :userid, :cdate);";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":userid", $vUID);
    $stmt->bindParam(":cdate", $cDate);

    $status = array('status' => 'unsuccess');
    if($stmt->execute()){
        $status = array('status' => 'success');
    }
    echo json_encode($status);
?>