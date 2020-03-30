<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testExpectedlySuccessful()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "account_from_id": 1,
              "account_to_id": 2,
              "value": 111
            }'
        );
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}