<?php

namespace App\Controllers;

use App\Service\RenderTemplateService;
use App\Service\RenderViewService;
use App\Service\Template;
use App\Service\ViewRenderService;
use App\Service\Widgets\NavigationWidget;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function homePage(): Response
    {
        $navigationWidget = new Template('navigation', 'widgets');
        $content = new Template('home_page', 'content', ['navigation']);
        $layout = new Template('main', 'layouts', ['content']);
        $view = (new RenderTemplateService([$layout, $content, $navigationWidget]))->renderFromListTemplates();

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
        $navigationWidget = new Template('navigation', 'widgets');
        $content = new Template('not_found_page', 'content', ['navigation']);
        $layout = new Template('main', 'layouts', ['content']);
        $view = (new RenderTemplateService([$layout, $content, $navigationWidget]))->renderFromListTemplates();

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