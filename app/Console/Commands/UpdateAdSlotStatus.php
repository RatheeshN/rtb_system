<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdSlot;
use Carbon\Carbon;

class UpdateAdSlotStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adslot:update-status';
    protected $description = 'Update ad slot statuses based on start and end times';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        AdSlot::where('status', 'upcoming')
            ->where('start_time', '<=', Carbon::now())
            ->update(['status' => 'open']);

        AdSlot::where('status', 'open')
            ->where('end_time', '<=', Carbon::now())
            ->update(['status' => 'closed']);
    }
}