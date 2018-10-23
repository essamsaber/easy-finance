<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \Illuminate\Support\Facades\DB::table('users')->truncate();
        \Illuminate\Support\Facades\DB::table('wallets')->truncate();
        $users = factory(\App\User::class, 10)->create();
        $users->each(function($user){
            $user->wallet()->updateOrCreate(['balance' => 0]);
        });
    }
}
