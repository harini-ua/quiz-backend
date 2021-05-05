<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@example.com';
        if (! DB::table('users')->whereEmail($email)->first()) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make('ighaec0zuuK4eiMumee4Wah5'),
                'is_admin' => 1,
                'created_at' => \Carbon\Carbon::now()
            ]);
        }

        $email = 'user@example.com';
        if (! DB::table('users')->whereEmail($email)->first()) {
            DB::table('users')->insert([
                'name' => 'User',
                'email' => $email,
                'password' => Hash::make('kWD8jbbw'),
                'is_admin' => 0,
                'created_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
