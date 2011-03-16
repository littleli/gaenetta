<?php

final class V {

  static function required() { return new RequiredValidator(); }
  static function max($max) { return new MaxValidator($max); }
  static function min($min) { return new MinValidator($min); }
  static function integer() { return new IntegerValidator(); }
  static function numeric() { return new NumericValidator(); }
  static function decimal() { return new DecimalValidator(); }
  static function range($min, $max) { return new RangeValidator($min, $max); }
  static function date($format) { return new DateValidator($format); }
}
