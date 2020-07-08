<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../settings/database.php';

    $database = new Database();
    $db = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $vFName = $data->fname;
    $vLName = $data->lname;
    $vMail = $data->mail;
    $vPass = $data->pass;
    $vSalute = $data->salute;

    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $vMainkey = substr(str_shuffle($permitted_chars), 0, 36);

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = '';
    for ($i = 0; $i < 20; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
    $vVerif = $randomString;

    $date = new DateTime("now", new DateTimeZone('Europe/Berlin') );
    $vDatum = $date->format('d.m.Y');

    $sql = "INSERT INTO `medicuser` (`FNAME`, `LNAME`, `USEMAIL`, `USEPASS`, `SALUTE`, `MAINKEY`, `VERIF`, `TYPE`, `REGISTRATION`) VALUES (:fname, :lname, :mail, :pass, :salute, AES_ENCRYPT(:mainkey,:pass), :verif, '2',:reg);";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":fname", $vFName);
    $stmt->bindParam(":lname", $vLName);
    $stmt->bindParam(":mail", $vMail);
    $stmt->bindParam(":pass", $vPass);
    $stmt->bindParam(":salute", $vSalute);
    $stmt->bindParam(":mainkey", $vMainkey);
    $stmt->bindParam(":verif", $vVerif);
    $stmt->bindParam(":reg", $vDatum);

    if($stmt->execute()){

        echo json_encode(array(
            'status' => 'success',
            'code' => $vVerif,
            'mail' => $vMail
        ));
    } else{

        echo json_encode(array(
            'status' => 'unsuccess'
        ));
    }
?>