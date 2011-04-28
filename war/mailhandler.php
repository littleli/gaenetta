<?php
header("Content-type: text/plain;charset=UTF-8");

$utf = 'UTF-8';
$postdata = file_get_contents('php://input');
$jbytearraystream = new Java('java.io.ByteArrayInputStream', $postdata);
$jproperties = new Java('java.util.Properties');
$jproperties->put('mail.mime.charset', $utf);
$jsession = java_class('javax.mail.Session')->getDefaultInstance($jproperties, NULL);
$jmimemsg = new Java('javax.mail.internet.MimeMessage', $jsession, $jbytearraystream);

$msg = $jmimemsg->reply(false); // new Java('javax.mail.internet.MimeMessage', $jsession);
$msg->setFrom(new Java('javax.mail.internet.InternetAddress', 'support@gaenetta.appspotmail.com', 'Test Office'));
$msg->setSubject(iconv("utf-8", "utf-8", "Pokus ěščřžýáé"), $utf);
$msg->setText(iconv("utf-8", "utf-8", "Čůráci největší"), $utf);
$transport = java_class('javax.mail.Transport');
$transport->send($msg);

//$mimeutility = java_class('javax.mail.internet.MimeUtility');

// $newmsg = new Java('javax.mail.internet.MimeMessage', $jsession);
// $newmsg->setHeader('Content-Encoding', 'UTF-8');
// $newmsg->setFrom(new Java('javax.mail.internet.InternetAddress', 'support@gaenetta.appspotmail.com', 'Test Office'));
// $newmsg->setSubject('Třitisíce žemliček', 'UTF-8');
// $newmsg->setText('Třitisíce žemliček', 'UTF-8');
// $newmsg->addRecipients('TO', 'ales.najmann@gmail.com');

// require_once "gae/Mail.class.php";

// $mail = Mail::with("support@gaenetta.appspotmail.com", "ales.najmann@gmail.com", "Rušička rádiových vln", "Jen tělo zprávičky");
// $mail->send();
