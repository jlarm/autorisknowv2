<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class FathomService
{
    public function __construct(
        private string $apiToken,
        private string $siteId
    ) {}

    public function getAggregatedStats(string $dateFrom, string $dateTo, array $aggregates = ['pageviews', 'visits', 'uniques']): array
    {
        $cacheKey = "fathom_stats_{$dateFrom}_{$dateTo}_".implode('_', $aggregates);

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo, $aggregates) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'pageview',
                'entity_id' => $this->siteId,
                'aggregates' => implode(',', $aggregates),
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });
    }

    public function getCurrentVisitors(): int
    {
        $result = Cache::remember('fathom_current_visitors', now()->addSeconds(30), function () {
            $response = $this->client()->get('/current_visitors', [
                'site_id' => $this->siteId,
            ]);

            if ($response->successful()) {
                return $response->json('total', 0);
            }

            return 0;
        });

        return (int) $result;
    }

    public function getStats(int $days = 7): array
    {
        $dateFrom = now()->subDays($days)->format('Y-m-d');
        $dateTo = now()->format('Y-m-d');

        $overallStats = $this->getAggregatedStats($dateFrom, $dateTo, ['pageviews', 'visits', 'uniques', 'avg_duration', 'bounce_rate']);
        $chartData = $this->getChartData($days);
        $topPages = $this->getTopPages($dateFrom, $dateTo);
        $topReferrers = $this->getTopReferrers($dateFrom, $dateTo);
        $deviceTypes = $this->getDeviceTypes($dateFrom, $dateTo);
        $browsers = $this->getBrowsers($dateFrom, $dateTo);
        $countries = $this->getCountries($dateFrom, $dateTo);
        $events = $this->getEvents($dateFrom, $dateTo);

        return [
            'pageviews' => (int) ($overallStats[0]['pageviews'] ?? 0),
            'visits' => (int) ($overallStats[0]['visits'] ?? 0),
            'uniques' => (int) ($overallStats[0]['uniques'] ?? 0),
            'avg_duration' => (int) ($overallStats[0]['avg_duration'] ?? 0),
            'bounce_rate' => (float) ($overallStats[0]['bounce_rate'] ?? 0),
            'current_visitors' => $this->getCurrentVisitors(),
            'chart_data' => $chartData,
            'top_pages' => $topPages,
            'top_referrers' => $topReferrers,
            'device_types' => $deviceTypes,
            'browsers' => $browsers,
            'countries' => $countries,
            'events' => $events,
        ];
    }

    public function getChartData(int $days = 7): array
    {
        $dateFrom = now()->subDays($days)->format('Y-m-d');
        $dateTo = now()->format('Y-m-d');

        $cacheKey = "fathom_chart_{$dateFrom}_{$dateTo}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'pageview',
                'entity_id' => $this->siteId,
                'aggregates' => 'pageviews,visits',
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'date_grouping' => 'day',
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];
        });
    }

    public function getTopPages(string $dateFrom, string $dateTo, int $limit = 8): array
    {
        $cacheKey = "fathom_top_pages_{$dateFrom}_{$dateTo}_{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo, $limit) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'pageview',
                'entity_id' => $this->siteId,
                'aggregates' => 'pageviews,visits,uniques',
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'field_grouping' => 'pathname',
                'sort_by' => 'pageviews:desc',
                'limit' => $limit,
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];
        });
    }

    public function getTopReferrers(string $dateFrom, string $dateTo, int $limit = 6): array
    {
        $cacheKey = "fathom_top_referrers_{$dateFrom}_{$dateTo}_{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo, $limit) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'pageview',
                'entity_id' => $this->siteId,
                'aggregates' => 'pageviews,visits',
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'field_grouping' => 'referrer_hostname',
                'sort_by' => 'visits:desc',
                'limit' => $limit,
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];
        });
    }

    public function getDeviceTypes(string $dateFrom, string $dateTo, int $limit = 10): array
    {
        $cacheKey = "fathom_device_types_{$dateFrom}_{$dateTo}_{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo, $limit) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'pageview',
                'entity_id' => $this->siteId,
                'aggregates' => 'visits',
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'field_grouping' => 'device_type',
                'sort_by' => 'visits:desc',
                'limit' => $limit,
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];
        });
    }

    public function getBrowsers(string $dateFrom, string $dateTo, int $limit = 10): array
    {
        $cacheKey = "fathom_browsers_{$dateFrom}_{$dateTo}_{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo, $limit) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'pageview',
                'entity_id' => $this->siteId,
                'aggregates' => 'visits',
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'field_grouping' => 'browser',
                'sort_by' => 'visits:desc',
                'limit' => $limit,
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];
        });
    }

    public function getCountries(string $dateFrom, string $dateTo, int $limit = 10): array
    {
        $cacheKey = "fathom_countries_{$dateFrom}_{$dateTo}_{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo, $limit) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'pageview',
                'entity_id' => $this->siteId,
                'aggregates' => 'visits',
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'field_grouping' => 'country',
                'sort_by' => 'visits:desc',
                'limit' => $limit,
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            return [];
        });
    }

    public function getEvents(string $dateFrom, string $dateTo, int $limit = 20): array
    {
        $cacheKey = "fathom_events_{$dateFrom}_{$dateTo}_{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($dateFrom, $dateTo, $limit) {
            $response = $this->client()->get('/aggregations', [
                'entity' => 'event',
                'entity_id' => $this->siteId,
                'aggregates' => 'uniques,completions',
                'date_from' => $dateFrom.' 00:00:00',
                'date_to' => $dateTo.' 23:59:59',
                'field_grouping' => 'event_name',
                'sort_by' => 'completions:desc',
                'limit' => $limit,
                'timezone' => 'America/New_York',
            ]);

            if ($response->successful()) {
                $events = $response->json() ?? [];

                // Calculate conversion rate for each event
                return array_map(function ($event) {
                    $uniques = (int) ($event['uniques'] ?? 0);
                    $completions = (int) ($event['completions'] ?? 0);
                    $event['conversion_rate'] = $uniques > 0 ? round(($completions / $uniques) * 100, 1) : 0;

                    return $event;
                }, $events);
            }

            return [];
        });
    }

    private function client(): PendingRequest
    {
        return Http::baseUrl('https://api.usefathom.com/v1')
            ->withToken($this->apiToken)
            ->acceptJson();
    }
}
