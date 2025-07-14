<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;

class ShowBookingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show:bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all bookings with their status and dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bookings = Booking::with('rentalUnit')->get();
        
        if ($bookings->isEmpty()) {
            $this->info('No bookings found in the database.');
            return;
        }
        
        $headers = ['ID', 'Status', 'Start Date', 'End Date', 'Is Future', 'Unit', 'Cancel Button Visible'];
        
        $rows = [];
        foreach ($bookings as $booking) {
            $isFuture = $booking->start_date->isFuture();
            $cancelVisible = ($booking->status !== 'cancelled' && $booking->status !== 'completed' && $isFuture);
            
            $rows[] = [
                $booking->booking_id,
                $booking->status,
                $booking->start_date->format('Y-m-d'),
                $booking->end_date->format('Y-m-d'),
                $isFuture ? 'Yes' : 'No',
                $booking->rentalUnit->address ?? 'Unknown',
                $cancelVisible ? 'Yes' : 'No'
            ];
        }
        
        $this->table($headers, $rows);
        $this->info('Total bookings: ' . count($bookings));
    }
}
