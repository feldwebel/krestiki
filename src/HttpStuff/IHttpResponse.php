<?php

declare(strict_types=1);

namespace App\HttpStuff;

interface IHttpResponse
{
    public function render(): void;
}