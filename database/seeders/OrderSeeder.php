<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 80) as $index) {
            $orderCreatedAt = now()->subDays(rand(0, 730));
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => rand(2, 3),
                'order_code' => strtoupper($faker->unique()->bothify('ORD#######')),
                'status' => $faker->randomElement(['completed', 'canceled']),
                'payment_method' => $faker->randomElement(['VNPAY', 'COD', 'MOMO']),
                'payment_status' => $faker->randomElement(['paid','cancel']),
                'address' => $faker->address,
                'fullname' => $faker->name,
                'email' => $faker->email,
                'phone_number' => $faker->phoneNumber,
                'note' => $faker->sentence,
                'total' => $faker->randomFloat(0, 1000000, 5000000),
                'total_final' => $faker->randomFloat(0, 1000000, 5000000),
                'discount_amount' => $faker->randomFloat(0, 0, 100000),
                'shipping' => $faker->randomFloat(0, 0, 100000),
                'created_at' => $orderCreatedAt,
                'updated_at' => $orderCreatedAt,
            ]);

            // Tạo order_items cho mỗi đơn hàng
            foreach (range(1, rand(1, 5)) as $itemIndex) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_variant_id' => rand(1, 5),
                    'product_name' => $faker->name,
                    'sku' => strtoupper($faker->bothify('SKU#######')),
                    'image_url' => $faker->imageUrl(),
                    'size' => rand(35, 45),
                    'color' => $faker->safeColorName,
                    'quantity' => rand(1, 5),
                    'unit_price' => $faker->randomFloat(0, 1000000, 5000000),
                    'created_at' => $orderCreatedAt,
                    'updated_at' => $orderCreatedAt,
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }
    }
}
