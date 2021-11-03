<?php

namespace App\Builders\Payloads;

use Illuminate\Support\Facades\Validator;

abstract class AbstractPayloadBuilder
{
    public $payload = [];
    public $additions = [];
    public $children = [];
    public $input;

    public function __construct($input)
    {
        $this->input = $input;
        $this->prepare();
    }

    abstract public function getName();

    abstract public function transform();

    public function rules()
    {
        return [];
    }

    public function prepare()
    {
        return $this;
    }

    public function fails()
    {
        return Validator::make($this->input->toArray(), $this->rules())->fails();
    }

    public function build()
    {
        $request[$this->getName()] = $this->transform();

        foreach ($this->additions as $addition) {
            $object = app($addition, ['input' => $this->input]);
            if (!$object->fails()) {
                $request = array_merge($request, $object->build());
            }
        }

        foreach ($this->children as $child) {
            $object = app($child, ['input' => $this->input]);
            if (!$object->fails()) {
                $request[$this->getName()] = array_merge($request[$this->getName()], $object->build());
            }
        }

        return $request;
    }
}
