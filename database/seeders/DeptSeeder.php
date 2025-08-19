<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'dept_id' => 'Dept001',
            'dept_name' => 'IT Department',
        ]);

        Department::create([
            'dept_id' => 'Dept002',
            'dept_name' => 'HR Department',
        ]);

        Department::create([
            'dept_id' => 'Dept003',
            'dept_name' => 'Finance Department',
        ]);

        Department::create([
            'dept_id' => 'Dept004',
            'dept_name' => 'Logistic Department',
        ]);
    }
}
