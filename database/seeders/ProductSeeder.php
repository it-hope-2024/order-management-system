<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\ProductFactory; 

class ProductSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productNames = ProductFactory::$productNames;

        foreach ($productNames as $product) {
            Product::factory()->create([
                'name' => $product
            ]);
        }
        // Product::factory()->count(50)->create(); // Creates 50 fake products
    }
}
