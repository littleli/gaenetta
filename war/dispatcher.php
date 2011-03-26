<?php

function autoload_classes($classname) {
  $classdirs = array( "gae", "m", "c", "u", "s", "u/validators" );
  foreach ($classdirs as $dir) {
    if (file_exists("$dir/$classname.php")) {
      require_once "$dir/$classname.php";
      break;
    } elseif (file_exists("$dir/$classname.class.php")) {
      require_once "$dir/$classname.class.php";
      break;
    }
  }
}

spl_autoload_register("autoload_classes");

$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
  case "GET":
    $params = $_GET;
    break;
  case "POST":
    $params = $_POST;
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

$model["headers"] = array(
  "HOST" => $_SERVER["HTTP_HOST"],
  "CONNECTION" => $_SERVER["HTTP_CONNECTION"],
  "USER_AGENT" => $_SERVER["HTTP_USER_AGENT"],
  "ACCEPT" => $_SERVER["HTTP_ACCEPT"],
  "ACCEPT_ENCODING" => $_SERVER["HTTP_ACCEPT_ENCODING"],
  "ACCEPT_LANGUAGE" => $_SERVER["HTTP_ACCEPT_LANGUAGE"],
  "ACCEPT_CHARSET" => $_SERVER["HTTP_ACCEPT_CHARSET"]
);

$model["session"] = &$_SESSION;

$controllerClass = ucfirst($model["controller"]) . "Controller";
$actionName = $model["action"];
$controller = new $controllerClass;

$viewModel = $controller->$actionName($params, $model);

$viewResolver = new DefaultViewResolver($params, $model);
$viewResolver->resolve( $viewModel );
