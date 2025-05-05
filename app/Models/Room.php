<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the reservations for the room.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Check if the room is available at the given time.
     *
     * @param \DateTime $startTime
     * @return bool
     */
    public function isAvailable(\DateTime $startTime)
    {
        $endTime = (clone $startTime)->modify('+1 hour');
        
        return !$this->reservations()
            ->where('status', '!=', 'rejected')
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();
    }
}