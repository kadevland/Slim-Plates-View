<?php

/**
 * Slim Framework (http://slimframework.com)
 *
 * @link      https://github.com/kadevland/Slim/Plate
 * @copyright Copyright (c) 2016 kadevland
 * @license   (MIT License)
 */
namespace kadevland\Tests\Views;

use Kaosland\Slim\Plates\Views\PlatesView;

require dirname(__DIR__) . '/vendor/autoload.php';

class PlatesViewTest extends \PHPUnit_Framework_TestCase
{
    public function testFetch()
    {
        $view = new PlatesView(dirname(__FILE__) . '/templates');

        $output = $view->fetch('example', [
            'name' => 'Josh'
        ]);

        $this->assertEquals("<p>Hi, my name is Josh.</p>\n", $output);
    }


    public function testRender()
    {
        $view = new PlatesView(dirname(__FILE__) . '/templates');

        $mockBody = $this->getMockBuilder('Psr\Http\Message\StreamInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockResponse = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $mockBody->expects($this->once())
            ->method('write')
            ->with("<p>Hi, my name is Josh.</p>\n")
            ->willReturn(28);

        $mockResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($mockBody);

        $response = $view->render($mockResponse, 'example', [
            'name' => 'Josh'
        ]);
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $response);
    }
}
