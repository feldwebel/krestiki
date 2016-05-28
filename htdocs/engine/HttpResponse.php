<?php

class HttpResponse {

    private $message = 'ok';
    private $payload = [];

    public function __construct($message = 'ok', $payload = [])
    {
        $this->message = $message;
        $this->payload = $payload;
    }

    public function make()
    {
        return json_encode(
            [
                'message' => $this->message,
                'payload' => $this->payload,
            ]
        );
    }
}
