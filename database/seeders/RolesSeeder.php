<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'label'=>'admin'
        ]);
        
        DB::table('roles')->insert([
            'label'=>'seller'
        ]);

        DB::table('roles')->insert([
            'label'=>'guest'
        ]);

        $admin =  \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password'=>Hash::make(123456),
            'role_id'=>1
        ]);

        // $admin->assignRole('admin');
    }
}
