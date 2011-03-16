<?php

class Util {
  static function setOptions($builder, $options) {
    if ($options && is_array($options)) {
      foreach ($options as $option => $value) {
        $builder->$option($value);
      }
    }
    return $builder;
  }
}
