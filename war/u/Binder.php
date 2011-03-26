<?php

class Binder {

  private static $log = java_class("java.util.logging.Logger")->getLogger(__CLASS__);
  private $rejected;
  private $accepted;
  private $target;

  public function getRejected() {
    return $this->rejected;
  }

  public function getAccepted() {
    return $this->accepted;
  }
  
  public function getTarget() {
    return $this->target;
  }
  
  protected function __construct(&$target) {
    $this->target = $target;
  	$this->rejected = array();
  	$this->accepted = array();
  }

  public static function bindData(&$target, $mapping, $params) {
    $result = new Binder($target);
    foreach ($mapping as $field => $validators) {
      $result->validateAndBind($target, $field, $validators, $params[$field]);
    }
    return $result;
  }
  
  public function hasErrors() {
  	return count( $this->getRejected() ) > 0;
  }

  public function rejectValue($field, $notice, $rejectedValue) {
    $this->rejected[$field]["notice"][] = $notice;
    if (isset($rejectedValue)) {
      $this->rejected[$field]["value"] = $rejectedValue;
    }
  }

  private function validateAndBind(&$target, $field, $validators, $value) {
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
        $convertedValue = $value; // defaults to string
      }
      if ($convertedValue !== NULL) {
	    $this->bindOnTarget($target, $field, $convertedValue);
	  }
    }
  }

  private function bindOnTarget(&$target, $field, $value) {
    if (is_object($target)) {
      $target->$field = $value;
    } elseif (is_array($target)) {
      $target[$field] = $value;
    } else {
       self::$log->error("Value [$value] could not be bound to field [$field]");
    }
  }
}
