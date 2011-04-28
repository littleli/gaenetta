<?php
import com.google.appengine.api.users.UserServiceFactory;

class Users {
  
  private static $userService = UserServiceFactory::getUserService();

  static function loginUrl($destination, $authDomain = NULL, $federatedLogin = NULL, $attributes = NULL) {
    if (!$authDomain && !$federatedLogin && !$attributes) {
      return self::$userService->createLoginUrl($destination);
    } elseif ($authDomain && !$federatedLogin && !$attributes) {
      return self::$userService->createLoginUrl($destination, $authDomain);
    } elseif ($authDomain && $federatedLogin && !$attributes) {
      return self::$userService->createLoginUrl($destination, $authDomain, $federatedLogin);
    } else {
      return self::$userService->createLoginUrl($destination, $authDomain, $federatedLogin, $attributes);
    }
  }

  static function logoutUrl($destination, $authDomain = NULL) {
    if (!$authDomain) {
      return self::$userService->createLogoutUrl($destination);
    } else {
      return self::$userService->createLogoutUrl($destination, $authDomain);
    }
  }

  static function getCurrentUser() {
    return self::$userService->getCurrentUser();
  }

  static function isUserAdmin() {
    return self::$userService->isUserAdmin();
  }

  static function isUserLoggedIn() {
    return self::$userService->isUserLoggedIn();
  }
}
