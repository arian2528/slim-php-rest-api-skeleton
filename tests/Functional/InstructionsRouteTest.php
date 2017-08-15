<?php

namespace Tests\Functional;

class InstructionsRouteTest extends BaseTestCase
{
    /**
     * Test that the instructions route returns a json encode message with 2 properties
     */
    public function testInstructionsRoute()
    {
        $response = $this->runApp('GET', '/api/instructions');

        $this->assertEquals(200, $response->getStatusCode());
        $response = json_decode($response->getBody(true), true);
        $this->assertContains('API Instructions', (string)$response['Title']);
        $this->assertContains('Description', (string)$response['Description']);
    }
}