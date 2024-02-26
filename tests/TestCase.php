<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // login in application as setup
    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }
    protected function signIn()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
    }
}
