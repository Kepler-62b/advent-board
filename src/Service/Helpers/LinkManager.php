<?php

namespace App\Service\Helpers;

use Symfony\Component\HttpFoundation\Request;

final class LinkManager
{
  private static Request $request;

  public function __construct(Request $request)
  {
    self::$request = $request;
  }

  /**
   * @todo возможно переделать метод, используя только объект request
   * @todo сделать выбор для входящих данных из querystring: заданные вручную или приходящие автоматом
   * @todo подумать про вариативность использования в ссылке параметра getBasePath()
   * @todo подумать как использовать этот метод, если нет параметров queryString, а роутинг осуществляется через ЧПУ
   * $queryStringParams = $queryStringParams . $key . '=' . $values; вариант для вормирования URI при использовании ЧПУ
   */
  public static function link(string $internalURI = null, array $inputParams = null): string
  {
    $request = self::$request;
    if (isset($inputParams)) {
      $internalURI = $internalURI . '?';
      $queryStringParams = [];
      foreach ($inputParams as $values) {
        if (filter_has_var(INPUT_GET, $values)) {
          $queryStringParams[$values] = filter_input(INPUT_GET, $values);
        }
      }
      $queryStringParams = http_build_query($queryStringParams);
      return $request->getBasePath() . $internalURI . $queryStringParams;
    } else {
      return $request->getBasePath() . $internalURI;
    }
  }

  public static function filter(string $filter)
  {
    $request = self::$request;
    $params = $request->query;
    foreach ($params as $key => $value) {
      if ($key === $filter) {
        $link = "&" . $key . "=" . $value;
        return $link;
      }
    }
  }

  public static function linkImage(string $storagePath = null, string $imageName = null): string
  {
    $request = self::$request;
    $link = $request->getBasePath() . $storagePath . $imageName;
    return $link;
  }
}