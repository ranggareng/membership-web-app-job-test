<?php

namespace Tests\Browser\TestCase\Membership\Payment;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// Model
use App\Models\MembershipPlan;
use App\Models\Membership;
use App\Models\Payment;

class PaymentConfirmation extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function emailFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#submit')
                ->assertSee('The email field is required.');
        });
    }

    /** @test */
    public function emailMustBeValidEmail()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#email", "invalid-email-address")
                ->pressAndWaitFor('#submit')
                ->assertSee('The email must be a valid email address.');
        });
    }

    /** @test */
    public function emailMustBeExsistingEmail()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#email", "mochamad.rangga@gmail.com")
                ->pressAndWaitFor('#submit')
                ->assertSee('The selected email is invalid.');
        });
    }

    /** @test */
    public function paymentFormFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#submit')
                ->assertSee('The payment from field is required.');
        });
    }

    /** @test */
    public function bankAccountNameFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#submit')
                ->assertSee('The payment name field is required.');
        });
    }

    /** @test */
    public function bankAccountNumberFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#submit')
                ->assertSee('The payment from number field is required.');
        });
    }

    /** @test */
    public function amountFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#submit')
                ->assertSee('The amount field is required.');
        });
    }

    /** @test */
    public function amountFieldMustBeBetween1DigitTo8Digit()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#amount", "12345678901")
                ->pressAndWaitFor('#submit')
                ->assertSee('The amount must be between 1 and 8 digits.');
        });
    }

    /** @test */
    public function canSubmit()
    {
        $memberPlan = MembershipPlan::factory()->create();
        $member = Membership::factory(['membership_plan_id' => $memberPlan->id, 'status' => 'pending'])
                ->has(Payment::factory(['membership_plan_id' => $memberPlan->id])->count(1))
                ->create();

        $this->browse(function (Browser $browser) use($member){
            $browser->visit(route('membership.payment.confirmation'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#email", $member->email)
                ->select("#payment_from", 'bca')
                ->type("#payment_name", "rangga")
                ->type("#payment_from_number", "1234567890")
                ->type("#amount", "250000")
                ->pressAndWaitFor('#submit')
                ->pause(2000)
                ->assertSee('Proof of Payments successfully added');
        });
    }
}
