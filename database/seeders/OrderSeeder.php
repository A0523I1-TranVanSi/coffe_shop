<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Products;
use App\Models\CartItem;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;


class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $target_products;

    public function __construct()
    {
        $this->target_products = Products::query()->get();
    }

    private function getDummyUsers(int $count): array
    {
        $users = [];

        for ($i = 1; $i <= $count; $i++) {
            $users[] = [
                'full_name' => fake()->name(),
                'phone_number' => fake()->phoneNumber(),
                'email' => fake()->email(),
            ];
        }

        return $users;
    }


    private function getRamdomTargetProducts(int $total): array
    {
        return $this->target_products->random($total)
            ->map(function ($product) {
                return ['product_id' => $product->id];
            })
            ->toArray();
    }


    private function createDummyOrder(mixed $user): Order
    {
        $num_items = random_int(1, 5);

        // random order date between 03 months
        $order_date = Carbon::today()->subDays(rand(0, 90));

        return Order::factory()
            ->state([
                'created_at' => $order_date,
                'cart_id' => Cart::factory()
                    ->has(
                        CartItem::factory()->count($num_items)
                            ->state(new Sequence(
                                ...$this->getRamdomTargetProducts($num_items)
                            )),
                        'items'
                    ),
                ...$user
            ])
            ->create();
    }

    public function run(): void
    {
        //
        $users = $this->getDummyUsers(50);

        foreach ($users as $user) {
            $num_order = random_int(1, 20);

            for ($j = 1; $j <= $num_order; $j++) {
                $this->createDummyOrder($user);
            }
        }
    }
}
