<?php

namespace Tests\Feature;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_a_password_reset_link(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'cliente@pingu.test',
        ]);

        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(ResetPasswordMail::class, function (ResetPasswordMail $mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->token !== '';
        });

        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }

    public function test_user_can_reset_password_with_valid_token(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'cliente@pingu.test',
            'password' => 'password-vieja',
        ]);

        $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        $sentMail = null;

        Mail::assertSent(ResetPasswordMail::class, function (ResetPasswordMail $mail) use (&$sentMail, $user) {
            $sentMail = $mail;

            return $mail->hasTo($user->email);
        });

        $response = $this->post(route('password.update'), [
            'token' => $sentMail->token,
            'email' => $user->email,
            'password' => 'NuevaPassword123',
            'password_confirmation' => 'NuevaPassword123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $user->refresh();

        $this->assertTrue(Hash::check('NuevaPassword123', $user->password));
        $this->assertDatabaseMissing('password_reset_tokens', [
            'email' => $user->email,
        ]);
    }
}
