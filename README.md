# Guzzle Request Headers Middleware

## Overview

[Middleware](http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html#middleware) for [Guzzle 6](http://docs.guzzlephp.org/en/stable/) for setting headers on all requests sent by a client.

Add any number of headers to every request sent by a client. That's it. Easy.

## Usage example

```php
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use webignition\Guzzle\Middleware\RequestHeaders\RequestHeadersMiddleware;

// Creating a client that uses the middleware
$requestHeadersMiddleware = new RequestHeadersMiddleware();

$handlerStack = HandlerStack::create();
$handlerStack->push($requestHeadersMiddleware, 'request-headers');

$client = new Client([
    'handler' => $handlerStack,
]);

// Setting request headers
$requestHeadersMiddleware->setHeader('User-Agent', 'Super Foo!');

// All requests to example.com (or *.example.com) will now have
// a header of 'User-Agent: Super Foo!'

// Clearing request headers by explicitly setting a previously-set value to null
$requestHeadersMiddleware->setHeader('User-Agent', null);
```
