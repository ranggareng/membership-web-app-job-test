<?php

namespace Tests\Browser\TestCase\Membership\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// Model
use App\Models\Membership;
use App\Models\MembershipPlan;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function nameFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#register')
                ->assertSee('The name field is required.');
        });
    }

    /** @test */
    public function emailFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#register')
                ->assertSee('The email field is required.');
        });
    }

    /** @test */
    public function emailMustBeValidEmail()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#email", "invalid-email-address")
                ->pressAndWaitFor('#register')
                ->assertSee('The email must be a valid email address.');
        });
    }

    /** @test */
    public function membershipPlanIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#register')
                ->assertSee('The membership plan field is required.');
        });
    }

    /** @test */
    public function passwordFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#register')
                ->assertSee('The password field is required.');
        });
    }

     /** @test */
    public function passwordMin8Char()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#password", "pass")
                ->pressAndWaitFor('#register')
                ->assertSee('The password must be at least 8 characters.');
        });
    }

     /** @test */
    public function confirmPasswordAndPasswordNotMatch()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#password", "password")
                ->type("#password_confirmation", "password123")
                ->pressAndWaitFor('#register')
                ->pause(2000)
                ->assertSee('The password and password confirmation must match.');
        });
    }

    /** @test */
    public function registerUsingExistingEmail(){
        $memberPlan = MembershipPlan::factory()->create();
        $member = Membership::factory(['membership_plan_id' => $memberPlan->id])->create();

        $this->browse(function (Browser $browser) use($member){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#email", $member->email)
                ->pressAndWaitFor('#register')
                ->pause(1000)
                ->assertSee('The email has already been taken.');
        });
    }

    /** @test */
    public function canRegister()
    {
        $memberPlan = MembershipPlan::factory()->create();

        $this->browse(function (Browser $browser) use($memberPlan){
            $browser->visit(route('membership.register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#name", 'mochamad rangga')
                ->type("#email", 'mochamad.rangga@gmail.com')
                ->select("#membership_plan", $memberPlan->id)
                ->type("#password", "password")
                ->type("#password_confirmation", "password")
                ->press('#register')
                ->waitForReload();

            $member = Membership::whereEmail('mochamad.rangga@gmail.com')->first();    
            $browser->assertRouteIs('membership.payment.info', [$member->id]);
        });
    }
}

