<?php

namespace App\Services;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VisitTrackingService
{
    /**
     * @var list<string>
     */
    private array $excludedPathFragments = [
        '/adminex/',
        '/assets/',
        '/admin/',
        '/sites/',
        '/web/',
        '/img/',
        '/css/',
        '/js/',
    ];

    public function track(Request $request): ?Visit
    {
        try {
            $path = '/'.trim($request->path(), '/');

            if (Str::contains($path, $this->excludedPathFragments)) {
                return null;
            }

            $timestamp = now();

            return Visit::query()->create([
                'ip' => $request->ip(),
                'url' => $path,
                'path' => $path,
                'method' => $request->method(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 500),
                'device_type' => $this->resolveDeviceType($request->userAgent()),
                'browser' => $request->server('HTTP_SEC_CH_UA'),
                'platform' => $request->server('HTTP_SEC_CH_UA_PLATFORM'),
                'referer' => $request->header('referer'),
                'query_params' => $request->query() ?: null,
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'date' => $timestamp->toDateString(),
                'hour' => (int) $timestamp->format('H'),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Failed to track visit.', ['message' => $e->getMessage()]);

            return null;
        }
    }

    private function resolveDeviceType(?string $userAgent): string
    {
        $normalizedUserAgent = strtolower($userAgent ?? '');

        return match (true) {
            str_contains($normalizedUserAgent, 'mobile') => 'mobile',
            str_contains($normalizedUserAgent, 'tablet') => 'tablet',
            default => 'desktop',
        };
    }
}
