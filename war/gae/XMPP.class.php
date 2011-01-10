<?php
import com.google.appengine.api.xmpp.MessageType;
import com.google.appengine.api.xmpp.XMPPServiceFactory;
import java.util.logging.Logger;

class XMPP {

  private static $log = Logger::getLogger(__CLASS__);
  private $xmpp;

  static function nu() {
    $this->xmpp = XMPPServiceFactory::getXMPPService();
  }

  /**
    PARAMETERS PROTOCOL:
    array(
      "type" => "CHAT" | "ERROR" | "GROUPCHAT" | "HEADLINE" | "NORMAL",
      "xml" => true | false,
      "body" => "body",
      "jid" => "some jid",
      "recipients" => "jid1" | array("jid1", "jid2", "jid3")
    );
   */
  private static function buildMessage($parameters = array()) {
    if ($parameters && is_array($parameters) && strlen($parameters) > 0) {      
      $builder = new Java("com.google.appengine.api.xmpp.MessageBuilder");
      if ($parameters["type"]) {
        $builder->withMessageType(MessageType::valueOf($parameters["type"]));
      }
      if ($parameters["xml"]) {
        $builder->asXml($parameters["xml"]);
      }
      if ($parameters["body"]) {
        $builder->withBody($parameters["body"]);
      }
      if ($parameters["jid"]) {
        $builder->withFromJid($parameters["jid"]);
      }
      if ($parameters["recipients"]) {
        $recipients = $parameters["recipients"];
        if (is_array($recipients)) {
          $builder->withRecipientJids($recipients);
        } else {
          $builder->withRecipientJids(array($recipients));
        }
      }
      return $builder->build();
    } else {
      self::$log->severe("Invalid builder parameters");
      return NULL;
    }    
  }

  private static function JID($jid) {
    return new Java("com.google.appengine.api.xmpp.JID", $jid);
  }

  function getPresence($jid) {
    return $this->xmpp->getPresence(self::JID($jid))->isAvailable();
  }

  function getPresenceFromBot($jid, $bot) {
    return $this->xmpp->getPresence(self::JID($jid), self::JID($bot))->isAvailable();
  }

  function _parseMessage() {
    $this->xmpp->parseMessage($request); // implicit variable $request configured by Quercus
  }

  function sendInvitation($jid) {
    $this->xmpp->sendInvitation(self::JID($jid));
  }

  function sendInviationFromBot($jid, $bot) {
    $this->xmpp->sendInvitation(self::JID($jid), self::JID($bot));
  }

  function sendMessage($parameters) {
    $message = self::buildMessage($parameters);
    if (!$message) {
      return array();
    }
    $sendResponse = $this->xmpp->sendMessage($message);
    $statusMap = $sendResponse->getStatusMap();
    foreach ($statusMap as $JID => $STATUS) { // TODO: this may not be necesary
      $jid = $JID->getId();
      $status = $STATUS->toString();
      $result[$jid] = $status;
    }
    return $result;
  }
}
