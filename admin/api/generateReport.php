<?php
  require "../../vendor/autoload.php";
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

  include('../connection.php');

  $param = $_GET['param'];

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet -> getActiveSheet();
  $statement = '';

  switch($param){
    case '1':
      $statement = $conn -> query("SELECT * FROM inventory");

      if($statement){
        $i = 2;
    
        $sheet -> setCellValue("A1", "Item Name");
        $sheet -> setCellValue("B1", "Serial Code");
        $sheet -> setCellValue("C1", "Brand");
        
        while ($row = $statement -> fetch_array()) {
          $sheet -> setCellValue("A" . $i, $row["name"]);
          $sheet -> setCellValue("B" . $i, $row["serial_code"]);
          $sheet -> setCellValue("C" . $i, $row["brand"]);
          $i++;
        }
      }
      break;
    case '2':
      $statement = $conn -> query("SELECT * FROM useraccounts");

      if($statement){
        $i = 2;
    
        $sheet -> setCellValue("A1", "Fullname");
        $sheet -> setCellValue("B1", "Username");
        $sheet -> setCellValue("C1", "Email");
        
        while ($row = $statement -> fetch_array()) {
          $sheet -> setCellValue("A" . $i, $row["fullname"]);
          $sheet -> setCellValue("B" . $i, $row["username"]);
          $sheet -> setCellValue("C" . $i, $row["email"]);
          $i++;
        }
      }

      break;
    case '3':
      $statement = $conn -> query("SELECT * FROM done");

      if($statement){
        $i = 2;
    
        $sheet -> setCellValue("A1", "Request ID");
        $sheet -> setCellValue("B1", "Client Name");
        $sheet -> setCellValue("C1", "Starting Date");
        
        while ($row = $statement -> fetch_array()) {
          $sheet -> setCellValue("A" . $i, $row["requestID"]);
          $sheet -> setCellValue("B" . $i, $row["client_name"]);
          $sheet -> setCellValue("C" . $i, $row["starting_date"]);
          $i++;
        }
      }

      break;
  }

      
  $writer = new Xlsx($spreadsheet);
  $currentDate = date("M-d-Y-his");
  $writer -> save("../files/Kipoint Export".$currentDate.".xlsx");
  echo "<a href='files/Kipoint Export".$currentDate.".xlsx' download>Download File</a>";
  
  $conn -> close();
?>