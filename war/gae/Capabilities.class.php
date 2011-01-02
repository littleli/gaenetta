<?php
import com.google.appengine.api.capabilities.Capability;
import com.google.appengine.api.capabilities.CapabilitiesServiceFactory;

class Capabilities {
  
  private static $capabilitiesService = CapabilitiesServiceFactory::getCapabilitiesService();
  private static $capabilities = array(
    "BLOBSTORE" => Capability::BLOBSTORE,
    "DATASTORE" => Capability::DATASTORE,
    "DATASTORE_WRITE" => Capability::DATASTORE_WRITE,
    "IMAGES" => Capability::IMAGES,
    "MAIL" => Capability::MAIL,
    "MEMCACHE" => Capability::MEMCACHE,
    "TASKQUEUE" => Capability::TASKQUEUE,
    "URL_FETCH" => Capability::URL_FETCH,
    "XMPP" => Capability::XMPP
  );

  static function all() {
    foreach (self::$capabilities as $key => $value) {
      $status[$key] = self::status($key);
    }
    return $status;
  }

  static function status($capability) {
    $status = self::$capabilitiesService->getStatus(self::$capabilities[$capability]);
    $value["status"] = $status->getStatus();
    $scheduled_date = $status->getScheduledDate();
    if ($scheduled_date) {
      $value["maintenance"] = $scheduled_date->getTime() / 1000; // timestamp (seconds since 1970-01-01)
    }
    return $value;
  }
}
