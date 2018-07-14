<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      foreach (range(1,10) as $index) {
      DB::table('users')->insert([
           'name' => $faker->name,
           'email' => $faker->email,
           'password' => bcrypt('secret'),
           'role' => rand(1,2)
       ]);
    }
    DB::table('users')->insert([
         'name' => 'adis',
         'email' => 'admin@gmail.com',
         'password' => bcrypt('secret'),
         'role' => 1
     ]);
  }
}
