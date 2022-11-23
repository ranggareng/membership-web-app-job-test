<?php

namespace App\Http\Livewire\Membership;

use Livewire\Component;

class PaymentInformation extends Component
{
    public function render()
    {
        return view('livewire.membership.payment-information')->extends('layouts.auth');
    }
}
