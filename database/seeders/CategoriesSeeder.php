<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\db\Categories;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $data = [
    ["category_name"=> "Autem error animi","category_id"=> 0],
    ["category_name"=> "Quia quis","category_id"=> 1],
    ["category_name"=> "Qui nostrum","category_id"=> 2],
    ["category_name"=> "Adipisci voluptas","category_id"=> 3],
    ["category_name"=> "Illo ea quia","category_id"=> 4],
    ["category_name"=> "Et et quis","category_id"=> 5],
    ["category_name"=> "Ratione eum tempore","category_id"=> 6],
    ["category_name"=> "Libero aut","category_id"=> 7],
    ["category_name"=> "Distinctio dolorem","category_id"=> 8],
    ["category_name"=> "At exercitationem ipsum","category_id"=> 9],
    ["category_name"=> "Aut qui quia","category_id"=> 10],
    ["category_name"=> "Tempore in eum","category_id"=> 11],
    ["category_name"=> "Cumque sapiente consequatur","category_id"=> 12],
    ["category_name"=> "In fugit","category_id"=> 13],
    ["category_name"=> "Fugiat libero laudantium","category_id"=> 14],
    ["category_name"=> "Magnam modi adipisci","category_id"=> 15],
    ["category_name"=> "Rerum voluptate","category_id"=> 16],
    ["category_name"=> "Quo corporis","category_id"=> 17],
    ["category_name"=> "Rem itaque aut","category_id"=> 18],
    ["category_name"=> "Cupiditate nam","category_id"=> 19],
    ["category_name"=> "Sed non","category_id"=> 20]];
    Categories::insert($data);
    }
}

