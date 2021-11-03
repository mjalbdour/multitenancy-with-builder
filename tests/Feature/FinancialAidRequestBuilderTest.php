<?php

namespace Tests\Feature;

use App\Models\User;
use App\Builders\Requests\FinancialAid\FinancialAidRequestBuilder;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinancialAidRequestBuilderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_request_must_contain_the_basic_object()
    {
        // create a user
        $user = User::factory()->foreign()->entity()->create();

        // we pass it inside the builder
        $financialAidRequestBuilder = new FinancialAidRequestBuilder($user);

        // call some methods on the builder
        $request = $financialAidRequestBuilder->build(); // however, send() is used to build & make request to api
//        dd($request);

        $basic_value = $request['basic'];

        // assertion
        $this->assertEquals([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'national_number' => $user->national_number
        ],
            $basic_value
        );

    }


    // Depending on the `user.type` you'll need to decide if the `entity` field should be included.
    // 2 tests for the entity depending on the type
    public function test_request_has_entity_object()
    {
        // create a user
        $user = User::factory()->entity()->create();

        // we pass it inside the builder
        $builder = new FinancialAidRequestBuilder($user);

        // call some methods on the builder
        $request = $builder->build();
        $entity_value = $request['entity'];

        // assertion
        $this->assertEquals([
            'number_of_employees' => $user->number_of_employees
        ],
            $entity_value
        );
    }


    // Depending on the `user.is_foreign` you'll need to decide if the `foreign` object is to be included.
    // 2 tests for the foreign object depending on the is_foreign attribute or column
    public function test_request_has_foreign_object()
    {
        // create a user
        $user = User::factory()->foreign()->create();

        // we pass it inside the builder
        $builder = new FinancialAidRequestBuilder($user);

        // call some methods on the builder
        $request = $builder->build();
        $entity_value = $request['foreign'];

        // assertion
        $this->assertEquals([
            "country" => 'jordan'
        ],
            $entity_value
        );
    }

}
