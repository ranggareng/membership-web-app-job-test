<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'membership_id',
        'name',
        'email',
        'password',
        'status',
        'expire_at',
        'membership_plan_id'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only include pending membership.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePending($query)
    {
        $query->where('status', 'pending');
    }
}
