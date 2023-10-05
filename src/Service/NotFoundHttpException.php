<?php

namespace App\Service;

use App\Service\Widgets\NavigationWidget;
use App\Service\Widgets\GetFormWidget;
use Symfony\Component\HttpFoundation\Response;

class NotFoundHttpException extends \Exception
{
    private ?string $params;

    /**
     * @TODO передавать парраметры массивом
     */
    public function __construct(string $message, string $params = null)
    {
        parent::__construct($message . ' ' . $params);
        $this->params = $params;
        $this->notFound();
    }

    /** @TODO настраивать надпись в шаблоне */
    public function notFound(): Response
    {
        // @TODO подумать, куда это убрать (в отдельный класс с конфигами?) или устанавливать константой
        ini_set('display_errors', 'Off');

        $navigationWidget = (new NavigationWidget('navigation_dashboard_bootstrap'))->getTemplate();
        $getFormWidget = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();

        $content = new Template('page_not_found_exception', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');

        $view = (new RenderTemplateService([$layout, $content, $getFormWidget, $navigationWidget]))->renderFromListTemplates();

        return (new Response())
            ->setContent($view)
            ->setStatusCode(Response::HTTP_NOT_FOUND)
            ->send();
    }


}