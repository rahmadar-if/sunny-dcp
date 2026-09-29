<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SolarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            \Solaris\Core\Database\Seeders\DatabaseSeeder::class,
            \Solaris\MasterData\Database\Seeders\DatabaseSeeder::class,
            \Solaris\BaseCRM\Database\Seeders\DatabaseSeeder::class,
            \Solaris\Sales\Database\Seeders\DatabaseSeeder::class,
            \Solaris\Marketing\Database\Seeders\DatabaseSeeder::class,
            \Solaris\CRM\Database\Seeders\DatabaseSeeder::class
        ]);
    }
}
