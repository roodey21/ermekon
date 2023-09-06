<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = User::firstOrCreate([
            'email' => 'admin@admin.com'
        ],[
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123')
        ]);
        Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole('admin');
        $this->call(TypeSeeder::class);
        // $this->call(UnitSeeder::class);
    }
}
