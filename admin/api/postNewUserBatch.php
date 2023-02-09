<?php
  session_start();

  require_once '../../vendor/autoload.php';
  include('../connection.php');
  include('emailer.php');

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


  // echo $_FILES['excelFile']['name'];
  $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  
  if(isset($_FILES['excelFile']['name']) && in_array($_FILES['excelFile']['type'], $file_mimes)) {
  
    $arr_file = explode('.', $_FILES['excelFile']['name']);
    $extension = end($arr_file);
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadsheet = $reader->load($_FILES['excelFile']['tmp_name']);
    $sheetData = $spreadsheet -> getActiveSheet() -> toArray();
      
    if(!empty($sheetData)) {
      for ($i = 1; $i < count($sheetData); $i++) {
        $fullname = $sheetData[$i][0];
        $email = $sheetData[$i][1];
        $contact = $sheetData[$i][2];
        $checkInDatabase = $conn -> query("SELECT * FROM useraccounts WHERE fullname='$fullname'");
        if($row = $checkInDatabase -> fetch_array()){

        }else {
          $conn -> query("INSERT INTO useraccounts(fullname, email, contact_number) VALUES('".$fullname."', '".$email."', '".$contact."')");
          informUser($email, $fullname);
          $currentDate = date('F j, Y h:i a');
          $message = $fullname . ' was added to Kipoints Database.';
          $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");
        }
      }
      echo 1;
    }
  }else {
    echo 0;
  }

  $conn -> close();
?>


