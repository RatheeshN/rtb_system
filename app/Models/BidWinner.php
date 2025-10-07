<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidWinner extends Model
{
    protected $fillable = [
        'ad_slot_id', 'bid_id', 'user_id', 'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function adSlot()
    {
        return $this->belongsTo(AdSlot::class);
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
