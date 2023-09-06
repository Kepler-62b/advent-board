<?php

namespace App\Service;


class RenderTemplateServise
{ // @TODO сделать класс для всех путей и расширений
  private array $templateRenderStorage = [];
  private array $templateObjectsStorage = [];

  public function __construct(array $templateObjects)
  {
    $this->templateObjectsStorage = $templateObjects;
  }

  /**
   * ОПИСАНИЕ:
   * метод принимает объект TemplateNavigator - должен быть верхним в иерархии "зависимость от переменных", 
   * т.е. зависеть от менее зависимого объекта.
   * 
   *  * объект - шаблон - экземпляр класса TemplateNavigator
   *  * свойство - параметр - свойство templateParams класса TemplateNavigator
   */
  private function templateProcessing(TemplateNavigator $templateObject)
  {
    // проверка объекта на наличие параметров в главном объекте - шаблоне
    if (!is_null($templateObject->templateParams)) {

      // проверка зависимости главного объекта - шаблона по его свойству - параметру от другого объекта - шаблона
      // (проверка зависимости осуществляется с помощью сопоставления значеня свойства - параметра с ключами массива используемых объектов - шаблонов)
      if ($this->templateObjectsStorage[current($templateObject->templateParams)]) {
        // начало рекурсии
        $this->templateObjectProcessing($this->templateObjectsStorage[current($templateObject->templateParams)]);

        // отрисовка из зависимого объекта - шаблона с параметрами или без (проверка условия) и наполнения свойств - параметров главного объекта - шаблона
        // (будет обновлено свойство - параметр главного объекта)
        if (is_null($this->templateObjectsStorage[current($templateObject->templateParams)]->templateParams)) {

          $templateName = $this->templateObjectsStorage[current($templateObject->templateParams)]->templateName;

          ob_start();
          require $this->templateObjectsStorage[current($templateObject->templateParams)]->templateDirectory . $this->templateObjectsStorage[current($templateObject->templateParams)]->templateName . $this->templateObjectsStorage[current($templateObject->templateParams)]->templateExtantion;
          $$templateName = ob_get_clean();

          $templateObject->templateParams = array($templateName => $$templateName);
        } else {
          extract($this->templateObjectsStorage[current($templateObject->templateParams)]->templateParams);

          $templateType = $this->templateObjectsStorage[current($templateObject->templateParams)]->templateType;

          ob_start();
          require $this->templateObjectsStorage[current($templateObject->templateParams)]->templateDirectory . $this->templateObjectsStorage[current($templateObject->templateParams)]->templateName . $this->templateObjectsStorage[current($templateObject->templateParams)]->templateExtantion;
          $$templateType = ob_get_clean();

          $templateObject->templateParams = array($templateType => $$templateType);
        }

        // Проверка свойства - параметра главного объекта - шаблона (после обновления свойства - параметра главного объекта) и распаковка в текущую область видимости
        if (!is_null($templateObject->templateParams)) {
          extract($templateObject->templateParams);
        }

        // Отрисовка главного объекта - шаблона в переменную с именем из свойства объекта - шаблона
        $templateType = $templateObject->templateType;
        ob_start();
        require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtantion;
        $$templateType = ob_get_clean();
        $this->templateRenderStorage[$templateType] = $$templateType;

        // конец рекурсии
      } else {
        // отрисовка из главного объекта - шаблона в переменную с именем из свойства объекта - шаблона, если свойство - параметр присутствует, но значение не имеет зависимости от другого объекта
        var_dump($templateObject);
        extract($templateObject->templateParams);
        $templateName = $templateObject->templateName;

        ob_start();
        require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtantion;
        $$templateName = ob_get_clean();
        $this->templateRenderStorage[$templateName] = $$templateName;
      }
    } else {
      // отрисовка из главного объекта - шаблона в переменную с именем из свойства объекта - шаблона, если свойство - параметр отсутствует
      $templateName = $templateObject->templateName;

      ob_start();
      require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtantion;
      $$templateName = ob_get_clean();
      $this->templateRenderStorage[$templateName] = $$templateName;
    }
  }

  /**
   * returns a string with the rendered template
   */

  public function renderFromDependenciesTemplates(): string
  {
    $templateObject = current($this->templateObjectsStorage);
    $this->templateProcessing($templateObject);

    // временная обработка
    if ($templateObject->templateType === 'widgets') {
      return $this->templateRenderStorage[$templateObject->templateName];
    } else {
      return $this->templateRenderStorage[$templateObject->templateType];
    }
  }

  /**
   * returns a string with the rendered template
   */

  public function renderFromListTemplates(): string
  {
    krsort($this->templateObjectsStorage, SORT_REGULAR);
    foreach ($this->templateObjectsStorage as $templateObject) {
      // @TODO разобраться с проверкой
      if ($templateObject->templateType === 'widgets') {
        $template = $templateObject->templateName;
      } else {
        $template = $templateObject->templateType;
      }

      if (!is_null($templateObject->templateParams)) {
        extract($templateObject->templateParams);
      }
      ob_start();
      require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtantion;
      $$template = ob_get_clean();
    }
    return $$template;
  }

}