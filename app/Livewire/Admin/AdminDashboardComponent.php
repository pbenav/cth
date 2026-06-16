<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminDashboardComponent extends Component
{
    public function render()
    {
        // 1. Total statistics
        $totalUsers = User::count();
        $totalTeams = Team::count();
        $totalEvents = Event::count();

        // 2. Team distribution
        $personalTeams = Team::where('personal_team', true)->count();
        $sharedTeams = $totalTeams - $personalTeams;

        // 3. Most active teams (by number of events)
        $mostActiveTeams = Team::with('owner')
            ->withCount('events')
            ->orderByDesc('events_count')
            ->take(5)
            ->get();

        // 4. Orphan or problematic teams (no owner)
        $orphanTeamsCount = Team::whereNull('user_id')
            ->orWhereNotIn('user_id', User::select('id'))
            ->count();

        // 5. User roles distribution
        $globalAdmins = User::where('is_admin', true)->count();

        // 6. Recent system activity (last 7 days events)
        $recentActivity = Event::where('created_at', '>=', now()->subDays(7))->count();

        return view('livewire.admin.admin-dashboard-component', [
            'totalUsers' => $totalUsers,
            'totalTeams' => $totalTeams,
            'totalEvents' => $totalEvents,
            'personalTeams' => $personalTeams,
            'sharedTeams' => $sharedTeams,
            'mostActiveTeams' => $mostActiveTeams,
            'orphanTeamsCount' => $orphanTeamsCount,
            'globalAdmins' => $globalAdmins,
            'recentActivity' => $recentActivity,
        ])->layout('layouts.app');
    }
}
