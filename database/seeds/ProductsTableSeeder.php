<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Product::class, 20)
            ->create()
            ->each(function ($product) {
                $product->categories()->sync(\App\Models\Category::all()->pluck('_id')->random(rand(5, 10))->toArray());
            });
    }
}
