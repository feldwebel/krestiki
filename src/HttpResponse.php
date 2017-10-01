<?php

class HttpResponse
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

    public function sendJSON()
    {
        header('Content-Type: application/json');
        echo $this->make();
    }

    private function make()
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
