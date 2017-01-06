<?php

class HttpRequest {

    private $params = [];

    public function __construct($get = [])
    {
        foreach ($get as $name => $element) {
            $this->params[$name] = $element;
        }
    }

    public function getOrElse($name, $else = null)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }

        return $else;
    }
}
