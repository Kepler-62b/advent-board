<?php

namespace App\Service;

use Dev\Tests\TemplateNavigation;

class RenderViewService
{ // @TODO сделать класс для всех путей и расширений
  private const PHP_EXTANSION = '.php';
  private const EXCEPTIONS_TEMPLATE_PATH = 'src/View/templates/exceptions/';
  private const LAYOUTS_TEMPLATE_PATH = 'src/View/templates/layouts/';
  private const CONTENT_TEMPLATE_PATH = 'src/View/templates/content/';
  private const WIDGETS_TEMPLATE_PATH = 'src/View/templates/widgets/';
  private const VIEW_PATH_MAP = [
    'layouts' => self::LAYOUTS_TEMPLATE_PATH,
    'content' => self::CONTENT_TEMPLATE_PATH,
    'exceptions' => self::EXCEPTIONS_TEMPLATE_PATH,
    'widgets' => self::WIDGETS_TEMPLATE_PATH,
  ];


  private array $template = [];
  private ?array $templateParams = [];
  private ?array $templatesObjects = [];

  public function __construct(array $template, array $templateParams = null, array $templateNavigation = null)
  {
    $this->template = $template;
    $this->templateParams = $templateParams;
    $this->templatesObjects = $templateNavigation;

  }

  public function __toString(): string
  {
    return $this->renderView();
  }

  /**
   * @TODO подумать как можно использовать 
   */
  private function prepareView(object $templates_objects)
  {
    $this->templates_objects[] = $templates_objects;
  }

  public function renderView(): string
  {
    if (!is_null($this->templateParams) && !array_is_list($this->templateParams)) {
      extract($this->templateParams, EXTR_OVERWRITE);
    }

    ob_start();

    require self::VIEW_PATH_MAP[key($this->template)] . current($this->template) . self::PHP_EXTANSION;

    $content = ob_get_clean();

    return $content;

  }

  public function renderViewFromObject()
  {
    var_dump($this->templatesObjects);


    foreach ($this->templatesObjects as $templateNavigation) {


      if (!is_null($templateNavigation->templateParams)) {
        // var_dump($this->templatesObjects[$templateNavigation->templateParams[0]]->template);
        // extract($this->templatesObjects[$templateNavigation->templateParams[0]]->template, EXTR_OVERWRITE);

        // START test code block  --------------------------------------
        // var_dump($templateNavigation);
        // $templateNavigation->templateParams = $this->templatesObjects[$templateNavigation->templateParams];
        // var_dump($templateNavigation);

        
        $templateNavigation->templateParams = $this->templatesObjects[$templateNavigation->templateParams];





        // die;
        // END test code block    --------------------------------------


        // extract($templateNavigation->templateParams, EXTR_OVERWRITE);
      }

      // ob_start();

      // foreach ($templateNavigation->template as $template => $path)
      //   require $path . $template . self::PHP_EXTANSION;

      // $content = ob_get_clean();




    }

    var_dump($templateNavigation);
    die;


    if (is_null($this->templatesObjects[$templateNavigation->templateParams]->templateParams)) {
      ob_start();

      foreach ($this->templatesObjects[$templateNavigation->templateParams]->template as $template => $path)
        require $path . $template . self::PHP_EXTANSION;

      $dependence['navigation'] = ob_get_clean();
      var_dump($dependence);
      die;
    }
    extract($dependence, EXTR_OVERWRITE);
    require $path . $template . self::PHP_EXTANSION;


    // START test code block  --------------------------------------
    // var_dump($this->templatesObjects);

    die;
    // END test code block    --------------------------------------



    return $content;


    // if (!is_null($templateNavigation->templateParams) && !array_is_list($templateNavigation->templateParams)) {
    //   extract($templateNavigation->templateParams, EXTR_OVERWRITE);
    // }
    // ob_start();
    // foreach ($templateNavigation->template as $template => $path)
    //   // var_dump(self::VIEW_PATH_MAP[$key] . $template . self::PHP_EXTANSION);
    //   require $path . $template . self::PHP_EXTANSION;
    // $content = ob_get_clean();

    // return $content;
  }

}