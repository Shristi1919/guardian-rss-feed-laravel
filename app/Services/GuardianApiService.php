<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GuardianApiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = '845699dd-6621-4ab1-8bf9-02d41a287158';
        $this->baseUrl = 'https://content.guardianapis.com/';
    }

    public function fetchSections(string $section): ?array
    {
        $response = Http::get("{$this->baseUrl}{$section}", [
            'api-key' => $this->apiKey,
            'format' => 'json',
        ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }
}
