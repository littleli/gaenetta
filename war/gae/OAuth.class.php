<?php
import com.google.appengine.api.oauth.OAuthServiceFactory;

class OAuth {
  private static $oauthService = OAuthServiceFactory::getOAuthService();

  static function currentUser() {
    return self::$oauthService->getCurrentUser();
  }

  static function consumerKey() {
    return self::$oauthService->getOAuthConsumerKey();
  }

  static function isAdmin() {
    return self::$oauthService->isUserAdmin();
  }
}
