<?php

namespace App\Builders\Requests;

use Illuminate\Support\Facades\Http;

abstract class AbstractRequestBuilder
{
    // this one is passed to the specified payload builder
    public $input;

    public $api_url;
    public $method = 'post';
    public $headers = [];

    public function __construct($input)
    {
        $this->api_url = $this->getURL();
        $this->input = $input;
    }

    abstract public function getURL();

    abstract public function build();

    public function send()
    {
        Http::send(
            $this->method,
            $this->api_url,
            [
                'body' => $this->build(),
                'header' => $this->headers
            ]);
    }
}
