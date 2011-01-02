<?php
require_once "Memcache.class.php";

$cache = Memcache::nu();
$cache->hodnota1 = "neco";
$cache->hodnota2 = 1200;

$hodnota3 = $cache->hodnota2;
var_dump($hodnota3);

$hodnota4 = $cache->nenitam;
var_dump($hodnota4);

var_dump(Memcache::stats());
