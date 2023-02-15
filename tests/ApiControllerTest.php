<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;

class ApiControllerTest extends WebTestCase
{
    public function testEndPoints() 
    {
        self::bootKernel();
        
        $container = static::getContainer();
        
        $client = $container->get(HttpClientInterface::class);
        
        $response = $client->request(
            'POST',
            'http://localhost/v1/user',
            [
                'headers' => [
                    'my-client-id' => 'myClient',
                    'my-client-key' => 'xyz'
                ],
                'json' => [
                    'title' => 'mr',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john@doe.com',
                    'phone' => '777 777 777',
                    'prefix' => '420',
                    'country' => 'CZ',
                    'newsletter' => false,
                    'created_at' => '1272508903',
                    'password' => '$2y$13$BgD7lCh9m/dB3Rk/A8SgfuPNt8hwI.3t09.X6LjPZ4lS3VkIeRRge'
                ]
            ]
            
        );
        
        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        
        $response = $client->request(
            'GET',
            'http://localhost/v1/user',
            [
                'headers' => [
                    'my-client-id' => 'myClient',
                    'my-client-key' => 'xyz'
                ],
                'query' => [
                    'email' => 'john@doe.com'
                ]
            ]
        );
        $jsonContent = $response->getContent();
        $content = json_decode($jsonContent);
        $this->assertSame('john@doe.com', $content->user->email);
    }
}