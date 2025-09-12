<?php
// database/seeders/UsersTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder {
    public function run(): void {
        User::create([
            'name' => 'Admin',
            'email' => 'priyaadmin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'kuladeepcustomer@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
