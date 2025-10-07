<?php

namespace App\Http\Controllers;

use App\Models\AdSlot;
use App\Models\Bid;
use App\Models\BidWinner;
use App\Jobs\ProcessBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function placeBid(Request $request, $adSlotId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $adSlot = AdSlot::findOrFail($adSlotId);

        if ($adSlot->status !== 'open') {
            return response()->json(['error' => 'Ad slot is not open for bidding'], 400);
        }

        ProcessBid::dispatch(Auth::id(), $adSlotId, $request->amount);

        return response()->json(['message' => 'Bid placed successfully'], 202);
    }

    public function getBids($adSlotId)
    {
        $bids = Bid::where('ad_slot_id', $adSlotId)->with('user')->get();
        return response()->json($bids);
    }

    public function getWinningBid($adSlotId)
    {
        $winner = BidWinner::where('ad_slot_id', $adSlotId)->with('user')->first();
        return response()->json($winner ?: ['message' => 'No winner yet']);
    }

    public function getUserBids()
    {
        $bids = Bid::where('user_id', Auth::id())->with('adSlot')->get();
        return response()->json($bids);
    }
}