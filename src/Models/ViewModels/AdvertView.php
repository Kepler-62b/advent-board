<?php

namespace App\Models\ViewModels;

use App\Models\Advert;
use Framework\Services\HydratorService;
use Framework\Services\RenderTemplateService;
use Framework\Services\Template;
use Framework\Services\Widgets\GetFormWidget;
use Framework\Services\Widgets\NavigationWidget;
use Framework\Services\Widgets\PaginationWidget;
use Framework\Services\Widgets\SortWidget;
use Framework\Services\Widgets\TableWidget;

class AdvertView
{
    public function displayAll(array $params): string
    {
        extract($params);

        $navigationWidget = (new NavigationWidget('w_navigation_bootstrap'))->getTemplate();
        $getFormWidget = (new GetFormWidget('w_form_get_bootstrap'))->getTemplate();
        $paginationWidget = (new PaginationWidget('w_pagination_array_bootstrap', ['totalCount' => $count], ['sampleLimit' => 10]))->getTemplate();
        $tableWidget = (new TableWidget(
            'w_table_adverts_bootstrap',
            [
                'Id',
                'Item',
                'Description',
                new SortWidget('w_sort_bootstrap', 'Price', 'price'),
                'Image',
                new SortWidget('w_sort_bootstrap', 'Created', 'created_date')
            ],
            ['adverts' => $data]
        ))->getTemplate();

        $content = new Template('c_show_page_adverts_bootstrap', 'content');
        $layout = new Template('l_main_page_dashboard_bootstrap', 'layouts');

        return (new RenderTemplateService(
            [
                $layout, $content, $tableWidget, $paginationWidget, $getFormWidget, $navigationWidget
            ]
        ))->renderFromListTemplates();
    }

    public function displayById(array $params): string
    {
        extract($params);

        $navigationWidget = (new NavigationWidget('w_navigation_bootstrap'))->getTemplate();
        $getFormWidget = (new GetFormWidget('w_form_get_bootstrap'))->getTemplate();

        $tableWidget = (
            new TableWidget(
                'w_table_adverts_bootstrap',
                [
                    'id' => 'Id',
                    'item' => 'Item',
                    'description' => 'Description',
                    'price' => 'Price',
                    'image' => 'Image',
                    'created_date' => 'Date'
                ],
                ['adverts' => $data],
            ))->getTemplate();

        $content = new Template('c_get_page_bootstrap', 'content');
        $layout = new Template('l_main_page_dashboard_bootstrap', 'layouts');

        return (new RenderTemplateService([$layout, $content, $tableWidget, $getFormWidget, $navigationWidget]))
            ->renderFromListTemplates();
    }

    public function displayForm(string $formTemplateName): string
    {
        $navigationWidget = (new NavigationWidget('w_navigation_bootstrap'))->getTemplate();
        $formGetWidget = (new GetFormWidget('w_form_get_bootstrap'))->getTemplate();
        $content = new Template($formTemplateName, 'content');
        $layout = new Template('l_main_page_dashboard_bootstrap', 'layouts');

        return (new RenderTemplateService([$layout, $content, $formGetWidget, $navigationWidget]))->renderFromListTemplates();
    }

}