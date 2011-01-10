<?php
import com.google.appengine.api.urlfetch.HTTPResponse;
import com.google.appengine.api.urlfetch.URLFetchService;
import com.google.appengine.api.urlfetch.URLFetchServiceFactory;
import com.google.appengine.api.urlfetch.HTTPRequest;
import com.google.appengine.api.urlfetch.HTTPMethod;
import com.google.appengine.api.urlfetch.FetchOptions;
import com.google.appengine.api.urlfetch.HTTPHeader;
import java.util.logging.Logger;

class ResponseResult {
  private $result;
  function __construct($result) { $this->result = $result; }
  function get() {
    if ($this->result == NULL) {
      return NULL;
    } elseif (is_string($this->result)) { // Result is string
      return $this->result;
    } else {                              // Result is promise
      return $this->result->get();
    }
  }
}

class UrlFetch {
  
  static function get($url, $options = array()) {
    return self::fetch($url, "GET", $options);
  }

  static function post($url, $options = array() ) {
    return self::fetch($url, "POST", $options);
  }

  static function put($url, $options = array()) {
    return self::fetch($url, "PUT", $options);
  }

  static function delete($url, $options = array()) {
    return self::fetch($url, "DELETE", $options);
  }

  static function head($url, $options = array()) {
    return self::fetch($url, "HEAD", $options);
  }

  private static $httpMethodEnum = java_class("com.google.appengine.api.urlfetch.HTTPMethod");
  private static $log = Logger::getLogger(__CLASS__);

  private static function fetch($url, $method, $options) {
    $fetchService = URLFetchServiceFactory::getURLFetchService();
    $fetch_options = java_class("com.google.appengine.api.urlfetch.FetchOptions\$Builder")->withDefaults();

    foreach ($options as $option => $value) {
      switch ( $option ) {
      case "allowTruncate": 
        if ($value) {
          $fetch_options->allowTruncate();
        } else {
          $fetch_options->disalowTruncate();
        }
        break;
      case "followRedirects":
        if ($value) {
          $fetch_options->followRedirects();
        } else {
          $fetch_options->doNotFollowRedirects();
        }
        break;
      case "deadline": 
        $fetch_options->deadline = $value;
        break;
      case 'headers':
      case 'payload':
      case 'params':
      case 'async':
        break;
      default:
        self::$log->severe("Unknown fetch option: $key");
        return new ResponseResult(NULL); // we returned NULL as response
      }
    }

    if ( $options["params"] ) {
      $encoded_params = http_build_query( $options["params"] );
      if ($method == "POST") {
        $options["headers"]["Content-type"] = "application/x-www-form-urlencoded";
        $options["payload"] = $encoded_params; 
      } else {
        $url = "${url}?${encoded_params}";
      }
    }

    $request = new Java("com.google.appengine.api.urlfetch.HTTPRequest", 
                  new Java("java.net.URL", $url), 
                  self::$httpMethodEnum->valueOf($method), $fetch_options);

    if ( $options["headers"] ) {
      foreach ($options["headers"] as $header => $value) {
        $request->addHeader(new Java("com.google.appengine.api.urlfetch.HTTPHeader", $header, $value));
      }
    }

    if ( $options["payload"] ) {
      $request->setPayload($options["payload"]);
    }

    if ( $options["async"] ) {
      return new ResponseResult($fetchService->fetchAsync($request));
    } else {
      return new ResponseResult($fetchService->fetch($request));
    }
  }
}

