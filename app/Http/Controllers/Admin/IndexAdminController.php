<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Errors;
use App\Http\Controllers\Controller;
use App\Jobs\VisitStatJob;
use App\Mail\SendPassword;
use App\Models\User;
use App\Models\VisitHoursStat;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class IndexAdminController extends Controller
{

    public function login()
    {
        return view('auth.admin_login');
    }

    public function auth()
    {
        $user = User::findOrFail(auth()->id());

        $code            = Str::random();
        $user->auth_code = password_hash($code, PASSWORD_DEFAULT);
        $user->save();

        $user->visible_password = $code;

        try {
            Mail::send_email(new SendPassword($user), $user->email);
//            (new MyMail())->to([$user->email, 'demy2@ukr.net'])->send(new SendPassword($user));
        } catch (\Exception $e) {
            new Errors($e->getMessage());
//                dump('MAIL_MAILER: ' . config('app.MAIL_MAILER'), 'MAIL_HOST: ' . config('app.MAIL_HOST'), 'MAIL_PORT: ' . config('app.MAIL_PORT'), 'MAIL_USERNAME: ' . config('app.MAIL_USERNAME'), 'MAIL_PASSWORD: ' . config('app.MAIL_PASSWORD'), 'MAIL_ENCRYPTION: ' . config('app.MAIL_ENCRYPTION'), 'MAIL_FROM_ADDRESS: ' . config('app.MAIL_FROM_ADDRESS'));
            dd(get_class(), debug_backtrace(), $e->getMessage());
        }

        return view('auth.login', compact('code'));
    }

    public function post_auth(Request $request)
    {
        $user = auth()->user();
        if (password_verify($request->auth_code, $user->auth_code)) {
            $user->auth_at = now()->addHours(12);
            $user->save();
            return redirect()->route('admin.home');
        }
        return back()->with('error', 'wrong data');
    }


    public function home()
    {
        return redirect()->route('admin.paintings.index');

        new VisitStatJob($_GET['date'] ?? date('Y-m-d'));

        $visit_stats = DB::table('visit_hours_stats')
            ->where(function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('date', now()->format('Y-m-d'))
                        ->where('hour', '>=', 0);
                })->orWhere(function (Builder $query) {
                    $query->where('date', now()->subDay()->format('Y-m-d'))
                        ->where('hour', '>', now()->hour);
                });
            })
            ->where('date', '>=', now()->subDay())
            ->get();
        foreach (range(23, 0) as $sub) {
            $date              = now()->subHours($sub)->format('Y-m-d');
            $hour              = now()->subHours($sub)->hour;
            $labels[]          = $hour;
            $visits_counts[]   = $visit_stats->where('date', $date)
                ->where('hour', $hour)
                ->sum('visits_count');
            $unique_visitors[] = $visit_stats->where('date', $date)
                ->where('hour', $hour)
                ->sum('unique_visitors');
        }
        $best_pages = VisitHoursStat::where(function ($query) {
            $query->where(function ($query) {
                $query->where('date', now()->format('Y-m-d'))
                    ->where('hour', '>=', 0);
            })->orWhere(function ($query) {
                $query->where('date', now()->subDay()->format('Y-m-d'))
                    ->where('hour', '>', now()->hour);
            });
        })
            ->selectRaw('
                path_id,
                SUM(visits_count) as sum_visits
            ')
            ->groupBy('path_id')
            ->orderByDesc('sum_visits')
            ->take(8)
            ->get();

        $visit_month_stats = DB::table('visit_hours_stats')
            ->where('date', '>=', now()->subMonth())
            ->where('date', '<=', now())
            ->get();
        foreach (range(31, 0) as $sub) {
            $date                    = now()->subDays($sub)->format('Y-m-d');
            $month_labels[]          = $date;
            $visits_month_counts[]   = $visit_month_stats->where('date', $date)
                ->sum('visits_count');
            $unique_month_visitors[] = $visit_month_stats->where('date', $date)
                ->sum('unique_visitors');
        }

        $best_month_pages = VisitHoursStat::where('date', '>=', now()->subMonth())
            ->where('date', '<=', now())
            ->selectRaw('
                path_id,
                SUM(visits_count) as sum_visits
            ')
            ->groupBy('path_id')
            ->orderByDesc('sum_visits')
            ->take(8)
            ->get();

        return view('admin.home.index', compact('labels', 'visits_counts', 'unique_visitors', 'best_pages', 'month_labels', 'visits_month_counts', 'unique_month_visitors', 'best_month_pages'));
    }

    public function test()
    {
        $images = \App\Models\Image::where('updated_at', '<', now()->subMinutes(30))
            ->get();
        foreach ($images as $image) {
            $image_path   = public_path($image->path);
            $spatie_image = Image::load($image_path);

            try {
                // Получаем EXIF-данные
                $exif = exif_read_data($image_path);
                if ($exif && isset($exif['Orientation'])) {
                    dd($exif);
                } else {
//                    continue;
                }
            } catch (\Exception $e) {
                // Проверяем MIME-тип файла
                $old_mime = mime_content_type($image_path);
                $spatie_image->format('jpg');
                $spatie_image->save();

                $mime = mime_content_type($image_path);

                dd($old_mime, $mime, $spatie_image, $e->getMessage());
            }
            $spatie_image->height(800);
            $spatie_image->format('jpg');
            $spatie_image->save();

            $path        = str_replace('storage/', '', $image->path);
            $image->size = Storage::disk('public')->size($path);
            $image->save();
            dump($image->id);
        }
        dd($images->count());
        return view('admin.test.index');
    }

    public function change_warehouse(Request $request)
    {
        $user = auth()->user();

        $user->warehouse_id = $request->warehouse_id;
        $user->save();
        return back();
    }
}
