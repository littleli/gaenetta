<?php
require_once "UrlFetch.class.php";

$response = UrlFetch::get("http://m.google.cz", array( "async" => 1 ));
echo $response->get()->getContent();


