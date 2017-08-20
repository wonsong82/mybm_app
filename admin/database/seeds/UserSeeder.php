<?php

use App\Helpers\DatabaseSeederTrait;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    use DatabaseSeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->emptyTable('users');
        $this->emptyTable('role_users');

        User::create([
            'id' => 1,
            'email' => 'admin',
            'password' => bcrypt('777')
        ])->assignRole(['admin']);



    }
}
