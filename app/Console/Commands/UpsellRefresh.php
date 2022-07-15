<?php

namespace App\Console\Commands;

use App\Models\orders;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpsellRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upsell:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This chron will be used to refresh the orders status.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $date = new DateTime;
        $date->modify('-15 minutes');
        $now = $date->format('Y-m-d H:i:s');
        $orders = orders::where([['created_at', '<=', $now],['shopify_order_number', '=', null]])->latest()->get();
        foreach ($orders as $order) {
            $order->update(['shopify_order_number' => 'dummy', 'shopify_order_name' => 'dummy', 'shopify_order_id' => 'dummy']);
        }
    }
}
