<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Define all permissions
        $permissions = [
            // Dashboard
            'view dashboard',

            // Data Barang
            'view barang',
            'create barang',
            'edit barang',
            'delete barang',

            // Kategori Barang
            'view kategori',
            'create kategori',
            'edit kategori',
            'delete kategori',

            // Peminjaman
            'view peminjaman',
            'create peminjaman',
            'edit peminjaman',
            'delete peminjaman',

            // Barang Masuk
            'view barang masuk',
            'create barang masuk',
            'edit barang masuk',
            'delete barang masuk',

            // Barang Keluar
            'view barang keluar',
            'create barang keluar',
            'edit barang keluar',
            'delete barang keluar',

            // Pengajuan Barang
            'view pengajuan',
            'create pengajuan',
            'edit pengajuan',
            'delete pengajuan',
            'approve pengajuan',  // Khusus untuk bendahara
            'reject pengajuan',   // Khusus untuk bendahara

            // Laporan
            'view laporan',
            'download laporan',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and their permissions
        $roles = [
            // Admin (Sapras) - Full Access
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

            // Bendahara - Read Only + Approve/Reject Pengajuan
            'bendahara' => [
                'view barang',        // Read only
                'view kategori',      // Read only
                'view pengajuan',     // Untuk approve/reject
                'approve pengajuan',  // Approve pengajuan
                'reject pengajuan',   // Reject pengajuan
                'view laporan',       // Read only
                'download laporan',   // Bisa download
            ],

            // Kepala Madrasah - Read Only
            'kepala_sekolah' => [
                'view barang',      // Read only
                'view kategori',    // Read only
                'view laporan',     // Read only
                'download laporan', // Bisa download
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        $this->command->info('✅ Roles dan permissions berhasil dibuat!');
    }
}