<?php

declare(strict_types=1);

namespace App\HttpStuff;

class HttpRequest {

    public const GET = 'GET';
    public const POST = 'POST';

    private ?array $params;
    private string $method;
    private ?string $endpoint;

    public function __construct($request = [])
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->endpoint = $_SERVER['REQUEST_URI'];

        foreach ($request['_POST'] as $name => $element) {
            $this->params[$name] = $element;
        }
    }

    public function getOrElse($name, $else = null): ?string
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }

        return $else;
    }

    public function isGet(): bool
    {
        return $this->method === self::GET;
    }
}
