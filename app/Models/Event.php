<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\TimeDiff;
use App\Traits\InsertHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    use TimeDiff;
    use InsertHistory;

    protected $fillable = [
        'user_id',
        'event_type_id',
        'start',
        'end',
        'is_open',
        'description',
        'observations'
    ];

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPeriod()
    {
        return $this->timeDiff($this->start, $this->end, true);
    }

    public function confirm()
    {
        error_log('Confirm...');
        if ($this->is_open == 1) {
            $this->is_open = 0;
        }
        $this->save();
    }

    public function toggleConfirm()
    {
        $orig_ev = clone $this;        
        $this->is_open = !$this->is_open;
        $this->save();
        if (auth()->user()->isTeamAdmin()) {
            $this->insertHistory('events', $orig_ev, $this);
        }
        unset($orig_ev);
    }


    public function scopeUserId(Builder $query, $scope)
    {
        return $query->where('user_id', $scope);
    }

    public function scopeMonth(Builder $query, $scope)
    {
        return $query->whereMonth('start', $scope);
    }

    public function scopeDay(Builder $query, $scope)
    {
        return $query->whereDay('start', $scope);
    }

    public function scopeDescription(Builder $query, $scope)
    {
        return $query->where('description', $scope);
    }

    public function scopeIsOpen(Builder $query)
    {
        return $query->where('is_open', '=', 1);
    }

    public function scopeEventsPerUserMonth(Builder $query, $user_id, $month, $year, $description)
    {
        return $query->selectRaw('user_id as user_id, DAY(start) as day,
                                    MONTH(start) as month,
                                    SUM(TIMESTAMPDIFF(minute, start, end))/60 as hours,
                                    description')
            ->where('user_id', $user_id)
            ->where('description', 'like', '%' . $description . '%')
            ->whereMonth('start', $month)
            ->whereYear('start', $year)
            ->groupBy('user_id', 'start', 'description')
            ->get();
    }


    public function scopefilterEvents(Builder $query, $start, $end, $user_id, $is_open)
    {
        return $query->select('id, user_id, start, end, is_open, observations')
            ->where('start', '>=', Carbon::parse($start))
            ->where('end', '<=', Carbon::parse($end))
            ->where('user_id', $user_id)
            ->where('is_open', $is_open)
            ->orderBy('start', 'asc')
            ->get();
    }
}
