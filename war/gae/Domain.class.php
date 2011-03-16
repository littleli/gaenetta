<?php
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

class Domain {

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

  static function withKind(string $kind) {
    return new Domain(new Entity($kind)); 
  }

  static function withKey(Key $key) {
    return new Domain(new Entity($key));
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
    $this->entity->setProperty($name, $value);
  }

  function setProperties($props) {
    foreach ($props as $prop => $val) {
      $this->entity->setProperty($prop, $val);
    }
  }

  function setUnindexedProperties($props) {
    foreach ($props as $prop => $val) {
      $this->entity->setUnindexedProperty($prop, $val);
    }
  }
}

