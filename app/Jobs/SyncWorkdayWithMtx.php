<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncWorkdayWithMtx implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $cthAction; // 'start' or 'stop'
    public $source;
    public $timestamp;

    public function __construct(string $email, string $cthAction, string $source = null, string $timestamp = null)
    {
        $this->email = $email;
        $this->cthAction = $cthAction;
        $this->source = $source;
        $this->timestamp = $timestamp;
    }

    public function handle(): void
    {
        // Avoid infinite loop if the request came from MTX
        if ($this->source === 's2s_api') {
            return;
        }

        $user = \App\Models\User::where('email', $this->email)->first();
        $userSecret = $user ? $user->meta()->where('meta_key', 'mtx_s2s_secret')->value('meta_value') : null;
        
        $apiUrl = rtrim(config('services.mtx.url'), '/');
        $secret = $userSecret ?: config('services.mtx.secret');

        if (!$apiUrl || !$secret) {
            Log::warning('MTX Sync: Missing MTX URL or Secret for user', ['email' => $this->email]);
            return; // Not configured
        }

        try {
            $payload = [
                'email' => $this->email,
                'action' => $this->cthAction,
            ];
            
            if ($this->timestamp) {
                $payload['timestamp'] = $this->timestamp;
            }

            $response = Http::timeout(5)->withHeaders(['X-S2S-Secret' => $secret])
                ->withToken($secret)
                ->acceptJson()
                ->post($apiUrl . '/api/s2s/sync-workday', $payload);

            if (!$response->successful()) {
                if ($response->status() !== 404) {
                    Log::error('MTX Sync: Failed to sync with MTX via S2S', ['email' => $this->email, 'status' => $response->status(), 'response' => $response->body()]);
                }
            } else {
                Log::info('MTX Sync: Successfully synced ' . $this->cthAction . ' to MTX', ['email' => $this->email]);
            }
        } catch (\Exception $e) {
            Log::error('MTX Sync Exception: ' . $e->getMessage(), ['email' => $this->email]);
        }
    }
}
