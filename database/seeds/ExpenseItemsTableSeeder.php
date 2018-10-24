<?php

use Illuminate\Database\Seeder;

class ExpenseItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \Illuminate\Support\Facades\DB::table('expense_items')->truncate();
        $items = ['Children School', 'House Rent', 'Shopping'];
        $periods = ['yearly', 'monthly', 'weekly', 'daily'];
        $users = \App\User::all();
        $items_collection = collect();
        $faker = \Faker\Factory::create();

        $users->each(function($user)use($items, $periods, $items_collection,$faker){

            foreach($items as $item) {

                $period = rand(0,3);


                $items_collection->push([
                    'user_id' => $user->id,
                    'name' => $item,
                    'period' => $periods[$period],
                    'description' => $faker->paragraphs(1, true),
                    'requested_amount' => rand(1000,9000),
                    'average' => rand(1000,9000)
                ]);
            }
        });
        \Illuminate\Support\Facades\DB::table('expense_items')
            ->insert($items_collection->toArray());

    }
}
