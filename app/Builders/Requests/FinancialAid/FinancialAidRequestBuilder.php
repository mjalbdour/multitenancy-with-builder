<?php

namespace App\Builders\Requests\FinancialAid;

use App\Builders\Payloads\FinancialAid\Basic;
use App\Builders\Requests\AbstractRequestBuilder;

class FinancialAidRequestBuilder extends AbstractRequestBuilder
{
    public function getURL()
    {
        return config('external_apis.financial_aid');
    }

    public function build()
    {
        $basic = new Basic($this->input);

        return $basic->build();
    }
}
