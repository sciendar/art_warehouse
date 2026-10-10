<?php

namespace App\Services;

use App\Models\Ip;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class IpAddressService
{
    public function exceptionIps(): array
    {
        if (! Schema::hasTable('ips')) {
            return [];
        }

        return Cache::remember('ip_exceptions', 3600, static fn (): array => Ip::query()
            ->where('is_active', false)
            ->pluck('ip')
            ->all());
    }

    public function allowedAdminIps(): array
    {
        if (! Schema::hasTable('ips')) {
            return [];
        }

        return Cache::remember('ip_allowed', 3600, static fn (): array => Ip::query()
            ->where('is_admin', true)
            ->pluck('ip')
            ->all());
    }

    public function remember(string $requestIp): string
    {
        if (! Schema::hasTable('ips') || app()->runningUnitTests()) {
            return $requestIp;
        }

        $existingIp = Ip::query()->where('ip', $requestIp)->first();

        if ($existingIp !== null) {
            return $existingIp->ip;
        }

        try {
            $response = Http::timeout(3)->get("http://ip-api.com/json/{$requestIp}");
        } catch (ConnectionException) {
            return $requestIp;
        }

        if (! $response->successful()) {
            return $requestIp;
        }

        $data = $response->json();

        if (($data['status'] ?? null) !== 'success') {
            return $requestIp;
        }

        $ip = Ip::query()->create([
            'ip' => $requestIp,
            'country' => $data['country'] ?? null,
            'region' => $data['regionName'] ?? null,
            'city' => $data['city'] ?? null,
            'lat' => $data['lat'] ?? null,
            'lon' => $data['lon'] ?? null,
        ]);

        Cache::forget('ip_exceptions');
        Cache::forget('ip_allowed');

        return $ip->ip;
    }
}
