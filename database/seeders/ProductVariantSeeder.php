<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_variants')->insert([
            [
                'product_id' => 1,
                'size' => '39',
                'color' => '#ffffff',
                'price' => 2000000,
                'quantity' => 10,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'product_id' => 2,
                'size' => '39',
                'color' => '#ffffff',
                'price' => 2000000,
                'quantity' => 10,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'product_id' => 3,
                'size' => '39',
                'color' => '#ffffff',
                'price' => 2000000,
                'quantity' => 10,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'product_id' => 4,
                'size' => '39',
                'color' => '#ffffff',
                'price' => 2000000,
                'quantity' => 10,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'product_id' => 5,
                'size' => '39',
                'color' => '#ffffff',
                'price' => 2000000,
                'quantity' => 10,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'product_id' => 6,
                'size' => '39',
                'color' => '#ffffff',
                'price' => 2000000,
                'quantity' => 10,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}





