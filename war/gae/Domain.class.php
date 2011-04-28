<?php
import java.util.logging.Logger;
import com.google.appengine.api.datastore.Entity;
import com.google.appengine.api.datastore.Transaction;
import com.google.appengine.api.datastore.DatastoreService;
import com.google.appengine.api.datastore.DatastoreServiceFactory;
import com.google.appengine.api.datastore.Email;
import com.google.appengine.api.datastore.Text;
import com.google.appengine.api.datastore.Category;
import com.google.appengine.api.datastore.Link;
import com.google.appengine.api.datastore.PhoneNumber;
import com.google.appengine.api.datastore.PostalAddress;
import com.google.appengine.api.datastore.Rating;
import com.google.appengine.api.datastore.ShortBlob;
import com.google.appengine.api.datastore.Blob;
import com.google.appengine.api.datastore.GeoPt;
import com.google.appengine.api.datastore.Key;
import com.google.appengine.api.datastore.KeyFactory;

class Domain {
  
  private static $log = Logger::getLogger(__CLASS__);
  private static $ds = DatastoreServiceFactory::getDatastoreService();
  private static $ads = DatastoreServiceFactory::getAsyncDatastoreService();
  private $entity;

  static function toEmail($value) { return new Email($value); }
  static function toText($value) { return new Text($value); }
  static function toLink($value) { return new Link($value); }
  static function toCategory($value) { return new Category($value); }
  static function toPhoneNumber($value) { return new PhoneNumber($value); }
  static function toPostalAdress($value) { return new PostalAddress($value); }
  static function toRating($value) { return new Rating($value); }
  static function toJID($value) { return new JID($value); }
  static function toGeoPt($latitude, $longitude) { return new GeoPt($latitude, $longitude); }
  static function toBlob($value) { return new Blob($value); }
  static function toShortBlob($value) { return new ShortBlob($value); }
  static function toCollection(&$array, $type = 'java.util.HashSet') { 
    $col = new Java($type, count($array));
  	foreach ($array as $item) { 
  	  $col->add($item);
  	}
  	return $list;
  }

  static function withKind(string $kind) {
    return new Domain(new Entity($kind)); 
  }

  static function withKey(Key $key) {
    return new Domain(new Entity($key));
  }
  
  static function withKeyString($str) {
    $key = self::stringToKey($str);
    if (!$key) {
      self::$log->warning("Key not found by string [$str]");
      return false;
    }
    return self::withKey($key);
  }

  static function withArray($params) {
    $kind = $params["kind"];
    if (!$kind) {
      return false;
    }
    $keyName = $params["keyName"];
    $parent = $params["parent"];
    if ($keyName && $parent) {
      return new Domain(new Entity($kind, $keyName, $parent));
    } elseif ($keyName) {
      return new Domain(new Entity($kind, $keyName));
    } elseif ($parent) {
      return new Domain(new Entity($kind, $parent));
    }
  }
  
  static function query($kind) {
    return new Finder($kind);        
  }
  
  static function stringToKey($str) {
    return KeyFactory::stringToKey($str);
  }
  
  static function stringToEntity($str, $async = false) {
    if ($async) {
      return self::$ads->get(self::stringToKey($str));
    }
    return self::$ds->get(self::stringToKey($str));
  }

  protected function __construct($entity) {
    $this->entity = $entity;
  }
  
  function get() {
    return $this->entity;
  }

  function __get($name) { 
    return $this->entity->getProperty($name);
  }

  function __set($name, $value) {
    if (is_array($value)) {
      $count = count($value);
      $set = new Java('java.util.HashSet', $count);
      for ($i = 0; $i < $count; $i++) {
        $set->add($value[$i]);        
      }
      $this->entity->setProperty($name, $set);
    } else {
      $this->entity->setProperty($name, $value);
    }
  }
  
  function setProperties(&$props) {
    foreach ($props as $prop => $val) {
      $this->entity->setProperty($prop, $val);
    }
  }

  function setUnindexedProperties(&$props) {
    foreach ($props as $prop => $val) {
      $this->entity->setUnindexedProperty($prop, $val);
    }
  }
  
  function save($async = false) {
    if ($async) {
      return self::$ads->put($this->entity);
    }
    return self::$ds->put($this->entity);
  }
   
  function delete($async = false) {
    $keys[] = $this->get()->getKey();
    if ($async) {
      return self::$ads->delete($keys);
    }
    return self::$ds->delete($keys);
  }
  
  function remove($prop) {
    $this->entity->removeProperty($prop);
  }
  
  function keyToString() {
    return KeyFactory::keyToString($this->get()->getKey());
  }
  
  function keyToInteger() {
    return $this->get()->getKey()->getId();
  }
}

