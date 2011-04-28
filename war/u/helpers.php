<?php

/**
 * url looks like this:
 * scheme://user:pass@host:port/path?query#fragment
 */
function http_build_url($builder) {
  if (!$builder['host']) return false;
  if (!$builder['scheme']) $builder['scheme'] = 'http';
  $url = $builder['scheme'] . '://';
  if ($builder['user'] && $builder['pass']) $url .= "${builder['user']}:${builder['pass']}@";
  if ($builder['host']) $url .= "${builder['host']}";
  if ($builder['port']) $url .= ":${builder['port']}";
  if ($builder['path']) {
    $path = $builder['path'];
    if (strpos($path, '/') === 0) {
      $url .= "$path";
    } else {
      $url .= "/$path";
    }
  } else {
    $url .= '/'; // TODO: ???
  }
  if ($builder['query']) $url .= "?${builder['query']}";
  if ($builder['fragment']) $url .= "#${builder['fragment']}";
  return $url;
}

/**
 * Redirection builder, it uses http_build_url builder with same schema
 */
function redirect($controller, $action, $params = NULL) {
  $parts['scheme'] = 'http';
  $parts['host'] = $_SERVER['HTTP_HOST'];
  $parts['path'] = "$controller/$action";
  if (isset($params)) {
    if (is_array($params)) {
      $parts['query'] = http_build_query($params);
      $parts['path'] = "$controller/$action";
    } else { // params is identifier
      $parts['path'] = "$controller/$action/$params"; // params hopefully is string or number
    }
  }
  $url = http_build_url($parts);
  header('HTTP/1.1 301 Moved Permanently');  
  header("Location: $url");
  return false; // always return false as it prevents resolving view when it's returned
}
