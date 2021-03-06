<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'tharinda.rodrigo@dialog.lk',
                'password' => bcrypt('123456'),
                'company_id' => null
            ], [
                'name' => 'Tharinda Rodrigo',
                'email' => 'tharindarodrigo@gmail.com',
                'password' => bcrypt('123456'),
                'company_id' => 2
            ]
        ]);
    }
}
