<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Models\UserTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MultitenantableTransactionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /*
     * This test creates 2 users where user1 initiates a trx
     * but user 2 must not see it
     * */
    public function test_load_scoped_transaction()
    {
        $user1 = User::factory()->create();
        $this->actingAs($user1);
        $company1 = Company::factory()->create();
        $transaction1 = UserTransaction::factory()->create(
            [
                'created_by_user_id' => auth()->id(),
                'company_id' => $company1->id
            ]
        );

        $user2 = User::factory()->create();
        $this->actingAs($user2);

        $t1 = UserTransaction::all();

        $t2 = UserTransaction::all();

        $this->assertEmpty($t1);
    }
}
