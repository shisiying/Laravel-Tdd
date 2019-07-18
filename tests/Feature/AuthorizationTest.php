<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function login_require_email()
    {
        $data = [
            'email' => null,
            'password' => 'secret'
        ];
        $response = $this->json('POST','/api/authorization',$data);
        $response->assertStatus(422)->assertJsonValidationErrors('email');
    }

    /**
     * @test
     */
    public function login_require_password()
    {
        $user = create('App\User');

        $data = [
            'email' => $user->email,
            'password' => null
        ];
        $response = $this->json('POST','/api/authorization',$data);
        $response->assertStatus(422)->assertJsonValidationErrors('password');
    }

    /**
     * @test
     */
    public function a_user_can_get_the_accesstoken()
    {
        $user = create('App\User');
        $data = [
            'email' => $user->email,
            'password' => 'secret'
        ];
        $response = $this->withExceptionHandling()->json('POST','/api/authorization',$data);
        $response->assertStatus(201)->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

}
