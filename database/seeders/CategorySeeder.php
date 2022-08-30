<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       // \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB:: table('categories') ->insert([
            "name" => "Data Science", 
           ]);

           DB:: table('categories') ->insert([
            "name" => "Artificial Intelligence", 
           ]);
           DB:: table('categories') ->insert([
            "name" => "Software Development", 
           ]);
           DB:: table('categories') ->insert([
            "name" => "Machine Learning", 
           ]);
    }
}
