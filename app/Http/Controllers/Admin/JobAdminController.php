<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\VisitStatJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class JobAdminController extends Controller
{
    public function visit_stats(Request $request)
    {
        $date = $request->query('date', date('Y-m-d'));

//        new VisitStatJob();
        VisitStatJob::dispatch($date);

        if (!Route::is('*.visit_stats')) {
            return back()->with('success', 'Job queued');
        } else {
            dd('Job queued');
        }
    }
}
