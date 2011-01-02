<?php
require_once "Mail.class.php";

$mail1 = Mail::with("ales.najmann@gmail.com", "ales.najmann@gmail.com", "gaenetta simple email test", "It's just email test");
// $mail1->send(); // or $mail1();
var_dump($mail1->getMessage()->getSender());
var_dump($mail1->getMessage()->getTo());
var_dump($mail1->getMessage()->getSubject());
var_dump($mail1->getMessage()->getTextBody());

$mail2 = Mail::withArray(array("sender" => "ales.najmann@gmail.com", "to" => array( "ales.najmann@gmail.com" ), 
  "subject" => "gaenetta email from array test", "htmlBody" => "It's just email test"));
// $mail2->send(); // or $mail2();
var_dump($mail2->getMessage()->getSender());
var_dump($mail2->getMessage()->getTo());
var_dump($mail2->getMessage()->getSubject());
var_dump($mail2->getMessage()->getHtmlBody());

$mail3 = Mail::instance();
$mail3->sender = "ales.najmann@gmail.com";
$mail3->to = array("ales.najmann+spam@gmail.com");
$mail3->subject = "gaenetta email from properties test";
$mail3->textBody = "It's just email test";
$mail3->x = "ahoj";
// $mail3->send(); // or $mail3();
var_dump($mail3->getMessage()->getSender());
var_dump($mail3->getMessage()->getTo());
var_dump($mail3->getMessage()->getSubject());
var_dump($mail3->getMessage()->getTextBody());

