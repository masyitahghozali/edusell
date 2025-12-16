<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'item_id';

    // Allow mass-assignment for these
    protected $fillable = [
        'user_id',
        'item_name',
        'item_price',
        'item_condition',
        'item_category',
        'item_description',
        'item_status',
        'item_image',
    ];

    // Owner of the item
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Users who liked this item
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'item_likes', 'item_id', 'user_id')
                    ->withTimestamps();
    }
}
