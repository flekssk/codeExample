<?php

namespace App\Tests\integrational\App\Application\TemplateRenderer;

use App\Infrastructure\TemplateRenderer\TemplateRendererService;
use Codeception\TestCase\Test;

/**
 * Class TemplateRendererServiceTest.
 *
 * @package App\Tests\integrational\App\Application\TemplateRenderer
 * @covers \App\Infrastructure\TemplateRenderer\TemplateRendererService
 */
class TemplateRendererServiceTest extends Test
{
    public function testRender()
    {
        $variables = [
            '%ORDER_DATE%' => '2020-01-01',
            '%ORDER_NUMBER%' => 'Р-2020-01-01-12345',
            '%ORDER_USERS_LIST%' => 'Иванов Иван Иванович',
            '%ORDER_USERS_ZPT%' => 'Иванов Иван Иванович',
        ];

        $templateRenderer = $this->getService();
        $content = $templateRenderer->render('order/inclusion', $variables);

        foreach ($variables as $key => $variable) {
            $this->assertStringContainsString($variable, $content);
            $this->assertStringNotContainsString($key, $content);
        }
    }

    /**
     * @return TemplateRendererService
     * @throws \Codeception\Exception\ModuleException
     */
    private function getService(): TemplateRendererService
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(TemplateRendererService::class);
    }
}
