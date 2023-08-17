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
   * @todo возможно переделать метод, составляя query string не из массива, а из строки
   * @todo возможно переделать метод, используя только объект request
   * @todo сделать фиксированные и приходящие по get параметры qery string
   * @todo сделать выбор для входящих данных из querystring: заданные вручную или приходящие автоматом
   * @todo подумать про вариативность использования в ссылке параметра getBasePath()
   * @todo подумать как использовать этот метод, если нет параметров queryString, а роутинг осуществляется через ЧПУ
   * $queryStringParams = $queryStringParams . $key . '=' . $values; вариант для вормирования URI при использовании ЧПУ
   */
  public static function link(string $internalURI = null, array $bindingParams = null, array $filterParams = null)
  {
    $request = self::$request;

    if (isset($bindingParams)) {
      if (!array_is_list($bindingParams)) {
        $internalURI = $internalURI . '?';
        $bindingParams = http_build_query($bindingParams);
      } else {
        throw new \Exception('arrument $bindingParams must not be a list');
      }
    } else {
      $bindingParams = '';
    }


    if (isset($filterParams)) {
      if ($bindingParams === '') {
        $internalURI = $internalURI . '?';
      }
      $queryStringParams = [];
      foreach ($filterParams as $values) {
        if (filter_has_var(INPUT_GET, $values)) {
          $queryStringParams[$values] = filter_input(INPUT_GET, $values);
          $filterParams = http_build_query($queryStringParams);
          // return $request->getBasePath() . $internalURI . $bindingParams . '&' . $filterParams;
        } else {
          $filterParams = '';
        }
      }
      if($filterParams !== '') {
        $filterParams = '&' . $filterParams;
      }
    }

    // возможно нужна конечная обработка аргументов и приведение к строке
    return $request->getBasePath() . $internalURI . $bindingParams . $filterParams;
  }

  /**
   * @deprecated объеденен с методом link
   */
  public static function filter(string $filter)
  {
    $request = self::$request;
    $params = $request->query;
    var_dump($params);

    foreach ($params as $key => $value) {
      if ($value === $filter) {
        $link[$key] = $value;
        // var_dump($link);
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