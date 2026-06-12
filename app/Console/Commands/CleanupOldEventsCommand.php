<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CleanupOldEventsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:cleanup {--dry-run : Muestra cuántos eventos se borrarían sin borrarlos realmente}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina los eventos antiguos basándose en el período de retención configurado por cada equipo (event_retention_months).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando limpieza de eventos antiguos...');
        Log::info('CleanupOldEventsCommand: Iniciando limpieza de eventos.');

        $isDryRun = $this->option('dry-run');
        if ($isDryRun) {
            $this->warn('Modo DRY-RUN activado. No se eliminará ningún registro.');
        }

        // Obtener todos los equipos que tengan configurado un periodo de retención.
        // Si por algún motivo event_retention_months es nulo, usaremos 60 meses por defecto.
        $teams = Team::all();
        $totalDeleted = 0;

        foreach ($teams as $team) {
            $retentionMonths = $team->event_retention_months ?? 60;
            $cutoffDate = Carbon::now()->subMonths($retentionMonths);

            // Contar cuántos eventos de este equipo son anteriores a la fecha de corte
            $query = Event::where('team_id', $team->id)
                          ->where('start', '<', $cutoffDate);
            
            $count = $query->count();

            if ($count > 0) {
                if ($isDryRun) {
                    $this->line("El equipo [{$team->name}] (ID: {$team->id}) tiene {$count} eventos anteriores al {$cutoffDate->format('Y-m-d')} listos para borrar.");
                } else {
                    $this->line("Eliminando {$count} eventos antiguos del equipo [{$team->name}] (ID: {$team->id})...");
                    
                    // Nota: Se usa chunk() y delete() en lugar de un delete() masivo para que
                    // se lancen los eventos Eloquent (si es necesario) y para evitar bloqueos masivos,
                    // aunque si hay millones de registros, un borrado crudo podría ser mejor.
                    // En este caso, para asegurar limpieza correcta (cascade, observers, auditoría), usamos bulk delete si no importa la auditoría de cada registro antiguo, 
                    // pero como son datos muy antiguos, un borrado directo en DB suele ser lo más eficiente.
                    
                    // Borrado masivo para mayor eficiencia (no deja rastro en events_history para no llenarlo de basura inútil)
                    $deleted = $query->delete();
                    $totalDeleted += $deleted;
                    
                    Log::info("CleanupOldEventsCommand: Eliminados {$deleted} eventos del equipo {$team->id} (anteriores a {$cutoffDate->format('Y-m-d')}).");
                }
            }
        }
        
        // Tratar eventos huérfanos (team_id = null)
        // Aplicamos el límite de retención por defecto de 5 años (60 meses)
        $orphanCutoffDate = Carbon::now()->subMonths(60);
        $orphanQuery = Event::whereNull('team_id')
                            ->where('start', '<', $orphanCutoffDate);
                            
        $orphanCount = $orphanQuery->count();
        if ($orphanCount > 0) {
            if ($isDryRun) {
                $this->line("Hay {$orphanCount} eventos huérfanos (sin equipo) anteriores al {$orphanCutoffDate->format('Y-m-d')} listos para borrar.");
            } else {
                $this->line("Eliminando {$orphanCount} eventos huérfanos...");
                $deleted = $orphanQuery->delete();
                $totalDeleted += $deleted;
                Log::info("CleanupOldEventsCommand: Eliminados {$deleted} eventos huérfanos (anteriores a {$orphanCutoffDate->format('Y-m-d')}).");
            }
        }

        if ($isDryRun) {
            $this->info("Simulación terminada. Se eliminarían un total de {$totalDeleted} (o más) eventos.");
        } else {
            $this->info("Limpieza finalizada exitosamente. Total de eventos eliminados: {$totalDeleted}");
            Log::info("CleanupOldEventsCommand: Finalizado. Total eventos eliminados: {$totalDeleted}");
        }

        return self::SUCCESS;
    }
}
