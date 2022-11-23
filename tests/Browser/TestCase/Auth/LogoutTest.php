<?php

namespace Tests\Browser\TestCase\Auth;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// Model
use App\Models\User;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function anAuthenticatedUserCanLogOut()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use($user){
            $browser->loginAs($user);

            $browser->visit('/')
                    ->press("#logout")
                    ->assertRouteIs('home')
                    ->assertSee('Laravel')
                    ->assertGuest();
        });
    }

    /** @test */
    public function anUnauthenticatedUserCanNotLogOut()
    {
        $this->browse(function (Browser $browser){
            $browser->visit('/')
                    ->assertDontSee('Log out');
        });
    }
}
