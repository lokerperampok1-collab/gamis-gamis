<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::updateOrCreate(
            ['email' => 'purno@admin.com'],
            [
                'name' => 'Purno Admin',
                'password' => bcrypt('perampok'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Categories
        $categoriesData = json_decode('[{"id":1,"name":"Dress","slug":"dress"},{"id":2,"name":"Koko","slug":"koko"},{"id":3,"name":"Scarf","slug":"scarf"},{"id":4,"name":"Skirt","slug":"skirt"},{"id":5,"name":"Tunic","slug":"tunic"},{"id":6,"name":"Mukena","slug":"mukena"}]', true);

        foreach ($categoriesData as $cat) {
            Category::updateOrCreate(
                ['id' => $cat['id']],
                [
                    'name' => $cat['name'],
                    'slug' => $cat['slug'],
                ]
            );
        }

        // 3. Create Products
        $productsData = json_decode('[{"id":1,"category_id":1,"name":"Izzy Dress","slug":"izzy-dress-xbpww","description":"Exclusive and premium Izzy Dress with elegant detailing.","price":3599000,"stock":9,"image":"izzy-dress.jpg","original_price":null},{"id":2,"category_id":1,"name":"Rebekah Dress","slug":"rebekah-dress-5t9iu","description":"Modern syari design for a timeless appearance.","price":1739400,"stock":10,"image":"rebekah-dress.jpg","original_price":2899000},{"id":3,"category_id":1,"name":"Lavender Dress","slug":"lavender-dress-qjtk2","description":"Soft lavender tones combined with Ranti\'s signature quality.","price":2319200,"stock":10,"image":"lavender-dress.jpg","original_price":2899000},{"id":4,"category_id":2,"name":"Afif Koko","slug":"afif-koko-b3hn7","description":"A refined Koko for formal and spiritual occasions.","price":749500,"stock":10,"image":"afif-koko.jpg","original_price":1499000},{"id":5,"category_id":2,"name":"Felika Koko","slug":"felika-koko-ikwsj","description":"Casual yet structured Felika Koko for everyday comfort.","price":424500,"stock":10,"image":"felika-koko.jpg","original_price":849000},{"id":6,"category_id":2,"name":"Razza Koko","slug":"razza-koko-17bwg","description":"Dark tones for a bold, masculine Koko look.","price":399500,"stock":10,"image":"razza-koko.jpg","original_price":799000},{"id":7,"category_id":2,"name":"Damaris Koko","slug":"damaris-koko-48ocx","description":"Lightweight and stylish Damaris Koko.","price":424500,"stock":10,"image":"damaris-koko.jpg","original_price":849000},{"id":8,"category_id":1,"name":"Carmen Dress","slug":"carmen-dress-fcxwq","description":"Carmen Dress offers a bold statement in premium fabric.","price":1449500,"stock":10,"image":"carmen-dress.jpg","original_price":2899000},{"id":9,"category_id":3,"name":"Winter Scarf","slug":"winter-scarf-acmjd","description":"Soft and warm Winter Scarf for a cozy syari look.","price":299000,"stock":10,"image":"winter-scarf.jpg","original_price":null},{"id":10,"category_id":3,"name":"Rona Scarf","slug":"rona-scarf-n3oln","description":"Bright and colorful Rona Scarf to elevate your style.","price":649000,"stock":10,"image":"rona-scarf.jpg","original_price":null},{"id":11,"category_id":4,"name":"Karenia Skirt","slug":"karenia-skirt-ytb0u","description":"Graceful Karenia Skirt with a fluid silhouette.","price":374500,"stock":10,"image":"karenia-skirt.jpg","original_price":749000},{"id":12,"category_id":5,"name":"Eleena Tunic","slug":"eleena-tunic-uu0xe","description":"Modern Eleena Tunic perfect for daytime events.","price":499500,"stock":10,"image":"eleena-tunic.jpg","original_price":999000},{"id":13,"category_id":5,"name":"Reina Tunic","slug":"reina-tunic-vi2lc","description":"Versatile Reina Tunic in a premium finish.","price":549500,"stock":10,"image":"reina-tunic.jpg","original_price":1099000},{"id":14,"category_id":6,"name":"Mukena Khodijah Kombinasi","slug":"mukena-khodijah-kombinasi-wqnkv","description":"High-quality prayer set for ultimate comfort.","price":759000,"stock":10,"image":"mukena-khodijah.jpg","original_price":null},{"id":15,"category_id":1,"name":"Eshal Kids Dress","slug":"eshal-kids-dress-u8zde","description":"Adorable and comfortable Eshal Kids Dress.","price":359700,"stock":10,"image":"eshal-kids.jpg","original_price":1199000},{"id":16,"category_id":4,"name":"Satine Skirt","slug":"satine-skirt-ntrxn","description":"Luxurious silk-feel Satine Skirt.","price":349500,"stock":10,"image":"satine-skirt.jpg","original_price":699000},{"id":17,"category_id":4,"name":"Adriana Skirt","slug":"adriana-skirt-ieqdk","description":"Classic Adriana Skirt for a formal look.","price":374500,"stock":10,"image":"adriana-skirt.jpg","original_price":749000},{"id":18,"category_id":3,"name":"Tapasya Scarf","slug":"tapasya-scarf-9z1l2","description":"Intricately designed Tapasya Scarf.","price":649000,"stock":10,"image":"tapasya-scarf.jpg","original_price":null},{"id":19,"category_id":2,"name":"Peony Koko","slug":"peony-koko-vzlc1","description":"Peony Koko features subtle floral inspirations.","price":899500,"stock":10,"image":"peony-koko.jpg","original_price":1799000},{"id":20,"category_id":1,"name":"Zenia Dress","slug":"zenia-dress-zwt3q","description":"Premium Zenia Dress for special milestones.","price":1449500,"stock":10,"image":"zenia-dress.jpg","original_price":2899000}]', true);

        foreach ($productsData as $prod) {
            Product::updateOrCreate(
                ['id' => $prod['id']],
                [
                    'category_id' => $prod['category_id'],
                    'name' => $prod['name'],
                    'slug' => $prod['slug'],
                    'description' => $prod['description'],
                    'price' => $prod['price'],
                    'stock' => $prod['stock'],
                    'image' => $prod['image'],
                    'original_price' => $prod['original_price'],
                ]
            );
        }
    }
}
