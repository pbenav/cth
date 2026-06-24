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

            if ($action === 'start') {
                // Si ya está trabajando en CTH (el próximo paso es clock_out o working_options),
                // no abrimos un nuevo turno ni damos error. Entendemos que es un cambio de puesto de trabajo en MTX.
                if (in_array($cthNextAction, ['clock_out', 'working_options'])) {
                    return response()->json([
                        'success' => true, 
                        'status' => 'already_working', 
                        'action_taken' => false, 
                        'message' => 'Cambio de puesto de trabajo en MTX, manteniendo turno de CTH activo.'
                    ]);
                }

                // Si no está trabajando, procedemos a iniciar el turno en CTH
                $eventTypeId = $clockAction['event_type_id'] ?? null;
                if (!$eventTypeId) {
                    // Buscar el tipo de evento de trabajo por defecto para garantizar el fichaje de entrada
                    $defaultEventType = \App\Models\EventType::where('is_work_time', true)->first();
                    $eventTypeId = $defaultEventType ? $defaultEventType->id : null;
                }

                if (!$eventTypeId) {
                    return response()->json(['message' => 'No event type available for clock in'], 400);
                }

                $overtime = $clockAction['overtime'] ?? false;
                $this->smartClockInService->clockIn($user, $eventTypeId, $overtime, 's2s_api', 'Sincronizado desde MTX');

                return response()->json(['success' => true, 'status' => 'started', 'action_taken' => true]);

            } elseif ($action === 'stop') {
                // El stop solo llega cuando el usuario pulsa explícitamente el botón terminar en MTX
                if (in_array($cthNextAction, ['clock_out', 'working_options'])) {
                    $openEventId = $clockAction['open_event_id'] ?? null;
                    if ($openEventId) {
                        $this->smartClockInService->clockOut($user, $openEventId);
                        return response()->json(['success' => true, 'status' => 'stopped', 'action_taken' => true]);
                    }
                }

                return response()->json(['success' => true, 'status' => 'not_working', 'action_taken' => false]);
            }

            return response()->json(['success' => true, 'action_taken' => false]);
        } catch (\Exception $e) {
            Log::error('S2S CTH Sync Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
