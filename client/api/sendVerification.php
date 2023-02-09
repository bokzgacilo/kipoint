<?php
// require phpmailer
require_once '../../vendor/autoload.php';

// for phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include('connection.php');

$user_email = $_POST['email'];

$checkVerification = $conn -> query("SELECT * FROM useraccounts WHERE email='$user_email'");

if($checkVerification -> num_rows == 0){
  echo 2;
}else {
  while($row = $checkVerification -> fetch_array()){
    if($row['verification_number'] == 0 || $row['status'] == 'Not Registered'){
      sendRegistrationEmail($user_email);
      echo 1;
    }else {
      echo 0;
    }
  }
}

function sendRegistrationEmail($receiver){
  include('connection.php');
  $verificationNumber = rand(100000,999999);

  $conn -> query("UPDATE useraccounts SET verification_number='$verificationNumber' WHERE email='$receiver'");

  $subject = "Registered Successfully";

  $message = "
    This is your verification number: ".$verificationNumber."
  ";

  $mail = new PHPMailer(true);
  
  $mail -> isSMTP();
  $mail -> Host = "smtp.gmail.com";
  $mail -> SMTPAuth = true;
  $mail -> Username = 'kipoint.pinagsama@gmail.com';
  $mail -> Password = 'anhdbeysgzbgevsc';
  $mail -> SMTPSecure = 'ssl';
  $mail -> Port = 465;

  $mail -> setFrom('kipoint.pinagsama@gmail.com', 'Kipoint');

  $mail -> addAddress($receiver);

  $mail -> isHTML(true);
  $mail -> Subject = $subject;
  $mail -> Body = $message;

  $mail -> send();
}

$conn -> close();

?>