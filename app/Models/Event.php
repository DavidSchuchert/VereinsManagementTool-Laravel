<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'max_attendees',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    /**
     * Get attendances for this event.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    /**
     * Scope for upcoming events.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('event_date', '>=', now())->orderBy('event_date', 'asc');
    }

    /**
     * Scope for past events.
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('event_date', '<', now())->orderBy('event_date', 'desc');
    }

    /**
     * Check if event is full.
     */
    public function isFull(): bool
    {
        if (!$this->max_attendees) return false;
        return $this->attendances()->count() >= $this->max_attendees;
    }
}
