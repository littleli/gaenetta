<?php
import com.google.appengine.api.taskqueue.QueueFactory;

class TaskQueue {

  static function get($name) {
    if ($name) {
      return QueueFactory::getQueue($name);
    } else {
      return self::getDefault();
    }
  }

  static function getDefault() {
    return QueueFactory::getDefaultQueue();
  }

  static function getOptionBuilder($options = NULL) {
    $builder = java_class("com.google.appengine.api.taskqueue.TaskOptions\$Builder");
    return Util::setOptions($builder, $options);
  }

  static function getRetryOptions($options = NULL) {
    $builder = java_class("com.google.appengine.api.taskqueue.RetryOptions\$Builder");
    return Util::setOptions($builder, $options);
  }

  protected function __construct() {
  }
}
