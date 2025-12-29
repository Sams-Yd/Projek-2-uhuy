<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['name' => 'Alat Tulis', 'description' => 'Pulpen, pensil, dan alat tulis lainnya'],
            ['name' => 'Kertas', 'description' => 'Kertas tulis, kertas A4, dan berbagai jenis kertas'],
            ['name' => 'Buku', 'description' => 'Buku catatan, buku tulis, dan buku pelajaran'],
            ['name' => 'Penggaris & Alat Ukur', 'description' => 'Penggaris, busur derajat, dan alat pengukur lainnya'],
            ['name' => 'Cat & Kuas', 'description' => 'Cat, kuas, dan perlengkapan melukis'],
            ['name' => 'Tas & Tempat', 'description' => 'Tas sekolah, kotak pensil, dan tempat penyimpanan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

