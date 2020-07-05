<?php

namespace Lit\Voltage\Tests;

use Laminas\Diactoros\Response;
use Lit\Voltage\JsonView;
use PHPUnit\Framework\TestCase;

class JsonViewTest extends TestCase
{
    protected $testData = [
        'embed' => [
            'foo' => 'bar',
        ],
        'empty' => [],
        'string' => 'bar',
        'num' => -3.45,
        'boo' => false,
        'nil' => null,
        'list' => [1, 1, 2, 3, 5],
    ];

    public function testRender()
    {
        $this->assertRenderAsExpected($this->testData, json_encode($this->testData));

        $this->assertRenderAsExpected([
            JsonView::JSON_ROOT => $this->testData,
        ], json_encode($this->testData));

        $this->assertRenderAsExpected([
            JsonView::JSON_ROOT => false,
        ], json_encode(false));
    }

    public function testSetOption()
    {
        $response = new Response();
        $view = new JsonView();
        $view->setResponse($response);

        $actualResponse = $view
            ->setJsonOption(JSON_PRETTY_PRINT)
            ->render($this->testData);
        $actualResponse->getBody()->rewind();

        self::assertEquals(json_encode($this->testData, JSON_PRETTY_PRINT), $actualResponse->getBody()->getContents());
        self::assertEquals(JSON_PRETTY_PRINT, $view->getJsonOption());
    }

    public function testRenderJson()
    {
        $response = new Response();
        $view = new JsonView();
        $view->setResponse($response);

        $actualResponse = $view->renderJson(null);
        $actualResponse->getBody()->rewind();

        self::assertEquals('null', $actualResponse->getBody()->getContents());
    }


    /**
     * @param array          $renderData
     * @param string|boolean $expectedBodyContent
     */
    protected function assertRenderAsExpected(array $renderData, $expectedBodyContent): void
    {
        self::assertIsString($expectedBodyContent);
        $response = new Response();
        $view = new JsonView();
        $view->setResponse($response);

        $actualResponse = $view->render($renderData);
        $actualResponse->getBody()->rewind();

        self::assertEquals($expectedBodyContent, $actualResponse->getBody()->getContents());
    }
}
