<?php
import com.google.appengine.api.memcache.MemcacheServiceFactory;
import com.google.appengine.api.memcache.Expiration;

class Memcache {

  private static $memcacheService = MemcacheServiceFactory::getMemcacheService();
  private static $setPolicy = java_class("com.google.appengine.api.memcache.MemcacheService\$SetPolicy");

  protected function __construct() {
  }

  static function nu() {
    return new Memcache();
  }

  static function stats() {
    $stats = self::$memcacheService->getStatistics();
    return array(
      "bytesReturnedForHits" => $stats->getBytesReturnedForHits(),
      "hitCount" => $stats->getHitCount(),
      "itemCount" => $stats->getItemCount(),
      "maxTimeWithoutAccess" => $stats->getMaxTimeWithoutAccess(),
      "missCount" => $stats->getMissCount(),
      "totalItemBytes" => $stats->getTotalItemBytes()
    );
  }

  function getService() {
    return self::$memcacheService;
  }

  function __get($key) {
    return self::$memcacheService->get($key);
  }

  function __set($key, $value) {
    self::$memcacheService->put($key, $value);
  }

  function put($key, $value, $expiration = NULL, $policy = NULL) {
    if (!$expiration && !$policy) {
      self::$memcacheService->put($key, $value);
    } elseif ($expiration && !$policy) {
      self::$memcacheService->put($key, $value, Expiration::byDeltaSeconds($expiration));
    } else {
      // return true if put succeded with given policy
      return self::$memcacheService->put($key, $value, Expiration::byDeltaSeconds($expiration), self::$setPolicy->valueOf($policy));
    }
  }

}
