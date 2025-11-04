<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Availability Exception Model
 *
 * Defines exceptions to regular availability (holidays, breaks, special hours).
 * Overrides availability templates for specific dates.
 */
class AvailabilityException extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'provider_id',
        'date',
        'start_time',
        'end_time',
        'reason',
        'is_unavailable',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'is_unavailable' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the provider for this availability exception.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Scope to filter by date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope to filter unavailable exceptions.
     */
    public function scopeUnavailable($query)
    {
        return $query->where('is_unavailable', true);
    }

    /**
     * Scope to filter available overrides.
     */
    public function scopeAvailableOverride($query)
    {
        return $query->where('is_unavailable', false);
    }
}
