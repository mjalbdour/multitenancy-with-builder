<?php

namespace App\Builders\Payloads\FinancialAid;

use App\Builders\Payloads\AbstractPayloadBuilder;

// Due to the Third-Party API Requirements, this class must always be included.
class Basic extends AbstractPayloadBuilder
{
    public $additions = [Entity::class, Foreign::class];

    public function getName()
    {
        return 'basic';
    }

    public function transform()
    {
        return [
            "name" => $this->input->name,
            "email" => $this->input->email,
            "national_number" => $this->input->national_number,
            "phone" => $this->input->phone,
        ];
    }
}
