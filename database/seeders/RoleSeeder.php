<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = ['view items', 'create items', 'edit items', 'delete items', 'view peminjaman', 'create peminjaman', 'edit peminjaman', 'delete peminjaman', 'view barang masuk', 'create barang masuk', 'edit barang masuk', 'delete barang masuk', 'view barang keluar', 'create barang keluar', 'edit barang keluar', 'delete barang keluar'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'admin' => ['view items', 'create items', 'edit items', 'delete items', 'view peminjaman', 'create peminjaman', 'edit peminjaman', 'delete peminjaman', 'view barang masuk', 'create barang masuk', 'edit barang masuk', 'delete barang masuk', 'view barang keluar', 'create barang keluar', 'edit barang keluar', 'delete barang keluar'],
            'kepala_sekolah' => ['view items', 'view peminjaman', 'view barang masuk',  'view barang keluar'],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        $this->command->info('✅ Roles dan permissions berhasil dibuat!');
    }
}
