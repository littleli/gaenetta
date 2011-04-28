<?php

class Binder {

  private static $log = java_class('java.util.logging.Logger')->getLogger(__CLASS__);
  private $rejected;
  private $accepted;
  private $target;
  private $params;

  function getRejected() {
    return $this->rejected;
  }

  function getAccepted() {
    return $this->accepted;
  }
  
  function getTarget() {
    return $this->target;
  }

  function getParams() {
    return $this->params;
  }
  
  protected function __construct(&$target, &$params) {
    $this->target = $target;
    $this->params = $params;
    $this->rejected = array();
    $this->accepted = array();
  }

  static function bind(&$target, $mapping, $params) {
    self::$log->info("Help me");
    $result = new Binder($target, $params);
    foreach ($mapping as $field => $validators) {
      $result->validateAndBind($field, $validators, $params[$field]);
    }
    return $result;
  }
  
  static function isNewForm(&$binder) {
    return $binder == NULL;
  }
  
  static function isErrorForm(&$binder) {
    return isset($binder) ? $binder->hasErrors() : false;
  }
    
  function hasErrors() {
  	return count( $this->rejected ) > 0;
  }

  function rejectValue($field, $notice, $rejectedValue) {
    $this->rejected[$field]["notice"][] = $notice;
    if (isset($rejectedValue)) {
      $this->rejected[$field]["value"] = $rejectedValue;
    }
  }

  private function validateAndBind($field, $validators, $value) {
    $allValid = true;
    $bindingValidator = false;

    foreach ($validators as $validator) {
      $valid = $validator->validate($field, $value, $this);
      $cont = $validator->canContinue();
      if ($valid) {
      	if ($validator->canConvert()) {
      	  $bindingValidator = $validator;
      	}
      } else {
        $allValid = false;
        if (!$cont) break; // exit validator and binding chain
      }
    }

    if ($allValid) {
      $this->accepted[$field] = $value;
      if ($bindingValidator) {
        $convertedValue = $bindingValidator->convert($value);
      } else {
        $convertedValue = $value; // defaults to string, no binding validator found in chain
      }
      if ($convertedValue != NULL) {
	    $this->bindOnTarget($field, $convertedValue);
      }
    }
  }

  private function bindOnTarget($field, $value) {
    if (is_object($this->target)) {
      $this->target->$field = $value;
    } elseif (is_array($this->target)) {
      $this->target[$field] = $value;
    } else {
      self::$log->error("Value [$value] could not be bound to field [$field]");
    }
  }
  
  function markRejected(&$attributes) {
    if ($this->hasErrors()) {
      $name = $attributes['name'];
      $rejectedField = $this->rejected[$name];
      if ($rejectedField) {
        $attributes['value'] = $rejectedField['value'];
        $class = $attributes['class'];
        if ($class) {
          $attributes['class'] = "$class error";
        } else {
          $attributes['class'] = 'error';
        }
      }
    }
    return $attributes;
  }
}
