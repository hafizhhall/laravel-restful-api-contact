<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/users', [
            'username' => 'hafizh',
            'password' => 'password',
            'name' => 'Hafizh Athallah Widianto'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'username' => 'hafizh',
                    'name' => 'Hafizh Athallah Widianto'
                ]
            ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'username' => [
                        'The username field is required.'
                    ],
                    'password' => [
                        'The password field is required.'
                    ],
                    'name' => [
                        'The name field is required.'
                    ]
                ]
            ]);
    }

    public function testRegisterUsernameExists()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'hafizh',
            'password' => 'password',
            'name' => 'Hafizh Athallah Widianto'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'username' => [
                        'Username already taken'
                    ]
                ]
            ]);
    }
}
