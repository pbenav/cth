<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class SyncHistoryWithMtx extends Command
{
    protected $signature = 'mtx:sync-history {--from= : The start date in YYYY-MM-DD format} {--y : Automatically confirm the destructive action}';
    protected $description = 'Synchronize historical workday events from CTH to MTX';

    public function handle()
    {
        $fromDateStr = $this->option('from');
        if (!$fromDateStr) {
            $this->error('Please provide a --from date. Example: --from=2026-01-01');
            return 1;
        }

        try {
            $fromDate = \Carbon\Carbon::parse($fromDateStr)->startOfDay();
        } catch (\Exception $e) {
            $this->error('Invalid date format. Please use YYYY-MM-DD');
            return 1;
        }

        $this->warn("⚠️ ATENCIÓN: Esta acción reemplazará todos los registros de jornada en MTX a partir del " . $fromDate->toDateString() . ".");
        $this->warn("Cualquier registro de jornada (workday) creado manualmente en MTX después de esta fecha será eliminado de forma permanente.");
        
        if (!$this->option('y') && !$this->confirm('¿Estás seguro de que deseas continuar con la sincronización?')) {
            $this->info('Operación cancelada por el usuario.');
            return 0;
        }

        $this->info("Fetching workday events from " . $fromDate->toDateString() . "...");

        // Fetch events
        $events = Event::whereHas('eventType', function($q) {
                $q->where('is_workday_type', true);
            })
            ->where('start', '>=', $fromDate->copy()->setTimezone('UTC')->format('Y-m-d H:i:s'))
            ->with('user')
            ->orderBy('start', 'asc')
            ->get();

        if ($events->isEmpty()) {
            $this->info("No events found to sync.");
            return 0;
        }

        $payloadEvents = [];
        foreach ($events as $event) {
            if (!$event->user || !$event->user->email) continue;

            $payloadEvents[] = [
                'email' => $event->user->email,
                'start_at' => \Carbon\Carbon::parse($event->start, 'UTC')->toIso8601String(),
                'end_at' => ($event->end && !$event->is_open) ? \Carbon\Carbon::parse($event->end, 'UTC')->toIso8601String() : null,
            ];
        }

        $mtxUrl = config('services.mtx.url');
        $mtxSecret = config('services.mtx.secret');

        if (!$mtxUrl || !$mtxSecret) {
            $this->error('MTX URL or Secret is not configured in services.php');
            return 1;
        }

        $this->info("Found " . count($payloadEvents) . " events. Pushing to MTX...");

        $response = Http::withHeaders([
            'X-S2S-Secret' => $mtxSecret,
            'Accept' => 'application/json',
        ])->post(rtrim($mtxUrl, '/') . '/api/s2s/sync-history', [
            'from_date' => $fromDate->copy()->setTimezone('UTC')->toIso8601String(),
            'events' => $payloadEvents
        ]);

        if ($response->successful()) {
            $this->info("Synchronization completed successfully.");
            return 0;
        } else {
            $this->error("Failed to sync. MTX responded with: " . $response->status() . " " . $response->body());
            return 1;
        }
    }
}
