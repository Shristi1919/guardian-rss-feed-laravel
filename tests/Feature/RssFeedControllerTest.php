<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

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
        $response = $this->get('/rssfeed/life_and_style');
        Log::info('Test Response: ' . $response->getContent());
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
