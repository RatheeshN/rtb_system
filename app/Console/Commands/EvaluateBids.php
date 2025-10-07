<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdSlot;
use App\Models\BidWinner;

class EvaluateBids extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bids:evaluate';
    protected $description = 'Evaluate bids for closed ad slots and select winners';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $closedSlots = AdSlot::where('status', 'closed')->get();

        foreach ($closedSlots as $slot) {
            $winningBid = $slot->bids()
                ->orderBy('amount', 'desc')
                ->orderBy('created_at', 'asc')
                ->first();

            if ($winningBid) {
                BidWinner::create([
                    'ad_slot_id' => $slot->id,
                    'bid_id' => $winningBid->id,
                    'user_id' => $winningBid->user_id,
                    'amount' => $winningBid->amount,
                ]);

                $slot->update(['status' => 'awarded']);
            }
        }
    }
}
