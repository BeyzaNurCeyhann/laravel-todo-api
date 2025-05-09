<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Backend', 'color' => '#FF5733'],
            ['name' => 'Frontend', 'color' => '#33FFBD'],
            ['name' => 'Veritabanı', 'color' => '#3380FF'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
