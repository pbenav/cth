<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class VerifyAndFixEventData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:verify-and-fix {--dry-run : Show what would be fixed without making changes} {--fix-descriptions : Fix events without descriptions} {--fix-extra-hours : Fix extra hours logic} {--fix-workday-types : Fix workday event types} {--fix-legacy-autoclose : Fix old 1-minute autoclose records to new 1-hour standard}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify and fix event data inconsistencies in production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $fixDescriptions = $this->option('fix-descriptions');
        $fixExtraHours = $this->option('fix-extra-hours');
        $fixWorkdayTypes = $this->option('fix-workday-types');
        $fixLegacy = $this->option('fix-legacy-autoclose');

        if ($dryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
        }

        $this->info('🔍 Starting event data verification...');

        $totalFixed = 0;

        // Run specific fixes
        if ($fixWorkdayTypes || (!$fixDescriptions && !$fixExtraHours && !$fixWorkdayTypes && !$fixLegacy)) {
            $totalFixed += $this->fixWorkdayEventTypes($dryRun);
        }

        if ($fixDescriptions || (!$fixDescriptions && !$fixExtraHours && !$fixWorkdayTypes && !$fixLegacy)) {
            $totalFixed += $this->fixEventDescriptions($dryRun);
        }

        if ($fixExtraHours || (!$fixDescriptions && !$fixExtraHours && !$fixWorkdayTypes && !$fixLegacy)) {
            $totalFixed += $this->fixExtraHoursLogic($dryRun);
        }

        if ($fixLegacy || (!$fixDescriptions && !$fixExtraHours && !$fixWorkdayTypes && !$fixLegacy)) {
            $totalFixed += $this->fixLegacyAutoCloseEvents($dryRun);
        }

        // Run verification checks
        $this->runVerificationChecks();

        if ($totalFixed > 0) {
            if ($dryRun) {
                $this->warn("🔧 Would fix {$totalFixed} issues (run without --dry-run to apply changes)");
            } else {
                $this->info("✅ Fixed {$totalFixed} issues successfully!");
            }
        } else {
            $this->info("✅ No issues found - everything looks good!");
        }

        return 0;
    }

    /**
     * Fix old 1-minute auto-closed events to the new 1-hour standard with proper translation.
     */
    private function fixLegacyAutoCloseEvents(bool $dryRun): int
    {
        $this->line("\n🧹 Cleaning up legacy 1-minute auto-closed registrations...");

        $oldMessage = 'Closed automatically due to expiration. Duration set to 1 minute.';
        
        $events = Event::where('observations', 'like', '%' . $oldMessage . '%')
            ->with('user')
            ->get();

        if ($events->isEmpty()) {
            $this->info("   ✅ No legacy 1-minute auto-closed events found.");
            return 0;
        }

        $this->warn("   ⚠️  Found {$events->count()} legacy auto-closed events that need updating.");

        if (!$dryRun) {
            $fixed = 0;
            foreach ($events as $event) {
                $user = $event->user;
                $locale = ($user && $user->locale) ? $user->locale : 'es';
                App::setLocale($locale);

                // Use the new standard message
                $newMessage = __('The record is closed with a single hour because it had no exit date or confirmed closure.');
                
                // Adjust duration to exactly 1 hour from start
                $newEnd = Carbon::parse($event->start)->addHour();

                $event->updateQuietly([
                    'end' => $newEnd->format('Y-m-d H:i:s'),
                    'observations' => str_replace($oldMessage, $newMessage, $event->observations)
                ]);
                $fixed++;
            }
            $this->info("   ✅ Updated {$fixed} legacy registrations to the new 1-hour standard.");
            return $fixed;
        }

        return $events->count();
    }

    /**
     * Fix workday event types
     */
    private function fixWorkdayEventTypes(bool $dryRun): int
    {
        $this->line("\n📋 Checking workday event types...");

        $toFix = EventType::where('name', 'Jornada laboral')
            ->where('is_workday_type', false)
            ->count();

        if ($toFix === 0) {
            $this->info("   ✅ All 'Jornada laboral' event types are correctly marked as workday types");
            return 0;
        }

        $this->warn("   ⚠️  Found {$toFix} 'Jornada laboral' event types not marked as workday types");

        if (!$dryRun) {
            EventType::where('name', 'Jornada laboral')
                ->where('is_workday_type', false)
                ->update(['is_workday_type' => true]);
            $this->info("   ✅ Fixed {$toFix} workday event types");
        }

        return $toFix;
    }

    /**
     * Fix event descriptions
     */
    private function fixEventDescriptions(bool $dryRun): int
    {
        $this->line("\n📝 Checking event descriptions...");

        $toFix = Event::leftJoin('event_types', 'events.event_type_id', '=', 'event_types.id')
            ->where(function ($query) {
                $query->whereNull('events.description')
                      ->orWhere('events.description', '')
                      ->orWhere('events.description', 'null');
            })
            ->whereNotNull('event_types.name')
            ->count();

        $orphans = Event::where(function ($query) {
                $query->whereNull('description')
                      ->orWhere('description', '')
                      ->orWhere('description', 'null');
            })
            ->whereNull('event_type_id')
            ->count();

        if ($toFix === 0 && $orphans === 0) {
            $this->info("   ✅ All events have proper descriptions");
            return 0;
        }

        if ($toFix > 0) {
            $this->warn("   ⚠️  Found {$toFix} events without descriptions (have event type)");
        }

        if ($orphans > 0) {
            $this->warn("   ⚠️  Found {$orphans} events without descriptions (no event type)");
        }

        if (!$dryRun) {
            $fixed = 0;

            if ($toFix > 0) {
                $fixed += DB::update("
                    UPDATE events 
                    LEFT JOIN event_types ON events.event_type_id = event_types.id 
                    SET events.description = event_types.name
                    WHERE (events.description IS NULL OR events.description = '' OR events.description = 'null')
                    AND event_types.name IS NOT NULL
                ");
            }

            if ($orphans > 0) {
                $fixed += DB::update("
                    UPDATE events 
                    SET description = 'Evento de trabajo' 
                    WHERE (description IS NULL OR description = '' OR description = 'null')
                    AND event_type_id IS NULL
                ");
            }

            $this->info("   ✅ Fixed {$fixed} event descriptions");
            return $fixed;
        }

        return $toFix + $orphans;
    }

    /**
     * Fix extra hours logic
     */
    private function fixExtraHoursLogic(bool $dryRun): int
    {
        $this->line("\n⏰ Checking extra hours logic...");

        // Count events that need fixing
        $toFix = DB::select("
            SELECT COUNT(*) as count FROM events 
            LEFT JOIN event_types ON events.event_type_id = event_types.id 
            WHERE events.is_extra_hours != CASE 
                WHEN event_types.is_workday_type = 1 THEN 0 
                ELSE 1 
            END
        ")[0]->count;

        if ($toFix === 0) {
            $this->info("   ✅ All events have correct extra hours logic");
            return 0;
        }

        $this->warn("   ⚠️  Found {$toFix} events with incorrect extra hours logic");

        if (!$dryRun) {
            $fixed = DB::update("
                UPDATE events 
                LEFT JOIN event_types ON events.event_type_id = event_types.id 
                SET events.is_extra_hours = CASE 
                    WHEN event_types.is_workday_type = 1 THEN 0 
                    ELSE 1 
                END
                WHERE events.is_extra_hours != CASE 
                    WHEN event_types.is_workday_type = 1 THEN 0 
                    ELSE 1 
                END
            ");

            $this->info("   ✅ Fixed {$fixed} events with extra hours logic");
            return $fixed;
        }

        return $toFix;
    }

    /**
     * Run verification checks
     */
    private function runVerificationChecks(): void
    {
        $this->line("\n🔍 Running verification checks...");

        // Check for events without event types
        $eventsWithoutType = Event::whereNull('event_type_id')->count();
        if ($eventsWithoutType > 0) {
            $this->warn("   ⚠️  {$eventsWithoutType} events without event type");
        }

        // Check for workday event types count
        $workdayTypes = EventType::where('is_workday_type', true)->count();
        $totalTeams = EventType::distinct('team_id')->count('team_id');
        
        if ($workdayTypes < $totalTeams) {
            $this->warn("   ⚠️  Only {$workdayTypes} workday event types for {$totalTeams} teams");
        } else {
            $this->info("   ✅ {$workdayTypes} workday event types for {$totalTeams} teams");
        }

        // Check for events with null descriptions
        $nullDescriptions = Event::whereNull('description')->count();
        $emptyDescriptions = Event::where('description', '')->count();
        
        if ($nullDescriptions > 0 || $emptyDescriptions > 0) {
            $this->warn("   ⚠️  {$nullDescriptions} events with null descriptions, {$emptyDescriptions} with empty descriptions");
        } else {
            $this->info("   ✅ All events have descriptions");
        }

        $this->line("");
    }
}
