<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Web Development' => [
                'desc' => 'Custom websites, dashboards, and backend platforms.',
                'children' => ['Laravel', 'Vue.js', 'API Integrations'],
            ],
            'Design & Branding' => [
                'desc' => 'Brand identity, UI systems, and product visuals.',
                'children' => ['UI Design', 'Brand Identity', 'Marketing Assets'],
            ],
            'Content & Marketing' => [
                'desc' => 'Campaigns, content strategy, and growth support.',
                'children' => ['Copywriting', 'SEO', 'Social Media'],
            ],
            'Mobile Apps' => [
                'desc' => 'Cross-platform mobile experiences and MVP launches.',
                'children' => ['Flutter', 'React Native'],
            ],
        ];

        foreach ($categories as $name => $data) {
            $parent = Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                [
                    'name' => $name,
                    'desc' => $data['desc'],
                    'parent_id' => null,
                ]
            );

            foreach ($data['children'] as $childName) {
                Category::updateOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($childName)],
                    [
                        'name' => $childName,
                        'desc' => $data['desc'],
                        'parent_id' => $parent->id,
                    ]
                );
            }
        }
    }
}
