<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'item_id',
        'chat_by_id',
        'chat_for_id',
        'chat_message',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'chat_by_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'chat_for_id');
    }
}
