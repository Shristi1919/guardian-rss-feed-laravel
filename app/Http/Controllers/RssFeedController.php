<?php

namespace App\Http\Controllers;

use App\Services\GuardianApiService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RssFeedController extends Controller
{
    protected $guardianApiService;

    public function __construct(GuardianApiService $guardianApiService)
    {
        $this->guardianApiService = $guardianApiService;
    }

    public function getRssFeed($section)
    {
        Log::info('Section received: ' . $section);
        if (!preg_match('/^[a-z-]+$/', $section)) {
            Log::warning('Invalid section name provided: ' . $section);
            return response()->json([
                'error' => 'Invalid section name. Only lowercase and hyphens are allowed.',
            ], 400);
        }

        $rssFeed = Cache::get($section);

        if (!$rssFeed) {
            $data = $this->guardianApiService->fetchSections($section);

            if (is_null($data)) {
                return response()->json([
                    'error' => 'Error fetching data from The Guardian API.',
                ], 500);
            }

            if (empty($data['response']['results'])) {
                return response()->json([
                    'error' => 'No articles found for the given section.',
                ], 404);
            }
            $rssFeed = $this->convertToRss($data);

            Cache::put($section, $rssFeed, now()->addMinutes(10));
        }

        return response($rssFeed, 200)
            ->header('Content-Type', 'application/rss+xml');
    }

    private function convertToRss($data)
    {
        $rssItems = '';

        foreach ($data['response']['results'] as $article) {
            $guid = htmlspecialchars($article['webUrl']);

            $title = htmlspecialchars($article['webTitle'] ?? 'No Title');
            $description = htmlspecialchars($article['fields']['trailText'] ?? 'No description available.');
            $pubDate = date(DATE_RSS, strtotime($article['webPublicationDate']));

            $rssItems .= '
                <item>
                    <title><![CDATA[' . $title . ']]></title>
                    <link>' . htmlspecialchars($article['webUrl']) . '</link>
                    <description><![CDATA[' . $description . ']]></description>
                    <pubDate>' . $pubDate . '</pubDate>
                    <guid>' . $guid . '</guid> <!-- Globally unique identifier for the item -->
                </item>
            ';
        }

        return '
            <rss version="2.0">
                <channel>
                    <title>The Guardian - ' . htmlspecialchars($data['response']['section']['webTitle'] ?? 'Unknown Section') . '</title>
                    <link>' . htmlspecialchars($data['response']['section']['webUrl'] ?? '') . '</link>
                    <description>Latest articles from The Guardian\'s ' . htmlspecialchars($data['response']['section']['webTitle'] ?? 'Unknown Section') . ' section.</description>
                    <lastBuildDate>' . date(DATE_RSS, strtotime($data['response']['results'][0]['webPublicationDate'])) . '</lastBuildDate> <!-- The last build date of the RSS feed -->
                    ' . $rssItems . '
                </channel>
            </rss>
        ';
    }
}
