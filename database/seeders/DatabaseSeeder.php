<?php

namespace Database\Seeders;

use App\Db\Categories;
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
        $this->call([
            CategoriesSeeder::class,
            ProductsSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
