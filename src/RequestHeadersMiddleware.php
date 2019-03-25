<?php

namespace webignition\Guzzle\Middleware\RequestHeaders;

use Psr\Http\Message\RequestInterface;

class RequestHeadersMiddleware
{
    private $headers = [];

    public function setHeader(string $name, ?string $value)
    {
        if (null === $value && array_key_exists($name, $this->headers)) {
            unset($this->headers[$name]);
        } else {
            $this->headers[$name] = $value;
        }
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use (&$handler) {
            if (empty($this->headers)) {
                return $handler($request, $options);
            }

            foreach ($this->headers as $name => $value) {
                $request = $request->withHeader($name, $value);
            }

            return $handler($request, $options);
        };
    }
}
