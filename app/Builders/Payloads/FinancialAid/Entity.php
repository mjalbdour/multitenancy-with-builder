<?php

namespace App\Builders\Payloads\FinancialAid;

use App\Builders\Payloads\AbstractPayloadBuilder;

class Entity extends AbstractPayloadBuilder
{
    public function getName()
    {
        return 'entity';
    }

    public function transform()
    {

        return [
            "number_of_employees" => $this->input->number_of_employees,
        ];
    }

    public function rules()
    {
        return [
            'type' => 'in:entity'
        ];
    }
}
