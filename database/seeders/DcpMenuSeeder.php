<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Solaris\Core\Models\Menu;

class DcpMenuSeeder extends Seeder
{
    /**
     * Run the database seeds for Sunny DCP Navigation.
     */
    public function run(): void
    {
        // 1. Create or get Category
        $category = Menu::where('name', 'CUSTOMER DATA PLATFORM')->where('is_category', true)->first();
        if (!$category) {
            $category = Menu::create([
                'id' => (string) Str::uuid(),
                'name' => 'CUSTOMER DATA PLATFORM',
                'position' => 4,
                'url' => '',
                'route_name' => '',
                'icon' => null,
                'is_category' => true,
                'is_hide' => false,
                'parent_id' => null,
                'category_id' => null,
            ]);
        }

        // 2. Create or get Parent Menu (CDP)
        $parent = Menu::where(function ($q) {
            $q->where('name', 'CDP')
              ->orWhere('name', 'Indosat DCP');
        })->where('category_id', $category->id)->first();

        if (!$parent) {
            $parent = Menu::create([
                'id' => (string) Str::uuid(),
                'name' => 'CDP',
                'position' => 1,
                'url' => '',
                'route_name' => '',
                'icon' => 'bx bx-radar',
                'is_category' => false,
                'is_hide' => false,
                'parent_id' => null,
                'category_id' => $category->id,
            ]);
        } else {
            $parent->update(['name' => 'CDP']);
        }

        // 3. Create Submenus (Contact and Campaign & Blasting only)
        $submenus = [
            [
                'name' => 'Contact',
                'url' => '/dcp/contact',
                'route_name' => 'dcp.contact',
                'position' => 1,
            ],
            [
                'name' => 'Campaign & Blasting',
                'url' => '',
                'route_name' => '',
                'position' => 2,
            ],
        ];

        foreach ($submenus as $sub) {
            $existing = Menu::where('name', $sub['name'])->where('parent_id', $parent->id)->first();
            if (!$existing) {
                Menu::create([
                    'id' => (string) Str::uuid(),
                    'name' => $sub['name'],
                    'position' => $sub['position'],
                    'url' => $sub['url'],
                    'route_name' => $sub['route_name'],
                    'icon' => null,
                    'is_category' => false,
                    'is_hide' => false,
                    'parent_id' => $parent->id,
                    'category_id' => null,
                ]);
            } else {
                $existing->update([
                    'position' => $sub['position'],
                    'url' => $sub['url'],
                    'route_name' => $sub['route_name'],
                ]);
            }
        }
    }
}
