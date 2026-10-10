<?php

namespace App\Imports;

use App\Models\Auction;
use App\Models\Author;
use App\Models\AuthorTranslation;
use App\Models\Condition;
use App\Models\ConditionTranslation;
use App\Models\Lot;
use App\Models\LotTranslation;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class LotsImport implements ToCollection
{
    public Auction $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $row) {
            if ($i++ > 0) {
                $condition = $this->get_condition($row);
                if ($row[1] == null) {
                    return redirect()->route('admin.auctions.edit', $this->auction)->with('error', 'В строке ' . $i . 'не заполнен автор');
                }
                $author = $this->get_author($row);

                $lot = $this->get_lot($this->auction->id, $author->id, $condition->id, $row);
            }
        }
    }

    public function get_condition($row)
    {
        $condition_translation = ConditionTranslation::where('locale', 'en')
            ->where('title', $row[6])
            ->first();
        if (!$condition_translation) {
            $condition = new Condition();
            $condition->save();

            $condition_translation               = new ConditionTranslation();
            $condition_translation->condition_id = $condition->id;
            $condition_translation->locale       = 'en';
            $condition_translation->text         = $row[6];
            $condition_translation->save();
        } else {
            $condition = Condition::where('id', $condition_translation->condition_id)
                ->first();
        }
        return $condition;
    }

    public function get_author($row)
    {
        $author_translation = AuthorTranslation::where('locale', 'en')
            ->where('title', $row[1])
            ->first();
        if (!$author_translation) {
            $author = new Author();
            $author->save();

            $author_translation               = new AuthorTranslation();
            $author_translation->condition_id = $author->id;
            $author_translation->locale       = 'en';
            $author_translation->text         = $row[1];
            $author_translation->save();
        } else {
            $author = Author::where('id', $author_translation->author_id)
                ->first();
        }
        return $author;
    }

    public function get_lot($auction_id, $author_id, $condition_id, $row)
    {
        $lot = Lot::where('auction_id', $auction_id)
            ->where('lot', $row[0])
            ->first();
        if (!$lot) {
            $lot             = new Lot();
            $lot->auction_id = $auction_id;
            $lot->lot        = $row[0];
        }
        $lot->author_id    = $author_id;
        $lot->condition_id = $condition_id;
        $lot->low_est      = $row[3];
        $lot->high_est     = $row[4];
        $lot->start_price  = $row[5];
        $lot->save();

        $lot_translation = LotTranslation::where('locale', 'en')
            ->where('lot_id', $lot->id)
            ->first();
        if (!$lot_translation) {
            $lot_translation         = new LotTranslation();
            $lot_translation->lot_id = $lot->id;
            $lot_translation->locale = 'en';
        }
        $lot_translation->title              = $row[1];
        $lot_translation->seo_title          = $row[1];
        $lot_translation->description_en     = Str::replace(';', '<br>', $row[2]);
        $lot_translation->seo_description_en = Str::replace(';', '<br>', $row[2]);
        $lot_translation->save();

        return $lot;
    }
}
