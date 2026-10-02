<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Solaris\Core\Models\Menu;
use Solaris\Core\Services\MenuService;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Locate the CDP Parent Menu
        $parent = Menu::where(function ($q) {
            $q->where('name', 'CDP')
              ->orWhere('name', 'Indosat DCP')
              ->orWhere('id', '2433cee8-ac8f-4e2d-afd6-4b7f0aaf86ee');
        })->first();

        if (!$parent) {
            return;
        }

        // Ensure parent name is CDP
        $parent->update(['name' => 'CDP']);

        // 2. Adjust sibling positions to make room at the top (position 1)
        Menu::where('parent_id', $parent->id)->where('name', 'Data Enrichment')->update(['position' => 2]);
        Menu::where('parent_id', $parent->id)->where('name', 'Data Cleansing')->update(['position' => 3]);
        Menu::where('parent_id', $parent->id)->where('name', 'Customer Research')->update(['position' => 4]);
        Menu::where('parent_id', $parent->id)->where('name', 'Campaign & Blasting')->update(['position' => 5]);

        // 3. Create or update Contact menu
        $contactMenu = Menu::where('parent_id', $parent->id)->where('name', 'Contact')->first();
        if (!$contactMenu) {
            $contactMenu = Menu::create([
                'id' => (string) Str::uuid(),
                'name' => 'Contact',
                'position' => 1,
                'url' => '/dcp/contact',
                'route_name' => 'dcp.contact',
                'icon' => null,
                'is_category' => false,
                'is_hide' => false,
                'parent_id' => $parent->id,
                'category_id' => null,
            ]);
        } else {
            $contactMenu->update([
                'position' => 1,
                'url' => '/dcp/contact',
                'route_name' => 'dcp.contact',
            ]);
        }

        // 4. Assign role permissions to Contact menu based on parent's roles
        $rolesWithAccess = DB::table('role_menus')
            ->whereIn('menu_id', function ($query) use ($parent) {
                $query->select('id')->from('menus')->where('parent_id', $parent->id)->orWhere('id', $parent->id);
            })
            ->pluck('role_id')
            ->unique();

        foreach ($rolesWithAccess as $roleId) {
            $exists = DB::table('role_menus')
                ->where('role_id', $roleId)
                ->where('menu_id', $contactMenu->id)
                ->exists();

            if (!$exists) {
                DB::table('role_menus')->insert([
                    'id' => (string) Str::uuid(),
                    'role_id' => $roleId,
                    'menu_id' => $contactMenu->id,
                ]);
            }
        }

        // 5. Clear Menu cache
        MenuService::clearCache();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $parent = Menu::where('name', 'CDP')->orWhere('id', '2433cee8-ac8f-4e2d-afd6-4b7f0aaf86ee')->first();
        if ($parent) {
            Menu::where('parent_id', $parent->id)->where('name', 'Contact')->delete();
            Menu::where('parent_id', $parent->id)->where('name', 'Data Enrichment')->update(['position' => 1]);
            Menu::where('parent_id', $parent->id)->where('name', 'Data Cleansing')->update(['position' => 2]);
            Menu::where('parent_id', $parent->id)->where('name', 'Customer Research')->update(['position' => 3]);
            Menu::where('parent_id', $parent->id)->where('name', 'Campaign & Blasting')->update(['position' => 4]);
            MenuService::clearCache();
        }
    }
};
