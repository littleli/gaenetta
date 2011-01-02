<?php
import com.google.appengine.api.mail.MailServiceFactory;
import com.google.appengine.api.mail.MailService;

class Mail {
  
  private static $mailService = MailServiceFactory::getMailService();
  private $message;

  protected function __construct($message) {
    $this->message = $message;
  }

  static function nu() {
    $message = new Java("com.google.appengine.api.mail.MailService\$Message");
    $mail = new Mail($message);
    return $mail;
  }

  static function with($sender, $to, $subject, $textBody) {
    $message = new Java("com.google.appengine.api.mail.MailService\$Message", $sender, $to, $subject, $textBody);
    $mail = new Mail($message);
    return $mail;
  }

  /**
   * on error it returns true or non-empty array
   */
  static function withArray($arr = NULL) {
    $message = new Java("com.google.appengine.api.mail.MailService\$Message");
    $errors = array();
    if ($arr && is_array($arr)) {
      foreach ($arr as $key => $value) {
        $method = "set" . ucfirst($key);
        if (method_exists($message, $method)) {
          $message->$method($value);
        } else {
          $errors[$key] = $value;
        }
      }
      if (!$errors) {
        return new Mail($message);
      }
    } else {
      return true;
    }
    return $errors;
  }

  static function newAttachment($filename, $bytes) {
    return new Java("com.google.appengine.api.mail.MailService\$Attachment", $filename, $bytes);
  }

  function __set($name, $value) {
    $method = "set" . ucfirst($name);
    if (method_exists($this->message, $method)) {
      $this->message->$method($value);
    } else {
      exit("Property $name does not exist");
    }
  }

  function __get($name) {
    $method = "get" . ucfirst($name);
    if (method_exists($this->message, $method)) {
      return $this->message->$method();
    } else {
      return NULL;
    }
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
