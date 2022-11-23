<?php

namespace App\Http\Livewire\Membership\Auth;

use Livewire\Component;
use Illuminate\Validation\Rule;
use DB;
use Illuminate\Support\Facades\Hash;

// Model
use App\Models\Membership;
use App\Models\MembershipPlan;

class Register extends Component
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    /** @var string */
    public $membershipPlan = '';

    public function register()
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:memberships'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            'membershipPlan' => [
                'required', 
                Rule::exists('membership_plans', 'id')->where('status', 'active'),
            ]
        ]);

        DB::beginTransaction();
        try{
            $member = Membership::create([
                'email' => $this->email,
                'name' => $this->name,
                'password' => Hash::make($this->password),
                'membership_plan_id' => $this->membershipPlan
            ]);

            // Get Membership Plan
            $memberPlan = MembershipPlan::find($this->membershipPlan);

            $member->payments()->create([
                'membership_plan_id' => $this->membershipPlan,
                'amount' => $memberPlan->harga
            ]);

            DB::commit();
        }catch(\Exception $e){
            report($e);
            DB::rollBack();
            return redirect()->back();
        }

        // event(new Registered($user));

        // Auth::login($user, true);

        return redirect()->intended(route('membership.payment.info', [$member->id]));
    }

    public function render()
    {
        $membershipPlanList = MembershipPlan::active()->get();
        return view('livewire.membership.auth.register', compact('membershipPlanList'))->extends('layouts.auth');
    }
}
