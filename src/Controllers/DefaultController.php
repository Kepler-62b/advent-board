<?php

namespace App\Controllers;

use Framework\Services\RenderTemplateService;
use Framework\Services\Template;
use Framework\Services\Widgets\GetFormWidget;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function homePage(): Response
    {
        $navigationWidget = new Template('w_navigation_bootstrap', 'widgets');
        $formGetWidget = (new GetFormWidget('w_form_get_bootstrap'))->getTemplate();
        $content = new Template('c_home_page', 'content');
        $layout = new Template('l_main_page_dashboard_bootstrap', 'layouts');
        $view = (new RenderTemplateService([$layout, $content, $formGetWidget, $navigationWidget]))->renderFromListTemplates();

        return (new Response())
            ->setContent($view)
            ->setStatusCode(Response::HTTP_OK)
            ->send();
    }

    public function notFound(): Response
    {
        $navigationWidget = new Template('w_navigation_bootstrap', 'widgets');
        $formGetWidget = (new GetFormWidget('w_form_get_bootstrap'))->getTemplate();
        $content = new Template('ce_not_found_page', 'content');
        $layout = new Template('l_main_page_dashboard_bootstrap', 'layouts');
        $view = (new RenderTemplateService([$layout, $content, $formGetWidget, $navigationWidget]))->renderFromListTemplates();

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

    /** принимает данные из модели */
    public function render()
    {
        
    }

}