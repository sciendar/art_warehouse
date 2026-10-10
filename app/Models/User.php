<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\ResetPassword;
use App\Traits\AddEdit;
use App\Traits\Logs;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use AddEdit, Logs;

    public static $page_title = 'Users';
    public static $page_icon = '<i class="bi bi-people"></i>';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'warehouse_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'auth_at'           => 'datetime',
            'last_auth_at'      => 'datetime',
            'last_painting_at'  => 'datetime',
            'is_active'         => 'boolean',
        ];
    }

    public static function aliases()
    {
        return [
            'name'             => 'ФИО',
            'email'            => 'Емейл',
            'phone'            => 'Телефон',
            'warehouse_id'     => 'Склад',
            'role_id'          => 'Роль',
            'password'         => 'Пароль',
            'created_at'       => 'Дата',
            'last_painting_at' => 'Дата последней картины',
        ];
    }

    public function is_super_admin(): bool
    {
        return $this->hasRole([
            'super_admin',
        ]);
    }

    public function is_admin(): bool
    {
        return $this->hasRole([
            'super_admin',
            'admin',
        ]);
    }

    public function is_storekeeper(): bool
    {
        return $this->hasRole('storekeeper');
    }

    public function is_manager(): bool
    {
        return $this->hasRole('manager');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class);
    }

    public function sync_warehouses($ids = [])
    {
        $this->warehouses()->sync($ids);
    }

    public function paintings(): HasMany
    {
        return $this->hasMany(Painting::class);
    }


    // изменение вида письма смены пароля
    public function sendPasswordResetNotification($token)
    {
        try {
            Mail::to($this->email)->send(new ResetPassword($token, $this));
        } catch (\Exception $e) {

        }
    }


    public function getDisplayNameAttribute(): string
    {
        $name = $this->first_name ?: Str::before($this->email, '@');

        return Str::of($name)
            ->replace(['_',
                       '-'], ' ')
            ->squish()
            ->title()
            ->toString();
    }

    public function getAdminAvatarUrlAttribute(): string
    {
        $hash    = md5(Str::lower(trim($this->email)));
        $default = rawurlencode('identicon');

        return "https://www.gravatar.com/avatar/{$hash}?s=96&d={$default}";
    }
}
