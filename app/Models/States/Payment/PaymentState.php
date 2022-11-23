<?php

namespace App\Models\States\Payment;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class PaymentState extends State
{    
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, WaitingConfirmation::class)
            ->allowTransition(WaitingConfirmation::class, Paid::class)
            ->allowTransition(WaitingConfirmation::class, Pending::class)
        ;
    }
}