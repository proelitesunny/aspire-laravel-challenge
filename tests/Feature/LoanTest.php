<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoanTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_loan_with_valid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $formData = [
            'amount' => 30000,
            'tenure' => 4
        ];

        $this->json('POST', route('loans.store'), $formData)->assertStatus(200);
    }

    public function test_can_create_loan_with_invalid_amount()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $formData = [
            'amount' => 60000,
            'tenure' => 4
        ];

        $this->json('POST', route('loans.store'), $formData)->assertStatus(422);
    }

    public function test_can_create_loan_with_invalid_tenure()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $formData = [
            'amount' => 60000,
            'tenure' => 4
        ];

        $this->json('POST', route('loans.store'), $formData)->assertStatus(422);
    }
}
