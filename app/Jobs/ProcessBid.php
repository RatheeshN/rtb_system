<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Bid;
use App\Models\AdSlot;

class ProcessBid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $adSlotId;
    protected $amount;
    /**
     * Create a new job instance.
     */
    public function __construct($userId, $adSlotId, $amount)
    {
        $this->userId = $userId;
        $this->adSlotId = $adSlotId;
        $this->amount = $amount;
    }
    /**
     * Execute the job.
     */
    public function handle()
    {
        $adSlot = AdSlot::findOrFail($this->adSlotId);

        if ($adSlot->status !== 'open') {
            throw new \Exception('Ad slot is not open for bidding');
        }

        if ($this->amount < $adSlot->minimum_bid_price) {
            throw new \Exception('Bid amount is below the minimum bid price');
        }

        Bid::create([
            'user_id' => $this->userId,
            'ad_slot_id' => $this->adSlotId,
            'amount' => $this->amount,
        ]);
    }
}
