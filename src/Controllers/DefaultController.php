<?php

namespace App\Controllers;

use App\Service\RenderTemplateService;
use App\Service\RenderViewService;
use App\Service\Template;
use App\Service\ViewRenderService;
use App\Service\Widgets\GetFormWidget;
use App\Service\Widgets\NavigationWidget;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function homePage(): Response
    {
        $navigation = new Template('navigation_dashboard_bootstrap', 'widgets');
        $formGet = (new GetFormWidget('form_get_dashboard_bootstrap'))->getTemplate();
        $content = new Template('home_page', 'content');
        $layout = new Template('main_dashboard_bootstrap', 'layouts');
        $view = (new RenderTemplateService([$layout, $content, $formGet, $navigation]))->renderFromListTemplates();

        return (new Response())
            ->setContent($view)
            ->setStatusCode(Response::HTTP_OK)
            ->send();
    }

    /**
     * @todo добавить картинку в контент страницы
     */
    public function notFound(): Response
    {
        $navigation = new Template('navigation_bootstrap', 'widgets');
        $content = new Template('not_found_page', 'content');
        $layout = new Template('main', 'layouts');
        $view = (new RenderTemplateService([$layout, $content, $navigation]))->renderFromListTemplates();

        return (new Response())
            ->setContent($view)
            ->setStatusCode(Response::HTTP_NOT_FOUND)
            ->send();
    }

    public function apiRaw($data = null): Response
    {
        $data = json_encode($data);

        $response = new Response(
            $data,
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
        return $response->send();

    }

}