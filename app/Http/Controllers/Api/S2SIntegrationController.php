<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmartClockInService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class S2SIntegrationController extends Controller
{
    protected $smartClockInService;

    public function __construct(SmartClockInService $smartClockInService)
    {
        $this->smartClockInService = $smartClockInService;
    }

    public function syncWorkday(Request $request)
    {
        // Simple shared secret validation
        $secret = config('services.mtx.secret');
        if (!$secret || $request->header('X-S2S-Secret') !== $secret) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $email = $request->input('email');
        $action = $request->input('action'); // 'start' or 'stop'

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        try {
            $clockAction = $this->smartClockInService->getClockAction($user);
            $cthNextAction = $clockAction['action'] ?? null;
            $cthCanClock = $clockAction['can_clock'] ?? false;

            $shouldClock = false;
            if ($action === 'start' && in_array($cthNextAction, ['clock_in', 'confirm_exceptional_clock_in'])) {
                $shouldClock = true;
            } elseif ($action === 'stop' && in_array($cthNextAction, ['clock_out', 'working_options'])) {
                $shouldClock = true;
            }

            if ($shouldClock) {
                // Determine event type for clock in
                if ($action === 'start') {
                    $eventTypeId = $clockAction['event_type_id'] ?? null;
                    if (!$eventTypeId) {
                        return response()->json(['message' => 'No event type available for clock in'], 400);
                    }
                    $overtime = $clockAction['overtime'] ?? false;
                    $this->smartClockInService->clockIn($user, $eventTypeId, $overtime, 's2s_api', 'Sincronizado desde MTX');
                } else {
                    $openEventId = $clockAction['open_event_id'] ?? null;
                    if ($openEventId) {
                        $this->smartClockInService->clockOut($user, $openEventId);
                    }
                }
            }

            return response()->json(['success' => true, 'action_taken' => $shouldClock]);
        } catch (\Exception $e) {
            Log::error('S2S CTH Sync Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
