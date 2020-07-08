<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../settings/database.php';

    $database = new Database();
    $db = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $vID = $data->id;
    $vSalute = $data->salute;
    $vFName = $data->fname;
    $vLName = $data->lname;
    $vMail = $data->mail;
    $vPhone = $data->phone;
    $vAddress = $data->address;
    $vNotes = $data->notes;
    $vDob = $data->dob;
    $vZip = $data->zip;
    $vCity = $data->city;
    $vInsurance = $data->insurance;

    $sql = "UPDATE `medicuser` SET `FNAME`=:fname, `LNAME`=:lname, `USEMAIL`=:mail, `SALUTE`=:salute, `NOTES`=:notes, `PHONE`=:phone, `ADRES`=:adres,`DOB`=:dob, `ZIP`=:zip, `CITY`=:city, `INSURANCE`=:insurance
                WHERE `medicuser`.`ID` = :id ";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(":id",$vID);
    $stmt->bindParam(":fname", $vFName);
    $stmt->bindParam(":lname", $vLName);
    $stmt->bindParam(":mail", $vMail);
    $stmt->bindParam(":salute", $vSalute);
    $stmt->bindParam(":notes", $vNotes);
    $stmt->bindParam(":phone", $vPhone);
    $stmt->bindParam(":adres", $vAddress);
    $stmt->bindParam(":zip", $vZip);
    $stmt->bindParam(":city", $vCity);
    $stmt->bindParam(":dob", $vDob);
    $stmt->bindParam(":insurance", $vInsurance);

    if($stmt->execute()){
        echo json_encode(array(
            'status' => 'success'
        ));
    } else{

        echo json_encode(array(
            'status' => 'unsuccess'
        ));
    }
?>