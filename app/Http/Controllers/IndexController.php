<?php

namespace App\Http\Controllers;

use App\Enums\BidStatus;
use App\Enums\LotStatus;
use App\Enums\PaintingStatus;
use App\Helpers\Errors;
use App\Http\Controllers\Controller;
use App\Jobs\VisitStatJob;
use App\Mail\BidApproved;
use App\Mail\BidWin;
use App\Mail\NewBid;
use App\Mail\OrderDelivered;
use App\Mail\OrderOnPayment;
use App\Mail\OrderPaid;
use App\Mail\ReminderNotice;
use App\Mail\ResetPassword;
use App\Mail\TestEmail;
use App\Mail\UserAdditionalInformation;
use App\Mail\UserApproved;
use App\Mail\VerifyEmail;
use App\Mail\Welcome;
use App\Models\Auction;
use App\Models\Author;
use App\Models\Bid;
use App\Models\Condition;
use App\Models\Country;
use App\Models\Lot;
use App\Models\Order;
use App\Models\OrderLot;
use App\Models\Product;
use App\Models\Theme;
use App\Models\User;
use App\Models\VisitHoursStat;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    public function home()
    {
        if (auth()->check()) {
            return redirect()->route('admin.paintings.index');
        } else {
            return redirect()->route('login');
        }
    }
}
