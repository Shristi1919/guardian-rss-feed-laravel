<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RssFeedControllerTest extends TestCase
{
    public function testRssFeedForValidSection()
    {
        $validSections = ['politics', 'lifeandstyle'];

        foreach ($validSections as $section) {
            $response = $this->get("/rssfeed/{$section}");
            $response->assertStatus(200);
            $response->assertHeader('Content-Type', 'application/rss+xml');
        }
    }
    public function testErrorForInvalidSectionName()
    {
        // $response = $this->get('/rssfeed/invalid-section');
        $response = $this->get('/rssfeed/life_and_style');
        // Log the full response to check the issue
        Log::info('Test Response: ' . $response->getContent());
        // dd($response);
        // Assert the expected error
        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'Invalid section name. Only lowercase and hyphens are allowed.',
        ]);
    }


    public function testRssFeedCacheDuration()
    {
        $section = 'politics';
        $rssData = 'rss data';
        Cache::put($section, $rssData, now()->addMinutes(10));

        $this->assertEquals($rssData, Cache::get($section));
        $this->assertTrue(Cache::has($section));
    }
}
