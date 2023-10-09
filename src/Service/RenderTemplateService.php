<?php

namespace App\Service;

class RenderTemplateService
{
    // @TODO сделать класс для всех путей и расширений
    private array $templateObjectsStorage = [];

    public function __construct(array $templateObjects)
    {
        $this->templateObjectsStorage = $templateObjects;
    }

    /**
     * Подготовка к отрисовке:
     * Метод принимает список объектов Template.
     * Объекты должны передаваться определятся в списке в следующем порядке - по степени зависимости от других объектов, где первый - самый зависимый, последний - менее зависимый.
     * Объекты, не зависящие от других передаются в самом конце - последовательность таких объектов не важна при передаче.
     * Массив объектов сортируется - от последнего, менее зависимого, к первому, более зависимому.
     * Каждый объект из массива содержит поля:
     *  - название файла-шаблона;
     *  - расширение файла-шаблона;
     *  - тип файла-шаблона (соответствует названию директории, в которой находится файл-шаблон);
     *  - директория файла-шаблона (путь к директории в которой находится файл-шаблон, для его подключения);
     *  - дополнительные параметры - ассоциативный массив, где ключ - название переменной, используемой в файле-шаблоне,
     *      а значение - значение переменной, используемой в файле-шаблоне.
     *
     * Отрисовка - перебор массива объектов Template:
     * Создается локальная переменная, содержащая название файла-шаблона.
     * Если в объекте Template есть поле с ассоциативным массивом параметров -
     * они экспортируются в текущую область видимости в виде переменных и будут доступны в файле-шаблоне (опционально).
     * Включается буферизация вывода.
     * Подключается файл с файлом-шаблоном - параметры подключения берутся из полей объекта Template.
     * Определяется переменная с названием, соответствующим названию файла-шаблона. Результат буферизации вывода помещается в данную переменную.
     *
     * В результате прохода по всем объектам Template будет создана переменная с самым зависимым файлом-шаблоном и значение переменной будет возвращено из метода
     */
    public function renderFromListTemplates(): string
    {
        krsort($this->templateObjectsStorage, SORT_REGULAR);
        foreach ($this->templateObjectsStorage as $templateObject) {
            // @TODO разобраться с проверками условий
            if ($templateObject->templateType === 'widgets') {
                $template = $templateObject->templateName;
                // @TODO сделать нормальную проверку и присвоение результата
            } elseif ($templateObject->templateType === 'content/exceptions') {
                $template = 'content';
            } else {
                $template = $templateObject->templateType;
            }

            if (!is_null($templateObject->templateParams)) {
                $scope = extract($templateObject->templateParams);
            }
            ob_start();

            require $templateObject->templateDirectory . $templateObject->templateName . $templateObject->templateExtension;
            $$template = ob_get_clean();
        }
        return $$template;
    }
}