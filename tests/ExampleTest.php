<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Laravel 5');
    }

    /**
     * Dashboard functional test example.
     *
     * @return void
     */
    public function testDashboardPage()
    {
        $this->sentryUserBe('admin@admin.com');
        $this->visit('/dashboard')
            ->see('dashboard');
    }

    /**
     * Login to sentry for Testing purpose
     * @param  $email
     * @return void
     */
    public function sentryUserBe($email='admin@admin.com')
    {
        $user = \Cartalyst\Sentry::findUserByLogin($email);
        \Sentry::login($user);
        \Event::fire('sentinel.user.login', ['user' => $user]);
    }
}
