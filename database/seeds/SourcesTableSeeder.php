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
        $user = \App\User::find(1);
        $sources_collection = [];
        $faker = \Faker\Factory::create();
        for($i = 0; $i <= 20; $i++) {
            $period = rand(0,3);
            $source = rand(0,2);

            $sources_collection[] = [
                'user_id' => $user->id,
                'name' => $sources[$source],
                'period' => $periods[$period],
                'description' => $faker->paragraphs(1, true),
                'income' => rand(1000,9000),
                'average' => rand(1000,9000)
            ];
        }
        \Illuminate\Support\Facades\DB::table('source_of_incomes')->insert($sources_collection);
    }
}
