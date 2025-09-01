<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Manager;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Manager */
        $admin = Manager::query()->firstOrCreate([
            'account' => 'admin'
        ], [
            'name'     => 'Admin',
            'password' => 'password',
            'enabled'  => true,
        ]);
    }
}
