<?php
$to = "olaf.ajax@hotmail.com";
$email = $_REQUEST['email'];
$name = $_REQUEST['name'];
$subject = "Bugreport";
$text = $_REQUEST['Bugreport'];
$message = "From: " . $name . "\nEmail: " . $email . "\n\n" . $text;

$send_mail = mail($to, $subject, $message);

if($send_mail){
echo "Thank You, your bug report has been sent";
}
else{
echo "ERROR something went wrong!";
}
?>