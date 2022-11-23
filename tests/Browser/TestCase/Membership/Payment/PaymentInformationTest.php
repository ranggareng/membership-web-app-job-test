<?php

namespace Tests\Browser\TestCase\Membership\Payment;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// Model
use App\Models\MembershipPlan;
use App\Models\Membership;
use App\Models\Payment;

class PaymentInformationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function cekPaymentInformation()
    {
        $this->browse(function (Browser $browser) {
            $memberPlan = MembershipPlan::factory()->create();
            $member = Membership::factory(['membership_plan_id' => $memberPlan->id])
                    ->has(Payment::factory(['membership_plan_id' => $memberPlan->id])->count(1))
                    ->create();
            
            $browser->visit(route('membership.payment.info',[$member->id]))
                    ->assertSee($member->name);
        });
    }
}
