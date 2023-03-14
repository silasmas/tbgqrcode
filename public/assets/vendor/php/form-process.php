<?php

$EmailTo = "techlabpro7@gmail.com";
$Subject = "New Message Received";

$success = false;
$errorMSG = array();
$first_name = $last_name = $email = $phone=  $message = $subject = null;
$fields = array(
    'first_name' => "First name is required ",
    'last_name' => "Last name is required ",
    'email' => "Email is required ",
    'phone' => "Phone is required ",
    'message' => "Message is required ",
    'subject' => "Subject is required "
);

foreach($fields as $key => $e_message){
    if (empty($_POST[$key])) {
        $errorMSG[] = $e_message;
    } else {
        $$key = $_POST[$key];
    }
}

$name = $first_name ." ". $last_name;

// prepare email body text
$Body = null;
$Body .= "<p><b>Name:</b> {$name}</p>";
$Body .= "<p><b>Email:</b> {$email}</p>";
$Body .= "<p><b>Phone:</b> {$phone}</p>";
$Body .= "<p><b>Subject:</b> {$subject}</p>";
$Body .= "<p><b>Message:</b> </p><p>{$message}</p>";

// send email
$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From:  ' . $name . ' <' . $email .'>' . " \r\n" .
            'Reply-To: '.  $email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

if($name && $email && $message){
    $success = mail($EmailTo, $Subject, $Body, $headers );
}

if(empty($errorMSG)){
    $errorMSG[] = "Something went wrong :(";
}

echo json_encode(array(
    'success' => $success,
    'message' => $errorMSG
));

die();