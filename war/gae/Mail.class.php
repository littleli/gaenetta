<?php
import com.google.appengine.api.mail.MailServiceFactory;
import com.google.appengine.api.mail.MailService;
import java.util.logging.Logger;

class Mail {
  
  private static $messageClass = "com.google.appengine.api.mail.MailService\$Message";
  private static $attachmentClass = "com.google.appengine.api.mail.MailService\$Attachment";
  private static $log = Logger::getLogger(__CLASS__);
  private static $mailService = MailServiceFactory::getMailService();
  private static $allowed_properties = array( "bcc" => 2, "cc" => 2, "htmlBody" => 1, "replyTo" => 1, 
    "sender" => 1, "subject" => 1, "textBody" => 1, "to" => 2, "attachments" => 2 );
  private $message;

  protected function __construct($message) {
    $this->message = $message;
  }

  static function nu() {
    $message = new Java(self::$messageClass);
    return new Mail($message);
  }

  static function with($sender, $to, $subject, $textBody) {
    $message = new Java(self::$messageClass, $sender, $to, $subject, $textBody);
    return new Mail($message);
  }

  static function withArray($arr = NULL) {
    if ($arr && is_array($arr)) {
      $mail = self::nu();
      foreach ($arr as $key => $value) {
        $mail->$key = $value;
      }
      return true;
    } else {
      self::$log->severe("Argument type is not array");
      return false;
    }
  }

  static function newAttachment($filename, $bytes) {
    return new Java(self::$attachmentClass, $filename, $bytes);
  }

  function __set($name, $value) {
    $method = "set" . ucfirst($name);
    $allowed = self::$allowed_properties[$name];
    switch ($allowed) {
    case 1:
      $this->message->$method("$value");
      break;
    case 2:       
      if (is_array($value)) {
        $this->message->$method($value);    
      } else {
        $this->message->$method(array("$value"));
      }
      break;
    default:
      self::$log->warning("Attempt to write value [$value] to non-existent property [$name]");
    }
  }

  function __get($name) {
    $allowed = $allowed_properties[$name];
    if ($allowed) {
      $method = "get" . ucfirst($name);
      return $this->message->$method();
    }
    self::$log->warning("Attempt to read non-existent property [$name]");
    return NULL;      
  }

  function __invoke() {
    self::$mailService->send($this->message);
  }

  function getMessage() {
    return $this->message;
  }

  function send() {
    self::$mailService->send($this->message);
  }

  function sendToAdmins() {
    self::$mailService->sendToAdmins($this->message);
  }
}
