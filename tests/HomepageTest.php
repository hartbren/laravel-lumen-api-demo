<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use AlbertCht\Lumen\Testing\TestCase as TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomepage()
    {
        /** @var  $response */
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Laravel Lumen API Demo');
    }
}
