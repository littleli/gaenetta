<?php
import com.google.appengine.api.blobstore.BlobstoreServiceFactory;
import com.google.appengine.api.blobstore.BlobKey;
import com.google.appengine.api.blobstore.ByteRange;

class Blobstore {
  private static $blobstoreService = BlobstoreServiceFactory::getBlobstoreService();
 
  static function createBlob($key) {
    return new BlobKey($key);
  }

  static function createUploadUrl($successPath) {
    return self::$blobstoreService->createUploadUrl($successPath);
  }

  static function delete($blobs) {
    if (is_array($blobs)) {
      self::$blobstoreService->delete($blobs);
    } elseif (is_string($blobs)) {
      self::$blobstoreService->delete(array($blobs));
    }
  }

  static function fetchData($key, $start, $end) {
    return self::$blobService->fetchData(self::createBlob($key), $start, $end);
  }

  static function uploadedBlobs() {
    return self::$blobstoreService->getUploadedBlobs($request); // $request is automatically created by Quercus
  }

  static function serve($blob, $response, $rangeStart = NULL, $rangeEnd = NULL) {
    if (!$rangeStart && !$rangeEnd) {
      self::$blobstoreService->serve($blob, $response);
    } elseif ($rangeStart && !$rangeEnd) {
      $range = new ByteRange($rangeStart);
      self::$blobstoreService->serve($blob, $range, $response);
    } else {
      $range = new ByteRange($rangeStart, $rangeEnd);
      self::$blobstoreService->serve($blob, $range, $response);
    }
  }

  static function serveWithHeader($blob, $response, $rangeHeader) {
    self::$blobstoreService->serve($blob, $rangeHeader, $response);
  }
}
