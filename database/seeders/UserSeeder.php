<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Michael Cabello',
            'email' => 'michael@ticomperu.com',
            'password' => bcrypt('12345678')
        ]);

        //$user->assignRole('admin');

        User::factory(20)->create();
    }
}
