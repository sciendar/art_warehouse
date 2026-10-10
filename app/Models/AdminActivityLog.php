<?php

namespace App\Models;

use App\Traits\AddEdit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminActivityLog extends Model
{
    use AddEdit;

    public static string $page_icon = '<i class="bi bi-cpu"></i>';//'<i class="bi bi-bar-chart-line"></i>';

    public static function page_title(): string
    {
        return 'Архів дій';
    }

    public static function route(string $suffix = null): string
    {
        return 'admin.action_statistics' . ($suffix != null ? '.' . $suffix : null);
    }

    public static function folder(string $suffix = null): string
    {
        return 'admin.action_statistics' . ($suffix != null ? '.' . $suffix : null);
    }

    protected $fillable = [
        'user_id',
        'url',
        'method',
        'ip',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'latitude',
        'longitude',
        'status_code',
        'request_data',
        'response_time',
    ];

    protected $casts = [
        'request_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function get_ip()
    {
        return $this->belongsTo(Ip::class, 'ip', 'ip');
    }

    public function browser()
    {
        $agents = [
            'Chrome',
            'Firefox',
            'Opera',
            'Safari',
            'Edge',
        ];

        foreach ($agents as $agent) {
            if (Str::contains(Str::upper($this->browser), Str::upper($agent))) {
                return $agent . ' v=' . Str::betweenFirst($this->browser, 'v="', '"');
            }
        }
        return $this->browser;
    }

    public function platform()
    {
        $agents = [
            'Windows',
            'Mac',
            'Linux',
            'Android',
            'iOS',
        ];

        foreach ($agents as $agent) {
            if (Str::contains(Str::upper($this->platform), Str::upper($agent))) {
                return $agent;
            }
        }
        return $this->platform;
    }

    public function status_code()
    {
        if ($this->status_code >= 500) {
            $color = 'danger';
        } elseif ($this->status_code >= 400) {
            $color = 'warning';
        }  elseif ($this->status_code >= 300) {
            $color = 'secondary';
        }
        return '<span class="text-' . ($color ?? 'success') . '">' . $this->status_code . '</span>';
    }
}
