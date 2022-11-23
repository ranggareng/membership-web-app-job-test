<?php

namespace App\Http\Livewire\Membership;

use Livewire\Component;
use Illuminate\Validation\Rule;
use DB;

// Model
use App\Models\Membership;

class PaymentConfirmation extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $amount = '';

    /** @var string */
    public $paymentName = '';

    /** @var string */
    public $paymentFrom = '';

    /** @var string */
    public $paymentFromNumber = '';

    public function submit()
    {
        $this->validate([
            'email' => [
                'required', 
                'email', 
                Rule::exists('memberships', 'email')->where('status', 'pending'),
            ],
            'amount' => ['required', 'digits_between:1,8'],
            'paymentName' => ['required'],            
            'paymentFromNumber' => ['required'],
            'paymentFrom' => ['required', 'in:bca,bni,bri,mandiri,others']
        ]);

        DB::beginTransaction();
        try{
            $member = Membership::whereEmail($this->email)->pending()->first();
            $payment = $member->payments()->pendingOrWaiting()->first();

            $payment->proofOfPayments()->create([
                'amount' => $this->amount,
                'payment_from' => $this->paymentFrom,
                'payment_from_name' => $this->paymentName,
                'payment_from_number' => $this->paymentFromNumber
            ]);

            if($payment->status->canTransitionTo(\App\Models\States\Payment\WaitingConfirmation::class))
                $payment->status->transitionTo(\App\Models\States\Payment\WaitingConfirmation::class);

            DB::commit();
            $this->reset();
            session()->flash('message', 'Proof of Payments successfully added');
        }catch(\Exception $e){
            report($e);
            DB::rollBack();
            session()->flash('message', $e->getMessage());
        }        
    }

    public function render()
    {
        return view('livewire.membership.payment-confirmation')->extends('layouts.auth');
    }
}
