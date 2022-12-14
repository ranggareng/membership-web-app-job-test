<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;
use App\Models\States\Payment\PaymentState;

class Payment extends Model
{
    use HasFactory, HasStates;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'membership_plan_id',
        'amount'
    ];

    protected $casts = [
        'status' => PaymentState::class
    ];

    public function proofOfPayments()
    {
        return $this->hasMany(ProofOfPayment::class);
    }

    /**
     * Scope a query to only include pending state payment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePendingOrWaiting($query)
    {
        $query->whereState('status', \App\Models\States\Payment\Pending::class)
        ->orWhereState('status', \App\Models\States\Payment\WaitingConfirmation::class);;
    }


}
