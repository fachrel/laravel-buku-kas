<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'tambah-user']);
        Permission::create(['name' => 'ubah-user']);
        Permission::create(['name' => 'hapus-user']);
        
        Permission::create(['name' => 'tambah-transaksi']);
        Permission::create(['name' => 'hapus-transaksi']);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('tambah-user');
        $roleAdmin->givePermissionTo('ubah-user');
        $roleAdmin->givePermissionTo('hapus-user');
        $roleAdmin->givePermissionTo('tambah-transaksi');
        $roleAdmin->givePermissionTo('hapus-transaksi');


        $roleUser = Role::findByName('user');
        $roleUser->givePermissionTo('tambah-transaksi');
    }
}
