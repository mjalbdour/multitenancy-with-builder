<?php

namespace App\Builders\Payloads\FinancialAid;

use App\Builders\Payloads\AbstractPayloadBuilder;

class Foreign extends AbstractPayloadBuilder
{
    public function getName()
    {
        return 'foreign';
    }

    public function transform()
    {
        return [
            "country" => "jordan",
        ];
    }

    public function rules()
    {
        return [
            'is_foreign' => 'required|in:1'
        ];
    }

    public function prepare()
    {
        $this->input->is_foreign = (string)$this->input->is_foreign;
    }
}
