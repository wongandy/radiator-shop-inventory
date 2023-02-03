<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Branch::factory(10)->create();
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        \App\Models\Product::factory()->create([
            'make' => 165,
            'brand' => 'BMW',
            'model' => 'e36 318i/ 328i / Z3 1.9/2.8',
            'year_start' => 1991,
            'year_end' => 2000,
            'transmission' => 'M/T',
            'thickness_number' => 32,
            'thickness' => 'mm',
            'stock_number' => '1295',
            'enterex_price' => 34,
            'price' => 13500,
            'notes' => 'test note',
        ]);
    }
}
