<?php

namespace Database\Factories;
use App\Models\Cart;
use App\Models\Products;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'cart_id' => Cart::factory(),
            'product_id' => Products::factory(),
            'quantity' => 5,
            'notes' => fake()->paragraph(1),
        ];
    }
}
