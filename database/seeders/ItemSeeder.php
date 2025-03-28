<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Dashboard',
                'url' => '/dashboard',
                'icon' => 'home',
            ],
            [
                'name' => 'Usuarios',
                'url' => '/users',
                'icon' => 'users',
            ],
            [
                'name' => 'Permisos',
                'url' => '/permissions',
                'icon' => 'shield-exclamation',
            ],
            [
                'name' => 'Roles',
                'url' => '/roles',
                'icon' => 'user-plus',
            ],
            [
                'name' => 'Menú',
                'url' => '/menu',
                'icon' => 'bars-4',
            ]
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
