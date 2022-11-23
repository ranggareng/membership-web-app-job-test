<?php

namespace App\Http\Livewire\Membership;

use Livewire\Component;

// Model
use App\Models\Membership;

class PaymentInformation extends Component
{
    /** @var string */
    public $membership;

    public function mount($id)
    {
        $this->membership = Membership::find($id);
    }

    public function render()
    {
        return view('livewire.membership.payment-information', ['membership' => $this->membership])->extends('layouts.auth');
    }
}
