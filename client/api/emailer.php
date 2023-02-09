<?php
// require phpmailer
require_once '../../vendor/autoload.php';
// for phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmailReceipt($requestID, $receiver){
  include('connection.php');

  $subject = "Registered Successfully";

  $sql = "SELECT * FROM requests WHERE requestID='$requestID'";
  $result = $conn -> query($sql);
  
  $message = '';
  
  while($row = $result -> fetch_array()){
    $message = "
      Hi ".$row['client_name']."!<br><br>
      Your event for ".$row['requestID']." is now ready to served. <br>
      Show this email to the Barangay Official assigned to facilitate your event. <br><br>
      Thank you.<br><br>
      

      <strong>This a an automated email. Do Not Reply</strong>
      Kipoint Team <a href='kipoint.pinagsama@gmail.com'></a>
    ";
  }
  
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
  $conn -> close();
}

?>