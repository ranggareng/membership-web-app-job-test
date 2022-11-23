<?php

namespace Tests\Browser\TestCase\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// Model
use App\Models\User;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function nameFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#register')
                ->assertSee('The name field is required.');
        });
    }

    /** @test */
    public function emailFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#register')
                ->assertSee('The email field is required.');
        });
    }

    /** @test */
    public function emailMustBeValidEmail()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#email", "invalid-email-address")
                ->pressAndWaitFor('#register')
                ->assertSee('The email must be a valid email address.');
        });
    }

    /** @test */
    public function passwordFieldIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->pressAndWaitFor('#register')
                ->assertSee('The password field is required.');
        });
    }

     /** @test */
    public function passwordMin8Char()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('register'));
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
            $browser->visit(route('register'));
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
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use($user){
            $browser->visit(route('register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#email", $user->email)
                ->pressAndWaitFor('#register')
                ->pause(1000)
                ->assertSee('The email has already been taken.');
        });
    }

    /** @test */
    public function canRegister()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('register'));
            $browser->script("document.querySelector('form').noValidate = true");
            $browser->type("#name", 'mochamad rangga')
                ->type("#email", 'mochamad.rangga@gmail.com')
                ->type("#password", "password")
                ->type("#password_confirmation", "password")
                ->press('#register')
                ->pause(1000);

            $user = User::where('email', 'mochamad.rangga@gmail.com')->first();
            $browser->assertAuthenticatedAs($user);
        });
    }
}
