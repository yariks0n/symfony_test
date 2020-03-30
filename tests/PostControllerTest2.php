<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest2 extends WebTestCase
{
    public function testExpectedlyUnsuccessful()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/transaction',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{
              "account_from_id": 3,
              "account_to_id": 2,
              "value": 111
            }'
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}