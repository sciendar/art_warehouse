<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use App\Services\IpAddressService;
use App\Services\VisitTrackingService;
use Closure;
use Illuminate\Http\Request;

class FixVisitsMiddleware
{
    // Фильтр ботов по user agent
    protected $botPatterns = [
        'bot',
        'crawler',
        'spider',
        'scraper',
        'checker',
        'google',
        'yandex',
        'bing',
        'yahoo',
        'duckduck',
        'facebook',
        'twitter',
        'linkedin',
    ];

    public function __construct(
        private readonly VisitTrackingService $visitTrackingService,
        private readonly IpAddressService $ipAddressService,
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->ipAddressService->remember($request->ip());
        $this->visitTrackingService->track($request);

        return $next($request);
    }
}
