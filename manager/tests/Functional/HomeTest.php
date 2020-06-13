<?php


namespace App\Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testGuest(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertSame('http://localhost/login', $client->getResponse()->headers->get('Location'));
    }
    
    public function testUser(): void
    {
        $client = static::createClient([], AuthFixture::userCredentials());
        $crawler = $client->request('GET', '/');
        
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Home', $crawler->filter('title')->text());
    }
    
    public function testAdmin(): void
    {
        $client = static::createClient([], AuthFixture::adminCredentials());
        $crawler = $client->request('GET', '/');
        
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Home', $crawler->filter('title')->text());
    }
}