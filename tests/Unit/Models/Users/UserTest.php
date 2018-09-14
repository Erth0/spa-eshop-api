<?php

namespace Tests\Unit\Models\Users;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductVariation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_hashes_the_password_when_creating()
    {
        $user = factory(User::class)->create([
            'password' => 'dogs'
        ]);

        $this->assertNotEquals($user->password, 'cats');
    }

    public function test_it_has_many_cart_products()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }

    public function test_it_has_a_quanity_for_each_cart_product()
    {
        $user = factory(User::class)->create();

        $user->cart()->attach(
            factory(ProductVariation::class)->create(),
            [
                'quantity' => $quantity = 1
            ]
        );

        $this->assertEquals($user->cart->first()->pivot->quantity, $quantity);
    }


}
