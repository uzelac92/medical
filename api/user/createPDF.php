<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Content-type: application/pdf");
    include_once '../settings/database.php';
    require 'vendor/autoload.php';

    $database = new Database();
    $db = $database->getConnection();

    $data = json_decode(file_get_contents("php://input"));
    $vUserid = $data->id;
    $vConsid = $data->consid;

    $vInsurance = $data->insurance;
    $vLName = $data->lname;
    $vFName = $data->fname;
    $vDob = str_split($data->dob);
    $vAdres = $data->address;
    $vZip = $data->zip;
    $vCity = $data->city;
    $vStart = $data->startdate;
    $vPeriod = $data->period;

    $vMail = $data->mail;

    $dateTime = new DateTime("now", new DateTimeZone('Europe/Berlin'));
    $cDate = $dateTime->format('d.m.Y');

    $due = date('d.m.Y', strtotime("+$vPeriod months", strtotime($vStart)));

    $timestamp = new DateTime();
    $fileName = substr($timestamp->format('Y-m-d\THisu'),0, -3).'Z.pdf';

    $birth = '';
    for($i=0; $i<count($vDob);$i++){
        if($vDob[$i] != '.'){
            $birth .= $vDob[$i];
        }
    }
    
    $arr = str_split($due);
    $startDate = '';
    for($i=0; $i<count($arr);$i++){
        if($arr[$i] != '.'){
            $startDate .= $arr[$i];
        }
    }

    $fields = array(
        'Pflegeversichertennummer'    => $vInsurance,
        'Name' => $vFName,
        'Vorname'    => $vLName,
        'Geburtsdatum'   => $birth,
        'Straße' => $vAdres, 
        'PLZ'    => $vZip,
        'Ort'   => $vCity,
        'Datum' => $startDate
    );

    $sql = "INSERT INTO `tasks` (`CONSID`, `USERID`, `CREATED`, `DUE`, `DUEFILENAME`) VALUES (:consid, :userid, :created, :duedate, :duefilename);";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":consid", $vConsid);
    $stmt->bindParam(":userid", $vUserid);
    $stmt->bindParam(":created", $cDate);
    $stmt->bindParam(":duedate", $due);
    $stmt->bindParam(":duefilename", $fileName);

    $status = array('status' => 'unsuccess');
    if($stmt->execute()){
        $pdf = new FPDM('fixed.pdf');
        $pdf->Load($fields, true); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $targetURL = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . '../../uploads' . DIRECTORY_SEPARATOR .$fileName;
        $pdf->Output('F',$targetURL);
        $status = array('status' => 'success');
    }
    echo json_encode($status);

?>