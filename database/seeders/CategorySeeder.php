<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public $categories = [
        [
            'id' => 1,
            'name' => 'Cafe',
            'description' => '',
            'category_id' => 1,
        ],
        [
            'id' => 2,
            'name' => 'Chicken',
            'description' => '',
            'category_id' => 2,
        ],
    ];

    private function getCategories()
    {
        return $this->categories;
    }

    public function run(): void
    {
        foreach ($this->getCategories() as $category) {
            Category::create($category);
        }
        
        // create 1000 records
        Category::factory()->count(1000)->create();
    }
}
