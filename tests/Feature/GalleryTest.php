<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_galleries_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('api.galleries.index'));
        $response->assertStatus(200);
        $this->assertArrayHasKey('activities', $response->json());
    }
}
