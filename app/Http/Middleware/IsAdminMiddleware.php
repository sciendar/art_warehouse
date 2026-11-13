<?php

namespace App\Http\Middleware;

use App\Models\AdminActivityLog;
use App\Services\IpAddressService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JsonException;

class IsAdminMiddleware
{
    public function __construct(
        private readonly IpAddressService $ipAddressService,
    )
    {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        // 1. Проверка авторизации
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Необходима авторизация.');
        }

        $user = Auth::user();

        // 2. Проверка роли
        if (
            !$user->is_admin() &&
            !$user->is_storekeeper() &&
            !$user->is_manager()
        ) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('error', 'Недостаточно прав.');
        }

        // 3. Проверка IP
        $ip = $this->ipAddressService->remember($request->ip());

        if (in_array(
            $ip,
            $this->ipAddressService->exceptionIps(),
            true
        )) {
            Auth::logout();

            return redirect()
                ->route('login')
                ->with('error', 'Доступ запрещён.');
        }

        // 4. Проверка срока авторизации
        if (
            $user->auth_at === null ||
            $user->auth_at->isPast()
        ) {
            return redirect()->route('admin.auth');
        }

        // 5. Выполнение контроллера
        $response = $next($request);

        // 6. Обновление активности
        $user->touch('last_auth_at');

        // 7. Журналирование
        if (!Str::contains(
            $request->fullUrl(),
            'action_statistics'
        )) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    protected function logActivity(Request $request, $response): void
    {
        try {
            AdminActivityLog::create([
                'user_id'       => Auth::id() ?? null,
                'url'           => $request->path(),
                'method'        => $request->method(),
                'ip'            => $request->ip(),
                'user_agent'    => $request->userAgent(),
                'device_type'   => $this->getDeviceType($request->userAgent()),
                'browser'       => $request->server('HTTP_SEC_CH_UA'),
                'platform'      => $request->server('HTTP_SEC_CH_UA_PLATFORM'),
                'status_code'   => $response->getStatusCode(),
                'query_params'  => $request->query() ?: null,
                'request_data'  => $this->getSanitizedRequestData($request),
                'response_time' => defined('LARAVEL_START') ? microtime(true) - LARAVEL_START : null,
            ]);
        } catch (\Exception $e) {

        }
    }

    protected function getDeviceType(?string $userAgent): string
    {
        $userAgent = strtolower((string)$userAgent);

        return match (true) {
            str_contains($userAgent, 'mobile') => 'mobile',
            str_contains($userAgent, 'tablet') => 'tablet',
            default => 'desktop',
        };
    }

    protected function getSanitizedRequestData(Request $request): ?string
    {
        $data = $request->except([
            'password',
            'password_confirmation',
            'token',
            'auth_code',
            'files',
            'file',
            'image',
            'new_images',
            'new_documents',
        ]);

        if (empty($data)) {
            return null;
        }

        try {
            return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return null;
        }
    }
}
