<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function profile_information_can_be_updated()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/profile', [
                'name'   => 'Test User',
                'email'  => 'test@example.com',
                '_token' => csrf_token(),
            ])
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);

        // Permitindo que email_verified_at continue com a data correta se já estiver verificado
        $this->assertNotNull($user->email_verified_at);
    }
}
