<?php

namespace tests\Unit;

use App\Service\Helpers\LinkManager;
use App\Service\RenderTemplateServise;
use App\Service\TemplateNavigator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RenderTemplateServiceTest extends TestCase
{
  /**
   * @var MockObject|TemplateNavigator
   */

  private LinkManager $linkManager;

  protected function setUp(): void
  {
    $this->linkManager = new LinkManager($this->createMock(Request::class));
  }

  public function testRenderFromListTemplatesIsValidString(): void
  {
    $navigation = new TemplateNavigator('navigation', 'widgets');
    $layout = new TemplateNavigator('main', 'layouts');
    $content = new TemplateNavigator('create_text_only', 'content');
    $render = new RenderTemplateServise([$layout, $content, $navigation]);
    $result = $render->renderFromListTemplates();

    $this->assertIsString($result);
    $this->assertStringStartsWith('<!DOCTYPE html>', $result);

  }

}