<?php

use App\Helpers\DatabaseSeederTrait;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    use DatabaseSeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->emptyTable('roles');
        $this->emptyTable('permissions');
        $this->emptyTable('permission_roles');

        DB::table('permissions')->insert($this->addTimestamps([
            ['name' => 'view admin'],
            ['name' => 'manage admin']
        ]));


        Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'view admin',
                'manage admin'
            ]);

    }
}
