<?php
require_once '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmailReceipt($requestID, $email, $receiver){

  $subject = "Your event is now ready to serve.";

  $message = "
    Hi $receiver!<br><br>
    Your event for <strong>$requestID</strong> is now ready to served. <br><br>
    Show this email to the Barangay Official assigned to facilitate your event. <br><br>
    Thank you.<br><br>
    
    If you have a concern please email us on: <a href='mailto:kipoint.pinagsama@gmail.com'>Kipoint Pinagsama Team</a><br><br>

    <strong>This an automated email. Do Not Reply</strong>
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

  $mail -> addAddress($email);

  $mail -> isHTML(true);
  $mail -> Subject = $subject;
  $mail -> Body = $message;

  $mail -> send();
}

function informUser($email, $receiver){

  $subject = "Your event is now ready to serve.";

  $message = "
    Hi $receiver!<br><br>
    You are added to Kipoint's database. You can now register to Kipoint. <br><br>
    Thank you.<br><br>
    
    If you have a concern please email us on: <a href='mailto:kipoint.pinagsama@gmail.com'>Kipoint Pinagsama Team</a><br><br>

    <strong>This an automated email. Do Not Reply!</strong>
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

  $mail -> addAddress($email);

  $mail -> isHTML(true);
  $mail -> Subject = $subject;
  $mail -> Body = $message;

  $mail -> send();
}

?>