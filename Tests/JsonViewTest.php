<?php

namespace Lit\Voltage\Tests;

use Lit\Voltage\JsonView;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response;

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
        $response = new Response();
        $view = new JsonView();
        $view->setResponse($response);

        $actualResponse = $view->render($this->testData);
        $actualResponse->getBody()->rewind();

        self::assertEquals(json_encode($this->testData), $actualResponse->getBody()->getContents());
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
}
