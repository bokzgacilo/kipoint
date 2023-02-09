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
  echo 0;
}else {
  sendRegistrationEmail($user_email);

  $currentDate = date('F j, Y h:i a');
  $message = 'A temporary password was sent to ' . $user_email;
  $conn -> query("INSERT INTO logs(event, date) VALUES('$message','$currentDate')");

  echo 1;
}

function sendRegistrationEmail($receiver){
  include('connection.php');
  $verificationNumber = rand(100000,999999);

  $conn -> query("UPDATE useraccounts SET temporary_password='temppassword$verificationNumber' WHERE email='$receiver'");

  $subject = "Temporary Password";

  $message = "
    This is your temporary password: <strong>temppassword".$verificationNumber."</strong>
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