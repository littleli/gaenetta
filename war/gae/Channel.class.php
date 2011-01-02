<?php
import com.google.appengine.api.channel.ChannelServiceFactory;
import com.google.appengine.api.channel.ChannelMessage;

class Channel {

  private static $channelService = ChannelServiceFactory::getChannelService();
  private $token = null;

  static function with($clientId) {
    return new Channel($clientId);    
  }

  protected function __construct($clientId) {
    $this->token = self::$channelService->createChannel($clientId);
  }

  function sendMessage($clientId, $message) {
    $channel_message = new ChannelMessage($clientId, $message);
    return self::$channelService->sendMessage($channel_message);
  }

  function parseMessage() {
    $message = self::$channelService->parseMessage($request); // NOTE: $request is automatically created by Quercus (I hope)
    return array( "clientId" => $message->getClientId(), "message" => $message->getMessage() );
  }
}
