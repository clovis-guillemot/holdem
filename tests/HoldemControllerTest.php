<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HoldemControllerTest extends WebTestCase
{
    public function testPageContainsForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/', [], [], ['HTTP_HOST' => 'localhost:8000']);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }
}
