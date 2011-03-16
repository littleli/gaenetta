<?php
/**
 *  Base class for each of validators
 **/
abstract class Validator {

  protected function __construct() {
  }
  /**
   *  Determines whether entire process of validation should continue after subsequent validation failure.
   *  It defaults to 'true'. Override it to change the behaviour.
   **/
  public function canContinue() { 
  	return true;
  }

  /**
   *  Abstract validation functionality. Every child of this class should return true on success and false on failure.
   *  field: string
   *  value: incoming value
   *  result: entire validation process state holder
   */
  abstract public function validate($field, $value, $result);
  
  
  /** 
   *  If this validator is also binding validator, ie. it is able to convert value to any specific php type.
   *  See also function convert(...)
   */
  public function canConvert() { 
  	return false; 
  }
  
  /**
   *  Conversion function
   */
  public function convert($value) { 
  	return $value; 
  }
}
