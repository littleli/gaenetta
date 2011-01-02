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

class DSEntity {

  private $entity;	// datastore primitive type
  private static $datastoreService = DatastoreServiceFactory::getDatastoreService();	// datastore service reference

  protected __construct($name) {
    $this->entity = new Entity($name);
  }

  static function instance() {
    return new BaseEntity($name);
  }

  static function withArray($name, $arr) {
    $entity = self::instance($name);
    foreach ($arr as $key => $value) {
      $entity->$key = $value; // do not access by $this->entity, let magic method does the work !!!
    }
  }

  static function withTransaction($transactionBlock) {
    $transaction = self::$datastoreService->beginTransaction();
    try {
      $transactionBlock($transaction);
      $transaction->commit();
    } catch (Exception $e) {
      $transaction->rollback();
      throw $e;
    }
  }

  static function valueAsEmail($value) { return new Email($value); }
  static function valueAsText($value) { return new Text($value); }
  static function valueAsLink($value) { return new Link($value); }
  static function valueAsCategory($value) { return new Category($value); }
  static function valueAsPhoneNumber($value) { return new PhoneNumber($value); }
  static function valueAsPostalAdress($value) { return new PostalAddress($value); }
  static function valueAsRating($value) { return new Rating($value); }
  static function valueAsJID($value) { return new JID($value); }
  static function valuesAsGeoPt($latitude, $longitude) { return new GeoPt($latitude, $longitude); }
  static function valueAsBlob($value) { return new Blob($value); }
  static function valueAsShortBlob($value) { return new ShortBlob($value); }

  function __get($name) { 
    return $this->entity->getProperty($name);
  }

  function __set($name, $value) {
    $this->entity->setProperty($name, $value);
  }

  function save() {
    self::datastoreService->put($this->entity);
  }

  function delete() {
    self::datastoreService->delete($this->entity->getKey());
  }

  function deleteKey($key) {
    self::datastoreService->delete($key);
  }
}
