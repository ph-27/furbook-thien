<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [   'id' => 1,
                'name' => 'Lê Hữu Thiên',
                'email' => 'huuthien@gmail.com',
                'password' => bcrypt('123'),
                'is_admin' => True
            ],
            [   'id' => 2,
                'name' => 'Rich Dloye',
                'email' => 'rich@gmail.com',
                'password' => bcrypt('123'),
                'is_admin' => False

            ],
        ]);
    }
}
