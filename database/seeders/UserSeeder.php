<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'user_id' => Str::uuid(),
                'password' => Hash::make('sapras127'),
            ]
        );
        $admin->assignRole('admin');

        $user = User::firstOrCreate(
            ['username' => 'kepalasekolah'],
            [
                'user_id' => Str::uuid(),
                'password' => Hash::make('kepsek123'),
            ]
        );
        $user->assignRole('kepala_sekolah');

        $bendahara = User::firstOrCreate(
            ['username' => 'bendahara'],
            [
                'user_id' => Str::uuid(),
                'password' => Hash::make('bendahara123'),
            ]
        );
        $bendahara->assignRole('bendahara');

        $this->command->info('✅ Users berhasil dibuat dan role telah diberikan!');
    }
}