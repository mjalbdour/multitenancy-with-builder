<?php

namespace App\Builders\Payloads\Example;

use App\Builders\Payloads\AbstractPayloadBuilder;

class Example extends AbstractPayloadBuilder
{
    /**
     * Returns the name which is used as a key inside the payload data.
     * @return string
     */
    public function getName()
    {
        return 'example';
    }

    /**
     * transforms the input data into the desired payload data
     * @return array
     */
    public function transform()
    {
        return [
//            "example" => $this->input->example,
        ];
    }

    /**
     * These rules check if this object will be added to payload
     * @return array
     */
    public function rules()
    {
        return [
//            'type' => 'in:entity'
        ];
    }

    /**
     * Resultant object this builder:
     * [ 'example' => 'example_value' ]
     */
}
