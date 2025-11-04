<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Service Model
 *
 * Represents bookable services with duration, pricing, and configuration.
 */
class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'description',
        'duration_minutes',
        'buffer_time_minutes',
        'price',
        'requires_deposit',
        'deposit_amount',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration_minutes' => 'integer',
        'buffer_time_minutes' => 'integer',
        'price' => 'decimal:2',
        'requires_deposit' => 'boolean',
        'deposit_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all bookings for this service.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope to get only active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the total duration including buffer time.
     */
    public function getTotalDurationMinutesAttribute(): int
    {
        return $this->duration_minutes + $this->buffer_time_minutes;
    }

    /**
     * Check if service requires a deposit.
     */
    public function requiresDeposit(): bool
    {
        return !is_null($this->deposit_amount) && $this->deposit_amount > 0;
    }
}
