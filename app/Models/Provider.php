<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Provider Model
 *
 * Represents service providers who manage availability and fulfill bookings.
 * Each provider is linked to a user account and has their own schedule.
 */
class Provider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'specialty',
        'bio',
        'timezone',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the provider profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all bookings for this provider.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get availability templates for this provider.
     */
    public function availabilityTemplates(): HasMany
    {
        return $this->hasMany(AvailabilityTemplate::class);
    }

    /**
     * Get availability exceptions for this provider.
     */
    public function availabilityExceptions(): HasMany
    {
        return $this->hasMany(AvailabilityException::class);
    }

    /**
     * Scope to get only active providers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get upcoming bookings for this provider.
     */
    public function upcomingBookings(): HasMany
    {
        return $this->bookings()
            ->where('start_time', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('start_time');
    }

    /**
     * Get today's bookings for this provider.
     */
    public function todaysBookings(): HasMany
    {
        return $this->bookings()
            ->whereDate('start_time', now()->toDateString())
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->orderBy('start_time');
    }
}
