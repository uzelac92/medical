<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../settings/database.php';

    $database = new Database();
    $db = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $vSalute = $data->salute;
    $vFName = $data->fname;
    $vLName = $data->lname;
    $vMail = $data->mail;
    $vPass = $data->pass;
    $vPhone = $data->phone;
    $vAddress = $data->address;
    $vNotes = $data->notes;
    $vDob = $data->dob;
    $vZip = $data->zip;
    $vCity = $data->city;
    $vInsurance = $data->insurance;

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $vMainkey = substr(str_shuffle($permitted_chars), 0, 36);

    $date = new DateTime("now", new DateTimeZone('Europe/Belgrade') );
    $vDatum = $date->format('d.m.Y');


    $sql = "INSERT INTO `medicuser` (`ID`, `FNAME`, `LNAME`, `USEMAIL`, `USEPASS`, `SALUTE`, `MAINKEY`, `VERIF`, `TYPE`, `NOTES`, `PHONE`, `ADRES`, `REGISTRATION`, `VERIFICATION`, `TERMS`, `DOB`, `ZIP`, `CITY`, `INSURANCE`) 
            VALUES (NULL, :fname, :lname, :mail, :pass, :salute, AES_ENCRYPT(:mainkey,:pass), NULL, '2', :notes, :phone, :adres, :dates, :dates, :dates, :dob, :zip, :city, :insurance);";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(":fname", $vFName);
    $stmt->bindParam(":lname", $vLName);
    $stmt->bindParam(":mail", $vMail);
    $stmt->bindParam(":pass", $vPass);
    $stmt->bindParam(":salute", $vSalute);
    $stmt->bindParam(":mainkey", $vMainkey);
    $stmt->bindParam(":notes", $vNotes);
    $stmt->bindParam(":phone", $vPhone);
    $stmt->bindParam(":adres", $vAddress);
    $stmt->bindParam(":dates", $vDatum);
    $stmt->bindParam(":zip", $vZip);
    $stmt->bindParam(":city", $vCity);
    $stmt->bindParam(":dob", $vDob);
    $stmt->bindParam(":insurance", $vInsurance);

    $state = $stmt->execute();

    if($state){

        echo json_encode(array(
            'status' => 'success'
        ));
    } else{

        echo json_encode(array(
            'status' => 'unsuccess'
        ));
    }
?>