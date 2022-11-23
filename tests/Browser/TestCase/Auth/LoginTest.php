<?php

namespace Tests\Browser\TestCase\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

// Model
use App\Models\User;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

     /** @test */
    public function canViewLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                    ->assertSee('Sign in to your account');
        });
    }

    /** @test */
    public function canLogin()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $this->browse(function (Browser $browser) use($user){
            $browser->visit(route('login'))
                ->type('#email', $user->email)
                ->type('#password', 'password')
                ->click('#sign-in')
                ->waitForReload()
                ->assertAuthenticated()
                ->assertPathIs('/');
        });            
    }

    /** @test */
    public function isRedirectedIfAlreadyLoggedIn()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $this->browse(function (Browser $browser) use($user){
            $browser->loginAs(User::find(1))
                ->visit(route('login'))
                ->assertPathIs('/')
                ->press("#logout");
        });    
    }

    /** @test */
    public function emailIsRequired()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('login'));
            $browser->script("document.querySelector('#login-form').noValidate = true");
            $browser->type('#password', 'password')
                ->pressAndWaitFor('#sign-in')
                ->assertSee('The email field is required.');
        });        
    }

    /** @test */
    public function emailMustBeValidEmail()
    {
        $this->browse(function (Browser $browser){
            $browser->visit(route('login'));
            $browser->script("document.querySelector('#login-form').noValidate = true");
            $browser->type('#email', 'invalid-email-format')
                ->pressAndWaitFor('#sign-in')
                ->assertSee('The email must be a valid email address.');
        });
    }

    /** @test */
    public function passwordIsRequired()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use($user){
            $browser->visit(route('login'));
            $browser->script("document.querySelector('#login-form').noValidate = true");
            $browser->type('#email', $user->email)
                ->pressAndWaitFor('#sign-in')
                ->pause(1000)
                ->assertSee('The password field is required.');
        });
    }
 
    /** @test */
    public function badLoginAttemptShowsMessage()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use($user){
            $browser->visit(route('login'));
            $browser->script("document.querySelector('#login-form').noValidate = true");
            $browser->type('#email', $user->email)
                ->type("#password", 'bad-password')
                ->pressAndWaitFor('#sign-in')
                ->pause(1000)
                ->assertSee('These credentials do not match our records.');
        });
    }
}