<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'abdelhak admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$Rp4oG8RQB8pGmdLlE7GXi.3W9PliansoHC9Pa6gU7ne9akbQDqlf.',
            'type' => 'admin',
            'photo' => '1640856442.jpeg',

        ]);
    }
}



