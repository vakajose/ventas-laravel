<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::factory()->create([
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'role_access' => 'admin',
            'order' => 1
        ]);
        Menu::factory()->create([
            'name' => 'Products',
            'route' => 'products.index',
            'role_access' => 'access-common',
            'order' => 2
        ]);
        Menu::factory()->create([
            'name' => 'Promotions',
            'route' => 'promotions.index',
            'role_access' => 'access-common',
            'order' => 3
        ]);
        Menu::factory()->create([
            'name' => 'Reservations',
            'route' => 'reservations.index',
            'role_access' => 'access-common',
            'order' => 4
        ]);
        Menu::factory()->create([
            'name' => 'Inventories',
            'route' => 'inventories.index',
            'role_access' => 'admin',
            'order' => 5
        ]);
        Menu::factory()->create([
            'name' => 'Sales',
            'route' => 'sales.index',
            'role_access' => 'admin',
            'order' => 6
        ]);
    }
}
