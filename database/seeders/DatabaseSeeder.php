<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add a test user
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Add an admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $categoriesData = [
            ['name' => 'Dress', 'slug' => 'dress'],
            ['name' => 'Koko', 'slug' => 'koko'],
            ['name' => 'Scarf', 'slug' => 'scarf'],
            ['name' => 'Skirt', 'slug' => 'skirt'],
            ['name' => 'Tunic', 'slug' => 'tunic'],
            ['name' => 'Mukena', 'slug' => 'mukena'],
        ];

        $categoryMap = [];
        foreach ($categoriesData as $cat) {
            $categoryMap[$cat['name']] = Category::create($cat)->id;
        }

        $products = [
            [
                'name' => 'Izzy Dress',
                'category' => 'Dress',
                'price' => 3599000,
                'original_price' => null,
                'image' => 'izzy-dress.jpg',
                'description' => 'Exclusive and premium Izzy Dress with elegant detailing.'
            ],
            [
                'name' => 'Rebekah Dress',
                'category' => 'Dress',
                'price' => 1739400,
                'original_price' => 2899000,
                'image' => 'rebekah-dress.jpg',
                'description' => 'Modern syari design for a timeless appearance.'
            ],
            [
                'name' => 'Lavender Dress',
                'category' => 'Dress',
                'price' => 2319200,
                'original_price' => 2899000,
                'image' => 'lavender-dress.jpg',
                'description' => 'Soft lavender tones combined with Ranti\'s signature quality.'
            ],
            [
                'name' => 'Afif Koko',
                'category' => 'Koko',
                'price' => 749500,
                'original_price' => 1499000,
                'image' => 'afif-koko.jpg',
                'description' => 'A refined Koko for formal and spiritual occasions.'
            ],
            [
                'name' => 'Felika Koko',
                'category' => 'Koko',
                'price' => 424500,
                'original_price' => 849000,
                'image' => 'felika-koko.jpg',
                'description' => 'Casual yet structured Felika Koko for everyday comfort.'
            ],
            [
                'name' => 'Razza Koko',
                'category' => 'Koko',
                'price' => 399500,
                'original_price' => 799000,
                'image' => 'razza-koko.jpg',
                'description' => 'Dark tones for a bold, masculine Koko look.'
            ],
            [
                'name' => 'Damaris Koko',
                'category' => 'Koko',
                'price' => 424500,
                'original_price' => 849000,
                'image' => 'damaris-koko.jpg',
                'description' => 'Lightweight and stylish Damaris Koko.'
            ],
            [
                'name' => 'Carmen Dress',
                'category' => 'Dress',
                'price' => 1449500,
                'original_price' => 2899000,
                'image' => 'carmen-dress.jpg',
                'description' => 'Carmen Dress offers a bold statement in premium fabric.'
            ],
            [
                'name' => 'Winter Scarf',
                'category' => 'Scarf',
                'price' => 299000,
                'original_price' => null,
                'image' => 'winter-scarf.jpg',
                'description' => 'Soft and warm Winter Scarf for a cozy syari look.'
            ],
            [
                'name' => 'Rona Scarf',
                'category' => 'Scarf',
                'price' => 649000,
                'original_price' => null,
                'image' => 'rona-scarf.jpg',
                'description' => 'Bright and colorful Rona Scarf to elevate your style.'
            ],
            [
                'name' => 'Karenia Skirt',
                'category' => 'Skirt',
                'price' => 374500,
                'original_price' => 749000,
                'image' => 'karenia-skirt.jpg',
                'description' => 'Graceful Karenia Skirt with a fluid silhouette.'
            ],
            [
                'name' => 'Eleena Tunic',
                'category' => 'Tunic',
                'price' => 499500,
                'original_price' => 999000,
                'image' => 'eleena-tunic.jpg',
                'description' => 'Modern Eleena Tunic perfect for daytime events.'
            ],
            [
                'name' => 'Reina Tunic',
                'category' => 'Tunic',
                'price' => 549500,
                'original_price' => 1099000,
                'image' => 'reina-tunic.jpg',
                'description' => 'Versatile Reina Tunic in a premium finish.'
            ],
            [
                'name' => 'Mukena Khodijah Kombinasi',
                'category' => 'Mukena',
                'price' => 759000,
                'original_price' => null,
                'image' => 'mukena-khodijah.jpg',
                'description' => 'High-quality prayer set for ultimate comfort.'
            ],
            [
                'name' => 'Eshal Kids Dress',
                'category' => 'Dress',
                'price' => 359700,
                'original_price' => 1199000,
                'image' => 'eshal-kids.jpg',
                'description' => 'Adorable and comfortable Eshal Kids Dress.'
            ],
            [
                'name' => 'Satine Skirt',
                'category' => 'Skirt',
                'price' => 349500,
                'original_price' => 699000,
                'image' => 'satine-skirt.jpg',
                'description' => 'Luxurious silk-feel Satine Skirt.'
            ],
            [
                'name' => 'Adriana Skirt',
                'category' => 'Skirt',
                'price' => 374500,
                'original_price' => 749000,
                'image' => 'adriana-skirt.jpg',
                'description' => 'Classic Adriana Skirt for a formal look.'
            ],
            [
                'name' => 'Tapasya Scarf',
                'category' => 'Scarf',
                'price' => 649000,
                'original_price' => null,
                'image' => 'tapasya-scarf.jpg',
                'description' => 'Intricately designed Tapasya Scarf.'
            ],
            [
                'name' => 'Peony Koko',
                'category' => 'Koko',
                'price' => 899500,
                'original_price' => 1799000,
                'image' => 'peony-koko.jpg',
                'description' => 'Peony Koko features subtle floral inspirations.'
            ],
            [
                'name' => 'Zenia Dress',
                'category' => 'Dress',
                'price' => 1449500,
                'original_price' => 2899000,
                'image' => 'zenia-dress.jpg',
                'description' => 'Premium Zenia Dress for special milestones.'
            ],
        ];

        foreach ($products as $prod) {
            Product::create([
                'category_id' => $categoryMap[$prod['category']],
                'name' => $prod['name'],
                'slug' => Str::slug($prod['name'] . '-' . Str::random(5)),
                'price' => $prod['price'],
                'original_price' => $prod['original_price'],
                'image' => $prod['image'],
                'description' => $prod['description'],
                'stock' => 10
            ]);
        }
    }
}
