<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Visit extends Model
{
    use AddEdit;

    public static $page_icon = '<i class="bi bi-graph-up-arrow"></i>';

    protected $fillable = [
        'ip',
        'url',
        'path',
        'method',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'referer',
        'query_params',
        'status_code',
        'user_id',
        'session_id',
// 'date' и 'hour'генерируются автоматически
    ];

    protected function casts(): array
    {
        return [
            'query_params' => 'array',
            'created_at' => 'datetime',
            'date' => 'date',
        ];
    }

    public function ip_details(): BelongsTo
    {
        return $this->belongsTo(Ip::class, 'ip', 'ip');
    }

    public function browser_label(): string
    {
        return $this->detect_agent_label($this->browser, ['Chrome', 'Firefox', 'Opera', 'Safari', 'Edge'], includeVersion: true);
    }

    public function platform_label(): string
    {
        return $this->detect_agent_label($this->platform, ['Windows', 'Mac', 'Linux', 'Android', 'iOS']);
    }

    public function statusColor(): string
    {
        return match (true) {
            $this->status_code >= 500 => 'danger',
            $this->status_code >= 400 => 'warning',
            $this->status_code >= 300 => 'secondary',
            default => 'success',
        };
    }

    private function detect_agent_label(?string $value, array $agents, bool $includeVersion = false): string
    {
        foreach ($agents as $agent) {
            if (Str::contains(Str::upper((string) $value), Str::upper($agent))) {
                if (! $includeVersion) {
                    return $agent;
                }

                return $agent.' v='.Str::betweenFirst((string) $value, 'v="', '"');
            }
        }

        return (string) $value;
    }
}
