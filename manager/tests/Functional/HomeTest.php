<?php


namespace App\Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testGuest()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertSame('http://localhost/login', $client->getResponse()->headers->get('Location'));
    }

    public function testSuccess(): void
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@test.com',
            'PHP_AUTH_PW' => '123456',
        ]);
        $crawler = $client->request('GET', '/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Hello', $crawler->filter('h1')->text());
    }
}