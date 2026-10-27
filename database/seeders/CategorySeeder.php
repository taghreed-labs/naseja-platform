<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            [
                'name_ar' => 'الخياطة والتفصيل',
                'name_en' => 'Sewing & Tailoring',
                'slug' => 'sewing-tailoring',
                'description' => 'مهارات الخياطة وتفصيل وتصميم الملابس.',
            ],

            [
                'name_ar' => 'التطريز',
                'name_en' => 'Embroidery',
                'slug' => 'embroidery',
                'description' => 'مهارات التطريز اليدوي والتطريز على الأقمشة.',
            ],

            [
                'name_ar' => 'الحلويات والمخبوزات',
                'name_en' => 'Baking & Desserts',
                'slug' => 'baking-desserts',
                'description' => 'مهارات إعداد الحلويات والكيك والمخبوزات.',
            ],

            [
                'name_ar' => 'الطبخ',
                'name_en' => 'Cooking',
                'slug' => 'cooking',
                'description' => 'مهارات الطبخ وإعداد الأطعمة المختلفة.',
            ],

            [
                'name_ar' => 'التصوير',
                'name_en' => 'Photography',
                'slug' => 'photography',
                'description' => 'مهارات التصوير الفوتوغرافي وتصوير المنتجات.',
            ],

            [
                'name_ar' => 'التصميم',
                'name_en' => 'Design',
                'slug' => 'design',
                'description' => 'مهارات التصميم الجرافيكي وتصميم المحتوى.',
            ],

            [
                'name_ar' => 'الأعمال اليدوية',
                'name_en' => 'Handicrafts',
                'slug' => 'handicrafts',
                'description' => 'المهارات المتعلقة بالأعمال والحرف اليدوية.',
            ],

            [
                'name_ar' => 'صناعة الإكسسوارات',
                'name_en' => 'Accessories Making',
                'slug' => 'accessories-making',
                'description' => 'صناعة وتصميم الإكسسوارات والمجوهرات اليدوية.',
            ],

        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'parent_id' => null,
                    'name_ar' => $category['name_ar'],
                    'name_en' => $category['name_en'],
                    'description' => $category['description'],
                    'created_by' => null,
                    'image' => null,
                    'status' => 'active',
                    'sort_order' => 0,
                ]
            );
        }
    }
}