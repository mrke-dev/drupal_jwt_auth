<?php

namespace Drupal\drupal_jwt_auth\Serializer;

use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;

/**
 * Class JwtDecodeException.
 *
 * @package Drupal\jwt\Trancoder
 */
class JWTSerializerException extends \Exception {

  const DOMAIN            = 1;
  const UNEXPECTED_VALUE  = 2;
  const SIGNATURE_INVALID = 3;
  const BEFORE_VALID      = 4;
  const EXPIRED           = 5;
  const UNKNOWN           = 6;

  /**
   * Construct a new decode exception from a php-jwt exception.
   *
   * @param \Exception $e
   *   The exception to decode.
   *
   * @return JWTSerializerException
   *   The decode exception.
   */
  public static function newFromException(\Exception $e): JWTSerializerException
  {
    switch ($e) {
      case ($e instanceof SignatureInvalidException):
          return new static($e->getMessage(), self::SIGNATURE_INVALID, $e);
      case ($e instanceof BeforeValidException):
          return new static($e->getMessage(), self::BEFORE_VALID, $e);
      case ($e instanceof ExpiredException):
          return new static($e->getMessage(), self::EXPIRED, $e);
      case ($e instanceof \DomainException):
          return new static($e->getMessage(), self::DOMAIN, $e);
      default:
          return new static('Internal Server Error', self::UNKNOWN, $e);
    }
  }
}
