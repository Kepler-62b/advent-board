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

  public function __toString(): string
  {
    return $this->render();
  }

  public function getProps()
  {
    return $this->templateObjectsStorage;
  }


  /**
   * ОПИСАНИЕ:
   * метод принимает объект TemplateNavigator - должен быть верхним в иерархии "зависимость от переменных", 
   * т.е. зависеть от менее зависимого объекта.
   * 
   *  * объект - шаблон - экземпляр класса TemplateNavigator
   *  * свойство - параметр - свойство templateParams класса TemplateNavigator
   */
  private function templateObjectProcessing(TemplateNavigator $templateObject)
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

  public function render()
  {
    $templateObject = current($this->templateObjectsStorage);
    $this->templateObjectProcessing($templateObject);

    // временная обработка
    if ($templateObject->templateType === 'widgets') {
      return $this->templateRenderStorage[$templateObject->templateName];
    } else {
      return $this->templateRenderStorage[$templateObject->templateType];
    }

  }

  /**
   * метод принимает объект и ищет в свойствах вложенные объекты и обрабатывает их
   */
  public function renderViewFromAttachmentsObject()
  {
    foreach ($this->templateObjectsStorage as $templateObject) {
      var_dump($templateObject);
      if (!is_null($templateObject->templateParams) && !array_is_list($templateObject->templateParams)) {
        foreach ($templateObject->templateParams as $templateSubObject) {
          if (!is_null($templateSubObject->templateParams) && !array_is_list($templateSubObject->templateParams)) {
            extract($templateObject->templateParams, EXTR_OVERWRITE);
          }
          ob_start();
          require $templateSubObject->templateDirectory . $templateSubObject->templateName . $templateSubObject->templateExtantion;

          $content = $templateSubObject->templateName;
          $$content = ob_get_clean();
        }
      }
      ob_start();
      require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtantion;
      $content = ob_get_clean();
      return ($content);
    }

  }

  public function renderViewFromArrayObjects()
  {
    $templateObject = current($this->templateObjectsStorage);

    if (!is_null($templateObject->templateParams)) {
      $templateSubObject = $this->templateObjectsStorage[current($templateObject->templateParams)];
      if (!is_null($templateSubObject->templateParams)) {
        $templateSubSubObject = $this->templateObjectsStorage[current($templateSubObject->templateParams)];
        ob_start();
        require $templateSubSubObject->templateDirectory . $templateSubSubObject->templateName . $templateSubSubObject->templateExtantion;
        $content = current($templateSubObject->templateParams);
        $$content = ob_get_clean();
      }
      ob_start();
      require $templateSubObject->templateDirectory . $templateSubObject->templateName . $templateSubObject->templateExtantion;
      $content = current($templateObject->templateParams);
      $$content = ob_get_clean();
    }
    ob_start();
    require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtantion;
    $content = $templateObject->templateName;
    $$content = ob_get_clean();

    return ($$content);
  }

}