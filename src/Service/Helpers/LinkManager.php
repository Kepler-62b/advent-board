<?php

namespace App\Service\Helpers;

use App\Service\Widgets\WidgetInterface;
use Symfony\Component\HttpFoundation\Request;

final class LinkManager
{
    private static Request $request;

    public function __construct(Request $request)
    {
        self::$request = $request;
    }

    /**
     * @TODO возможно переделать метод, составляя query string не из массива, а из строки
     * @TODO возможно переделать метод, используя только объект request
     * @TODO сделать фиксированные и приходящие по get параметры query string
     * @TODO сделать выбор для входящих данных из querystring: заданные вручную или приходящие автоматом
     * @TODO подумать про вариативность использования в ссылке параметра getBasePath()
     * @TODO подумать как использовать этот метод, если нет параметров queryString, а роутинг осуществляется через ЧПУ
     * $queryStringParams = $queryStringParams . $key . '=' . $values; вариант для формирования URI при использовании ЧПУ
     */
    public static function link(string $internalURI = null, array $bindingParams = null, array $externalParams = null)
    {
        $request = self::$request;

        if (isset($bindingParams)) {
            if (!array_is_list($bindingParams)) {
                $internalURI = $internalURI . '?';
                $bindingParams = http_build_query($bindingParams);
            } else {
                throw new \Exception('argument $bindingParams must not be a list');
            }
        } else {
            $bindingParams = '';
        }


        if (isset($externalParams)) {
            if ($bindingParams === '') {
                $internalURI = $internalURI . '?';
            }
            $queryStringParams = [];
            foreach ($externalParams as $values) {
                if (filter_has_var(INPUT_GET, $values)) {
                    $queryStringParams[$values] = filter_input(INPUT_GET, $values);
                    $externalParams = http_build_query($queryStringParams);
                    // return $request->getBasePath() . $internalURI . $bindingParams . '&' . $externalParams;
                } else {
                    $externalParams = '';
                }
            }
            if ($externalParams !== '') {
                $externalParams = '&' . $externalParams;
            }
        }
        // возможно нужна конечная обработка аргументов и приведение к строке
        return $request->getBasePath() . $internalURI . $bindingParams . $externalParams;
    }

    /** @deprecated не использовать (объеденен с методом link) */
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

    public static function widget(WidgetInterface $widget)
    {
        $reflection = new \ReflectionClass($widget);
        $propsStorage = [];
        foreach ($reflection->getProperties() as $prop) {
            $propsStorage[$prop->getName()] = $prop->getValue($widget);
        }

        for ($i = 1; $i <= $propsStorage['sampleLimit']; $i++) {
            $link = self::link('/show', [$propsStorage['divider'] => $i], $propsStorage['filter']);
            $storageLinks[] = "<a href=\"${link}\">${i}</a>";
        }

        for ($i = 1; $i <= count($storageLinks); $i++) {
            $codeBlock = "<div>{pagination}</div>";
            $replace['{pagination}'] = implode(' ', $storageLinks);
            $codeBlock = strtr($codeBlock, $replace);
        }
        return $codeBlock;
    }

    public static function returnReferenceLink()
    {
        return self::$request->headers->get('referer');
    }

}