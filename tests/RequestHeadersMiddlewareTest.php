<?php

namespace webignition\Guzzle\Middleware\RequestHeaders\Tests;

use Psr\Http\Message\RequestInterface;
use webignition\Guzzle\Middleware\RequestHeaders\RequestHeadersMiddleware;

class RequestHeadersMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestHeadersMiddleware
     */
    private $requestHeadersMiddleware;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->requestHeadersMiddleware = new RequestHeadersMiddleware();
    }

    public function testInvokeNoHeaders()
    {
        $request = \Mockery::mock(RequestInterface::class);
        $options = [];

        $returnedFunction = $this->requestHeadersMiddleware->__invoke(
            function ($returnedRequest, $returnedOptions) use ($request, $options) {
                $this->assertEquals($request, $returnedRequest);
                $this->assertEquals($options, $returnedOptions);
            }
        );

        $returnedFunction($request, $options);
    }

    public function testInvokeAllHeadersRemoved()
    {
        $this->requestHeadersMiddleware->setHeader('foo', 'bar');
        $this->requestHeadersMiddleware->setHeader('foo', null);

        $request = \Mockery::mock(RequestInterface::class);
        $options = [];

        $returnedFunction = $this->requestHeadersMiddleware->__invoke(
            function ($returnedRequest, $returnedOptions) use ($request, $options) {
                $this->assertEquals($request, $returnedRequest);
                $this->assertEquals($options, $returnedOptions);
            }
        );

        $returnedFunction($request, $options);
    }

    public function testInvokeCredentialsValidForRequest()
    {
        $this->requestHeadersMiddleware->setHeader('foo', 'bar');

        $modifiedRequest = \Mockery::mock(RequestInterface::class);

        $request = \Mockery::mock(RequestInterface::class);
        $request
            ->shouldReceive('withHeader')
            ->with('foo', 'bar')
            ->andReturn($modifiedRequest);

        $options = [];

        $returnedFunction = $this->requestHeadersMiddleware->__invoke(
            function ($returnedRequest, $returnedOptions) use ($modifiedRequest, $options) {
                $this->assertEquals($modifiedRequest, $returnedRequest);
                $this->assertEquals($options, $returnedOptions);
            }
        );

        $returnedFunction($request, $options);
    }
}
