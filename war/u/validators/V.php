<?php

final class V {

  static function required() { 
    return new RequiredValidator(); 
  }
  
  static function max($max, $optional = false) { 
    return new MaxValidator($max, $optional);
  }
  
  static function min($min, $optional = false) { 
    return new MinValidator($min, $optional);
  }
  
  static function numeric($optional = false) { 
    return new NumericValidator($optional); 
  }
  
  static function range($min, $max, $optional = false) { 
    return new RangeValidator($min, $max, $optional);
  }
  
  static function date($format, $optional = false) { 
    return new DateValidator($format, $optional);
  }
}
