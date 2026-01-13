<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view dashboard',

            'view barang',
            'create barang',
            'edit barang',
            'delete barang',

            'view kategori',
            'create kategori',
            'edit kategori',
            'delete kategori',

            'view peminjaman',
            'create peminjaman',
            'edit peminjaman',
            'delete peminjaman',

            'view barang masuk',
            'create barang masuk',
            'edit barang masuk',
            'delete barang masuk',

            'view barang keluar',
            'create barang keluar',
            'edit barang keluar',
            'delete barang keluar',

            'view pengajuan',
            'create pengajuan',
            'edit pengajuan',
            'delete pengajuan',
            'approve pengajuan',
            'reject pengajuan',

            'view laporan',
            'download laporan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'admin' => [
                'view dashboard',
                'view barang',
                'create barang',
                'edit barang',
                'delete barang',
                'view kategori',
                'create kategori',
                'edit kategori',
                'delete kategori',
                'view peminjaman',
                'create peminjaman',
                'edit peminjaman',
                'delete peminjaman',
                'view barang masuk',
                'create barang masuk',
                'edit barang masuk',
                'delete barang masuk',
                'view barang keluar',
                'create barang keluar',
                'edit barang keluar',
                'delete barang keluar',
                'view pengajuan',
                'create pengajuan',
                'edit pengajuan',
                'delete pengajuan',
                'view laporan',
                'download laporan',
            ],

            'bendahara' => [
                'view barang',
                'view kategori',
                'view pengajuan',
                'approve pengajuan',
                'reject pengajuan',
                'view laporan',
                'download laporan',
            ],

            'kepala_sekolah' => [
                'view barang',
                'view kategori',
                'view laporan',
                'download laporan',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        $this->command->info('✅ Roles dan permissions berhasil dibuat!');
    }
}