<?php
import com.google.appengine.api.taskqueue.QueueFactory;

// TODO: everything
class Tasks {

  static function getQueue($name) {
    return QueueFactory::getQueue($name);
  }

  static function getDefault() {
    return QueueFactory::getDefaultQueue();
  }

  protected function __construct() {
  }


}
