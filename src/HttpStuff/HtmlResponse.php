<?php

declare(strict_types=1);

namespace App\HttpStuff;

class HtmlResponse implements IHttpResponse
{
    private string $payload;

    public function __construct(string $payload)
    {
        $a = __DIR__;
        $this->payload = file_get_contents(ROOT . '/Views/' .$payload);
    }

    public function render(): void
    {
        header('Content-Type: text/html');
        echo $this->payload;
    }
}