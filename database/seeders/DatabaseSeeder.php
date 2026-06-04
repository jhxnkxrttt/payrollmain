<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@cafe.com'],
            [
                'name' => 'Cafe Admin',
                'employee_id' => null,
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $employees = [
            ['name' => 'Miguel Santos', 'position' => 'Manager', 'monthly_salary' => 25000],
            ['name' => 'Carla Reyes', 'position' => 'Assistant Manager', 'monthly_salary' => 18000],
            ['name' => 'Ramon Dela Cruz', 'position' => 'Head Chef', 'monthly_salary' => 20000],
        ];

        foreach ($employees as $employee) {
            DB::table('employees')->updateOrInsert(
                ['name' => $employee['name']],
                [
                    ...$employee,
                    'hire_date' => '2026-01-01',
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $employeeRecord = DB::table('employees')->where('name', $employee['name'])->first();
            $email = strtolower(str_replace(' ', '.', $employee['name'])).'@cafe.com';

            DB::table('users')->updateOrInsert(
                ['email' => $email],
                [
                    'name' => $employee['name'],
                    'employee_id' => $employeeRecord->id,
                    'password' => Hash::make('employee123'),
                    'role' => $employee['position'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
