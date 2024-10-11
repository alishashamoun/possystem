<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $admin->assignRole('admin');

        // Create manager
        $manager = User::create([
            'name' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $manager->assignRole('manager');

        // create cashier
        $cashier = User::create([
            'name' => 'cashier',
            'email' => 'cashier@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $cashier->assignRole('cashier');

        // create inventory staff
        $inventory_staff = User::create([
            'name' => 'inventorystaff',
            'email' => 'inventorystaff@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $inventory_staff->assignRole('inventorystaff');

        // create customer
        $customer = User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $customer->assignRole('customer');
    }
}
