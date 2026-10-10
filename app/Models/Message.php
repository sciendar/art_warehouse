<?php

namespace App\Models;

use App\Traits\AddEdit;
use App\Traits\Logs;
use App\Traits\UploadFile;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use AddEdit, UploadFile, Logs;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'theme_id','name','email','text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->withDefault();
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id')->withDefault();
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class)->withDefault();
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class)->withDefault();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function unread_messages()
    {
        return $this->hasMany(Message::class)->where('author_id', '!=', auth()->id())->where('read_at', null);
    }

    public function last_message()
    {
        return $this->hasOne(Message::class)->where('author_id', '!=', auth()->id())->latest();
    }
}
