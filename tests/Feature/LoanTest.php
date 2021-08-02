<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_loan_with_valid_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $formData = [
            'amount' => 30000,
            'tenure' => 4
        ];

        $this->json('POST', route('loans.store'), $formData)->assertStatus(200);
    }

    public function test_can_create_loan_with_invalid_amount()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $formData = [
            'amount' => 60000,
            'tenure' => 4
        ];

        $this->json('POST', route('loans.store'), $formData)->assertStatus(422);
    }

    public function test_can_create_loan_with_invalid_tenure()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $formData = [
            'amount' => 60000,
            'tenure' => 4
        ];

        $this->json('POST', route('loans.store'), $formData)->assertStatus(422);
    }

    public function test_can_pay_for_loan_valid_amount()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $loanData = [
            'amount' => 30000,
            'tenure' => 4
        ];

        $response = $this->json('POST', route('loans.store'), $loanData)->getOriginalContent();

        $this->json('POST', route('loans.pay', [$response['loan_details']['id']]), ['amount' => 10000])->assertStatus(200);
    }

    public function test_can_pay_for_loan_invalid_amount()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $loanData = [
            'amount' => 30000,
            'tenure' => 4
        ];

        $response = $this->json('POST', route('loans.store'), $loanData)->getOriginalContent();

        $this->json('POST', route('loans.pay', [$response['loan_details']['id']]), ['amount' => 100000])->assertStatus(422);
    }

    public function test_can_get_loan_details()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $loanData = [
            'amount' => 30000,
            'tenure' => 4
        ];

        $response = $this->json('POST', route('loans.store'), $loanData)->getOriginalContent();

        $this->json('GET', route('loans.show', ['loan_id' => $response['loan_details']['id']]))->assertStatus(200);
    }

    public function test_can_get_my_loans()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $formData = [
            'amount' => 30000,
            'tenure' => 4
        ];

        $response = $this->json('POST', route('loans.store'), $formData)->getOriginalContent();

        $this->json('GET', route('loans.index'))->assertStatus(200);
    }
}
