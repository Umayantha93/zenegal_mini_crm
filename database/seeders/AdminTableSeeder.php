<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::updateOrCreate(['id'=>1],[
            'name' => 'admin',
            'email' => 'admin@domain.test',
            'password' => '$2y$10$lNJislnchyZu7tA3s5/4X.fZuivP84bJRjHYxnPwJmj7IXMemra26'
        ]);
    }
}
