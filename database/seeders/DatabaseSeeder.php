<?php

namespace Database\Seeders;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'CMS Papua',
            'email' => 'cms@papua.go.id',
            'password' => Hash::make('password123'),
        ]);

        // seeder settings

        Settings::create([
            'site_name' => 'CMS Papua',
            'description' => 'CMS Papua',
            'visi' => 'CMS Papua',
            'misi' => 'CMS Papua',
            'name_gubernur' => 'CMS Papua',
            'position_gubernur' => 'CMS Papua',
            'photo_gubernur' => 'CMS Papua',
            'name_wakil_gubernur' => 'CMS Papua',
            'position_wakil_gubernur' => 'CMS Papua',
            'photo_wakil_gubernur' => 'CMS Papua',

        ]);
    }
}
