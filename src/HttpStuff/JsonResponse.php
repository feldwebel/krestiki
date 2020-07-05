<?php

declare(strict_types=1);

namespace App\HttpStuff;

class JsonResponse implements IHttpResponse
{

    private $message = 'ok';
    private $payload = [];
    private $timeSpent;

    public function __construct($message = 'ok', $payload = [], $time = 0)
    {
        $this->message = $message;
        $this->payload = $payload;
        $this->timeSpent = $time;
    }

    public function render(): void
    {
        header('Content-Type: application/json');
        echo $this->make();
    }

    private function make(): string
    {
        return json_encode(
            [
                'message' => $this->message,
                'payload' => $this->payload,
                'time' => $this->timeSpent,
            ]
        );
    }
}
