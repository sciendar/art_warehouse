<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AuctionStatus;
use App\Enums\LotStatus;
use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\AuctionTranslation;
use App\Models\Author;
use App\Models\Condition;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\Locale;
use App\Models\Lot;
use App\Models\Theme;
use App\Models\Translation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Mockery\Exception;

class ParserAdminController extends Controller
{
    public function users()
    {
        User::pars_data();
        dd('ok');
    }

    public function countries()
    {
        Country::pars_data();
        dd('ok');
    }

    public function themes()
    {
        Theme::pars_data();
        dd('ok');
    }

    public function auctions()
    {
        Auction::pars_data();
        dd('ok');
    }

    public function authors()
    {
        Author::pars_data();
        dd('ok');
    }

    public function conditions()
    {
        Condition::pars_data();
        dd('ok');
    }

    public function translations()
    {
        Translation::pars_data();
        dd('ok');
    }

    public function lots()
    {
        Lot::pars_data();
        dd('ok');
    }

    public function auction(Request $request, Auction $auction = null)
    {
        try {
            if ($auction && $auction->url_liveauctioneers != $request->url_liveauctioneers) {
                return back()->with('error', 'Ссылка не соответсвует уже сохранённой');
            }
            $auction = $this->get_auction_by_url($request);

            $html = Http::get($request->url_liveauctioneers . '?page=1&pageSize=all')->body();

            $main_block = Str::between($html, '<main', '</main>');
            $images     = $this->get_images($main_block);
            if (isset($images['error'])) {
                return back()->with('error', $images['error']);
            }

            $auction->images = $images;
            if ($auction->isDirty()) {
                $auction->save();
            }

            $auction_trans = $this->get_auction_trans($auction);
            $auction_trans = $this->update_auction_trans($auction_trans, $main_block);
            if (isset($auction_trans['error'])) {
                return back()->with('error', $images['error']);
            }

            $this->pars_pre_lots($main_block, $auction);

            return back()->with('success', 'Информация сохранена');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        //        preg_match_all('/<meta[^>]*>/i', $html, $matches);
//
//        $meta_contents = [];
//        foreach ($matches[0] as $metaTag) {
//            // Ищем name и content
//            preg_match('/name=["\']([^"\']*)["\']/i', $metaTag, $nameMatch);
//            preg_match('/content=["\']([^"\']*)["\']/i', $metaTag, $contentMatch);
//
//            if (!empty($nameMatch[1]) && !empty($contentMatch[1])) {
//                $meta_contents[$nameMatch[1]] = $contentMatch[1];
//            }
//        }
//        $meta_properties = [];
//        foreach ($matches[0] as $metaTag) {
//            // Ищем name и content
//            preg_match('/property=["\']([^"\']*)["\']/i', $metaTag, $nameMatch);
//            preg_match('/content=["\']([^"\']*)["\']/i', $metaTag, $contentMatch);
//
//            if (!empty($nameMatch[1]) && !empty($contentMatch[1])) {
//                $meta_properties[$nameMatch[1]] = $contentMatch[1];
//            }
//        }
    }

    public function get_auction_by_url($request)
    {
        $auction = Auction::where('url_liveauctioneers', $request->url_liveauctioneers)
            ->first();
        if (!$auction) {
            $auction                      = new Auction();
            $auction->status_id           = AuctionStatus::ACTIVE;
            $auction->url_liveauctioneers = $request->url_liveauctioneers;
        }
        return $auction;
    }

    public function get_auction_trans($auction)
    {
        $auction_trans = AuctionTranslation::where('auction_id', $auction->id)
            ->where('locale', config('app.locale'))
            ->first();
        if (!$auction_trans) {
            $auction_trans             = new AuctionTranslation();
            $auction_trans->auction_id = $auction->id;
            $auction_trans->locale     = config('app.locale');
        }
        return $auction_trans;
    }

    public function update_auction_trans($auction_trans, $main_block)
    {
        $info_block = Str::between($main_block, 'class="CatalogInfo__CatalogInfoContainer', 'class="FluidItemGrid__ItemGridContainer');
////        $date = Str::betweenFirst($info_block, 'timed-or-live-date', '</span>');
//        $date = Str::after($info_block, 'Starts on: ');

        $title = Str::between($info_block, '<h1', '</h1>');
        $title = Str::betweenFirst($title, '<div', '</div>');
        $title = Str::after($title, '>');

        if (Str::containsAll($title, ['<',
                                      '"',
                                      '>'])) {
            return ['error' => 'Что-то не так с названием. ' . $title];
        }
        $description = Str::after($info_block, 'CatalogInfo__Description');
        $description = Str::betweenFirst($description, '<div', '</div>');
        $description = Str::afterLast($description, '<div>');

        $auction_trans->title           = $title;
        $auction_trans->description     = $description;
        $auction_trans->seo_title       = $title;
        $auction_trans->seo_description = $description;
        if ($auction_trans->isDirty()) {
            $auction_trans->save();
        }
        return $auction_trans;
    }

    public function get_images($main_block)
    {
        $images_block = Str::between($main_block, 'class="CoverLotsWideComponent__StyledCoverLotsWide', 'class="CatalogComponent__CatalogWrapper');
        $images_array = Str::of($images_block)->explode('CoverLotsWideComponent__StyledLink');
        if (count($images_array) != 4) {
            return ['error' => 'Что-то не так с блоком картинок CoverLotsWideComponent__StyledCoverLotsWide'];
        }
        foreach ($images_array as $image_data) {
            $url = Str::betweenFirst($image_data, 'src="', '"');
            if (Str::contains($url, 'https:')) {
                $images[] = $url;
            }
        }
        return $images ?? null;
    }

    public function pars_pre_lots($main_block, $auction)
    {
        $lots_block = Str::after($main_block, 'class="CatalogComponent__CatalogWrapper');
        $lots_array = Str::of($lots_block)->explode('CatalogItemCard__CatalogItemCardContainer');
        foreach ($lots_array as $lot_data) {
            if (Str::contains($lot_data, 'ImageRow__ContainerLink')) {
                $url      = Str::betweenFirst($lot_data, 'href="', '"');
                $lot_data = Str::after($lot_data, 'CatalogItemCard__PlacedItemCardTitle');
                $lot_data = Str::after($lot_data, '<span');
                $lot_data = Str::betweenFirst($lot_data, '>', '</span>');
                $lot_num  = Str::before($lot_data, ':');

                $lot = Lot::where('auction_id', $auction->id)
                    ->where('lot', $lot_num)
                    ->first();
                if (!$lot) {
                    $lot             = new Lot();
                    $lot->auction_id = $auction->id;
                    $lot->lot        = $lot_num;
                }
                $lot->status_id           = LotStatus::FOR_SALE;
                $lot->url_liveauctioneers = 'https://www.liveauctioneers.com' . $url;
                if ($lot->isDirty()) {
                    $lot->save();
                }
            }
        }
    }
}
