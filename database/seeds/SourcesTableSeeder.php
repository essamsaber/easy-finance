<?php

use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \Illuminate\Support\Facades\DB::table('source_of_incomes')->truncate();
        $sources = ['Taxi', 'My Job', 'Free Lancing'];
        $periods = ['yearly', 'monthly', 'weekly', 'daily'];
        $users = \App\User::all();
        $sources_collection = collect();
        $faker = \Faker\Factory::create();

        $users->each(function($user)use($sources, $periods, $sources_collection,$faker){

            foreach($sources as $source) {
                $period = rand(0,3);

                $sources_collection->push([
                    'user_id' => $user->id,
                    'name' => $source,
                    'description' => $faker->paragraphs(1, true),
                    'period' => $periods[$period],
                    'income' => rand(1000,9000),
                    'average' => rand(1000,9000)
                ]);
            }
        });
        \Illuminate\Support\Facades\DB::table('source_of_incomes')
            ->insert($sources_collection->toArray());
    }
}
