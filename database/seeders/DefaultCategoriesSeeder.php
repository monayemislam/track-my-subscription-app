<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCategories = [
            ['name' => 'Entertainment', 'color' => '#FF4444', 'is_default' => true],
            ['name' => 'Software', 'color' => '#33B5E5', 'is_default' => true],
            ['name' => 'Gaming', 'color' => '#AA66CC', 'is_default' => true],
            ['name' => 'Music', 'color' => '#99CC00', 'is_default' => true],
            ['name' => 'Streaming', 'color' => '#FF8800', 'is_default' => true],
            ['name' => 'Cloud Storage', 'color' => '#00C851', 'is_default' => true],
            ['name' => 'Other', 'color' => '#777777', 'is_default' => true],
        ];

        foreach ($defaultCategories as $category) {
            Category::create($category);
        }
    }
}
