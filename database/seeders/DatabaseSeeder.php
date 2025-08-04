<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);

        Language::create(['code' => 'en', 'name' => 'English']);
        Language::create(['code' => 'fr', 'name' => 'French']);
        Language::create(['code' => 'es', 'name' => 'Spanish']);

        Category::create([
            'key' => 'electronics',
            'name' => ['en' => 'Electronics', 'fr' => 'Électronique', 'es' => 'Electrónica'],
            'description' => ['en' => 'Electronic devices', 'fr' => 'Appareils électroniques', 'es' => 'Dispositivos electrónicos'],
            'tag' => 'web'
        ]);
    }
}