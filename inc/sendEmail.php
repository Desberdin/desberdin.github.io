﻿<?php

// Replace this with your own email address
$siteOwnersEmail = 'info@desberdin.com';


if($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Por favor, inserta tu nombre.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Por favor, introduce una dirección de email válida.";
	}
	// Check Message
	if (strlen($contact_message) < 10) {
		$error['message'] = "Por favor, introduce un mensaje de al menos 10 caracteres.";
	}
   // Subject
	if ($subject == '') { $subject = "Envio de formulario desde el apartado de contacto"; }


   // Set Message
   $message .= "Email de: " . $name . "<br />";
   $message .= "Dirección Email: " . $email . "<br />";
   $message .= "Mensaje: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> Este es un email enviado desde el formulario de contacto de tu página web: www.desberdin.com. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Algo fue mal. Por favor, vuélvelo a intentar."; }
		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>