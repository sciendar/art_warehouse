<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class CacheHelper
{
    private const CACHING_TIME = 24 * 3600;

    public static function warehouses()
    {
        if (!Schema::hasTable('warehouses') || !Schema::hasTable('countries')) {
            return collect();
        }

        return Cache::remember('warehouses_user_' . auth()->id(), self::CACHING_TIME, function () {
            return DB::table('warehouses')
                ->join('countries', 'countries.id', '=', 'warehouses.country_id')
                ->when(!(auth()->user()->is_admin() || auth()->user()->is_manager()), function ($query) {
                    $query->whereIn('warehouses.id', self::my_warehouse_ids());
                })
                ->select('warehouses.id', 'warehouses.title as title', 'countries.title as country_title')
                ->orderBy('title')
                ->get();
        });
    }

    public static function users()
    {
        if (!Schema::hasTable('users')) {
            return collect();
        }

        return Cache::remember('users', self::CACHING_TIME, function () {
            $role_id = DB::table('roles')
                ->where('name', 'storekeeper')->value('id');
            $user_ids = DB::table('model_has_roles')
                ->where('role_id', $role_id)
                ->pluck('model_id')
                ->toArray();

            return DB::table('users')
                ->whereIn('id', $user_ids)
                ->select('id', 'name', 'email')
                ->orderBy('name')
                ->get();
        });
    }

    public static function countries()
    {
        if (!Schema::hasTable('countries')) {
            return collect();
        }

        return Cache::remember('countries', self::CACHING_TIME, function () {
            return DB::table('countries')
                ->select('id', 'title')
                ->orderBy('title')
                ->get();
        });
    }

    public static function roles()
    {
        if (!Schema::hasTable('roles')) {
            return collect();
        }

        return Cache::remember('roles', self::CACHING_TIME, function () {
            return DB::table('roles')
                ->select('id', 'name as title')
                ->orderBy('id')
                ->get();
        });
    }

    public static function my_warehouse_ids()
    {
        return DB::table('user_warehouse')
            ->where('user_id', auth()->id())
            ->pluck('warehouse_id')
            ->toArray();
    }

//    public static function conditions()
//    {
//        if (!Schema::hasTable('conditions')) {
//            return collect();
//        }
//
//        return Cache::remember('conditions_' . self::locale(), self::CACHING_TIME, function () {
//            return DB::table('conditions')
//                ->join('condition_translations', 'conditions.id', '=', 'condition_translations.condition_id')
//                ->where('condition_translations.locale', self::locale())
//                ->where('conditions.is_active', true)
//                ->select('conditions.id', 'is_active', 'text')
//                ->orderBy('text')
//                ->get();
//        });
//    }
}
