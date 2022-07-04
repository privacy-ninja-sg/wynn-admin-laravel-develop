<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 96,
                'title' => 'sa_game_account_create',
            ],
            [
                'id'    => 97,
                'title' => 'sa_game_account_edit',
            ],
            [
                'id'    => 98,
                'title' => 'sa_game_account_show',
            ],
            [
                'id'    => 99,
                'title' => 'sa_game_account_delete',
            ],
            [
                'id'    => 100,
                'title' => 'sa_game_account_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
