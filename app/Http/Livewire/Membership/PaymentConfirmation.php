<?php

namespace App\Http\Livewire\Membership;

use Livewire\Component;

class PaymentConfirmation extends Component
{
    public function render()
    {
        return view('livewire.membership.payment-confirmation')->extends('layouts.auth');
    }
}
