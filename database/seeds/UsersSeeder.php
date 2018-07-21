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

      //team
    DB::table('users')->insert([
         'name' => 'team1',
         'email' => 'team1@gmail.com',
         'password' => bcrypt('secret'),
         'role' => 3,
         'role_id' => 1
     ]);
     DB::table('users')->insert([
          'name' => 'team2',
          'email' => 'team2@gmail.com',
          'password' => bcrypt('secret'),
          'role' => 3,
          'role_id' => 2
      ]);
      DB::table('users')->insert([
           'name' => 'team3',
           'email' => 'team3@gmail.com',
           'password' => bcrypt('secret'),
           'role' => 3,
           'role_id' => 3
       ]);
       //admin
    DB::table('users')->insert([
         'name' => 'admin',
         'email' => 'admin@gmail.com',
         'password' => bcrypt('secret'),
         'role' => 1
     ]);

  }
}
