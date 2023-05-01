<?php

namespace Tests\Unit\Services;

use Auth;
use Tests\TestCase;

class BaseServiceTest extends TestCase
{
    protected function login_user1(): void
    {
        Auth::attempt(
            [
                'email' => 'test1@sample.com',
                'password' => 'password'
            ]
        );
    }

    protected function login_user2(): void
    {
        Auth::attempt(
            [
                'email' => 'test2@sample.com',
                'password' => 'password'
            ]
        );
    }

    protected function login_user3(): void
    {
        Auth::attempt(
            [
                'email' => 'test3@sample.com',
                'password' => 'password'
            ]
        );
    }
}
