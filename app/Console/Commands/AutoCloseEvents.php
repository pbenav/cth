<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class AutoCloseEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:autoclose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically closes and fixes inconsistent workday events (too long or forgotten open).';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🚀 Starting AutoCloseEvents command...');
        Log::info('Starting AutoCloseEvents command (Full Scan mode)...');

        $totalFixed = 0;

        // 1. FIXED INCOHERENT RECORDS (duration > 24h or missing end)
        // We look for all workday events that lasted more than a day or are still open after 24h
        $events = Event::whereHas('eventType', function($q) {
                $q->where('is_workday_type', true);
            })
            ->where(function($query) {
                $query->where(function($q) {
                    // Already closed but duration > 24h
                    $q->where('is_open', false)
                      ->whereNotNull('end')
                      ->whereRaw('TIMESTAMPDIFF(HOUR, start, end) >= 24');
                })
                ->orWhere(function($q) {
                    // Still open and started more than 24h ago
                    $q->where('is_open', true)
                      ->where('start', '<', Carbon::now()->subDay());
                });
            })
            ->with('user')
            ->get();

        $this->info("🔍 Found {$events->count()} events that need fixing.");

        foreach ($events as $event) {
            $user = $event->user;
            
            // Set locale for translations based on user preference
            $locale = $user->locale ?: config('app.locale', 'es');
            App::setLocale($locale);

            $oldStatus = $event->is_open ? 'OPEN' : 'CLOSED_TOO_LONG';
            
            // Requirements:
            // 1. Duration must be exactly 1 hour from start
            $correctedEnd = Carbon::parse($event->start)->addHour();
            
            // 2. Observations message based on case
            if ($event->is_open) {
                $comment = __('The record is closed with a single hour because it had no exit date or confirmed closure.');
            } else {
                $comment = __('The record is closed because its duration exceeds the maximum workday value and is therefore invalid.');
            }

            Log::info("Fixing event {$event->id} [{$oldStatus}] for user {$user->id}. Setting duration to 1 hour.");

            $event->updateQuietly([
                'end' => $correctedEnd,
                'is_open' => false,
                'is_closed_automatically' => true,
                'observations' => trim(($event->observations ? $event->observations . " \n" : '') . $comment),
            ]);

            $totalFixed++;
        }

        // 3. TEAM SPECIFIC EXPIRATION (Optional double check for team-policy closures if needed)
        // But the requirements above cover all "incoherent" (>24h) workday records.

        Log::info("AutoCloseEvents command finished. Total fixed: {$totalFixed}");
        $this->info("✅ Command finished. Fixed {$totalFixed} events.");
        
        return 0;
    }
}
