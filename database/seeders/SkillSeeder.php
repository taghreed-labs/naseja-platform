<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * إضافة المهارات الأساسية للنظام.
     */
    public function run(): void
    {
        $skills = [

            // الخياطة والتفصيل
            [
                'category_slug' => 'sewing-tailoring',
                'name_ar' => 'الخياطة',
                'name_en' => 'Sewing',
                'slug' => 'sewing',
                'description' => 'خياطة وتصميم الملابس بمختلف أنواعها.',
            ],
            [
                'category_slug' => 'sewing-tailoring',
                'name_ar' => 'تفصيل الملابس',
                'name_en' => 'Clothing Tailoring',
                'slug' => 'clothing-tailoring',
                'description' => 'تفصيل الملابس حسب المقاسات والتصاميم.',
            ],
            [
                'category_slug' => 'sewing-tailoring',
                'name_ar' => 'تصميم الأزياء',
                'name_en' => 'Fashion Design',
                'slug' => 'fashion-design',
                'description' => 'تصميم الأزياء والملابس المختلفة.',
            ],

            // التطريز
            [
                'category_slug' => 'embroidery',
                'name_ar' => 'التطريز اليدوي',
                'name_en' => 'Hand Embroidery',
                'slug' => 'hand-embroidery',
                'description' => 'تنفيذ أعمال التطريز اليدوي على الأقمشة.',
            ],
            [
                'category_slug' => 'embroidery',
                'name_ar' => 'التطريز الآلي',
                'name_en' => 'Machine Embroidery',
                'slug' => 'machine-embroidery',
                'description' => 'تنفيذ أعمال التطريز باستخدام الآلات.',
            ],
            [
                'category_slug' => 'embroidery',
                'name_ar' => 'تطريز الملابس',
                'name_en' => 'Clothing Embroidery',
                'slug' => 'clothing-embroidery',
                'description' => 'إضافة التصاميم والزخارف المطرزة على الملابس.',
            ],

            // الحلويات والمخبوزات
            [
                'category_slug' => 'baking-desserts',
                'name_ar' => 'صناعة الكيك',
                'name_en' => 'Cake Making',
                'slug' => 'cake-making',
                'description' => 'إعداد وتصميم الكيك للمناسبات المختلفة.',
            ],
            [
                'category_slug' => 'baking-desserts',
                'name_ar' => 'تزيين الكيك',
                'name_en' => 'Cake Decoration',
                'slug' => 'cake-decoration',
                'description' => 'تزيين وتصميم الكيك بطريقة احترافية.',
            ],
            [
                'category_slug' => 'baking-desserts',
                'name_ar' => 'المخبوزات',
                'name_en' => 'Baking',
                'slug' => 'baking',
                'description' => 'إعداد مختلف أنواع المخبوزات.',
            ],

            // الطبخ
            [
                'category_slug' => 'cooking',
                'name_ar' => 'الطبخ المنزلي',
                'name_en' => 'Home Cooking',
                'slug' => 'home-cooking',
                'description' => 'إعداد الأطعمة والوجبات المنزلية.',
            ],
            [
                'category_slug' => 'cooking',
                'name_ar' => 'الطبخ الشعبي',
                'name_en' => 'Traditional Cooking',
                'slug' => 'traditional-cooking',
                'description' => 'إعداد الأطباق الشعبية والتراثية.',
            ],

            // التصوير
            [
                'category_slug' => 'photography',
                'name_ar' => 'التصوير الفوتوغرافي',
                'name_en' => 'Photography',
                'slug' => 'photography',
                'description' => 'التصوير الفوتوغرافي بمختلف أنواعه.',
            ],
            [
                'category_slug' => 'photography',
                'name_ar' => 'تصوير المنتجات',
                'name_en' => 'Product Photography',
                'slug' => 'product-photography',
                'description' => 'تصوير المنتجات بطريقة احترافية.',
            ],

            // التصميم
            [
                'category_slug' => 'design',
                'name_ar' => 'التصميم الجرافيكي',
                'name_en' => 'Graphic Design',
                'slug' => 'graphic-design',
                'description' => 'تصميم الشعارات والمحتوى البصري.',
            ],
            [
                'category_slug' => 'design',
                'name_ar' => 'تصميم الشعارات',
                'name_en' => 'Logo Design',
                'slug' => 'logo-design',
                'description' => 'تصميم الشعارات والهويات البصرية.',
            ],

            // الأعمال اليدوية
            [
                'category_slug' => 'handicrafts',
                'name_ar' => 'الأعمال اليدوية',
                'name_en' => 'Handicrafts',
                'slug' => 'handicrafts',
                'description' => 'تنفيذ المنتجات والأعمال اليدوية المختلفة.',
            ],
            [
                'category_slug' => 'handicrafts',
                'name_ar' => 'صناعة المنتجات اليدوية',
                'name_en' => 'Handmade Products',
                'slug' => 'handmade-products',
                'description' => 'صناعة منتجات يدوية مميزة.',
            ],

            // صناعة الإكسسوارات
            [
                'category_slug' => 'accessories-making',
                'name_ar' => 'صناعة الإكسسوارات',
                'name_en' => 'Accessories Making',
                'slug' => 'accessories-making',
                'description' => 'تصميم وصناعة الإكسسوارات اليدوية.',
            ],
            [
                'category_slug' => 'accessories-making',
                'name_ar' => 'صناعة المجوهرات اليدوية',
                'name_en' => 'Handmade Jewelry',
                'slug' => 'handmade-jewelry',
                'description' => 'صناعة وتصميم المجوهرات اليدوية.',
            ],
        ];

        foreach ($skills as $skill) {

            $category = Category::where(
                'slug',
                $skill['category_slug']
            )->first();

            // إذا لم يوجد التصنيف، نتجاوز المهارة
            if (!$category) {
                continue;
            }

            Skill::updateOrCreate(
                [
                    'slug' => $skill['slug'],
                ],
                [
                    'category_id' => $category->id,
                    'name_ar' => $skill['name_ar'],
                    'name_en' => $skill['name_en'],
                    'description' => $skill['description'],
                    'status' => 'active',
                ]
            );
        }
    }
}