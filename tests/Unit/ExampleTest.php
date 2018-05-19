<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user= factory(\App\User::class)->create([
            'name' => 'Dark Me'
        ]);
        $this->actingAs($user, 'api')
             ->get('/api/user')
             ->assertSee('Dark Me');
    }
}
