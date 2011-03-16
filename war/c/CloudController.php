<?php

class CloudController extends BaseController {

  //cloud/status
  public function status($params, &$model) {
  	if ($_SESSION["sid"]) $sid = $_SESSION["sid"];
  	if (!$sid) $_SESSION["sid"] = rand(1, 10);
    $model["capabilities"] = Capabilities::all();
  }
  
  public function status_json($params, &$model) {
    $model["capabilities"] = Capabilities::all();
  }
}
