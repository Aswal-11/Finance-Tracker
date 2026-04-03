<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Expense
            ['name' => 'Food', 'type' => 'expense'],
            ['name' => 'Rent', 'type' => 'expense'],
            ['name' => 'Travel', 'type' => 'expense'],
            ['name' => 'Shopping', 'type' => 'expense'],
            ['name' => 'Bills', 'type' => 'expense'],

            // Income
            ['name' => 'Salary', 'type' => 'income'],
            ['name' => 'Freelancing', 'type' => 'income'],
            ['name' => 'Business', 'type' => 'income'],
            ['name' => 'Investment', 'type' => 'income'],
        ];

        Category::insert($categories);
    }
}
