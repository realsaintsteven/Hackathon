<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class loginAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB:: table('admins') ->insert([
            "email" => "admin@gmail.com",
            "password" =>'password',
            'uid' => 1,
            'name' => 'Admin System',
            
           
           ]);
      
    }
}
