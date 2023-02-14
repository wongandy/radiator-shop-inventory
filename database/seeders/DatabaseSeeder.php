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

        \App\Models\Product::factory()->create([
            'make' => 103,
            'brand' => 'chevrolet',
            'model' => 'aveo 1.6',
            'year_start' => 2004,
            'year_end' => 2009,
            'transmission' => 'M/T',
            'thickness_number' => 16,
            'thickness' => 'mm',
            'stock_number' => '2837mt',
            'enterex_price' => 20.99,
            'price' => 4800,
            'notes' => 'test note2',
        ]);
    }
}
