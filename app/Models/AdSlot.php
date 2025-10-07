<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdSlot extends Model
{
    protected $fillable = [
        'name', 'start_time', 'end_time', 'minimum_bid_price', 'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'minimum_bid_price' => 'decimal:2',
    ];

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function winner()
    {
        return $this->hasOne(BidWinner::class);
    }
}
