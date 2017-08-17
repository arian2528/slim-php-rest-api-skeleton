<?php

namespace Tests\Functional;

class FetchRouteTest extends BaseTestCase
{
    /**
     * Test that the fetch route returns an error message if params are not passed
     */
    public function testFetchRouteEmptyParams()
    {
        $response = $this->runApp('GET', '/api/skills/fetch/');

        $this->assertEquals(200, $response->getStatusCode());
        $response = json_decode($response->getBody(true), true);
        $this->assertTrue($response['success'] === false);
        $this->assertContains('Missing params in the request', (string)$response['error']);
    }

    /**
     * Test that the fetch route returns an object with a success : true and a array of results
     */
    // public function testFetchRoute()
    // {
    //     $response = $this->runApp('GET', '/api/skills/fetch/type:1');

    //     $this->assertEquals(200, $response->getStatusCode());
    //     $response = json_decode($response->getBody(true), true);
    //     $this->assertTrue($response['success'] === true);
    //     // $this->assertContains('Missing params in the request', (string)$response['error']);
    // }
}