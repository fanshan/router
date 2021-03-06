<?php

namespace Test\ObjectivePHP\Router;


use Codeception\Test\Unit;
use ObjectivePHP\Router\MatchedRoute;
use ObjectivePHP\Router\RoutingResult;

class RoutingResultTest extends Unit
{
    public function testDidNotMatch()
    {
        $routingResult = new RoutingResult();
        $this->assertFalse($routingResult->didMatch());

    }

    public function testDidtMatch()
    {
        $matchedRoute = $this->getMockBuilder(MatchedRoute::class)->disableOriginalConstructor()->getMock();
        $routingResult = new RoutingResult($matchedRoute);

        $this->assertTrue($routingResult->didMatch());
        $this->assertSame($matchedRoute, $routingResult->getMatchedRoute());
    }
}