<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete(); // Clear existing entries (optional)

        $categories = [
            [
                'title' => 'Technology',
                'slug' => 'tech',
                'description' => 'Articles about technology and gadgets',
            ],
            [
                'title' => 'Lifestyle',
                'slug' => 'lstyle',
                'description' => 'Tips and tricks for everyday living',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
