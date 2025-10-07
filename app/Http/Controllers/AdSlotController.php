<?php

namespace App\Http\Controllers;

use App\Models\AdSlot;
use Illuminate\Http\Request;

class AdSlotController extends Controller
{
    public function index(Request $request)
    {
        $query = AdSlot::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'minimum_bid_price' => 'required|numeric|min:0',
        ]);

        $adSlot = AdSlot::create($request->all());
        return response()->json($adSlot, 201);
    }
}