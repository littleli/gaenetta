<?php

abstract class BaseController {

  function __call($name, $arguments) {
    require_once "../404.php";
  }
}
