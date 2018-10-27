<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SourcesTableSeeder::class);
        $this->call(ExpenseItemsTableSeeder::class);
        $this->call(IncomeTableSeeder::class);
        $this->call(ExpenseTableSeeder::class);
    }
}
