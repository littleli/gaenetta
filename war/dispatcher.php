<?php

$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
  case "GET":
    $params = $_GET;
    break;
  case "POST":
    $params = $_POST + $_GET;
    break;
  case "PUT":
    $params = array();
    parse_str(file_get_contents("php://input"), &$params);
    $params = $params + $_GET;
    break;
  case "DELETE":
    $params = $_GET;
    break;
  default:
} // default parameter extracting mechanism

$model = array(
  "action" => $params["action"],
  "controller" => $params["controller"],
  "method" => $method,
  "view" => $params["action"] // default view = action
); // initial model, will be enriched later within user code
if ($params["id"]) $model["id"] = $params["id"];

$c = "c/${model['controller']}.php";
if (file_exists($c)) {
  include "$c";
  $controllerClass = ucfirst($model["controller"]);
  $actionName = $model["action"];
  $controller = new $controllerClass;
  $controller->$actionName($params, $model);
} else {
  printf("Fail");
}
